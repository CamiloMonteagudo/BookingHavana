<?php
  global $Image, $ImgW, $ImgH;

  header('Content-type: application/json');

  if( empty($_POST["IdUser"])  ) ReturnError(10);
  if( empty($_POST["imgName"]) ) ReturnError(15);
  
  $idCasa  = $_POST["IdUser"];
  $imgName = $_POST["imgName"];
  
  session_start();
  if( empty($_SESSION["IdUser"]) || $idCasa != $_SESSION["IdUser"] ) 
    { 
    if( isset($idCasa) && !empty($_SESSION["Admin"]) ) 
      { $AutoLogueo = true; }
    else
      { ReturnError(11); }
    }
  
  $ImgInfo = $_FILES['Image'];
   
  if( $ImgInfo['error'] > 0) ReturnError( $ImgInfo['error'] );
  
  if( isset($_POST["foto"]) )
    {
    DelFiles( 'fotos/Casa'.$idCasa."*.jpg" );  
    
    $filePath = ChkDir('fotos/' ).$imgName;
  
    if( !move_uploaded_file( $ImgInfo['tmp_name'], $filePath) )
      ReturnError(5);
    }
  else 
    {
    LoadImage( $ImgInfo );
    
    ResizeImage( 640, 480, ChkDir('CasasG/'.$idCasa.'/').$imgName );   
    ResizeImage( 320, 240, ChkDir('CasasM/'.$idCasa.'/').$imgName );   
    ResizeImage( 120,  90, ChkDir('CasasP/'.$idCasa.'/').$imgName );   
    }

ReturnError(0);

// Chequea que el directorio 'sDir' exista, si no existe lo crea
function ChkDir( $sDir )
  {
  if( file_exists($sDir) || mkdir($sDir, 0777, true) ) return $sDir;
  ReturnError(9);  
  }

// Termina con el código de error especificado
function ReturnError( $nError )
  {
  echo '{"error":'.$nError.'}';  
  exit;
  }

// Carga una imagen desde un fichero
function LoadImage( $fileInfo )
  {
  global $Image, $ImgW, $ImgH;
  
  $fname = $fileInfo['tmp_name'];
   
  list($ImgW, $ImgH) = getimagesize($fname); 
  if( $ImgW==0 || $ImgH==0 ) ReturnError(14);
  
	$mime_type = "";
		
	if( isset($fileInfo['mime']) ) $mime_type = $fileInfo['mime'];
	if( isset($fileInfo['type']) ) $mime_type = $fileInfo['type'];
	
  switch( $mime_type )
    {
    case 'image/gif'  : $Image = ImageCreateFromGif($fname); break;
    case 'image/x-png':
    case 'image/png'  : $Image = ImageCreateFromPng($fname); break;
    default           : $Image = ImageCreateFromJpeg($fname); break;
    }
  }
  
// Redimensiona la imagen cargada y la guarda en el fichero dado
function ResizeImage( $ancho, $alto, $fname )
  {
  global $Image, $ImgW, $ImgH;

  $Aspect = ($ImgH/$ImgW);
  if( $Aspect>0.75 )
    {
    $h = $alto; $w = $h/$Aspect;      // Centra por la horizontal
    $y = 0;     $x = ($ancho-$w)/2;    
    }
  else
    {
    $w = $ancho; $h = $w*$Aspect;     // Centra por la vertical
    $x = 0;      $y = ($alto-$h)/2;   
    } 
     
 // die( "dst_x=".$x." dst_y=".$y." src_x=0 src_y=0 dst_w=".$w." dst_h=".$h." src_w=".$ImgW." src_h=".$ImgH );
  
  $ImgNew = imagecreatetruecolor( $ancho, $alto ); 
  
  //$blanco = imagecolorallocate($ImgNew, 255, 255, 255);
  //imagefilledrectangle($ImgNew, 0, 0, $ancho-1, $alto-1, $blanco);  
  
  imagecopyresampled( $ImgNew, $Image, $x, $y, 0, 0, $w, $h, $ImgW, $ImgH) ; 
  imagejpeg( $ImgNew, $fname, 60 ) ; 
  }
      
// Borra todos los ficheros que coinciden con el patron dado
function DelFiles( $patron )
  {
  foreach( glob( $patron ) as $nombre_fichero ) 
    {
    unlink( $nombre_fichero );  
    }
  }
      
?>

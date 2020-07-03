<?php
header('Content-type: text/plain');

if( empty($_POST["FData"]) ) die( '{"error":17}' );
if( empty($_POST["Ini"])   ) $Ini=0; else $Ini = $_POST["Ini"];
if( empty($_POST["Orden"]) ) $Orden=0; else $Orden = $_POST["Orden"];

$FData  = $_POST["FData"];
$Filter = json_decode($FData);

$From = ' FROM casas WHERE Activo>0 '; 
if( $Filter->ft[7] ) 
  {
  session_start();
  if( empty($_SESSION["IdUser"]) ) { die( '{"error":20}' ); }
    
  $From = ' FROM casasfavoritas WHERE Activo>0 AND IdUser='.$_SESSION["IdUser"].' '; 
  } 

$sFilt  = GetWhere( $Filter );
$sFilt .= GetOrden( $Orden, $Filter );
$sFilt .= GetRango( $Ini );

include 'OpenDb.php';   

$NRows = 0;
if( $Ini==0 )
  {
  $Sel = 'SELECT COUNT(*) AS NRows'.$From;
  $query = mysqli_query($myDB, $Sel.$sFilt) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  
  $Row = mysqli_fetch_assoc($query);
  $NRows = $Row["NRows"];
  
  mysqli_free_result($query);
  }

$Sel = 'SELECT Id, nImgs, 0 AS img, iNames, pProp, pLoc, pDesc, pPrecHab, pPrecAll, pNHab, pNPers, pNBanos, pNCamas, pPisc, pLab, pAire, pIndp, pRank'.$From;
$query = mysqli_query($myDB, $Sel.$sFilt) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Casas = array();
while( $Casa = mysqli_fetch_assoc($query) )
  {
  $Casas[] = $Casa;  
  }

mysqli_free_result($query);

//$sFilt = $NRows;
$ftJSON = json_encode( array("Msg"=>$sFilt) );
$csJSON = json_encode($Casas,JSON_NUMERIC_CHECK);

echo '{"nCasas":'.$NRows.', "Casas":'.$csJSON.', "error":0, "Msg":'.$ftJSON.'}';

mysqli_close($myDB);

//Obtiene la parte de la sentencia que filtra los datos
function GetWhere( $Filter )
  {
  $Sql  = FeaturesFilter( $Filter->ft );
  $Sql .= LocalidadFilter( $Filter );
  $Sql .= PreciosFilter( $Filter );
  $Sql .= HabitacionesFilter( $Filter );
  
  return $Sql;  
  }
  
//Filtra los datos por caracteristicas
function FeaturesFilter( $feats )
  {
  if( !isset($feats) ) return "";
  
  $where = "";
  if( isset($feats[0]) && $feats[0]>0 ) $where .= "AND pAire>0 ";  //A. Acondicionado
  if( isset($feats[1]) && $feats[1]>0 ) $where .= "AND pPisc>0 ";  //Piscina          
  if( isset($feats[2]) && $feats[2]>0 ) $where .= "AND pLab>0 ";   //Lavadora         
  if( isset($feats[3]) && $feats[3]>0 ) $where .= "AND pIndp>0 ";  //Independiente    
  if( isset($feats[4]) && $feats[4]>0 ) $where .= "AND pLujo>0 ";  //De lujo          
  if( isset($feats[5]) && $feats[5]>0 ) $where .= "AND pHotal>0 "; //Hostal           
  if( isset($feats[6]) && $feats[6]>0 ) $where .= "AND pPlaya>0 "; //En la playa      

  return $where;  
  }
  
//Filtra los datos por localidades
function LocalidadFilter( $Filter )
  {
  if( !empty($Filter->Loc) ) 
    {
    $Loc = $Filter->Loc;
    return 'AND pLoc="'.$Loc.'" ';
    }
  
  if( isset( $Filter->Prov )  ) 
    return 'AND pProv='.$Filter->Prov.' ';

  return '';  
  }
  
//Filtra los datos por precios
function PreciosFilter( $Filter )
  {
  $Field = PreciosField( $Filter );
    
  $where = "";
  if( !empty($Filter->precMin) ) $where  = 'AND '.$Field.'>='.$Filter->precMin.' ';
  if( !empty($Filter->precMax) && $Filter->precMax<150) $where .= 'AND '.$Field.'<='.$Filter->precMax.' ';

  if( !empty($where) ) $where .= 'AND '.$Field.'>0 ';
  return $where;  
  }
  
//Filtra los datos por el número de habitaciones
function HabitacionesFilter( $Filter )
  {
  $where = "";
  
  if( !empty($Filter->Casa) ) $where .= 'AND pPrecAll>0 ';
  if( !empty($Filter->PMes) ) 
    {
    if( !empty($Filter->Estd) ) $where .= 'AND pPrecEst>0 ';
    else                        $where .= 'AND pPrc1Mes>0 ';
    }
    
  $Min = $Filter->NHab->min;
  $Max = $Filter->NHab->max;
  
  if( $Min>0 )
    {
    if($Max<=0 || $Max>$Min) $where .= 'AND pNHab>='.$Min.' ';
    else                     $where .= 'AND pNHab='.$Min.' ';
    }
    
  if( $Max>$Min ) $where .= 'AND pNHab<='.$Max.' ';
  
  return $where;  
  }
  
//Define como se va a ordenar el resultado
function GetOrden( $Orden, $Filter )
  {
  $Field = PreciosField( $Filter );
    
  switch( $Orden ) 
    {
    case 0: return '';
    case 1: return 'ORDER BY pRank DESC ';
    case 3: return 'AND '.$Field.'>0 ORDER BY '.$Field.' DESC ';
    case 2: return 'AND '.$Field.'>0 ORDER BY '.$Field.' ';
    case 4: return 'ORDER BY pProp ';
    case 5: return 'ORDER BY pNHab DESC ';
    }  
    
  return "";  
  }
  
//Define el rango de filas que se van a retornar
function GetRango( $Ini )
  {
  return "LIMIT $Ini, 5 ";
  }
  
//Filtra los datos por precios
function PreciosField( $Filter )
  {
  $Field = 'pPrecHab';
  if( !empty($Filter->Casa) ) $Field = 'pPrecAll';
  if( !empty($Filter->PMes) ) $Field = 'pPrc1Mes';
  if( !empty($Filter->Estd) ) $Field = 'pPrecEst';
  
  return $Field;
  }
  


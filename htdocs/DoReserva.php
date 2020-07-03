<?php
header('Content-type: text/plain');

if( empty($_POST["Data"]) ) die( '{"error":17}' );
$sData  = $_POST["Data"];
$Data = json_decode( $sData );
  
include 'OpenDb.php';   

global $newUser, $IdUser, $opId, $opName, $opMail, $opNext;
FindOperator( $Data->User, $Data->Mail );
  
$Cmd = 'INSERT INTO reservaciones (  IdCasa     ,   IdOper  ,        User      ,      eMail       ,       fInic      ,      fFin        ,      nPers     ,      nMenores     ,     nHab     ,      Coments       )
                            VALUES ('.$Data->Id.', '.$opId.', "'.$Data->User.'", "'.$Data->Mail.'", "'.$Data->FIni.'", "'.$Data->FFin.'", '.$Data->Pers.', '.$Data->Menores.', '.$Data->Hab.', "'.$Data->Coments.'")';
                            
mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

echo '{"error":0}';

SendEmails( $Data );

if( $opNext )
  {
  $Cmd = "UPDATE usuarios SET Operdor=".$opId." WHERE Id=".$IdUser;
  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  
  if( !NextOperator($opId) )
    NextOperator(1);
  }

// Busca el operador que atiende la reserva
function FindOperator( $user, $mail )
  {
  global $myDB, $newUser, $IdUser, $opId, $opName, $opMail, $opNext;
  
  $Sel   = "SELECT Id, Propietario, Operdor FROM usuarios WHERE Nombre='".$user."' AND Correo='".$mail."'";
  $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  $Row   = mysqli_fetch_assoc($query);
  mysqli_free_result($query);
  
  if( $Row )
    {
    $IdUser  = $Row["Id"];
    $opId    = $Row["Operdor"];
    $newUser = false;
    }
  else
    {
    $Cmd = "INSERT INTO usuarios (Correo, Nombre) VALUES ('".$mail."', '".$user."')";
    mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
    
    $IdUser  = mysqli_insert_id( $myDB );
    $opId    = 1;
    $newUser = true;
    }
  
  while( true )
    {
    $Sel = 'SELECT Nombre, Mail, OpId FROM operadores WHERE Id='.$opId;  
    $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
    $Row = mysqli_fetch_assoc($query);
    mysqli_free_result($query);
    
    if( $Row )
      {
      $opName = $Row["Nombre"];
      $opMail = $Row["Mail"];
      
      if( $opId==1 ) { $opNext=true; $opId=$Row["OpId"]; }
      else             $opNext=false; 
      
      return;
      }
    else
      $opId=1; 
    }
  } 

// Pone el operador para la proxima reserva
function NextOperator( $opId )
  {
  global $myDB;
  
  $Sel = 'SELECT * FROM operadores WHERE Id>'.$opId.' GROUP BY Id';
  $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  $Row   = mysqli_fetch_assoc($query);
  mysqli_free_result($query);
  
  if( !$Row ) return false; 

  $Cmd = 'UPDATE operadores SET Nombre="'.$Row["Nombre"].'", Mail="'.$Row["Mail"].'", OpId='.$Row["Id"].' WHERE Id=1';
  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

  return true;
  }
  
// Manda correos al usuario, al operador y al administrador
function SendEmails( $Data )
  {
  include 'SendMail.php';   
  include 'Links.php';   
  
  global $myDB, $newUser, $IdUser, $opId, $opName, $opMail;
  
  $Datos = array( '{Name}'    =>$Data->User,    '{Correo}' =>$Data->Mail,    '{CasaName}' =>$Data->pProp, 
                  '{FIni}'    =>$Data->FIni,    '{FFin}'   =>$Data->FFin,    '{NPers}'    =>$Data->Pers, 
                  '{NMenores}'=>$Data->Menores, '{OpName}' =>$opName,        '{OpCorreo}' =>$opMail,     
                  '{NHab}'    =>$Data->Hab,     '{Coments}'=>$Data->Coments, '{URL}'=>GetCasaLnk( $Data->Id, $Data->pLoc, $Data->pProp, "" ) );
                  
  SendMail( $Data->Mail, $MailReservaToUser, $Datos, $opMail );
   
  $Sel = 'SELECT * FROM usercasa WHERE Id='.$Data->Id;
  $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  $Row   = mysqli_fetch_assoc($query);
  mysqli_free_result($query);
  
  $Datos['{Telef}'] = $Row["Telefono"];
  if( !empty($Row["MasContacto"]) ) $Datos['{Telef}'] .= '  '.$Row["MasContacto"];
  
  $Datos['{Dir}']   = $Row["pDir"];
  
  $Precio ='';
  if( $Row["pPrecAll"]>0 ) $Precio .='Casa '           .$Row["pPrecAll"].' CUC  ';
  if( $Row["pPrecHab"]>0 ) $Precio .='Habitación '     .$Row["pPrecHab"].' CUC  ';
  if( $Row["pPrc1Mes"]>0 ) $Precio .='Mensual '        .$Row["pPrc1Mes"].' CUC  ';
  if( $Row["pPrecEst"]>0 ) $Precio .='Para estudiante '.$Row["pPrecEst"].' CUC  ';
  $Datos['{Precio}']  = $Precio;
       
  $mail = 'bookinghavana@gmail.com';
  $Datos['{Copia}'] = "PD:Copia para el administrador.";
  SendMail( $mail, $MailReservaToAdmin, $Datos );
  
  $Datos['{Copia}'] = "\r\n\r\nPD:Copia para el tur operador.";
  SendMail( $opMail, $MailReservaToAdmin, $Datos );
  
  if( $newUser )
    {
    $Datos = array( '{Name}'=>$Data->User, '{Correo}'=>$Data->Mail, '{UserId}'=>$IdUser );
    SendMail( $Data->Mail, $MailAutoNewUser, $Datos );
    }
    
  }  

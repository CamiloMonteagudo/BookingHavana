<?php
header('Content-type: text/plain');

if( empty($_POST["mail"]) ) die( '{"error":17}' );
if( empty($_POST["name"]) ) die( '{"error":17}' );
if( empty($_POST["pwd1"]) ) die( '{"error":17}' );
if( empty($_POST["Id"])   ) die( '{"error":17}' );

$Id = $_POST["Id"];

session_start();
if( empty($_SESSION["IdUser"]) || $Id != $_SESSION["IdUser"] ) 
  { 
  if( is_int($Id) && !empty($_SESSION["Admin"]) ) 
    { $AutoLogueo = true; }
  else
    { die( '{"error":11}' ); }
  }

include 'OpenDb.php';   

$mail = mysqli_real_escape_string( $myDB, $_POST["mail"] );
$name = mysqli_real_escape_string( $myDB, $_POST["name"] );
$pwd1 = mysqli_real_escape_string( $myDB, $_POST["pwd1"] );

$Prop = 0;
$Telef = "";
if( !empty($_POST["telef"])  ) 
  {
  $Prop = 1;
  $Telef = mysqli_real_escape_string( $myDB, $_POST["telef"] );
  }

$Sel   = "SELECT Id FROM usuarios WHERE Nombre='".$name."' AND Correo='".$mail."' AND Id<>".$Id;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$NRec  = mysqli_num_rows($query);
mysqli_free_result($query);

if( $NRec>0 ) die( '{"error":0, "duplicado":1}' );

$Sel   = "SELECT Correo FROM usuarios WHERE Id=".$Id;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$User   = mysqli_fetch_assoc($query);
mysqli_free_result($query);

$ChgCorreo = ( $User["Correo"] != $_POST["mail"] );
$Confirm = $ChgCorreo? ", Confirmado=0" : "";
 
$Cmd = "UPDATE usuarios SET Nombre='".$name."', Correo='".$mail."', PassWord='".$pwd1."'".$Confirm.", Propietario=".$Prop.", Telefono='".$Telef."' WHERE Id=".$Id;
if( mysqli_query( $myDB, $Cmd ) )
  {
  $ret = '{"error":0, "update":1';
  if( $ChgCorreo )
    {
    include 'SendMail.php';   
    
    $Datos = array( '{Name}'=>$name, '{UserInfo}'=>$Id );
    SendMail( $mail, $MailUserValidate, $Datos );
    
    $ret .= ', "validate":1';  
    }
    
  $ret .= '}';  
  }
else
  {
  $ret = '{"error":18, "msg":"'.mysqli_error($myDB).'"}';
  }  

mysqli_close($myDB);

echo $ret;  


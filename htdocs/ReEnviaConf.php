<?php
header('Content-type: text/plain');

if( empty($_POST["IdUser"]) ) die( '{"error":17}' );
$IdUser = $_POST["IdUser"];

include 'SendMail.php';   
include 'OpenDb.php';   

$Sel   = "SELECT Nombre, Correo FROM usuarios WHERE Id=".$IdUser;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$User  = mysqli_fetch_assoc($query);
mysqli_free_result($query);
  
$Datos = array( '{Name}'=>$User["Nombre"], '{UserInfo}'=>$IdUser );
SendMail( $User["Correo"], $MailUserValidate, $Datos );
  
mysqli_close($myDB);

echo '{"error":0}';  

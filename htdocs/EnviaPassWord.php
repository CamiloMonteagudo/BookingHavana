<?php
header('Content-type: text/plain');

include 'SendMail.php';   
include 'OpenDb.php';   

if( isset($_POST["Where"]) ) $sWhere = $_POST["Where"]; 
else                         die( '{"error":17}' );

$Sel = "SELECT Id, Nombre, Correo, PassWord FROM usuarios WHERE ";
$Users = mysqli_query($myDB, $Sel.$sWhere) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

while( $User = mysqli_fetch_assoc($Users) )
  {
  $Datos = array( '{Name}'=>$User["Nombre"], '{PassWord}'=>$User["PassWord"] );
  
  SendMail( $User["Correo"], $MailSendPassword, $Datos );
  }
  
mysqli_free_result($Users);
mysqli_close($myDB);

echo '{"error":0}';  

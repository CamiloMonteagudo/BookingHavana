<?php
header('Content-type: text/plain');

if( empty($_POST["mail"]) ) die( '{"error":17}' );
if( empty($_POST["name"])  ) die( '{"error":17}' );
if( empty($_POST["pwd1"])  ) die( '{"error":17}' );

session_start();

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

$Cmd = "SELECT Id FROM usuarios WHERE Nombre='".$name."'";
 
$query = mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$ret = "";
if( mysqli_num_rows($query) > 0 )
  {  
  $ret = '{"error":0, "exist":1}';  
  }
else
  {  
  $Cmd = 'INSERT INTO usuarios (Nombre, Correo, PassWord, Confirmado, Propietario, Telefono)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                    VALUES ("'.$name.'", "'.$mail.'", "'.$pwd1.'", 0, '.$Prop.', "'.$Telef.'")';

  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  $ret = '{"error":0, "nuevo":1}';  
  $IdUser = mysqli_insert_id( $myDB );
  
  include 'SendMail.php';   
  
  $Datos = array( '{Name}'=>$name, '{UserInfo}'=>$IdUser );
  SendMail( $mail, $MailUserValidate, $Datos );
  }  
  
mysqli_free_result($query);
mysqli_close($myDB);

echo $ret;  


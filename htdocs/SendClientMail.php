<?php
header('Content-type: text/plain');

if( empty($_POST["msgBody"]) ) die( '{"error":17}' );
$msgBody = $_POST["msgBody"];

if( empty($_POST["Mail"]) ) $Mail = 'bookinghavana@gmail.com';
else                        $Mail = $_POST["Mail"];

if( empty($_POST["Mail"]) ) $Suject = "Correo de un cliente";
else                        $Suject = "Recomendación de un amigo";
    
$Header = "From: bookinghavana@gmail.com\r\n".
          "Reply-To: bookinghavana@gmail.com\r\n".
          "X-Mailer: PHP/" . phpversion();
  
mail($Mail, $Suject, $msgBody, $Header);

if( !empty($_POST["Mail"]) ) 
  mail('bookinghavana@gmail.com', $Suject, $msgBody, $Header);

echo '{"error":0}';  

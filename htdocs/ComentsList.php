<?php
header('Content-type: text/plain');

if( empty($_POST["IdCasa"]) ) die( '{"error":17}' );

$IdCasa  = $_POST["IdCasa"];

include 'OpenDb.php';   

$Sel = "SELECT pProp FROM casas WHERE Id=".$IdCasa;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$Row = mysqli_fetch_assoc($query);

if( $Row ) $CasaName = $Row["pProp"];
else       die( '{"error":21}' );

mysqli_free_result($query);

if( !empty($_POST["sText"]) ) 
  {
  $sText = mysqli_real_escape_string( $myDB, $_POST["sText"]);
  
  if( empty($_POST["sUser"]) ) $sUser="Anonimo"; 
  else                         $sUser=mysqli_real_escape_string( $myDB, $_POST["sUser"]);
  
  $Cmd = "INSERT INTO comentarios (IdCasa, UserName, Texto) VALUES (".$IdCasa.", '".$sUser."', '".$sText."')";  
  $query = mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  
  $Suject = "Comentarario sobre la casa: ".$CasaName.' ('.$IdCasa.')';
  $Header = "From: bookinghavana@gmail.com\r\n".
            "Reply-To: bookinghavana@gmail.com\r\n".
            "X-Mailer: PHP/" . phpversion();
  $msgBody = "Usuario : ".$sUser."\r\n\r\n".$_POST["sText"];
  
  mail('bookinghavana@gmail.com', $Suject, $msgBody, $Header);
  }

$NRows = 0;
$Sel = "SELECT COUNT(*) AS NRows FROM comentarios WHERE IdCasa=".$IdCasa;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Row = mysqli_fetch_assoc($query);
$NRows = $Row["NRows"];

mysqli_free_result($query);

if( $NRows>20 ) $lim = " LIMIT ".($NRows-20).", 20 ";
else            $lim = "";

$Sel = "SELECT * FROM comentarios WHERE IdCasa=".$IdCasa.$lim;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Coments = array();
while( $Cmt = mysqli_fetch_assoc($query) )
  { 
  $Cmt["Texto"] = nl2br( $Cmt["Texto"] );
  $Coments[] = $Cmt; 
  }

mysqli_free_result($query);

mysqli_close($myDB);

$cmJSON = json_encode($Coments,JSON_NUMERIC_CHECK);

echo '{"Count":'.$NRows.', "Name":"'.$CasaName.'", "Coments":'.$cmJSON.', "error":0}';

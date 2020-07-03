<?php
header('Content-type: text/plain');

if( empty($_POST["UserId"]) ) die( '{"error":17}' );
if( empty($_POST["CasaId"]) ) die( '{"error":17}' );

$UserId = $_POST["UserId"];
$CasaId = $_POST["CasaId"];

include 'OpenDb.php';   

$Sel   = "SELECT * FROM favoritas WHERE IdUser=".$UserId." AND IdCasa=".$CasaId;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

if( mysqli_num_rows($query)>0 )
  {
  $Cmd = "DELETE FROM favoritas WHERE IdUser=".$UserId." AND IdCasa=".$CasaId;
  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  echo '{"error":0, "On":0}';  
  }
else
  {
  $Cmd = "INSERT INTO bookinghavana.favoritas (IdUser, IdCasa) VALUES (".$UserId.", ".$CasaId.")";
  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  echo '{"error":0, "On":1}';  
  }

mysqli_free_result($query);
  
mysqli_close($myDB);



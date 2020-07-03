<?php
header('Content-type: text/plain');

if( empty($_POST["UserId"]) ) die( '{"error":17}' );
if( empty($_POST["CasaId"]) ) die( '{"error":17}' );

$UserId = $_POST["UserId"];
$CasaId = $_POST["CasaId"];

include 'OpenDb.php';   

$Sel   = "SELECT * FROM favoritas WHERE IdUser=".$UserId." AND IdCasa=".$CasaId;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

if( mysqli_num_rows($query)>0 ) echo '{"error":0, "On":1}';  
else                            echo '{"error":0, "On":0}';  

mysqli_free_result($query);
  
mysqli_close($myDB);



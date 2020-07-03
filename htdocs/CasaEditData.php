<?php
header('Content-type: text/plain');

if( empty($_POST["IdCasa"])  ) die( '{"error":10}' );

$IdCasa  = $_POST["IdCasa"];

session_start();
if( empty($_SESSION["IdUser"]) || $IdCasa != $_SESSION["IdUser"] ) 
  die( '{"error":11}' );
  
include 'OpenDb.php';   

$Cmd1 = 'SELECT * FROM casas WHERE Id='.$IdCasa;
 
$query = mysqli_query($myDB, $Cmd1) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$NRows =  mysqli_num_rows($query);

if( $NRows<=0 )
  {
  mysqli_free_result($query);
  
  $Cmd2 = 'INSERT INTO casas ( Id ) VALUES ( '.$IdCasa.')';
  mysqli_query($myDB, $Cmd2) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  
  $Cmd1 = 'SELECT * FROM casas WHERE Id='.$IdCasa;
  $query = mysqli_query($myDB, $Cmd1) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  }

$Casa = mysqli_fetch_assoc($query);
mysqli_free_result($query);

$Cmd = 'SELECT * FROM habitaciones WHERE Id='.$IdCasa;  

$query = mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Habts = array();
$Num = 0;
while( $row = mysqli_fetch_assoc($query) ) 
  {
  $Habts[$Num] = $row;  
  ++$Num;  
  }

if( $Num==0 ) $Num=1;

$Casa["Habits"] = $Habts;
$Casa["pNHab"]  = $Num;

mysqli_free_result($query);

$Casa["error"] = 0;
$Data = json_encode($Casa,JSON_NUMERIC_CHECK);

mysqli_close($myDB);

echo $Data;

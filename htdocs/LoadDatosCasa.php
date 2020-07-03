<?php
session_start();

global $Data;
if( isset($IdCasa) && !empty($_SESSION["Admin"]) ) 
  { $AutoLogueo = true; }
  
if( !isset($AutoLogueo) && isset($Edit) )
  {
  if( empty($_SESSION["IdUser"]) || $IdCasa != $_SESSION["IdUser"] ) 
    { $Data='{"error":11}'; return; }
  }
  
include 'OpenDb.php';   

$Cmd1 = 'SELECT * FROM casas WHERE Id='.$IdCasa;
if( !isset($Edit) )
  $Cmd1 .= ' AND Activo>0';
 
if( !$query = mysqli_query($myDB, $Cmd1) ) {SetError( 18, true ); return;}
  
$NRows =  mysqli_num_rows($query);

if( $NRows<=0 )
  {
  if( isset($Edit) )
    {
    mysqli_free_result($query);
    
    $Cmd2 = 'INSERT INTO casas ( Id ) VALUES ( '.$IdCasa.')';
    if( !mysqli_query($myDB, $Cmd2) ) {SetError( 18, true ); return;}
    
    $Cmd1 = 'SELECT * FROM casas WHERE Id='.$IdCasa;
    if( !$query = mysqli_query($myDB, $Cmd1) ) {SetError( 18, true ); return;}
    }
  else
    {SetError( 19, false ); return;} 
  }

$Casa = mysqli_fetch_assoc($query);
mysqli_free_result($query);

$Cmd = 'SELECT * FROM habitaciones WHERE Id='.$IdCasa;  

if( !$query = mysqli_query($myDB, $Cmd) ) {SetError( 18, true ); return;}

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

// Termina con el código de error especificado
function SetError( $nError, $lstErr )
  {
  global $myDB, $Data;  
  $Data = '{"error":'.$nError;
  
  if( $lstErr )
    $Data .= ', "msg":"'.mysqli_error($myDB).'"';  
  
  $Data .= '}';  
  
  mysqli_close($myDB);
  }


<?php
header('Content-type: text/plain');

if( empty($_POST["IdCasa"])  ) die( '{"error":17}' );
if( !isset($_POST["Puntos"]) ) die( '{"error":17}' );

$IdCasa  = $_POST["IdCasa"];
$Puntos  = $_POST["Puntos"];

if( $Puntos<0 ) $Puntos = 0;
if( $Puntos<0 ) $Puntos = 5;

include 'OpenDb.php';   

$Sel   = 'SELECT Puntos FROM casas WHERE Id='.$IdCasa;
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$Casa  = mysqli_fetch_assoc($query);
mysqli_free_result($query);

if( !$Casa ) die( '{"error":21}' );

$Datos = explode( ",", $Casa["Puntos"] );
if( count( $Datos ) < 6 ) $Datos = array(0,0,0,0,0,0);

$Datos[ $Puntos ] += 1;
$NewDatos = implode(',', $Datos);

$Suma=0; $Num=0;
for( $i=0; $i<6; ++$i ) 
  {
  $n = $Datos[$i];
  $Num  += $n;
  $Suma += $i*$n;
  }
  
$Prom = $Suma/$Num;

$Cmd = "UPDATE casas SET pRank=".$Prom.", Puntos='".$NewDatos."' WHERE Id=".$IdCasa;
mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

mysqli_close($myDB);

echo '{"error":0, "Rank":'.number_format($Prom,2).', "Puntos":"'.$NewDatos.'"}';

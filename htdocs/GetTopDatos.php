<?php
header('Content-type: text/plain');

include 'OpenDb.php';   

$Sel = 'SELECT * FROM tops_casas';
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$TopCasas = mysqli_fetch_assoc($query);

mysqli_free_result($query);

$Casas = array(); 
for( $i=1; $i<=6; ++$i )
  {
  $Id = $TopCasas['Casa'.$i]; 
  $Sel = 'SELECT Id, iNames, pProp, pLoc, pPrecHab, pPrecAll, pNHab, pNPers, pNBanos, pNCamas, pPisc, pLab, pAire, pIndp, pRank FROM casas WHERE Id='.$Id;
  $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

  $Casa = mysqli_fetch_assoc($query);
  $Casas[] = $Casa;  

  mysqli_free_result($query);
  }

$Sel = 'SELECT Name, nCasas FROM tops_destinos';
$query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Destinos = '[';
while( $Dest = mysqli_fetch_assoc($query) )
  {
  if( strlen( $Destinos )>1 ) $Destinos .= ', ';
    
  $Destinos .= json_encode($Dest,JSON_NUMERIC_CHECK);  
  }
$Destinos .= ']';

mysqli_free_result($query);

$csJSON = json_encode($Casas,   JSON_NUMERIC_CHECK);

echo '{"Destinos":'.$Destinos.', "Casas":'.$csJSON.', "error":0 }';
//echo '{"Destinos":'.$dtJSON.', "Casas":'.$csJSON.', "error":0 }';

mysqli_close($myDB);

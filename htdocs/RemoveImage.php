<?php
  header('Content-type: text/plain');

  if( empty($_POST["IdUser"])  ) die( '{"error":10}' );
  if( empty($_POST["imgName"]) ) die( '{"error":15}' );
  
  $idCasa  = $_POST["IdUser"];
  $imgName = $_POST["imgName"];
  
  session_start();
//  if( empty($_SESSION["IdUser"]) || $idCasa != $_SESSION["IdUser"] ) 
//    die( '{"error":11}' );

  $ImgG = str_replace( "CasasP", "CasasG", $imgName);
  $ImgM = str_replace( "CasasP", "CasasM", $imgName);

  if( file_exists($ImgG)    ) unlink( $ImgG );
  if( file_exists($ImgM)    ) unlink( $ImgM );
  if( file_exists($imgName) ) unlink( $imgName );

  die( '{"error":0}' );  
?>

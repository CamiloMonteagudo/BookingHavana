<?php
header('Content-type: text/plain');

session_start();

if( isset($_SESSION["IdUser"]) && $_SESSION["IdUser"]==1 )
  unset( $_SESSION["Admin"] );
  
unset( $_SESSION["IdUser"] );

die( '{"error":0}' );  

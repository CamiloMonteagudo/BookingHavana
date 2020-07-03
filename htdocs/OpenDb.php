<?php
  global $myDB;

  $myDB = mysqli_connect("localhost", "root", "", "bookinghavana");

  if( mysqli_connect_errno()) 
    die( '{"error":12}' );  

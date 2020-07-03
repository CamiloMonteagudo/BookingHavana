<?php
header('Content-type: text/plain');

session_start();
include 'OpenDb.php';   

if( isset($_POST["pwd"]) ) $pwd = mysqli_real_escape_string( $myDB, $_POST["pwd"] ); 
else                       die( '{"error":17}' );

if( !empty($_POST["user"]) ) $user = mysqli_real_escape_string( $myDB, $_POST["user"] );
if( !empty($_POST["mail"]) ) $mail = mysqli_real_escape_string( $myDB, $_POST["mail"] );

if( !isset($user) && !isset($mail) ) die( '{"error":17}' );

if( isset($user) && isset($mail) ) $sWhere = "Nombre='".$user."' AND Correo='".$mail."'";
else if( isset($user) )            $sWhere = "Nombre='".$user."'";
else                               $sWhere = "Correo='".$mail."'";

if( empty($_SESSION["Admin"])  )   $sPass = " AND PassWord='".$pwd."'";
else                               $sPass = ""; 
 
$Sel = "SELECT Id, Nombre, Correo, Confirmado, Telefono, Propietario, nLogin FROM usuarios WHERE ";
$Users = mysqli_query($myDB, $Sel.$sWhere.$sPass) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$NRec  = mysqli_num_rows($Users);
$User  = mysqli_fetch_assoc($Users);
mysqli_free_result($Users);

$ret = "";
if( !$User )
  {
  $Users = mysqli_query($myDB, $Sel.$sWhere);
  $User  = mysqli_fetch_assoc($Users);
  mysqli_free_result($Users);
  
  if( $User ) $ret = '{"error":0, "login":0, "where":"'.$sWhere.'"}';
  else        $ret = '{"error":0, "login":0}';
  }
else
  {
  if( $NRec == 1 )  
    {
    $Id = $User["Id"];
    if( $User["Confirmado"] )
      {
      $User["error"] = 0;
      $User["login"] = 1;
      
      $Cmd2 = "SELECT pProp, pLoc FROM casas WHERE Id = ".$Id;
      $Casas = mysqli_query($myDB, $Cmd2) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
      if( mysqli_num_rows($Casas) > 0 )
        {
        $Casa = mysqli_fetch_assoc($Casas);
        mysqli_free_result($Casas);
          
        $User["casa"] = $Casa["pProp"];
        $User["loc" ] = $Casa["pLoc"];
        }
        
      $_SESSION["IdUser"] = $Id;
      
      $ret = json_encode($User);
      if( $Id==1 ) $_SESSION["Admin"] = true;
      
      $Cmd2 = "UPDATE usuarios SET nLogin=". ($User["nLogin"]+1) ." WHERE Id = ".$Id;
      mysqli_query($myDB, $Cmd2) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
      }
    else { $ret = '{"error":0, "login":0, "Chk":1, "Id":'.$Id.'}'; }
    }
  else
    {
    $ret = '{"error":0, "login":0, "NRec":'.$NRec.'}';
    }  
  }  
  
mysqli_close($myDB);

echo $ret;  

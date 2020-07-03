<?php
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']."/");

if( empty($_GET["User"])  ) 
  { $Msg = "No se suministro información sobre el usuario a validar"; }
else
  {
  $IdUser = $_GET["User"];
  $Cmd = 'UPDATE usuarios SET Confirmado = 1 WHERE Id = '.$IdUser;

  include 'OpenDb.php';   
  
  mysqli_query($myDB, $Cmd);
  $nRows = mysqli_affected_rows($myDB);
  if( $nRows>0 )
    { 
    $Msg = "El usuario se activo satisfactoriamente y esta listo para su usar."; 
    NotifyNewUser( $IdUser );
    }
  else if( $nRows<0 )
    {
    $Msg = "Error en la activación: ".mysqli_error($myDB); 
    }
  else 
    {
    $Msg = "No se encontro ningún usuario para activar."; 
    }
  
  mysqli_close($myDB);
  }
  
// Notifica al usuario y al administrador del sitio que se registro un usuario nuevo
function NotifyNewUser( $IdUser )
  {
  include 'SendMail.php';   
  
  $Cmd = "SELECT Nombre, Correo, PassWord, Propietario, Telefono FROM usuarios WHERE Id = ".$IdUser;
   
  global $myDB;
  $query = mysqli_query($myDB, $Cmd);
  if( mysqli_num_rows($query) > 0 )
    {
    $User = mysqli_fetch_assoc($query);
    
    $mail  = $User["Correo"];
    $Datos = array( '{Name}'=>$User["Nombre"], '{PassWord}'=>$User["PassWord"] );
    SendMail( $mail, $MailUserValidated, $Datos );
    
    $mail = 'bookinghavana@gmail.com';
    $Datos['{IdUser}'] = $IdUser;
    $Datos['{Correo}'] = $User["Correo"];
    $Datos['{Telef}'] = $User["Telefono"];
    
    $Temp = ($User["Propietario"])? $MailNewPropietario : $MailNewNormalUser;
    SendMail( $mail, $Temp, $Datos );
    }
    
  mysqli_free_result($query);
  }  
?>

<!doctype html>
<html>
<head>
<base href="<?=SITE_URL?>">
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<title>Validación de usuario</title>

<link href="css/BookingHav.css" rel="stylesheet" type="text/css">

</head>

<body>
<!--------------------------------------- Encabezamiento ----------------------------------------->
<div class="header"> 
  <a href="index.html"><img class="logo" src="images/LogoBH.svg" alt="logo"/></a>
  <div class="menu-btn"><img src="images/menu.svg" alt="menu"/></div>
  <div class="menu"> 
    <div class="item"> Inicio </div>
    <div class="item"> <img class="icon_M" src="images/login.svg" alt="" /><span id="User"></span></div>
  </div>
</div>
    
<!------------------------------ Zona para mostrar información  ------------------------------->

<div id="frmCasas" style="min-height:20px;">
  <div class="UpSep">
    <h2 class="SubTitle">Activación de usuario</h2>
      <p><?= $Msg?></p>   
  </div>
  
  <div class="UpSep"></div>
</div>

<!------------------------------------------ Footer ---------------------------------------------->
<div id="PageFooter">
  <div class="content">
    <div class="block contacto">
      <div class="Title">Nosotros</div>
      <div class="text">
        <div><img src="images/GrupoBH.jpg" alt="" style="width:100%" /> </div>
      </div>
    </div>
      
    <div class="block correo">
      <div class="Title"> Booking Havana </div>
      <div> Agencia gestora de alojamiento para casas particulares de alquiler en Cuba. </div>
      <br/>
      <div class="text">Dirección:</div>
      <div class="text">Calle 13 # 1054, entre 12 y 14</div>
      <div class="text">Vedado, La Habana, Cuba</div>
      <br/>
      <div class="text">Cel: +53 53465756 </div>
      <div class="text gmail"><a href=""><img src="images/Correo.png" alt=""/>Alex@bookinghavana.com </a></div>
    </div>
  
    <div class="block Pages">
      <div class="Title"> Páginas </div>
      <div class="text">
        <div><a href="politica-de-privacidad.php"> • Política de Privacidad.</a></div>
        <div><a href="terminos-y-condiciones.php"> • Términos y condiciones</a></div>
        <div><a href="javascript:EditCasa()"> • <span id="lnkEdProp">Inscribir</span> propiedad</a></div>
        <div><a href="enlaces-de-interes.php"> • Enlaces de interés</a></div>
        <div><a href="acerca-de-nosotros.php"> • Acerca de nosotros</a></div>
      </div>
    </div>
  </div>  

<div class="rigths">© Booking Havana 2015 All rights reserved </div>

 </div>  

<!------------------------------------------------------------------------------------------------>
<!--  Segmentos de manejo dinamico                                                             --->
<!------------------------------------------------------------------------------------------------>
<div id="HidedBoxs" style="display:none">

<!-- Cuadro para loguearse o crear usuario nuevo -->
<div id="BoxUser" class="BoxFloat">
  <div id="LogIn" >
    <div><input class="LineInput" type="text"     placeholder="Usuario o Correo"/></div>
    <div><input class="LineInput" type="password" placeholder="Contraseñas"/></div>
    <div class="MsgError" ></div>
    <div class="btnRight">Entrar</div>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="NewUser" >
    <div><input class="LineInput" type="text"     placeholder="Correo electronico"/></div>
    <div><input class="LineInput" type="text"     placeholder="Usuario"/></div>
    <div><input class="LineInput" type="password" placeholder="Contraseñas"/></div>
    <div><input class="LineInput" type="password" placeholder="Confirmar contraseñas"/></div>
    <div><input class="isProp"    type="checkbox"/><label for="isProp">Propietario</label></div>
    <div><input class="LineInput Telef" type="text"     placeholder="Teléfono"/></div>
    <div class="MsgError" ></div>
    <div class="btnRight">Crear</div>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="EditUser" >
    <div><input class="LineInput" type="text"     placeholder="Correo electronico"/></div>
    <div><input class="LineInput" type="text"     placeholder="Usuario"/></div>
    <div><input class="LineInput" type="password" placeholder="Contraseñas"/></div>
    <div><input class="LineInput" type="password" placeholder="Confirmar contraseñas"/></div>
    <div><input class="isProp"    type="checkbox"/><label for="isProp">Propietario</label></div>
    <div><input class="LineInput Telef" type="text"     placeholder="Teléfono"/></div>
    <div class="MsgError" ></div>
    <div class="btnRight">Modificar</div>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="MsgActive" >
    <p>Hemos re-enviado el correo de validación del usuario.</p>
    <p>Revise su buzón, y siga el enlace para completar el proceso.</p>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="MsgPassWord" >
    <p>Le hemos enviado la contraseñas, a la direccion de correo electronico asociada al nombre de usuario.</p>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="MsgUpdate" >
    <p>Los datos del usuario actual, fueron actualizados satifactoriamente.</p>
    <p>Para que los cambios, tengan efecto hay que salir y volver a entrar</p>
    <div class="btnLeft">&lt;&lt;</div>
  </div>
  
  <div id="mnuUser" class="list">
    <div class="item-pu" cmd="1">Salir</div>
    <div class="item-pu" cmd="2">Entrar como Usuario</div>
    <div class="item-pu" cmd="3">Crear nuevo Usuario</div>
    <div class="item-pu" cmd="4">Editar datos de Usuario</div>
    <div class="item-pu" cmd="5">Inscribir propiedad</div>
  </div>
  
</div>

</div>

<!------------------------------------------------------------------------------------------------>
<!-- CODIGO JAVASCRIPT  -->
<!------------------------------------------------------------------------------------------------>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/BookingHav.js"></script>

<script type="text/javascript">
var Menu;

$(function() 
  {
  Menu = new MainMenu(); 
  });

</script> 

</body>
</html>

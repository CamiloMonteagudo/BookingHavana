<?php
if( !defined('SITE_URL') )
  define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']."/");

$MailUserValidate = array(
'Title' => "Validación del correo",
'Msg' => "{Name}, bienvenido como nuevo usuario de BookingHavana \r\n\r\nPara completar el proceso de validación del usuario, usted debe seguir el enlace de abajo dando doble click, o copiandolo en la barra de direcciones de su navegador. \r\n\r\n".SITE_URL."validate_email.php?User={UserInfo} \r\n\r\nGracias \r\n\r\n      Equipo de trabajo de BookingHavana."
);

$MailUserValidated = array(
'Title' => "Usuario validado",
'Msg' => "{Name}, bienvenido a BookingHavana \r\n\r\nEl proceso de validación termino satisfactorimente. Para registrase a nuetro sitio web use los siguientes datos:\r\n\r\nUsuario = {Name} \r\nContraseñas = {PassWord} \r\n\r\nGracias \r\n\r\n      Equipo de trabajo de BookingHavana."
);

$MailNewNormalUser = array(
'Title' => "Nuevo usuario",
'Msg' => "Se ha adicionado un nuevo usuario con los siguentes datos:\r\n\r\n    Identificador = {IdUser} \r\n    Usuario = {Name} \r\n    Contraseñas = {PassWord} \r\n    Correo = {Correo}"
);

$MailAutoNewUser = array(
'Title' => "Nuevo usuario creado automáticamente",
'Msg' => "Al hacer una reservación BookingHavana ha creado un nuevo usuario para ti, con los siguentes datos:\r\n\r\n    Usuario = {Name} \r\n    Correo = {Correo} \r\n    Contraseñas =   (sin contraseñas)\r\n\r\nSin embargo, para poder entrar con ese usuario a BookingHavana debe completar el proceso de validación, para eso usted debe seguir el enlace de abajo dando doble click, o copiandolo en la barra de direcciones de su navegador.\r\n\r\n".SITE_URL."validate_email.php?User={UserId} \r\n\r\nDespués que pueda entrar, si lo desea, seleccione 'Cambiar datos de usuario' y ponga una contraseñas \r\n\r\n      Equipo de trabajo de BookingHavana."
);

$MailNewPropietario = array(
'Title' => "Nuevo propietario",
'Msg' => "Se ha adicionado un nuevo propietario con los siguentes datos:\r\n\r\n    Identificador = {IdUser} \r\n    Usuario = {Name} \r\n    Contraseñas = {PassWord} \r\n    Correo = {Correo} \r\n    Teléfono = {Telef}"
);

$MailUserPublicada = array(
'Title' => "Casa publicada",
'Msg' => "{Name}, su casa con nombre comercial '{CasaName}' ha siso publicada satisfactoriamente\r\n\r\nAhora debe esperar por el proceso de revición para verla en el listado de BookingHavana\r\n\r\nGracias \r\n\r\n      Equipo de trabajo de BookingHavana."
);

$MailCasaPublicada = array(
'Title' => "Nueva casa publicada",
'Msg' => "Se ha publicado una nueva casa con los siguentes datos:\r\n\r\n    Propietario = {Name} \r\n    Nombre comercial = {CasaName} \r\n    Usuario = {UserName} \r\n    Correo = {Correo} \r\n    Teléfono = {Telef} \r\n    UserId = {UserId} \r\n    Link = {Link}"
);

$MailCasaActive = array(
'Title' => "Cambio de estado de la propiedad",
'Msg' => "Su propiedad ha cambiado de estado, ahora esta activa y se podrá reservar desde BookingHavana:\r\n\r\n    Propietario = {Name} \r\n    Nombre comercial = {CasaName} \r\n    UserId = {UserId} \r\n    Link = {Link} \r\n      Equipo de trabajo de BookingHavana."
);

$MailCasaDesActive = array(
'Title' => "Cambio de estado de la propiedad",
'Msg' => "Su propiedad ha cambiado de estado, se ha desactivado temporarmente hasta que sea publicada y aceptada nuevamente:\r\n\r\n    Propietario = {Name} \r\n    Nombre comercial = {CasaName} \r\n    UserId = {UserId} \r\n      Equipo de trabajo de BookingHavana."
);

$MailReservaToUser = array(
'Title' => "Reservación realizada",
'Msg' => "BookingHavana ha recibido una reservación con los datos siguientes:\r\n\r\n    Cliente = {Name} \r\n    Correo = {Correo} \r\n    Propiedad = {CasaName} \r\n    URL = ".SITE_URL."{URL} \r\n    Fecha de entrada = {FIni} \r\n    Fecha de salida = {FFin} \r\n    Número de personas = {NPers} \r\n    Número de menores = {NMenores} \r\n    Número de habitaciones = {NHab} \r\n    Comentarios = {Coments} \r\n\r\nEn breve tiempo será tramitada su solicitud, a traves del tur operador:\r\n    Nombre: {OpName}\r\n    Correo: {OpCorreo}\r\n\r\nSi tiene alguna duda o quiere hacer una pregunta, no dude en contactanos, mediante el correo suministrado o respondiendo este mensaje.\r\n\r\n    Gracías por su preferencia\r\n    Equipo de trabajo de BookingHavana."
);

$MailReservaToAdmin = array(
'Title' => "Reservación realizada",
'Msg' => "BookingHavana ha recibido una reservación con los datos siguientes:\r\n\r\n    Cliente = {Name} \r\n    Correo = {Correo} \r\n    Propiedad = {CasaName} \r\n    URL = ".SITE_URL."{URL} \r\n    Fecha de entrada = {FIni} \r\n    Fecha de salida = {FFin} \r\n    Número de personas = {NPers} \r\n    Número de menores = {NMenores} \r\n    Número de habitaciones = {NHab} \r\n    Comentarios = {Coments} \r\n\r\n    Teléfono = {Telef} \r\n    Dirección = {Dir} \r\n    Precios = {Precio}     \r\n\r\nEn breve tiempo será tramitada su solicitud, a traves del tur operador:\r\n    Nombre: {OpName}\r\n    Correo: {OpCorreo}\r\n\r\n {Copia}"
);

$MailSendPassword = array(
'Title' => "Recordatorio de contraseñas",
'Msg' => "{Name}, en respuesta a su solicitud, le estamos enviando los datos de su cuenta de usuario en BookingHavana.\r\n\r\n      Usuario = {Name}\r\n      Contraseñas = {PassWord}\r\n\r\n      Equipo de trabajo de BookingHavana.\r\n\r\nPD: Algunos usuarios especificos, pueden recibir este correo sin habelo solicitado."
);

// Envia un correo electronico
function SendMail( $To, $template, $Datos, $Reply='' )
  {
  if( empty($Reply) ) $Reply = 'bookinghavana@gmail.com';
    
  $Suject = $template["Title"];
  $Body   = SetDatos( $template["Msg"], $Datos);
  $Header = "From: ".$Reply."\r\n".
            "Reply-To: ".$Reply."\r\n".
            "X-Mailer: PHP/" . phpversion();
  
  mail($To, $Suject, $Body, $Header);
  }

// Pone los datos en el cuerpo del mensaje
function SetDatos( $Msg, $Datos )
  {
  foreach ($Datos as $key => $val) 
    {
    $Msg = str_replace( $key, $val, $Msg );
    }   

  return( $Msg );
  }
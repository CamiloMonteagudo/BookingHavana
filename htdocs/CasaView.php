<!-- 
<?php
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']."/");

if( empty($_GET["IdCasa"])  ) 
  { header( 'Location: index.html' ); exit(0); }

$IdCasa = $_GET["IdCasa"];
include 'LoadDatosCasa.php';   
?>
-->
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

<title>Descripción de la casa</title>

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
    
<div id="ViewCasa">

<!------------- Encabezamiento con datos principales ----------------------------------->
  <div class="frame">
    <h1>Casa particular <label>de arquiler</label> en <span id="pLoc"></span></h1>
    
    <h2>
      <span id="pProp"></span>
      <div class="Rank">
        <label>Puntuación: </label>
        <div class="Back">
          <div class="Color"> <img src="images/RankWhite.png" alt=""/> </div>
        </div> 
      <label id="NVotos" class="Hover"></label>
      </div>
    <div id="btnReserva" class="BotonG rigth-top"><img src="images/reservar.svg" alt=""/> Reservar</div>
    </h2>

    <div class="foto">
      <div class="fotoframe">
        <img id="pFoto" src="images/foto.png" alt=""/>
      </div>
      <label id="pName" >Propietario</label>
    </div>
    
    <div id="Resumen">
      <p id="pDesc"></p>   
      
      <div id="PreciosBox" class="LstVals">
        <strong><img class="icon" src="images/precio.svg" alt=""/> Precios</strong> 
        <span class="lbTemp"><input id="tmpAlta" type="checkbox" onClick="ChangePrecio();">
          <label id="lbTmpAlta"  for="tmpAlta">Temporada alta</label>
        </span>
        <ul>
          <li id="pPrecHabItem"><label>Habitación:</label>     <b id="pPrecHab"></b></li>
          <li id="pPrecAllItem"><label>Apartamento:</label>    <b id="pPrecAll"></b></li>
          <li id="pPrc1MesItem"><label>Estancia larga:</label> <b id="pPrc1Mes"></b></li>
          <li id="pPrecEstItem"><label>A Estudiantes:</label>  <b id="pPrecEst"></b></li>
        </ul>
      </div>
    </div>
    
    <div class="LstVals features">
    <ul>
      <li><label><img class="icon" src="images/lavadora.svg" alt=""/> Capacidad:</label> <b id="pNPers"></b></li>
      <li><label><img class="icon" src="images/comentar.svg" alt=""/> Habitaciones:</label> <b id="pNHab"></b></li>
      <li><label><img class="icon" src="images/mensaje.svg" alt=""/> Baños:</label> <b id="pNBanos"></b></li>
      <li><label><img class="icon" src="images/favorito.svg" alt=""/> Camas:</label> <b id="pNCamas"></b></li>
        
      <li id="pAire"><label><img class="icon" src="images/aire.svg" alt=""/> A. Acondicionado</label></li>
      <li id="pPisc"><label><img class="icon" src="images/piscina.svg" alt=""/> Piscina</label></li>
      <li id="pIndp"><label><img class="icon" src="images/privado.svg" alt=""/> Independiente</label></li>
      <li id="pLujo"><label><img class="icon" src="images/lavadora.svg" alt=""/> De lujo</label></li>
      <li id="pHotal"><label><img class="icon" src="images/aire.svg" alt=""/> Hostal</label></li>
      <li id="pPlaya"><label><img class="icon" src="images/piscina.svg" alt=""/> En la playa</label></li>
      <li id="pParq"><label><img class="icon" src="images/favorito.svg" alt=""/> Parqueo:</label> <b></b></li>
    </ul>
  </div>
  
  </div>
  
<!--------------------- acciones que se pueden realizar --------------------------------->
  <div class="cmds">
    <div id="bntComt" class="item"><img class="icon" src="images/comentar.svg" alt=""/> <span class="hide">Comentar</span></div>
    <div id="bntMail" class="item"><img class="icon" src="images/mensaje.svg" alt=""/> <span class="hide">Correo</span></div>
    <div id="bntFav"  class="item"><img class="icon" src="images/FavOff.png" alt=""/> <span class="hide">Favorito</span></div>
    <div id="bntRecm" class="item"><img class="icon" src="images/recomendar.svg" alt=""/> <span class="hide">Recomendar</span></div>
  </div>
  
<!------------------------- Zona para mostrar las fotos ------------------------------->
  <div id="ViewFotos">
    <div id="FrameFoto"><img src="images/Next.png" class="ChgCasa btnPrev" alt=""><img src="images/Previous.png" class="ChgCasa btnNext" alt=""></div>
    <div id="FrameBrowse">
      <div id="BrowLeft">
        <img src="images/Previous.png" alt=""/>
      </div>
      <div id="BrowFotos"></div>
      <div id="BrowRight">
        <img src="images/Next.png" alt=""/>
      </div>
    </div>
  </div>

<!-------------------------- Características principales ------------------------------->
  <div class="LstVals UpSep">
    <h2 class="SubTitle">Sobre el apartamento</h2>
    <p id="pDescDet"></p>

    <ul>
      <li><label><img class="icon" src="images/favorito.svg" alt=""/> Entrada:</label> <b id="pIn"></b></li>
      <li><label><img class="icon" src="images/favorito.svg" alt=""/> Salida:</label> <b id="pOut"></b></li>
      
      <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Transfer:</label> <b id="pTranf"></b></li>
      <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Desayuno:</label> <b id="pDesay"></b></li>
      <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Gastronomia:</label> <b id="pGast"></b></li>
    </ul>
  </div>
  
<!----------------------------- Facilidades de la casa --------------------------------->
  <div class="LstVals Facilid UpSep">
    <h2 class="SubTitle">Otras facilidades</h2>
    <ul>
      <li><label>Calentador:</label> <b id="pCalent"></b></li>
      <li><label>Discapacitados:	</label> <b id="pDiscap"></b></li>
      <li><label>Cancelar Reserva:  </label> <b id="pCancel"></b></li>
      <li><label>Elevador:	</label> <b id="pElev"></b></li>
      <li><label>Aire Central:</label> <b id="pACent"></b></li>
      <li><label>Sist. de audio:   </label> <b id="pAudio"></b></li>
      <li><label>Televisor:      </label> <b id="pTV"></b></li>
      <li><label>Télefono:     </label> <b id="pTelef"></b></li>
      <li><label>Billar:  </label> <b id="pBillar"></b></li>
      <li><label>Wifi:    </label> <b id="Wifi"></b></li>
      <li><label>Refrigerador:    </label> <b id="pRefr"></b></li>
      <li><label>Enchufe 110v:</label> <b id="p110v"></b></li>
      <li><label>Enchufe 220v:</label> <b id="p220v"></b></li>
      <li><label>Bar:     </label> <b id="pBar"></b></li>
      <li><label>Lavadora:</label> <b id="pLab"></b></li>
      <li><label>Serv. de lavado:</label> <b id="pSLab"></b></li>
      <li><label>Serv. de plachado: </label> <b id="pSPlanc"></b></li>
      <li><label>Masaje:  </label> <b id="pMasj"></b></li>
      <li><label>Seguridad 24h: </label> <b id="pSegd"></b></li>
      <li><label>Gimnasio:</label> <b id="pGimn"></b></li>
      <li><label>Cocina:</label> <b id="pCocina"></b></li>
      <li><label>Vista al Mar:</label> <b id="pVMar"></b></li>
      <li><label>Vista a la ciudad:</label> <b id="pVCiud"></b></li>
      <li><label>Vista panorámica:</label> <b id="pVPanor"></b></li>
      <li><label>Agua a presión:</label> <b id="pAPrec"></b></li>
      <li><label>Baño auxiliar:</label> <b id="pBAux"></b></li>
      <li><label>Jacuzzi:</label> <b id="pJacuz"></b></li>
      <li><label>Jardín:</label> <b id="pJard"></b></li>
      <li><label>Ranchón:</label> <b id="pRanch"></b></li>
      <li><label>Parrilla:</label> <b id="pParr"></b></li>
      <li><label>Balcón:</label> <b id="pBalcon"></b></li>
      <li><label>Terraza:</label> <b id="pTarrz"></b></li>
      <li><label>Patio:</label> <b id="pPatio"></b></li>
      <li><label>Área de fumadores:</label> <b id="pAFum"></b></li>
      <li><label>Zona de trabajo:</label> <b id="pATrab"></b></li>
      <li><label>Salón de reuniones:</label> <b id="pSReun"></b></li>
    </ul>
  </div>

<!--------------------------  Datos de las habitaciones -------------------------------->
  <div class="Habits UpSep">
    <h2 class="SubTitle">Habitaciones</h2>
    <ul class="Tab">
    </ul>
    <div class="TabContent">
      <div class="frame">
        <div class="FrmCasaM">
          <img src="images/Next.png" class="ChgCasa btnPrev" alt="">
          <img src="images/Previous.png" class="ChgCasa btnNext" alt="">
        </div>
        
        <div class="CasaDesM">
          <p id="hDesc"></p>   
          
          <div class="LstVals habTipo">
            <ul>
              <li><label>Tipo: </label> <b id="hTipo"></b></li>
              <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Precio:</label> <b id="hPrec"></b></li>
              <li id="btnReservaHab" class="Hover"><span><img class="icon" src="images/reservar.svg" alt=""/> Reservar</span></li>
            </ul>
          </div>
               
          <div class="LstVals camas">
            <h2>Camas</h2>
            <ul>
              <li><label>Camera:</label> <b id="hCCam"></b></li>
              <li><label>King Size: </label> <b id="hCKing"></b></li>
              <li><label>Queen: </label> <b id="hCQueen"></b></li>
              <li><label>Personal:</label> <b id="hCPers"></b></li>
              <li><label>Cuna: </label> <b id="hCCuna"></b></li>
              <li><label>Litera:</label> <b id="hCLit"></b></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="LstVals Facilid UpSep">
        <h2 class="SubTitle">Facilidades</h2>
        <ul>
          <li><label>Independiente:    </label> <b id="hIndep"></b></li>
          <li><label>A. Acondicionado: </label> <b id="hAire"></b></li>
          <li><label>Split:            </label> <b id="hSplit"></b></li>
          <li><label>Ventiladores:     </label> <b id="hVent"></b></li>
          <li><label>Sist. de Audio:   </label> <b id="hAudio"></b></li>
          <li><label>Televisor:        </label> <b id="hTV"></b></li>
          <li><label>Teléfono:         </label> <b id="hTelef"></b></li>
          <li><label>Enchufe 110v:     </label> <b id="hV110"></b></li>
          <li><label>Enchufe 220v:     </label> <b id="hV220"></b></li>
          <li><label>Mini Bar:         </label> <b id="hMBar"></b></li>
          <li><label>Vestidor:         </label> <b id="hVest"></b></li>
          <li><label>Closet:           </label> <b id="hClos"></b></li>
          <li><label>Armario:          </label> <b id="hArm"></b></li>
        </ul>
      </div>

      <div class="LstVals Facilid UpSep">
        <h2 class="SubTitle">Baño</h2>
          <p id="bDesc">Moderno y amplio con todas las comodidades.</p>   
        <ul>
          <li><label>En la Habitación: </label> <b id="bDentro"></b></li>
          <li><label>Agua caliente     </label> <b id="bACal"></b></li>
          <li><label>Jacuzzi:          </label> <b id="bJacuz"></b></li>
          <li><label>Cabina de baño:   </label> <b id="bCabin"></b></li>
          <li><label>Tina de baño:     </label> <b id="bTina"></b></li>
          <li><label>Bidel:            </label> <b id="bBidl"></b></li>
          <li><label>Secadora de pelo: </label> <b id="bSecd"></b></li>
          <li><label>Discapacitados:   </label> <b id="bDisc"></b></li>
        </ul>
      </div>

    </div>
    
  </div>
  
<!------------------------------- Datos de la cocina ----------------------------------->
  <br/>
  <div id="CocDatos" class="LstVals Facilid UpSep">
    <h2 class="SubTitle">Cocina</h2>
      <p id="cDesc"></p>   
    <ul>
      <li><label>Horno Microwave: </label> <b id="cMWave"></b></li>
      <li><label>Batidora:        </label> <b id="cBatd"></b></li>
      <li><label>Cafetera:        </label> <b id="cCaft"></b></li>
      <li><label>Refrigerador:    </label> <b id="cRefr"></b></li>
      <li><label>Horno de gas:    </label> <b id="cHGas"></b></li>
      <li><label>Horno eléctrico: </label> <b id="cHElect"></b></li>
      <li><label>Olla arrocera:   </label> <b id="cOArroc"></b></li>
      <li><label>Olla de preción: </label> <b id="cOPrec"></b></li>
      <li><label>Filtro de agua:  </label> <b id="cFAgua"></b></li>
      <li><label>Juego de Vajilla:</label> <b id="cVagill"></b></li>
      <li><label>Mesa:            </label> <b id="cMesa"></b></li>
      <li><label>Nevera:          </label> <b id="cNevera"></b></li>
    </ul>
  </div>
  
  <div id="EditMode" class="UpSep" style="display:none;">  
    <a id="lnkEdit" href=""> <div id="btnEditar" class="BotonG center"><img src="images/reservar.svg" alt=""/> Editar</div> </a>
  </div>

</div>

<!-- Dialogo para mandar un correo -->
<div id="MailData" class="BoxFloat" style="display:block;" >
    <div><textarea class="LineInput" rows="10" style="width:300px;" placeholder="Contenido del correo"></textarea></div>
    <div class="btnRight">Enviar</div>
</div>

<!-- Dialogo para hacer una recomendación -->
<div id="RecomData" class="BoxFloat" style="display:block; width:300px;" >
    <div><input class="LineInput" type="text" placeholder="Nombre"/></div>
    <div><input class="LineInput" type="text" placeholder="Correo"/></div>
    <br>
    <div><input class="LineInput" type="text" placeholder="Correo del amigo"/></div>
    <div><input class="LineInput" type="text" placeholder="Comentario"/></div>
    <div class="btnRight">Recomendar</div>
</div>

<br/>
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

<!-- Mensaje de confirmación para otorgar puntuación -->
<div id="RankMsg" class="BoxFloat" >
  <p>Esta seguro que desea otorgar una puntuación de <strong>5</strong> estrellas a esta propiedad.</p>
  <div id="RankOK">Sí</div>
</div>

<!-- Muestra un resumen de la puntuación de una casa -->
<div id="RankSumary" class="BoxFloat" style="width:205px;">
  <div style="margin-bottom:6px;">Puntuaciones otorgadas:</div>
  <div>
    <div class="NumPts" id="rkPnts0"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:0;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div>
    <div class="NumPts" id="rkPnts1"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:20px;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div>
    <div class="NumPts" id="rkPnts2"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:40px;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div>
    <div class="NumPts" id="rkPnts3"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:60px;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div>
    <div class="NumPts" id="rkPnts4"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:80px;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div>
    <div class="NumPts" id="rkPnts5"></div> 
    <div class="Pnts">
      <div class="Back"> <div class="Color" style="width:100px;"> <img src="images/RankWhite.png" alt=""/> </div> </div> 
    </div> 
  </div> 
  <div style="margin-top:5px;">Promedio:<b id="rkProm"></b></div>
</div>


</div>

<br/>
<br/>
<br/>

<!------------------------------------------------------------------------------------------------>
<!-- CODIGO JAVASCRIPT  -->
<!------------------------------------------------------------------------------------------------>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/BookingHav.js"></script>

<script type="text/javascript">

var Casa = <?= $Data?>;
var AutoLogueo = <?= isset($AutoLogueo)? 1 : 0 ?>;
var Menu, Correo, bntFav, Recom;
var csRank, csFotos, Habs, floatBox;

// Inicia manipuladores y variables, después de cargarse la página
$(function() 
  {
  if( !CheckData(Casa) )
    { window.location = "<?=SITE_URL?>Index.html"; return; }
  
  localStorage.LastCasa = Casa.Id;
    
  var User = GetLogUser();
  if( Casa.Id === User.Id || AutoLogueo )
    $("#EditMode").css("display", "block");  
  
  Menu = new MainMenu(); 
  floatBox = $("#btnReserva");
  floatBox.click( GoReserva );
  $("#btnReservaHab").click( GoReserva );

  $(window).scroll( OnScroll );
  
  csRank = new Ranking( Casa.pRank );
  csRank.SetNVotos( Casa.Puntos );
  csRank.RankingChanged = ChangePuntuacion;
  
  csFotos = BrowseFotos( Casa );
  Habs    = MngHabitaciones( Casa );
  
  FillCasaDatos( Casa );
  $("#lnkEdit").attr("href", GetCasaLnk( Casa.Id, Casa.pLoc, Casa.pProp, "modificar/" ) );
  
  bntFav = $("#bntFav");
  bntFav.click( toggleFavorito );

  $("#bntComt").click(function(e) 
    { window.location="/CasasComents.html"; });

  UserChanged();  
  Menu.ChangeUser = UserChanged;
  
  Correo = new PopUp( "#bntMail", {} ); 
  Correo.SetBox("#MailData");
  $("#MailData .btnRight").click(SendCorreo);
  
  Recom = new PopUp( "#bntRecm", {right:1} ); 
  Recom.SetBox("#RecomData");
  Recom.OnShowPopUp = SetRecomedData;
  $("#RecomData .btnRight").click(SendRecomendacion);
  
});

// Se llama cada vez que el usuario cambia
function UserChanged()
  {
  var User = GetLogUser();
  
  if( User.Id ) viewFavorito( User.Id, Casa.Id);
  else          SetFavorito( false );
  }

// Mira si la casa es favorita del usuario actual
function viewFavorito( UserId, CasaId )
  {
  var Data = 'UserId='+UserId+"&CasaId="+CasaId;
  $.ajax({ url: "viewFavorito.php", data: Data, type:"POST",
     complete: function( xhr )
        { 
        checkReturn( xhr, function(data){ SetFavorito(data.On); } ); 
        }
    });
  }

// Mira si la casa es favorita del usuario actual
function toggleFavorito()
  {
  var User = GetLogUser();
  if( !User.Id ) 
    { alert( msgErrors[20] ); return; }

  var Data = 'UserId='+User.Id+"&CasaId="+Casa.Id;
  $.ajax({ url: "toggleFavorito.php", data: Data, type:"POST",
     complete: function( xhr )
        { 
        checkReturn( xhr, function(data){ SetFavorito(data.On); } ); 
        }
    });
  }

// Muestra estado de favorito
function SetFavorito( On )
  {
  if( On ) 
    {
    bntFav.find("img").attr("src","images/FavOn.png");
    bntFav.css( {'color':'#177ee5', 'font-weight':'bold'} );  
    }
  else
    {  
    bntFav.find("img").attr("src","images/FavOff.png");
    bntFav.css( {'color':'#565a5c', 'font-weight':'normal'} );  
    }
  }

// Cambia la puntuación de una casa
function ChangePuntuacion ( rk )
  {
  var Data = 'Puntos='+rk+"&IdCasa="+Casa.Id;
  $.ajax({ url: "CasaPuntos.php", data: Data, type:"POST",
     complete: function( xhr )
        { 
        checkReturn( xhr, function(data)
          { 
          csRank.SetRanking( data.Rank, data.Puntos );
          csRank.ShowSumary();
          }); 
        }
    });
  };
   
// Pone los datos para enviar recomendacion   
function SetRecomedData()
  {
  var Inps = $("#RecomData input"); 
  
  var User = GetLogUser();
  if( User.Id  )                       
    {
    Inps.eq(0).val( User.Nombre );
    Inps.eq(1).val( User.Correo );
    }
  else
    {
    if( localStorage.LastUserName ) Inps.eq(0).val( localStorage.LastUserName );
    if( localStorage.LastUserMail ) Inps.eq(1).val( localStorage.LastUserMail );
    }
  }

// Envia un recomendacion
function SendRecomendacion()
  {
  var Data;  
  var Inps = $("#RecomData input"); 
  var User = Inps.eq(0).val(), userMail = Inps.eq(1).val();  
  var Mail = Inps.eq(2).val(), coments  = Inps.eq(3).val(); 
  
  if( !reMail.test(Mail)) 
    { 
    alert("El correo electronico está incorrecto");  
    Inps.eq(2).focus();
    return false;
    }
    
  Data = "Mail=" + encodeURIComponent(Mail);
  var msg  = "Te recomiendo el arquiler de esta casa:\r\n<?=SITE_URL?>" + GetCasaLnk( Casa.Id, Casa.pLoc, Casa.pProp, "" );    
  if( coments.trim().length > 0 )
    msg += "\r\n\r\n" + coments;   
  
  msg += "\r\n\r\nEnviado: " + User;   
  msg += "\r\nCorreo: " + userMail;   
  Data += "&msgBody=" + encodeURIComponent(msg);
  
  DoSendEMail( Data, Recom );
  
  localStorage.LastUserName = User;
  localStorage.LastUserMail = userMail;
  }

// Envia un correo al administrador del sito
function SendCorreo()
  {
  var Data = 'msgBody='+ encodeURIComponent($("#MailData textarea").val());
  DoSendEMail( Data, Correo );
  }

// Envia un correo con los datos suministrados
function DoSendEMail( Data, popup )
  {
  $.ajax({ url:"SendClientMail.php", data: Data, type:"POST",
     complete: function( xhr )
        { 
        if( checkReturn( xhr ) && popup)
          popup.ClosePopUp();           
        }
    });
  }

// Monitorea el scroll, para dejar los filtros fijo en la parte de arriba de la página
function OnScroll()
  {
  var float = floatBox.attr("style");
  var offy = $(document).scrollTop();
  if( offy>130 )
    {
    if( !float ) {floatBox.css( {position:'fixed', top:10}); }
    }
  else
    {
    if( float ) {floatBox.removeAttr("style");}
    }
  }

function ChangePrecio()
  {
  SetPrecios( Casa );
  }
 
//Chequea los botones para cambiar imagen, solo muestra el que es necesario
function CheckBtns( cs, btnPrev, btnNext )
  {
  var shwPrev = ( cs.img<=0         )? "none" : "block";
  var shwNext = ( cs.img>=cs.nImgs-1 )? "none" : "block";
    
  btnPrev.css("display", shwPrev);
  btnNext.css("display", shwNext);
  }

//Cambia animado de la imagen de la casa (hacia la derecha o hacia la izquierda) 
function ChangeCasaImg( frame, newPath , toRight, tm )
  {
  var durac   = tm || 0;  
  var ImgOld  = frame.find(".ImgCasa");
  var ImgNew  = $('<img src="'+ newPath +'" class="CasaMBox ImgCasa">');
  
  frame.append(ImgNew);
  
  var w = ImgNew.width();  
  if( toRight ) w = -w;
  
  ImgNew.css( {position:'absolute', top:0, left:w} );
  
  ImgNew.animate({left:0}, durac, function()
    {
    ImgOld.remove();
    ImgNew.css( {position:'relative'} );
    });
  }

// Implementa la interface para ver las imagenes de una casa
function BrowseFotos( casa )
  {
  var cs = casa;
  cs.img = -1;
  var frm  = $("#FrameFoto");
  var Tira = $("#BrowFotos");
  var FrmTira = $("#FrameBrowse");
  var BrowL = $("#BrowLeft");
  var BrowR = $("#BrowRight");
  var btnPrev = frm.find(".btnPrev");
  var btnNext = frm.find(".btnNext");      
  var Timer;
  
  var html = "";  
  for( var i=0; i<cs.nImgs; ++i )  
    html += '<img idx="'+i+'" src="'+ ImgPath( cs, "P", i ) +'">';  
    
  Tira.append( html );
  var imgs = Tira.find("img");  
  
  var lenFotos = Tira.outerWidth();
  var lenFrame = FrmTira.outerWidth();
  
  // Selecciona la casa con indice idx
  function SelectFoto( idx, tmp, toRight )
    {
    if( cs.img === idx ) return;
    
    var newPath = ImgPath( cs, "G", idx );
    ChangeCasaImg( frm, newPath, toRight, tmp );
    
    imgs.filter(".SelFoto").removeClass("SelFoto");
    $(imgs[idx]).addClass("SelFoto");
    
    cs.img = idx;
    CheckBtns( cs, btnPrev, btnNext );      
    }  
  
  // Pasa a la proxima imagen, si la última empieza otra vez  
  function NextImage()
    {
    var n = cs.img + 1;
    if( n>=cs.nImgs ) n=0;
      
    SelectFoto( n, 300, false );  
    }
    
  // Chequea si la tira de fotos cabe en el marco  
  function CheckTiraFrame()
    {
    lenFrame = FrmTira.outerWidth();
    if( lenFotos<=lenFrame )
      {
      BrowL.hide();
      BrowR.hide();
      Tira.css( {left:2} );
      return false;
      }
      
    return true;  
    }  
  
  // Cuando se oprime el botón izquierdo de la tira de fotos  
  BrowL.click(function(e) {
    if( !CheckTiraFrame() ) return;
      
    var x = Tira[0].offsetLeft;
    x -= (lenFrame-200);
        
    if( lenFotos+x < lenFrame )  { x = lenFrame-lenFotos-32; BrowL.hide();}
    
    BrowR.show();
    
    Tira.animate({left:x}, 300 );
    return false;  
    });
 
  // Cuando se oprime el botón derecho de la tira de fotos  
  BrowR.click(function(e) {
    if( !CheckTiraFrame() ) return;
    var x = Tira[0].offsetLeft;
    x += (lenFrame-200);
        
    if( x>0 ) { x = 32; BrowR.hide();}
    
    BrowL.show();
    
    Tira.animate({left:x}, 300 );
    return false;  
    }); 
      
  // Cuando se selecciona una foto en la tira de miniaturas
  imgs.click(function(e) {
    var idx = +$(this).attr("idx");
    toRight = (idx<cs.img);
    SelectFoto( idx, 300, toRight );
    PauseReprod();
    });

  // Se oprimio boton de correr una imagen hacia atras
  btnPrev.click(function(e) {
    var n = cs.img - 1;
    if( n<0 ) return;
      
    SelectFoto( n, 300, true );  
    PauseReprod();
    });
  
  // Se oprimio boton de correr una imagen hacia adelente
  btnNext.click(function(e) {
    var n = cs.img + 1;
    if( n>=cs.nImgs ) return;
      
    SelectFoto( n, 300, false );  
    PauseReprod();
    });      

  function PauseReprod()
    {
    clearInterval( Timer );
    Timer = setTimeout( function()
      {
      Timer = setInterval( NextImage, 5000 );
      }, 30000);
    }
        
  // Inicializa con la primera foto seleccionada    
  SelectFoto( 0 );
  if( lenFotos > lenFrame )
    {  
    BrowL.show(); 
    Tira.css( {left:32} );
    }

  Timer = setInterval( NextImage, 5000 );
  }

// Maneja la visualización del los datos de las habitaciones  
function MngHabitaciones( casa )
  {
  var Habs = casa.Habits;
  var nHab = Habs.length;
  var Act  = -1;
  var Hdr  = $(".Tab");
  var Body = $(".TabContent");
  var FrmImg  = Body.find(".FrmCasaM");
  var btnPrev = FrmImg.find(".btnPrev");
  var btnNext = FrmImg.find(".btnNext");      
  var HabImgs = [];
  var ActImg  = -1;

  btnPrev.click(function(e) {
    var n = ActImg - 1;
    if( n<0 ) return;
      
    SelectFoto( n, 300, true );  
    });
  
  btnNext.click(function(e) {
    var n = ActImg + 1;
    if( n>=HabImgs.length ) return;
      
    SelectFoto( n, 300, false );  
    });      
  
  // Selecciona la foto de la casa con indice idx
  function SelectFoto( idx, tmp, toRight )
    {
    if( ActImg === idx ) return;
    
    if( HabImgs.length>0 )
      {
      var newPath = ImgPath( casa, "M", HabImgs[idx] );
      ChangeCasaImg( FrmImg, newPath, toRight, tmp );
      ActImg = idx;
      }
    
    ChkBtns( btnPrev, btnNext );      
    }  
  
  //Chequea los botones para cambiar imagen, solo muestra el que es necesario
  function ChkBtns( btnPrev, btnNext )
    {
    var shwPrev = ( ActImg<=0                )? "none" : "block";
    var shwNext = ( ActImg>=HabImgs.length-1 )? "none" : "block";
      
    btnPrev.css("display", shwPrev);
    btnNext.css("display", shwNext);
    }


  var html = "";  
  for( var i=0; i<nHab; ++i )  
    html += '<li idx="'+i+'" class="TabItem Hover"><label>Hab. '+ (i+1) +'</label></li>';  
    
  Hdr.append( html );
  var Tabs = Hdr.find(".TabItem");
  Tabs.click(function(e) {
    var idx = +$(this).attr("idx");
    SelectTab( idx );
    });  
    
  function SelectTab( idx )
    {
    if( Act === idx ) return;
    
    Tabs.filter(".Active").removeClass("Active");
    $(Tabs[idx]).addClass("Active");
    
    Act = idx;
    
    var iOpts = casa.iOpts.split(',');
    var n = 0;
    HabImgs = [];
    for( i=0; i<iOpts.length ; ++i)
      {
      if( iOpts[i]-5 == idx ) 
        HabImgs[n++] = i;
      }
  
    ActImg = -1;
    FillHabDatos( idx );
    }  
    
  function FillHabDatos( idx )
    {
    SelectFoto( 0, 0, true ); 
    
    var Hab = Habs[idx];
    $("#hDesc"  ).text( Hab.hDesc   );
    $("#hTipo"  ).text( Hab.hTipo   );
    $("#hPrec"  ).text( PrecioText(Hab.hPrec) );
    $("#hCCam"  ).text( Hab.hCCam   );
    $("#hCKing" ).text( Hab.hCKing  );
    $("#hCQueen").text( Hab.hCQueen );
    $("#hCPers" ).text( Hab.hCPers  );
    $("#hCCuna" ).text( Hab.hCCuna  );
    $("#hCLit"  ).text( Hab.hCLit   );
       
    $("#hIndep" ).html( bool(Hab.hIndep));
    $("#hAire"  ).html( bool(Hab.hAire));
    $("#hSplit" ).html( bool(Hab.hSplit));
    $("#hVent"  ).html( Hab.hVent   );
    $("#hAudio" ).html( bool(Hab.hAudio));
    $("#hTV"    ).html( bool(Hab.hTV)   );
    $("#hTelef" ).html( bool(Hab.hTelef));
    $("#hV110"  ).html( bool(Hab.hV110) );
    $("#hV220"  ).html( bool(Hab.hV220) );
    $("#hMBar"  ).html( bool(Hab.hMBar) );
    $("#hVest"  ).html( bool(Hab.hVest) );
    $("#hClos"  ).html( bool(Hab.hClos) );
    $("#hArm"   ).html( bool(Hab.hArm ) );
       
    $("#bDesc"  ).text( Hab.bDesc );
    $("#bDentro").html( bool(Hab.bDentro) );
    $("#bACal"  ).html( bool(Hab.bACal)  );
    $("#bJacuz" ).html( bool(Hab.bJacuz) );
    $("#bCabin" ).html( bool(Hab.bCabin) );
    $("#bTina"  ).html( bool(Hab.bTina)  );
    $("#bBidl"  ).html( bool(Hab.bBidl)  );
    $("#bSecd"  ).html( bool(Hab.bSecd)  );
    $("#bDisc"  ).html( bool(Hab.bDisc)  ); 
    
    }
     
  SelectTab( 0 );  
  }

function bool( sw )  
  {
  if( sw ) return '<img src="images/ok.png" width="16px" height="20px" />';
  else     return 'No';
  }
  
function SetImg( id , src )
  {
  var name = src || "images/foto.png";   
  $(id).attr( "src", name );
  }

function ChkString( str, sDef )
  {
  if( !str || str.length==0 ) return sDef;
  else                        return str;
  }

function ShowHide( elem, val )
  {
  if( val && val!="No" ) $(elem).css( {display:"inline-block"} );
  else                   $(elem).css( {display:"none"} );
  }

function SetPrecios( cs )
  {
  var tAlta = false;  
  if( cs.pByTemp ) tAlta = $(tmpAlta)[0].checked
  else             $(".lbTemp").hide(); 
  
  var pHab = (tAlta)? cs.pPrecHab2 : cs.pPrecHab;
  var pAll = (tAlta)? cs.pPrecAll2 : cs.pPrecAll;
  var pMes = (tAlta)? cs.pPrc1Mes2 : cs.pPrc1Mes;
  var pEst = (tAlta)? cs.pPrecEst2 : cs.pPrecEst;
  
  $("#pPrecHab").text( PrecioText(pHab) );
  $("#pPrecAll").text( PrecioText(pAll) );
  $("#pPrc1Mes").text( PrecioText(pMes) );
  $("#pPrecEst").text( PrecioText(pEst) );

  ShowHide( "#pPrecHabItem", pHab );  
  ShowHide( "#pPrecAllItem", pAll );  
  ShowHide( "#pPrc1MesItem", pMes );  
  ShowHide( "#pPrecEstItem", pEst );  
  }

function SetTemporada( cs )
  {
  var AIni = 9, AEnd = 3;
  var tMeses = Casa.pTemps.split(",");
  if( tMeses.length===4 )
    {
    AIni = +tMeses[2];
    AEnd = +tMeses[3];
    }
    
  var mes = (new Date()).getMonth();
  if( mes>AIni || mes<AEnd ) 
    $(tmpAlta)[0].checked = true;
  
  $("#lbTmpAlta").text( "Temporada alta ("+Meses[AIni]+" - "+Meses[AEnd]+")" );  
  }
  
function FillCasaDatos( cs )
  {
  SetTemporada(cs);
  
  SetImg( "#pFoto", cs.pFoto );
  
  $("#pLoc"    ).text( GetLocalidad(cs.pLoc) );
  $("#pName"   ).text( ChkString(cs.pName, "Propietario") );
  $("#pProp"   ).text( cs.pProp );
  $("#pDesc"   ).text( cs.pDesc );
  
  SetPrecios( cs );
  
  $("#pNPers"  ).text( cs.pNPers   );
  $("#pNHab"   ).text( cs.pNHab );
  $("#pNBanos" ).text( cs.pNBanos );
  $("#pNCamas" ).text( cs.pNCamas );
  
  ShowHide("#pAire" , cs.pAire  );
  ShowHide("#pPisc" , cs.pPisc  );
  ShowHide("#pIndp" , cs.pIndp  );
  ShowHide("#pLujo" , cs.pLujo  );
  ShowHide("#pHotal", cs.pHotal );
  ShowHide("#pPlaya", cs.pPlaya );
  ShowHide("#pParq" , cs.pParq  );

  $("#pParq b"   ).text( PrecioText(cs.pParq) );
  
  $("#pDescDet").html( cs.pDescDet );
  $("#pIn"     ).text( HoraText(cs.pIn ) );
  $("#pOut"    ).text( HoraText(cs.pOut) );
  $("#pTranf"  ).text( PrecioText(cs.pTranf) );
  $("#pDesay"  ).text( PrecioText(cs.pDesay) );
  $("#pGast"   ).text( PrecioText(cs.pGast ) );
  
  $("#pCalent" ).html( bool(cs.pCalent) );
  $("#pDiscap" ).html( bool(cs.pDiscap) );
  $("#pCancel" ).html( bool(cs.pCancel) );
  $("#pElev"   ).html( bool(cs.pElev  ) );
  $("#pACent"  ).html( bool(cs.pACent ) );
  $("#pAudio"  ).html( bool(cs.pAudio ) );
  $("#pTV"     ).html( bool(cs.pTV    ) );
  $("#pTelef"  ).html( bool(cs.pTelef ) );
  $("#pBillar" ).html( bool(cs.pBillar) );
  $("#Wifi"    ).html( bool(cs.Wifi   ) );
  $("#pRefr"   ).html( bool(cs.pRefr  ) );
  $("#p110v"   ).html( bool(cs.p110v  ) );
  $("#p220v"   ).html( bool(cs.p220v  ) );
  $("#pBar"    ).html( bool(cs.pBar   ) );
  $("#pLab"    ).html( bool(cs.pLab   ) );
  $("#pSLab"   ).html( bool(cs.pSLab  ) );
  $("#pSPlanc" ).html( bool(cs.pSPlanc) );
  $("#pMasj"   ).html( bool(cs.pMasj  ) );
  $("#pSegd"   ).html( bool(cs.pSegd  ) );
  $("#pGimn"   ).html( bool(cs.pGimn  ) );
  $("#pCocina" ).html( bool(cs.pCocina) );
  $("#pVMar"   ).html( bool(cs.pVMar  ) );
  $("#pVCiud"  ).html( bool(cs.pVCiud ) );
  $("#pVPanor" ).html( bool(cs.pVPanor) );
  $("#pAPrec"  ).html( bool(cs.pAPrec ) );
  $("#pBAux"   ).html( bool(cs.pBAux  ) );
  $("#pJacuz"  ).html( bool(cs.pJacuz ) );
  $("#pJard"   ).html( bool(cs.pJard  ) );
  $("#pRanch"  ).html( bool(cs.pRanch ) );
  $("#pParr"   ).html( bool(cs.pParr  ) );
  $("#pBalcon" ).html( bool(cs.pBalcon) );
  $("#pTarrz"  ).html( bool(cs.pTarrz ) );
  $("#pPatio"  ).html( bool(cs.pPatio ) );
  $("#pAFum"   ).html( bool(cs.pAFum  ) );
  $("#pATrab"  ).html( bool(cs.pATrab ) );
  $("#pSReun"  ).html( bool(cs.pSReun ) );
  
  if( cs.pCocina )
    {
    $("#cDesc"  ).html( cs.cDesc );
    $("#cMWave" ).html( bool(cs.cMWave ) );
    $("#cBatd"  ).html( bool(cs.cBatd  ) );
    $("#cCaft"  ).html( bool(cs.cCaft  ) );
    $("#cRefr"  ).html( bool(cs.cRefr  ) );
    $("#cHGas"  ).html( bool(cs.cHGas  ) );
    $("#cHElect").html( bool(cs.cHElect) );
    $("#cOArroc").html( bool(cs.cOArroc) );
    $("#cOPrec" ).html( bool(cs.cOPrec ) );
    $("#cFAgua" ).html( bool(cs.cFAgua ) );
    $("#cVagill").html( bool(cs.cVagill) );
    $("#cMesa"  ).html( bool(cs.cMesa  ) );
    $("#cNevera").html( bool(cs.cNevera) );
    }
  else
    {
    $("#CocDatos").css("display", "none");  
    }
  
  }
     
function GoReserva()
  {
  var AllScreen = $('<iframe id="AllScreen" class="AllScreen"></iframe>');

  $("body").append( AllScreen );
  AllScreen.attr( "src", "Reservar.html");
  }

function GetFrameDatos()
  {
  return { Id:Casa.Id, pProp:Casa.pProp, pLoc:Casa.pLoc, pNHab:Casa.pNHab };
  }
  
function CloseFrame()
  {
  $("#AllScreen").remove();  
  }
  
</script>  


</body>
</html>

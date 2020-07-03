<!-- 
<?php
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']."/");

if( empty($_GET["IdCasa"])  ) 
  { header( 'Location: index.html' ); exit(0); }

$IdCasa = $_GET["IdCasa"];
$Edit = true;

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

<title>Datos de la casa</title>

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
    
    
<form id="EditCasa">
<!------------- Encabezamiento con datos principales ----------------------------------->
  <div class="frame">
    <h1>Datos de la propiedad</h1>
    <div class="UpSep"></div>
    <div class="foto">
      <div class="fotoframe">
        <img id="pFoto" src="images/foto.png" alt=""/>
      </div>
      <input id="pName" type="text" placeholder="Nombre del propietario">
      <div class="BtnFlat center">  
        <div> Subir una foto </div>
        <input id="UpFoto" class="UpInput" type="file" title="Imagen cuadrada de 200 x 200 pixeles o más">
      </div>
    </div>
    
    <div id="Resumen">
      <div>
        <span style="display:inline-block;">
          <label for="pDesc" class="lbInput">Nombre comercial* (hasta 30 caracteres)</label>
          <input id="pProp" type="text"  style="width:300px" maxlength="30">
        </span>
    
        <div id="ctrlCbLoc"> <span>Localidad:</span>
          <div id="selLoc" class="ComboFilter selLoc"><span></span></div>
        </div>
      </div>  

    <label for="pDesc" class="lbInput">Breve descripción de la propiedad* (hasta 255 caracteres)</label>
    <textarea id="pDesc" maxlength="255" rows="3" cols="255"></textarea>
    
    <label for="pDir" class="lbInput">Dirección de la propiedad*</label>
    <textarea id="pDir" maxlength="255" rows="3" cols="255"></textarea>
    </div>
  </div>
    
  <div id="PreciosBox" class="LstVals">
    <strong><img class="icon" src="images/precio.svg" alt=""/> Precios</strong> 
    <span class="lbByTemp"><input id="pByTemp" type="checkbox"><label for="pCalent">Por temporadas</label></span>
    <span class="lbTemp"><label>Temporada alta ( <span id="TempAltaIni" class="ComboFlat thin">Noviembre</span>- <span id="TempAltaFin" class="ComboFlat thin"> Marzo</span>)</label></span>
    <ul id="TempAlta">
      <li><div id="pPrecHab2" class="Combo"><span></span></div><label class="PrecLabel">Habitación:</label>    </li>
      <li><div id="pPrecAll2" class="Combo"><span></span></div><label class="PrecLabel">Apartamento:</label>   </li>
      <li><div id="pPrc1Mes2" class="Combo"><span></span></div><label class="PrecLabel">Estancia larga:</label></li>
      <li><div id="pPrecEst2" class="Combo"><span></span></div><label class="PrecLabel">A Estudiantes:</label> </li>
    </ul>
    <span class="lbTemp"><label>Temporada baja ( <span id="TempBajaIni">Abril</span> - <span id="TempBajaFin">Octubre</span> )</label></span>
    <ul>
      <li><div id="pPrecHab" class="Combo"><span></span></div><label class="PrecLabel">Habitación:</label>    </li>
      <li><div id="pPrecAll" class="Combo"><span></span></div><label class="PrecLabel">Apartamento:</label>   </li>
      <li><div id="pPrc1Mes" class="Combo"><span></span></div><label class="PrecLabel">Estancia larga:</label></li>
      <li><div id="pPrecEst" class="Combo"><span></span></div><label class="PrecLabel">A Estudiantes:</label> </li>
    </ul>
  </div>
  
  <div class="UpSep"></div>
  <div class="LstVals">
    <ul>
      <li><input id="pAire" type="checkbox"><label for="pAire"><img class="icon" src="images/aire.svg" alt=""/> A. Acondicionado</label></li>
      <li><input id="pPisc" type="checkbox"><label for="pPisc"><img class="icon" src="images/piscina.svg" alt=""/> Piscina</label></li>
      <li><input id="pIndp" type="checkbox"><label for="pIndp"><img class="icon" src="images/privado.svg" alt=""/> Independiente</label></li>
      <li><input id="pHotal" type="checkbox"><label for="pHotal"><img class="icon" src="images/aire.svg" alt=""/> Hostal</label></li>
      <li><input id="pPlaya" type="checkbox"><label for="pPlaya"><img class="icon" src="images/piscina.svg" alt=""/> En la playa</label></li>
      <li><input id="pLujo" type="checkbox"><label for="pLujo"><img class="icon" src="images/lavadora.svg" alt=""/> De lujo</label></li>
    </ul>
  </div>
  <div class="LstVals">
    <ul>
      <li><label><img class="icon" src="images/mensaje.svg" alt=""/> Baños:</label><input id="pNBanos" value="1" type="number" step="1" min="1"></li>
      <li style="width:210px;"><label><img class="icon" src="images/mensaje.svg" alt=""/> Habitaciones:</label><input id="pNHab" value="1" type="number" step="1" min="1"></li>
      <li class="Red"><label ><img class="icon" src="images/precio.svg" alt=""/>Parqueo:</label><div id="pParq" class="Combo"><span></span></div></li>
    </ul>
  </div>
<!------------------------- Zona para mostrar las fotos ------------------------------->
  <div id="UploadImgs" class="UpSep" style="position:relative;" >
    <div id="CubreFotos" style="position:absolute; left:0; top:0; width:100%; height:100%; z-index:100; display:none;">
      <div style="position:absolute; width:40px; height:40px;"></div>
    </div>
    <h2 class="SubTitle">Fotos 
      <div id="btnSubir" class="BotonM rigth-top"><img src="images/reservar.svg" alt=""/> Subir
        <input id="UpImgCasa" type="file" class="UpInput" title="Imagen alta resilución 640x480 o superior">
      </div>
    </h2>
    <div id="CasaImgs">
    </div>
  </div>

<!-------------------------- Características principales ------------------------------->
  <div class="LstVals aptoFeats UpSep">
    <h2 class="SubTitle">Sobre el apartamento</h2>
    
    <label for="pDescDet" class="lbInput">Descripción detallada de la propiedad*</label>
    <textarea id="pDescDet" rows="10"></textarea>

    <ul>
      <li><label><img class="icon" src="images/favorito.svg" alt=""/> Entrada:</label><div id="pIn" class="Combo thin"><span></span></div></li>
      <li><label><img class="icon" src="images/favorito.svg" alt=""/> Salida:</label><div id="pOut" class="Combo thin"><span></span></div></li>
      
      <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Transfer:   </label><div id="pTranf" class="Combo"><span></span></div></li>
      <li class="Red" style="width:220px;"><label><img class="icon" src="images/precio.svg" alt=""/> Desayuno:   </label><div id="pDesay" class="Combo"><span></span></div></li>
      <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Gastronomia:</label><div id="pGast"  class="Combo"><span></span></div></li>
    </ul>
  </div>
  
<!----------------------------- Facilidades de la casa --------------------------------->
  <div class="LstVals Facilid UpSep">
    <h2 class="SubTitle">Otras facilidades</h2>
    <ul>
      <li><input id="pCalent" type="checkbox"><label for="pCalent">Calentador        </label></li>
      <li><input id="pDiscap" type="checkbox"><label for="pDiscap">Discapacitados    </label></li>
      <li><input id="pCancel" type="checkbox"><label for="pCancel">Cancelar Reserva  </label></li>
      <li><input id="pElev"   type="checkbox"><label for="pElev"  >Elevador          </label></li>
      <li><input id="pACent"  type="checkbox"><label for="pACent" >Aire Central      </label></li>
      <li><input id="pAudio"  type="checkbox"><label for="pAudio" >Sist. de Audio    </label></li>
      <li><input id="pTV"     type="checkbox"><label for="pTV"    >Televisor         </label></li>
      <li><input id="pTelef"  type="checkbox"><label for="pTelef" >Télefono          </label></li>
      <li><input id="pBillar" type="checkbox"><label for="pBillar">Billar            </label></li>
      <li><input id="Wifi"    type="checkbox"><label for="Wifi"   >Wifi              </label></li>
      <li><input id="pRefr"   type="checkbox"><label for="pRefr"  >Refrigerador      </label></li>
      <li><input id="p110v"   type="checkbox"><label for="p110v"  >Enchufe 110v      </label></li>
      <li><input id="p220v"   type="checkbox"><label for="p220v"  >Enchufe 220v      </label></li>
      <li><input id="pBar"    type="checkbox"><label for="pBar"   >Bar               </label></li>
      <li><input id="pLab"    type="checkbox"><label for="pLab"   >Lavadora          </label></li>
      <li><input id="pSLab"   type="checkbox"><label for="pSLab"  >Serv. de lavado   </label></li>
      <li><input id="pSPlanc" type="checkbox"><label for="pSPlanc">Serv. de plachado </label></li>
      <li><input id="pMasj"   type="checkbox"><label for="pMasj"  >Masaje            </label></li>
      <li><input id="pSegd"   type="checkbox"><label for="pSegd"  >Seguridad 24h     </label></li>
      <li><input id="pGimn"   type="checkbox"><label for="pGimn"  >Gimnasio          </label></li>
      <li><input id="pCocina" type="checkbox"><label for="pCocina">Cocina            </label></li>
      <li><input id="pVMar"   type="checkbox"><label for="pVMar"  >Vista al Mar      </label></li>
      <li><input id="pVCiud"  type="checkbox"><label for="pVCiud" >Vista a la Ciudad </label></li>
      <li><input id="pVPanor" type="checkbox"><label for="pVPanor">Vista Panorámica  </label></li>
      <li><input id="pAPrec"  type="checkbox"><label for="pAPrec" >Agua a Presión    </label></li>
      <li><input id="pBAux"   type="checkbox"><label for="pBAux"  >Baño Auxiliar     </label></li>
      <li><input id="pJacuz"  type="checkbox"><label for="pJacuz" >Jacuzzi           </label></li>
      <li><input id="pJard"   type="checkbox"><label for="pJard"  >Jardín            </label></li>
      <li><input id="pRanch"  type="checkbox"><label for="pRanch" >Ranchón           </label></li>
      <li><input id="pParr"   type="checkbox"><label for="pParr"  >Parrilla          </label></li>
      <li><input id="pBalcon" type="checkbox"><label for="pBalcon">Balcón            </label></li>
      <li><input id="pTarrz"  type="checkbox"><label for="pTarrz" >Terraza           </label></li>
      <li><input id="pPatio"  type="checkbox"><label for="pPatio" >Patio             </label></li>
      <li><input id="pAFum"   type="checkbox"><label for="pAFum"  >Área de fumadores </label></li>
      <li><input id="pATrab"  type="checkbox"><label for="pATrab" >Zona de Trabajo   </label></li>
      <li><input id="pSReun"  type="checkbox"><label for="pSReun" >Salón de reuniones</label></li>
    </ul>
  </div>

<!--------------------------  Datos de las habitaciones -------------------------------->
  <div class="Habits UpSep">
    <h2 class="SubTitle">Habitaciones</h2>
    <ul class="Tab">
    </ul>
    <div class="TabContent">
        <div class="CasaDesM">
          <div class="LstVals">
            <ul>
              <li><label>Tipo: </label><div id="hTipo" class="Combo thin"><span></span></div></li>
              <li class="Red"><label><img class="icon" src="images/precio.svg" alt=""/> Precio:</label><div id="hPrec" class="Combo"><span>Precio</span></div></li>
            </ul>
          </div>
               
          <label for="hDesc" class="lbInput">Descripción de la habitación* (hasta 255 caracteres)</label>
          <textarea id="hDesc" maxlength="255" rows="3" cols="255" ></textarea>
    
          <div style="position:relative;" >
            <h2 class="SubTitle">Fotos de la habitación</h2>
            <div class="HabImgs"></div>
          </div>
          
          <div class="LstVals camasIn UpSep">
            <h2 class="SubTitle">Camas</h2>
            <ul>
              <li><label>Camera:    </label><input id="hCCam"   type="number" step="1" min="0"></li>
              <li><label>King Size: </label><input id="hCKing"  type="number" step="1" min="0"></li>
              <li><label>Queen:     </label><input id="hCQueen" type="number" step="1" min="0"></li>
              <li><label>Personal:  </label><input id="hCPers"  type="number" step="1" min="0"></li>
              <li><label>Cuna:      </label><input id="hCCuna"  type="number" step="1" min="0"></li>
              <li><label>Litera:    </label><input id="hCLit"   type="number" step="1" min="0"></li>
            </ul>
          </div>
        </div>
      
      <div class="LstVals Facilid UpSep">
        <h2 class="SubTitle">Facilidades</h2>
        <ul>
          <li><input id="hIndep" type="checkbox"><label for="hIndep">Independiente   </label></li>
          <li><input id="hAire"  type="checkbox"><label for="hAire" >A. Acondicionado</label></li>
          <li><input id="hSplit" type="checkbox"><label for="hSplit">Split           </label></li>
          <li><label>Ventiladores: </label><input id="hVent"  type="number" step="1" min="0"></li>
          <li><input id="hAudio" type="checkbox"><label for="hAudio">Sist. de Audio  </label></li>
          <li><input id="hTV"    type="checkbox"><label for="hTV"   >Televisor       </label></li>
          <li><input id="hTelef" type="checkbox"><label for="hTelef">Teléfono        </label></li>
          <li><input id="hV110"  type="checkbox"><label for="hV110" >Enchufe 110v    </label></li>
          <li><input id="hV220"  type="checkbox"><label for="hV220" >Enchufe 220v    </label></li>
          <li><input id="hMBar"  type="checkbox"><label for="hMBar" >Mini Bar        </label></li>
          <li><input id="hVest"  type="checkbox"><label for="hVest" >Vestidor        </label></li>
          <li><input id="hClos"  type="checkbox"><label for="hClos" >Closet          </label></li>
          <li><input id="hArm"   type="checkbox"><label for="hArm"  >Armario         </label></li>
        </ul>
      </div>

      <div class="LstVals Facilid UpSep">
        <h2 class="SubTitle">Baño</h2>
        
        <label for="hDesc" class="lbInput">Descripción del baño</label>
        <textarea id="bDesc" maxlength="255" rows="2" cols="255" ></textarea>
    
        <ul>
          <li><input id="bDentro" type="checkbox"><label for="bDentro">En la Habitación: </label></li>
          <li><input id="bACal"   type="checkbox"><label for="bACal"  >Agua caliente     </label></li>
          <li><input id="bJacuz"  type="checkbox"><label for="bJacuz" >Jacuzzi:          </label></li>
          <li><input id="bCabin"  type="checkbox"><label for="bCabin" >Cabina de baño:   </label></li>
          <li><input id="bTina"   type="checkbox"><label for="bTina"  >Tina de baño:     </label></li>
          <li><input id="bBidl"   type="checkbox"><label for="bBidl"  >Bidel:            </label></li>
          <li><input id="bSecd"   type="checkbox"><label for="bSecd"  >Secadora de pelo: </label></li>
          <li><input id="bDisc"   type="checkbox"><label for="bDisc"  >Discapacitados:   </label></li>
        </ul>
      </div>

    </div>
  </div>
  
<!------------------------------- Datos de la cocina ----------------------------------->
  <div id="CocDatos" class="LstVals Facilid UpSep">
    <h2 class="SubTitle">Cocina</h2>
    
    <label for="cDesc" class="lbInput">Descripción de la cocina*</label>
    <textarea id="cDesc" maxlength="255" rows="2"></textarea>

    <ul>
      <li><input id="cMWave"  type="checkbox"><label for="cMWave" >Horno Microwave </label></li>
      <li><input id="cBatd"   type="checkbox"><label for="cBatd"  >Batidora        </label></li>
      <li><input id="cCaft"   type="checkbox"><label for="cCaft"  >Cafetera        </label></li>
      <li><input id="cRefr"   type="checkbox"><label for="cRefr"  >Refrigerador    </label></li>
      <li><input id="cHGas"   type="checkbox"><label for="cHGas"  >Horno de gas    </label></li>
      <li><input id="cHElect" type="checkbox"><label for="cHElect">Horno eléctrico </label></li>
      <li><input id="cOArroc" type="checkbox"><label for="cOArroc">Olla arrocera   </label></li>
      <li><input id="cOPrec"  type="checkbox"><label for="cOPrec" >Olla de preción </label></li>
      <li><input id="cFAgua"  type="checkbox"><label for="cFAgua" >Filtro de agua  </label></li>
      <li><input id="cVagill" type="checkbox"><label for="cVagill">Juego de Vajilla</label></li>
      <li><input id="cMesa"   type="checkbox"><label for="cMesa"  >Mesa            </label></li>
      <li><input id="cNevera" type="checkbox"><label for="cNevera">Nevera          </label></li>
    </ul>
  </div>
  
  <div class="UpSep">  
    <div class="block50">  
      <div id="btnGuardar" class="BotonG center"><img src="images/reservar.svg" alt=""/> Guardar</div>
    </div>
    <div class="block50">  
      <div id="btnPublicar" class="BotonG center"><img src="images/reservar.svg" alt=""/> Publicar</div>
    </div>
  </div>

  <div style="display:<?= isset($AutoLogueo)?'block':'none'?>">  
    <input id="pActive" type="checkbox"><label for="pActive" >Activa para reservar</label>
  </div>
</form>

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

<!-- Cuadro de selección de la localidad -->
<div id="LocBox">
  <div class="Left">
    <div class="item select">...</div>
  </div>
  <div class="Rigth"> 
    <div class="item">...</div>
   </div>
</div>

<!-- Cuadro para seleccion del precio -->
<div id="cbSelPrecio">
  <div class="Hover prec">&bull; Valor definido
    <div><img class="icon" src="images/precio.svg" alt=""/> <input type="number" step="5" min="5"> CUC</div>  
  </div>
  <div class="Hover Incld">&bull; Incluido</div>
  <div class="Hover Negoc">&bull; Negociable</div>
  <div class="Hover NoDisp">&bull; No Disponible</div>
</div>

</div>

<!------------------------------------------------------------------------------------------------>
<!-- CODIGO JAVASCRIPT  -->
<!------------------------------------------------------------------------------------------------>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/BookingHav.js"></script>
<script src="js/CasaEdit.js"></script>

<script type="text/javascript">
var Casa = <?= $Data?>;

<?php if( isset($AutoLogueo) ) 
  {?>
  sessionStorage.User = JSON.stringify( { Id:Casa.Id, Nombre:"Admin", Propietario:1, casa:Casa.pProp, loc:Casa.pLoc } ); <?php
  } ?>

$(function() 
  {
  if( !sessionStorage.User )
    {
    alert("El usuario no esta logueado");  
    window.location = "<?=SITE_URL?>Index.html";
    return;
    }
  
  if( !CheckData(Casa) )
    { window.location = "<?=SITE_URL?>Index.html"; return; }
    
  IdCasa = Casa.Id;  
  localStorage.LastCasa = IdCasa;
  
  InitPage();
  
  Menu.ChangeUser = function() 
    {
    var User = GetLogUser();
    
    if( User.casa )
      window.location = GetCasaLnk( User.Id, User.loc, User.casa, "modificar/" );
    else
      window.location = "<?=SITE_URL?>Index.html";
    }
  });

</script>'  

</body>
</html>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<title>Listado de Casas</title>

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
    
<!--------------------------------------- Zona para filtrar -------------------------------------->
<div class="FilterBox"> </div>
<div class="FilterMain FilterBox FilterFloat" id="FloatBox">
  <h1> Directorio de casas particulares.</h1>
  <div class="Data">
    <div id="selLoc"   class="ComboFilter"><span>Localidad</span></div>
    <div id="selPrec"  class="ComboFilter"><span>Precio</span></div>
    <div id="selHabts" class="ComboFilter"><span>Habitaciones</span></div>
    <div id="selOtros" class="ComboFilter">Características <b></b></div>
    <div class="btnBuscar"  >Buscar </div>
  </div>
  <div id="FilterFav" class="Favoritos"> 
    <div class="Item" onClick="ClickLink(1);">• Favoritas </div> 
    <div class="Item" onClick="ClickLink(2);">• Casa con piscina</div>
    <div class="Item" onClick="ClickLink(3);">• Casas de lujo</div> 
    <div class="Item" onClick="ClickLink(4);">• Hostales</div> 
    <div class="Item" onClick="ClickLink(5);">• Casas en la playa</div> 
    <div class="Item" onClick="ClickLink(6);">• Económicas </div> 
   </div>
</div>

<!--<div id="MsgIn"></div>
<div id="MsgOut"></div>
-->
<!--------------------------------------- Listado de Casas  -------------------------------------->
<div id="frmCasas">
  <div id="casasHrd">
    <label id="lbOrden"> Ordenar por:</label> <span id="btnOrden"> Sin orden </span> 
    <span class="lstType right-bottom">
      <img id="btnLista" src="images/Lista2.svg" alt=""/>
      <img id="btnGrid" src="images/Mosaico1.svg" alt=""/>
    </span>
  </div>
  <div id="ListCasas">
  </div>
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
      <div class="text">Calle Calle Linea entre 8 y 10</div>
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
<!-- Cuadro de features de la habitación -->
<div id="BoxOtros" >
  <div class="chkItem"><input type="checkbox"><img src="images/aire.svg" alt="" /><span>A. Acondicionado</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/piscina.svg" alt="" /><span>Piscina</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/lavadora.svg" alt="" /><span>Lavadora</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/privado.svg" alt="" /><span>Independiente</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/lavadora.svg" alt="" /><span>De lujo</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/aire.svg" alt="" /><span>Hostal</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/piscina.svg" alt="" /><span>En la playa</span></div>
  <div class="chkItem"><input type="checkbox"><img src="images/piscina.svg" alt="" /><span>Favoritas</span></div>
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

<!-- Cuadro de selección del rango de precios -->
<div id="PrecioBox">
  <label>Precios menor a:</label>
    <div class="RangeFix">
      <label max="25"><input type="radio" name="prec"><span>25 CUC</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <label max="35"><input type="radio" name="prec"><span>35 CUC</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <label max="40"><input type="radio" name="prec"><span>40 CUC</span></label>
    </div>
  
  <label>Precios mayor a:</label>
    <div class="RangeFix">
      <label min="50"><input type="radio" name="prec"><span>50 CUC</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <label min="80"><input type="radio" name="prec"><span>80 CUC</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <label min="100"><input type="radio" name="prec"><span>100 CUC</span></label>
    </div>
  <div id="RangeBox">
    <label id="LabelLeft"></label>
    <div class="Bar"></div>
    <div id="PointerLeft" class="Pointer">
      <img src="images/Pointer.png" alt=""/>
    </div>
    <div id="PointerRight" class="Pointer">
      <img src="images/Pointer.png" alt=""/>
    </div>

  </div>
</div>

<!-- Cuadro de selección de las habitaciones -->
<div id="HabitsBox">
  <div class="NumHab"><label class="chk"><input id="chk1" type="checkbox">Número de habitaciones</label>
    <div class="n-hab">
      <label class="hab">Desde: </label><input id="Min" type="number" name="Hab"> Hab.
    </div>
    <div class="n-hab">
      <label class="hab">Hasta: </label><input id="Max" type="number" name="Hab"> Hab.
    </div>
  </div>

  <div><label class="chk"><input id="chk2" type="checkbox">Toda la casa</label></div>
  <div><label class="chk"><input id="chk3" type="checkbox">Pago mensual</label></div>
  <div class="Estud"><label class="chk"><input id="chk4" type="checkbox">Para estudiante</label></div>
</div>

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

<br/>
<br/>
<br/>

<!------------------------------------------------------------------------------------------------>
<!-- CODIGO JAVASCRIPT  -->
<!------------------------------------------------------------------------------------------------>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/BookingHav.js"></script>

<script type="text/javascript">

var Menu, floatBox, FilterFav;
var cbOrden;
var showMode=0, btnList, btnGrid;
var DwLoadCasas = null, Timer;
var casas = [], nCasas = 0;
var FInfo, lstFilt;

// Inicia manipuladores y variables, después de cargarse la página
$(function() 
  {
  Menu = new MainMenu(); 
  FInfo = new FilterInfo();
      
  floatBox = $("#FloatBox");
  FilterFav = $("#FilterFav");
  
  $(window).scroll( OnScroll );
  
  var LstOden = [ "Sin Ordenar", "Puntuación", "Precios menores", "Precios mayores", "Nombre propiedad", "Num. de habitaciones"];
  cbOrden  = new PopUp( "#btnOrden", {right:1, wBtn:1} ); 
  cbOrden.BoxFromList( LstOden, true, OnOrdenaCasa );
  
  if( !localStorage.Orden ) localStorage.Orden = 1;
  cbOrden.SetSelItem( localStorage.Orden );
  
  btnList = $("#btnLista")
  btnList.click( showModeToList );
  
  btnGrid = $("#btnGrid")
  btnGrid.click( showModeToGrid );
  btnGrid.css("cursor", "pointer");
  
  $(".btnBuscar").click( OnBuscarCasas );
  
  DescargarCasas();
  });

// Atiende el boton de buscar casas 
function OnBuscarCasas()
  {
  FInfo.Save();  
  
  nowFilt = GetFiterData();

  var url = "";
  if( lstFilt )
    {
    if( nowFilt.Pisc != lstFilt.Pisc && nowFilt.Pisc>0 )
      { 
      url = "casas-particulares-con-piscina.php"; 
      }
    else if( nowFilt.Loc != lstFilt.Loc && nowFilt.Loc.length===2 )
      {
      url = "casas-particulares-en-" + GetLocalidad(nowFilt.Loc).replace( / /g, "-").toLowerCase() + ".php";  
      }
    else if( nowFilt.Prov != lstFilt.Prov && nowFilt.Loc.length===0 )
      {
      url = "casas-particulares-en-" + GetProvincia(nowFilt.Prov).replace( / /g, "-").toLowerCase() + ".php";  
      }
    }
  
  if( url.length>0 ) window.location = url;
  else               DescargarCasas();
  }

// Atiende uno delo enlaces directos de buscar casa 
function GetFiterData()
  {
  var ret = JSON.parse(localStorage.FInfo);  
  return {Loc:ret.Loc||"", Prov:ret.Prov||-1, Pisc:ret.ft[1]};
  }
 
// Atiende uno delo enlaces directos de buscar casa 
function ClickLink( nLnk )
  {
  FInfo.GoFavLink( nLnk );  
  }
 
// Monitorea el scroll, para dejar los filtros fijo en la parte de arriba de la página
function OnScroll()
  {
  var float = floatBox.attr("style");
  var offy = $(document).scrollTop();
  var wDoc = $(document).width();
  if( offy>130 && wDoc>767)
    {
    if( !float ) 
      {
      floatBox.css( {position:'fixed', top:-55, height:115, 'z-index':'5000' } );  
      FilterFav.css( {display:"none"} );
      }
    }
  else
    {
    if( float ) 
      {
      floatBox.removeAttr("style"); 
      FilterFav.removeAttr("style"); 
      }
    }
  }

// Obtiene el código HTML necesario para mostrar una casa 
function getHtmlHomeBox( idx )
  {
  var cs = casas[idx];
  
  var htPut = "", htPisc="", htAir="", htLab="", htPriv="", htAll="", showPrev="", showNext="";
  for( var i=0; i<cs.pRank; ++i )
    htPut+='<img src="images/StarA.png" alt=""/>';
    
  for( ; i<5; ++i )
    htPut+='<img src="images/StarB.png" alt=""/>';
    
  if( cs.pPisc )
    htPisc = '<div class="Item"><img src="images/piscina.svg" alt="" /><span>Piscina</span></div>';
    
  if( cs.pLab )
    htLab = '<div class="Item"><img src="images/lavadora.svg" alt="" /><span>Lavadora</span></div>';
    
  if( cs.pAire )
    htAir = '<div class="Item"><img src="images/aire.svg" alt="" /><span>A. Acondicionado</span></div>';
    
  if( cs.pIndp )
    htPriv = '<div class="Item"><img src="images/privado.svg" alt="" /><span>Independiente</span></div>';
    
  if( cs.pPrecAll )
    htAll = '<div class="Item"><img src="images/aire.svg" alt="" /><span>Casa completa</span></div>';
    
  var htPrec = ''; 
  if( cs.pPrecHab>0 ) htPrec += 'Hab. ' + cs.pPrecHab + ' CUC';
  if( cs.pPrecAll>0 )
  { 
  if( htPrec.length>0 ) htPrec += ' - ';
  htPrec += 'Casa ' + cs.pPrecAll + ' CUC';
  }
     
  if( cs.img<=0         ) showPrev=' style="display:none"';
  if( cs.img>=cs.nImgs-1 ) showNext=' style="display:none"';
  
  var ht = 
  '<div id="Casa'+idx+'" class="BoxCasa">'+
    '<div class="leftBox">'+
      '<img class="CasaMBox ImgCasa" src="'+ ImgPath(cs) +'" alt=""/>'+
      '<div class="OnImg">'+
        '<div class="Precio left-bottom">'+htPrec+'</div>'+
      '</div>'+
      '<img src="images/Next.png" class="ChgCasa btnPrev" OnClick="OnPrevImg('+idx+');"'+showPrev+'>'+
      '<img src="images/Previous.png" class="ChgCasa btnNext" OnClick="OnNextImg('+idx+');"'+showNext+'>'+
    '</div>'+
    '<div class="rigthBox">'+
      '<div class="hdr">'+
        '<span class="Hover" OnClick="GoToCasa('+idx+');">'+cs.pProp+'</span>'+
        '<div class="Puntos rigth-top">'+
          '<label>Puntuación:&nbsp;</label>'+
            htPut +
          '</div>'+  
      '</div>'+
      '<p>'+ cs.pDesc +'</p>'+         
      '<div class="features" >'+
        htAir + htPisc + htLab + htPriv + htAll +
      '</div>'+
      '<div class="foot">'+
        '<span class="l">Personas:</span><span class="s">Per:</span><span class="m">P:</span><b>'+cs.pNPers+'</b> &nbsp;'+
        '<span class="l">Dormitorios:</span><span class="s">Dor:</span><span class="m">D:</span><b>'+cs.pNHab+'</b> &nbsp;'+
        '<span class="l">Camas:</span><span class="s">Cam:</span><span class="m">C:</span><b>'+cs.pNCamas+'</b> &nbsp;'+
        '<span class="l">Baños:</span><span class="s">Bañ:</span><span class="m">B:</span><b>'+cs.pNBanos+'</b>'+ 
      '</div>'+
      '<div class="GoCasa right-bottom">'+
        '<span class="Reserva Hover" OnClick="GoReserva('+idx+');"><img src="images/reservar.svg" alt=""/><label> Reservar</label></span>'+
        '<span class="SeeMore Hover" OnClick="GoToCasa('+idx+');">Ver más</span>'+
      '</div>'+
    '</div>'+
  '</div>';
  
  return ht;
  }

var lastCasa;     
function GoReserva( idx )
  {
  lastCasa = casas[idx];
  var AllScreen = $('<iframe id="AllScreen" class="AllScreen"></iframe>');

  $("body").append( AllScreen );
  AllScreen.attr( "src", "Reservar.html");
  }

function GetFrameDatos()
  {
  return { Id:lastCasa.Id, pProp:lastCasa.pProp, pLoc:lastCasa.pLoc, pNHab:lastCasa.pNHab };
  }
  
function CloseFrame()
  {
  $("#AllScreen").remove();  
  }
  
function GoToCasa( idx )
  {
  var cs = casas[idx];
  var url = GetCasaLnk( cs.Id, cs.pLoc, cs.pProp, "" );  
  window.open( url, "CasaView"+Date() );
  }
  
// Muestra las casas en forma de regilla (mosaico)  
function showModeToGrid()
  {
  if( showMode == 1 ) return;
  $("#frmCasas").addClass("CasaGrid");  
  
  btnGrid.attr("src","images/Mosaico2.svg");
  btnList.attr("src","images/Lista1.svg");
  
  btnGrid.css("cursor", "default");
  btnList.css("cursor", "pointer");
  
  showMode = 1;
  }

// Muestra las casas en forma de lista  
function showModeToList()
  {
  if( showMode == 0 ) return; 
  $("#frmCasas").removeClass("CasaGrid");  
  
  btnGrid.attr("src","images/Mosaico1.svg");
  btnList.attr("src","images/Lista2.svg");
  
  btnGrid.css("cursor", "pointer");
  btnList.css("cursor", "default");
  
  showMode = 0;
  }
  
// Ordena las casas de acuerdo al idx                
function OnOrdenaCasa( idx )
  {
  localStorage.Orden = idx;
  
  FInfo.Save();  
  DescargarCasas();
  }

// Muestra todas las casas en la lista de casas
function ShowCasas()
  {
  var html = "";
  for( var i=0; i<casas.length; ++i  )
    html += getHtmlHomeBox( i );
    
  $("#ListCasas").html( html );
  }  
  
// Pasa a la imagen previa de la casa  
function OnPrevImg( idx )
  {
  var cs = casas[idx];
  var n = cs.img - 1;
  if( n<0 ) return;
    
  cs.img = n;
  CheckBtns( cs, idx );
  ChangeCasaImg( idx, true );
  }

// Pasa a la proxima imagen de la casa  
function OnNextImg( idx )
  {
  var cs = casas[idx];
  var n = cs.img + 1;
  if( n>=cs.nImgs ) return;

  cs.img = n;
  CheckBtns( cs, idx );
  ChangeCasaImg( idx, false );
  }
  
//Chequea los botones para cambiar imagen, solo muestra el que es necesario
function CheckBtns( cs, idx )
  {
  var shwPrev = ( cs.img<=0         )? "none" : "block";
  var shwNext = ( cs.img>=cs.nImgs-1 )? "none" : "block";
    
  $("#Casa"+idx+" .btnPrev").css("display", shwPrev);
  $("#Casa"+idx+" .btnNext").css("display", shwNext);
  }

//Cambia animado de la imagen de la casa (hacia la derecha o hacia la izquierda) 
function ChangeCasaImg( idx , toRight )
  {
  var    Box  = $( "#Casa"+idx+" .leftBox" );
  var ImgOld  = Box.find(".ImgCasa");
  
  var ImgName = ImgPath( casas[idx] );
  var ImgNew  = $('<img src="'+ ImgName +'" class="CasaMBox ImgCasa">');
  
  Box.append(ImgNew);
  
  var w = ImgNew.width();  
  if( toRight ) w = -w;
  
  ImgNew.css( {position:'absolute', top:0, left:w} );
  
  ImgNew.animate({left:0},300,function()
    {
    ImgOld.remove();
    ImgNew.css( {position:'relative'} );
    });
    
  }

// Muestra un cursor de espera, para cargar información de las casas
function ShowWait()
  {
  DwLoadCasas = true;
  
  var htm = '<div id="waiting" class="wait-in BoxCasa">'+
              '<div class="leftBox"></div>'+
              '<div class="rigthBox"></div>'+
              '<img src="images/wait-cur.gif" alt="" class="wait-cursor"/>'+
            '</div>';
            
  $("#ListCasas").append( htm ); 
  }
  
function HideWait()
  {
  $("#waiting").remove();
  DwLoadCasas = false;
  }
  
// Descarga las primeras casas disponibles
function DescargarCasas()
  {
  $("#ListCasas").html( "" );
  casas.length = 0;
  nCasas = 0;
  
  HideWait();
  DescargarMasCasas();
  }
  
// Si esta en la parte de abajo de la lista de casas, manda a bajar más
function CheckForDownload( arg ) 
  { 
  var offy = $(document).scrollTop();
  var yLast = $("#PageFooter").position().top; 
  var h = window.innerHeight;
  
  if( yLast>offy && yLast<offy+h )
    DescargarMasCasas();
  }

// Manda a pedir mas casas al servidor
function DescargarMasCasas()
  {
  if( DwLoadCasas ) return;
  clearInterval( Timer );
  
  ShowWait();
  
  var Ini = casas.length;
  var sData = encodeURIComponent(localStorage.FInfo);
  var Order = cbOrden.idxSel;
  var Data = 'FData='+ sData +'&Ini='+Ini +'&Orden='+Order;
  
  //$("#MsgIn").text(localStorage.FInfo);
  
  $.ajax({ url: "FilterCasas.php", data: Data, type:"POST",
    complete: function( xhr )
      { 
      HideWait();
       
      lstFilt = GetFiterData();
      checkReturn( xhr, function( retCasas )
        {
        if( Ini==0 )
          nCasas = retCasas.nCasas;
          
        retCasas = retCasas.Casas;
        for(var i=0; i<retCasas.length; ++i )
          {
          var idx = i+Ini;  
          casas[idx] = retCasas[i];
          
          var htm = getHtmlHomeBox( idx )
          $("#ListCasas").append( htm ); 
          }
        });
        
      if( casas.length < nCasas )
        Timer = setInterval( CheckForDownload, 3000 );
      }
    });
  }
</script>  

</body>
</html>

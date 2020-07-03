var msgErrors = [ "", "La imagen excede el tamaño máximo permitido. Recomendamos que sean de un tamaño 800 x 600 px.",
"El fichero a subir excede el máximo permitido por el formulario HTML.",
"El fichero solo se subio parcialmente.",
"No se ha seleccionado una imagen para publicar.",
"No se pudo mover el ficheros subido al directorio de la aplicación",
"No hay un directorio temporar para guardar el fichero.",
"El fichero no puede ser guardado en el disco.",
"La carga del fichero fue interrunpida.",
"No se pudo crear el directorio en el servidor.",
"Se debe suministrar un usuario.",
"El usuario no esta logueado.",
"No se pudo abrir la base de datos.",
"Error de sintaxis en los datos retornados del servidor.",
"Error al leer el fichero de imagen.",
"Falta nombre del fichero.",
"No se pudo completar satifactoriamente la solicitud al servidor.",
"Los datos suministrado son erroneos.",
"Error al consultar la base de datos.",
"La propiedad solicitada no esta disponible.",
"Para acceder a la casas favoritas, el usuario debe estar logueado.",
"No se encontro la casa.",
];

var reMail = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i;

// Obtine los datos del usuario logueado, u objeto vacio
function GetLogUser()
  {
  "use strict";  
  if( sessionStorage.User ) 
    {
    var user = JSON.parse(sessionStorage.User);  
    user.Id = +user.Id;
    user.Propietario = +user.Propietario;
    return user;
    }
    
  return {};
  }
  
function EditCasa()
  {
  "use strict";  
  var User = GetLogUser();
  
  if( !User.Id || !User.Propietario )
    {
    alert("Para poder inscribir una propiedad hay que estar registrado como propietario");
    }
  else 
    {
    window.location = GetCasaLnk( User.Id, User.loc, User.casa, "modificar/" );
    }  
  }

// Obtiene el link a una casa
function GetCasaLnk( Id, CodLoc, csName, sifix )
  {
  "use strict";  
  var path = "casa-particular-en-";
  var Loc = GetLocalidad( CodLoc );
  if( Loc.length > 0 ) 
    { path += Loc.replace( / /g, "-").toLowerCase(); }
  else
    { path += "cuba"; }
 
  if( !csName ) {csName = "Nueva";}
  var Nombre = csName.replace( / /g, "-").toLowerCase();       
  return path + "/" + Nombre +"/"  + sifix + Id;
  }

// Chequea que el retorno desde Ajax es corecto
function checkReturn( xhr, fn )
  {
  "use strict";  
  if( xhr.readyState === 4 ) 
    {
    var ret = {error:16};  
    if( xhr.status === 200 ) 
      {
      ret = {error:13};  
      try { ret = JSON.parse(xhr.responseText); }
      catch (e){}

      if( !ret.error ) { if(fn){fn(ret);} return true;} 
      } 
      
    var msg = msgErrors[ ret.error ];
    if( ret.msg ) {msg += "\n\r" +ret.msg;}
    alert( msg );
    } 
  }

// Chequea los datos retornados del servidor
function CheckData( data )
  {
  "use strict";  
  if( !data.error ) { return true;} 
      
  var msg = msgErrors[ data.error ];
  if( data.msg ) {msg += "\n\r" +data.msg;}
  
  alert( msg );
  return false;
  }

// Obtiene a una imagen
function ImgPath( cs, tm, num )
  {
  "use strict";  
  var dir = "Casas" + ((tm)? tm: "M");
  var idx = (num>=0)? num : cs.img;
  return dir+"/"+cs.Id+"/"+cs.iNames+idx+".jpg";
  }

// Retorna el texto del precio que se muestra al usuario  
function PrecioText( v )  
  {
  "use strict";  
  if(v>0   ) {return v + " CUC";  }
  if(v===-2) {return "Incluido";  }
  if(v===-1) {return "Negociable";}
  if(v===0 ) {return "No Disp.";  }
  
  return "¿Precio?";
  }

var Horas = [ "11 AM", "12 PM", "1 PM", "2 PM", "3 PM", "4 PM", "5 PM", "6 PM", "Flexible" ];
// Retorna el texto de un codigo de hora  
function HoraText( v )  
  {
  "use strict";  
  if(v<0 || v >= Horas.length ) {return "No Defin.";}
  
  return Horas[v];
  }

// Retorna el nombre de un mes  
var Meses = [ "Enero", "Febrero", "Marzo", "Abrir", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
function MesText( v )  
  {
  "use strict";  
  if(v<0 || v >= Meses.length ) {return "No Defin.";}
  
  return Meses[v];
  }
  
var _PopUp;
var _NoHide;
// Clase para manejar los recuadros flotantes
function PopUp( clickElem, opciones )
  {
  "use strict";  
  var box;
  var clkElem = $(clickElem);
  var posElem = clkElem;
  var opt = opciones || {};
  var $this = this;
  var frm = $("body");  
  var Slide = opt.Slide;
  var mvBox = true;
  var isCb = false;
  var callFn = null;
  
  var pos = clkElem.css( "position" );
  if( pos!=="absolute" && pos!=="relative" )
    {clkElem.css( "position", "relative" );}
    
  {clkElem.css( "cursor", "pointer" );}
  
  if( opt.NoClick!==1 ) {clkElem.click( ShowPopup );}
  if( opt.PosElem ) {posElem = $(opt.PosElem);}

  this.idxSel = -1;
  this.OnShowPopUp = null;
  this.OnClosePopUp = null;
  this.OnVisiblePopUp = null;
  this.SetCallBack = function(fn) {callFn=fn;};
  this.GetBox = function(){return box;}; 
  this.Show   = function(){ ShowPopup(); }; 
    
  this.BoxFromList = function( list, cb, CallBack  )
    {
    if( box )  
      {box.removeAttr("style");
       box.remove();}
       
    callFn = CallBack;
    isCb   = cb;
      
    var s = ""; 
    if( opt.w    ) { s = 'width:'+ opt.w +'px; ';}
    if( opt.hMax ) { s+= 'max-height:'+ opt.hMax +'px; overflow-y: auto;';} 
    if( s !== "" ) { s = 'style="'+ s + '"';} 
    
    var html = '<div class="popup" '+ s + '>';
    
    for( var i=0; i<list.length; ++i )
      {
      var str = list[i];  
      html += '<div class="item-pu" item="'+ i +'">'+ str +'</div>';
      }
      
    html += '</div>';
    box = $(html);
    
    box.find(".item-pu").click( SelectedItem );
    };
    
  this.SetBox = function( Box, ClkClose ) 
    {
    box = $(Box);
    if( !ClkClose ) { box.click( function(e){ e.stopPropagation();} ); }
    if( mvBox ) { box.css( {display:'none', position:'absolute'} ); }
    };
    
  this.UseBox = function( Box, Click ) {mvBox=false; this.SetBox(Box,Click);};

  this.SetSelItem = function( iSel )
    { 
    if( !isCb ) {return;} 
    
    var Items = box.find(".item-pu");
    if( iSel<0 || iSel>=Items.length )
      { 
      clkElem.text("");
      this.idxSel = -1;
      }
    else
      { 
      clkElem.text( Items.eq(iSel).text() );
      this.idxSel = iSel;
      }
    };
   
  function ShowPopup( e )
    {
    if( _PopUp )
      {
      if( _PopUp===opt.NoHide ) { _NoHide = _PopUp; }
      else
        {  
        var ret = (_PopUp === $this)? null : ShowPopup;
        return _PopUp.ClosePopUp( e, ret );
        }
      }
 
    if( _NoHide && _NoHide!==opt.NoHide ) { return _NoHide.ClosePopUp( e, ShowPopup ); }
      
    if( opt.SlideRef )
      {
      var ref = $(opt.SlideRef);  
      if( ref.css("display")==="block" ) { Slide=1;}
      else { Slide=0;}
      }
      
    if( !box ) {console.log("No box set"); return;}
    if( !mvBox && !Slide ) {console.log("Only for Slide"); return;}
        
    if( $this.OnShowPopUp ) {$this.OnShowPopUp();}   
    
    if( Slide ) { SlideLeftBox(); }
    else        { PushDownBox(); }
    
    $("html").one("click",$this.ClosePopUp );

    _PopUp = $this;
    
    if(e) {e.stopPropagation();}
    }
     
  this.ClosePopUp = function( e, fn, par )
    {
    if( Slide ) { SlideRightBox(fn, par); }
    else        { PushUpBox(fn, par); }

    if(e) {e.stopPropagation();}
    
    if( $this === _PopUp  ) { _PopUp  = undefined;}
    if( $this === _NoHide ) { _NoHide = undefined;}
    
    if( $this.OnClosePopUp ) {$this.OnClosePopUp();}
    };
    
  function SelectedItem()
    { 
    if( isCb ) 
      {
      clkElem.text( $(this).text() );
      box.find(".item-pu").click( SelectedItem );
      }
      
    $this.idxSel = +$(this).attr("item");

    $this.ClosePopUp( null, callFn, $this.idxSel ); 
    return false;
    }
    
  function PushDownBox()
    {
    clkElem.append( box );
    
    if( opt.wBtn  ) { box.outerWidth( clkElem.outerWidth() ); }
    
    var x = 0;
    var ye = clkElem.outerHeight();
    var wb = box.outerWidth(); 
    var mg = opt.mg || 10;
    var xe = clkElem.offset().left;
    if( opt.right )
      {
      var we = clkElem.outerWidth();
      var xi = xe - (wb - we) - mg;
      if( xi<0 ) {x = (xe+we)-(mg+wb);}
      
      box.css( "right", x );
      }
    else
      {
      var W = $("body").outerWidth();
      var xf = xe + wb + mg;
      
      if( xf>W ) { x = -(xf-W); }
      box.css( "left", x );
      }
    
    box.css( "top", ye );
  
    box.slideDown( 200, function()
      { 
      if( $this.OnVisiblePopUp ) {$this.OnVisiblePopUp();}
      });
    }    

  function PushUpBox( fn, par )
    {
    if( !box ) {return;}  
    box.slideUp(200, function()
      { 
      if( mvBox ) {$("#HidedBoxs").append( box );}
      else        {box.removeAttr("style");}
      
      if( fn ) {fn(par);}
      });
    }  

  var xi;   
  function SlideLeftBox()
    {
    if( mvBox ) {frm.append( box );} 
    
    var pos = posElem.offset();
    if( opt.Up ) { window.scroll({top:pos.top}); }
    
    pos.top += posElem.height();
    pos.left  = frm.width() + 10;
    
    box.css( {display:"block"} );
    frm.css( "overflow-x","hidden" );
    box.offset( pos );  
    
    xi = box.position().left;
    var mg = opt.mg || 15;
    var w = box.outerWidth(); 
    var xf = xi - ( 10 + w + mg );
    
    box.animate( {left: xf}, 500, function(){frm.css( "overflow-x","visible" );} );
    }
      
  function SlideRightBox( fn, par )
    {
    if( !box ) {return;}  
    frm.css( "overflow-x","hidden" );
    box.animate( {left: xi}, 500, function()
      { 
      if( mvBox ) {$("#HidedBoxs").append( box );} 
      else        {box.removeAttr("style");}
      
      frm.css( "overflow-x","visible" );
      
      if( fn ) {fn(par);}
      });
    }  

  }

// Clase para manejar la selección del rango de precios
function PrecioRange()
  {
  "use strict";  
  var d = document;  
  var CurLeft  = d.getElementById("PointerLeft");
  var CurRight = d.getElementById("PointerRight");
  var lbLeft   = d.getElementById("LabelLeft");    
  var bar = d.getElementsByClassName("Bar").item(0);
  
  var dtImgLeft  = 40;
  var dtImgRight = 10;
  var IsInit = false, xi=0, xf=261;
  
  var xLeft, xRight, xMouse, xDelta, PrecMin, PrecMax;
  var $this = this;
  this.ShowPrecio = null;

  this.GetPrecMin = function() { return PrecMin;};
  this.GetPrecMax = function() { return PrecMax;};

  // Inicializa para metros de la clase la primera vez visible  
  this.Init = function()
    {
    if( IsInit ) {return;}
    
    xi = bar.offsetLeft;
    xf = xi + bar.offsetWidth-1;
  
    this.SetRange( PrecMin, PrecMax );
    
    AddHandle( CurLeft, "mousedown", IniDragLeft, false );
    AddHandle( CurRight, "mousedown", IniDragRight, false );
    
    IsInit = true;
    };
  
  // Pone el rango de precios solicitado
  this.SetRange = function( Min, Max )
    {
    var xMin, xMax;  
    if( !Min ) {xMin = xi;}
    else       {xMin = (Min*(xf-xi) + 150*xi) / 150;}
    
    if( !Max ) {xMax = xf;}
    else       {xMax = (Max*(xf-xi) + 150*xi) / 150;}
    
    if( xMax < xMin+20 ) {xMax = xMin+20;} 
    if( xMax>xf ) { xMax=xf; }
    if( xMin<xi ) { xMin=xi; }
      
    SetLeftPos( xMin );  
    SetRightPos( xMax );  
    };
  
  // Pone el handle 'fn' para el evento 'sEvent' en el elemento 'elem'  
  function AddHandle( elem, sEvent, fn, capture )
    {
    if( document.addEventListener )                   // Registra eventos para browses standar
      {  
      if( capture ) {elem = document;}
      elem.addEventListener( sEvent, fn, capture );
      }
    else if( document.attachEvent )                   // Registra eventos para IE 5-8
      {  
      if( capture )
        {
        elem.setCapture();
        elem.attachEvent("onlosecapture", fn);
        }
      elem.attachEvent( sEvent, fn );
      }
    }
  
  // Quita el handle 'fn' para el evento 'sEvent' en el elemento 'elem'  
  function RemoveHandle( elem, sEvent, fn, capture )
    {
    if( document.removeEventListener ) 
      {  // DOM event model
      if( capture ) {elem = document;}
      elem.removeEventListener(sEvent, fn, capture);
      }
    else if (document.detachEvent) 
      {  // IE 5+ Event Model
      elem.detachEvent(sEvent, fn);
      if( capture )
        {
        elem.releaseCapture();
        elem.detachEvent("onlosecapture", fn);
        }
      }
    }
    
  // Return the current scrollbar offsets as the x and y properties of an object
  function getScrollXOffset() 
    {
    var w = window;
    if( w.pageXOffset !== null ) {return w.pageXOffset;} // This works for all browsers except IE versions 8 and before
    
    var d = w.document;                                 // For IE (or any browser) in Standards mode
    if( document.compatMode === "CSS1Compat" )
      {return d.documentElement.scrollLeft;}
    
    return d.body.scrollLeft;                           // For browsers in Quirks mode
    }
  
  // Impide que el evento sea manejado por otros elementos
  function StopEventNav( e ) 
    {
    // El evento no se propaga a otros elementos  
    if( e.stopPropagation ) {e.stopPropagation();}    // Modelo standar
    else                    {e.cancelBubble = true;}  // IE    
    
    // Cancela las acciones por defecto
    if( e.preventDefault ) {e.preventDefault();}      // Modelo standar
    else                   {e.returnValue = false;}   // IE    
    }

  // Desplaza el elemento 'elem' con el mouse
  function IniDragLeft( e ) 
    {
    if( !e ) {e = window.event;}  // IE Event Model
    
    xMouse = e.clientX + getScrollXOffset();   // Posicion inicial del mouse
    xDelta = xMouse - xLeft;                   // Diferencia entre origen y donde se oprimio

    AddHandle( CurLeft, "mousemove", MoveLeft, true );
    AddHandle( CurLeft, "mouseup", UpLeft, true );
    
    StopEventNav( e );
    }

  // Evento para mover el cursor de la izquierda
  function MoveLeft( e )
    {
    if( !e ) {e = window.event;}  // IE Event Model
    
    var x = e.clientX + getScrollXOffset() - xDelta;
    if( x<xi ) {x=xi;}
    if( x > xRight-20 ) {x = xRight-20;}
    
    SetLeftPos( x ); 
    }
  
  // Evento para terminar el movimiento del cursor izquierdo
  function UpLeft( e )
    {
    if( !e ) {e = window.event;}  // IE Event Model
    
    RemoveHandle( CurLeft, "mousemove", MoveLeft, true );
    RemoveHandle( CurLeft, "mouseup", UpLeft, true );
    
    $(".RangeFix input").attr("checked",false);
    StopEventNav( e );
    }
    
  // Desplaza el elemento 'elem' con el mouse
  function IniDragRight( e ) 
    {
    if( !e ) {e = window.event;}  // IE Event Model
    
    xMouse = e.clientX + getScrollXOffset();      // Posicion inicial del mouse
    xDelta = xMouse - xRight;                     // Diferencia entre origen y donde se oprimio
    
    AddHandle( CurRight, "mousemove", MoveRight, true );
    AddHandle( CurRight, "mouseup", UpRight, true );
    
    StopEventNav( e );
    }

  // Evento para mover el cursor de la derecha
  function MoveRight( e )
    {
    var x = e.clientX + getScrollXOffset() - xDelta;
    if( x > xf ) {x = xf;}
    if( x < xLeft+20 ) {x = xLeft+20;}
    
    SetRightPos( x );
    }
  
  // Evento para terminar el movimiento del cursor derecho
  function UpRight( e )
    {
    if( !e ) {e = window.event;}  // IE Event Model
    
    RemoveHandle( CurRight, "mousemove", MoveRight, true );
    RemoveHandle( CurRight, "mouseup", UpRight, true );
    
    $(".RangeFix input").attr("checked",false);
    StopEventNav( e );
    }
  
  // Posiciona el cursor izquierdo en la posición x  
  function SetLeftPos( x )
    {
    if( x === xLeft ) {return;}
     
    xLeft = x;
    CurLeft.style.left = (x-dtImgLeft)+"px"; 
    
    PrecMin = GetPrecio( x );
    ShowPrecioInfo();
    }
    
  // Posiciona el cursor derecho en la posición x  
  function SetRightPos( x )
    {
    if( xRight === x ) {return;}
            
    xRight = x;
    CurRight.style.left = (x-dtImgRight)+"px"; 
    
    PrecMax = GetPrecio( x );
    ShowPrecioInfo();
    }
    
  // Obtiene un precio según la posición x en la barra
  function GetPrecio( x )
    {    
    var prec = (150 * (x-xi)) / (xf-xi);  
    var div = Math.round( prec/5 );
    
    return( div * 5 );
    }
    
  // Pone una cadena con la información de los precios actuales
  function ShowPrecioInfo()
    {    
    var sPrec = "";
    if( PrecMin && PrecMax && PrecMax!==150 ) 
      {
      sPrec = "De " + PrecMin + " a " + PrecMax + " CUC";
      }
    else
      {  
      if( PrecMin ) {sPrec += "Desde " + PrecMin + " CUC";}
      if( PrecMax && PrecMax!==150 ) {sPrec += "Hasta " + PrecMax + " CUC";}
      }
    
    if( sPrec === "" ) {sPrec = "Todos los precios";}
    
    lbLeft.innerHTML = sPrec;
    if( $this.ShowPrecio ) {$this.ShowPrecio.innerHTML = sPrec;}
    }
  }
  
// Datos de las localidades
var LocInfo = 
  [
  {prov:"La Habana", 
    locs:[ {loc:"El Vedado", cod:"H1"},
           {loc:"Habana Vieja", cod:"H2"},
           {loc:"Centro Habana", cod:"H3"},
           {loc:"Miramar", cod:"H4"},
           {loc:"Playa", cod:"H5"},
           {loc:"Playas del Este", cod:"H6"},
           {loc:"Nuevo Vedado", cod:"H7"},
           {loc:"Kholy", cod:"H8"},
           {loc:"Jaimanitas", cod:"H9"},
           {loc:"Santa Fe", cod:"Ha"},
           {loc:"Santo Suarez", cod:"Hb"},
           {loc:"Cogimar", cod:"Hc"},
         ]},  
  {prov:"Pinar del Río", 
    locs:[ {loc:"Ciudad Pinar del Río", cod:"P1"},
           {loc:"Soroa", cod:"P2"},
           {loc:"Viñales", cod:"P3"},
           {loc:"Cayo Jutias", cod:"P4"},
           {loc:"Puerto Esperanza", cod:"P5"},
           {loc:"Sandino", cod:"P6"}
         ]},  
  {prov:"Matanzas", 
    locs:[ {loc:"Ciudad Matanzas", cod:"M1"},
           {loc:"Santa Marta", cod:"M2"},
           {loc:"Playa Varadero", cod:"M3"},
           {loc:"Boca Camarioca", cod:"M4"},
           {loc:"Playa Larga", cod:"M5"},
           {loc:"Playa Girón", cod:"M6"},
           {loc:"Jovellanos", cod:"M7"}
         ]},  
  {prov:"Cienfuegos", 
    locs:[ {loc:"Ciudad Cienfuegos", cod:"C1"},
           {loc:"Punta Gorda", cod:"C2"}
         ]},  
  {prov:"Villa Clara", 
    locs:[ {loc:"Santa Clara", cod:"V1"},
           {loc:"Remedios", cod:"V2"},
           {loc:"Caibarien", cod:"V3"},
         ]}, 
  {prov:"Sancti Spíritus", 
    locs:[ {loc:"Ciudad Sancti Spíritus", cod:"S1"},
           {loc:"Trinidad", cod:"S2"},
           {loc:"Puerto Casilda", cod:"S3"},
           {loc:"Playa La Boca", cod:"S4"},
         ]},  
  {prov:"Holguín", 
    locs:[ {loc:"Ciudad Holguín", cod:"G1"},
           {loc:"Gibara", cod:"G2"},
           {loc:"Guardalavaca", cod:"G3"},
           {loc:"Banes", cod:"G4"},
           {loc:"Cayo Bariay", cod:"G5"}
         ]},  
  {prov:"Otros", 
    locs:[ {loc:"Camagüey", cod:"O1"},
           {loc:"Las Tunas", cod:"O2"},
           {loc:"Puerto Padre", cod:"O3"},
           {loc:"Bayamo", cod:"O4"},
           {loc:"Santiago de Cuba", cod:"O5"},
           {loc:"Guantánamo", cod:"O6"},
           {loc:"Baracoa", cod:"O7"}
         ]}  
  ];

// Obtiene le nombre de una localidad teniendo el código
function GetLocalidad( cod )
  {
  for( var i=0; i<LocInfo.length; ++i )
    {
    var Locs = LocInfo[i].locs;
    for( var j=0; j< Locs.length; ++j )
      {
      if( Locs[j].cod === cod )  
        { return Locs[j].loc; }
      }
    }
    
  return "";
  }
  
// Obtiene le nombre de la provincia teniendo el codigo
function GetProvincia( idx )
  {
  if( idx<0 || idx>=LocInfo.length-1 ) return "cuba";
  return LocInfo[idx].prov;
  }
  
// Clase para manejar la zona de filtrado
function FilterInfo( LocOnly )
  {
  "use strict";  
  var FInfo = {};
  var $this = this;

  /*** FUNCIONES PARA MANEJAR LAS LOCALIDADES ***/
  // Se ejecuta cada vez que se selecciona una provincia
  this.ClickProv = function()
    {
    cbLoc.Prov = +$(this).attr("idx");  
    cbLoc.Loc  = "";
    
    if( !LocOnly ) {$("#selLoc span").text( LocInfo[+cbLoc.Prov].prov );}
    
    SetLocalidad();    
    
    $("#LocBox .Left .select").removeClass("select");
    $(this).addClass("select");
    
    return false;
    };
    
  // Ejecuta cada vez que se selecciona una localidad
  this.ClickLocalidad = function()
    {
    cbLoc.Loc = $(this).attr("cod"); 
    var txt = $(this).text();
    
    cbLoc.ClosePopUp(null, function(){ $("#selLoc span").text(txt); });
    
    return false;
    };
    
  // Actualiza el cuadro de localidades antes de mostrarlo
  this.OnShowLocalidad = function ()
    {
    var iSel = (cbLoc.Prov)? +cbLoc.Prov : 0;
    
    var sLeft = "";
    for( var i=0; i<LocInfo.length; ++i )
      {
      var sSel = (iSel===i)? "  select" : "";  
      sLeft += '<div class="item'+sSel+'" idx="'+i+'">'+LocInfo[i].prov+'</div>';
      }
    
    $("#LocBox .Left").html( sLeft ).find(".item").click( $this.ClickProv );

    SetLocalidad();    
    };
  
  // Llena panel derecho con las localidades correspondiete a la provincia actual
  function SetLocalidad()
    {
    var iSel = (cbLoc.Prov)? +cbLoc.Prov : 0;
    
    var sRight = "";
    var Locs = LocInfo[iSel].locs;
    for( var i=0; i< Locs.length; ++i )
      { sRight += '<div class="item" cod="'+Locs[i].cod+'">'+Locs[i].loc+'</div>'; }
    
    if( LocOnly && iSel===LocInfo.length-1 )
      { sRight += '<div class="item" cod="-1">Otra localidad</div>'; }
    
    $("#LocBox .Rigth").html( sRight ).find(".item").click( $this.ClickLocalidad );
    }

  // Busca el indice a la localidad y a la provincia
  function IndexLoc( codLoc )
    { 
    if( !codLoc || codLoc.length !== 2 ) {return -1;}
    
    for( var i=0; i<LocInfo.length; ++i )
      {
      var Locs = LocInfo[i].locs;
      for( var j=0; j< Locs.length; ++j )
        {
        if( Locs[j].cod === codLoc ) { cbLoc.Prov=i; return j; }
        }
      }
      
    return -1;
    }

  // Pone como seleccionada la localidad y/o provincia dada
  function SetLocCaption( idxPro, codLoc )
    { 
    if( idxPro===undefined && !codLoc ) {return;}
    
    var txt = "";
    if( idxPro>=0 && idxPro<LocInfo.length ) 
      { txt = LocInfo[idxPro].prov; cbLoc.Prov=+idxPro; }
    
    var idxLoc = IndexLoc( codLoc );
    if( idxLoc >= 0 )
      {txt = LocInfo[cbLoc.Prov].locs[idxLoc].loc;}
      
    if( txt !== "")
      {  
      $("#selLoc span").text( txt );
      cbLoc.Loc = codLoc;
      }
    }
      
  this.SetLoc = function( codLoc ){ SetLocCaption( -1, codLoc ); };
  this.GetLoc = function(){ return cbLoc.Loc || ""; };
  this.GetProv = function()
    { 
    IndexLoc( cbLoc.Loc );
    return cbLoc.Prov || -1; 
    };
      
  /*** FUNCIONES PARA MANEJAR LOS PRECIOS ***/
  // Se ejecuta cuando se selecciona un precio
  this.ClickPrecio = function()
    {
    var Min = $(this).attr("min"); 
    var Max = $(this).attr("max"); 

    rgPrecio.SetRange( +Min, +Max);      
    };

  /*** FUNCIONES PARA MANEJAR LA SELECCION DE HABITACIONES ***/
  // Actualiza la información cuando cambia el estado de un checkbox
  this.ClickHabChk = function()
    {
    var n = +($(this).attr("id").charAt(3)); 
    
    if( n===4 && cbHabts.checks[3].checked  ) {cbHabts.checks[2].checked = true;}
    if( n===3 && !cbHabts.checks[2].checked ) {cbHabts.checks[3].checked = false;}
      
    showHabInfo();  
    };
  
  // Se llama cuando cambia el número de habitaciones
  this.ChangeNHab = function()
    {
    cbHabts.checks[0].checked = true;  
    if( $(this).attr("id")==="Min" )
      {$("#Max").val( $(this).val() );}
      
    showHabInfo();  
    };

  // Muestra la información sobre las habitaciones seleccionadas
  function showHabInfo()
    {
    var txt = "";  
    var rg = GetHabRange();
    
    var habs = cbHabts.checks;
    if( habs[1].checked ) { txt = " Casa "; }
    
    if( rg.min>0 ) 
      { 
      txt += rg.min;
      if( rg.max>rg.min ) { txt += "-" + rg.max; }
      if( rg.max===0    ) { txt += "+"; }
      
      txt += " Hab "; 
      }
    
    if( habs[3].checked ) { txt += "Estudiante"; }
    else {
         if( habs[2].checked ) { txt += "Mensual"; }
         }
    
    if( txt === "" ) { txt = "Habitaciones";}  
    
    $("#selHabts span").text( txt );
    }

  // Obtiene el rango en la cantidad de habitaciones
  function GetHabRange()
    {
    if( !cbHabts.checks[0].checked ) {return {min:0, max:0};}
    
    var Min = +cbHabts.Range.eq(0).val();
    var Max = +cbHabts.Range.eq(1).val();
    
    if( Min<=0 ) { Min=1; }
    if( Max<Min && Max!==0 ) { Max=Min; }
    
    return {min:Min, max:Max};
    }

  /*** FUNCIONES PARA MANEJAR CUADRO DE CARACTERISTICAS ***/
  // Se ejcuta cada vez que se chequea una caracteristica
  this.ClickItem = function( e )
    {
    if( e.target.type !== "checkbox" )  
      {
      var chk = this.firstChild;  
      if( chk.checked) {chk.checked = false;}
      else             {chk.checked = true;}  
      }
    
    GetFeatures();
    //return false;
    };

  // Obtiene un arreglo con el estado de las características
  function GetFeatures()
    {
    var n  = 0;  
    var ft = [];
    $("#BoxOtros [type=checkbox]").each( function(idx, elem) 
      {
      if( elem.checked ) {++n; ft[idx]=1;}
      else {ft[idx] = 0;}
      });
    
    ShowFeaturesCount( n );      
    
    return ft;
    }

  // Actualiza las características de acuerdo al los valores del arreglo
  function UpdateFeatures( items )
    {
    var n = 0;  
    if( items ) 
      {
      $("#BoxOtros [type=checkbox]").each( function(idx, elem) 
        {
        if( items[idx]  ) {elem.checked = true; ++n;}
        else              {elem.checked = false;}
        });
      } 
      
    ShowFeaturesCount( n );      
    }

  // Muestra la cantidad de características que estan seleccionadas
  function ShowFeaturesCount( n )
    {
    var txt = "";
    if( n>0 ) {txt = "(" + n +")";}
    $(".Data #selOtros b").text( txt );
    }

  /*** FUNCIONES PARA GUARDAR O ACTUALIZA LOS DATOS DE LOS FILTROS ***/
  this.GoFavLink = function ( n )
    {
    var sLnks = ["en-cuba", "fovoritas", "con-piscina", "de-lujo", "hostales", "en-la-playa", "económicas", "en-la-habana","en-santiago-de-cuba","en-sancti-spiritus","en-pinar-del-río","en-matanzas","en-varadero"];
    
    if( n<0 || n>=sLnks.length ) {n = 0;}
    
    FInfo = {};
    
    FInfo.NHab = {min:0, max:0};
    FInfo.ft = [0,0,0,0,0,0,0,0];
    switch( n ) 
      {
      case 0: break;
      case 1: FInfo.ft[7] = 1; break;
      case 2: FInfo.ft[1] = 1; break;
      case 3: FInfo.ft[4] = 1; break;
      case 4: FInfo.ft[5] = 1; break;
      case 5: FInfo.ft[6] = 1; break;
      case 6: FInfo.precMax = 25; break;
      case 7: FInfo.Prov = 0; break;
      case 8: FInfo.Loc  = "O5"; break;
      case 9: FInfo.Prov  = 5; break;
      case 10: FInfo.Prov  = 1; break;
      case 11: FInfo.Prov  = 2; break;
      case 12: FInfo.Loc  = "M3"; break;
      } 
    
    localStorage.FInfo = JSON.stringify(FInfo);
    window.location = "casas-particulares-" + sLnks[n] + ".php";  
    };

  // Almacena los datos de los filtros en una sesion local
  this.Save = function ( nLink )
    {
    FInfo.Prov = cbLoc.Prov;  
    FInfo.Loc  = cbLoc.Loc;
    
    FInfo.precMax = rgPrecio.GetPrecMax();  
    FInfo.precMin = rgPrecio.GetPrecMin();  
    
    FInfo.NHab = GetHabRange();
    FInfo.Casa = cbHabts.checks[1].checked;  
    FInfo.PMes = cbHabts.checks[2].checked;  
    FInfo.Estd = cbHabts.checks[3].checked;  
    
    FInfo.ft = GetFeatures();

    if( localStorage )
      { localStorage.FInfo = JSON.stringify(FInfo); }
    };
    
  // Actualiza los filtros de acuerdo a los datos de FInfo
  this.UpdateFilters = function ()
    {
    UpdateFeatures( FInfo.ft );
    
    SetLocCaption( FInfo.Prov, FInfo.Loc );
      
    rgPrecio.SetRange( +FInfo.precMin, +FInfo.precMax );  
    
    SetHabtsInfo();
    };

  // Con los datos en FInfo actualiza el cuadro de habitaciones
  function SetHabtsInfo()
    {
    var range = FInfo.NHab;
    
    if( range && range.min > 0 )
      {  
      cbHabts.Range.eq(0).val( range.min ); 
      cbHabts.Range.eq(1).val( range.max );
      
      cbHabts.checks[0].checked = true;  
      }
    else  
      {cbHabts.checks[0].checked = false;}
    
    cbHabts.checks[1].checked = FInfo.Casa;  
    cbHabts.checks[2].checked = FInfo.PMes; 
    
    if( FInfo.PMes ) {cbHabts.checks[3].checked = FInfo.Estd;}
    else             {cbHabts.checks[3].checked = FInfo.Estd;}  
    
    showHabInfo();  
    }
  
  // Inicializa los controles de los filtros
  var parm = (LocOnly)? {right:1,mg:1} : {};
  var cbLoc  = new PopUp( "#selLoc", parm ); 
  cbLoc.SetBox("#LocBox");
  cbLoc.OnShowPopUp = this.OnShowLocalidad;

  if( LocOnly ) {return;}
  
  var cbPrec  = new PopUp( "#selPrec", { } ); 
  cbPrec.SetBox("#PrecioBox");
  
  var cbHabts = new PopUp( "#selHabts", { wBtn:1 } ); 
  cbHabts.SetBox("#HabitsBox");
  cbHabts.checks = $("#HabitsBox .chk input");
  cbHabts.checks.click( this.ClickHabChk );
  cbHabts.Range  = $("#HabitsBox .n-hab input");
  cbHabts.Range.change( this.ChangeNHab );
  cbHabts.Range.keyup( this.ChangeNHab );
  
  var cbOtros = new PopUp( "#selOtros", { right:1 } ); 
  cbOtros.SetBox("#BoxOtros");
  $("#BoxOtros .chkItem").click( this.ClickItem );
  
  var rgPrecio = new PrecioRange();  
  cbPrec.OnVisiblePopUp = function(){ rgPrecio.Init(); };
  rgPrecio.ShowPrecio = $("#selPrec span")[0];
  $(".RangeFix label").click( this.ClickPrecio );
  
  var s;
  if( localStorage ) {s=localStorage.FInfo;}
  if( s ) 
    { 
    FInfo = JSON.parse(s);
    this.UpdateFilters();
    }
}

// Clase para manejar la puntuación 
function Ranking( rk )
  {
  "use strict";  
  var rank = rk;  
  var col = $(".Rank .Color");
  var nVtos = $("#NVotos");
  var Votos = [0,0,0,0,0,0];
  col.width( rk * 20 );  
  var nStart = Math.round(rank);
  var inMsg = false;
  var rkSumary = new PopUp( ".Rank .Back", {right:1,NoClick:1} ); 
  rkSumary.SetBox("#RankSumary");
  
  var $this = this;
  this.RankingChanged = function(){};
  this.SetRanking = function( rk, pnts )
    {
    rank = rk;
    col.width( rank * 20 );  
  
    this.SetNVotos(pnts);  
    };
    
  this.SetNVotos = function( pnts )
    {
    Votos = pnts.split(",");
    var nVotos = 0;
    Votos.forEach( function(x) {nVotos += (+x);} );
    nVtos.text( "("+nVotos+")" );
    };
    
  this.ShowSumary = function()
    {
    rkSumary.Show();
    var box = rkSumary.GetBox();
    
    box.find("#rkPnts0").text( Votos[0] );
    box.find("#rkPnts1").text( Votos[1] );
    box.find("#rkPnts2").text( Votos[2] );
    box.find("#rkPnts3").text( Votos[3] );
    box.find("#rkPnts4").text( Votos[4] );
    box.find("#rkPnts5").text( Votos[5] );
    
    box.find("#rkProm").text( rank );
    };
  
  var img = $(".Rank .Back img");
  img.mouseleave( function()
    {
    if( inMsg ) {return;}  
    col.width( rank * 20 );  
    
    return false;
    });  
  
  img.mousemove( function(e)
    {
    if( inMsg ) {return;}  
    var x = e.offsetX;  
    nStart = Math.round( x/20 );
    
    col.width( nStart * 20 );  
    return false;
    });

  var msg  = new PopUp( ".Rank .Back", {right:1} ); 
  msg.SetBox("#RankMsg");
  msg.OnShowPopUp = function(){
    inMsg = true;
    $("#RankMsg strong").text( nStart );
    };
  
  $("#RankMsg #RankOK").click(function() {
    inMsg = false;
    msg.ClosePopUp( null, function(){ $this.RankingChanged(nStart); } );
    return false;
    });
  
  msg.OnClosePopUp = function(){
    inMsg = false;
    col.width( rank * 20 );  
    };
    
  nVtos.click(function() { $this.ShowSumary(); return false;});  
  }  

// Maneja todas la opciones del menú principal
function MainMenu()
  {
  "use strict";  
  var $this = this;
  this.ChangeUser = function(){};
  this.HideMenu = function(n){ MnuItems.eq(n).hide(); };
      
  var MnuItems = $(".header .menu .item");
   
  MnuItems.eq(0).click( OnHome );  
  
  var btnMenu = new PopUp( ".menu-btn", {Slide:1} );
  btnMenu.UseBox( ".header .menu" );
   
  var mnuLogIn = new PopUp( MnuItems.eq(1), {SlideRef:".menu-btn", PosElem:".menu-btn"} );
  mnuLogIn.SetBox("#BoxUser");
  
  var UserMode = 0;
  UpdateUserInfo();
  
  // Llama cada vez que sale el dialogo de usuario 
  mnuLogIn.OnShowPopUp = function()
    { 
    var User = GetLogUser();
    
    OnSwUser( (User.Id)? 3:0 ); 
    };
  
  // Llama cada vez que el dialogo de usuario se hace visible
  mnuLogIn.OnVisiblePopUp = function() { SetFocus(); };

  // Se llama cuando se va ha loguear un usuario y contrasña
  $("#LogIn .btnRight").click(function() 
    {
    var Msg = $("#LogIn .MsgError");
    Msg.hide();
    
    var UserIn = $("#LogIn input");
    var pwd  = UserIn.eq(1).val();  
    var Data = 'pwd='+encodeURIComponent(pwd);
    
    var info = UserIn.eq(0).val().split("/");
    if( info.length === 1 )
      {  
      if( reMail.test( info[0] ) ) { Data += '&mail='+encodeURIComponent(info[0]);}
      else                         { Data += '&user='+encodeURIComponent(info[0]);}
      }
    else
      {
      Data += '&user='+encodeURIComponent(info[0]) + '&mail='+encodeURIComponent(info[1]);  
      }
    
    $.ajax({ url: "Login.php", data: Data, type:"POST",
         complete: function( xhr )
            { 
            checkReturn( xhr, function( data )
              {
              if( data.login )
                {
                sessionStorage.User = JSON.stringify(data);
                
                mnuLogIn.ClosePopUp(null, function()
                  {
                  OnSwUser(3);
                  $this.ChangeUser();
                  });
                } 
              else
                {
                if( data.NRec )
                  {
                  Msg.html( "Hay más de un usuario con los datos suministrados. <br/><br/><span style='color:#555'>Especifique el usuario y el correo, con el formato siguente: <b>Usuario</b>/<b>Correo</b></span>" );
                  }  
                else if( data.Chk )
                  {
                  Msg.html( "El usuario esta esperando por confirmación. <br/><br/><span style='color:#555'>Oprima <a href=''>aqui</a> para reenviar correo de confirmación</span>" );
                  Msg.find("a").click(function() {return ReEnviaConf(data);} );
                  }
                else
                  {  
                  var sErr = "Usuario y/o Contraseñas incorrecto.";
                  if( data.where ) 
                    {sErr += "<br/><br/><span style='color:#555'>Si olvido la contraseñas, oprima <a href=''>aqui</a> para enviarsela por correo</span>";}
                    
                  Msg.html( sErr );
                  Msg.find("a").click(function() {return EnviaPassWord(data);} );
                  }
                  
                Msg.show();
                }  
              }); 
            }
      });
      
  return false;
  });    

  // Envia la contraseñas por correo
  function EnviaPassWord( data )
    {
    var Data = 'Where='+encodeURIComponent(data.where);
    $.ajax({ url: "EnviaPassWord.php", data: Data, type:"POST",
       complete: function( xhr )
          { 
          checkReturn( xhr, function(){ OnSwUser(5); } ); 
          }
      });
      
    return false;  
    }
    
  // Reenvia correo para activar usuario
  function ReEnviaConf( data )
    {
    var Data = 'IdUser='+encodeURIComponent(data.Id);
    $.ajax({ url: "ReEnviaConf.php", data: Data, type:"POST",
       complete: function( xhr )
          { 
          checkReturn( xhr, function(){ OnSwUser(2); } ); 
          }
      });
      
    return false;  
    }
    
  // Desloguea al usuario actual      
  function OnLogOut()
    {
    $.ajax({ url: "Logout.php", type:"POST",
         complete: function( xhr )
            { 
            if( checkReturn(xhr) )
              {
              mnuLogIn.ClosePopUp( null, function() 
                {
                delete sessionStorage.User;

                UpdateUserInfo();
                $this.ChangeUser();
                });
              }
            }
      });
      
    return false;
    }
   
  // Llena formulario con datos de usuario actual 
  function FillDatos( User )
    {
    var Ctrs = $("#EditUser input");
    
    Ctrs.eq(0).val( User.Correo );
    Ctrs.eq(1).val( User.Nombre);
    
    Ctrs.eq(2).val("");
    Ctrs.eq(3).val("");
    
    if( User.Propietario )
      {
      Ctrs.eq(4).attr( "checked", "true" );
      Ctrs.eq(5).val( User.Telefono );
      }
    else
      {
      Ctrs.eq(4).removeAttr("checked");
      Ctrs.eq(5).hide();
      }
    }
   
  // Obtiene y valida los datos del usuario
  function GetUserData( Msg, box ) 
    {
    Msg.hide();
    
    var mail   = box.eq(0).val();
    var name   = box.eq(1).val();
    var pwd1   = box.eq(2).val();
    var pwd2   = box.eq(3).val();
    var isProp = box[4].checked;
    var telef  = box.eq(5).val();
    
    var reTelf = /^\+?([0-9 \-]{7,}[,; ]*)+$/;
    
    var txt="", foco;
         if( !reMail.test(mail)  ) { txt="El correo es erroneo";            foco = box.eq(0); }
    else if( name.length<3       ) { txt="Falta el nombre del usuario";     foco = box.eq(1); }
    else if( pwd1.length<1       ) { txt="Tiene que poner una contraseñas"; foco = box.eq(2); }
    else if( pwd1 !== pwd2       ) { txt="Las contraseñas no coinciden";    foco = box.eq(3); }
    else if( isProp &&             
             !reTelf.test(telef) ) { txt="El teléfono es erroneo";          foco = box.eq(5); }
      
    if( txt.length>0 ) { Msg.text(txt); Msg.show();  foco.focus(); return false; }
      
    var Data = 'mail='+encodeURIComponent(mail)+'&name='+encodeURIComponent(name)+'&pwd1='+encodeURIComponent(pwd1);
    if( isProp ) {Data +='&telef='+encodeURIComponent(telef);}
    
    return Data;
    }
    
  // Se llama para crear un usuario nuevo
  $("#NewUser .btnRight").click(function() 
    {
    var Msg = $("#NewUser .MsgError");
    
    var Data = GetUserData( Msg, $("#NewUser input") );
    if( !Data ) {return;}
    
    $.ajax({ url: "NewUser.php", data: Data, type:"POST",
       complete: function( xhr )
          { 
          checkReturn( xhr, function( data )
            {
            if( data.nuevo ) { OnSwUser(2); } 
            else
              {
              var sErr = "Ya hay un usuario con ese nombre.";
              Msg.text( sErr );
              Msg.show();
              }  
            }); 
          }
      });

    return false;
    });    

  // Se llama para editar los datos del usuario actual
  $("#EditUser .btnRight").click(function() 
    {
    var Msg = $("#EditUser .MsgError");
    
    var Data = GetUserData( Msg, $("#EditUser input") );
    if( !Data ) {return;}

    var User = GetLogUser();
    if( User.Id ) 
      {
      Data +='&Id='+User.Id;
      }
    else
      {
      Msg.text("Para modificar sus datos, el usuario debe estar logueado."); 
      Msg.show();  
      return false;
      }
    
    $.ajax({ url: "UpdateUser.php", data: Data, type:"POST",
       complete: function( xhr )
          { 
          checkReturn( xhr, function( data )
            {
            if( data.update ) 
              { 
              if( data.validate ) {OnSwUser(2);} 
              else                {OnSwUser(6);} 
              } 
            else
              {
              var sErr = "Ya hay un usuario con ese nombre y correo.";
              Msg.text( sErr );
              Msg.show();
              }  
            }); 
          }
      });

    return false;
    });    

  // Muestra el telefono cuando se marca propietario
  $("#BoxUser .isProp").click(function() 
    {     
    var show = (this.checked)? "block" : "none";  
    var box  = $(this).parent().parent();
    
    box.find(".Telef").css("display",show);
    });    
  
  // Atiende los comados para los dialogos de usuario
  $("#BoxUser .item-pu").click(function() 
    {
    var cmd = +$(this).attr("cmd");
    
    switch( cmd )
      {
      case 1: OnLogOut(0); break;  // Salir
      case 2: OnSwUser(0); break;  // Otro usuario
      case 3: OnSwUser(1); break;  // Usuario nuevo
      case 4: OnSwUser(4); break;  // Modificar usuario
      case 5: EditCasa(); break;  // Editar propiedad
      }
    });  
  
  // Pone el menú de inicio
  $("#BoxUser input").keypress( function(){$("#BoxUser .MsgError").hide();} );

  // Pone el menú de inicio
  $("#BoxUser .btnLeft").click(function() { return OnSwUser(3); });  

  // Cambia el modo de mostrar el dialogo de usuario    
  function OnSwUser( n )
    {
    UserMode = n;
      
    $("#LogIn"      ).css("display",(n===0)? "block" : "none");
    $("#NewUser"    ).css("display",(n===1)? "block" : "none");
    $("#MsgActive"  ).css("display",(n===2)? "block" : "none");
    $("#mnuUser"    ).css("display",(n===3)? "block" : "none");
    $("#EditUser"   ).css("display",(n===4)? "block" : "none");
    $("#MsgPassWord").css("display",(n===5)? "block" : "none");
    $("#MsgUpdate"  ).css("display",(n===6)? "block" : "none");
    
    var User = GetLogUser();
    if( User.Id ) 
      { if( n===4 ) {FillDatos(User);} }
    else  
      { $("#EditUser" ).css("display","none"); }
    
    UpdateUserInfo();
  
    if(n===1) { $("#NewUser .Telef").hide(); $("#NewUser .isProp")[0].checked=false; }
  
    SetFocus();  
    return false;
    }
  
  function SetFocus()
    { 
         if(UserMode===0) {$("#LogIn input").eq(0).focus();}
    else if(UserMode===1) {$("#NewUser input").eq(0).focus();}
    else if(UserMode===4) {$("#EditUser input").eq(0).focus();}
    }

  
  // Actualiza la información sobre el usuario en la página
  function UpdateUserInfo()
    {
    var mnu = $("#mnuUser .item-pu");
    var User = GetLogUser();
    if( User.Id ) 
      {
      $("#User").text( User.Nombre );
      mnu.eq(0).show(); //Salir
      mnu.eq(3).show(); //Modificar
      
      if( User.Propietario ) {mnu.eq(4).show();} else {mnu.eq(4).hide();}
      } 
    else                        
      {
      $("#User").text( "Entrar" );
      mnu.eq(0).hide();
      mnu.eq(3).hide();
      mnu.eq(4).hide();
      }
      
    if( User.casa === undefined ) 
      { 
      $("#lnkEdProp").text("Inscribir"); 
      mnu.eq(4).text("Inscribir propiedad");
      }
    else                      
      { 
      $("#lnkEdProp").text("Modificar"); 
      mnu.eq(4).text("Modificar propiedad");
      }
    }
  
  function OnHome()
    {
    window.location ="index.html";
    }
  
  } // Fin de la clase MainMenu
  


var Menu;
var csRank, csFotos, Habs, cbLoc, UpFoto, UpImg;
var cbPrecHab, cbPrecAll, cbPrc1Mes, cbPrecEst;
var cbPrecHab2, cbPrecAll2, cbPrc1Mes2, cbPrecEst2, cbPrecParq, cbEntrada;
var overFotos, divImgType, cbImgTipos, cbHabTipos, cbPrecHab3, Temps, cbSalida;
var IdCasa, lstImg = 0;

// Inicia manipuladores y variables, después de cargarse la página
function InitPage() 
  {
  Menu = new MainMenu(); 
  cbLoc = new FilterInfo( true );
  
  UpFoto = new UploadImg( "#UpFoto", ".foto", true);  
  UpFoto.ShowImage = function(imgName) {$("#pFoto").attr("src", "fotos/"+imgName);  };
  
  UpImg = new UploadImg( "#UpImgCasa", "#UploadImgs", false);  
  UpImg.ShowImage = AddImage;
  
  cbPrecHab = new SelPrecio( "#pPrecHab", "#cbSelPrecio" );
  cbPrecAll = new SelPrecio( "#pPrecAll", "#cbSelPrecio" );
  cbPrc1Mes = new SelPrecio( "#pPrc1Mes", "#cbSelPrecio" );
  cbPrecEst = new SelPrecio( "#pPrecEst", "#cbSelPrecio" );
  
  cbPrecHab2 = new SelPrecio( "#pPrecHab2", "#cbSelPrecio" );
  cbPrecAll2 = new SelPrecio( "#pPrecAll2", "#cbSelPrecio" );
  cbPrc1Mes2 = new SelPrecio( "#pPrc1Mes2", "#cbSelPrecio" );
  cbPrecEst2 = new SelPrecio( "#pPrecEst2", "#cbSelPrecio" );
  
  cbPrecParq = new SelPrecio( "#pParq", "#cbSelPrecio", {inc:1} );
  
  overFotos = $("#CubreFotos");
  divImgType = overFotos.children().first(); 
  cbImgTipos  = new PopUp( divImgType, {right:1} ); 
  
  var HabTipos = [ "Sencilla", "Doble", "Triple", "Cuádruple" ];
  cbHabTipos = new PopUp( "#hTipo", {} ); 
  cbHabTipos.BoxFromList( HabTipos, true, null );

  cbPrecHab3 = new SelPrecio( "#hPrec", "#cbSelPrecio", {inc:0,disp:0}  );
  
  cbEntrada = new PopUp( "#pIn", {} );
  cbEntrada.BoxFromList( Horas, true, null );
  
  cbSalida = new PopUp( "#pOut", {} );
  cbSalida.BoxFromList( Horas, true, null );

  cbTransfer = new SelPrecio( "#pTranf", "#cbSelPrecio", {inc:1} );
  cbDesayuno = new SelPrecio( "#pDesay", "#cbSelPrecio", {inc:1} );
  cbGastronomia = new SelPrecio( "#pGast", "#cbSelPrecio", {inc:1} );
  
  $("#pCocina").click( function()
    {
    var show = (this.checked)? "block" : "none";  
    $("#CocDatos").css("display",show);
    });
  
  Temps = new Temporadas();
  $("#pByTemp").click( SetByTemp );  
  
  $("#btnGuardar").click( function() { SaveCasaDatos(); });
  $("#btnPublicar").click( function() { ValidateDatos(); });
  
  Habs = new MngHabitaciones( Casa );
  $("#pNHab").change(ChangeHabitaciones);
    
  FillCasaDatos();  
  ChangeHabitaciones();
  }

function Temporadas()
  {
  var lbBajaIni = $("#TempBajaIni");
  var lbBajaFin = $("#TempBajaFin");
  
  var cbAltaIni = new PopUp( "#TempAltaIni", {} );     
  cbAltaIni.BoxFromList( Meses, true, onChangeAltaIni );

  var cbAltaFin = new PopUp( "#TempAltaFin", {} );     
  cbAltaFin.BoxFromList( Meses, true, onChangeAltaFin );

  var BIni = 3;
  var BFin = 9;
  var AIni = 10;
  var AFin = 2;
  
  function onChangeAltaIni( idx )
    {
    AIni = idx;  
    AFin = cbAltaFin.idxSel;
    if( AIni === AFin )
      {
      AFin = AIni + 1;
      if( AFin>=11 ) {AFin = 0;}  
      
      cbAltaFin.SetSelItem( AFin );
      }
      
    SetTempBaja( AIni, AFin);  
    }  
  
  function onChangeAltaFin( idx )
    {
    AFin = idx;  
    AIni = cbAltaIni.idxSel;
    if( AFin === AIni )
      {
      AIni = AFin - 1;
      if( AIni<0 ) {AIni = 11;}  
      
      cbAltaIni.SetSelItem( AIni );
      }
      
    SetTempBaja( AIni, AFin);  
    }  
  
  function SetTempBaja( ini, fin )
    {
    BIni = fin+1;
    BFin = ini-1;
    
    if( BIni>11 ) {BIni = 0;}
    if( BFin<0  ) {BFin = 11;}
    
    lbBajaIni.text( Meses[BIni] );
    lbBajaFin.text( Meses[BFin] );
    }
  
  this.SetMesIni = function(idx) { cbAltaIni.SetSelItem(idx); onChangeAltaIni(idx);};
  this.SetMesFin = function(idx) { cbAltaFin.SetSelItem(idx); onChangeAltaFin(idx);};
  
  this.GetMeses = function() { return BIni+','+BFin+','+AIni+','+AFin;};
  }

// Habilita/Deshabilita para entrar los precios por temporadas
function SetByTemp()
  {
  var byTemp = $("#pByTemp")[0].checked
  if( byTemp )
    {
    $("#TempAlta").show();  
    $(".lbTemp").show();  
    }
  else
    {
    $("#TempAlta").hide();  
    $(".lbTemp").hide();
    }  
  }
  
// Se llama cada vez que se cambia el num de habitaciones
function ChangeHabitaciones()
  {
  var num = +$("#pNHab").val();  
  
  Habs.SetNumber(num);
  
  var ImgTipos = [ "Exteriores", "Salones", "Piscina", "Cocina" ];
  for( var i=0; i<num; ++i )
    {ImgTipos[i+4] = "Habitación " + (i+1);}
  
  cbImgTipos.BoxFromList( ImgTipos, false, null );
  }
  
// Dialogo para seleccionar precio
function SelPrecio( idValue, idBox, sw )
  {
  var box = $(idBox).clone();  
  var cbList = new PopUp( idValue, { right:1 } ); 
  cbList.SetBox(box);
  var val = -3;
  
  var sel    = $(idValue+" span");
  var inVal  = box.find("input");
  var Negoc  = box.find(".Negoc");
  var Incld  = box.find(".Incld");
  var NoDisp = box.find(".NoDisp");
  
  if( !sw || !sw.inc    ) {Incld.css( "display", "none" );}
  if( sw && sw.disp===0 ) {NoDisp.css("display", "none" );}
  
  inVal.keypress( function(e) 
    { 
    if( e.keyCode===13 ) { SetValue( +$(this).val() ); cbList.ClosePopUp(); }
    
    var k=e.charCode; 
    return( k<32 || (k>=48 && k<=57) ); 
    });
    
  inVal.change(function(e) { SetValue( +$(this).val() ); }); 
  inVal.keyup(function(e)  { SetValue( +$(this).val() ); }); 
  
  Negoc.click(function(e) { SetValue(-1); cbList.ClosePopUp(); return false; });  
  Incld.click(function(e) { SetValue(-2); cbList.ClosePopUp(); return false; });  
  NoDisp.click(function(e) { SetValue(0); cbList.ClosePopUp(); return false; });  
    
  function SetValue( v )  
    {
    if(val===-3) {sel.removeAttr("style");}
    
    sel.text( PrecioText(v) );
    
    if( v<-2 ) { sel.css("color","#BBB"); v=-3;}
     
    val = v;
    }
    
  this.setVal = function( v ){ SetValue(v);};  
  this.getVal = function(){ return val;};  
  }
  
// Muestra un cursor de espera
var NWait = 0;
function ShowWait( idWait )
  {
  var Id = "Wait" + (NWait++);  
  var htm = '<div id="'+Id+'" class="wait-up">'+
              '<img src="images/wait-cur.gif" alt="" class="wait-cursor" style="width: 32px; height: 32px; margin-left: -16px;"/>'+
            '</div>';
            
  $(idWait).append( htm ); 
  
  this.Hide = function()
    { $('#'+Id).remove(); };
  }

// Clase para manejar los detalles de subir las imagenes  
function UploadImg( idInput, idWait, foto )
  {
  var $this = this;
  var selFile = $(idInput);
  this.ShowImage = function( imgName ){};
  this.CanSelect = function(){ return true; };
  this.ValidateImage = function( img ){ return true; };

  function upload_file( file ) 
    {
    var Wait   = new ShowWait( idWait );
    var imgName = "Casa"+IdCasa+"_"+ (++lstImg) + ".jpg";  
      
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "UploadImage.php");
    xhr.onreadystatechange = function()
      {
      if( xhr.readyState === 4 ) 
        {
        Wait.Hide();  
        if( xhr.status === 200 ) 
          {
          //alert( xhr.responseText ); return;
          var ret;  
          try { ret = FInfo = JSON.parse(xhr.responseText); }
          catch (e){}
          
          if( ret && ret.error===0 )
            { $this.ShowImage( imgName ); }
          else
            { 
            var err = (ret? ret.error : 13);
            alert( msgErrors[ err ] ); 
            }  
          } 
        else
          { alert("Hubo un error al subir la imagen al servidor."); }  
        } 
      };

    var formdata = new FormData();
         
    formdata.append("Image"  , file );
    formdata.append("IdUser" , IdCasa );
    formdata.append("imgName", imgName );
    if( foto ) {formdata.append( "foto", foto );}
      
    xhr.send(formdata);
    }
    
  selFile.change(function(e) 
    {
	  var files = this.files;
  	if( files[0].type.match(/image/) ) 
		  {
      var reader = new FileReader();
      reader.onload = function(e)
        { 
        var img = new Image();
        img.onerror = function() { alert("No se pudo cargar la imagen"); };
        img.onload  = function(e)
          {
          if( $this.ValidateImage( img ) )
            {upload_file( files[0] );}
          };
        
        img.src = e.target.result;
        };
        
      reader.readAsDataURL( files[0] );
      }
    else
      { alert("Debe seleccionar un fichero de imagen"); }  
      
    return false;  
    });
  
  selFile.click(function(e) {
    return $this.CanSelect();
    });
  }

// Adiciona una imagen a la lista de imagenes de la propiedad  
function AddImage( imgName, tHab )
  {
  var stHab = ""  
  if( tHab>0 ) {stHab=' data-thab="'+tHab+'"';}
   
  var html = '<div class="CasaImgBox"'+stHab+'>'+
                '<div class="DelImg"><div class="btnImgType right-bottom"></div><img class="btnDel rigth-top" src="images/Delete.png"/></div>'+  
                '<img src="CasasP/'+IdCasa+'/'+imgName+'" class="CasaImgP">'+  
             '</div>';  
  
  var ImgNew = $(html);
  ImgNew.find(".btnDel"    ).click( DeleteImg );
  ImgNew.find(".btnImgType").click( ClasificaImg );
  
  var Box = $("#CasaImgs");
  Box.append(ImgNew);
  
  var hScrll = Box[0].scrollHeight; 
  var hBox   = Box.outerHeight();
  if( hScrll > hBox)
    { Box.scrollTop( hScrll-hBox ); }
  }

// Borra una imagen de la lista de imagenes de la propiedad
function DeleteImg()
  {
  var elem = $(this).parent().parent();  
  var fileName = elem.find(".CasaImgP").attr("src");
  
  var Data = 'imgName='+fileName+'&IdUser='+IdCasa;
  
  $.ajax({ url: "RemoveImage.php", data: Data, type:"POST",
       complete: function( xhr )
          { if( checkReturn( xhr ) ) {elem.remove(); Habs.UpdateImages();} }
    });
  }
  
// Clasifica la zona de la casa de la imagén
function ClasificaImg()
  {
  overFotos.css( "display", "block" );

  var imgBox = $(this).parent().parent();  
  divImgType.offset( $(this).offset() );
  
  var iSel  = (+imgBox.attr("data-thab"));
  var items = cbImgTipos.GetBox().find(".item-pu");
  
  items.removeClass("selected");
  if( iSel>0 ) {items.eq(iSel-1).addClass("selected");}
  
  cbImgTipos.OnClosePopUp = function(){
    overFotos.css( "display", "none" );
    };

  cbImgTipos.SetCallBack( function(idx){
    var last = (+imgBox.attr("data-thab"))-1;
    imgBox.attr("data-thab", (idx+1) );
    
    var Act = Habs.Active() + 4;
    if( Act===idx || Act===last ) { Habs.UpdateImages(); }
    });

  divImgType.trigger('click');  
  return false;
  }
  
// Pone un DIV que cubre toda la pantalla
function AllScreenCover()
  {
  var w = window.innerWidth;
  var h = window.innerHeight;
  
  this.AllScreen = $('<div id="AllScreen" class="wait-up" style="position:fixed; top:0; left:0; width:'+w+'px; height:'+h+'px; z-index:5000;">'+
                        '<img src="images/wait-cur.gif" alt="" class="wait-cursor" style="width: 32px; height: 32px; margin-left: -16px;"/>'+
                     '</div>');
             
  $("body").append( this.AllScreen );
  
  //this.AllScreen.click( function(e) {$(this).remove(); });
  this.Close = function() { this.AllScreen.remove(); };
  }
  
// Crea un objeto habitación vacio
function EmptyRoom() 
  { 
  this.hDesc=""; this.hTipo=0; this.hPrec=-3; this.hCCam=1; this.hCKing=0; this.hCQueen=0; this.hCPers=0; this.hCCuna=0; this.hCLit=0; this.hIndep=0; 
  this.hAire=0; this.hSplit=0; this.hVent=0; this.hAudio=0; this.hTV=0; this.hTelef=0; this.hV110=0; this.hV220=0; this.hMBar=0; this.hVest=0; 
  this.hClos=0; this.hArm=0; this.bDesc=""; this.bDentro=0; this.bACal=0; this.bJacuz=0; this.bCabin=0; this.bTina=0; this.bBidl=0; this.bSecd=0; this.bDisc=0; 
  }
                       
// Maneja la visualización del los datos de las habitaciones  
function MngHabitaciones( casa )
  {
  if( !casa.Habits ) casa.Habits = [];
  
  var Habs = casa.Habits ;
  var Count = 0;
  var Act  = -1;
  var Hdr  = $(".Tab");
  var Tabs;
  var self = this;

  function DrawTabs()
    {
    var html = "";  
    for( var i=0; i<Count; ++i )  
      {html += '<li idx="'+i+'" class="TabItem Hover'+(i===Act? " Active" : "")+'"><label>Hab. '+ (i+1) +'</label></li>';}
      
    Hdr.html( html );
    
    Tabs = Hdr.find(".TabItem");
    Tabs.click(function(e) {
      var idx = +$(this).attr("idx");
      SelectTab( idx );
      });  
    }

  this.Active = function(){return Act;};
  
  this.SetNumber = function( num )
    {
    if( num>Habs.length ) {Habs.length = num;}
    Count = num;
    
    for( var i=0; i<Count; ++i )
      { if( !Habs[i] ) {Habs[i] = new EmptyRoom();} }
        
    DrawTabs(); 
    if( Act<0      ) { SelectTab( 0 ); }
    if( Act>=Count ) { SelectTab( Count-1 ); }
    };

  this.UpdateImages = function()
    {
    var Imgs = $('#CasaImgs [data-thab='+(Act+5)+']').clone();
    Imgs.find(".DelImg").remove();
    
    $(".HabImgs").empty();
    $(".HabImgs").append(Imgs);
    };

  this.Save = function() 
    {
    SaveHabDatos(Act); 
    Habs.length=Count; 
    };

  this.getCount = function() { return Count; };

  function SelectTab( idx )
    {
    if( Act===idx ) {return true;}
    if( idx<0 || idx>=Habs.length ) {return false;}
    
    Tabs.filter(".Active").removeClass("Active");
    $(Tabs[idx]).addClass("Active");
    
    if( SaveHabDatos( Act ) )
      {
      Act = idx;
      FillHabDatos( idx );
      return true;
      }
      
    return false;  
    }  
    
  function FillHabDatos( idx )
    {
    if( idx<0 || idx>=Habs.length ) {return;}
    
    self.UpdateImages();
    
    var Hab = Habs[idx];
    $("#hDesc").val( Hab.hDesc   );
    
    cbHabTipos.SetSelItem( Hab.hTipo );
    cbPrecHab3.setVal( Hab.hPrec ) ;

    $("#hCCam"  ).val( Hab.hCCam   );
    $("#hCKing" ).val( Hab.hCKing  );
    $("#hCQueen").val( Hab.hCQueen );
    $("#hCPers" ).val( Hab.hCPers  );
    $("#hCCuna" ).val( Hab.hCCuna  );
    $("#hCLit"  ).val( Hab.hCLit   );
       
    $("#hVent"  ).val( Hab.hVent   );
    
    $("#bDesc"  ).val( Hab.bDesc );
    
    SetCheck( "hIndep" , Hab.hIndep);
    SetCheck( "hAire"  , Hab.hAire);
    SetCheck( "hSplit" , Hab.hSplit);

    SetCheck( "hAudio" , Hab.hAudio);
    SetCheck( "hTV"    , Hab.hTV   );
    SetCheck( "hTelef" , Hab.hTelef);
    SetCheck( "hV110"  , Hab.hV110 );
    SetCheck( "hV220"  , Hab.hV220 );
    SetCheck( "hMBar"  , Hab.hMBar );
    SetCheck( "hVest"  , Hab.hVest );
    SetCheck( "hClos"  , Hab.hClos );
    SetCheck( "hArm"   , Hab.hArm  );

    SetCheck( "bDentro", Hab.bDentro);
    SetCheck( "bACal"  , Hab.bACal  );
    SetCheck( "bJacuz" , Hab.bJacuz );
    SetCheck( "bCabin" , Hab.bCabin );
    SetCheck( "bTina"  , Hab.bTina  );
    SetCheck( "bBidl"  , Hab.bBidl  );
    SetCheck( "bSecd"  , Hab.bSecd  );
    SetCheck( "bDisc"  , Hab.bDisc  ); 
    
    }
     
  function SaveHabDatos( idx )
    {
    if( idx<0 || idx>=Habs.length ) {return true;}
    
    var Hab = Habs[idx];
    Hab.hDesc = $("#hDesc").val();

    Hab.hTipo = cbHabTipos.idxSel;
    Hab.hPrec = cbPrecHab3.getVal();

    Hab.hCCam   = +$("#hCCam"  ).val();
    Hab.hCKing  = +$("#hCKing" ).val();
    Hab.hCQueen = +$("#hCQueen").val();
    Hab.hCPers  = +$("#hCPers" ).val();
    Hab.hCCuna  = +$("#hCCuna" ).val();
    Hab.hCLit   = +$("#hCLit"  ).val();
         
    Hab.hVent   = +$("#hVent"  ).val();
       
    Hab.bDesc = $("#bDesc").val();

    Hab.hIndep = IsCheck("hIndep" );
    Hab.hAire  = IsCheck("hAire"  );
    Hab.hSplit = IsCheck("hSplit" );

    Hab.hAudio = IsCheck("hAudio" );
    Hab.hTV    = IsCheck("hTV"    );
    Hab.hTelef = IsCheck("hTelef" );
    Hab.hV110  = IsCheck("hV110"  );
    Hab.hV220  = IsCheck("hV220"  );
    Hab.hMBar  = IsCheck("hMBar"  );
    Hab.hVest  = IsCheck("hVest"  );
    Hab.hClos  = IsCheck("hClos"  );
    Hab.hArm   = IsCheck("hArm"   );

    Hab.bDentro= IsCheck("bDentro");
    Hab.bACal  = IsCheck("bACal"  );
    Hab.bJacuz = IsCheck("bJacuz" );
    Hab.bCabin = IsCheck("bCabin" );
    Hab.bTina  = IsCheck("bTina"  );
    Hab.bBidl  = IsCheck("bBidl"  );
    Hab.bSecd  = IsCheck("bSecd"  );
    Hab.bDisc  = IsCheck("bDisc"  ); 

    return true;
    }
     
  DrawTabs();
  SelectTab( 0 );  
  }

function SetCheck( IdElem, val )  
  {
  var elem = document.getElementById(IdElem);
  if( elem ) {elem.checked = (val>0);} 
  }

function IsCheck( IdElem )  
  {
  var elem = document.getElementById(IdElem);
  return ( elem && elem.checked)? 1 : 0;  
  }

function SetImg( id , src )
  {
  var name = src || "images/foto.png";   
  $(id).attr( "src", name );
  }

function FillCasaDatos()
  {
  SetImg( "#pFoto", Casa.pFoto );  

  cbLoc.SetLoc( Casa.pLoc );

  var iOpts = Casa.iOpts.split(',');
  for( i=0; i<Casa.nImgs; ++i)
    {  
    var name = Casa.iNames+i+'.jpg';
    
    AddImage( name, iOpts[i] ); 
    }
  
  lstImg = Casa.nImgs;
  
  Habs.UpdateImages();
    
  cbEntrada.SetSelItem( Casa.pIn );
  cbSalida.SetSelItem( Casa.pOut );
    
  $("#pName"   ).val( Casa.pName );
  $("#pProp"   ).val( Casa.pProp );
  $("#pDesc"   ).val( Casa.pDesc );
  $("#pDir"    ).val( Casa.pDir  );
  $("#pDescDet").val( Casa.pDescDet );
  $("#cDesc"   ).val( Casa.cDesc );
  
  $("#pNHab"    ).val( Casa.pNHab   );
  $("#pNBanos"  ).val( Casa.pNBanos );
  
  var tMeses = Casa.pTemps.split(",");
  if( tMeses.length===4 )
    {
    Temps.SetMesIni( +tMeses[2] );
    Temps.SetMesFin( +tMeses[3] );
    }
    
  cbPrecHab.setVal( Casa.pPrecHab );
  cbPrecAll.setVal( Casa.pPrecAll );
  cbPrc1Mes.setVal( Casa.pPrc1Mes );
  cbPrecEst.setVal( Casa.pPrecEst );
               
  cbPrecHab2.setVal( Casa.pPrecHab2 );
  cbPrecAll2.setVal( Casa.pPrecAll2 );
  cbPrc1Mes2.setVal( Casa.pPrc1Mes2 );
  cbPrecEst2.setVal( Casa.pPrecEst2 );
               
  cbPrecParq.setVal( Casa.pParq );
                                 
  cbTransfer.setVal( Casa.pTranf );
  cbDesayuno.setVal( Casa.pDesay );
  cbGastronomia.setVal( Casa.pGast );
  
  SetCheck("pAire"   , Casa.pAire   );
  SetCheck("pPisc"   , Casa.pPisc   );
  SetCheck("pIndp"   , Casa.pIndp   );
  SetCheck("pLujo"   , Casa.pLujo   );
  SetCheck("pHotal"  , Casa.pHotal  );
  SetCheck("pPlaya"  , Casa.pPlaya  );
                      
  SetCheck("pCalent" , Casa.pCalent );
  SetCheck("pDiscap" , Casa.pDiscap );
  SetCheck("pCancel" , Casa.pCancel );
  SetCheck("pElev"   , Casa.pElev   );
  SetCheck("pACent"  , Casa.pACent  );
  SetCheck("pAudio"  , Casa.pAudio  );
  SetCheck("pTV"     , Casa.pTV     );
  SetCheck("pTelef"  , Casa.pTelef  );
  SetCheck("pBillar" , Casa.pBillar );
  SetCheck("Wifi"    , Casa.Wifi    );
  SetCheck("pRefr"   , Casa.pRefr   );
  SetCheck("p110v"   , Casa.p110v   );
  SetCheck("p220v"   , Casa.p220v   );
  SetCheck("pBar"    , Casa.pBar    );
  SetCheck("pLab"    , Casa.pLab    );
  SetCheck("pSLab"   , Casa.pSLab   );
  SetCheck("pSPlanc" , Casa.pSPlanc );
  SetCheck("pMasj"   , Casa.pMasj   );
  SetCheck("pSegd"   , Casa.pSegd   );
  SetCheck("pGimn"   , Casa.pGimn   );
  SetCheck("pCocina" , Casa.pCocina );
  SetCheck("pVMar"   , Casa.pVMar   );
  SetCheck("pVCiud"  , Casa.pVCiud  );
  SetCheck("pVPanor" , Casa.pVPanor );
  SetCheck("pAPrec"  , Casa.pAPrec  );
  SetCheck("pBAux"   , Casa.pBAux   );
  SetCheck("pJacuz"  , Casa.pJacuz  );
  SetCheck("pJard"   , Casa.pJard   );
  SetCheck("pRanch"  , Casa.pRanch  );
  SetCheck("pParr"   , Casa.pParr   );
  SetCheck("pBalcon" , Casa.pBalcon );
  SetCheck("pTarrz"  , Casa.pTarrz  );
  SetCheck("pPatio"  , Casa.pPatio  );
  SetCheck("pAFum"   , Casa.pAFum   );
  SetCheck("pATrab"  , Casa.pATrab  );
  SetCheck("pSReun"  , Casa.pSReun  );

  SetCheck("cMWave"  , Casa.cMWave  );
  SetCheck("cBatd"   , Casa.cBatd   );
  SetCheck("cCaft"   , Casa.cCaft   );
  SetCheck("cRefr"   , Casa.cRefr   );
  SetCheck("cHGas"   , Casa.cHGas   );
  SetCheck("cHElect" , Casa.cHElect );
  SetCheck("cOArroc" , Casa.cOArroc );
  SetCheck("cOPrec"  , Casa.cOPrec  );
  SetCheck("cFAgua"  , Casa.cFAgua  );
  SetCheck("cVagill" , Casa.cVagill );
  SetCheck("cMesa"   , Casa.cMesa   );
  SetCheck("cNevera" , Casa.cNevera );
  SetCheck("pActive" , Casa.Activo  );
  SetCheck("pByTemp" , Casa.pByTemp );

  SetByTemp();
  
  $("#CocDatos").css("display", (Casa.pCocina)? "block" : "none");  
  }

function SaveCasaDatos( publicar )
  {
  if( FindOne( "*?<>/\\&:|\"'.", $("#pProp").val()) )
    {
    alert("Caracteres ilegales en el nombre comercial de la propiedad.");  
    $("#pProp").focus();
    return;
    }
    
  var scrn = new AllScreenCover();
  
  Casa.pFoto = $("#pFoto").attr("src"); 
  
  Habs.Save();
 
  var Imgs = [], Opts = [];
  
  $("#CasaImgs .CasaImgP").each( function( idx, elem) 
    {
    var path  = elem.attributes.src.value;
    var pos   = path.lastIndexOf("/")+1;
    Imgs[idx] = path.substring(pos);  
    
    var padre = elem.parentElement.attributes["data-thab"];
    if( padre ) {Opts[idx] = +padre.value;}
    else        {Opts[idx] = -1;}
    });
  
  Casa.pImgs = Imgs;
  Casa.iOpts = Opts;
  Casa.pLoc  = cbLoc.GetLoc();
  Casa.pProv = cbLoc.GetProv();
  Casa.pIn   = cbEntrada.idxSel;
  Casa.pOut  = cbSalida.idxSel;

  Casa.pName    = $("#pName"   ).val().trim();
  Casa.pProp    = $("#pProp"   ).val().trim();
  Casa.pDesc    = $("#pDesc"   ).val();
  Casa.pDir     = $("#pDir"    ).val();
  Casa.pDescDet = $("#pDescDet").val();
  Casa.cDesc    = $("#cDesc"   ).val();

  Casa.pNBanos = +$("#pNBanos").val();
  Casa.pNHab   = +$("#pNHab"  ).val();
  
  Casa.pByTemp   = IsCheck("pByTemp");
  Casa.pTemps    = Temps.GetMeses();
  
  Casa.pPrecHab  = cbPrecHab.getVal();
  Casa.pPrecAll  = cbPrecAll.getVal();
  Casa.pPrc1Mes  = cbPrc1Mes.getVal();
  Casa.pPrecEst  = cbPrecEst.getVal();
                
  Casa.pPrecHab2 = cbPrecHab2.getVal();
  Casa.pPrecAll2 = cbPrecAll2.getVal();
  Casa.pPrc1Mes2 = cbPrc1Mes2.getVal();
  Casa.pPrecEst2 = cbPrecEst2.getVal();
                
  Casa.pParq = cbPrecParq.getVal();
                
  Casa.pTranf = cbTransfer.getVal();
  Casa.pDesay = cbDesayuno.getVal();
  Casa.pGast  = cbGastronomia.getVal();
  
  Casa.pAire   = IsCheck("pAire"  );
  Casa.pPisc   = IsCheck("pPisc"  );
  Casa.pIndp   = IsCheck("pIndp"  );
  Casa.pLujo   = IsCheck("pLujo"  );
  Casa.pHotal  = IsCheck("pHotal" );
  Casa.pPlaya  = IsCheck("pPlaya" );
              
  Casa.pCalent = IsCheck("pCalent");
  Casa.pDiscap = IsCheck("pDiscap");
  Casa.pCancel = IsCheck("pCancel");
  Casa.pElev   = IsCheck("pElev"  );
  Casa.pACent  = IsCheck("pACent" );
  Casa.pAudio  = IsCheck("pAudio" );
  Casa.pTV     = IsCheck("pTV"    );
  Casa.pTelef  = IsCheck("pTelef" );
  Casa.pBillar = IsCheck("pBillar");
  Casa.Wifi    = IsCheck("Wifi"   );
  Casa.pRefr   = IsCheck("pRefr"  );
  Casa.p110v   = IsCheck("p110v"  );
  Casa.p220v   = IsCheck("p220v"  );
  Casa.pBar    = IsCheck("pBar"   );
  Casa.pLab    = IsCheck("pLab"   );
  Casa.pSLab   = IsCheck("pSLab"  );
  Casa.pSPlanc = IsCheck("pSPlanc");
  Casa.pMasj   = IsCheck("pMasj"  );
  Casa.pSegd   = IsCheck("pSegd"  );
  Casa.pGimn   = IsCheck("pGimn"  );
  Casa.pCocina = IsCheck("pCocina");
  Casa.pVMar   = IsCheck("pVMar"  );
  Casa.pVCiud  = IsCheck("pVCiud" );
  Casa.pVPanor = IsCheck("pVPanor");
  Casa.pAPrec  = IsCheck("pAPrec" );
  Casa.pBAux   = IsCheck("pBAux"  );
  Casa.pJacuz  = IsCheck("pJacuz" );
  Casa.pJard   = IsCheck("pJard"  );
  Casa.pRanch  = IsCheck("pRanch" );
  Casa.pParr   = IsCheck("pParr"  );
  Casa.pBalcon = IsCheck("pBalcon");
  Casa.pTarrz  = IsCheck("pTarrz" );
  Casa.pPatio  = IsCheck("pPatio" );
  Casa.pAFum   = IsCheck("pAFum"  );
  Casa.pATrab  = IsCheck("pATrab" );
  Casa.pSReun  = IsCheck("pSReun" );
              
  Casa.cMWave  = IsCheck("cMWave" );
  Casa.cBatd   = IsCheck("cBatd"  );
  Casa.cCaft   = IsCheck("cCaft"  );
  Casa.cRefr   = IsCheck("cRefr"  );
  Casa.cHGas   = IsCheck("cHGas"  );
  Casa.cHElect = IsCheck("cHElect");
  Casa.cOArroc = IsCheck("cOArroc");
  Casa.cOPrec  = IsCheck("cOPrec" );
  Casa.cFAgua  = IsCheck("cFAgua" );
  Casa.cVagill = IsCheck("cVagill");
  Casa.cMesa   = IsCheck("cMesa"  );
  Casa.cNevera = IsCheck("cNevera");
  Casa.Activo  = IsCheck("pActive");

  for( i=0; i<Casa.Habits.length; ++i )
    {
    var hb = Casa.Habits[i];
    if( hb.hPrec<-2 ) {hb.hPrec = Casa.pPrecHab;}
    }
  
  var sData = JSON.stringify(Casa);
  var Data = 'Data='+encodeURIComponent( sData );
  
  $.ajax({ url: "UpdateCasa.php", data: Data, type:"POST",
       complete: function( xhr )
          { 
          scrn.Close();  
          if( checkReturn( xhr ) ) 
            {
            if( sessionStorage.User ) 
              {
              var User = JSON.parse(sessionStorage.User);
                
              User.casa = Casa.pProp;
              User.loc  = Casa.pLoc;
              
              sessionStorage.User = JSON.stringify(User);
              }
            
            if( publicar )
              {
              var sNext = encodeURIComponent("publicacion-terminada.php?User="+Casa.Id);  
              var sBack = encodeURIComponent(window.location);  
              window.location = "terminos-y-condiciones.php?next="+sNext+"&back="+sBack;  
              } 
            else
              {  
              alert("Los datos de la casa se actualizaron satisfactoriamente\r\nCuando esten instroducidos todos los datos oprima el boton 'Publicar'\r\nSu propiedad no será listada en BookingHavana hasta que no sea publicada y revisada");
              }
            }
          }
    });
    
  }

function FindOne( arr, str )
  {
  for( var i=0; i<arr.length; ++i ) 
    { if( str.indexOf(arr.charAt(i))>=0 ) {return true;} }  
  return false;   
  }
  
function ValidateDatos()
  {
  if( FindOne( "*?<>/\\&:|\"'.", $("#pProp").val()) )
    {
    alert("Caracteres ilegales en el nombre comercial de la propiedad.");  
    $("#pProp").focus();
    return;
    }
    
  var len = Name.length;
  if( len<5 || len>30 )
    {
    alert("El tamaño del nombre comercial de la propiedad debe estar entre 4 y 30 caracteres.");  
    $("#pProp").focus();
    return;
    }

  var Loc = cbLoc.GetLoc();
  if( !Loc || Loc.length !== 2 ) 
    {
    alert("Debe de especificar la localidad donde esta ubicada la propiedad.");  
    return;
    }

  var nHab = Habs.getCount();
  if( nHab<1 )
    {
    alert("Debe definir el menos una habitación.");  
    $("#pNHab").focus();
    return;
    }
    
  var Opts = [];
  
  $("#CasaImgs .CasaImgP").each( function( idx, elem) 
    {
    var padre = elem.parentElement.attributes["data-thab"];
    if( padre ) {Opts[idx] = +padre.value;}
    else        {Opts[idx] = -1;}
    });

  for( i=0; i<nHab; ++i )
    {
    var nImg = 0;  
    for( j=0; j<Opts.length; ++j )
      { if( Opts[j] === i+5 ) {++nImg;} }

    if( nImg<1 )
      {
      alert("La habitación "+(i+1)+" debe tener al menos una foto.\r\nSuba todas las fotos en la sección de Fotos y luego indique a que parte de la propiedad pertenecen.");  
      return;
      }      
    }

  var pName = $("#pName").val();
  if( pName.length<3 )
    {
    alert("El nombre del propietario debe ser mayor a 3 carácteres.");  
    $("#pName").focus();
    return;
    }
  
  var pDesc = $("#pDesc").val();
  if( pDesc.length<30 )
    {
    alert("La descripción breve de la propiedad debe tener al menos 30 carácteres.");  
    $("#pDesc").focus();
    return;
    }
  
  var pDir = $("#pDir").val();
  if( pDir.length<10 )
    {
    alert("La dirección de la propiedad debe tener al menos 10 caracteres.");  
    $("#pDir").focus();
    return;
    }
  
  var pPrecHab  = cbPrecHab.getVal();
  var pPrecAll  = cbPrecAll.getVal();
  var pPrc1Mes  = cbPrc1Mes.getVal();
  var pPrecEst  = cbPrecEst.getVal();
  if( pPrecHab<-2 || pPrecAll<-2 || pPrc1Mes<-2 || pPrecEst<-2 )
    {
    alert("Debe definir todos los precios de la temprada baja.");  
    return;
    }
    
  if( pPrecHab===0 && pPrecAll===0 && pPrc1Mes===0 && pPrecEst===0 )
    {
    alert("En la temporada baja, al menos un precio tiene que tener valor o ser negociable.");  
    return;
    }
  
  if( IsCheck("pByTemp") )
    {
    var pPrecHab2  = cbPrecHab2.getVal();
    var pPrecAll2  = cbPrecAll2.getVal();
    var pPrc1Mes2  = cbPrc1Mes2.getVal();
    var pPrecEst2  = cbPrecEst2.getVal();
    if( pPrecHab2<-2 || pPrecAll2<-2 || pPrc1Mes2<-2 || pPrecEst2<-2 )
      {
      alert("Debe definir todos los precios de la temprada alta.");  
      return;
      }
      
    if( pPrecHab2===0 && pPrecAll2===0 && pPrc1Mes2===0 && pPrecEst2===0 )
      {
      alert("En la temporada alta, al menos un precio tiene que tener valor o ser negociable.");  
      return;
      }
    }
    
  SaveCasaDatos( true );
  }
  
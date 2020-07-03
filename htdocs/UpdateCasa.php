<?php
header('Content-type: text/plain');
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']."/");

if( empty($_POST["Data"])   ) die( '{"error":17}' );

$Data = $_POST["Data"];
$Casa = json_decode($Data);

$Id = $Casa->Id;

session_start();
if( empty($_SESSION["IdUser"]) || $Id != $_SESSION["IdUser"] ) 
  { 
  if( is_int($Id) && !empty($_SESSION["Admin"]) ) 
    { $AutoLogueo = true; }
  else
    { die( '{"error":11}' ); }
  }
  
require_once 'OpenDb.php';   

$nImgs    = count( $Casa->pImgs );
$pProp    = mysqli_real_escape_string( $myDB, $Casa->pProp );
$imgNames = GetImagesName( $pProp );
$Camas    = CalCamas( $Casa->Habits );
$Personas = CalPersonas( $Casa->Habits );
$ImgOpt   = implode(",", $Casa->iOpts);
  
$Casa->pPNotes = "";

RenameFoto( $Casa );
RenameImagenes( $Id, $imgNames, $Casa->pImgs );
  
$Cmd = 'SELECT Activo FROM casas WHERE Id='.$Id;
 
$result = mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
$NRows =  mysqli_num_rows($result);

$pName    = mysqli_real_escape_string( $myDB, $Casa->pName );
$pDesc    = mysqli_real_escape_string( $myDB, $Casa->pDesc );
$pDir     = mysqli_real_escape_string( $myDB, $Casa->pDir  );
$pDescDet = mysqli_real_escape_string( $myDB, $Casa->pDescDet );
$cDesc    = mysqli_real_escape_string( $myDB, $Casa->cDesc );
$pPNotes  = mysqli_real_escape_string( $myDB, $Casa->pPNotes );

$ChgActivo = false;
$Activo    = 0;
if( $NRows >0 )
  {
  $row = mysqli_fetch_assoc($result);
    
  if( !empty($_SESSION["Admin"]) ) $Activo = $Casa->Activo;
  if( $Activo != $row["Activo"]  ) $ChgActivo = true;
  
  mysqli_free_result($result);
  $Cmd = 'UPDATE casas SET pName="'.$pName.'",pProp="'.$pProp.'",nImgs='.$nImgs.',iNames="'.$imgNames.'",pFoto="'.$Casa->pFoto.'",iOpts="'.$ImgOpt.'",pProv='.$Casa->pProv.',pLoc="'.$Casa->pLoc.'",pIn='.$Casa->pIn.',pOut='.$Casa->pOut.',pDesc="'.$pDesc.'",pDir="'.$pDir.'",pDescDet="'.$pDescDet.'",cDesc="'.$cDesc.'",pNBanos='.$Casa->pNBanos.',pNHab='.$Casa->pNHab.',pNPers='.$Personas.',pNCamas='.$Camas.',pByTemp='.$Casa->pByTemp.',pPrecHab='.$Casa->pPrecHab.',pTemps="'.$Casa->pTemps.'",pPrecAll='.$Casa->pPrecAll.',pPrc1Mes='.$Casa->pPrc1Mes.',pPrecEst='.$Casa->pPrecEst.',pPrecHab2='.$Casa->pPrecHab2.',pPrecAll2='.$Casa->pPrecAll2.',pPrc1Mes2='.$Casa->pPrc1Mes2.',pPrecEst2='.$Casa->pPrecEst2.
    ',pPNotes="'.$pPNotes.'",pParq='.$Casa->pParq.',pTranf='.$Casa->pTranf.',pDesay='.$Casa->pDesay.',pGast='.$Casa->pGast.',pAire='.$Casa->pAire.',pPisc='.$Casa->pPisc.',pIndp='.$Casa->pIndp.',pLujo='.$Casa->pLujo.',pHotal='.$Casa->pHotal.',pPlaya='.$Casa->pPlaya.',pCalent='.$Casa->pCalent.',pDiscap='.$Casa->pDiscap.',pCancel='.$Casa->pCancel.',pElev='.$Casa->pElev.',pACent='.$Casa->pACent.',pAudio='.$Casa->pAudio.',pTV='.$Casa->pTV.',pTelef='.$Casa->pTelef.',pBillar='.$Casa->pBillar.',Wifi='.$Casa->Wifi.',pRefr='.$Casa->pRefr.',p110v='.$Casa->p110v.',p220v='.$Casa->p220v.',pBar='.$Casa->pBar.',pLab='.$Casa->pLab.
    ',pSLab='.$Casa->pSLab.',pSPlanc='.$Casa->pSPlanc.',pMasj='.$Casa->pMasj.',pSegd='.$Casa->pSegd.',pGimn='.$Casa->pGimn.',pCocina='.$Casa->pCocina.',pVMar='.$Casa->pVMar.',pVCiud='.$Casa->pVCiud.',pVPanor='.$Casa->pVPanor.',pAPrec='.$Casa->pAPrec.',pBAux='.$Casa->pBAux.',pJacuz='.$Casa->pJacuz.',pJard='.$Casa->pJard.',pRanch='.$Casa->pRanch.',pParr='.$Casa->pParr.',pBalcon='.$Casa->pBalcon.',pTarrz='.$Casa->pTarrz.',pPatio='.$Casa->pPatio.',pAFum='.$Casa->pAFum.',pATrab='.$Casa->pATrab.',pSReun='.$Casa->pSReun.',cMWave='.$Casa->cMWave.',cBatd='.$Casa->cBatd.',cCaft='.$Casa->cCaft.',cRefr='.$Casa->cRefr.
    ',cHGas='.$Casa->cHGas.',cHElect='.$Casa->cHElect.',cOArroc='.$Casa->cOArroc.',cOPrec='.$Casa->cOPrec.',cFAgua='.$Casa->cFAgua.',cVagill='.$Casa->cVagill.',cMesa='.$Casa->cMesa.',cNevera='.$Casa->cNevera.',Activo='.$Activo.', Publicado=0 WHERE Id='.$Id;
  
  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  }
else
  {
  mysqli_free_result($result);
  $Cmd = 'INSERT INTO casas ( Id, pName, pProp, nImgs, iNames, pFoto, iOpts, pProv, pLoc, pIn, pOut, pDesc, pDir, pDescDet, cDesc, pNBanos, pNHab, pNPers, pNCamas, pByTemp, pPrecHab, pPrecAll, pPrc1Mes, pPrecEst, pPrecHab2, pPrecAll2, pPrc1Mes2, pPrecEst2, pPNotes, pParq, pTranf, pDesay, pGast, pAire, pPisc, pIndp, pLujo, pHotal, pPlaya, pCalent, pDiscap, pCancel, pElev, pACent, pAudio, pTV, pTelef, pBillar, Wifi, pRefr, p110v, p220v, pBar, pLab, pSLab, pSPlanc, pMasj, pSegd, pGimn, pCocina, pVMar, pVCiud, pVPanor, pAPrec, pBAux, pJacuz, pJard, pRanch, pParr, pBalcon, pTarrz, pPatio, pAFum, pATrab, pSReun, cMWave, cBatd, cCaft, cRefr, cHGas, cHElect, cOArroc, cOPrec, cFAgua, cVagill, cMesa, cNevera) 
                     VALUES ( '.$Id.', "'.$pName.'", "'.$pProp.'", '.$nImgs.', "'.$imgNames.'", "'.$Casa->pFoto.'", "'.$ImgOpt.'", '.$Casa->pProv.', "'.$Casa->pLoc.'", '.$Casa->pIn.', '.$Casa->pOut.', "'.$pDesc.'", "'.$pDir.'", "'.$pDescDet.'", "'.$cDesc.'", '.$Casa->pNBanos.', '.$Casa->pNHab.', '.$Personas.', '.$Camas.', '.$Casa->pByTemp.', '.$Casa->pPrecHab.', '.$Casa->pPrecAll.', '.$Casa->pPrc1Mes.', '.$Casa->pPrecEst.', '.$Casa->pPrecHab2.', '.$Casa->pPrecAll2.', '.$Casa->pPrc1Mes2.', '.$Casa->pPrecEst2.', "'.$pPNotes.'", '.$Casa->pParq.', '.$Casa->pTranf.', '.$Casa->pDesay.', '.$Casa->pGast.', '.$Casa->pAire.', '.$Casa->pPisc.', '.$Casa->pIndp.', '.$Casa->pLujo.', '.$Casa->pHotal.', '.$Casa->pPlaya.', '
                               .$Casa->pCalent.', '.$Casa->pDiscap.', '.$Casa->pCancel.', '.$Casa->pElev.', '.$Casa->pACent.', '.$Casa->pAudio.', '.$Casa->pTV.', '.$Casa->pTelef.', '.$Casa->pBillar.', '.$Casa->Wifi.', '.$Casa->pRefr.', '.$Casa->p110v.', '.$Casa->p220v.', '.$Casa->pBar.', '.$Casa->pLab.', '.$Casa->pSLab.', '.$Casa->pSPlanc.', '.$Casa->pMasj.', '.$Casa->pSegd.', '.$Casa->pGimn.', '.$Casa->pCocina.', '.$Casa->pVMar.', '.$Casa->pVCiud.', '.$Casa->pVPanor.', '.$Casa->pAPrec.', '.$Casa->pBAux.', '.$Casa->pJacuz.', '.$Casa->pJard.', '.$Casa->pRanch.', '.$Casa->pParr.', '.$Casa->pBalcon.', '.$Casa->pTarrz.', '.$Casa->pPatio.', '.$Casa->pAFum.', '.$Casa->pATrab.', '.$Casa->pSReun.', '
                               .$Casa->cMWave.', '.$Casa->cBatd.', '.$Casa->cCaft.', '.$Casa->cRefr.', '.$Casa->cHGas.', '.$Casa->cHElect.', '.$Casa->cOArroc.', '.$Casa->cOPrec.', '.$Casa->cFAgua.', '.$Casa->cVagill.', '.$Casa->cMesa.', '.$Casa->cNevera.')';

  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  }

$Cmd = 'DELETE FROM habitaciones WHERE Id = '.$Id;
mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');

$Habs = $Casa->Habits;

for( $i=0; $i<count($Habs); ++$i ) 
  {
  $Hab = $Habs[$i];  
  $Num = $i+1;
  
  $hDesc = mysqli_real_escape_string( $myDB, $Hab->hDesc );
  $bDesc = mysqli_real_escape_string( $myDB, $Hab->bDesc );
  
  $Cmd = 'INSERT INTO habitaciones (Id, Num, hDesc, hTipo, hPrec, hCCam, hCKing, hCQueen, hCPers, hCCuna, hCLit, hVent, bDesc, hIndep, hAire, hSplit, hAudio, hTV, hTelef, hV110, hV220, hMBar, hVest, hClos, hArm, bDentro, bACal, bJacuz, bCabin, bTina, bBidl, bSecd, bDisc)
            VALUES ('.$Id.', '.$Num.', "'.$hDesc.'", '.$Hab->hTipo.', '.$Hab->hPrec.', '.$Hab->hCCam.', '.$Hab->hCKing.', '.$Hab->hCQueen.', '.$Hab->hCPers.', '.$Hab->hCCuna.', '.$Hab->hCLit.', '.$Hab->hVent.', "'.$bDesc.'", '.$Hab->hIndep.', '.$Hab->hAire.', '.$Hab->hSplit.', '.$Hab->hAudio.', '.$Hab->hTV.', '.$Hab->hTelef.', '.$Hab->hV110.', '.$Hab->hV220.', '.$Hab->hMBar.', '.$Hab->hVest.', '.$Hab->hClos.', '.$Hab->hArm.', '.$Hab->bDentro.', '.$Hab->bACal.', '.$Hab->bJacuz.', '.$Hab->bCabin.', '.$Hab->bTina.', '.$Hab->bBidl.', '.$Hab->bSecd.', '.$Hab->bDisc.')';

  mysqli_query($myDB, $Cmd) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  }

if( $ChgActivo )
  {
  NotifyChangeStatus( $Id, $Activo, $Casa->pName, $Casa->pProp, $Casa->pLoc );  
  
  UpdateDestinos();
  }

mysqli_close($myDB);

die( '{"error":0}' );  

// Calcula el número de camas que hay en la casa
function CalCamas( $Habs )
  {
  $NCamas = 0;  
  for( $i=0; $i<count($Habs); ++$i ) 
    {
    $hab = $Habs[$i];  
    $NCamas += $hab->hCCam;  
    $NCamas += $hab->hCKing;  
    $NCamas += $hab->hCQueen;  
    $NCamas += $hab->hCPers;  
    $NCamas += $hab->hCLit;  
    }
    
  return $NCamas;
  }

// Calcula el número de personas que admite la casa
function CalPersonas( $Habs )
  {
  $NPers = 0;  
  for( $i=0; $i<count($Habs); ++$i ) 
    {
    $hab = $Habs[$i];  
    $NPers += (2*$hab->hCCam);  
    $NPers += (2*$hab->hCKing);  
    $NPers += (2*$hab->hCQueen);  
    $NPers += $hab->hCPers;  
    $NPers += (2*$hab->hCLit);  
    }
    
  return $NPers;
  }

// Renombra la foto del propietario
function RenameFoto( $Casa )
  {
  if( !file_exists($Casa->pFoto) ) 
    {
    $Casa->pFoto = "images/foto.png";
    return;
    }
  
  $Name = pathinfo( $Casa->pFoto,  PATHINFO_FILENAME);  
  $NewName = ChkDir('fotos/' ).'PropFoto'.$Casa->Id.'.jpg';
  
  if( rename( $Casa->pFoto, $NewName) )
    $Casa->pFoto = $NewName;
  }

// Obtiene el nombre utilizado para las imagenes
function GetImagesName( $PropName )
  {
  $find = array(" ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "ü", "Ü");
  $sust = array("_", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "u", "U");
    
  return str_replace( $find, $sust, trim($PropName) ).'_';
  }
  
// Renombra los ficheros subidos
function RenameImagenes( $Id, $Names, $Imgs )
  {
  for( $i=0; $i<count($Imgs); ++$i )  
    {
    $name = $Imgs[$i];
    $newName = $Names.$i.'.jpg';
    
    if( $newName != $name )
      {
      $Dir = ChkDir('CasasP/'.$Id.'/');
      rename( $Dir.$name, $Dir.$newName);
      
      $Dir = ChkDir('CasasM/'.$Id.'/');
      rename( $Dir.$name, $Dir.$newName);
      
      $Dir = ChkDir('CasasG/'.$Id.'/');
      rename( $Dir.$name, $Dir.$newName);
      }
    }
  }
  
// Chequea que el directorio 'sDir' exista, si no existe lo crea
function ChkDir( $sDir )
  {
  if( file_exists($sDir) || mkdir($sDir, 0777, true) ) return $sDir;
  ReturnError(9);  
  }

// Actualiza los datos de los destinos destacados
function UpdateDestinos()
  {
  global $myDB;
  
  $Sel = 'SELECT * FROM tops_destinos';
  $query = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
  
  while( $Dest = mysqli_fetch_assoc($query) )
    {
    $Prov = $Dest["Prov"];  
    $Loc  = $Dest["Loc"];
    
    if( empty($Loc) ) $Sel = "SELECT COUNT(*) AS Num FROM casas WHERE Activo>0 AND pProv = ".$Prov;
    else              $Sel = "SELECT COUNT(*) AS Num FROM casas WHERE Activo>0 AND pLoc = '".$Loc."'";
    
    $query2 = mysqli_query($myDB, $Sel) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
    $Count = mysqli_fetch_assoc($query2);
    mysqli_free_result($query2);
    
    $update = "UPDATE tops_destinos SET nCasas=".$Count["Num"]." WHERE Orden=".$Dest["Orden"];
    mysqli_query($myDB, $update) or die( '{"error":18, "msg":"'.mysqli_error($myDB).'"}');
    }
  
  mysqli_free_result($query);
  }

// Notifica al usuario y al administrador que el estado de la casa cambio
function NotifyChangeStatus( $IdCasa, $Active, $NameProp, $NameCasa, $Loc )
  {
  include 'SendMail.php';   
  include 'Links.php';   
  
  $Cmd = "SELECT Correo FROM usuarios WHERE Id=".$IdCasa;
   
  global $myDB;
  $query2 = mysqli_query($myDB, $Cmd);
  if( $Row = mysqli_fetch_assoc($query2) )
    {
    $Template = ($Active>0)? $MailCasaActive : $MailCasaDesActive;
    $mail  = $Row["Correo"];
    $Datos = array( '{Name}'    =>$NameProp, 
                    '{CasaName}'=>$NameCasa,
                    '{UserId}'  =>$IdCasa,
                    '{Link}'    =>SITE_URL.GetCasaLnk( $IdCasa, $Loc, $NameCasa, "" )
                     );
                     
    SendMail( $mail, $Template, $Datos );
    
    $mail = 'bookinghavana@gmail.com';
    SendMail( $mail, $Template, $Datos );
    }
  
  mysqli_free_result($query2);
  }  

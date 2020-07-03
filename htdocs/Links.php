<?php
// Datos de las localidades
global $LocInfo;

$LocInfo = 
  [
  "H1"=>"El Vedado", 
  "H2"=>"Habana Vieja", 
  "H3"=>"Centro Habana", 
  "H4"=>"Miramar", 
  "H5"=>"Playa", 
  "H6"=>"Playas del Este", 
  "H7"=>"Nuevo Vedado", 
  "H8"=>"Kholy", 
  "H9"=>"Jaimanitas", 
  "Ha"=>"Santa Fe", 
  "Hb"=>"Santo Suarez", 
  "Hc"=>"Cogimar",
  "P1"=>"Ciudad Pinar del Río",
  "P2"=>"Soroa", 
  "P3"=>"Viñales",
  "P4"=>"Cayo Jutias",
  "P5"=>"Puerto Esperanza",
  "P6"=>"Sandino",
  "M1"=>"Ciudad Matanzas",
  "M2"=>"Santa Marta",
  "M3"=>"Playa Varadero",
  "M4"=>"Boca Camarioca",
  "M5"=>"Playa Larga",
  "M6"=>"Playa Girón",
  "M7"=>"Jovellanos",
  "C1"=>"Ciudad Cienfuegos",
  "C2"=>"Punta Gorda",
  "V1"=>"Santa Clara",
  "V2"=>"Remedios",
  "V3"=>"Caibarien",
  "S1"=>"Ciudad Sancti Spíritus",
  "S2"=>"Trinidad",
  "S3"=>"Puerto Casilda",
  "S4"=>"Playa La Boca",
  "G1"=>"Ciudad Holguín",
  "G2"=>"Gibara",
  "G3"=>"Guardalavaca",
  "G4"=>"Banes",
  "G5"=>"Cayo Bariay",
  "O1"=>"Camagüey",
  "O2"=>"Las Tunas",
  "O3"=>"Puerto Padre",
  "O4"=>"Bayamo",
  "O5"=>"Santiago de Cuba",
  "O6"=>"Guantánamo",
  "O7"=>"Baracoa",
  ];
  
// Obtiene el link a una casa
function GetCasaLnk( $Id, $CodLoc, $Name, $sifix )
  {
  global $LocInfo;
    
  $path = "casa-particular-en-";
  $Loc = $LocInfo[$CodLoc];
  
  if( isset($Loc) ) 
    { $path .= strtolower( str_replace( ' ', '-', $Loc ) ); }
  else
    { $path .= "cuba"; }
 
  $Nombre = strtolower( str_replace( ' ', '-', $Name ) );       
  return $path.'/'.$Nombre.'/'.$sifix.$Id;
  }


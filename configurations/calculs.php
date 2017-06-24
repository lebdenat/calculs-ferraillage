<?php


////////////////////////////////////////////////////////////////////////////
//
// Chargement des definitions de chaque calcul
//
////////////////////////////////////////////////////////////////////////////

$Index1stPropDefinition = 1;
$IndexNomDefinition = 0;
$IndexCalcul = 1;
$DefinitionsFic = "definitions.txt" ;

$VarsDonneesDefinition = file ("./".$locations['DonneesDir']."/".$DefinitionsFic);

// Noms des proprietes
$VarsNameDefinition = split ("\|", $VarsDonneesDefinition[0]);

// Assignation des variables par types de calculs
for ($IndexTemp = $Index1stPropDefinition; $IndexTemp < SizeOf($VarsDonneesDefinition); $IndexTemp++){
$PropTempDefinition = split ("\|", $VarsDonneesDefinition[$IndexTemp]);
# $Definition[$PropTemp[$IndexDefinition]] = $PropTemp ;
for ($IndexNameProp = 0; $IndexNameProp < SizeOf($VarsNameDefinition); $IndexNameProp++){
$Definition[$PropTempDefinition[$IndexCalcul]][$PropTempDefinition[$IndexNomDefinition]][$VarsNameDefinition[$IndexNameProp]] = $PropTempDefinition[$IndexNameProp] ;
}
}




////////////////////////////////////////////////////////////////////////////
//
// Chargement des proprietes de chaque calcul
//
////////////////////////////////////////////////////////////////////////////

$Index1stPropCalcul = 1;
$IndexNomCalcul = 0;
$IndexCalcul = 1;
$CalculFic = "calculs.txt";

$VarsDonneesCalcul = file ("./".$locations['DonneesDir']."/".$CalculFic);

// Noms des proprietes
$VarsNameCalcul = split ("\|", $VarsDonneesCalcul[0]);

// Assignation des variables par types de calculs
for ($IndexTemp = $Index1stPropCalcul; $IndexTemp < SizeOf($VarsDonneesCalcul); $IndexTemp++){
$PropTempCalcul = split ("\|", $VarsDonneesCalcul[$IndexTemp]);
for ($IndexNameProp = 0; $IndexNameProp < SizeOf($VarsNameCalcul); $IndexNameProp++){
$Calcul[$PropTempCalcul[$IndexCalcul]][$PropTempCalcul[$IndexNomCalcul]][$VarsNameCalcul[$IndexNameProp]] = $PropTempCalcul[$IndexNameProp] ;
}
}



////////////////////////////////////////////////////////////////////////////
//
// Chargement des scripts de chaque calcul
//
////////////////////////////////////////////////////////////////////////////

$Index1stPropScript = 1;
$IndexNomScript = 0;
$IndexPage = 2;
$ScriptFic = "scripts.txt";

$VarsDonneesScript = file ("./".$locations['DonneesDir']."/".$ScriptFic);

// Noms des proprietes
$VarsNameScript = split ("\|", $VarsDonneesScript[0]);

// Assignation des variables par types de calculs
for ($IndexTemp = $Index1stPropScript; $IndexTemp < SizeOf($VarsDonneesScript); $IndexTemp++){
$PropTempScript = split ("\|", $VarsDonneesScript[$IndexTemp]);
for ($IndexNameProp = 0; $IndexNameProp < SizeOf($VarsNameScript); $IndexNameProp++){
$Script[$PropTempScript[$IndexPage]][$PropTempScript[$IndexNomScript]][$VarsNameScript[$IndexNameProp]] = $PropTempScript[$IndexNameProp] ;
}
}



?>
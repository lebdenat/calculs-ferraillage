<?php


///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour l'affichage des variables a entrer
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function nouveau(){

// recuperation des variables
global $FormVars ;

//Initialisation des donnees : Analyse des erreurs
$Donnees = AnalyseErreurs();

//Recuperation de la page "nouveau"
$Donnees .= DecodeVars(DecodeFonction(TraiteTemplate("nouveau.htm")), $FormVars['type']);
 
return $Donnees ;
}



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour la presentation des differents champs du formulaire pour entrer les informations
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function Elements(){

// recuperation des variables
global $FormVars, $Calcul, $Definition, $Script , $Config;

// Initialisation du buffer de sortie
$Donnees = "" ;
$CurPage = "Nouveau";
$TypeCalcul = "Defaut";
$ThemeTemp = "";

// Recherche du script special pour le type de calcul appele
foreach ($Script[$CurPage] as $IndexScript=>$ValScript){
if ($Script[$CurPage][$IndexScript]["calcul"] ==  $FormVars['type']):
$TypeCalcul = $FormVars['type'];
break;
endif;
}

// Script normal code pour les differentes portions de formulaire
foreach ($Script[$CurPage] as $IndexScript=>$ValScript){
if ($Script[$CurPage][$IndexScript]["calcul"] == $TypeCalcul){
if (ereg ($Config['TagDebut'], $Script[$CurPage][$IndexScript]["valeur"]) and !ereg($Config['TagDebut'].$Config['FormVars'], $Script[$CurPage][$IndexScript]["valeur"])){
foreach (${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']] as $Type=>$value):
if ($ThemeTemp != ${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]['theme'] && $TypeCalcul!=$FormVars['type']){
$Donnees .= '<tr><th colspan="2" class="Theme">'.${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]['theme'].'</th></tr>';
	$ThemeTemp = ${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]['theme'] ; 
	}
$Donnees .= DecodeVars ($Script[$CurPage][$IndexScript]["valeur"], ${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]) ;
endforeach ;
}
else
$Donnees .= $Script[$CurPage][$IndexScript]["valeur"];
}
}

	
// Renvoi des resultats
return $Donnees ;
}




function AnalyseErreurs(){
global $FormVars, $locations, $Calcul;
$NomFicLOG = "Erreurs.txt" ;
$Msg = "";
$Erreurs = file("./".$locations['DonneesDir']."/".$NomFicLOG) ;
if (SizeOF($Erreurs) > 0){
$Msg = "<font color='red'><p>Les champs suivis d'une croix n'ont pas de valeur; Veuillez les remplir SVP!!!</p></font>" ;
for ($CptErr = 0; $CptErr<SizeOF($Erreurs); $CptErr++){
if (ereg ("=", $Erreurs[$CptErr])){
list ($Type, $Val) = split ("=", $Erreurs[$CptErr]);
$Val = ereg_replace("\r\n", "", $Val);
if (ereg ("text", $Calcul[$FormVars['type']][$Type]['form']))
$Calcul[$FormVars['type']][$Type]['form'] = ereg_replace("value=\"\"", "value=\"".$Val."\"", $Calcul[$FormVars['type']][$Type]['form']);
elseif (ereg ("radio", $Calcul[$FormVars['type']][$Type]['form'])){
$Calcul[$FormVars['type']][$Type]['form'] = ereg_replace("checked( *)", "", $Calcul[$FormVars['type']][$Type]['form']);
$Calcul[$FormVars['type']][$Type]['form'] = ereg_replace("value=\"".$Val."\"", "value=\"".$Val."\" checked", $Calcul[$FormVars['type']][$Type]['form']);
}
elseif (ereg ("select", $Calcul[$FormVars['type']][$Type]['form'])){
$Calcul[$FormVars['type']][$Type]['form'] = ereg_replace("selected( *)", "", $Calcul[$FormVars['type']][$Type]['form']);
$Calcul[$FormVars['type']][$Type]['form'] = ereg_replace("value=\"".$Val."\"", "value=\"".$Val."\" selected", $Calcul[$FormVars['type']][$Type]['form']);
}
}
else{
$Type=ereg_replace("\r\n", "", $Erreurs[$CptErr]);
$Calcul[$FormVars['type']][$Type]['titre'] .= "<font color='red'>*</font>";
}
}
////////////////////////////////////////////////////////////////////////////////
// rafraichissement du fichier LOG
$FicLOG = fopen("./".$locations['DonneesDir']."/".$NomFicLOG, "w") ;
fclose($FicLOG);
}
return $Msg;
}





?>
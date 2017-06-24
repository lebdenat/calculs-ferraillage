<?php


///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour l'affichage des variables a entrer
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function accueil(){

//Initialisation des donnees
$Donnees = DecodeFonction(TraiteTemplate("accueil.htm"));

/*
// Affichage des types de calculs recenses
foreach ($Calcul as $Type=>$value):

endforeach ;
*/

// 
return $Donnees ;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour l'affichage des variables a entrer
//
///////////////////////////////////////////////////////////////////////////////////////////////////
function LiensCalculs(){
// Chargement des calculs
global $Calcul, $Definition, $Script,$Config;

// Determination de la page en cours
$CurPage = "Accueil";
$PropPres = "titre";

// Initialisation des donnees
$Donnees = '';

// Script normal code pour un cham
foreach ($Script[$CurPage] as $IndexScript=>$ValScript){
if (ereg ($Config['TagDebut'], $Script[$CurPage][$IndexScript]["valeur"]))
foreach ($Definition as $Type=>$value):
$Donnees .= DecodeVars ($Script[$CurPage][$IndexScript]["valeur"], $Definition[$Type][$PropPres]) ;
endforeach ;
else
$Donnees .= $Script[$CurPage][$IndexScript]["valeur"];
}

return $Donnees ;
}

?>
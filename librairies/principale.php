<?php


///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour l'affichage des variables a entrer
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function principale(){

// recuperation des variables
global $locations, $Config, $FormVars, $Definition ;
// Variable pour l'affichage
$Donnees = '' ;
$vars = array() ;


// champs supplementaires
if (isset ($FormVars['type'])){
	if ($FormVars['action'] == "nouveau")
		$Config['Titre'] .= " :: nouveau calcul ".$Definition[$FormVars['type']]["titre"]['valeur'];
	else
		$Config['Titre'] .= " :: r&eacute;sultats du calcul ".$Definition[$FormVars['type']]["titre"]['valeur'];
	$FormVars['titre'] = $Definition[$FormVars['type']]["titre"]['valeur'];
	$vars['titre_calcul'] = $FormVars['titre'] ;
	$vars['mots_cles'] = $Definition[$FormVars['type']]["titre"]['mots_cles'];
	$vars['description'] = $Definition[$FormVars['type']]["titre"]['description'];
} 
else{
}

// Recuperation du theme global
$Page = DecodeVars(TraiteTemplate($Config['Theme']."/index.html"), $vars);


// Appel de la fonction en fonction de l'action
if (isset($FormVars['action']))
$Donnees .= call_user_func ($FormVars['action']);
else
$Donnees .= accueil();

// Mise a jour des donnees dans la page
$Page = ereg_replace ($Config['TagDebut']."Donnees".$Config['TagFin'], $Donnees, $Page);


return $Page ;
}



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonction pour l'appel des fonctions dans le template
//
///////////////////////////////////////////////////////////////////////////////////////////////////
function DecodeFonction($CodeFonction){

// recuperation des variables
global $Config ;

// Decomposition du code en lignes
$Lignes = split ("\n", $CodeFonction) ;
$Fonction = "";
$FonctionExpr = "(".$Config['TagDebut'].$Config['TagFonction']."+)([a-zA-Z]+)(;)(\(?)([a-zA-Z0-9]*)(\)?)(".$Config['TagFin'].")" ;

foreach ($Lignes as $LigneTemp){
if (ereg ($FonctionExpr, $LigneTemp, $regs)){
// recuperation du contenu avant et apres le contenu de la fonction
list ($AvantFonc, $ApresFonc) = split ($FonctionExpr, $LigneTemp);
// Appel de la fonction et encadrage avec les contenus d'avant et apres
$Fonction .= $AvantFonc. call_user_func ($regs[2], $regs[5]) .$ApresFonc ;
}
else {
$Fonction .= $LigneTemp ;
}
}

// $Fonction = ereg_replace ("(\{\&+)([a-zA-Z]+)(;)(\(?)([a-zA-Z0-9]*)(\)?)(\})", call_user_func("\\2", "\\5"), $CodeFonction) ;
/*
$Fonction = ereg_replace ("\&", "", $CodeFonction) ;
list ($NomFonction, $Parametres) = split ("::", $Fonction) ;
$Donnees = call_user_func ($NomFonction, $Parametres) ;
return $Donnees ;
*/
return $Fonction ;
}



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonction pour l'appel des variables dans le template
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function DecodeVars($CodeVars, $CourVar){

// recuperation des variables
global $locations, $Config, $FormVars, $Calcul, $Operation ;

// Chargement des variables de configuration
$Vars = "";
// $VarsExpr = $Config['TagDebut'].$Config['TagVars'].$Config['TagFin'] ;

// Remplacement des variables du type de calcul appele
$VarTemp = $CourVar ;
if (is_array ($VarTemp)){
while (list($Var, $value) = each($VarTemp)) {
	$CodeVars =  ereg_replace ($Config['TagDebut'].$Var.$Config['TagFin'], stripslashes(addslashes($VarTemp[$Var])), $CodeVars) ;
	// $VarTemp = "";
}
}
else
$CodeVars =  ereg_replace ($Config['TagDebut'].$Config['this'].$Config['TagFin'], $VarTemp, $CodeVars) ;


// Remplacement des variables de configurations
foreach ($Config as $Var => $value){
$CodeVars =  ereg_replace ($Config['TagDebut'].$Var.$Config['TagFin'], $Config[$Var], $CodeVars) ;
}
// echo $CourVar."<br />" ;

# foreach ($CourVar as $Var => $test){
# }

// Remplacement des variables de configurations
foreach ($FormVars as $Var => $value){
$CodeVars =  ereg_replace ($Config['TagDebut'].$Config['FormVars'].$Var.$Config['TagFin'], $FormVars[$Var], $CodeVars) ;
}

// Valeur de Retour
return $CodeVars ;
}


///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour la recuperation du template
//
///////////////////////////////////////////////////////////////////////////////////////////////////
function TraiteTemplate($template_file)
{
// Recuperation du dossier des templates
global $locations ;
$contenu = "";
// traitement du template
$template = fopen ($locations['TplDir']."/".$template_file, "r");
while (!feof ($template))
{
$ligne = fgets ($template, 255);
$contenu.= $ligne;
}
fclose($template);
return $contenu;
}



?>
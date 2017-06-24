<?php

// Variables de configuration 
$Config = array (
				////////////////////////////////////////////////////////////////////////////////
				// Les variables de localisation
				////////////////////////////////////////////////////////////////////////////////
				'URISite' => "http://localhost/kak", # URI de l'application
				'Theme' => "automne" , # theme de l'application
				'Titre' => "Calculs Ferraillage", # Titre de l'application
				////////////////////////////////////////////////////////////////////////////////
				// Les variables des tags
				////////////////////////////////////////////////////////////////////////////////				
				'TagDebut' => "\{", # Tag de debut d'une variable
				'TagFin' => "\}", # Tag de fin d'une variable
				'TagFonction' => "\&", #Tag d'introduction d'une fonction
				'FormVars' => "FormVars_", # Tag d'introduction des variables de formulaire transmises
				'this' => "this", # est utilise pour recuperer toutes les cles du courant objet affiche
				'mots_cles' => "calcul, ferraillage, batiment, semelle, fondation", # Mots cl&eacute;s par d&eacute;faut
				'description' => "Cette application, r&eacute;alis&eacute;e en PHP, permet d'effectuer des calculs de b&acirc;timent, du poteau &agrave; la semelle de fondation. Il est un freeware et au stade de d&eacute;veloppement." # Description de l'application
				);
				
// recuperation des donnees transmises
$FormVars = array () ;
foreach ($_POST as $var => $val)
{
$FormVars[$var] = $_POST[$var];
}
foreach ($_GET as $var => $val)
{
$FormVars[$var] = $_GET[$var];
}

// Les options supplementaires
//if (isset ($FormVars['type']))
// $FormVars['titre'] = $Definition[$FormVars['type']]["titre"]['valeur'];



?>

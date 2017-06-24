<?php


///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Fonctions pour l'affichage des variables a entrer
//
///////////////////////////////////////////////////////////////////////////////////////////////////

function sauve(){

		// recuperation des variables
		global $FormVars, $locations ;

		//Initialisation des donnees : Analyse des erreurs
		$Donnees = AnalyseErreurs();

		$local_vars = array (
			"std_date" => date("d/m/Y"),
			"nom_fichier" => $FormVars['type'].'_'.strtotime(date("Y-m-d h:i:s")),
		) ;
		$local_vars['uri_fichier'] = $locations['FicsDir']."/".$local_vars['nom_fichier'].".html" ;
		
		calcul_resultats();

		$Entete = "<p>
			Votre calcul a &eacute;t&eacute; sauvegard&eacute; sous le nom de <b>".$local_vars['uri_fichier']."</b><br />
			<a href=\"index.php?action=obtient_fichier&fichier=".$local_vars['nom_fichier'].".html.gz"."\">T&eacute;l&eacute;charger</a><br />
			<a href=\"javascript:history.back()\">Retour</a>
			</p>" ; 
		
//echo $Donnees;

		//Recuperation de la page "nouveau"
		$Donnees .= DecodeVars(DecodeFonction(TraiteTemplate("fichier_calcul.htm")), $FormVars['type']);

		$Donnees = DecodeVars($Donnees, $local_vars) ;
		
		// Sauvegarde du 
		/*
		$fic = fopen($local_vars['uri_fichier'], "w");
		fputs($fic, $Donnees) ;
		fclose($fic) ;
		*/
		
		//Sauvegarde GZ
		$fic = gzopen($local_vars['uri_fichier'].".gz", "w9");
		gzputs($fic, $Donnees) ;
		gzclose($fic) ;
		
		// Sauvegarde BZ2
		/*
		$fic = bzopen($local_vars['uri_fichier'].".bz2", "w9");
		bzwrite($fic, $Donnees) ;
		bzclose($fic) ;
		*/
		
		// Sauvegarde Tar.gz
		// include class
		/*
		require("Tar.php");
		// create Archive_Tar() object
		// specify filename for output file and compression method
		$tar = new Archive_Tar($local_vars['uri_fichier'].".tar.gz", "gz");
		// set up file list
		$files = array($local_vars['uri_fichier']);
		// build archive
		$tar->create($files) or die("Could not create archive!");
		*/
		
		$Donnees = $Entete.$Donnees ;

		echo $Donnees ;
		exit;
 
		return $Donnees ;

}



function Fichier(){
// Recuperation des variables
global $FormVars, $Calcul, $Config, $Operation, $Definition, $Script ;

		$Donnees = '';
		$TypeCalcul = 'Defaut';
		$CurPage = 'Sauvegarde';
		$ThemeTemp = '';
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
		if (ereg ($Config['TagDebut'], $Script[$CurPage][$IndexScript]["valeur"]) and !ereg ($Config['TagDebut'].$Config['FormVars'], $Script[$CurPage][$IndexScript]["valeur"]))
		foreach (${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']] as $Type=>$value):
		if (${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]["theme"] != $ThemeTemp and $TypeCalcul == "Defaut"){
		$Donnees .= '<tr><th colspan="2" class="Theme">'.${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]['theme'].'</th></tr>';
			$ThemeTemp = ${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]['theme'] ; 
			}
		$Donnees .= DecodeVars ($Script[$CurPage][$IndexScript]["valeur"], ${$Script[$CurPage][$IndexScript]["type"]}[$FormVars['type']][$Type]) ;
		endforeach ;
		else
		$Donnees .= $Script[$CurPage][$IndexScript]["valeur"];
		}
		}
		
		return $Donnees;
}



function obtient_fichier(){

	//header('Content-type: application/gz2') ;
	global $locations ;

	$local_vars['uri_fichier'] = $locations['FicsDir']."/".$_GET['fichier'] ;
	$filename = $_GET['fichier'] ;
	$size = filesize($local_vars['uri_fichier']);

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename."\";");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".$size);

	readfile($local_vars['uri_fichier']);
	exit ;
}



?>
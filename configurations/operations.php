<?php

# $FicDonnees = fopen("./".$locations['DonneesDir']."/calculs.txt", "r") ;

$Index1stPropOperation = 1;
$IndexNomOperation = 0;
$IndexOperation = 1;
$OperationsFic = "operations.txt";
$NomFonctionResultats = "resultats";
$actions_pour_resultats = array("resultats", "sauve") ;

$VarsDonneesOperation = file ("./".$locations['DonneesDir']."/".$OperationsFic);

// Noms des proprietes
$VarsNameOperation = split ("\|", $VarsDonneesOperation[0]);

// Assignation des variables par types de calculs
	for ($IndexTemp = $Index1stPropOperation; $IndexTemp < SizeOf($VarsDonneesOperation); $IndexTemp++){
		$PropTempOperation = split ("\|", $VarsDonneesOperation[$IndexTemp]);
		# $Calcul[$PropTemp[$IndexCalcul]] = $PropTemp ;
		for ($IndexNameProp = 0; $IndexNameProp < SizeOf($VarsNameOperation); $IndexNameProp++){
			$Operation[$PropTempOperation[$IndexOperation]][$PropTempOperation[$IndexNomOperation]][$VarsNameOperation[$IndexNameProp]] = $PropTempOperation[$IndexNameProp] ;
		}
	// echo $."<br />" ;
}



if (isset ($FormVars['action']))
if (in_Array($FormVars['action'], $actions_pour_resultats)){
	if (isset ($Calcul[$FormVars['type']])){
	$IlyaErreur = false;
	///////////////////////////////////////////////////////////////////////////////////////////
	// Mise a jour des variables utilisees dans le script resultat
		foreach ($Calcul[$FormVars['type']] as $Prop => $ValueProp){
		$Calcul[$FormVars['type']][$Prop]['valeur'] = $FormVars[$Prop] ;
		if ($Calcul[$FormVars['type']][$Prop]['valeur'] == ''){
		$IlyaErreur = true;
		}
		}

		// Ouverture du fichier resultats
		$FicResultats = fopen("./".$locations['LibDir']."/".$NomFonctionResultats.".php", "w") ;

		//////////////////////////////////////////////////////////////////////////////////////////
		// Fonction Resultats
		// definition des variables pour l'affichage du resultat
		$ScriptResultats  = "//Affectations entre variables\r\n";
		$DebutPHP = "<?php";
		$FinPHP = "?>";
		$FonctionCalculResultats =  "\n\r\n\r\nfunction calcul_resultats(){\r\n" ;
		$FonctionResultats = "\n\r\n\r\nfunction resultats(){\r\n" ;
		$GlobalsVars = "// Recuperation des variables\r\nglobal \$FormVars,  \$Calcul,\$Operation, \$Config ;\r\n\r\n" ;
		$AppelResultats = "\r\n// Calcul des r&eacute;sultats du calcul demand&eacute;
		calcul_resultats() ;\r\n// Formules du calcul demand&eacute;
		cree_expressions() ;" ;
		$AppelPage = "\r\n//Recuperation de la page \"resultats\"
		\$Donnees = DecodeVars(DecodeFonction(TraiteTemplate(\"resultats.htm\")), \$FormVars['type']);\r\n\r\nreturn \$Donnees;\r\n";
		$FinFonction = "}\r\n\r\n\r\n";
		///////////////////////////////////////////////////////////////////////////////////////////
		// Les resultats
		///////////////////////////////////////////////////////////////////////////////////////////
		if (is_Array ($Operation[$FormVars['type']]) and $IlyaErreur == false){
		///////////////////////////////////////////////////////////////////////////////////////////

		// Ajout des scripts de chaque operation
		foreach ($Operation[$FormVars['type']] as $PropTemp => $value){
			$ScriptResultats .= $Operation[$FormVars['type']][$PropTemp]['script']."\r\n" ;
		}

		// Mise a jour des variables d'operations
		foreach ($Operation[$FormVars['type']] as $Prop => $ValueProp){
			$ScriptResultats = ereg_replace ("\{".$Prop."\}", "\$Operation['".$FormVars['type']."']['".$Prop."']['valeur']", $ScriptResultats) ;
		}

		// Mise a jour des variables de calculs
		foreach ($Calcul[$FormVars['type']] as $Prop => $ValueProp){
			$ScriptResultats = ereg_replace ("\{".$Prop."\}", "\$Calcul['".$FormVars['type']."']['".$Prop."']['valeur']", $ScriptResultats) ;
		}

		$ScriptResultats = $DebutPHP.$FonctionCalculResultats.$GlobalsVars.$ScriptResultats.$FinFonction.$FonctionResultats.$GlobalsVars.$AppelResultats.$AppelPage.$FinFonction ;

		//////////////////////////////////////////////////////////////////////////////////////////
		// Fonction Tableau
		// definition des variables pour l'affichage du Tableau
		$FonctionTableau = "\n\r\n\r\nfunction Tableau(){\r\n" ;
		$GlobalsVars = "// Recuperation des variables\r\nglobal \$FormVars, \$Calcul, \$Config, \$Operation, \$Definition, \$Script ;\r\n\r\n" ;
		$InitialsVars ="
		\$Donnees = '';
		\$TypeCalcul = 'Defaut';
		\$CurPage = 'Resultats';
		\$ThemeTemp = '';
		// Recherche du script special pour le type de calcul appele
		foreach (\$Script[\$CurPage] as \$IndexScript=>\$ValScript){
		if (\$Script[\$CurPage][\$IndexScript][\"calcul\"] ==  \$FormVars['type']):
		\$TypeCalcul = \$FormVars['type'];
		break;
		endif;
		}
		"
		;
		$ScriptTableau = "
		// Script normal code pour les differentes portions de formulaire
		foreach (\$Script[\$CurPage] as \$IndexScript=>\$ValScript){
		if (\$Script[\$CurPage][\$IndexScript][\"calcul\"] == \$TypeCalcul){
		if (ereg (\$Config['TagDebut'], \$Script[\$CurPage][\$IndexScript][\"valeur\"]) and !ereg (\$Config['TagDebut'].\$Config['FormVars'], \$Script[\$CurPage][\$IndexScript][\"valeur\"]))
		foreach (\${\$Script[\$CurPage][\$IndexScript][\"type\"]}[\$FormVars['type']] as \$Type=>\$value):
		if (\${\$Script[\$CurPage][\$IndexScript][\"type\"]}[\$FormVars['type']][\$Type][\"theme\"] != \$ThemeTemp and \$TypeCalcul == \"Defaut\"){
		\$Donnees .= '<tr><th colspan=\"2\" class=\"Theme\">'.\${\$Script[\$CurPage][\$IndexScript][\"type\"]}[\$FormVars['type']][\$Type]['theme'].'</th></tr>';
			\$ThemeTemp = \${\$Script[\$CurPage][\$IndexScript][\"type\"]}[\$FormVars['type']][\$Type]['theme'] ; 
			}
		\$Donnees .= DecodeVars (\$Script[\$CurPage][\$IndexScript][\"valeur\"], \${\$Script[\$CurPage][\$IndexScript][\"type\"]}[\$FormVars['type']][\$Type]) ;
		endforeach ;
		else
		\$Donnees .= \$Script[\$CurPage][\$IndexScript][\"valeur\"];
		}
		}

		return \$Donnees;\r\n"
		;

		$FinFonction = "}\r\n\r\n\r\n";

		$ScriptTableau = $FonctionTableau.$GlobalsVars.$InitialsVars.$ScriptTableau.$FinFonction.$FinPHP ;

		fputs ($FicResultats, $ScriptResultats.$ScriptTableau) ;
		fclose ($FicResultats);
		}
		else{

		$ScriptSuppl = "

		function resultats(){
		// Recuperation du dossier des calculs
		global \$Calcul, \$FormVars, \$locations ;
		\$NomFicLOG = \"Erreurs.txt\";
		\$LogErreurs = '';
		foreach (\$Calcul[\$FormVars['type']] as \$CurCalc => \$Val){
		// echo '<p>'.\$calcul[\$FormVars['type']].'</p>'; 
		if (\$Calcul[\$FormVars['type']][\$CurCalc]['valeur'] == '') {
		// echo \$CurCalc.'='.\$Calcul[\$FormVars['type']][\$CurCalc]['valeur'].\"<br />\";
		\$LogErreurs .= \$CurCalc.\"\\r\\n\";
		}
		}
		if (\$LogErreurs != ''){
		foreach (\$Calcul[\$FormVars['type']] as \$CurCalc => \$Val){
		// echo '<p>'.\$Calcul[\$FormVars['type']][\$CurCalc]['valeur'].'</p>'; 
		if (\$Calcul[\$FormVars['type']][\$CurCalc]['valeur'] != '') {
		\$LogErreurs .= \$CurCalc.\"=\".\$Calcul[\$FormVars['type']][\$CurCalc]['valeur'].\"\\r\\n\";
		}
		}
		////////////////////////////////////////////////////////////////////////////////
		// Ouverture du fichier LOG
		\$FicLOG = fopen(\"./\".\$locations['DonneesDir'].\"/\".\$NomFicLOG, \"w\") ;
		fputs (\$FicLOG, \$LogErreurs);
		fclose(\$FicLOG);
		echo \"<script language=\\\"javascript\\\">
		window.location = 'index.php?action=nouveau&type=\".\$FormVars['type'].\"';
		//history.back();
		</script>
		\";
		}
		}\r\n
		";
		$ScriptTableau = $DebutPHP.$ScriptSuppl.$FinPHP ;

		fputs ($FicResultats, $ScriptTableau) ;
		fclose ($FicResultats);
		}
	}
	else{
		Header ("Location:index.php") ;
	}
}
else{
	//Header ("Location:index.php") ;
}




?>
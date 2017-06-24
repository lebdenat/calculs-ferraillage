<?php

		function resultats(){
		// Recuperation du dossier des calculs
		global $Calcul, $FormVars, $locations ;
		$NomFicLOG = "Erreurs.txt";
		$LogErreurs = '';
		foreach ($Calcul[$FormVars['type']] as $CurCalc => $Val){
		// echo '<p>'.$calcul[$FormVars['type']].'</p>'; 
		if ($Calcul[$FormVars['type']][$CurCalc]['valeur'] == '') {
		// echo $CurCalc.'='.$Calcul[$FormVars['type']][$CurCalc]['valeur']."<br />";
		$LogErreurs .= $CurCalc."\r\n";
		}
		}
		if ($LogErreurs != ''){
		foreach ($Calcul[$FormVars['type']] as $CurCalc => $Val){
		// echo '<p>'.$Calcul[$FormVars['type']][$CurCalc]['valeur'].'</p>'; 
		if ($Calcul[$FormVars['type']][$CurCalc]['valeur'] != '') {
		$LogErreurs .= $CurCalc."=".$Calcul[$FormVars['type']][$CurCalc]['valeur']."\r\n";
		}
		}
		////////////////////////////////////////////////////////////////////////////////
		// Ouverture du fichier LOG
		$FicLOG = fopen("./".$locations['DonneesDir']."/".$NomFicLOG, "w") ;
		fputs ($FicLOG, $LogErreurs);
		fclose($FicLOG);
		echo "<script language=\"javascript\">
		window.location = 'index.php?action=nouveau&type=".$FormVars['type']."';
		//history.back();
		</script>
		";
		}
		}

		?>
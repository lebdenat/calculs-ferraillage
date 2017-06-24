<?php


function cree_expressions(){
	// Recuperation des variables
	global $FormVars,  $Calcul,$Operation, $Config ;
	foreach ($Operation[$FormVars['type']] as $cpt_ops => $op){
		// 0 : R&eacute;cup&eacute;ration de l'expression cod&eacute;e
		$Operation[$FormVars['type']][$cpt_ops]['expression'] = $op['script'] ;
		// 1 : Remplacer les calculs par leurs nom sans les tags
		foreach ($Calcul[$FormVars['type']] as $nom_calc => $calc){
			$Operation[$FormVars['type']][$cpt_ops]['expression'] = ereg_replace($Config['TagDebut'].$nom_calc.$Config['TagFin'], "<span class=\"expression\">".$nom_calc."</span>",$Operation[$FormVars['type']][$cpt_ops]['expression']) ;
		}
		// 2 : Remplacer les op&eacute;rations par leurs nom sans les tags
		foreach ($Operation[$FormVars['type']] as $nom_ops_tmp => $op_tmp){
			$Operation[$FormVars['type']][$cpt_ops]['expression'] = ereg_replace($Config['TagDebut'].$op_tmp['nom'].$Config['TagFin'], "<span class=\"expression\">".$op_tmp['nom']."</span>",$Operation[$FormVars['type']][$cpt_ops]['expression']) ;
		}
		$mots = array (
			'if( )' => array ('trans' => 'si ', 'class' => 'struct_ctrl'),
			'else' => array ('trans' => 'sinon ', 'class' => 'struct_ctrl'),
			'round' => array ('trans' => 'arrondi', 'class' => 'func'),
			'pow' => array ('trans' => 'puissance', 'class' => 'func'),
			'\*' => array ('trans' => ' x ', 'class' => ''),
			'sqrt' => array ('trans' => 'racine_carr&eacute;e', 'class' => 'func'),
			'\{' => array ('trans' => '{<br />', 'class' => ''),
			'\}' => array ('trans' => '}<br />', 'class' => '')
		);
		foreach ($mots as $nom_mot => $mot)
			$Operation[$FormVars['type']][$cpt_ops]['expression'] = ereg_replace($nom_mot, "<span class='".$mot['class']."'>".$mot['trans']."</span>", $Operation[$FormVars['type']][$cpt_ops]['expression']) ;
		//$Operation[$FormVars['type']][$cpt_ops]['expression'] = ereg_replace('\"(.)*\"', "ouille", $Operation[$FormVars['type']][$cpt_ops]['expression']) ;
		}
}

?>
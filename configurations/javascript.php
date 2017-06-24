<?php

/////////////////////////////////////////////////////////////////////////////
// 
// Script pour la v&eacute;rification des valeurs du formulaire pr&eacute;sent&eacute; pour le calcul en cours
//
////////////////////////////////////////////////////////////////////////////
if (isset ($FormVars['action']) and $FormVars['action']=="nouveau"){
$NomFicJs = "Calcul.js";
$ScriptJs = "function Verif(){

ListeErreurs  = new Array();
var NomCalculs = new Array();
var TitreCalculs = new Array();
TexteErreur = '<font face=\"Arial\" style=\"color:red;font-size:11px;font-weight:bold\">Veuillez remplir les champs auivants!!!</font><br /><font face=\"Arial\" style=\"color:red;font-size:11px\">';
";

$IndexCalcul = 0;
foreach ($Calcul[$FormVars['type']] as $CurCalcul){
$ScriptJs .= "NomCalculs[".$IndexCalcul."] = \"".$CurCalcul['nom']."\";\n";
$ScriptJs .= "TitreCalculs[".$IndexCalcul."] = \"".$CurCalcul['titre']."\";\n";
$IndexCalcul++ ;
}

$ScriptJs .= "
IndexErreur = -1;
for (i=0; i< NomCalculs.length; i++){
if (document.getElementsByName(NomCalculs[i])[0].value == ''){
ListeErreurs[IndexErreur+1] = TitreCalculs[i];
TexteErreur += '- '+ListeErreurs[IndexErreur+1]+'<br />';
IndexErreur ++;
}
}
TexteErreur += '</font>';
if (IndexErreur != -1){
alert (\"Des champs ne sont pas remplis!!!\");
document.getElementById(\"Erreur\").innerHTML = TexteErreur ;
return false;
}
else
return true;
}
";

////////////////////////////////////////////////////////////////////////////////
// Ouverture du fichier Js
$FicJs = fopen("./".$locations['AddOns']."/".$NomFicJs, "w") ;
fputs ($FicJs, $ScriptJs);
fclose($FicJs);
}


?>
<?php


// Debug mode
//define('DEBUG',false);

error_reporting(0);

///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Choix des differents dossiers
//
///////////////////////////////////////////////////////////////////////////////////////////////////

$locations = array (
					'App'=>"." ,
					'ConfigDir' => "configurations",
					'LibDir' => "librairies",
					'DonneesDir' => "donnees",
					'TplDir' => "templates",
					'AddOns' => "add-ons",
					'FicsDir' => "fichiers"
					);



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Charger les variables de configuration
//
///////////////////////////////////////////////////////////////////////////////////////////////////

include $locations['ConfigDir']."/site.php" ;



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Charger les variables de calculs et les operations
//
///////////////////////////////////////////////////////////////////////////////////////////////////

include $locations['ConfigDir']."/calculs.php" ;
// include $locations['ConfigDir']."/javascript.php" ;
include $locations['ConfigDir']."/operations.php" ;



///////////////////////////////////////////////////////////////////////////////////////////////////
//
// Execution des differentes fonctions appelees dans les librairies
//
///////////////////////////////////////////////////////////////////////////////////////////////////
// Dossiers contenant les librairies par defaut
$inc = array ($locations['LibDir'], $locations['AddOns']);


// Inclusion de toutes les librairies
 foreach ($inc as $Dir)
{
if ($handle = opendir($Dir)) 
{ 
   while (false !== ($phpfile = readdir($handle))) 
   {
   if ($phpfile != '..' and $phpfile != '.' and ereg ('\.php', $phpfile))
   {
   $inc_file= $Dir.'/'.$phpfile;
   include  $Dir.'/'.$phpfile ;
   }
   }
   closedir($handle);
}
}

$Donnees = principale();

echo $Donnees;



?>
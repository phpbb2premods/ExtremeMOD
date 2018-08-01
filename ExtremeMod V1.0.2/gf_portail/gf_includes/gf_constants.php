<?php

/*
 * Whoisonline 
 * On s'assure que la constante pour la page du portail est unique
 */

// On r�cup�re toutes les constantes d�finies
if (phpversion() >= 5)
{
	// Avec php5, on peut limiter les constantes � r�cup�rer
	$csts = get_defined_constants(true);
	$tableau = $csts['user'];
}
else
{
	$csts = get_defined_constants();
	$tableau = $csts;
}
$pages = array();
/* On va parcourir chaque constante et v�rifier s'il s'agit
   d'une constante de page de phpBB
   C'est un peu fastidieux et consommateur en ressources,
   mais �a fait une modification en moins lors de l'installation */
foreach ($tableau as $k => $v)
{
	// Si c'est bien le cas
	if (strpos($k, 'PAGE_') === 0)
	{
		// On stocke la valeur de la constante dans un tableau
		$pages[] = $v;
	}
}
// On attribue � la constante une valeur unique automatiquement
define('PAGE_PORTAL', min($pages) - 1);

/*
 * Permissions
 */

// Invit�
define('AUTH_INV', 10);
// Priv�
define('AUTH_ACLX', 11);

/*
 * Tables de la base de donn�es
 */

// Configuration du portail
define('PORTAL_TABLE', $table_prefix.'portal');
// Blocs du portail
define('PORTAL_MOD', $table_prefix.'portal_mod' );
// Structures du portail
define('PORTAL_STRUCT', $table_prefix.'portal_struct' );
// Param�tres des structures
define('PORTAL_PAGE', $table_prefix.'portal_page');

// Mod Blocs-Auth - Permissions des blocs du portail
define('AUTH_PORTAL_TABLE', $table_prefix.'auth_portal');

// Bloc Liens V2
define('LINKS_TABLE', $table_prefix.'portal_links');
// Bloc Menu V2.1 - Items des menus
define('NAVIG_TABLE', $table_prefix.'portal_navig') ; //mod menu portail
// Bloc Menu V2.1 - 
define('NAVMEN_TABLE', $table_prefix.'portal_navmen') ; //mod menu portail
// Bloc Menu V2.1 - Table de liaison Menus-Structures
define('PAGMEN_TABLE', $table_prefix.'portal_pagmen') ; //mod menu portail
// Bloc Welcome
define('PORTAL_WELCOME_TABLE', $table_prefix.'portal_welcome' ); 


?>
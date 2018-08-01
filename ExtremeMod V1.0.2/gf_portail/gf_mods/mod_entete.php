<?php

/***************************************************************************
 *                                mod_entete.php
 *                            -------------------
 *   fait le                : Samedi,26 Juillet, 2003
 *   Par : giefca - giefca@hotmail.com - http://www.gf-phpbb.fr.st
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Minimodule à intégrer dans un Gf-Portail
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_entete.tpl')
);

$template_mod->assign_vars(array(
		'URL_BKG' => $phpbb_root_path . '/templates/'  . $theme['template_name'] . '/images/gfpic.jpg',
		'URL_LOGO' => $phpbb_root_path . '/templates/'  . $theme['template_name'] . '/images/gfportail.jpg' )
	);
	
$modvar = $template_mod->pparse_mod('body');

?>
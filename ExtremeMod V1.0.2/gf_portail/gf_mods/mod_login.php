<?php

/***************************************************************************
 *                                mod_login.php
 *                            -------------------
 *   fait le                : Dimanche,20 Juillet, 2003
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
   'body' => 'mod_login.tpl')
);

$template_mod->assign_vars(array(
	'L_SEND_PASSWORD' => $lang['Forgotten_password'],
	'U_SEND_PASSWORD' => append_sid("profile.$phpEx?mode=sendpassword"),
	'L_REGISTER_NEW_ACCOUNT' => sprintf($lang['Register_new_account'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>'),
	'L_REMEMBER_ME' => $lang['Remember_me'],
	'AVATAR_IMG' => $avatar_img)
);
	
$modvar = $template_mod->pparse_mod('body');

?>
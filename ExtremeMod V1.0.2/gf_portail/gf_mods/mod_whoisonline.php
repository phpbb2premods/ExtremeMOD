<?php

/***************************************************************************
 *                                mod_whoisonline.php
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
   'body' => 'mod_whoisonline.tpl')
);

if( $userdata['session_logged_in'] )
{
	$template_mod->assign_block_vars( 'switch_user_logged_in' , array() );
}
else
{
	$template_mod->assign_block_vars( 'switch_user_logged_out' , array() );
}

$template_mod->assign_vars(array(
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'U_VIEWONLINE' => append_sid('viewonline.'.$phpEx),
	'L_VIEW_COMPLETE_LIST' => $lang['View_complete_list'])
);

$modvar = $template_mod->pparse_mod('body');

?>
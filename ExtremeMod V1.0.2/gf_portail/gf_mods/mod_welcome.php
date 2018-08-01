<?php

/***************************************************************************
 *                                mod_welcome.php
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
   'body' => 'mod_welcome.tpl')
);

 
if( $userdata['session_logged_in'] )
{
	$sql = "SELECT COUNT(post_id) as total
			FROM " . POSTS_TABLE . "
			WHERE post_time >= " . $userdata['user_lastvisit'];
	$result = $db->sql_query($sql);
	if( $result )
	{
		$row = $db->sql_fetchrow($result);
		$lang['Search_new'] = $lang['Search_new'] . "&nbsp;(" . $row['total'] . ")";
	}
}

// Avatar
$avatar_img = '';
if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
{
	switch( $userdata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	}
}
// Check For Anonymous User
if ($userdata['user_id'] != '-1')
{
	$name_link = '<a href="' . append_sid("profile.$phpEx?mode=editprofile&amp;" . $userdata['user_id']) . '">' . $userdata['username'] . '</a>';
}
else
{
	$name_link = $lang['Guest'];
	$avatar_img = $portal_config['guest_avatar'] ? '<img src="'. $images['guest_avatar'] .'" alt="" border="0" />' : '';
}
// END: Avatar

$template_mod->assign_vars(array(
//	'L_SEND_PASSWORD' => $lang['Forgotten_password'],
//	'U_SEND_PASSWORD' => append_sid("profile.$phpEx?mode=sendpassword"),
	'L_LOGOUT' => $lang['Logout'],
	'U_LOGOUT' => "login.$phpEx?logout=true&amp;redirect=portal.$phpEx&amp;sid=".$userdata['session_id'],
	'L_REGISTER_NEW_ACCOUNT' => sprintf($lang['Register_new_account'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>'),
	'L_REMEMBER_ME' => $lang['Remember_me'],
	'U_NAME_LINK' => $name_link,
	'L_NAME_WELCOME' => $lang['Welcome'],	
	'AVATAR_IMG' => $avatar_img)
);
	
$modvar = $template_mod->pparse_mod('body');

?>
<?php
/***************************************************************************
*                               pagestart_modo.php
*                              --------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

define('IN_ADMIN', true);
define('IN_MOD', true);
// Include files
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
$notmodo = "Vous n'êtes pas modérateur!";
if (!$userdata['session_logged_in'])
{
      message_die(GENERAL_MESSAGE, $userdata['username'] . ' vous n\'êtes  pas autorisé(e) à consulter cette page' );
//   redirect(append_sid("login.$phpEx?redirect=index.$phpEx", true));
}
else if (($userdata['user_level'] != ADMIN) && ($userdata['user_level'] != MOD))
//else if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

if ($HTTP_GET_VARS['sid'] != $userdata['session_id'])
{
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name'])), '', $HTTP_SERVER_VARS['REQUEST_URI']);
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path'])), '', $url);
	$url = str_replace('//', '/', $url);
	$url = preg_replace('/sid=([^&]*)(&?)/i', '', $url);
	$url = preg_replace('/\?$/', '', $url);
	$url .= ((strpos($url, '?')) ? '&' : '?') . 'sid=' . $userdata['session_id'];

	redirect("index.$phpEx?sid=" . $userdata['session_id']);
}
/*
if (!$userdata['session_admin']) 
{ 
     message_die(GENERAL_MESSAGE, $userdata['username'] . ' vous n\'êtes  pas autorisé(e) à consulter cette page 2' );
//   redirect(append_sid("login.$phpEx?redirect=index.$phpEx", true));
} 
*/
if (empty($no_page_header))
{
	// Not including the pageheader can be neccesarry if META tags are
	// needed in the calling script.
	include('./includes/page_header.'.$phpEx);
}

?>
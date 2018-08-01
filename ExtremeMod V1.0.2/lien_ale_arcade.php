<?php
/***************************************************************************
*                               lirn_ale_arcade.php
*                              ---------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if ( !$userdata['session_logged_in'] )
{
$sql = 'SELECT game_id, game_auth_acc FROM '. GAMES_TABLE .' WHERE game_auth_acc ORDER BY rand() LIMIT 0,1';
if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query games auth information", "", __LINE__, __FILE__, $sql);
	}

$row = $db->sql_fetchrow($result);
redirect(append_sid("games.$phpEx?gid=".$row['game_id']));
} else {
$sql = 'SELECT game_id FROM '. GAMES_TABLE .' ORDER BY rand() LIMIT 0,1';
if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
	}

$row = $db->sql_fetchrow($result);
redirect(append_sid("games.$phpEx?gid=".$row['game_id']));
}

?>
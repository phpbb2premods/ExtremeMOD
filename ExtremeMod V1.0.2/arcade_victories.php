<?php
/***************************************************************************
*                               arcadevictories.php
*                              ---------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);

$phpbb_root_path = './';
include($phpbb_root_path .'extension.inc');
include($phpbb_root_path .'common.'.$phpEx);

$user_id = intval($HTTP_GET_VARS['u']);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAQ);
init_userprefs($userdata);
//
// End session management
//

//
// Generate page
//
$page_title = $lang['Arcade_victories_title'];
$gen_simple_header = TRUE;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'arcade_victories' => 'arcade_victories_body.tpl')
  );

$sql = "SELECT game_id, game_pic, game_highuser, game_name, game_highscore
	FROM " . GAMES_TABLE . "
	WHERE game_highuser = $user_id
	ORDER BY game_name ASC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible d\'accéder à la table GAMES_TABLE', '', __LINE__, __FILE__, $sql);
}
$total_record = mysql_num_rows($result);

if ( $total_record )
{
	$template->assign_block_vars('record', array(
		'L_IMG' => $lang['Game_pic'],
		'L_GAME' => $lang['Game_name'],
		'L_SCORE'=> $lang['highscore']
	));

	while ( $gamer = $db->sql_fetchrow($result) )
	{
		$template->assign_block_vars('record.total_record', array(
			'GAME_NAME' => $gamer['game_name'],
			'U_GAME' => append_sid("games.$phpEx?gid=".$gamer['game_id']),
			'GAME_PIC'=> '<img src="games/pics/' . $gamer['game_pic'] . '" width="30" height="30" align="center" valign="middle" border="0" alt="' . $gamer['game_name'] . '" title="' . $gamer['game_name'] . '">',
			'GAME_SCORE'=> $gamer['game_highscore']
		));
	}
}

$victories = ( $total_record ) ? sprintf($lang['Winner'], $total_record) : $lang['No_Winner'];

//
// Send vars to template
//
$template->assign_vars(array(
	'PAGE_TITLE' => $page_title,
	'L_CLOSE_WINDOW' => '<a href="javascript:window.close();">' . $lang['Close_window'] . '</a>',
	'L_VICTORIES' => $victories
));

$template->pparse('arcade_victories');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
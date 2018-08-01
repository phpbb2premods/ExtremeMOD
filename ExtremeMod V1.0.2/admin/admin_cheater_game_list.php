<?php
/***************************************************************************
*                               admin_cheater_game_list.php
*                              -----------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Administration_Arcade_VPro']['Gestion_des_Cheaters'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
} else {
	$mode = "";
}

if ( $mode == 'delete_cheater' )
{
  $selected_check = ( isset($HTTP_POST_VARS['select_list']) ) ?  $HTTP_POST_VARS['select_list'] : array();
	$select_id_sql = '';
	$csc = count($selected_check);
	if($csc==0)
	{
		message_die(GENERAL_MESSAGE, 'Aucune ligne n\'est sélectionnée', '', __LINE__, __FILE__, $sql);
	}

	for($i = 0; $i < $csc; $i++)
	{
		$select_id_sql .= ( ( $select_id_sql != '' ) ? ', ' : '' ) . $selected_check[$i];
	}

  $sql = "DELETE FROM " . ARCADE_CHEATER_TABLE . "
  WHERE cheater_id IN ($select_id_sql) ";
  $result = $db->sql_query($sql);
  if( !$result )
  {
    message_die(GENERAL_ERROR, "Couldn't delete line", "", __LINE__, __FILE__, $sql);
  }
  unset($mode);
}

$template->set_filenames(array( "body" => "admin/arcade_cheater_game_list.tpl"));

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

$sql = "SELECT u.username, g.game_name, a.cheater_id, a.date_cheat, a.score_game, a.realtime, a.flashtime, a.cheattype
   FROM " . GAMES_TABLE . " g INNER JOIN " . ARCADE_CHEATER_TABLE . " a ON g.game_id = a.game_id
   LEFT JOIN ". USERS_TABLE . " u ON a.user_id = u.user_id
   ORDER BY a.date_cheat DESC, g.game_name ASC, u.username ASC LIMIT $start, " . $board_config['topics_per_page'];
$result = $db->sql_query($sql);
if( !$result )
{
	message_die(GENERAL_ERROR, 'Could not obtain cheaters information', "", __LINE__, __FILE__, $sql);
}
$cheaters = $db->sql_fetchrowset($result);

for($i = 0; $i < count($cheaters); $i++)
{
$template->assign_block_vars('ligne_cheat', array(
  'CHEATER_ID' => $cheaters[$i]['cheater_id'],
	'CHEATER_USERS' => $cheaters[$i]['username'],
	'CHEATER_GAME' => $cheaters[$i]['game_name'],
	'CHEATER_DATE_CHEAT' => create_date($board_config['default_dateformat'], $cheaters[$i]['date_cheat'], $board_config['board_timezone']),
	'CHEATER_SCORE' => $cheaters[$i]['score_game'],
	'CHEATER_TIME_CLIENT' => $cheaters[$i]['flashtime'],
	'CHEATER_TIME_SERVER' => $cheaters[$i]['realtime'],
	'CHEATER_TYPE' => $cheaters[$i]['cheattype']
	));
}

$sql = "SELECT count(*) AS total FROM " . ARCADE_CHEATER_TABLE ;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total cheaters', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
  $total_cheaters = $total['total'];
	$pagination = generate_pagination("admin_cheater_game_list.$phpEx?mode=$mode", $total_cheaters, $board_config['topics_per_page'], $start). '&nbsp;';
}

$template->assign_vars(array(
'L_TITLE' => $lang['admin_arcade_cheater_list'],
'L_EXPLAIN' => $lang['admin_arcade_cheater_list_explain'],
'DELETE_GAME' => $lang['Delete_game'],
'L_ACTION' => $lang['Action'],
'L_USER' => $lang['DB_Username'],
'L_GAME' => $lang['Game_name'],
'L_DATE_CHEAT' => $lang['Date_cheat'],
'L_SCORE' => $lang['Game_score'],
'L_TIME_CLIENT' => $lang['Time_client'],
'L_TIME_SERVER' => $lang['Time_server'],
'L_CHEAT_TYPE' => $lang['Type_triche'],
'L_ACTION' => $lang['Action'],
'L_DELETE' => $lang['Delete'],
'L_FOR_GAME_SELECTION' => $lang['For_game_selection'],
'ALL_CHECKED' => $lang['All_checked'],
'NOTHING_CHECKED' => $lang['Nothing_checked'],
'PAGINATION' => $pagination,
'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_cheaters / $board_config['topics_per_page'] )),
'L_GOTO_PAGE' => $lang['Goto_page'],
'S_ACTION' => append_sid("admin_cheater_game_list.$phpEx?mode=delete_cheater"))
);

// On affiche le bouton supprimer seulement s'il existe au moins un cheater dans la liste
if ( $total_cheaters>0 )
{
  $template->assign_block_vars('switch_liste_non_vide', array());
}

$template->pparse("body");
include('./page_footer_admin.'.$phpEx);

?>
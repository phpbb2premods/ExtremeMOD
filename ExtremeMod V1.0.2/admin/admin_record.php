<?php
/***************************************************************************
*                               admin_record.php
*                              ------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Administration_Arcade_VPro']['Gestion_des_Records'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

$template->set_filenames(array(
  'body' => 'admin/admin_record_body.tpl')
	);

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
} else {
	$mode = "";
}

if ( $mode == 'delete_records' )
{
  $selected_check = ( isset($HTTP_POST_VARS['select_list']) ) ?  $HTTP_POST_VARS['select_list'] : array();
	$select_id_sql = '';
	$csc = count($selected_check);
	if($csc==0)
	{
		message_die(GENERAL_MESSAGE, 'Aucun record n\'est sélectionné', '', __LINE__, __FILE__, $sql);
	}

	for($i = 0; $i < $csc; $i++)
	{
		$select_id_sql .= ( ( $select_id_sql != '' ) ? ', ' : '' ) . $selected_check[$i];
	}

  $sql = "DELETE FROM " . MODOADMINRECORD . "
  WHERE modo_record_id IN ($select_id_sql) ";
  $result = $db->sql_query($sql);
  if( !$result )
  {
    message_die(GENERAL_ERROR, "Impossible de supprimer les records", "", __LINE__, __FILE__, $sql);
  }
  unset($mode);
}
$sql = "SELECT m.*, c.game_name, c.game_id, u.user_id, u.username FROM " . MODOADMINRECORD . " m LEFT JOIN " . GAMES_TABLE . " c ON m.jeu = c.game_id LEFT JOIN " . USERS_TABLE ." u ON m.champion = u.user_id ORDER BY m.modo_record_id DESC " ;

$result = $db->sql_query($sql);
if( !$result )
{
	message_die(GENERAL_ERROR, 'Impossible d\'acceder à la table des records supprimés', "", __LINE__, __FILE__, $sql);
}
$records = $db->sql_fetchrowset($result);

for($i = 0; $i < count($records); $i++)
{
$template->assign_block_vars('ligne_records', array(
  'MDRA' => $records[$i]['modo_record_id'],
	'MDRB' => $records[$i]['moderateur'],
	'MDRC' => $records[$i]['game_name'],
	'MDRD' => create_date($board_config['default_dateformat'], $records[$i]['date_effacement'], $board_config['board_timezone']),
	'MDRE' => $records[$i]['username'],
	'MDRF' => $records[$i]['score'],
	'MDRG' => $records[$i]['commentaire']
	));
}

$sql = "SELECT count(*) AS total FROM " . MODOADMINRECORD . " "  ;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible d\'acceder à la table des records supprimés', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
   $total_records = $total['total'];
	$pagination = generate_pagination("admin_records.$phpEx?mode=$mode", $total_records, $board_config['topics_per_page'], $start). '&nbsp;';
}

$template->assign_vars(array(
'L_VER' => $lang['Admin_records_version'],
'L_MDRAA' => $lang['Admin_records_titre'],
'L_MDRA' => $lang['Admin_records_id'],
'L_MDRB' => $lang['Admin_records_moderateur'],
'L_MDRC' => $lang['Admin_records_jeu'],
'L_MDRD' => $lang['Admin_records_date'],
'L_MDRE' => $lang['Admin_records_champion'],
'L_MDRF' => $lang['Admin_records_score'],
'L_MDRG' => $lang['Admin_records_commentaire'],
'L_ACTION' => $lang['Action'],
'L_DELETE' => $lang['Delete'],
'L_FOR_GAME_SELECTION' => $lang['For_game_selection'],
'ALL_CHECKED' => $lang['All_checked'],
'NOTHING_CHECKED' => $lang['Nothing_checked'],
'PAGINATION' => $pagination,
'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_records / $board_config['topics_per_page'] )),
'L_GOTO_PAGE' => $lang['Goto_page'],
'S_ACTION' => append_sid("admin_record.$phpEx?mode=delete_records"))
);

// On affiche le bouton supprimer seulement s'il existe au moins un record dans la liste
if ( $total_records>0 )
{
  $template->assign_block_vars('switch_liste_non_vide', array());
}

$template->pparse("body");
include('./page_footer_admin.'.$phpEx);

?>
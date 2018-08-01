<?php
/***************************************************************************
*                               admin_arcade_del_guest.php
*                              ----------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Administration_Arcade_VPro']['Game_suppr_invités'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

$template->set_filenames(array(
	'body' => 'admin/admin_arcade_del_guest.tpl')
	);

$page_title = $lang['arcade_del_guest'];
$arcade_config = array();
$arcade_config = read_arcade_config();
$games_par_page = $arcade_config['page_guest_admin'];
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
} else {
	$mode = "";
}

if( isset($HTTP_POST_VARS['sort']) )
{ $sort_method = $HTTP_POST_VARS['sort']; } else if( isset($HTTP_GET_VARS['sort']) )
{ $sort_method = $HTTP_GET_VARS['sort']; } else { $sort_method = ''; }

if( isset($HTTP_POST_VARS['order']) )
{	$sort_order = $HTTP_POST_VARS['order']; } else if( isset($HTTP_GET_VARS['order']) )
{	$sort_order = $HTTP_GET_VARS['order']; } else {	$sort_order = 'ORDER BY game_id DESC'; }

if(! empty($mode))
{
  $selected_check = ( isset($HTTP_POST_VARS['select_del_game']) ) ?  $HTTP_POST_VARS['select_del_game'] : array();
	$select_id_sql = '';
	$tot = count($selected_check);

	for($i = 0; $i < $tot; $i++)
	{
		$select_id_sql .= ( ( $select_id_sql != '' ) ? ', ' : '' ) . $selected_check[$i];
	}
	if($tot >=1)
	{
   $sql = "UPDATE " . GAMES_TABLE . " SET game_auth_acc = 0
   WHERE game_id IN ($select_id_sql) ";
   $result = $db->sql_query($sql);
   if( !$result )
   {
      message_die(GENERAL_ERROR, "Impossible d'ajouter les jeux", "", __LINE__, __FILE__, $sql);
   }
	}
   unset($mode);
}

$sql = "SELECT count(*) AS total FROM " . GAMES_TABLE . " 
WHERE game_auth_acc = 1 ";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible d\'acceder à la liste des jeux invités', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
  $total_games = $total['total'];
  $pagination = generate_pagination("admin_arcade_del_guest.$phpEx?sort=$sort_method&amp;order=$sort_order", $total_games, $games_par_page, $start). '&nbsp;';
}

  $template->assign_vars(array(
  "TITLE" => $page_title,
	"L_SELECT_SORT_METHOD" => $lang['Select_sort_method'],
	"L_SORT" => $lang['Sort'],
	"L_SORT_DESCENDING" => $lang['Sort_Descending'],
	"L_SORT_ASCENDING" => $lang['Sort_Ascending'],
	"L_SORT" => $lang['Sort'],
	"L_ORDER" => $lang['Order'],
	"GAME_NAME_SELECTED" => ($sort_method == 'game_name') ? 'selected="selected"' : '',
	"GAME_SET_SELECTED" => ($sort_method == 'game_set') ? 'selected="selected"' : '',
	"GAME_HIGHSCORE_SELECTED" => ($sort_method == 'game_highscore') ? 'selected="selected"' : '',
	"GAME_ULTIMATE_HIGHSCORE_SELECTED" => ($sort_method == 'game_ultimate_highscore') ? 'selected="selected"' : '',
	"GAME_CAT_SELECTED" => ($sort_method == 'arcade_catid') ? 'selected="selected"' : '',
	"GAME_ID_SELECTED" => ($sort_method == 'game_id') ? 'selected="selected"' : '',
	"ASC_SELECTED" => ($sort_order != 'ASC') ? 'selected="selected"' : '',
	"DESC_SELECTED" => ($sort_order == 'DESC') ? 'selected="selected"' : '',
  "L_GAME_ID" => $lang['game_id'],
  "L_GAME_PIC" => $lang['game_pic'],
  "L_GAME_NAME" => $lang['game_name'],
  "L_GAME_SET" => $lang['game_set'],
  "L_GAME_HIGHSCORE" => $lang['game_highscore'],
  "L_GAME_ULTIMATE_HIGHSCORE" => $lang['game_ultimate_highscore'],
  "L_GAME_DESC" => $lang['game_desc'],
  "L_GAME_CAT" => $lang['cattitle'],
  "L_ACTION" => $lang['Action'],
  "L_DELETE" => $lang['Delete'],
  "L_FOR_GAME_SELECTION" => $lang['For_game_selection'],
  "ALL_CHECKED" => $lang['All_checked'],
  "NOTHING_CHECKED" => $lang['Nothing_checked'],
  "PAGINATION" => $pagination,
  "PAGE_NUMBER" => sprintf($lang['Page_of'], ( floor( $start / $games_par_page ) + 1 ), ceil( $total_games / $games_par_page )),
  "L_GOTO_PAGE" => $lang['Goto_page'],
  "TOTAL_GAMES" => $total_games,
  "S_ACTION" => append_sid("admin_arcade_del_guest.$phpEx?mode=$mode"))
  );

  // On affiche le bouton supprimer seulement s'il existe au moins un jeu dans la liste
  if ( $total_games>0 )
  {
    $template->assign_block_vars('switch_listedel_existante', array());
  }

  $sql = "SELECT g.game_id, g.game_pic, g.game_name, g.game_set, g.game_desc, g.game_highscore, g.game_ultimate_highscore, g.game_auth_acc, a.arcade_catid, a.arcade_cattitle
   FROM " . ARCADE_CATEGORIES_TABLE . " a 
   LEFT JOIN " . GAMES_TABLE . " g ON a.arcade_catid = g.arcade_catid
	 WHERE g.game_auth_acc = 1 
   " . $condition . "" . $sort_method . " " . $sort_order . "
	 LIMIT ".$start.",".$games_par_page;

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrowset($result);

  for($i = 0; $i < count($row); $i++)
  {
	$template->assign_block_vars('listedel', array(
  "GAME_ID" => $row[$i]['game_id'],
  "GAME_SET" => $row[$i]['game_set'],
  "GAME_DESC" => $row[$i]['game_desc'],
  "GAME_PIC" => '<img src="./../games/pics/' . $row[$i]['game_pic'] . '" alt="' . $row[$i]['game_name'] . '" title="' . $row[$i]['game_name'] . '" width="35" height="35" border="0">',
	"GAME_NAME" => '<nobr><a href="' . append_sid("./../games.$phpEx?gid=" . $row[$i]['game_id'] ) . '" alt="Cliquer ici pour ouvrir ' . $row[$i]['game_name'] . '" title="Cliquer ici pour ouvrir ' . $row[$i]['game_name'] . '">' . $row[$i]['game_name'] . '</a></nobr> ',
  "GAME_ULTIMATE_HIGHSCORE" => $row[$i]['game_ultimate_highscore'],
  "GAME_HIGHSCORE" => $row[$i]['game_highscore'],
	"CAT_NAME" => $row[$i]['arcade_cattitle'])
	);
  }

$db->sql_freeresult($result);
$template->pparse("body");
include('./page_footer_admin.'.$phpEx);

?>
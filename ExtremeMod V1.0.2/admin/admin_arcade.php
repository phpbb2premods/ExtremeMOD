<?php
/***************************************************************************
*                               admin_arcade.php
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
 $module['Administration_Arcade_VPro']['Configuration_arcade'] = "$file";
 return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

//
// Pull all config data
//
$sql = "SELECT *
  FROM " . ARCADE_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_arcade", "", __LINE__, __FILE__, $sql);
} else {
 while( $row = $db->sql_fetchrow($result) )
 {
	$arcade_name = $row['arcade_name'];
	$arcade_value = $row['arcade_value'];
	$default_arcade[$arcade_name] = $arcade_value;
	$new[$arcade_name] = ( isset($HTTP_POST_VARS[$arcade_name]) ) ? $HTTP_POST_VARS[$arcade_name] : $default_arcade[$arcade_name];

if( isset($HTTP_POST_VARS['submit']) )
 {
	$sql = "UPDATE " . ARCADE_TABLE . " SET
		arcade_value = '" . str_replace("\'", "''", $new[$arcade_name]) . "'
		WHERE arcade_name = '$arcade_name'";
  if( !$db->sql_query($sql) )
	 {
		message_die(GENERAL_ERROR, "Failed to update arcade configuration for $arcade_name", "", __LINE__, __FILE__, $sql);
	 }
	}
 }

if( isset($HTTP_POST_VARS['submit']) )
 {
	$message = $lang['Arcade_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_arcade_config'], "<a href=\"" . append_sid("admin_arcade.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
  message_die(GENERAL_MESSAGE, $message);
 }
}

$color_user = $new['color_user'];
$color_mod = $new['color_mod'];
$color_admin = $new['color_admin'];
$color_use_yes = ( $new['color_use'] ) ? "checked=\"checked\"" : "";
$color_use_no = ( !$new['color_use'] ) ? "checked=\"checked\"" : "";

$header_forum_yes = ( $new['forum_header'] ) ? "checked=\"checked\"" : "";
$header_forum_no = ( !$new['forum_header'] ) ? "checked=\"checked\"" : "";

$bodyline_yes = ( $new['bodyline'] ) ? "checked=\"checked\"" : "";
$bodyline_no = ( !$new['bodyline'] ) ? "checked=\"checked\"" : "";

$head_out_bodyline_yes = ( $new['head_out_bodyline'] ) ? "checked=\"checked\"" : "";
$head_out_bodyline_no = ( !$new['head_out_bodyline'] ) ? "checked=\"checked\"" : "";

$s_alpha = ( $new['game_order'] == 'Alpha' ) ? "selected" : "";
$s_popular = ( $new['game_order'] == 'Popular' ) ? "selected" : "";
$s_fixed = ( $new['game_order'] == 'Fixed') ? "selected" : "";
$s_random = ( $new['game_order'] == 'Random') ? "selected" : "";
$s_news = ( $new['game_order'] == 'News') ? "selected" : "";

$s_order  = "<option value='Alpha' $s_alpha >" . $lang['game_order_alpha'] . "</option>\n";
$s_order .= "<option value='Popular' $s_popular >" . $lang['game_order_popular'] . "</option>\n";
$s_order .= "<option value='Fixed' $s_fixed >" . $lang['game_order_fixed'] . "</option>\n";
$s_order .= "<option value='Random' $s_random >" . $lang['game_order_random'] . "</option>\n";
$s_order .= "<option value='News' $s_news >" . $lang['game_order_news'] . "</option>\n";

$use_category_mod_yes = ( $new['use_category_mod'] ) ? "checked=\"checked\"" : "";
$use_category_mod_no = ( !$new['use_category_mod'] ) ? "checked=\"checked\"" : "";

$display_winner_avatar_yes = ( $new['display_winner_avatar'] ) ? "checked=\"checked\"" : "";
$display_winner_avatar_no = ( !$new['display_winner_avatar'] ) ? "checked=\"checked\"" : "";

$display_ultime_winner_avatar_yes = ( $new['display_ultime_winner_avatar'] ) ? "checked=\"checked\"" : "";
$display_ultime_winner_avatar_no = ( !$new['display_ultime_winner_avatar'] ) ? "checked=\"checked\"" : "";

$winner_avatar_left = ( $new['winner_avatar_position']=='left' ) ? "checked=\"checked\"" : "";
$winner_avatar_right = ( $new['winner_avatar_position']!='left' ) ? "checked=\"checked\"" : "";

$winner_ultime_avatar_left = ( $new['winner_ultime_avatar_position']=='left' ) ? "checked=\"checked\"" : "";
$winner_ultime_avatar_right = ( $new['winner_ultime_avatar_position']!='left' ) ? "checked=\"checked\"" : "";

$scorerow_left = ( $new['scorerow_position']=='left' ) ? "checked=\"checked\"" : "";
$scorerow_right = ( $new['scorerow_position']!='left' ) ? "checked=\"checked\"" : "";

$s_linkcatittle_align_left = ( $new['linkcatittle_align'] == '0' ) ? "selected" : "";
$s_linkcatittle_align_center = ( $new['linkcatittle_align'] == '1' ) ? "selected" : "";
$s_linkcatittle_align_right = ( $new['linkcatittle_align'] == '2') ? "selected" : "";

$s_linkcatittle_align  = "<option value='0' $s_linkcatittle_align_left >" . $lang['linkcat_left'] . "</option>\n";
$s_linkcatittle_align .= "<option value='1' $s_linkcatittle_align_center >" . $lang['linkcat_center'] . "</option>\n";
$s_linkcatittle_align .= "<option value='2' $s_linkcatittle_align_right >" . $lang['linkcat_right'] . "</option>\n";

$s_linkcat_align_left = ( $new['linkcat_align'] == '0' ) ? "selected" : "";
$s_linkcat_align_center = ( $new['linkcat_align'] == '1' ) ? "selected" : "";
$s_linkcat_align_right = ( $new['linkcat_align'] == '2') ? "selected" : "";

$s_linkcat_align  = "<option value='0' $s_linkcat_align_left >" . $lang['linkcat_left'] . "</option>\n";
$s_linkcat_align .= "<option value='1' $s_linkcat_align_center >" . $lang['linkcat_center'] . "</option>\n";
$s_linkcat_align .= "<option value='2' $s_linkcat_align_right >" . $lang['linkcat_right'] . "</option>\n";

$limit_by_posts_yes = ( $new['limit_by_posts'] ) ? "checked=\"checked\"" : "";
$limit_by_posts_no = ( !$new['limit_by_posts'] ) ? "checked=\"checked\"" : "";

$limit_type_posts = ( $new['limit_type']=='posts' ) ? "checked=\"checked\"" : "";
$limit_type_date = ( $new['limit_type']=='date' ) ? "checked=\"checked\"" : "";

$use_points_mod_yes = ( $new['use_points_mod'] ) ? "checked=\"checked\"" : "";
$use_points_mod_no = ( !$new['use_points_mod'] ) ? "checked=\"checked\"" : "";

$use_points_win_mod_yes = ( $new['use_points_win_mod'] ) ? "checked=\"checked\"" : "";
$use_points_win_mod_no = ( !$new['use_points_win_mod'] ) ? "checked=\"checked\"" : "";

$use_points_pay_mod_yes = ( $new['use_points_pay_mod'] ) ? "checked=\"checked\"" : "";
$use_points_pay_mod_no = ( !$new['use_points_pay_mod'] ) ? "checked=\"checked\"" : "";

$use_points_pay_submit_yes = ( $new['use_points_pay_submit'] ) ? "checked=\"checked\"" : "";
$use_points_pay_submit_no = ( !$new['use_points_pay_submit'] ) ? "checked=\"checked\"" : "";

$use_points_pay_charging_yes = ( $new['use_points_pay_charging'] ) ? "checked=\"checked\"" : "";
$use_points_pay_charging_no = ( !$new['use_points_pay_charging'] ) ? "checked=\"checked\"" : "";

$points_winner = $new['points_winner'];
$points_pay = $new['points_pay'];

$pay_all_games_yes = ( $new['pay_all_games'] ) ? "checked=\"checked\"" : ""; 
$pay_all_games_no = ( !$new['pay_all_games'] ) ? "checked=\"checked\"" : "";

$prize_all_games_yes = ( $new['prize_all_games']==1 ) ? "checked=\"checked\"" : ""; 
$prize_all_games_no = ( !$new['prize_all_games'] ) ? "checked=\"checked\"" : "";

$prize_all_games_pgames = ( $new['prize_all_games']==2 ) ? "checked=\"checked\"" : "";

$arcade_vote_max = $new['rating_max'];

$use_arcade_vote_yes = ( $new['use_arcade_vote'] ) ? "checked=\"checked\"" : "";
$use_arcade_vote_no = ( !$new['use_arcade_vote'] ) ? "checked=\"checked\"" : "";

$use_fav_category_yes = ( $new['use_fav_category'] ) ? "checked=\"checked\"" : "";
$use_fav_category_no = ( !$new['use_fav_category'] ) ? "checked=\"checked\"" : "";

$use_hide_fav_yes = ( $new['use_hide_fav'] ) ? "checked=\"checked\"" : "";
$use_hide_fav_no = ( !$new['use_hide_fav'] ) ? "checked=\"checked\"" : "";

$games_cheater_submit_yes = ( $new['games_cheater_submit'] ) ? "checked=\"checked\"" : "";
$games_cheater_submit_no = ( !$new['games_cheater_submit'] ) ? "checked=\"checked\"" : "";

$game_pres_yes = ( $new['game_pres'] ) ? "checked=\"checked\"" : "";
$game_pres_no = ( !$new['game_pres'] ) ? "checked=\"checked\"" : "";

$message_pres_yes = ( $new['message_pres'] ) ? "checked=\"checked\"" : "";
$message_pres_no = ( !$new['message_pres'] ) ? "checked=\"checked\"" : "";

$auths_play_yes = ( $new['auths_play'] ) ? "checked=\"checked\"" : "";
$auths_play_no = ( !$new['auths_play'] ) ? "checked=\"checked\"" : "";

$auths_score_yes = ( $new['auths_score'] ) ? "checked=\"checked\"" : "";
$auths_score_no = ( !$new['auths_score'] ) ? "checked=\"checked\"" : "";

$auths_vote_yes = ( $new['auths_vote'] ) ? "checked=\"checked\"" : "";
$auths_vote_no = ( !$new['auths_vote'] ) ? "checked=\"checked\"" : "";

$auths_vote_hidden_yes = ( $new['auths_vote_hidden'] ) ? "checked=\"checked\"" : "";
$auths_vote_hidden_no = ( !$new['auths_vote_hidden'] ) ? "checked=\"checked\"" : "";

$topstats_see_yes = ( $new['topstats_see'] ) ? "checked=\"checked\"" : "";
$topstats_see_no = ( !$new['topstats_see'] ) ? "checked=\"checked\"" : "";

$champ_see_yes = ( $new['champ_see'] ) ? "checked=\"checked\"" : "";
$champ_see_no = ( !$new['champ_see'] ) ? "checked=\"checked\"" : "";

$heading_see_yes = ( $new['heading_see'] ) ? "checked=\"checked\"" : "";
$heading_see_no = ( !$new['heading_see'] ) ? "checked=\"checked\"" : "";

$whoisplay_see_yes = ( $new['whoisplay_see'] ) ? "checked=\"checked\"" : "";
$whoisplay_see_no = ( !$new['whoisplay_see'] ) ? "checked=\"checked\"" : "";

$cat_see_yes = ( $new['cat_see'] ) ? "checked=\"checked\"" : "";
$cat_see_no = ( !$new['cat_see'] ) ? "checked=\"checked\"" : "";

$favoris_see_yes = ( $new['favoris_see'] ) ? "checked=\"checked\"" : "";
$favoris_see_no = ( !$new['favoris_see'] ) ? "checked=\"checked\"" : "";

$favoris_seeg_yes = ( $new['favoris_seeg'] ) ? "checked=\"checked\"" : "";
$favoris_seeg_no = ( !$new['favoris_seeg'] ) ? "checked=\"checked\"" : "";

$topstats_seeg_yes = ( $new['topstats_seeg'] ) ? "checked=\"checked\"" : "";
$topstats_seeg_no = ( !$new['topstats_seeg'] ) ? "checked=\"checked\"" : "";

$champ_seeg_yes = ( $new['champ_seeg'] ) ? "checked=\"checked\"" : "";
$champ_seeg_no = ( !$new['champ_seeg'] ) ? "checked=\"checked\"" : "";

$heading_seeg_yes = ( $new['heading_seeg'] ) ? "checked=\"checked\"" : "";
$heading_seeg_no = ( !$new['heading_seeg'] ) ? "checked=\"checked\"" : "";

$whoisplay_seeg_yes = ( $new['whoisplay_seeg'] ) ? "checked=\"checked\"" : "";
$whoisplay_seeg_no = ( !$new['whoisplay_seeg'] ) ? "checked=\"checked\"" : "";

$cat_seeg_yes = ( $new['cat_seeg'] ) ? "checked=\"checked\"" : "";
$cat_seeg_no = ( !$new['cat_seeg'] ) ? "checked=\"checked\"" : "";

include( $phpbb_root_path . 'includes/functions_arcade_championnat.'.$phpEx);
include( $phpbb_root_path . 'includes/functions_arcade.'.$phpEx);

$arcade_config = array();
$arcade_config = read_arcade_config();
$version_arcade = $arcade_config['version_arcade'];

$championnat_cat_select = championnat_cat_select($new['championnat_cat'], 'championnat_cat');
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
} else {
	$mode = "";
}

if( isset($HTTP_POST_VARS['recreate_comments']) || isset($HTTP_GET_VARS['recreate_comments']) )
{
	recreate_comments();
}
if( isset($HTTP_POST_VARS['recreate_comments']) )
{
	$message = "<b>Vider la table Comments: </b><font color=green>OK!</font><br /><b>Insert Game ID: </b><font color=green>OK!</font><br /><br />La table comments à été supprimée puis recrée avec succés.<br /><br />" . sprintf($lang['Click_return_arcade_config'], "<a href=\"" . append_sid("admin_arcade.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}
	
if( isset($HTTP_POST_VARS['reset']) || isset($HTTP_GET_VARS['reset']) )
{
	arcade_championnat_reset();
}
if( isset($HTTP_POST_VARS['cagnotte_distrib']) || isset($HTTP_GET_VARS['cagnotte_distrib']) )
{
	distrib_cagnotte();
}

$championnat_points_one = $new['championnat_points_one'];
$championnat_points_two = $new['championnat_points_two'];
$championnat_points_three = $new['championnat_points_three'];
$championnat_points_four = $new['championnat_points_four'];
$championnat_points_five = $new['championnat_points_five'];
$championnat_points_six = $new['championnat_points_six'];
$championnat_points_seven = $new['championnat_points_seven'];
$championnat_points_eight = $new['championnat_points_eight'];
$championnat_points_nine = $new['championnat_points_nine'];
$championnat_points_ten = $new['championnat_points_ten'];
$championnat_points_eleven = $new['championnat_points_eleven'];
$championnat_points_twelve = $new['championnat_points_twelve'];
$championnat_points_thirteen = $new['championnat_points_thirteen'];
$championnat_points_fourteen = $new['championnat_points_fourteen'];
$championnat_points_fiveteen = $new['championnat_points_fiveteen'];
$championnat_points_sixteen = $new['championnat_points_sixteen'];
$championnat_points_seventeen = $new['championnat_points_seventeen'];
$championnat_points_eighteen = $new['championnat_points_eighteen'];
$championnat_points_nineteen = $new['championnat_points_nineteen'];
$championnat_points_twenty = $new['championnat_points_twenty'];
$use_cagnotte_mod_yes = ( $new['use_cagnotte_mod'] ) ? "checked=\"checked\"" : "";
$use_cagnotte_mod_no = ( !$new['use_cagnotte_mod'] ) ? "checked=\"checked\"" : "";
$use_points_cagnotte_yes = ( $new['use_points_cagnotte'] ) ? "checked=\"checked\"" : "";
$use_points_cagnotte_no = ( !$new['use_points_cagnotte'] ) ? "checked=\"checked\"" : "";
$cat_use_yes = ( $new['cat_use'] ) ? "checked=\"checked\"" : "";
$cat_use_no = ( !$new['cat_use'] ) ? "checked=\"checked\"" : "";
$cagnotte = $new['cagnotte'];
$championnat_taux_un = $new['championnat_taux_un'];
$championnat_taux_deux = $new['championnat_taux_deux'];
$championnat_taux_trois = $new['championnat_taux_trois'];
$championnat_taux_quatre = $new['championnat_taux_quatre'];
$championnat_taux_cinq = $new['championnat_taux_cinq'];
$championnat_taux_six = $new['championnat_taux_six'];
$championnat_taux_sept = $new['championnat_taux_sept'];
$championnat_taux_huit = $new['championnat_taux_huit'];
$championnat_taux_neuf = $new['championnat_taux_neuf'];
$championnat_taux_dix = $new['championnat_taux_dix'];
$day_distrib = $new['day_distrib'];
$page_guest_admin = $new['page_guest_admin'];
$use_auto_distrib_yes = ( $new['use_auto_distrib'] ) ? "checked=\"checked\"" : "";
$use_auto_distrib_no = ( !$new['use_auto_distrib'] ) ? "checked=\"checked\"" : "";

$template->set_filenames(array(
	"body" => "admin/arcade_config_body.tpl")
  );

$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_arcade.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
  "L_VERSION_ARCADE_SETTINGS" => $lang['version_arcade_explain'],
	"L_CONFIGURATION_TITLE" => $lang['Arcade_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Arcade_config_explain'],
	"L_GENERAL_SETTINGS" => $lang['General_arcade_settings'],
	"L_STATARCADE_SETTINGS" => $lang['statarcade_settings'],
	"L_GAMES_AREA_SETTINGS" => $lang['games_area_settings'],
	"L_USE_CATEGORY_MOD" => $lang['use_category_mod'],
	"L_USE_CATEGORY_MOD_EXPLAIN" => $lang['use_category_mod_explain'],
	"L_CATEGORY_PREVIEW_GAMES" => $lang['category_preview_games'],
	"L_CATEGORY_PREVIEW_GAMES_EXPLAIN" => $lang['category_preview_games_explain'],
	"L_GAMES_PAR_PAGE" => $lang['games_par_page'],
	"L_GAMES_PAR_PAGE_EXPLAIN" => $lang['games_par_page_explain'],
	"L_GAME_ORDER" => $lang['games_order'],
	"L_GAME_ORDER_EXPLAIN" => $lang['games_order_explain'],
	"L_SCORE_POSITION" => $lang['score_position'],
	"L_SCORE_POSITION_EXPLAIN" => $lang['score_position_explain'],
	"L_SCORE_RIGHT" => $lang['Right_score'],
	"L_SCORE_LEFT" => $lang['Left_score'],
	"L_DISPLAY_WINNER_AVATAR" => $lang['display_winner_avatar'],
	"L_DISPLAY_WINNER_AVATAR_EXPLAIN" => $lang['display_winner_avatar_explain'],
	"L_DISPLAY_ULTIME_WINNER_AVATAR" => $lang['display_ultime_winner_avatar'],
	"L_DISPLAY_ULTIME_WINNER_AVATAR_EXPLAIN" => $lang['display_ultime_winner_avatar_explain'],
	"L_WINNER_AVATAR_POSITION" => $lang['winner_avatar_position'],
	"L_WINNER_AVATAR_POSITION_EXPLAIN" => $lang['winner_avatar_position_explain'],
	"L_WINNER_ULTIME_AVATAR_POSITION" => $lang['winner_ultime_avatar_position'],
	"L_WINNER_ULTIME_AVATAR_POSITION_EXPLAIN" => $lang['winner_ultime_avatar_position_explain'],
	"L_RIGHT" => $lang['Right_avatar'],
	"L_LEFT" => $lang['Left_avatar'],
	"L_MAXSIZE_AVATAR" => $lang['maxsize_avatar'],
	"L_MAXSIZE_AVATAR_EXPLAIN" => $lang['maxsize_avatar_explain'],
	"L_STAT_PAR_PAGE" => $lang['stat_par_page'],
	"L_STAT_PAR_PAGE_EXPLAIN" => $lang['stat_par_page_explain'],
	"L_LINKCAT_ALIGN" => $lang['linkcat_align'],
	"L_LINKCAT_ALIGN_EXPLAIN" => $lang['linkcat_align_explain'],
	"L_LINKCATITTLE_ALIGN" => $lang['linkcatittle_align'],
	"L_LINKCATITTLE_ALIGN_EXPLAIN" => $lang['linkcatittle_align_explain'],
	"L_POSTS_ONLY" => $lang['posts_only'],
	"L_POSTS_DATE" => $lang['posts_date'],
	"L_LIMIT_TYPE" => $lang['limit_type'],
	"L_LIMIT_TYPE_EXPLAIN" => $lang['limit_type_explain'],
	"L_GAME_ACCESS_SETTINGS" => $lang['game_access_settings'],
	"L_LIMIT_BY_POSTS" => $lang['limit_by_posts'],
	"L_POSTS_NEEDED" => $lang['posts_needed'],
	"L_DAYS_LIMIT" => $lang['days_limit'],
	"L_LIMIT_BY_POSTS_EXPLAIN" => $lang['limit_by_posts_explain'],
	"L_POSTS_NEEDED_EXPLAIN" => $lang['posts_needed_explain'],
	"L_DAYS_LIMIT_EXPLAIN" => $lang['days_limit_explain'],
	"L_POINTS_ARCADE_AREA_SETTINGS" => $lang['points_arcade_area_settings'],
	"L_USE_POINTS_MOD" => $lang['use_points_mod'],
	"L_USE_POINTS_MOD_EXPLAIN" => $lang['use_points_mod_explain'],
	"L_USE_POINTS_WIN_MOD" => $lang['use_points_win_mod'],
	"L_USE_POINTS_WIN_MOD_EXPLAIN" => $lang['use_points_win_mod_explain'],
	"L_USE_POINTS_PAY_MOD" => $lang['use_points_pay_mod'],
	"L_USE_POINTS_PAY_MOD_EXPLAIN" => $lang['use_points_pay_mod_explain'],
	"L_USE_POINTS_PAY_CHARGING" => $lang['use_points_pay_charging'],
	"L_USE_POINTS_PAY_CHARGING_EXPLAIN" => $lang['use_points_pay_charging_explain'],
	"L_USE_POINTS_PAY_SUBMIT" => $lang['use_points_pay_submit'],
	"L_USE_POINTS_PAY_SUBMIT_EXPLAIN" => $lang['use_points_pay_submit_explain'],
	"L_POINTS_WINNER" => $lang['points_winner'],
	"L_POINTS_PAY" => $lang['points_pay'],
	"L_POINTS_WINNER_EXPLAIN" => $lang['points_winner_explain'],
	"L_POINTS_PAY_EXPLAIN" => $lang['points_pay_explain'],
	"L_RATING_AREA" => $lang['rating_area'],
	"L_RATING_MAX" => $lang['rating_max'],
	"L_RATING_MAX_EXPLAIN" => $lang['rating_max_explain'],
	"L_USE_ARCADE_VOTE" => $lang['use_arcade_vote'],
	"L_USE_ARCADE_VOTE_EXPLAIN" => $lang['use_arcade_vote_explain'],
	"L_USE_FAV_CATEGORY" => $lang['use_fav_category'],
	"L_USE_FAV_CATEGORY_EXPLAIN" => $lang['use_fav_category_explain'],
	"L_NBR_GAMES_FAV" => $lang['nbr_games_fav'],
  "L_NBR_GAMES_FAV_EXPLAIN" => $lang['nbr_games_fav_explain'],
	"L_FAV_SETTINGS" => $lang['Favoris_settings'],
	"L_USE_HIDE_FAV" => $lang['use_hide_fav'],
	"L_USE_HIDE_FAV_EXPLAIN" => $lang['use_hide_fav_explain'],
	"L_FAV_NBR_IN_PAGE" => $lang['fav_nbr_in_page'],
	"L_FAV_NBR_IN_PAGE_EXPLAIN" => $lang['fav_nbr_in_page_explain'],
	"L_ALL" => $lang['All'],
	"L_ALL_EXPLAIN" => $lang['All_explain'],
	"L_EACH_GAME" => $lang['Each_game'],
	"L_ALL_EXPLAIN_G" => $lang['All_explain_g'],
	"L_PAYING_GAMES" => $lang['Paying_games'],
	"L_GAMES_CHEATER_SUBMIT" => $lang['games_cheater_submit'],
	"L_GAMES_CHEATER_SUBMIT_EXPLAIN" => $lang['games_cheater_submit_explain'],
	"L_GAMES_TIME_TOLERANCE" => $lang['games_time_tolerance'],
	"L_GAMES_TIME_TOLERANCE_EXPLAIN" => $lang['games_time_tolerance_explain'],
	"L_QUOTA_SETTINGS" => $lang['Quota_arcade_settings'],
	"L_NB_PARTIES" => $lang['Nb_parties_quota'],
	"L_NB_PARTIES_EXPLAIN" => $lang['Nb_parties_quota_explain'],
	"L_PRESENT_SETTINGS" => $lang['present_setting'],
	"L_PRESENT_FID" => $lang['present_fid'],
	"L_PRES_GAME" => $lang['use_pres'],
	"L_PRES_EXPLAIN" => $lang['use_pres_explain'],
  "L_AUTHS_ARCA_SETTINGS" => $lang['auths_arca_setting'],
	"L_AUTHS_PLAY" => $lang['auths_play'],
	"L_AUTHS_PLAY_EXPLAIN" => $lang['auths_play_explain'],
	"L_AUTHS_SCORE" => $lang['auths_score'],
	"L_AUTHS_SCORE_EXPLAIN" => $lang['auths_score_explain'],
	"L_AUTHS_VOTE" => $lang['auths_vote_arcade'],
	"L_AUTHS_VOTE_EXPLAIN" => $lang['auths_vote_arcade_explain'],
	"L_AUTHS_VOTE_HIDDEN" => $lang['auths_vote_hidden_arcade'],
	"L_AUTHS_VOTE_HIDDEN_EXPLAIN" => $lang['auths_vote_hidden_arcade_explain'],
	"L_AUTHS_LIMIT_GAME" => $lang['auths_limit_games'],
	"L_AUTHS_LIMIT_GAME_EXPLAIN" => $lang['auths_limit_games_explain'],
	"L_CHAMPIONNAT_POINTS_ONE" => $lang['championnat_points_one'],
	"L_CHAMPIONNAT_POINTS_ONE_EXPLAIN" => $lang['championnat_points_one_explain'],
	"L_CHAMPIONNAT_POINTS_TWO" => $lang['championnat_points_two'],
	"L_CHAMPIONNAT_POINTS_TWO_EXPLAIN" => $lang['championnat_points_two_explain'],
	"L_CHAMPIONNAT_POINTS_THREE" => $lang['championnat_points_three'],
	"L_CHAMPIONNAT_POINTS_THREE_EXPLAIN" => $lang['championnat_points_three_explain'],
	"L_CHAMPIONNAT_POINTS_FOUR" => $lang['championnat_points_four'],
	"L_CHAMPIONNAT_POINTS_FOUR_EXPLAIN" => $lang['championnat_points_four_explain'],
	"L_CHAMPIONNAT_POINTS_FIVE" => $lang['championnat_points_five'],
	"L_CHAMPIONNAT_POINTS_FIVE_EXPLAIN" => $lang['championnat_points_five_explain'],
	"L_CHAMPIONNAT_RESET" => $lang['championnat_reset'],
	"L_ARCADE_CHAMPIONNAT_AREA_SETTINGS" => $lang['arcade_championnat_area_settings'],
	"L_USE_CAGNOTTE_MOD" => $lang['use_cagnotte_mod'],
	"L_USE_CAGNOTTE_MOD_EXPLAIN" => $lang['use_cagnotte_mod_explain'],
	"L_USE_AUTO_DISTRIB" => $lang['use_auto_distrib'],
	"L_USE_AUTO_DISTRIB_EXPLAIN" => $lang['use_auto_distrib_explain'],
	"L_CAT_USE" => $lang['cat_use'],
	"L_CAT_USE_EXPLAIN" => $lang['cat_use_explain'],
	"L_USE_POINTS_CAGNOTTE" => $lang['use_points_cagnotte'],
	"L_USE_POINTS_CAGNOTTE_EXPLAIN" => $lang['use_points_cagnotte_explain'],
	"L_CAGNOTTE" => $lang['cagnotte'],
	"L_CAGNOTTE_EXPLAIN" => $lang['cagnotte_explain'],
	"L_CAGNOTTE_DISTRIB" => $lang['cagnotte_distrib'],
	"L_CHAMPIONNAT_CATEGORIE" => $lang['championnat_categorie'],
	"L_CHAMPIONNAT_CATEGORIE_EXPLAIN" => $lang['championnat_categorie_explain'],
	"L_CHAMPIONNAT_TAUX_UN" => $lang['championnat_taux_un'],
	"L_CHAMPIONNAT_TAUX_DEUX" => $lang['championnat_taux_deux'],
	"L_CHAMPIONNAT_TAUX_TROIS" => $lang['championnat_taux_trois'],
	"L_CHAMPIONNAT_TAUX_QUATRE" => $lang['championnat_taux_quatre'],
	"L_CHAMPIONNAT_TAUX_CINQ" => $lang['championnat_taux_cinq'],
	"L_CHAMPIONNAT_TAUX_SIX" => $lang['championnat_taux_six'],
	"L_CHAMPIONNAT_TAUX_SEPT" => $lang['championnat_taux_sept'],
	"L_CHAMPIONNAT_TAUX_HUIT" => $lang['championnat_taux_huit'],
	"L_CHAMPIONNAT_TAUX_NEUF" => $lang['championnat_taux_neuf'],
	"L_CHAMPIONNAT_TAUX_DIX" => $lang['championnat_taux_dix'],
	"L_CHAMPIONNAT_POINTS_SIX" => $lang['championnat_points_six'],
	"L_CHAMPIONNAT_POINTS_SIX_EXPLAIN" => $lang['championnat_points_six_explain'],
	"L_CHAMPIONNAT_POINTS_SEVEN" => $lang['championnat_points_seven'],
	"L_CHAMPIONNAT_POINTS_SEVEN_EXPLAIN" => $lang['championnat_points_seven_explain'],
	"L_CHAMPIONNAT_POINTS_EIGHT" => $lang['championnat_points_eight'],
	"L_CHAMPIONNAT_POINTS_EIGHT_EXPLAIN" => $lang['championnat_points_eight_explain'],
	"L_CHAMPIONNAT_POINTS_NINE" => $lang['championnat_points_nine'],
	"L_CHAMPIONNAT_POINTS_NINE_EXPLAIN" => $lang['championnat_points_nine_explain'],
	"L_CHAMPIONNAT_POINTS_TEN" => $lang['championnat_points_ten'],
	"L_CHAMPIONNAT_POINTS_TEN_EXPLAIN" => $lang['championnat_points_ten_explain'],
	"L_CHAMPIONNAT_POINTS_ELEVEN" => $lang['championnat_points_eleven'],
	"L_CHAMPIONNAT_POINTS_ELEVEN_EXPLAIN" => $lang['championnat_points_eleven_explain'],
	"L_CHAMPIONNAT_POINTS_TWELVE" => $lang['championnat_points_twelve'],
	"L_CHAMPIONNAT_POINTS_TWELVE_EXPLAIN" => $lang['championnat_points_twelve_explain'],
	"L_CHAMPIONNAT_POINTS_THIRTEEN" => $lang['championnat_points_thirteen'],
	"L_CHAMPIONNAT_POINTS_THIRTEEN_EXPLAIN" => $lang['championnat_points_thirteen_explain'],
	"L_CHAMPIONNAT_POINTS_FOURTEEN" => $lang['championnat_points_fourteen'],
	"L_CHAMPIONNAT_POINTS_FOURTEEN_EXPLAIN" => $lang['championnat_points_fourteen_explain'],
	"L_CHAMPIONNAT_POINTS_FIVETEEN" => $lang['championnat_points_fiveteen'],
	"L_CHAMPIONNAT_POINTS_FIVETEEN_EXPLAIN" => $lang['championnat_points_fiveteen_explain'],
	"L_CHAMPIONNAT_POINTS_SIXTEEN" => $lang['championnat_points_sixteen'],
	"L_CHAMPIONNAT_POINTS_SIXTEEN_EXPLAIN" => $lang['championnat_points_sixteen_explain'],
	"L_CHAMPIONNAT_POINTS_SEVENTEEN" => $lang['championnat_points_seventeen'],
	"L_CHAMPIONNAT_POINTS_SEVENTEEN_EXPLAIN" => $lang['championnat_points_seventeen_explain'],
	"L_CHAMPIONNAT_POINTS_EIGHTEEN" => $lang['championnat_points_eighteen'],
	"L_CHAMPIONNAT_POINTS_EIGHTEEN_EXPLAIN" => $lang['championnat_points_eighteen_explain'],
	"L_CHAMPIONNAT_POINTS_NINETEEN" => $lang['championnat_points_nineteen'],
	"L_CHAMPIONNAT_POINTS_NINETEEN_EXPLAIN" => $lang['championnat_points_nineteen_explain'],
	"L_CHAMPIONNAT_POINTS_TWENTY" => $lang['championnat_points_twenty'],
	"L_CHAMPIONNAT_POINTS_TWENTY_EXPLAIN" => $lang['championnat_points_twenty_explain'],
	"L_CHAMPIONNAT_TAUX" => $lang['championnat_taux'],
	"L_CHAMPIONNAT_TAUX_EXPLAIN" => $lang['championnat_taux_explain'],
	"L_DAY_DISTRIB" => $lang['day_distrib'],
	"L_DAY_DISTRIB_EXPLAIN" => $lang['day_distrib_explain'],
	"L_COMMENTS_RECREATE" => $lang['comments_recreate'],
	"L_COMMENTS_RESYNCH_EXPLAIN" => $lang['comments_resynch'],
	"L_COMMENTS_RECREATE_EXPLAIN" => $lang['comments_recreate_explain'],
	"L_TABLES_SEE" => $lang['table_see'],
	"L_CHAMP_SEE" => $lang['champ_see'],
	"L_CHAMP_SEE_EXPLAIN" => $lang['champ_see_explain'],
	"L_HEADING_SEE" => $lang['heading_see'],
	"L_HEADING_SEE_EXPLAIN" => $lang['heading_see_explain'],
	"L_TOPSTATS_SEE" => $lang['topstats_see'],
	"L_TOPSTATS_SEE_EXPLAIN" => $lang['topstats_see_explain'],
	"L_WHOISPLAY_SEE" => $lang['whoisplay_see'],
	"L_WHOISPLAY_SEE_EXPLAIN" => $lang['whoisplay_see_explain'],
	"L_CAT_SEE" => $lang['cat_see'],
	"L_CAT_SEE_EXPLAIN" => $lang['cat_see_explain'],
	"L_FAVORIS_SEE" => $lang['favoris_see'],
	"L_FAVORIS_SEE_EXPLAIN" => $lang['favoris_see_explain'],
	"L_TABLES_SEEG" => $lang['table_seeg'],
	"L_CHAMP_SEEG" => $lang['champ_seeg'],
	"L_CHAMP_SEEG_EXPLAIN" => $lang['champ_seeg_explain'],
	"L_HEADING_SEEG" => $lang['heading_seeg'],
	"L_HEADING_SEEG_EXPLAIN" => $lang['heading_seeg_explain'],
	"L_TOPSTATS_SEEG" => $lang['topstats_seeg'],
	"L_TOPSTATS_SEEG_EXPLAIN" => $lang['topstats_see_explain'],
	"L_WHOISPLAY_SEEG" => $lang['whoisplay_seeg'],
	"L_WHOISPLAY_SEEG_EXPLAIN" => $lang['whoisplay_seeg_explain'],
	"L_CAT_SEEG" => $lang['cat_seeg'],
	"L_CAT_SEEG_EXPLAIN" => $lang['cat_seeg_explain'],
	"L_FAVORIS_SEEG" => $lang['favoris_seeg'],
	"L_FAVORIS_SEEG_EXPLAIN" => $lang['favoris_seeg_explain'],
	"L_REDIRECTION_PRES" => $lang['redirection_pres'],
	"L_REDIRECTION_PRES_EXPLAIN" => $lang['redirection_pres_explain'],
	"L_COLOR_USER" => $lang['color_user'],
	"L_COLOR_MOD" => $lang['color_mod'],
	"L_COLOR_ADMIN" => $lang['color_admin'],
	"L_COLOR_USE" => $lang['color_use'],

	"S_HEADING_SEEG_YES" => $heading_seeg_yes,
	"S_HEADING_SEEG_NO" => $heading_seeg_no,
	"S_CHAMP_SEEG_YES" => $champ_seeg_yes,
	"S_CHAMP_SEEG_NO" => $champ_seeg_no,
	"S_TOPSTATS_SEEG_YES" => $topstats_seeg_yes,
	"S_TOPSTATS_SEEG_NO" => $topstats_seeg_no,
	"S_FAVORIS_SEEG_YES" => $favoris_seeg_yes,
	"S_FAVORIS_SEEG_NO" => $favoris_seeg_no,
	"S_WHOISPLAY_SEEG_YES" => $whoisplay_seeg_yes,
	"S_WHOISPLAY_SEEG_NO" => $whoisplay_seeg_no,
	"S_CAT_SEEG_YES" => $cat_seeg_yes,
	"S_CAT_SEEG_NO" => $cat_seeg_no,
	"S_HEADING_SEE_YES" => $heading_see_yes,
	"S_HEADING_SEE_NO" => $heading_see_no,
	"S_CHAMP_SEE_YES" => $champ_see_yes,
	"S_CHAMP_SEE_NO" => $champ_see_no,
	"S_TOPSTATS_SEE_YES" => $topstats_see_yes,
	"S_TOPSTATS_SEE_NO" => $topstats_see_no,
	"S_WHOISPLAY_SEE_YES" => $whoisplay_see_yes,
	"S_WHOISPLAY_SEE_NO" => $whoisplay_see_no,
	"S_CAT_SEE_YES" => $cat_see_yes,
	"S_CAT_SEE_NO" => $cat_see_no,
	"S_FAVORIS_SEE_YES" => $favoris_see_yes,
	"S_FAVORIS_SEE_NO" => $favoris_see_no,
	"S_GAME_PRES_YES" => $game_pres_yes,
	"S_GAME_PRES_NO" => $game_pres_no,
	"S_MESSAGE_PRES_YES" => $message_pres_yes,
	"S_MESSAGE_PRES_NO" => $message_pres_no,
	"S_CATEGORY_PREVIEW_GAMES" => intval($new['category_preview_games']),
	"S_GAMES_PAR_PAGE" => intval($new['games_par_page']),
	"S_STAT_PAR_PAGE" => intval($new['stat_par_page']),
	"S_GAME_ORDER" => $s_order,
	"S_USE_CATEGORY_MOD_YES" => $use_category_mod_yes,
	"S_USE_CATEGORY_MOD_NO" => $use_category_mod_no,
	"S_DISPLAY_WINNER_AVATAR_YES" => $display_winner_avatar_yes,
	"S_DISPLAY_WINNER_AVATAR_NO" => $display_winner_avatar_no,
	"S_DISPLAY_ULTIME_WINNER_AVATAR_YES" => $display_ultime_winner_avatar_yes,
	"S_DISPLAY_ULTIME_WINNER_AVATAR_NO" => $display_ultime_winner_avatar_no,
	"S_WINNER_AVATAR_LEFT" => $winner_avatar_left,
	"S_WINNER_AVATAR_RIGHT" => $winner_avatar_right,
	"S_WINNER_ULTIME_AVATAR_LEFT" => $winner_ultime_avatar_left,
	"S_WINNER_ULTIME_AVATAR_RIGHT" => $winner_ultime_avatar_right,
	"S_SCORE_LEFT" => $scorerow_left,
	"S_SCORE_RIGHT" => $scorerow_right,
	"S_MAXSIZE_AVATAR" => intval($new['maxsize_avatar']),
  "S_POSTS_NEEDED" => intval($new['posts_needed']),
  "S_DAYS_LIMIT" => intval($new['days_limit']),
	"S_LINKCATITTLE_ALIGN" => $s_linkcatittle_align,
	"S_LINKCAT_ALIGN" => $s_linkcat_align,
  "S_LIMIT_TYPE_POSTS" => $limit_type_posts,
  "S_LIMIT_TYPE_DATE" => $limit_type_date,
  "S_LIMIT_BY_POSTS_YES" => $limit_by_posts_yes,
  "S_LIMIT_BY_POSTS_NO" => $limit_by_posts_no,
	"S_USE_POINTS_MOD_YES" => $use_points_mod_yes,
	"S_USE_POINTS_MOD_NO" => $use_points_mod_no,
	"S_USE_POINTS_WIN_MOD_YES" => $use_points_win_mod_yes,
	"S_USE_POINTS_WIN_MOD_NO" => $use_points_win_mod_no,
	"S_USE_POINTS_PAY_MOD_YES" => $use_points_pay_mod_yes,
	"S_USE_POINTS_PAY_MOD_NO" => $use_points_pay_mod_no,
	"S_USE_POINTS_PAY_CHARGING_YES" => $use_points_pay_charging_yes,
	"S_USE_POINTS_PAY_CHARGING_NO" => $use_points_pay_charging_no,
	"S_USE_POINTS_PAY_SUBMIT_YES" => $use_points_pay_submit_yes,
	"S_USE_POINTS_PAY_SUBMIT_NO" => $use_points_pay_submit_no,
	"S_POINTS_WINNER" => $points_winner,
	"S_POINTS_PAY" => $points_pay,
	"S_RATING_MAX" => $arcade_vote_max,
	"S_USE_ARCADE_VOTE_YES" => $use_arcade_vote_yes,
	"S_USE_ARCADE_VOTE_NO" => $use_arcade_vote_no,
	"S_USE_FAV_CATEGORY_YES" => $use_fav_category_yes,
	"S_USE_FAV_CATEGORY_NO" => $use_fav_category_no,
	"S_NBR_GAMES_FAV" => intval($new['nbr_games_fav']),
	"S_USE_HIDE_FAV_YES" => $use_hide_fav_yes,
	"S_USE_HIDE_FAV_NO" => $use_hide_fav_no,
	"S_FAV_NBR_IN_PAGE" => intval($new['fav_nbr_in_page']),
	"S_PAY_ALL_GAMES_YES" => $pay_all_games_yes,
	"S_PAY_ALL_GAMES_NO" => $pay_all_games_no,
	"S_PRIZE_ALL_GAMES_YES" => $prize_all_games_yes,
	"S_PRIZE_ALL_GAMES_NO" => $prize_all_games_no,
	"S_PRIZE_ALL_GAMES_PGAMES" => $prize_all_games_pgames,
	"S_GAMES_TIME_TOLERANCE" => intval($new['games_time_tolerance']),
	"S_GAMES_CHEATER_SUBMIT_YES" => $games_cheater_submit_yes,
	"S_GAMES_CHEATER_SUBMIT_NO" => $games_cheater_submit_no,
	"S_NB_PARTIES" => $new['quota_games'],
	"S_AUTHS_VOTE_YES" => $auths_vote_yes,
	"S_AUTHS_VOTE_NO" => $auths_vote_no,
	"S_AUTHS_VOTE_HIDDEN_YES" => $auths_vote_hidden_yes,
	"S_AUTHS_VOTE_HIDDEN_NO" => $auths_vote_hidden_no,
	"S_AUTHS_PLAY_YES" => $auths_play_yes,
	"S_AUTHS_PLAY_NO" => $auths_play_no,
	"S_AUTHS_SCORE_YES" => $auths_score_yes,
	"S_AUTHS_SCORE_NO" => $auths_score_no,
	"S_CHAMPIONNAT_POINTS_ONE" => $championnat_points_one,
	"S_CHAMPIONNAT_POINTS_TWO" => $championnat_points_two,
	"S_CHAMPIONNAT_POINTS_THREE" => $championnat_points_three,
	"S_CHAMPIONNAT_POINTS_FOUR" => $championnat_points_four,
	"S_CHAMPIONNAT_POINTS_FIVE" => $championnat_points_five,
	"S_CHAMPIONNAT_POINTS_SIX" => $championnat_points_six,
	"S_CHAMPIONNAT_POINTS_SEVEN" => $championnat_points_seven,
	"S_CHAMPIONNAT_POINTS_EIGHT" => $championnat_points_eight,
	"S_CHAMPIONNAT_POINTS_NINE" => $championnat_points_nine,
	"S_CHAMPIONNAT_POINTS_TEN" => $championnat_points_ten,
	"S_CHAMPIONNAT_POINTS_ELEVEN" => $championnat_points_eleven,
	"S_CHAMPIONNAT_POINTS_TWELVE" => $championnat_points_twelve,
	"S_CHAMPIONNAT_POINTS_THIRTEEN" => $championnat_points_thirteen,
	"S_CHAMPIONNAT_POINTS_FOURTEEN" => $championnat_points_fourteen,
	"S_CHAMPIONNAT_POINTS_FIVETEEN" => $championnat_points_fiveteen,
	"S_CHAMPIONNAT_POINTS_SIXTEEN" => $championnat_points_sixteen,
	"S_CHAMPIONNAT_POINTS_SEVENTEEN" => $championnat_points_seventeen,
	"S_CHAMPIONNAT_POINTS_EIGHTEEN" => $championnat_points_eighteen,
	"S_CHAMPIONNAT_POINTS_NINETEEN" => $championnat_points_nineteen,
	"S_CHAMPIONNAT_POINTS_TWENTY" => $championnat_points_twenty,
	"S_USE_CAGNOTTE_MOD_YES" => $use_cagnotte_mod_yes,
	"S_USE_CAGNOTTE_MOD_NO" => $use_cagnotte_mod_no,
	"S_USE_AUTO_DISTRIB_YES" => $use_auto_distrib_yes,
	"S_USE_AUTO_DISTRIB_NO" => $use_auto_distrib_no,
	"S_CAT_USE_YES" => $cat_use_yes,
	"S_CAT_USE_NO" => $cat_use_no,
	"S_USE_POINTS_CAGNOTTE_YES" => $use_points_cagnotte_yes,
	"S_USE_POINTS_CAGNOTTE_NO" => $use_points_cagnotte_no,
	"S_CAGNOTTE" => $cagnotte,
	"S_CHAMPIONNAT_TAUX_UN" => $championnat_taux_un,
	"S_CHAMPIONNAT_TAUX_DEUX" => $championnat_taux_deux,
	"S_CHAMPIONNAT_TAUX_TROIS" => $championnat_taux_trois,
	"S_CHAMPIONNAT_TAUX_QUATRE" => $championnat_taux_quatre,
	"S_CHAMPIONNAT_TAUX_CINQ" => $championnat_taux_cinq,
	"S_CHAMPIONNAT_TAUX_SIX" => $championnat_taux_six,
	"S_CHAMPIONNAT_TAUX_SEPT" => $championnat_taux_sept,
	"S_CHAMPIONNAT_TAUX_HUIT" => $championnat_taux_huit,
	"S_CHAMPIONNAT_TAUX_NEUF" => $championnat_taux_neuf,
	"S_CHAMPIONNAT_TAUX_DIX" => $championnat_taux_dix,
	"S_DAY_DISTRIB" => $day_distrib,
	"S_PAGE_GUEST_LIMIT" => $page_guest_admin,
	"S_COLOR_USER" => $color_user,
	"S_COLOR_MOD" => $color_mod,
	"S_COLOR_ADMIN" => $color_admin,
	"S_COLOR_USE_YES" => $color_use_yes,
	"S_COLOR_USE_NO" => $color_use_no,

	"I_OPT_GUEST" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_invites'] . '" title="' . $lang['Options_invites'] . '" border=0> ' . $lang['Options_invites'] . '',
	"I_OPT_PRES" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_presentation'] . '" title="' . $lang['Options_presentation'] . '" border=0> ' . $lang['Options_presentation'] . '',
	"I_OPT_TABLES" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_tableaux'] . '" title="' . $lang['Options_tableaux'] . '" border=0> ' . $lang['Options_tableaux'] . '',
	"I_OPT_GEN" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_generales'] . '" title="' . $lang['Options_generales'] . '" border=0> ' . $lang['Options_generales'] . '',
	"I_OPT_CHAMP" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Championnat'] . '" title="' . $lang['Options_Championnat'] . '" border=0> ' . $lang['Options_Championnat'] . '',
	"I_OPT_CAG_CHAMP" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Cagnotte'] . '" title="' . $lang['Options_Cagnotte'] . '" border=0> ' . $lang['Options_Cagnotte'] . '',
	"I_OPT_TAU_CHAMP" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Taux'] . '" title="' . $lang['Options_Taux'] . '" border=0> ' . $lang['Options_Taux'] . '',
	"I_OPT_COMMENTS" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Commentaires'] . '" title="' . $lang['Options_Commentaires'] . '" border=0> ' . $lang['Options_Commentaires'] . '',
	"I_OPT_REST" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Restrictions'] . '" title="' . $lang['Options_Restrictions'] . '" border=0> ' . $lang['Options_Restrictions'] . '',
	"I_OPT_GAMES" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Games'] . '" title="' . $lang['Options_Games'] . '" border=0> ' . $lang['Options_Games'] . '',
	"I_OPT_FAV" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Favoris'] . '" title="' . $lang['Options_Favoris'] . '" border=0> ' . $lang['Options_Favoris'] . '',
	"I_OPT_VOTE" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Vote'] . '" title="' . $lang['Options_Vote'] . '" border=0> ' . $lang['Options_Vote'] . '',
	"I_OPT_STATS" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Statistiques'] . '" title="' . $lang['Options_Statistiques'] . '" border=0> ' . $lang['Options_Statistiques'] . '',
	"I_OPT_POINTS" => '<img src="' . append_sid("./../images/arcades/options_arcade.gif").'" alt="' . $lang['Options_Points'] . '" title="' . $lang['Options_Points'] . '" border=0> ' . $lang['Options_Points'] . '',

	"LAST_SEEN" => $new['last_seen'],
	"PRESENT_FID" => $new['present_fid'],
	"CHAMPIONNAT_CAT_SELECT" => $championnat_cat_select,
	"VERSION_ARCADE" => $version_arcade,

	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'])
  );

// Génération de la page
$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
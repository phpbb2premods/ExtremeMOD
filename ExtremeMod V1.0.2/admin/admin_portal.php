<?php
/***************************************************************************
 *                              admin_portal.php
 *                            -------------------
 *   begin                : Vendredi 01 Août 2003
 *   email                : giefca@hotmail.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_portal']['Config_portal'] = "$file?mode=config";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . PORTAL_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_portal", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$portal_name = $row['portal_name'];
		$portal_value = $row['portal_value'];
		$default_portal[$portal_name] = $portal_value;
		
		$new[$portal_name] = ( isset($HTTP_POST_VARS[$portal_name]) ) ? $HTTP_POST_VARS[$portal_name] : $default_portal[$portal_name];

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				portal_value = '" . str_replace("\'", "''", $new[$portal_name]) . "'
				WHERE portal_name = '$portal_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update portal configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Portal_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . append_sid("admin_portal.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

/*
 * Version information
 */
$file = @fopen('http://www.gf-phpbb.com/version/current_version.txt', 'r');
$current_version = @fread($file, 16);
@fclose ($file);
if ($new['gf_version'] == $current_version)
{
	$l_version_info = sprintf($lang['Gf_version_ok'], $current_version);
}
elseif ($new['gf_version'] < $current_version)
{
	$l_version_info = sprintf($lang['Gf_version_too_old'], $new['gf_version'], $current_version);
}
else
{
	$l_version_info = sprintf($lang['Gf_version_too_new'], $new['gf_version'], $current_version);
}

$col1_percent = ( $new['col1_unit'] == 'percent' ) ? "selected" : "";
$col1_pixel = ( $new['col1_unit'] == 'pixel' ) ? "selected" : "";
$col2_percent = ( $new['col2_unit'] == 'percent' ) ? "selected" : "";
$col2_pixel = ( $new['col2_unit'] == 'pixel' ) ? "selected" : "";
$col3_percent = ( $new['col3_unit'] == 'percent' ) ? "selected" : "";
$col3_pixel = ( $new['col3_unit'] == 'pixel' ) ? "selected" : "";

$header_forum_yes = ( $new['forum_header'] ) ? "checked=\"checked\"" : "";
$header_forum_no = ( !$new['forum_header'] ) ? "checked=\"checked\"" : "";

$bodyline_yes = ( $new['bodyline'] ) ? "checked=\"checked\"" : "";
$bodyline_no = ( !$new['bodyline'] ) ? "checked=\"checked\"" : "";

$head_out_bodyline_yes = ( $new['head_out_bodyline'] ) ? "checked=\"checked\"" : "";
$head_out_bodyline_no = ( !$new['head_out_bodyline'] ) ? "checked=\"checked\"" : "";
$foot_out_bodyline_yes = ( $new['foot_out_bodyline'] ) ? "checked=\"checked\"" : "";
$foot_out_bodyline_no = ( !$new['foot_out_bodyline'] ) ? "checked=\"checked\"" : "";

$guest_avatar_yes = ( $new['guest_avatar'] ) ? "checked=\"checked\"" : "";
$guest_avatar_no = ( !$new['guest_avatar'] ) ? "checked=\"checked\"" : "";


$template->set_filenames(array(
	"body" => "admin/portal_config_body.tpl")
);

//
// Escape any quotes in the site description for proper display in the text
// box on the admin page 
//
$new['site_desc'] = str_replace('"', '&quot;', $new['site_desc']);
$new['sitename'] = str_replace('"', '&quot;', strip_tags($new['sitename']));

$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_portal.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_CONFIGURATION_TITLE" => $lang['Portal_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Portal_config_explain'],
	"L_GENERAL_SETTINGS" => $lang['General_portal_settings'],
	"L_SPACE_ROW" => $lang['Space_row'],
	"L_SPACE_ROW_EXPLAIN" => $lang['Space_row_explain'], 
	"L_SPACE_COL" => $lang['Space_col'],
	"L_SPACE_COL_EXPLAIN" => $lang['Space_col_explain'],
	"L_WIDTH_COL1" => $lang['Width_col1'],
	"L_WIDTH_COL2" => $lang['Width_col2'],
	"L_WIDTH_COL3" => $lang['Width_col3'],
	"L_PERCENT" => $lang['unit_percent'],
	"L_PIXEL" => $lang['unit_pixel'],
	"L_HEADER_FORUM" => $lang['forum_header'],
	"L_PORTAL_BODYLINE" => $lang['portal_bodyline'],
	"L_USEFUL" => $lang['only_no_header'],
	"L_HEADER_OUTBODYLINE" => $lang['header_out_body'],
	"L_FOOTER_OUTBODYLINE" => $lang['footer_out_body'],
	"L_OUTBODYLINE_EXPLAIN" => $lang['out_body_explain'],	
	"L_GUEST_AVATAR" => $lang['guest_avatar'],
	"L_GUEST_AVATAR_EXPLAIN" => $lang['guest_avatar_explain'],

	"L_NUMBER_RECENT_TOPICS" => $lang['Number_Recent_Topics'],
	"L_LAST_SEEN" => $lang['Last_Seen'],

	'L_VERSION_INFO' => $l_version_info,

	"NUMBER_RECENT_TOPICS" => $new['number_recent_topics'],
	"LAST_SEEN" => $new['last_seen'],


	"COL1_PERCENT" => $col1_percent,
	"COL1_PIXEL" => $col1_pixel,
	"WIDTH_COL1" => $new['col1_size'],
	"COL2_PERCENT" => $col2_percent,
	"COL2_PIXEL" => $col2_pixel,
	"WIDTH_COL2" => $new['col2_size'],	
	"COL3_PERCENT" => $col3_percent,
	"COL3_PIXEL" => $col3_pixel,
	"WIDTH_COL3" => $new['col3_size'],
	"S_HEADER_FORUM_YES" => $header_forum_yes,	
	"S_HEADER_FORUM_NO" => $header_forum_no,	
	"S_BODYLINE_YES" => $bodyline_yes,	
	"S_BODYLINE_NO" => $bodyline_no,	
	"S_HEAD_OUTBODYLINE_YES" => $head_out_bodyline_yes,	
	"S_HEAD_OUTBODYLINE_NO" => $head_out_bodyline_no,	
	"S_FOOT_OUTBODYLINE_YES" => $foot_out_bodyline_yes,	
	"S_FOOT_OUTBODYLINE_NO" => $foot_out_bodyline_no,	

	"S_GUEST_AVATAR_YES" => $guest_avatar_yes,	
	"S_GUEST_AVATAR_NO" => $guest_avatar_no,	
	
	"SPACE_ROW" => $new['space_row'],
	"SPACE_COL" => $new['space_col'],

	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'])
);

//Configuration générale des modules
//==================================

// mod bienvenue
$simple_welcome_yes = ( $new['simple_welcome'] ) ? "checked=\"checked\"" : "";
$simple_welcome_no = ( !$new['simple_welcome'] ) ? "checked=\"checked\"" : "";

$template->assign_vars(array(
	"L_MODULE_BIENVENUE" => $lang['Options_module_bienvenue'],
	"L_WELCOME_TEXT" => $lang['Welcome_text'],
	"L_WELCOME_TEXT_EXPLAIN" => $lang['Welcome_text_explain'],
	"S_SIMPLE_WELCOME_YES" => $simple_welcome_yes,	
	"S_SIMPLE_WELCOME_NO" => $simple_welcome_no,	
	"L_USE_SIMPLE_TEXT" => $lang['Use_simple_welcome_text'],
	"L_USE_SIMPLE_EXPLAIN" => $lang['Use_simple_explain'],
	"WELCOME_TEXT" => $new['welcome_text'])
);


// mod news
$sql = "SELECT forum_name, forum_id FROM " . FORUMS_TABLE . " ORDER BY forum_name ASC " ;
if( ! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Failed to access forums table", "", __LINE__, __FILE__, $sql);
}

$liste_forums = "" ;
while ( $row = $db->sql_fetchrow( $result ) )
{
	$selected = ( $new['news_forum'] == $row['forum_id'] ) ? "selected" : "" ;	
	$libelle_forum = ( strlen($row['forum_name']) > 50 ) ? substr( $row['forum_name'], 0, 47 ) . '...' : $row['forum_name'] ;
	$liste_forums .= "<option value='" . $row['forum_id'] . "' $selected >" . $libelle_forum . "</option>" ;
}

$template->assign_vars(array(
	"L_NUMBER_OF_NEWS" => $lang['Number_of_News'],
	"L_NUMBER_OF_NEWS_EXPLAIN" => $lang['Number_of_News_Explain'],
	"L_NEWS_LENGTH" => $lang['News_length'],
	"L_NEWS_FORUM" => $lang['News_Forum'],
	"L_NEWS_FORUM_EXPLAIN" => $lang['News_Forum_Explain'],
	"L_MODULE_NEWS" => $lang['Options_module_news'],
	"NUMBER_OF_NEWS" => $new['number_of_news'],
	"NEWS_LENGTH" => $new['news_length'],
	"NEWS_FORUM" => $liste_forums )
);


// mod sondage
$sql = "SELECT t.*, vd.* FROM " . TOPICS_TABLE	 . " AS t, " . VOTE_DESC_TABLE  . " AS vd
			WHERE  t.topic_status <> 1 AND
			  t.topic_status <> 2 AND t.topic_vote = 1 AND t.topic_id = vd.topic_id
			   ORDER BY t.topic_time DESC " ;

if( ! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Failed to access topics/votes tables", "", __LINE__, __FILE__, $sql);
}

$liste_poll = "" ;
while ( $row = $db->sql_fetchrow( $result ) )
{
	$selected = ( $new['poll_id'] == $row['topic_id'] ) ? "selected" : "" ;	
	$libelle_sondage = ( strlen($row['vote_text']) > 50 ) ? substr( $row['vote_text'], 0, 47 ) . '...' : $row['vote_text'] ;
	$liste_poll .= "<option value='" . $row['topic_id'] . "' $selected >" . $libelle_sondage . "</option>" ;
}

$template->assign_vars(array(
	"L_MODULE_POLL" => $lang['Options_module_poll'],
	"L_POLL_FORUM" => $lang['Poll_Forum'],
	"L_POLL_FORUM_EXPLAIN" => $lang['Poll_Forum_Explain'],
	"POLL_ID" => $liste_poll )
);


// mod recent topics
$scroll_up = ( $new['scroll_up'] ) ? "checked=\"checked\"" : "";
$scroll_down = ( !$new['scroll_up'] ) ? "checked=\"checked\"" : "";
$scrolling_topics_yes = ( $new['scrolling_topics'] ) ? "checked=\"checked\"" : "";
$scrolling_topics_no = ( !$new['scrolling_topics'] ) ? "checked=\"checked\"" : "";

$template->assign_vars(array(
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_UP" => $lang['Up_way'],
	"L_DOWN" => $lang['Down_way'],
	"L_SCROLLING_ONLY" => $lang['Scrolling_only'],
	"L_MODULE_RECENT_TOPICS" => $lang['Options_module_recent_topics'],
	"L_NUMBER_TOPICS" => $lang['number_recent_topics'],
	"L_NUMBER_TOPICS_EXPLAIN" => $lang['number_recent_topics_explain'],	
	"S_NUMBER_TOPICS" => $new['number_recent_topics'],
	"L_SCROLLING" => $lang['Scrolling_topics'],
	"L_SCROLLING_EXPLAIN" => $lang['Scrolling_topics_explain'],
	"S_SCROLLING_TOPICS_YES" => $scrolling_topics_yes,
	"S_SCROLLING_TOPICS_NO" => $scrolling_topics_no,
	"L_SCROLLING_HEIGHT" => $lang['Scroll_height'],
	"L_SCROLLING_HEIGHT_EXPLAIN" => $lang['Scroll_height_explain'],
	"S_SCROLLING_HEIGHT" => $new['scroll_height'],
	"L_SCROLLING_DELAY" => $lang['Scroll_delay'],
	"L_SCROLLING_DELAY_EXPLAIN" => $lang['Scroll_delay_explain'],
	"S_SCROLLING_DELAY" => $new['scroll_delay'],
	"L_SCROLLING_STEP" => $lang['Scroll_step'],
	"L_SCROLLING_STEP_EXPLAIN" => $lang['Scroll_step_explain'],
	"S_SCROLLING_STEP" => $new['scroll_step'],
	"L_SCROLLING_WAY" => $lang['Scrolling_way'],
	"S_SCROLLING_UP" => $scroll_up,
	"S_SCROLLING_DOWN" => $scroll_down)
);


//Fin Configuration des modules
//==================================

// Génération de la page

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>

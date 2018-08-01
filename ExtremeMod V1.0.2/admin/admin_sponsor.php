<?php
/***************************************************************************
 *                              admin_sponsor.php
 *                            ------------------
 *   begin                : 15/04/2004
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Sponsor_settings'] = "$filename";
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");

$template->set_filenames(array(
	"body" => "admin/config_sponsor_body.tpl")
);

$template->assign_vars(array(
	'GAIN_FIRST' => $board_config['sponsor_gain_first'],
	'GAIN_SECOND' => $board_config['sponsor_gain_second'],
	'GAIN_POINTS' => $board_config['sponsor_points_gain'],
	'BASE_CHECKED' => ( $board_config['sponsor_enabled'] ? 'CHECKED' :'' ),
	'NO_BASE_CHECKED' => ( !$board_config['sponsor_enabled'] ? 'CHECKED' :'' ),
	'POINTS_CHECKED' => ( $board_config['sponsor_points_enabled'] ? 'CHECKED' :'' ),
	'NO_POINTS_CHECKED' => ( !$board_config['sponsor_points_enabled'] ? 'CHECKED' :'' ),
));

$submit = isset($HTTP_POST_VARS['submit']); 

if ( $submit )
{
	$enable = intval($HTTP_POST_VARS['sponsor_enabled']);
	$points_enable = intval($HTTP_POST_VARS['sponsor_points_enabled']);
	$gain_first = intval($HTTP_POST_VARS['sponsor_gain_first']);
	$gain_second = intval($HTTP_POST_VARS['sponsor_gain_second']);
	$gain_points = intval($HTTP_POST_VARS['sponsor_points_gain']);

	$sql = "UPDATE " . CONFIG_TABLE . " 
		SET	config_value = $enable
		WHERE config_name = 'sponsor_enabled'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
	}
		
	$sql = "UPDATE " . CONFIG_TABLE . " 
		SET	config_value = $points_enable
		WHERE config_name = 'sponsor_points_enabled'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . CONFIG_TABLE . " 
		SET	config_value = $gain_first
		WHERE config_name = 'sponsor_gain_first'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . CONFIG_TABLE . " 
		SET	config_value = $gain_second
		WHERE config_name = 'sponsor_gain_second'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . CONFIG_TABLE . " 
		SET	config_value = $gain_points
		WHERE config_name = 'sponsor_points_gain'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
	}

	$message = $lang['Sponsor_updated'] . "<br /><br />" . sprintf($lang['Sponsor_settings_return'], "<a href=\"" . append_sid("admin_sponsor.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);

}

$template->assign_vars(array(
	'L_NO' => $lang['No'],
	'L_YES' => $lang['Yes'],
	'L_SUBMIT' => $lang['Submit'],
	'L_POINTS' => $board_config['points_name'],
	'L_GAIN_REGISTER' => $lang['Sponsor_gain_register'],
	'L_SPONSOR_TITLE' => $lang['Sponsor_title'],
	'L_SPONSOR_EXPLAIN' => $lang['Sponsor_title_explain'],
	'L_GAIN_FIRST' => $lang['Sponsor_gain_first'],
	'L_GAIN_SECOND' => $lang['Sponsor_gain_second'],
	'L_GAIN_POINTS' => $lang['Sponsor_gain_points'],
	'L_GAIN_POINTS_EXPLAIN' => $lang['Sponsor_gain_points_explain'],
	'L_BASE_CHECKED' => $lang['Sponsor_base'],
	'L_POINTS_CHECKED' => $lang['Sponsor_points'],
	'L_POINTS_CHECKED_EXPLAIN' => $lang['Sponsor_points_explain'],
	'S_SPONSOR_ACTION' => append_sid("admin_sponsor.$phpEx")
	)
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
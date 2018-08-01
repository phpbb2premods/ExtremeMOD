<?php
/**
*
* @version $Id: admin_minichat.php,v 1.0.0 2007/03/25 22:04:45 ABDev Exp $
* @copyright (c) 2007 ABDev, EzCom
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Shoutbox'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

//
// Pull all config data
//
$sql = 'SELECT * FROM ' . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Could not query config information in admin_minichat', '', __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_value = \'' . str_replace("\'", "''", $new[$config_name]) . '\'
				WHERE config_name = \'' . $config_name . '\'';
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to update general configuration for '.$config_name, '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_minichat_config'], '<a href="' . append_sid('admin_minichat.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
}

$shoutbox_on_yes = ( $new['shoutbox_on'] ) ? 'checked="checked"' : '';
$shoutbox_on_no = ( !$new['shoutbox_on'] ) ? 'checked="checked"' : '';

$date_on_yes = ( $new['shoutbox_date_on'] ) ? 'checked="checked"' : '';
$date_on_no = ( !$new['shoutbox_date_on'] ) ? 'checked="checked"' : '';

$make_links_yes = ( $new['shoutbox_make_links'] ) ? 'checked="checked"' : '';
$make_links_no = ( !$new['shoutbox_make_links'] ) ? 'checked="checked"' : '';

$links_names_yes = ( $new['shoutbox_links_names'] ) ? 'checked="checked"' : '';
$links_names_no = ( !$new['shoutbox_links_names'] ) ? 'checked="checked"' : '';

$allow_smilies_yes = ( $new['shoutbox_allow_smilies'] ) ? 'checked="checked"' : '';
$allow_smilies_no = ( !$new['shoutbox_allow_smilies'] ) ? 'checked="checked"' : '';

$allow_bbcode_yes = ( $new['shoutbox_allow_bbcode'] ) ? 'checked="checked"' : '';
$allow_bbcode_no = ( !$new['shoutbox_allow_bbcode'] ) ? 'checked="checked"' : '';

$allow_edit_yes = ( $new['shoutbox_allow_edit'] ) ? 'checked="checked"' : '';
$allow_edit_no = ( !$new['shoutbox_allow_edit'] ) ? 'checked="checked"' : '';

$allow_edit_all_yes = ( $new['shoutbox_allow_edit_all'] ) ? 'checked="checked"' : '';
$allow_edit_all_no = ( !$new['shoutbox_allow_edit_all'] ) ? 'checked="checked"' : '';

$allow_delete_yes = ( $new['shoutbox_allow_delete'] ) ? 'checked="checked"' : '';
$allow_delete_no = ( !$new['shoutbox_allow_delete'] ) ? 'checked="checked"' : '';

$allow_delete_all_yes = ( $new['shoutbox_allow_delete_all'] ) ? 'checked="checked"' : '';
$allow_delete_all_no = ( !$new['shoutbox_allow_delete_all'] ) ? 'checked="checked"' : '';

$allow_guest_yes = ( $new['shoutbox_allow_guest'] ) ? 'checked="checked"' : '';
$allow_guest_no = ( !$new['shoutbox_allow_guest'] ) ? 'checked="checked"' : '';

$allow_guest_view_yes = ( $new['shoutbox_allow_guest_view'] ) ? 'checked="checked"' : '';
$allow_guest_view_no = ( !$new['shoutbox_allow_guest_view'] ) ? 'checked="checked"' : '';

$template->set_filenames(array('body' => 'admin/minichat_config_body.tpl'));

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid('admin_minichat.' . $phpEx),

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],
	'L_MINICHAT_TITLE' => $lang['MiniChat_Config'],
	'L_MINICHAT_EXPLAIN' => $lang['MiniChat_explain'],

	'SHOUTBOX_ON_YES' => $shoutbox_on_yes,
	'SHOUTBOX_ON_NO' => $shoutbox_on_no,
	'DATE_ON_YES' => $date_on_yes,
	'DATE_ON_NO' => $date_on_no,
	'MAKE_LINKS_YES' => $make_links_yes,
	'MAKE_LINKS_NO' => $make_links_no,
	'LINKS_NAMES_YES' => $links_names_yes,
	'LINKS_NAMES_NO' => $links_names_no,
	'ALLOW_SMILIES_YES' => $allow_smilies_yes,
	'ALLOW_SMILIES_NO' => $allow_smilies_no,
	'ALLOW_BBCODE_YES' => $allow_bbcode_yes,
	'ALLOW_BBCODE_NO' => $allow_bbcode_no,
	'ALLOW_EDIT_YES' => $allow_edit_yes,
	'ALLOW_EDIT_NO' => $allow_edit_no,
	'ALLOW_EDIT_ALL_YES' => $allow_edit_all_yes,
	'ALLOW_EDIT_ALL_NO' => $allow_edit_all_no,
	'ALLOW_DELETE_YES' => $allow_delete_yes,
	'ALLOW_DELETE_NO' => $allow_delete_no,
	'ALLOW_DELETE_ALL_YES' => $allow_delete_all_yes,
	'ALLOW_DELETE_ALL_NO' => $allow_delete_all_no,
	'ALLOW_GUEST_YES' => $allow_guest_yes,
	'ALLOW_GUEST_NO' => $allow_guest_no,
	'ALLOW_GUEST_VIEW_YES' => $allow_guest_view_yes,
	'ALLOW_GUEST_VIEW_NO' => $allow_guest_view_no,

	'COUNT_MSG' => $new['shoutbox_count_msg'],
	'TEXT_LENGHT' => $new['shoutbox_text_lenght'],
	'WORD_LENGHT' => $new['shoutbox_word_lenght'],
	'DATE_FORMAT' => $new['shoutbox_date_format'],
	'SHOUT_WIDTH' => $new['shoutbox_width'],
	'SHOUT_HEIGHT' => $new['shoutbox_height'],
	'BANNED_USER_ID' => $new['shoutbox_banned_user_id'],
	'BANNED_USER_ID_VIEW' => $new['shoutbox_banned_user_id_view'],
	'DELETE_DAYS' => $new['shoutbox_delete_days'],
	'SHOUT_REFRESH_TIME' => $new['shoutbox_refresh_time'],
	'SHOUT_MESSAGES_ON_INDEX' => $new ['shoutbox_messages_number_on_index'],

	'L_SHOUT_MESSAGES_ON_INDEX' => $lang['sb_messages_number_on_index'],
	'L_SHOUT_REFRESH_TIME' => $lang['sb_refresh_time'],
	'L_DELETE_DAYS' => $lang['delete_days'],
	'L_SHOUTBOX_ON' => $lang['shoutbox_on'],
	'L_DATE_ON' => $lang['date_on'],
	'L_ALLOW_SMILIES' => $lang['Allow_smilies'],
	'L_ALLOW_BBCODE' => $lang['Allow_BBCode'],
	'L_DATE_FORMAT' => $lang['Date_format'],
	'L_SHOUT_SIZE' => $lang['shout_size'],
	'L_MAKE_LINKS' => $lang['sb_make_links'],
	'L_LINKS_NAMES' => $lang['sb_links_names'],
	'L_ALLOW_EDIT' => $lang['sb_allow_edit'],
	'L_ALLOW_EDIT_ALL' => $lang['sb_allow_edit_all'],
	'L_ALLOW_DELETE' => $lang['sb_allow_delete'],
	'L_ALLOW_DELETE_ALL' => $lang['sb_allow_delete_all'],
	'L_ALLOW_GUEST' => $lang['sb_allow_guest'],
	'L_ALLOW_GUEST_VIEW' => $lang['sb_allow_guest_view'],
	'L_COUNT_MSG' => $lang['sb_count_msg'],
	'L_TEXT_LENGHT' => $lang['sb_text_lenght'],
	'L_WORD_LENGHT' => $lang['sb_word_lenght'],
	'L_BANNED_USER_ID' => $lang['sb_banned_user_send'],
	'L_BANNED_USER_ID_E' => $lang['sb_banned_user_send_e'],
	'L_BANNED_USER_ID_VIEW' => $lang['sb_banned_user_view'],
	'L_BANNED_USER_ID_VIEW_E' => $lang['sb_banned_user_view_e'],
));

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>

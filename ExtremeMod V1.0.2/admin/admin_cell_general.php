<?php
/***************************************************************************
 *                              admin_cell_general.php
 *                            ------------------
 *   begin                : 23/01/2004
 *
 *
 ***************************************************************************/

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Jail']['Jail_settings'] = $file;
	return;
}

define('IN_PHPBB', true);

$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_jail.'.$phpEx);

$template->set_filenames(array(
	'body' => 'admin/config_cell_general_body.tpl')
);

$submit = isset($HTTP_POST_VARS['submit']); 

$template->assign_vars(array(
	'CELL_BARS_CHECKED' => ( $board_config['cell_allow_display_bars'] ? 'CHECKED' :'' ),
	'CELL_CELLEDS_CHECKED' => ( $board_config['cell_allow_display_celleds'] ? 'CHECKED' :'' ),
	'CELL_CAUTION_CHECKED' => ( $board_config['cell_allow_user_caution'] ? 'CHECKED' :'' ),
	'CELL_JUDGE_CHECKED' => ( $board_config['cell_allow_user_judge'] ? 'CHECKED' :'' ),
	'CELL_BLANK_CHECKED' => ( $board_config['cell_allow_user_blank'] ? 'CHECKED' :'' ),
	'CELL_BLANK' => $board_config['cell_amount_user_blank'],
	'CELL_VOTERS' => $board_config['cell_user_judge_voters'],
	'CELL_POSTS' => $board_config['cell_user_judge_posts'],
));

if ( $submit )
{
	$allow_display_bars = intval ( $HTTP_POST_VARS['allow_display_bars']);
	$allow_display_celleds = intval ( $HTTP_POST_VARS['allow_display_celleds']);
	$allow_user_caution = intval ( $HTTP_POST_VARS['allow_user_caution']);
	$allow_user_judge = intval ( $HTTP_POST_VARS['allow_user_judge']);
	$allow_user_blank = intval ( $HTTP_POST_VARS['allow_user_blank']);
	$amount_user_blank = intval ( $HTTP_POST_VARS['amount_user_blank']);
	$voters = intval ( $HTTP_POST_VARS['voters']);
	$posts = intval ( $HTTP_POST_VARS['posts']);

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$allow_display_bars' WHERE config_name = 'cell_allow_display_bars' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$allow_display_celleds' WHERE config_name = 'cell_allow_display_celleds' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 	
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$allow_user_caution' WHERE config_name = 'cell_allow_user_caution' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$allow_user_judge' WHERE config_name = 'cell_allow_user_judge' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$allow_user_blank' WHERE config_name = 'cell_allow_user_blank' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$amount_user_blank' WHERE config_name = 'cell_amount_user_blank' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$voters' WHERE config_name = 'cell_user_judge_voters' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$posts' WHERE config_name = 'cell_user_judge_posts' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Cell_admin_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 



	message_die(GENERAL_MESSAGE, sprintf($lang['Cell_updated_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Vault_settings']);
}

$template->assign_vars(array(
	'L_CELL_SETTINGS' => $lang['Jail_settings'],
	'L_CELL_SETTINGS_EXPLAIN' => $lang['Cell_settings_explain'],
	'L_CELL_BARS' => $lang['Cell_settings_bars'],
	'L_CELL_CELLEDS' => $lang['Cell_settings_celleds'],
	'L_CELL_CAUTION' => $lang['Cell_settings_caution'],
	'L_CELL_JUDGE' => $lang['Cell_settings_judge'],
	'L_CELL_BLANK' => $lang['Cell_settings_blank'],
	'L_CELL_BLANK_SUM' => $lang['Cell_settings_blank_sum'],
	'L_CELL_VOTERS' => $lang['Cell_settings_voters'],
	'L_CELL_POSTS' => $lang['Cell_settings_posts'],
	'L_SUBMIT' => $lang['Submit'],
	'S_CELL_ACTION' => append_sid(basename(__FILE__)))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
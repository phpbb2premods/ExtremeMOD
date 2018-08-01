<?php
/***************************************************************************
 *                             admin_groups_salary.php
 *                            -------------------
 *   Version                       : 1.0.0
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if(!empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Groups']['Group_salary'] = $file;
	return;
}

$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$template->set_filenames(array(
'body' => 'admin/config_groups_salary_body.tpl')
);	

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Group_salary_points'];

$update = isset($HTTP_POST_VARS['update']);
$manual_update = isset($HTTP_POST_VARS['manual_update']);
$cron_enable = intval($HTTP_POST_VARS['cron_enable']);
$cron_time = ( intval($HTTP_POST_VARS['cron_time']) * 86400 );

if ( $manual_update )
{
	$sql = "SELECT * FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . TRUE . "";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Group_salary_update_error'] , "", __LINE__, __FILE__, $sql); 
	} 
	$groups = $db->sql_fetchrowset($result);
	for( $i = 0; $i < count($groups); $i++ )
	{
		$salary = $groups[$i]['group_salary'];
		$group_id = $groups[$i]['group_id'];
		$usql = "SELECT user_id FROM " . USER_GROUP_TABLE . "
			WHERE user_pending = 0  
			AND group_id = ".$group_id;
		if ( !($uresult = $db->sql_query($usql)) ) 
		{ 
			message_die(GENERAL_ERROR, $lang['Group_salary_update_error'] , "", __LINE__, __FILE__, $usql); 
		} 
		$usergroups = $db->sql_fetchrowset($uresult);
		for( $k = 0; $k < count($usergroups); $k++ )
		{
			$csql = "UPDATE " . USERS_TABLE . "
				SET user_points = user_points + $salary
				WHERE user_id = ".$usergroups[$k]['user_id']; 
			if ( !($cresult = $db->sql_query($csql)) ) 
			{ 
				message_die(GENERAL_ERROR, $lang['Group_salary_update_error'] , "", __LINE__, __FILE__, $csql); 
			} 
		}
	}

	$message = $lang['Group_salary_manual_updated'].'<br /><br />'.sprintf($lang['Group_salary_return'],"<a href=\"" . append_sid("admin_groups_salary.$phpEx") . "\">", "</a>") ;
	message_die(GENERAL_MESSAGE, $message);
}

if ( $update )
{
	$sql = "SELECT * FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . TRUE . "";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Group_salary_update_error'] , "", __LINE__, __FILE__, $sql); 
	} 
	$groups = $db->sql_fetchrowset($result);

	$sql = array();
	while( list(,$group) = @each($groups) )
	{
		$salary = intval($HTTP_POST_VARS[$group['group_id']]);
		$sql[] = "UPDATE " . GROUPS_TABLE . " 
			SET group_salary = $salary
		WHERE group_id = '" . $group['group_id'] . "'";
	}

	for( $i = 0; $i < count($sql); $i++ )
	{
		if ( !($result = $db->sql_query($sql[$i])) )
		{
			message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql[$i]);
		}
	}

	$sql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$cron_enable' WHERE config_name = 'groups_salary_cron_enable' ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Group_salary_update_error']  , "", __LINE__, __FILE__, $sql); 
	} 

	$sql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$cron_time' WHERE config_name = 'groups_salary_cron_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Group_salary_update_error']  , "", __LINE__, __FILE__, $sql); 
	} 

	$message = $lang['Group_salary_updated'].'<br /><br />'.sprintf($lang['Group_salary_return'],"<a href=\"" . append_sid("admin_groups_salary.$phpEx") . "\">", "</a>") ;
	message_die(GENERAL_MESSAGE, $message);
}

$sql = "SELECT * FROM " . GROUPS_TABLE . "
	WHERE group_single_user <> " . TRUE . "";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(GENERAL_ERROR, $lang['Group_salary_update_error'] , "", __LINE__, __FILE__, $sql); 
} 
$group = $db->sql_fetchrowset($result);

for( $i = 0; $i < count($group); $i++ )
{
	$template->assign_block_vars('row',	array(
      	 'GROUP_ID' => $group[$i]['group_id'],
      	 'GROUP_SALARY' => $group[$i]['group_salary'],
	       'GROUP_DESCRIPTION' => $group[$i]['group_description'],
	   	 'GROUP_NAME'=> $group[$i]['group_name'])
	);
}

$template->assign_vars(array(
	'CRON_SALARY_CHECKED' => ($board_config['groups_salary_cron_enable'] ? 'CHECKED' : '') ,
	'CRON_SALARY_TIME' => floor($board_config['groups_salary_cron_time'] / 86400),
	'L_MANUAL_UPDATE' => $lang['Group_salary_manual_update'], 
	'L_GENERAL' => $lang['Group_salary_settings'], 
	'L_CRON_SALARY' => $lang['Group_salary_cron'], 
	'L_CRON_SALARY_TIME' => $lang['Group_salary_time'], 
	'L_DAYS' => $lang['Days'],
	'L_GROUP_SALARY_TITLE' => $lang['Group_salary'],
	'L_GROUP_SALARY_EXPLAIN' => $lang['Group_salary_title_explain'],
	'L_GROUP' => $lang['Group_salary_group'],
	'L_SALARY' => $lang['Group_salary_salary'],
	'L_GROUP_NAME' => $lang['Group_salary_group_name'],
	'L_GROUP_DESC' => $lang['Group_salary_group_desc'],
	'L_POINTS' => $board_config['points_name'],
	'L_SUBMIT' => $lang['Submit'],
	'S_GROUP_SALARY_ACTION' => append_sid("admin_groups_salary.$phpEx"),
));

$template->pparse('body');

include('page_footer_admin.' . $phpEx);

?>

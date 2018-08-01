<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if ( !$board_config['groups_salary_cron_last_time'] )
{
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = ".time()." WHERE config_name = 'groups_salary_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
	$board_config['groups_salary_cron_last_time']  = time();
}

if ( ( time() - $board_config['groups_salary_cron_last_time'] ) > $board_config['groups_salary_cron_time'])
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

	$new_time = $board_config['groups_salary_cron_last_time'] +  $board_config['groups_salary_cron_time'];

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = $new_time WHERE config_name = 'groups_salary_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
}

?>
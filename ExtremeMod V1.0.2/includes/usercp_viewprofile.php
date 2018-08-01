<?php
/***************************************************************************
 *                           usercp_viewprofile.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: usercp_viewprofile.php,v 1.5.2.6 2005/09/14 18:14:30 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}
$profiledata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]);

// Medal MOD

//
// Category
//

$sql = "SELECT cat_id, cat_title
	FROM " . MEDAL_CAT_TABLE . "
	ORDER BY cat_order";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query medal categories list', '', __LINE__, __FILE__, $sql);
}

$category_rows = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$category_rows[] = $row;
}
$db->sql_freeresult($result);

$sql = "SELECT m.medal_id, mu.user_id
	FROM " . MEDAL_TABLE . " m, " . MEDAL_USER_TABLE . " mu
	WHERE mu.user_id = '" . $profiledata['user_id'] . "'
	AND m.medal_id = mu.medal_id
	ORDER BY m.medal_name";
	
if($result = $db->sql_query($sql))
{
	$medal_list = $db->sql_fetchrowset($result);
	$medal_count = count($medal_list);

	if ( $medal_count )
	{
		$medal_count = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $profiledata['user_id'] . "#medal") . '" class="genmed">' . $medal_count . '</a>';

		$template->assign_block_vars('switch_display_medal', array());

		$template->assign_block_vars('switch_display_medal.medal', array(
			'MEDAL_BUTTON' => '<button onclick="ToggleBox(\'toggle_medal\')">'.$lang['Medal_details'].'</button>')
		);
	}
}

for ($i = 0; $i < count($category_rows); $i++)
{
	$cat_id = $category_rows[$i]['cat_id'];

	$sql = "SELECT m.medal_id, m.medal_name,m.medal_description, m.medal_image, m.cat_id, mu.issue_reason, mu.issue_time, c.cat_id, c.cat_title
		FROM " . MEDAL_TABLE . " m, " . MEDAL_USER_TABLE . " mu, " . MEDAL_CAT_TABLE . " c
		WHERE mu.user_id = '" . $profiledata['user_id'] . "'
		AND m.cat_id = c.cat_id
		AND m.medal_id = mu.medal_id
		ORDER BY c.cat_order, m.medal_name, mu.issue_time";

	if ($result = $db->sql_query($sql))
	{
		$row = array();
		$rowset = array();
		$medal_time = $lang['Medal_time'] . ':&nbsp;';
		$medal_reason = $lang['Medal_reason'] . ':&nbsp;';
		while ($row = $db->sql_fetchrow($result))
		{
			if (empty($rowset[$row['medal_name']]))
			{
				$rowset[$row['medal_name']]['cat_id'] = $row['cat_id'];
				$rowset[$row['medal_name']]['cat_title'] = $row['cat_title'];
				$rowset[$row['medal_name']]['medal_description'] .= $row['medal_description'];
				$rowset[$row['medal_name']]['medal_image'] = $row['medal_image'];
				$row['issue_reason'] = ( $row['issue_reason'] ) ? $row['issue_reason'] : $lang['Medal_no_reason'];
				$rowset[$row['medal_name']]['medal_issue'] = '<tr><td><span class="genmed">' . $medal_time . create_date($board_config['default_dateformat'], $row['issue_time'], $board_config['board_timezone']) . '</span></td></tr><tr><td><span class="genmed">' . $medal_reason . $row['issue_reason']  . '</span><hr></td></tr>';
				$rowset[$row['medal_name']]['medal_count'] = '1';
			}
			else
			{
				$row['issue_reason'] = ( $row['issue_reason'] ) ? $row['issue_reason'] : $lang['Medal_no_reason'];
				$rowset[$row['medal_name']]['medal_issue'] .= '<tr><td><span class="genmed">' . $medal_time . create_date($board_config['default_dateformat'], $row['issue_time'], $board_config['board_timezone']) . '</span></td></tr><tr><td><span class="genmed">' . $medal_reason . $row['issue_reason'] . '</span><hr /></td></tr>';
				$rowset[$row['medal_name']]['medal_count'] += '1';
			}
		}

		$medal_width = ( $board_config['medal_display_width'] ) ? 'width="'.$board_config['medal_display_width'].'"' : '';
		$medal_height = ( $board_config['medal_display_height'] ) ? 'height="'.$board_config['medal_display_height'].'"' : '';

		$medal_name = array();
		$data = array();

		//
		// Should we display this category/medal set?
		//
		$display_medal = 0;

		while (list($medal_name, $data) = @each($rowset))
		{
			if ( $cat_id == $data['cat_id'] ) { $display_medal = 1; }

			if ( !empty($display_medal) )
			{
				$template->assign_block_vars('switch_display_medal.details', array(
					'MEDAL_CAT' => $data['cat_title'],
					'MEDAL_NAME' => $medal_name,
					'MEDAL_DESCRIPTION' => $data['medal_description'],
					'MEDAL_IMAGE' => '<img src="'. $phpbb_root_path . $data['medal_image'] . '" border="0" alt="' . $medal_name . '" title="' . $medal_name . '" />',
					'MEDAL_IMAGE_SMALL' => '<img src="'. $phpbb_root_path . $data['medal_image'] . '" border="0" alt="' . $medal_name . '" title="' . $medal_name . '"' . $medal_width . $medal_height . ' />',
					'MEDAL_ISSUE' => $data['medal_issue'],
					'MEDAL_COUNT' => $lang['Medal_amount'] . $data['medal_count'],
				
					'L_MEDAL_DESCRIPTION' => $lang['Medal_description'])
				);
				$display_medal = 0;
			}
		}
	}
}

if (!$profiledata)
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

//
// Output page header and profile_view template
//
$template->set_filenames(array(
	'body' => 'profile_view_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

//
// Calculate the number of days this user has been a member ($memberdays)
// Then calculate their posts per day
//
$regdate = $profiledata['user_regdate'];
$memberdays = max(1, round( ( time() - $regdate ) / 86400 ));
$posts_per_day = $profiledata['user_posts'] / $memberdays;

// Get the users percentage of total posts
if ( $profiledata['user_posts'] != 0  )
{
	$total_posts = get_db_stat('postcount');
	$percentage = ( $total_posts ) ? min(100, ($profiledata['user_posts'] / $total_posts) * 100) : 0;
}
else
{
	$percentage = 0;
}

if ( $board_config['cell_allow_display_celleds'] && $profiledata['user_cell_celleds'] ) 
{
	$template->assign_block_vars('celleds', array());
}

$avatar_img = '';
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
{
	switch( $profiledata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			$avatar_img = ( ($profiledata['user_cell_time'] > 0) && $board_config['cell_allow_display_bars']) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $avatar_img ;
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			$avatar_img = ( ($profiledata['user_cell_time'] > 0) && $board_config['cell_allow_display_bars'] ) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $profiledata['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $avatar_img ;
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			$avatar_img = ( ($profiledata['user_cell_time'] > 0) && $board_config['cell_allow_display_bars'] ) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $board_config['avatar_gallery_path'] . '/' . $profiledata['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $avatar_img ;
			break;
	}
}

// Default avatar MOD, By Manipe (Begin)
if ((!$avatar_img) && (($board_config['default_avatar_set'] == 1) || ($board_config['default_avatar_set'] == 2)) && ($board_config['default_avatar_users_url'])){
	$avatar_img = '<img src="' . $board_config['default_avatar_users_url'] . '" alt="" border="0" />';
}
// Default avatar MOD, By Manipe (End)

$poster_rank = '';
$rank_image = '';
if ( $profiledata['user_rank'] )
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_rank'] == $ranksrow[$i]['rank_id'] && $ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}
else
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_posts'] >= $ranksrow[$i]['rank_min'] && !$ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}

$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )
{
	$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $profiledata['user_id']) : 'mailto:' . $profiledata['user_email'];

	$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
	$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
}
else
{
	$email_img = '&nbsp;';
	$email = '&nbsp;';
}

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '&nbsp;';
$www = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww">' . $profiledata['user_website'] . '</a>' : '&nbsp;';

if ( !empty($profiledata['user_icq']) )
{
	$icq_status_img = '<a href="http://wwp.icq.com/' . $profiledata['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $profiledata['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
	$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
	$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '">' . $lang['ICQ'] . '</a>';
}
else
{
	$icq_status_img = '&nbsp;';
	$icq_img = '&nbsp;';
	$icq = '&nbsp;';
}

$aim_img = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '&nbsp;';
$aim = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '&nbsp;';

$msn_img = ( $profiledata['user_msnm'] ) ? $profiledata['user_msnm'] : '&nbsp;';
$msn = $msn_img;

$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($profiledata['username']) . "&amp;showresults=posts");
$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" title="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" border="0" /></a>';
$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '</a>';
if ( $board_config['vault_display_profile'] )
{
	$template->assign_block_vars('display_shares',array());

	$sql = " SELECT e.* , eu .* FROM " . VAULT_EXCHANGE_TABLE . " e 
		LEFT JOIN " . VAULT_EXCHANGE_USERS_TABLE . " eu ON ( eu.user_id =  " . $profiledata['user_id'] . " AND e.stock_id = eu.stock_id ) "; 
	if( !($result = $db->sql_query($sql))) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql); 
	} 
	$shares = $db->sql_fetchrowset($result); 

	for ( $i = 0 ; $i < count($shares) ; $i ++ ) 
	{ 
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2']; 

		$template->assign_block_vars('display_shares.shares' , array( 
			'SHARE_ROW' => $row_class,
			'SHARE_NAME' => vault_get_lang($shares[$i]['stock_name']),  
			'SHARE_SUM' => intval($shares[$i]['stock_amount']), 
		)); 
	} 

	$sql = " SELECT * FROM " . VAULT_USERS_TABLE . " 
		WHERE owner_id = " . $profiledata['user_id']; 
	if( !($result = $db->sql_query($sql))) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql); 
	} 
	$accounts = $db->sql_fetchrow($result); 

	$on_account = ( $accounts['account_protect'] && $userdata['user_level'] != ADMIN && $accounts['owner_id'] != $userdata['user_id'] ) ? $lang['Vault_confidential'] : intval($accounts['account_sum']).'&nbsp;'.$board_config['points_name'];
	$loan = ( $accounts['loan_protect'] && $userdata['user_level'] != ADMIN && $accounts['owner_id'] != $userdata['user_id'] ) ? $lang['Vault_confidential'] : intval($accounts['loan_sum']).'&nbsp;'.$board_config['points_name'];
}
$user_points = ($userdata['user_level'] == ADMIN || user_is_authed($userdata['user_id'])) ? '<a href="' . append_sid("pointscp.$phpEx?" . POST_USERS_URL . "=" . $profiledata['user_id']) . '" class="gen" title="' . sprintf($lang['Points_link_title'], $board_config['points_name']) . '">' . $profiledata['user_points'] . '</a>' : $profiledata['user_points'];

if ($board_config['points_donate'] && $userdata['user_id'] != ANONYMOUS && $userdata['user_id'] != $profiledata['user_id'])
{
	$donate_points = '<br />' . sprintf($lang['Points_donate'], '<a href="' . append_sid("pointscp.$phpEx?mode=donate&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']) . '" class="genmed" title="' . sprintf($lang['Points_link_title_2'], $board_config['points_name']) . '">', '</a>');
}
else
{
	$donate_points = '';
}

//-- mod : rank color system ---------------------------------------------------
//-- add
$username_color = $rcs->get_colors($profiledata, $profiledata['username']);
//-- fin mod : rank color system -----------------------------------------------

//-- mod : gender --------------------------------------------------------------
//-- add
if ( !empty($profiledata['user_gender']) )
{
	switch ($profiledata['user_gender'])
	{
		case 1:
			$gender = $lang['Male'];
			break;
		case 2:
			$gender = $lang['Female'];
			break;
		default:
			$gender = $lang['No_gender_specify'];
	}
}
else
{
	$gender = $lang['No_gender_specify'];
}
//-- fin mod : gender ----------------------------------------------------------

//-- mod : flags ---------------------------------------------------------------
//-- add
display_flag($profiledata['user_flag']);
//-- fin mod : flags -----------------------------------------------------------

// Start add - Birthday MOD
if ($profiledata['user_birthday']!=999999)
{
	$user_birthday = realdate($lang['DATE_FORMAT'], $profiledata['user_birthday']);
} else
{
	$user_birthday = $lang['No_birthday_specify'];
}
// End add - Birthday MOD

//
// Generate page
//
$page_title = $lang['Viewing_profile'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if( $userdata['user_level'] == ADMIN ) 
{
	if ( $userdata['session_admin'] )
	{
		$temp_url = ($phpbb_root_path . "admin/admin_users.$phpEx?mode=edit&admin=1&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']."&sid=".$userdata['session_id']);
		$useradmin_img = '<a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)"><img src="' . $images['icon_mangmt'] . '" alt="' . sprintf($lang['User_admin_for'], $profiledata['username']) . '" title="' . sprintf($lang['User_admin_for'], $profiledata['username']) . '" border="0" /></a>'; 
		$useradmin = '<a href="' . $temp_url . '">' . sprintf($lang['User_admin_for'], $profiledata['username']) . '</a>'; 

		$temp_url = ($phpbb_root_path . "admin/admin_ug_auth.$phpEx?mode=user&admin=1&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']."&sid=".$userdata['session_id']);
		$permcontrol_img = '<a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)"><img src="' . $images['icon_perm'] . '" alt="' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '" title="' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '" border="0" /></a>';
		$permcontrol = '<a href="' . $temp_url . '">' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '</a>';
	}
	else
	{
		$temp_url = ($phpbb_root_path . "login.$phpEx?redirect=admin/admin_users.$phpEx&amp;" . POST_USERS_URL . '=' . $profiledata['user_id'] . '&amp;mode=edit&amp;admin=1');
		$useradmin_img = '<a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)"><img src="' . $images['icon_mangmt'] . '" alt="' . sprintf($lang['User_admin_for'], $profiledata['username']) . '" title="' . sprintf($lang['User_admin_for'], $profiledata['username']) . '" border="0" /></a>'; 
		$useradmin = '<a href="' . $temp_url . '">' . sprintf($lang['User_admin_for'], $profiledata['username']) . '</a>'; 

		$temp_url = ($phpbb_root_path . "login.$phpEx?redirect=admin/admin_ug_auth.$phpEx&amp;" . POST_USERS_URL . '=' . $profiledata['user_id'] . '&amp;mode=user&amp;admin=1');
		$permcontrol_img = '<a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)"><img src="' . $images['icon_perm'] . '" alt="' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '" title="' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '" border="0" /></a>';
		$permcontrol = '<a href="' . $temp_url . '">' . sprintf($lang['Permissions_control_for'], $profiledata['username']) . '</a>';
	}

	$template->assign_vars(array( 
		'L_USER_ADMIN' => sprintf($lang['User_admin_for'], $profiledata['username']), 
		'USERADMIN_IMG' => $useradmin_img, 
		'USERADMIN' => $useradmin, 
		'L_USER_PERMISSIONS' => sprintf($lang['Permissions_control_for'], $profiledata['username']), 
		'PERMCONTROL_IMG' => $permcontrol_img, 
		'PERMCONTROL' => $permcontrol) 
	); 
	$template->assign_block_vars("switch_user_admin", array()); 
}


display_upload_attach_box_limits($profiledata['user_id']);

// Start add - Online/Offline/Hidden Mod
if ($profiledata['user_session_time'] >= (time()-$board_config['online_time']))
{
	if ($profiledata['user_allow_viewonline'])
	{
		$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_online'] . '" alt="' . sprintf($lang['is_online'], $profiledata['username']) . '" title="' . sprintf($lang['is_online'], $profiledata['username']) . '" /></a>';
		$online_status = '<strong><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_online'], $profiledata['username']) . '"' . $online_color . '>' . $lang['Online'] . '</a></strong>';
	}
	else if ($userdata['user_level'] == ADMIN || $userdata['user_id'] == $profiledata['user_id'])
	{
		$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_hidden'] . '" alt="' . sprintf($lang['is_hidden'], $profiledata['username']) . '" title="' . sprintf($lang['is_hidden'], $profiledata['username']) . '" /></a>';
		$online_status = '<strong><em><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_hidden'], $profiledata['username']) . '"' . $hidden_color . '>' . $lang['Hidden'] . '</a></em></strong>';
	}
	else
	{
		$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $profiledata['username']) . '" title="' . sprintf($lang['is_offline'], $profiledata['username']) . '" />';
		$online_status = '<span title="' . sprintf($lang['is_offline'], $profiledata['username']) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
	}
}
else
{
	$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $profiledata['username']) . '" title="' . sprintf($lang['is_offline'], $profiledata['username']) . '" />';
	$online_status = '<span title="' . sprintf($lang['is_offline'], $profiledata['username']) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
}
// End add - Online/Offline/Hidden Mod


if (function_exists('get_html_translation_table'))
{
	$u_search_author = urlencode(strtr($profiledata['username'], array_flip(get_html_translation_table(HTML_ENTITIES))));
}
else
{
	$u_search_author = urlencode(str_replace(array('&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array('&', "'", '"', '<', '>'), $profiledata['username']));
}

	include_once($phpbb_root_path .'language/lang_'. $board_config['default_lang'] .'/lang_mood_mod.'. $phpEx);
	$user_mood_1 	= explode('.', $profiledata['user_mood_mod']);
	$user_mood_2 	= explode('/', $user_mood_1[1]);
	$mood_count		= count($user_mood_2);
	$user_mood 		= str_replace('_', ' ', $user_mood_2[($mood_count - 1)]);
	$user_mood 		= ucwords(strtolower($user_mood));
	
	$poster_rank	.= ($profiledata['user_mood_mod']) ? '<br><br>'. $lang['MM_profile'] .'&nbsp;&nbsp;<img src="'. $profiledata['user_mood_mod'] .'" border="0" alt="'. $user_mood .'" title="'. $user_mood .'">' : '';


$template->assign_vars(array(
	//-- mod : rank color system ---------------------------------------------------
	//-- delete
	/*-MOD
	'USERNAME' => $profiledata['username'],
	MOD-*/
	//-- add
	'USERNAME' => $username_color,
	'L_USER_MEDAL' =>$lang['Medals'],	// Medal MOD
	'USER_MEDAL_COUNT' => $medal_count,	// Medal MOD
	'L_MEDAL_INFORMATION' => $lang['Medal_Information'], // Medal MOD
	'L_MEDAL_NAME' => $lang['Medal_name'],		// Medal MOD
	'L_MEDAL_DETAIL' => $lang['Medal_details'],	// Medal MOD
	//-- fin mod : rank color system -----------------------------------------------
	'JOINED' => create_date($lang['DATE_FORMAT'], $profiledata['user_regdate'], $board_config['board_timezone']),
	//-- mod : mini last visit -----------------------------------------------------
	//-- add
	'L_VISITED' => $lang['Visited'],
	'VISITED' => display_last_visit($profiledata['user_id'], $profiledata['user_lastlogin'], $profiledata['user_allow_viewonline']),
	//-- fin mod : mini last visit -------------------------------------------------
	'POSTER_RANK' => $poster_rank,
	'RANK_IMAGE' => $rank_image,
	'POSTS_PER_DAY' => $posts_per_day,
	'POSTS' => $profiledata['user_posts'],
	'PERCENTAGE' => $percentage . '%', 
	'POST_DAY_STATS' => sprintf($lang['User_post_day_stats'], $posts_per_day), 
	'POST_PERCENT_STATS' => sprintf($lang['User_post_pct_stats'], $percentage), 

	'SEARCH_IMG' => $search_img,
	'SEARCH' => $search,
	'L_ON_ACCOUNT' => $lang['Vault_on_account'], 
	'L_LOAN' => $lang['Vault_loan_account'],
	'ON_ACCOUNT' => $on_account,
	'LOAN' => $loan,
	'PM_IMG' => $pm_img,
	'PM' => $pm,
	'EMAIL_IMG' => $email_img,
	'EMAIL' => $email,
	'WWW_IMG' => $www_img,
	'WWW' => $www,
	'ICQ_STATUS_IMG' => $icq_status_img,
	'ICQ_IMG' => $icq_img, 
	'ICQ' => $icq, 
	'AIM_IMG' => $aim_img,
	'AIM' => $aim,
	'MSN_IMG' => $msn_img,
	'MSN' => $msn,
	'YIM_IMG' => $yim_img,
	'YIM' => $yim,
	'CELLEDS' => $profiledata['user_cell_celleds'],
	'L_CELLEDS' => $lang['Celleds_time'],
	'U_CELLEDS' => append_sid("courthouse.$phpEx?from=celleds_list"),
	'POINTS' => $user_points,
	'DONATE_POINTS' => $donate_points,

	'LOCATION' => ( $profiledata['user_from'] ) ? $profiledata['user_from'] : '&nbsp;',
	'OCCUPATION' => ( $profiledata['user_occ'] ) ? $profiledata['user_occ'] : '&nbsp;',
	'INTERESTS' => ( $profiledata['user_interests'] ) ? $profiledata['user_interests'] : '&nbsp;',
	// Start add - Birthday MOD
	'BIRTHDAY' => $user_birthday,
	// End add - Birthday MOD
	//-- mod : gender --------------------------------------------------------------
	//-- add
	'GENDER' => $gender,
	'L_GENDER' => $lang['Gender'],
	//-- fin mod : gender ----------------------------------------------------------
	'AVATAR_IMG' => $avatar_img,

	//-- mod : rank color system ---------------------------------------------------
	//-- delete
	/*-MOD
	'L_VIEWING_PROFILE' => sprintf($lang['Viewing_user_profile'], $profiledata['username']),
	'L_ABOUT_USER' => sprintf($lang['About_user'], $profiledata['username']),
	MOD-*/
	//-- add
	'L_VIEWING_PROFILE' => sprintf($lang['Viewing_user_profile'], $username_color),
	'L_ABOUT_USER' => sprintf($lang['About_user'], $username_color),
	//-- fin mod : rank color system -----------------------------------------------
	'L_AVATAR' => $lang['Avatar'], 
	'L_POSTER_RANK' => $lang['Poster_rank'], 
	'L_JOINED' => $lang['Joined'], 
	'L_TOTAL_POSTS' => $lang['Total_posts'], 
	//-- mod : rank color system ---------------------------------------------------
	//-- delete
	/*-MOD
	'L_SEARCH_USER_POSTS' => sprintf($lang['Search_user_posts'], $profiledata['username']),
	MOD-*/
	//-- add
	'L_SEARCH_USER_POSTS' => sprintf($lang['Search_user_posts'], $username_color),
	//-- fin mod : rank color system -----------------------------------------------
	'L_CONTACT' => $lang['Contact'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	'L_EMAIL' => $lang['Email'],
	'L_PM' => $lang['Private_Message'],
	'L_ICQ_NUMBER' => $lang['ICQ'],
	'L_YAHOO' => $lang['YIM'],
	'L_AIM' => $lang['AIM'],
	'L_MESSENGER' => $lang['MSNM'],
	'L_WEBSITE' => $lang['Website'],
	'L_LOCATION' => $lang['Location'],
	'L_OCCUPATION' => $lang['Occupation'],
	'L_INTERESTS' => $lang['Interests'],
	 'L_ARCADE' => $lang['lib_arcade'],
  	'URL_STATS' => '<a class="genmed" href="' . append_sid("statarcade.$phpEx?uid=" . $profiledata['user_id'] ) . '">' . $lang['statuser'] . '</a> ',
	// Start add - Birthday MOD
	'L_BIRTHDAY' => $lang['Birthday'],
	// End add - Birthday MOD
	// Start add - Online/Offline/Hidden Mod
	'ONLINE_STATUS_IMG' => $online_status_img,
	'ONLINE_STATUS' => $online_status,
	'L_ONLINE_STATUS' => $lang['Online_status'],
	// End add - Online/Offline/Hidden Mod
	'L_POINTS' => $board_config['points_name'],

	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author),

	'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
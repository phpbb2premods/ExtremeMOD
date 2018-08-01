<?php
/***************************************************************************
 *                              sponsor.php
 *                            -------------------
 *   begin                : 15/04/04
 *   copyright            : Dr DLP
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
//
// End session management
//

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
	$mode = 'joined';
}

if(isset($HTTP_POST_VARS['order']))
{
	$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else if(isset($HTTP_GET_VARS['order']))
{
	$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else
{
	$sort_order = 'ASC';
}

$mode_types_text = array($lang['Username'],$lang['Sponsor_gained'],$board_config['points_name']);
$mode_types = array( 'username' , 'sponsor_gain', 'points');

$select_sort_mode = '<select name="mode">';
for($i =  0; $i < count($mode_types_text); $i++)
{
	$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
	$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';
if($sort_order == 'ASC')
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';

$page_title = $lang['Sponsor_overall'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'sponsor_body.tpl')
);

$template->assign_vars(array(
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],
	'L_POINTS' => $board_config['points_name'],
	'L_GAIN' => $lang['Sponsor_gained'], 
	'L_SPONSOR_FIRST' => $lang['Sponsor_first'], 
	'L_SPONSOR_SECOND' => $lang['Sponsor_second'], 
	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_MODE_ACTION' => append_sid("sponsor.$phpEx"))
);

switch( $mode )
{
	case 'username':
		$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'sponsor_gain':
		$order_by = "user_sponsor_gain $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'points':
		$order_by = "user_points $sort_order LIMIT $start," . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "user_sponsor_gain $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT username, user_id, user_points , user_sponsor_gain 
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . "
	AND user_sponsor_gain > 0
	ORDER BY $order_by";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$username = $row['username'];
		$user_id = $row['user_id'];
		$user_points = $row['user_points'];
		$gain = $row['user_sponsor_gain'];

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('sponsorrow', array(
			'ROW_NUMBER' => $i + ( $HTTP_GET_VARS['start'] + 1 ),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'USERNAME' => $username,
			'GAIN' => $gain,
			'POINTS' => $user_points,
			'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
		);

		$ssql = " SELECT user_id , username FROM " . USERS_TABLE . " 
			WHERE user_sponsor_id = $user_id ";
		if( !($sresult = $db->sql_query($ssql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $ssql);
		}
		$first_sponsors = $db->sql_fetchrowset($sresult);

		if ( $db->sql_numrows($sresult) )
		{
			for ( $s = 0 ; $s < count($first_sponsors) ; $s ++ )
			{
				$first_id = intval($first_sponsors[$s]['user_id']);

				$template->assign_block_vars('sponsorrow.first', array(
					'ROW_CLASS2' => $row_class,
					'USERNAME2' => $first_sponsors[$s]['username'],
					'POINTS2' => $first_sponsors[$s]['user_points'],
					'U_VIEWPROFILE2' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$first_id")
				));

				$sssql = " SELECT user_id , username FROM " . USERS_TABLE . " 
					WHERE user_sponsor_id = $first_id ";
				if( !($ssresult = $db->sql_query($sssql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sssql);
				}
				$second_sponsors = $db->sql_fetchrowset($ssresult);

				if ( $db->sql_numrows($ssresult) )
				{
					for ( $j = 0 ; $j < count($second_sponsors) ; $j ++ )
					{
						$second_id = intval($second_sponsors[$j]['user_id']);

						$template->assign_block_vars('sponsorrow.first.second', array(
							'ROW_CLASS3' => $row_class,
							'USERNAME3' => $second_sponsors[$j]['username'],
							'U_VIEWPROFILE3' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$second_id")
						));
					}
				}
			}	
		}

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
}

if ( $board_config['topics_per_page'] < 10 )
{
	$sql = "SELECT count(*) AS total
		FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS . "
		AND user_sponsor_gain > 0 ";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];

		$pagination = generate_pagination("sponsor.$phpEx?mode=$mode&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start). '&nbsp;';
	}
}
else
{
	$pagination = '&nbsp;';
	$total_members = 10;
}

// Create the link to the register page
$link = 'http://'.$board_config['server_name'].$board_config['script_path'].'profile.'.$phpEx.'?mode=register&sponsor='.$userdata['user_id'];

$template->assign_vars(array(
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members / $board_config['topics_per_page'] )), 
	'L_LINK' => $lang['Sponsor_link'],
	'L_GOTO_PAGE' => $lang['Goto_page'],
	'U_LINK' => append_sid("$link"))
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
<?php
//-- mod: sf
/***************************************************************************
 *                                index.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: index.php,v 1.99.2.7 2006/01/28 11:13:39 acydburn Exp $
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
 ***************************************************************************/

//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
//-- mod: sf - end
$time_end = time();
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

// Arcade type 4
if( isset($HTTP_GET_VARS['act']) || isset($HTTP_POST_VARS['act']) )
{ 
   $arcade = ( isset($HTTP_POST_VARS['act']) ) ? $HTTP_POST_VARS['act'] : $HTTP_GET_VARS['act']; 
} 
else 
{ 
   $arcade = '';
}

if( isset($HTTP_GET_VARS['do']) || isset($HTTP_POST_VARS['do']) ) 
{ 
   $newscore = ( isset($HTTP_POST_VARS['do']) ) ? $HTTP_POST_VARS['do'] : $HTTP_GET_VARS['do']; 
} 
else 
{ 
   $newscore = '';
} 

if( ($arcade == 'Arcade') && ($newscore == 'newscore') )
{ 
if (isset($HTTP_POST_VARS['gamesessid']) )
 {
  $gamesessid = $HTTP_POST_VARS['gamesessid'];
if (!preg_match('/^[A-Za-z0-9]*$/', $gamesessid))
 {
  $gamesessid = '';
 }
  else
 {
  $clause_sql = " AND game_sessid = " . "'$gamesessid'";
 }
}

   $gamename = str_replace("\'","''",$HTTP_POST_VARS['gname']); 
   $gamename = preg_replace(array('#&(?!(\#[0-9]+;))#', '#<#', '#>#'), array('&amp;', '&lt;', '&gt;'),$gamename); 
   $gamescore = intval($HTTP_POST_VARS['gscore']); 
   $gameflashtime = intval($HTTP_POST_VARS['flashgametime']);
   $gamecheattype = (isset($HTTP_POST_VARS['gcheatlm'])) ? intval($HTTP_POST_VARS['gcheatlm']) : 0;

   //Get Game ID 
if (isset($HTTP_POST_VARS['gameid']))
 {
  $gid = intval($HTTP_POST_VARS['gameid']);
  $sql = "SELECT game_id, game_cheat_control from " . GAMES_TABLE . "
  WHERE game_id = $gid AND game_scorevar='$gamename'";
if( !($result = $db->sql_query($sql)) )
 {
  message_die(GENERAL_ERROR, "Impossible de trouver le jeu !", '', __LINE__, __FILE__, $sql);
 }
  $row = $db->sql_fetchrow($result);
}
 else
{
  $row = $db->sql_fetchrow($db->sql_query("SELECT game_id, game_cheat_control from " . GAMES_TABLE . " WHERE game_scorevar='$gamename'"));
} 
   $gid = intval($row['game_id']); 
   if ($row['game_cheat_control'])
   {
      //Calcul du temps de jeu
      $sql = "SELECT date_enreg from " . ARCADE_TIME_TEMP . " WHERE user_id = " . $userdata['user_id'] . "
                                                               AND game_id = " . $gid . $clause_sql . "
                                                               ORDER BY date_enreg DESC";
      if( !($result = $db->sql_query($sql)) )
      {
      	message_die(GENERAL_ERROR, "Impossible d'identifier votre session de jeu", '', __LINE__, __FILE__, $sql);
      }
      $row = $db->sql_fetchrow($result);

      if ( !(is_null($row['date_enreg'])) )
      {
         $time_begin = $row['date_enreg'];
         $gamerealtime = $time_end - $time_begin;
      }
      else
      {
         //Erreur lors de la sélection des valeurs du jeu !
         $message = 'Erreur lors de la sélection des valeurs de votre session de jeu' . '<br /><br />' . sprintf($lang['Click_return_index ' . $gamesessid], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');
         message_die(GENERAL_MESSAGE, $message);
      }
   }
   if (@phpversion() >= '4.0.0')
   {
      session_save_path($phpbb_root_path . './sess_arcade');
      session_name('gf_arcade');
      session_start();
      $gf_sess = session_id();
   }

   if (!empty($gf_sess))
   {
      //Passage des valeurs du jeu par une session php
      $_SESSION['gamescore'] = intval($HTTP_POST_VARS['gscore']);
      $_SESSION['gameflashtime'] = intval($HTTP_POST_VARS['flashgametime']);
      $_SESSION['gamerealtime'] = intval($gamerealtime);
      $_SESSION['gamecheattype'] = $gamecheattype;
      $_SESSION['gamesessid'] = $gamesessid;
      $header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
      header($header_location . append_sid("proarcade.$phpEx?valid=X&gpaver=GFARV2&gid=$gid", true));
      exit;
   }
   else
   {
      //Passage des valeurs par un form HTML (méthode POST)
      echo "<form method='post' name='ibpro_score' action='proarcade.php?valid=X&gpaver=GFARV2'>";
      echo "<input type=hidden name='vscore' value='$gamescore'>";
      echo "<input type=hidden name='gameflashtime' value='$gameflashtime'>";
      echo "<input type=hidden name='gamerealtime' value='$gamerealtime'>";
      echo "<input type=hidden name='gamecheattype' value='$gamecheattype'>";
      echo "<input type=hidden name='gamesessid' value='$gamesseid'>";
      echo "<input type=hidden name='gid' value='$gid'>";
      echo "</form>";

      echo "<script type=\"text/javascript\">";
      echo "window.onload = function(){document.forms[\"ibpro_score\"].submit()}";
      echo "</script>";
      exit;
   }
} 
// Arcade type 4


//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_lang($lang);
//-- mod: sf - end

$viewcat = ( !empty($HTTP_GET_VARS[POST_CAT_URL]) ) ? $HTTP_GET_VARS[POST_CAT_URL] : -1;

if( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = ( isset($HTTP_POST_VARS['mark']) ) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}

//
// Handle marking posts
//
if( $mark_read == 'forums' )
{
	if( $userdata['session_logged_in'] )
	{
		setcookie($board_config['cookie_name'] . '_f_all', time(), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}

	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="3;url='  .append_sid("index.$phpEx") . '">')
	);

	$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');

	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

//-- mod: sf
	$_sf_root_forum_id = 0;
}
else
{
	// we are in viewforum
	if ( !defined('IN_PHPBB') )
	{
		die('Hack attempt!');
	}
	$viewcat = -1;
	$_sf_root_forum_id = $forum_row['forum_id'];
	$_sf_sav_forum_id = $forum_id;

	// mark subforums read
	if ( _sf_mark_subs_read($_sf_root_forum_id, 'mark', 'forums') )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $_sf_root_forum_id) . '">',
		));
		$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $_sf_root_forum_id) . '">', '</a> ');
		message_die(GENERAL_MESSAGE, $message);
	}

	// fill the categories_row array and initiate the retained forums for forum_data array() fill
	$category_rows = array(0 => array('cat_id' => $forum_row['cat_id']));
	$forum_data = array();

	$_sf_retained_forums = array();
}
//-- mod: sf - end

$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_t"]) : array();
$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_f"]) : array();

//
// If you don't use these stats on your index you may want to consider
// removing them
//

//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
//-- mod: sf - end

$total_posts = get_db_stat('postcount');
$total_users = get_db_stat('usercount');
$newest_userdata = get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}


//-- mod : minichat ------------------------------------------------------------
//-- add
$board_config['shoutbox_banned_user_id_view'] = $GLOBALS['board_config']['shoutbox_banned_user_id_view'];
if( strstr($board_config['shoutbox_banned_user_id_view'], ',') )
{
	$fids = explode(',', $board_config['shoutbox_banned_user_id_view']);
	while( list($foo, $id) = each($fids) )
	{
		$fid[] = intval( trim($id) );
	}
}
else
{
	$fid[] = intval( trim($board_config['shoutbox_banned_user_id_view']) );
}

reset($fid);

if ( $board_config['shoutbox_on'] && in_array($userdata['user_id'], $fid) == false )
{
	include($phpbb_root_path . 'shoutbox_body.'.$phpEx);
}
//-- fin mod : minichat --------------------------------------------------------

//
// Is there any global announcement ?
//
if ( $board_config['annonce_globale_index'] )
{
	//-- mod : quick title edition ------------------------------------------------- 
	//-- add 
	include($get->url('includes/class_attributes')); 
	//-- fin mod : quick title edition ---------------------------------------------
	get_annonce_list();
}

//
// Start page proper
//
$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
	FROM " . CATEGORIES_TABLE . " c 
	ORDER BY c.cat_order";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
}

$category_rows = array();
while ($row = $db->sql_fetchrow($result))
{
	$category_rows[] = $row;
}
$db->sql_freeresult($result);

//-- mod: sf
}
//-- mod: sf - end

if( ( $total_categories = count($category_rows) ) )
{
	//
	// Define appropriate SQL
	//
	switch(SQL_LAYER)
	{
		case 'postgresql':
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id 
				FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
				WHERE p.post_id = f.forum_last_post_id 
					AND u.user_id = p.poster_id  
					UNION (
						SELECT f.*, NULL, NULL, NULL, NULL
						FROM " . FORUMS_TABLE . " f
						WHERE NOT EXISTS (
							SELECT p.post_time
							FROM " . POSTS_TABLE . " p
							WHERE p.post_id = f.forum_last_post_id  
						)
					)
					ORDER BY cat_id, forum_order";
			break;

		case 'oracle':
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id 
				FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
				WHERE p.post_id = f.forum_last_post_id(+)
					AND u.user_id = p.poster_id(+)
				ORDER BY f.cat_id, f.forum_order";
			break;
		//-- mod : last active topic on index ------------------------------------------
		//-- delete
		/*-MOD
		default:
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id
				FROM (( " . FORUMS_TABLE . " f
				LEFT JOIN " . POSTS_TABLE . " p ON p.post_id = f.forum_last_post_id )
				
				LEFT JOIN " . USERS_TABLE . " u ON u.user_id = p.poster_id )
				ORDER BY f.cat_id, f.forum_order";
			break;
		MOD-*/
		//-- add
		default:
			$sql = 'SELECT f.*, p.post_time, p.post_username, u.username, u.user_id, t.topic_title, t.topic_id
				FROM ((( ' . FORUMS_TABLE . ' f
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = f.forum_last_post_id )
				LEFT JOIN ' . TOPICS_TABLE . ' t ON t.topic_id = p.topic_id )
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = p.poster_id )
				ORDER BY f.cat_id, f.forum_order';
			break;
		//-- fin mod : last active topic on index --------------------------------------

	}
	
	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace(', u.user_id', ', u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
	//-- fin mod : rank color system -----------------------------------------------
	
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$forum_data = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		//-- mod: sf
		if ( !defined('IN_VIEWFORUM') )
		{
		//-- mod: sf - end
		
		$forum_data[] = $row;
		
		//-- mod: sf
		}
		else
		{
			if ( (intval($row['forum_id']) == $_sf_root_forum_id) || isset($_sf_retained_forums[ intval($row['forum_parent']) ]) )
			{
				$forum_data[] = $row;
				$_sf_retained_forums[ intval($row['forum_id']) ] = true;
			}
		}
//-- mod: sf - end
		
		
		
	}
	$db->sql_freeresult($result);

	//-- mod: sf
	if ( !defined('IN_VIEWFORUM') )
	{
	//-- mod: sf - end


	if ( !($total_forums = count($forum_data)) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}
	
	
	//-- mod: sf
	}
	else
	{
		if ( !($total_forums = count($forum_data)) || ($total_forums <= 1) )
		{
			return;
		}
		unset($_sf_retained_forums);
	}
	//-- mod: sf - end
	



	//
	// Obtain a list of topic ids which contain
	// posts made since user last visited
	//
	if ($userdata['session_logged_in'])
	{
		// 60 days limit
		if ($userdata['user_lastvisit'] < (time() - 5184000))
		{
			$userdata['user_lastvisit'] = time() - 5184000;
		}

		$sql = "SELECT t.forum_id, t.topic_id, p.post_time 
			FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p 
			WHERE p.post_id = t.topic_last_post_id 
				AND p.post_time > " . $userdata['user_lastvisit'] . " 
				AND t.topic_moved_id = 0"; 
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
		}

		$new_topic_data = array();
		while( $topic_data = $db->sql_fetchrow($result) )
		{
			$new_topic_data[$topic_data['forum_id']][$topic_data['topic_id']] = $topic_data['post_time'];
		}
		$db->sql_freeresult($result);
	}

	//
	// Obtain list of moderators of each forum
	// First users, then groups ... broken into two queries
	//
	$sql = "SELECT aa.forum_id, u.user_id, u.username 
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 1 
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
			AND u.user_id = ug.user_id 
		GROUP BY u.user_id, u.username, aa.forum_id 
		ORDER BY aa.forum_id, u.user_id";
		
	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace(', u.user_id', ', u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
	//-- fin mod : rank color system -----------------------------------------------	
		
	
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	$forum_moderators = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		//-- mod : rank color system ---------------------------------------------------
		//-- delete
		/*-MOD
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
		MOD-*/
		//-- add
		$style_color = $rcs->get_colors($row);
		$forum_moderators[$row['forum_id']][] = '<a href="' . $get->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $style_color . '>' . $row['username'] . '</a>';
		//-- fin mod : rank color system -----------------------------------------------
	}
	$db->sql_freeresult($result);

	$sql = "SELECT aa.forum_id, g.group_id, g.group_name 
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 0 
			AND g.group_type <> " . GROUP_HIDDEN . "
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
		GROUP BY g.group_id, g.group_name, aa.forum_id 
		ORDER BY aa.forum_id, g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		//-- mod : rank color system ---------------------------------------------------
		//-- delete
		/*-MOD
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
		MOD-*/
		//-- add
		$style_color = $rcs->get_group_class($row['group_id']);
		$forum_moderators[$row['forum_id']][] = '<a href="' . $get->url('groupcp', array(POST_GROUPS_URL => $row['group_id']), true) . '"' . $style_color . '>' . $row['group_name'] . '</a>';
		//-- fin mod : rank color system -----------------------------------------------
	}
	$db->sql_freeresult($result);

	//
	// Find which forums are visible for this user
	//
	$is_auth_ary = array();
	$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data);
	



// Birthday Mod, Show users with birthday 
$sql = ($board_config['birthday_check_day']) ? "SELECT user_flag,user_id, username, user_birthday,user_level FROM " . USERS_TABLE. " WHERE user_birthday!=999999 ORDER BY username" :"";

//-- mod : rank color system ---------------------------------------------------
//-- add
  $sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------

if($result = $db->sql_query($sql)) 
{ 
	if (!empty($result)) 
	{ 
		$time_now = time();
		$this_year = create_date('Y', $time_now, $board_config['board_timezone']);
		$date_today = create_date('Ymd', $time_now, $board_config['board_timezone']);
		$date_forward = create_date('Ymd', $time_now+($board_config['birthday_check_day']*86400), $board_config['board_timezone']);
	      while ($birthdayrow = $db->sql_fetchrow($result))
		{ 
		      $user_birthday2 = $this_year.($user_birthday = realdate("md",$birthdayrow['user_birthday'] )); 
      		if ( $user_birthday2 < $date_today ) $user_birthday2 += 10000;
      		
      			
      			if ( $dta_flag = display_flag($birthdayrow['user_flag'], true) )
			{
			$user_flag = '&nbsp;<img class="gensmall" src="' . $dta_flag['img'] . '" alt="' . $dta_flag['name'] . '" title="' . $dta_flag['name'] . '" style="vertical-align:text-bottom; border:0;" />';
			}
			
      		
      		
			if ( $user_birthday2 > $date_today  && $user_birthday2 <= $date_forward ) 
			{ 
				// user are having birthday within the next days
				$user_age = ( $this_year.$user_birthday < $date_today ) ? $this_year - realdate ('Y',$birthdayrow['user_birthday'])+1 : $this_year- realdate ('Y',$birthdayrow['user_birthday']); 
				
				//-- mod : rank color system ---------------------------------------------------
				//-- delete
				/*-MOD
				switch ($birthdayrow['user_level'])
				{
					case ADMIN :
		      			$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
      					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
						break;
					case MOD :
		      			$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
      					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
						break;
					default: $style_color = '';
				}
				$birthday_week_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>,'; 
			
				MOD-*/
				//-- add
				  $style_color = $rcs->get_colors($birthdayrow);
				  $birthday_week_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>'. $user_flag .','; 
				//-- fin mod : rank color system -----------------------------------------------
				
				
				
			} else if ( $user_birthday2 == $date_today ) 
      		{ 
				//user have birthday today 
				$user_age = $this_year - realdate ( 'Y',$birthdayrow['user_birthday'] ); 
				
				//-- mod : rank color system ---------------------------------------------------
				//-- delete
				/*-MOD
				
				switch ($birthdayrow['user_level'])
				{
					case ADMIN :
		      			$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
      					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
						break;
					case MOD :
			      		$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
      					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
						break;
					default: $style_color = '';
				}

				$birthday_today_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>,'; 
				
					MOD-*/
					//-- add
				  $style_color = $rcs->get_colors($birthdayrow);
				  $birthday_today_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>'. $user_flag .','; 
					//-- fin mod : rank color system -----------------------------------------------
				
		      }
			 
		}
		if ($birthday_today_list) $birthday_today_list[ strlen( $birthday_today_list)-1] = ' ';
		if ($birthday_week_list) $birthday_week_list[ strlen( $birthday_week_list)-1] = ' ';
	} 
	$db->sql_freeresult($result);
}

	//
	// Start output of page
	//
	
	//-- mod: sf
	// send constants
	$template->assign_vars(array(
		'L_SUBFORUMS' => $lang['sf_Subforums'],
		'L_FORUM' => $lang['Forum'],
		// Start add - Birthday MOD
		'L_WHOSBIRTHDAY_WEEK' => ($board_config['birthday_check_day'] > 1) ? sprintf( (($birthday_week_list) ? $lang['Birthday_week'] : $lang['Nobirthday_week']), $board_config['birthday_check_day']).$birthday_week_list : '',
		'L_WHOSBIRTHDAY_TODAY' => ($board_config['birthday_check_day']) ? ($birthday_today_list) ? $lang['Birthday_today'].$birthday_today_list : $lang['Nobirthday_today'] : '',
		// End add - Birthday MOD
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'],
		'L_MODERATOR'=> $lang['Moderators'],
	));

	if ( !defined('IN_VIEWFORUM') )
	{
	//-- mod: sf - end
	
	
	define('SHOW_ONLINE', true);
	$page_title = $lang['Index'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
	
	//-- mod : toolbar -------------------------------------------------------------
	//-- add
	build_toolbar('index', $l_privmsgs_text, $s_privmsg_new);
	//-- fin mod : toolbar ---------------------------------------------------------
	
	//-- mod : today userlist ------------------------------------------------------
	//-- add
	include($phpbb_root_path . 'includes/class_userlist.' . $phpEx);
	$today_userlist = new today_userlist();
	$today_userlist->display();
	unset($today_userlist);
	//-- fin mod : today userlist --------------------------------------------------

	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$rcs->display_legend();
	$newest_color = $rcs->get_colors($newest_userdata);
	//-- fin mod : rank color system -----------------------------------------------

	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);

	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
		//-- mod : rank color system ---------------------------------------------------
		//-- delete
		/*-MOD
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'),
		MOD-*/
		//-- add
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . $get->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $newest_uid), true) . '"' . $newest_color . '>', $newest_user, '</a>'),
		//-- fin mod : rank color system -----------------------------------------------

		'FORUM_IMG' => $images['forum'],
		'FORUM_NEW_IMG' => $images['forum_new'],
		'FORUM_LOCKED_IMG' => $images['forum_locked'],

		'L_FORUM' => $lang['Forum'],
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'], 
		'L_NO_NEW_POSTS' => $lang['No_new_posts'],
		'L_NEW_POSTS' => $lang['New_posts'],
		'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'], 
		'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'], 
		'L_ONLINE_EXPLAIN' => $lang['Online_explain'], 

		'L_MODERATOR' => $lang['Moderators'], 
		'L_FORUM_LOCKED' => $lang['Forum_is_locked'],
		'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'], 
		
		'U_MARK_READ' => append_sid("index.$phpEx?mark=forums"))
	);
	
	
	
	//-- mod: sf
	}
	//-- mod: sf - end

	//
	// Let's decide which categories we should display
	//
	
	//-- mod: sf
	/*
	
	$display_categories = array();

	for ($i = 0; $i < $total_forums; $i++ )
	{
		if ($is_auth_ary[$forum_data[$i]['forum_id']]['auth_view'])
		{
			$display_categories[$forum_data[$i]['cat_id']] = true;
		}
	}
	
	*/
	// now get the last topic info plus the unread flag plus the cats to display
	$_sf_cat_first = array();
	$_sf_last_sub_id = array();
	$_sf_last_child_idx = array();

	$display_categories = _sf_get_last_stacked_data($forum_data, $is_auth_ary, $_sf_root_forum_id, $_sf_cat_first, $_sf_last_sub_id, $_sf_last_child_idx);
	if ( empty($display_categories) )
	{
		if ( defined('IN_VIEWFORUM') )
		{
			return;
		}
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}
	//-- mod: sf - end
	

	//
	// Okay, let's build the index
	//
	for($i = 0; $i < $total_categories; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];

		//
		// Yes, we should, so first dump out the category
		// title, then, if appropriate the forum list
		//
		if (isset($display_categories[$cat_id]) && $display_categories[$cat_id])
		{
			$template->assign_block_vars('catrow', array(
				'CAT_ID' => $cat_id,
				'CAT_DESC' => smilies_pass($category_rows[$i]['cat_title']),
				'U_VIEWCAT' => append_sid("index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
			);
			
			
			//-- mod: sf
			if ( !defined('IN_VIEWFORUM') )
			{
				$template->assign_block_vars('catrow.cat', array());
				$_sf_prev_forum_id = 0;
			}
			else
			{
				$_sf_prev_forum_id = $forum_row['forum_id'];
			}
			$_sf_first_sub = true;
			$_sf_is_sub = false;
			$_sf_rowcolor = false;
			//-- mod: sf - end

			if ( $viewcat == $cat_id || $viewcat == -1 )
			{
				
				//-- mod: sf
				/*
				for($j = 0; $j < $total_forums; $j++)
				{
					if ( $forum_data[$j]['cat_id'] == $cat_id )
					{
						$forum_id = $forum_data[$j]['forum_id'];

						if ( $is_auth_ary[$forum_id]['auth_view'] )
						{
							if ( $forum_data[$j]['forum_status'] == FORUM_LOCKED )
							{
								$folder_image = $images['forum_locked']; 
								$folder_alt = $lang['Forum_locked'];
							}
							else
							{
								$unread_topics = false;
								if ( $userdata['session_logged_in'] )
								{
									if ( !empty($new_topic_data[$forum_id]) )
									{
										$forum_last_post_time = 0;

										while( list($check_topic_id, $check_post_time) = @each($new_topic_data[$forum_id]) )
										{
											if ( empty($tracking_topics[$check_topic_id]) )
											{
												$unread_topics = true;
												$forum_last_post_time = max($check_post_time, $forum_last_post_time);

											}
											else
											{
												if ( $tracking_topics[$check_topic_id] < $check_post_time )
												{
													$unread_topics = true;
													$forum_last_post_time = max($check_post_time, $forum_last_post_time);
												}
											}
										}

										if ( !empty($tracking_forums[$forum_id]) )
										{
											if ( $tracking_forums[$forum_id] > $forum_last_post_time )
											{
												$unread_topics = false;
											}
										}

										if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
										{
											if ( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] > $forum_last_post_time )
											{
												$unread_topics = false;
											}
										}

									}
								}

								$folder_image = ( $unread_topics ) ? $images['forum_new'] : $images['forum']; 
								$folder_alt = ( $unread_topics ) ? $lang['New_posts'] : $lang['No_new_posts']; 
							}
							
							*/
				for ( $j = intval($_sf_cat_first[$cat_id]); $j < $total_forums; $j++)
				{
					if ( $forum_data[$j]['cat_id'] != $cat_id )
					{
						break;
					}
					$forum_id = $forum_data[$j]['forum_id'];

					// jump over a non-authorised branch
					if ( !$is_auth_ary[$forum_id]['auth_view'] )
					{
						$j = $_sf_last_child_idx[$forum_id];
						continue;
					}
					
					
					               if ( $forum_data[$j]['forum_name'] == "Arcade" ) 
{ 
   $folder_image = "<img src=\"games/pics/arcade.gif\" alt=\"Arcade\" />"; 
   $template->assign_block_vars("catrow.arcaderow",array( 
   'FORUM_NAME' => $forum_data[$j]['forum_name'], 
   'FORUM_DESC' => $forum_data[$j]['forum_desc'], 
   'U_VIEWFORUM' => append_sid("arcade.$phpEx"), 
   'U_TOPARCADE' => append_sid("toparcade.$phpEx"), 
   'BEST_SCORES' => $lang['best_scores'], 
   'FOLDER' => $folder_image) 
   ); 


   // Recupération du dernier record aux jeux 
   $sqlArcade = " SELECT g.* , u.username FROM " . GAMES_TABLE . " g left join " . USERS_TABLE . " u on g.game_highuser = u.user_id ORDER BY game_highdate DESC LIMIT 0,1 " ; 
   if ( !($resultArcade = $db->sql_query($sqlArcade)) ) 
   { 
      message_die(GENERAL_ERROR, 'Impossible d\'acceder aux tables games/users', '', __LINE__, __FILE__, $sqlArcade); 
   } 
   if ($rowArcade = $db->sql_fetchrow($resultArcade)) 
   { 
     if ( $rowArcade['game_highuser']!=0 ) 
      { 
      $template->assign_block_vars("catrow.arcaderow.bestscore",array( 
      'LAST_SCOREGAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $rowArcade['game_id']) . '">' . $rowArcade['game_name'] . '</a>', 
      'LAST_SCOREDATE' => create_date($board_config['default_dateformat'], $rowArcade['game_highdate'] , $board_config['board_timezone']), 
      'LAST_SCOREUSER' => '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $rowArcade['game_highuser']) . '">' . $rowArcade['username'] . '</a>', 
      'LAST_SCORE' => $rowArcade['game_highscore']) 
      ); 
      } 
   } 
}                                                                                        
else 
{ 

					// attached to the main object (root, or in viewforum the selected forum)
					if ( (!defined('IN_VIEWFORUM') && !intval($forum_data[$j]['forum_parent'])) || (defined('IN_VIEWFORUM') && (intval($forum_data[$j]['forum_parent']) == $_sf_root_forum_id)) )
					{
						$_sf_prev_forum_id = $forum_id;
						$_sf_is_sub = false;
						$_sf_first_sub = true;
					}
					// attached to a viewable forum, so displayed as sub
					else if ( intval($forum_data[$j]['forum_parent']) == $_sf_prev_forum_id )
					{
						$_sf_is_sub = true;
					}
					// level not displayed: jump over
					else
					{
						if ( !defined('IN_VIEWFORUM') || ($forum_id != $_sf_root_forum_id) )
						{
							$j = $_sf_last_child_idx[$forum_id];
						}
						continue;
					}

					// prepare the display
					if ( !$_sf_is_sub )
					{
						$_sf_rowcolor = !$_sf_rowcolor;
					}
					$row_color = $_sf_rowcolor ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = $_sf_rowcolor ? $theme['td_class1'] : $theme['td_class2'];

					// recompute the front icons
					$_sf_folder = _sf_get_folder($_sf_is_sub ? 'mini' : 'standard', ($_sf_last_sub_id[$forum_id] == $forum_id ? 'std' : 'has_sub') . ($forum_data[$j]['forum_status'] == FORUM_LOCKED ? '_locked' : '') . ($forum_data[$j]['unread'] ? '_new' : '') . (intval($forum_data[$j]['forum_posts']) ? '' : '_empty'));
					$folder_image = $images[ $_sf_folder['img'] ];
					$folder_alt = $lang[ $_sf_folder['txt'] ];

					if ( $_sf_is_sub && $_sf_first_sub )
					{
						$template->assign_block_vars('catrow.forumrow.sub', array());
					}
					{{
					//-- mod: sf - end

							$posts = $forum_data[$j]['forum_posts'];
							$topics = $forum_data[$j]['forum_topics'];
							$icon = $forum_data[$j]['forum_icon'];	// Forum Icon Mod

							if ( $forum_data[$j]['forum_last_post_id'] )
							{
								//-- mod : last active topic on index ------------------------------------------
								//-- add
								$last_topic_url = $get->url('viewtopic', array(POST_TOPIC_URL => $forum_data[$j]['topic_id']), true);
								$last_post_url = $get->url('viewtopic', array(POST_POST_URL => $forum_data[$j]['forum_last_post_id']), true) . '#' . $forum_data[$j]['forum_last_post_id'];

								$destination = $board_config['last_topic_title_redirect'] ? $last_post_url : $last_topic_url;
								$last_topic_title = (strlen($forum_data[$j]['topic_title']) > $board_config['last_topic_title_length']) ? substr($forum_data[$j]['topic_title'], 0, $board_config['last_topic_title_length']) . '...' : $forum_data[$j]['topic_title'];

								$last_post = '<a href="' . $destination . '" title="' . $forum_data[$j]['topic_title'] . '">' . $last_topic_title . '</a><br />';
								//-- fin mod : last active topic on index --------------------------------------

								$last_post_time = create_date($board_config['default_dateformat'], $forum_data[$j]['post_time'], $board_config['board_timezone']);


								//-- mod : last active topic on index ------------------------------------------
								//-- delete
								/*-MOD
								$last_post = $last_post_time . '<br />';
								MOD-*/
								//-- add
								$last_post .= '<span class="date-general">' . $last_post_time . '</span><br />';
								//-- fin mod : last active topic on index --------------------------------------


								//-- mod : rank color system ---------------------------------------------------
								//-- delete
								/*-MOD
								$last_post .= ( $forum_data[$j]['user_id'] == ANONYMOUS ) ? ( ($forum_data[$j]['post_username'] != '' ) ? $forum_data[$j]['post_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $forum_data[$j]['user_id']) . '">' . $forum_data[$j]['username'] . '</a> ';
								MOD-*/
								//-- add
								$style_color = $rcs->get_colors($forum_data[$j]);
								
								$last_post .= ($forum_data[$j]['user_id'] == ANONYMOUS) ? ((($forum_data[$j]['post_username'] != '') ? $forum_data[$j]['post_username'] : $lang['Guest']) . '&nbsp;') : '<a href="' . $get->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $forum_data[$j]['user_id']), true) . '"' . $style_color . '>' . $forum_data[$j]['username'] . '</a>&nbsp;';
								
								//-- MOD END: Last Topic Title on Index -------------------
								
								
								//-- fin mod : rank color system -----------------------------------------------
								
								$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
							}
							else
							{
								$last_post = $lang['No_Posts'];
							}

							if ( count($forum_moderators[$forum_id]) > 0 )
							{
								$l_moderators = ( count($forum_moderators[$forum_id]) == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
								$moderator_list = implode(', ', $forum_moderators[$forum_id]);
							}
							else
							{
								$l_moderators = '&nbsp;';
								$moderator_list = '&nbsp;';
							}


							//-- mod: sf
							/*
							
							$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
							$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

							$template->assign_block_vars('catrow.forumrow',	array(
							
							*/
							$template->assign_block_vars('catrow.forumrow' . ($_sf_is_sub ? '.sub.item' : ''), array(
								'L_SEP' => $forum_id == $_sf_last_sub_id[$_sf_prev_forum_id] ? '': ',',
								'FORUM_DESC_HTML' => htmlspecialchars(preg_replace('#<[\/\!]*?[^<>]*?>#si', '', $forum_data[$j]['forum_desc'])),
								'U_LAST_POST' => intval($forum_data[$j]['forum_posts']) ? append_sid('viewtopic.' . $phpEx . '?' . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] : append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $forum_id),
								'L_LAST_POST' => intval($forum_data[$j]['forum_posts']) ? $lang['View_latest_post'] : $folder_alt,
							//-- mod: sf - end
							
							
								'ROW_COLOR' => '#' . $row_color,
								'ROW_CLASS' => $row_class,
								'FORUM_EDIT_IMG'	=> (($userdata['user_level'] == ADMIN) ? '&nbsp;&nbsp;<a href="#" onclick="window.open(\'admin/admin_forums.'. $phpEx .'?mode=editforum&in_from=index&'. POST_FORUM_URL .'='. $forum_id .'&sid='. $userdata['session_id'] .'\',\'popup\',\'width=650,height=100,scrollbars=yes,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no\'); return false;"><img src="images/forum_edit.gif" border="0"></a>' : ''),
								'FORUM_FOLDER_IMG' => $folder_image, 
								'FORUM_ICON_IMG' => ($icon) ? '<img src="' . $phpbb_root_path . $board_config['forum_icon_path'] . '/' . $icon . '" alt="'.$forum_data[$j]['forum_name'].'" title="'.$forum_data[$j]['forum_name'].'" border="0" />' : '',	// Forum Icon Mod
								/* supprimer par mod Smilies Everywhere
								'FORUM_NAME' => $forum_data[$j]['forum_name'],
								'FORUM_DESC' => $forum_data[$j]['forum_desc'],
								*/
								'FORUM_NAME' => smilies_pass($forum_data[$j]['forum_name']),
								'FORUM_DESC' => smilies_pass($forum_data[$j]['forum_desc']),
								//fin remplacement du code
								'FORUM_COLOR' => ( $forum_data[$j]['forum_color'] != '' ) ? 'style="color: #'.$forum_data[$j]['forum_color'].'"' : '',
								'POSTS' => $forum_data[$j]['forum_posts'],
								'TOPICS' => $forum_data[$j]['forum_topics'],
								'LAST_POST' => $last_post,
								'MODERATORS' => $moderator_list,

								'L_MODERATOR' => $l_moderators, 
								'L_FORUM_FOLDER_ALT' => $folder_alt, 

								'U_VIEWFORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"))
							);
							
							//-- mod: sf
							if ( $_sf_is_sub )
							{
								$template->assign_block_vars('catrow.forumrow.sub.item.first' . ($_sf_first_sub ? '' : '_ELSE'), array());
								$template->assign_block_vars('catrow.forumrow.sub.item.last' . ($forum_id == $_sf_last_sub_id[$_sf_prev_forum_id] ? '' : '_ELSE'), array());
								$template->assign_block_vars('catrow.forumrow.sub.item.link' . (intval($forum_data[$j]['forum_posts']) ? '' : '_ELSE'), array());
								$_sf_first_sub = false;
							}
							//-- mod: sf - end
						}
						
						} // Arcade 
					}
				}
			}
		}
	} // for ... categories

}// if ... total_categories
else
{
	message_die(GENERAL_MESSAGE, $lang['No_forums']);
}

//
// Generate the page
//

//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
//-- mod: sf - end

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

//-- mod: sf
}
else
{
	$forum_id = $_sf_sav_forum_id;
	unset($forum_data);
	unset($categories_row);

	$template->set_filenames(array('subforums' => 'index_body.tpl'));
	$_sf_subforums = _sf_get_pparse('subforums', true);
	if ( !empty($_sf_subforums) )
	{
		$template->assign_vars(array(
			'SUBFORUMS' => $_sf_subforums,
			'U_MARK_FORUMS_READ' => $userdata['session_logged_in'] ? append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . intval($forum_id) .'&amp;mark=forums') : '',
			'L_MARK_FORUMS_READ' => $userdata['session_logged_in'] ? $lang['Mark_all_forums'] : '',
		));
		unset($_sf_subforums);

		// send the mark forum link
		if ( $userdata['session_logged_in'] )
		{
			$template->assign_block_vars('mark_forums', array());
		}
	}
	// back to viewforum
	return;
}
//-- mod: sf - end

?>
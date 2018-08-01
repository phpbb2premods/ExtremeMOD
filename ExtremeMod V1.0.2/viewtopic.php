<?php
//-- mod: sf
//-- mod : topics enhanced -----------------------------------------------------
/***************************************************************************
 *                               viewtopic.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: viewtopic.php,v 1.186.2.47 2006/12/16 13:11:25 acydburn Exp $
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start initial var setup
//
$topic_id = $post_id = 0;
$vote_id = array();
if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_GET_VARS['topic']) )
{
	$topic_id = intval($HTTP_GET_VARS['topic']);
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]))
{
	$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
}


$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

if (!$topic_id && !$post_id)
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}

//
// Find topic id if user requested a newer
// or older topic
//
if ( isset($HTTP_GET_VARS['view']) && empty($HTTP_GET_VARS[POST_POST_URL]) )
{
	if ( $HTTP_GET_VARS['view'] == 'newest' )
	{
		if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_GET_VARS['sid']) )
		{
			$session_id = isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) ? $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid'] : $HTTP_GET_VARS['sid'];

			if (!preg_match('/^[A-Za-z0-9]*$/', $session_id)) 
			{
				$session_id = '';
			}

			if ( $session_id )
			{
				$sql = "SELECT p.post_id
					FROM " . POSTS_TABLE . " p, " . SESSIONS_TABLE . " s,  " . USERS_TABLE . " u
					WHERE s.session_id = '$session_id'
						AND u.user_id = s.session_user_id
						AND p.topic_id = $topic_id
						AND p.post_time >= u.user_lastvisit
					ORDER BY p.post_time ASC
					LIMIT 1";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					message_die(GENERAL_MESSAGE, 'No_new_posts_last_visit');
				}

				$post_id = $row['post_id'];

				if (isset($HTTP_GET_VARS['sid']))
				{
					redirect("viewtopic.$phpEx?sid=$session_id&" . POST_POST_URL . "=$post_id#$post_id");
				}
				else
				{
					redirect("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id");
				}
			}
		}

		redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
	}
	else if ( $HTTP_GET_VARS['view'] == 'next' || $HTTP_GET_VARS['view'] == 'previous' )
	{
		$sql_condition = ( $HTTP_GET_VARS['view'] == 'next' ) ? '>' : '<';
		$sql_ordering = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'ASC' : 'DESC';

		$sql = "SELECT t.topic_id
			FROM " . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2
			WHERE
				t2.topic_id = $topic_id
				AND t.forum_id = t2.forum_id
				AND t.topic_moved_id = 0
				AND t.topic_last_post_id $sql_condition t2.topic_last_post_id
			ORDER BY t.topic_last_post_id $sql_ordering
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain newer/older topic information", '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$topic_id = intval($row['topic_id']);
		}
		else
		{
			$message = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'No_newer_topics' : 'No_older_topics';
			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

//
// This rather complex gaggle of code handles querying for topics but
// also allows for direct linking to a post (and the calculation of which
// page the post is on and the correct display of viewtopic)
//
$join_sql_table = (!$post_id) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = (!$post_id) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = (!$post_id) ? '' : ", COUNT(p2.post_id) AS prev_posts";

$order_sql = (!$post_id) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments ORDER BY p.post_id ASC";

$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments" . $count_sql . "
	FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $join_sql_table . "
	WHERE $join_sql
		AND f.forum_id = t.forum_id
		$order_sql";
		
//-- mod : quick title edition -------------------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT t.topic_attribute, t.topic_poster, ', $sql);
//-- fin mod : quick title edition ---------------------------------------------
		
//-- mod : quick post es -------------------------------------------------------
//-- add
$sql = str_replace(', f.forum_id', ', f.forum_id, f.forum_qpes', $sql);
//-- fin mod : quick post es ---------------------------------------------------
		
attach_setup_viewtopic_auth($order_sql, $sql);
		
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}

$forum_id = intval($forum_topic_data['forum_id']);

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

if ( $userdata['user_cell_time'] > 0 && !defined('CELL') && $userdata['session_logged_in'] && $userdata['user_level'] != ADMIN && $userdata['user_cell_punishment'] == 3 )
{
	redirect(append_sid("cell.$phpEx", true));
}

//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_display_nav($forum_id);
//-- mod: sf - end

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_topic_data);

if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = ($post_id) ? POST_POST_URL . "=$post_id" : POST_TOPIC_URL . "=$topic_id";
		$redirect .= ($start) ? "&start=$start" : '';
		redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&$redirect", true));
	}

	$message = ( !$is_auth['auth_view'] ) ? $lang['Topic_post_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End auth check
//

// Forum Icon Mod
$sql = "SELECT forum_icon
	FROM " . FORUMS_TABLE . "
	WHERE forum_id = $forum_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
}
$forum_row = $db->sql_fetchrow($result);
$forum_icon = $forum_row['forum_icon'];

$forum_name = $forum_topic_data['forum_name'];
$topic_title = $forum_topic_data['topic_title'];
//-- mod : quick title edition -------------------------------------------------
//-- add
include($get->url('includes/class_attributes'));
$qte->attr($topic_title, $forum_topic_data['topic_attribute']);
//-- fin mod : quick title edition ---------------------------------------------
$topic_id = intval($forum_topic_data['topic_id']);
$topic_time = $forum_topic_data['topic_time'];

if ($post_id)
{
	$start = floor(($forum_topic_data['prev_posts'] - 1) / intval($board_config['posts_per_page'])) * intval($board_config['posts_per_page']);
}

//
// Is user watching this thread?
//
if( $userdata['session_logged_in'] )
{
	$can_watch_topic = TRUE;

	$sql = "SELECT notify_status
		FROM " . TOPICS_WATCH_TABLE . "
		WHERE topic_id = $topic_id
			AND user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic watch information", '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($HTTP_GET_VARS['unwatch']) )
		{
			if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
			{
				$is_watching_topic = 0;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "DELETE $sql_priority FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not delete topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['No_longer_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = TRUE;

			if ( $row['notify_status'] )
			{
				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "UPDATE $sql_priority " . TOPICS_WATCH_TABLE . "
					SET notify_status = 0
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not update topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	else
	{
		if ( isset($HTTP_GET_VARS['watch']) )
		{
			if ( $HTTP_GET_VARS['watch'] == 'topic' )
			{
				$is_watching_topic = TRUE;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not insert topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['You_are_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = 0;
		}
	}
}
else
{
	if ( isset($HTTP_GET_VARS['unwatch']) )
	{
		if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
		{
			redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&" . POST_TOPIC_URL . "=$topic_id&unwatch=topic", true));
		}
	}
	else
	{
		$can_watch_topic = 0;
		$is_watching_topic = 0;
	}
}

//
// Generate a 'Show posts in previous x days' select box. If the postdays var is POSTed
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Posts'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if( !empty($HTTP_POST_VARS['postdays']) || !empty($HTTP_GET_VARS['postdays']) )
{
	$post_days = ( !empty($HTTP_POST_VARS['postdays']) ) ? intval($HTTP_POST_VARS['postdays']) : intval($HTTP_GET_VARS['postdays']);
	$min_post_time = time() - (intval($post_days) * 86400);

	$sql = "SELECT COUNT(p.post_id) AS num_posts
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
		WHERE t.topic_id = $topic_id
			AND p.topic_id = t.topic_id
			AND p.post_time >= $min_post_time";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain limited topics count information", '', __LINE__, __FILE__, $sql);
	}

	$total_replies = ( $row = $db->sql_fetchrow($result) ) ? intval($row['num_posts']) : 0;

	$limit_posts_time = "AND p.post_time >= $min_post_time ";

	if ( !empty($HTTP_POST_VARS['postdays']))
	{
		$start = 0;
	}
}
else
{
	$total_replies = intval($forum_topic_data['topic_replies']) + 1;

	$limit_posts_time = '';
	$post_days = 0;
}

$select_post_days = '<select name="postdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($post_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_post_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_post_days .= '</select>';

//
// Decide how to order the post display
//
if ( !empty($HTTP_POST_VARS['postorder']) || !empty($HTTP_GET_VARS['postorder']) )
{
	$post_order = (!empty($HTTP_POST_VARS['postorder'])) ? htmlspecialchars($HTTP_POST_VARS['postorder']) : htmlspecialchars($HTTP_GET_VARS['postorder']);
	$post_time_order = ($post_order == "asc") ? "ASC" : "DESC";
}
else
{
	$post_order = 'asc';
	$post_time_order = 'ASC';
}

$select_post_order = '<select name="postorder">';
if ( $post_time_order == 'ASC' )
{
	$select_post_order .= '<option value="asc" selected="selected">' . $lang['Oldest_First'] . '</option><option value="desc">' . $lang['Newest_First'] . '</option>';
}
else
{
	$select_post_order .= '<option value="asc">' . $lang['Oldest_First'] . '</option><option value="desc" selected="selected">' . $lang['Newest_First'] . '</option>';
}
$select_post_order .= '</select>';

//
// forum enter limit by emrag
//
		if (!($userdata['user_level'] == ADMIN OR $userdata['user_level'] == MOD))
		{
		$sql = "SELECT f.forum_id, f.forum_enter_limit, u.user_posts
			FROM " . FORUMS_TABLE . " f, " . USERS_TABLE . " u
			WHERE user_id = " . $userdata['user_id'];

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query information', '', __LINE__, __FILE__, $sql);
		}

			while ($row = $db->sql_fetchrow($result))
			{
			$forum_id_limit = $row['forum_id'];
			$forum_enter_limit = $row['forum_enter_limit'];
			$user_posts_limit = $row['user_posts'];

			$error_limit = "Vous devez avoir posté $forum_enter_limit messages pour accéder a ce forum.";

				if ($forum_id == $forum_id_limit AND $user_posts_limit < $forum_enter_limit)
				{
					message_die(GENERAL_ERROR, $error_limit);
				}
			}
		}
//
// forum enter limit by emrag
//

//
// Go ahead and pull all data for this topic
//
$sql = "SELECT u.username,u.user_mood_mod, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, u.user_warn, u.user_level, u.user_birthday, u.user_next_birthday_greeting, u.user_allow_viewonline, u.user_session_time,u.user_points,u.user_cell_time, u.user_cell_celleds, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
	FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
	WHERE p.topic_id = $topic_id
		$limit_posts_time
		AND pt.post_id = p.post_id
		AND u.user_id = p.poster_id
	ORDER BY p.post_time $post_time_order
	LIMIT $start, ".$board_config['posts_per_page'];
	
	//-- mod : post description ----------------------------------------------------
	//-- add
	$sql = str_replace(', pt.post_subject', ', pt.post_subject, pt.post_sub_title', $sql);
	//-- fin mod : post description ------------------------------------------------
	
	//-- mod : quick title edition -------------------------------------------------
	//-- add
	$sql = str_replace('pt.bbcode_uid', 'pt.bbcode_uid, t.topic_poster', $sql);
	$sql = str_replace(POSTS_TEXT_TABLE . ' pt', POSTS_TEXT_TABLE . ' pt, ' . TOPICS_TABLE . ' t', $sql);
	$sql = str_replace('WHERE p.topic_id = ' . $topic_id, 'WHERE p.topic_id = ' . $topic_id . ' AND t.topic_id = p.topic_id', $sql);
	//-- fin mod : quick title edition ---------------------------------------------
	
	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
	//-- fin mod : rank color system -----------------------------------------------
	
	//-- mod : gender --------------------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT u.user_gender, ', $sql);
	//-- fin mod : gender ----------------------------------------------------------
	
	//-- mod : flags ---------------------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT u.user_flag, ', $sql);
	//-- fin mod : flags -----------------------------------------------------------
	
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain post/user information.", '', __LINE__, __FILE__, $sql);
}

$postrow = array();
if ($row = $db->sql_fetchrow($result))
{
	do
	{
		$postrow[] = $row;
	}
	while ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);

	$total_posts = count($postrow);
}
else 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   message_die(GENERAL_MESSAGE, $lang['No_posts_topic']); 
} 

$resync = FALSE; 
if ($forum_topic_data['topic_replies'] + 1 < $start + count($postrow)) 
{ 
   $resync = TRUE; 
} 
elseif ($start + $board_config['posts_per_page'] > $forum_topic_data['topic_replies']) 
{ 
   $row_id = intval($forum_topic_data['topic_replies']) % intval($board_config['posts_per_page']); 
   if ($postrow[$row_id]['post_id'] != $forum_topic_data['topic_last_post_id'] || $start + count($postrow) < $forum_topic_data['topic_replies']) 
   { 
      $resync = TRUE; 
   } 
} 
elseif (count($postrow) < $board_config['posts_per_page']) 
{ 
   $resync = TRUE; 
} 

if ($resync) 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   $result = $db->sql_query('SELECT COUNT(post_id) AS total FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id); 
   $row = $db->sql_fetchrow($result); 
   $total_replies = $row['total']; 
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Censor topic title
//
if ( count($orig_word) )
{
	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
}

//
// Was a highlight request part of the URI?
//
$highlight_match = $highlight = '';
if (isset($HTTP_GET_VARS['highlight']))
{
	// Split words and phrases
	$words = explode(' ', trim(htmlspecialchars($HTTP_GET_VARS['highlight'])));

	for($i = 0; $i < sizeof($words); $i++)
	{
		if (trim($words[$i]) != '')
		{
			$highlight_match .= (($highlight_match != '') ? '|' : '') . str_replace('*', '\w*', preg_quote($words[$i], '#'));
		}
	}
	unset($words);

	$highlight = urlencode($HTTP_GET_VARS['highlight']);
	$highlight_match = phpbb_rtrim($highlight_match, "\\");
}

//
// Post, reply and other URL generation for
// templating vars
//
$new_topic_url = append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id");
$reply_topic_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id");
$view_forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id");
$view_prev_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=previous");
$view_next_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=next");

//
// Mozilla navigation bar
//
$nav_links['prev'] = array(
	'url' => $view_prev_topic_url,
	'title' => $lang['View_previous_topic']
);
$nav_links['next'] = array(
	'url' => $view_next_topic_url,
	'title' => $lang['View_next_topic']
);
$nav_links['up'] = array(
	'url' => $view_forum_url,
	'title' => $forum_name
);

$reply_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $images['reply_locked'] : $images['reply_new'];
$reply_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['Reply_to_topic'];
$post_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'];
$post_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'];

//
// Set a cookie for this topic
//
if ( $userdata['session_logged_in'] )
{
	$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
	$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();

	if ( !empty($tracking_topics[$topic_id]) && !empty($tracking_forums[$forum_id]) )
	{
		$topic_last_read = ( $tracking_topics[$topic_id] > $tracking_forums[$forum_id] ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
	}
	else if ( !empty($tracking_topics[$topic_id]) || !empty($tracking_forums[$forum_id]) )
	{
		$topic_last_read = ( !empty($tracking_topics[$topic_id]) ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
	}
	else
	{
		$topic_last_read = $userdata['user_lastvisit'];
	}

	if ( count($tracking_topics) >= 150 && empty($tracking_topics[$topic_id]) )
	{
		asort($tracking_topics);
		unset($tracking_topics[key($tracking_topics)]);
	}

	$tracking_topics[$topic_id] = time();

	setcookie($board_config['cookie_name'] . '_t', serialize($tracking_topics), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

//
// Load templates
//
$template->set_filenames(array(
	'body' => 'viewtopic_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);

//
// Output page header
//
//-- mod : quick title edition -------------------------------------------------
//-- delete
/*-MOD
$page_title = $lang['View_topic'] .' - ' . $topic_title;
MOD-*/
//-- add
$page_title = $lang['View_topic'] . ' - ' . $forum_topic_data['topic_title'];
//-- fin mod : quick title edition ---------------------------------------------
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//-- mod : toolbar -------------------------------------------------------------
//-- add
if ( $can_watch_topic )
{
	$uw_parm = $is_watching_topic ? 'unwatch' : 'watch';
	$tlbr_more = array(
		'watch' => array('link_pgm' => 'viewtopic', 'link_parms' => array(POST_TOPIC_URL => intval($topic_id), $uw_parm => 'topic', 'start' => intval($start)), 'txt' => $is_watching_topic ? 'Stop_watching_topic' : 'Start_watching_topic', 'img' => $is_watching_topic ? 'tlbr_un_watch' : 'tlbr_watch'),
	);
}
build_toolbar('viewtopic', $l_privmsgs_text, $s_privmsg_new, $forum_id, $tlbr_more);
//-- fin mod : toolbar ---------------------------------------------------------


//-- mod : quick post es -------------------------------------------------------
//-- add
$forum_qpes = intval($forum_topic_data['forum_qpes']);
if (!empty($forum_qpes))
{
	include($phpbb_root_path . 'qpes.' . $phpEx);
}
//-- fin mod : quick post es ---------------------------------------------------

//
// User authorisation levels output
//
$s_auth_can = ( ( $is_auth['auth_post'] ) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_reply'] ) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_delete'] ) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';

attach_build_auth_levels($is_auth, $s_auth_can);

$topic_mod = '';

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= ( $forum_topic_data['topic_status'] == TOPIC_UNLOCKED ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=lock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_lock'] . '" alt="' . $lang['Lock_topic'] . '" title="' . $lang['Lock_topic'] . '" border="0" /></a>&nbsp;' : "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=unlock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_unlock'] . '" alt="' . $lang['Unlock_topic'] . '" title="' . $lang['Unlock_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
	
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=merge&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_merge'] . '" alt="' . $lang['Merge_topic'] . '" title="' . $lang['Merge_topic'] . '" border="0" /></a>&nbsp;';
}


//-- mod : quick title edition -------------------------------------------------
//-- add
if ( ( ($userdata['user_id'] == $postrow[$row_id]['topic_poster']) && ($userdata['user_level'] == USER) ) || ($userdata['user_level'] == MOD) || ($userdata['user_level'] == ADMIN) )
{
	$get->assign_switch('switch_attribute', true);
}
//-- fin mod : quick title edition ---------------------------------------------

//
// Topic watch information
//
$s_watching_topic = '';
if ( $can_watch_topic )
{
	if ( $is_watching_topic )
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Stop_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['topic_un_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_un_watch'] . '" alt="' . $lang['Stop_watching_topic'] . '" title="' . $lang['Stop_watching_topic'] . '" border="0"></a>' : '';
	}
	else
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Start_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['Topic_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['Topic_watch'] . '" alt="' . $lang['Start_watching_topic'] . '" title="' . $lang['Start_watching_topic'] . '" border="0"></a>' : '';
	}
}

//
// If we've got a hightlight set pass it on to pagination,
// I get annoyed when I lose my highlight after the first page.
//
$pagination = ( $highlight != '' ) ? generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight", $total_replies, $board_config['posts_per_page'], $start) : generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order", $total_replies, $board_config['posts_per_page'], $start);

//
// Send vars to template
//
$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
    	/* supprimé par Smilies Everywhere
    	'FORUM_NAME' => $forum_name,
    	'TOPIC_ID' => $topic_id,
    	'TOPIC_TITLE' => $topic_title,
    	*/
    	'FORUM_NAME' => smilies_pass($forum_name),
    	'FORUM_ICON_IMG' => ($forum_icon) ? '<img src="' . $phpbb_root_path . $board_config['forum_icon_path'] . '/' . $forum_icon . '" alt="'.$forum_name.'" title="'.$forum_name.'" border="0" />&nbsp;' : '',	// Forum Icon Mod
	'TOPIC_ID' => $topic_id,
	'TOPIC_TITLE' => smilies_pass($topic_title),
	'TOPIC_TITLE2' => $topic_title,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval($board_config['posts_per_page']) ) + 1 ), ceil( $total_replies / intval($board_config['posts_per_page']) )),

	'POST_IMG' => $post_img,
	'REPLY_IMG' => $reply_img,
	'LEFT_GRAPH_IMAGE' => $images['vote_left'], 
	'RIGHT_GRAPH_IMAGE' => $images['vote_right'], 
	'GRAPH_IMAGE' => $images['vote_bar'],
	'L_AUTHOR' => $lang['Author'],
	'L_MESSAGE' => $lang['Message'],
	'L_POSTED' => $lang['Posted'],
	'L_POST_SUBJECT' => $lang['Post_subject'],
	'L_VIEW_NEXT_TOPIC' => $lang['View_next_topic'],
	'L_VIEW_PREVIOUS_TOPIC' => $lang['View_previous_topic'],
	'L_POST_NEW_TOPIC' => $post_alt,
	'L_POST_REPLY_TOPIC' => $reply_alt,
	'L_BACK_TO_TOP' => $lang['Back_to_top'],
	'L_DISPLAY_POSTS' => $lang['Display_posts'],
	'L_LOCK_TOPIC' => $lang['Lock_topic'],
	'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
	'L_MOVE_TOPIC' => $lang['Move_topic'],
	'L_SPLIT_TOPIC' => $lang['Split_topic'],
	'L_DELETE_TOPIC' => $lang['Delete_topic'],
	'L_GOTO_PAGE' => $lang['Goto_page'],

	'S_TOPIC_LINK' => POST_TOPIC_URL,
	'S_SELECT_POST_DAYS' => $select_post_days,
	'S_SELECT_POST_ORDER' => $select_post_order,
	'S_POST_DAYS_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id . "&amp;start=$start"),
	'S_AUTH_LIST' => $s_auth_can,
	'S_TOPIC_ADMIN' => $topic_mod,
	'S_WATCH_TOPIC' => $s_watching_topic,
	'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,
	//-- mod : quick title edition -------------------------------------------------
	//-- add
	'S_ATTRIBUTE_SELECTOR' => $qte->combo($forum_topic_data['topic_attribute'], $forum_topic_data['topic_poster']),
	'F_ATTRIBUTE_URL' => $get->url('modcp', array('sid' => $userdata['session_id']), true),
	'L_ATTRIBUTE_APPLY' => $lang['Attribute_apply'],
	'I_MINI_SUBMIT' => $images['cmd_mini_submit'],
	//-- fin mod : quick title edition ---------------------------------------------

	'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight"),
	'U_VIEW_FORUM' => $view_forum_url,
	'U_VIEW_OLDER_TOPIC' => $view_prev_topic_url,
	'U_VIEW_NEWER_TOPIC' => $view_next_topic_url,
	'U_POST_NEW_TOPIC' => $new_topic_url,
	'U_POST_REPLY_TOPIC' => $reply_topic_url)
);

//
// Does this topic contain a poll?
//
if ( !empty($forum_topic_data['topic_vote']) )
{
	$s_hidden_fields = '';

	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vd.vote_max, vd.vote_voted, vd.vote_hide, vd.vote_undo, vr.vote_option_id, vr.vote_option_text, vr.vote_result
		FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
		WHERE vd.topic_id = $topic_id
			AND vr.vote_id = vd.vote_id
		ORDER BY vr.vote_result DESC,vr.vote_option_id ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain vote data for this topic", '', __LINE__, __FILE__, $sql);
	}

	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options = count($vote_info);

		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];
		$max_vote = $vote_info[0]['vote_max'];
		$voted_vote = $vote_info[0]['vote_voted'];
		$hide_vote = $vote_info[0]['vote_hide'];

		$sql = "SELECT vote_option_id
			FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id = $vote_id
				AND vote_user_id = " . intval($userdata['user_id']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $db->sql_numrows() < $max_vote ) ? 0 : TRUE;
		if ( $db->sql_numrows() > 0 && !($user_voted) )	//	get options already voted for
		{ 
			$row = $db->sql_fetchrowset($result);
			for ($i = 0; $i < count($row); $i++)
			{
				$vbn[$i] = $row[$i]['vote_option_id'];
			}
			$db->sql_freeresult($result);
		}

		if ( isset($HTTP_GET_VARS['vote']) || isset($HTTP_POST_VARS['vote']) )
		{
			$view_result = ( ( ( isset($HTTP_GET_VARS['vote']) ) ? $HTTP_GET_VARS['vote'] : $HTTP_POST_VARS['vote'] ) == 'viewresult' ) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}

		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;
		
				$auth_undo = ( $vote_info[0]['vote_undo'] ) ? true : false;
		if ( $userdata['user_level'] == ADMIN )
		{
			$auth_mod = true;
		}
		else if ( $userdata['user_level'] == MOD )
		{
			$sql = "SELECT ug.user_id 
				FROM " . AUTH_ACCESS_TABLE . " aa, 
				" . USER_GROUP_TABLE . " ug WHERE 
				aa.auth_mod = " . TRUE . " AND 
				aa.group_id = ug.group_id AND 
				aa.forum_id = $forum_id AND 
				ug.user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not obtain user permissions", '', __LINE__, __FILE__, $sql);
			}
			$auth_mod = ( $db->sql_numrows() ) ? true : false;
		}
		else
		{
			$auth_mod = false;
		}

		if ( $user_voted || $view_result || $poll_expired || !$is_auth['auth_vote'] || $forum_topic_data['topic_status'] == TOPIC_LOCKED )
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_result.tpl')
			);

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}

			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);
			
						if ( ($hide_vote && ($hide_vote % 3 != 1)) && !$poll_expired && $vote_info[0]['vote_length'] && !$auth_mod )
			{
				//	Resort the options - the results are hidden so we shouldn't
				//	give any inclination to what is winning
				$new_sort = array();
				for ($i = 0; $i < $vote_options; $i++)
				{
					$new_sort[$vote_info[$i]['vote_option_id']] = $i;
				}
				ksort($new_sort);
	
				foreach ($new_sort as $i)
				{
					$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
					$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);
	
					$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
					$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;
	
					if ( count($orig_word) )
					{
						$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
					}
					
				$disable = false;
				if (isset($vbn))
				{
					foreach ($vbn as $option)
					{
						if ($option == $vote_info[$i]['vote_option_id'])
						{
							$disable = true;
						}
					}
				}
				$disabled = ($disable) ? "disabled=\"disabled\" " : "";
	
					$template->assign_block_vars("poll_option", array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => '',
						'POLL_OPTION_PERCENT' => '',
						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => '0')
					);
				}
			}
			else
			{

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
				$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);

				$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
				$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;

				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars("poll_option", array(
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
					'POLL_OPTION_RESULT' => $vote_info[$i]['vote_result'],
					'POLL_OPTION_PERCENT' => sprintf("%.1d%%", ($vote_percent * 100)),

					'POLL_OPTION_IMG' => $vote_graphic_img,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
				);
			}
			
		}

			if ( ($hide_vote && ($hide_vote % 3 != 1)) && !$poll_expired && $vote_info[0]['vote_length'] && !$auth_mod )
			{
				$template->assign_block_vars("after", array(
					'L_RESULTS_AFTER' => $lang['Results_after'])
				);
				if ( $hide_vote % 3 )
				{
					$template->assign_block_vars("voted", array(
						'L_VOTED' => $lang['Voted_show'],
						'VOTED' => $voted_vote)
					);
				}
			}
			else
			{
				$template->assign_block_vars("voted", array(
					'L_VOTED' => $lang['Voted_show'],
					'VOTED' => $voted_vote)
				);
				$template->assign_block_vars("total", array(
					'L_TOTAL_VOTES' => $lang['Total_votes'],
					'TOTAL_VOTES' => $vote_results_sum)
				);
			}

			if ( !$poll_expired && $vote_info[0]['vote_length'] )
			{
				$time_left = $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] - time();
				$days_left = intval($time_left / 86400);
				$time_left = $time_left - ( $days_left * 86400 );
				$hours_left = intval($time_left / 3600);
				$time_left = $time_left - ( $hours_left * 3600 );
				$minutes_left = intval($time_left / 60);
				$time_left = (( $days_left == 1 ) ? $days_left . ' ' . $lang['Day'] : $days_left . ' ' . $lang['Days']) . ', ';
				$time_left .= (( $hours_left == 1 ) ? $hours_left . ' ' . $lang['Hour'] : $hours_left . ' ' . $lang['Hours']) . ', ';
				$time_left .= ( $minutes_left == 1 ) ? $minutes_left . ' ' . $lang['Minute'] : $minutes_left . ' ' . $lang['Minutes'];
			
				$template->assign_block_vars("expires", array(
					'L_POLL_EXPIRES' => $lang['Poll_expires'],
					'POLL_EXPIRES' => $time_left)
				);
			}
			else if ($poll_expired == 1)
			{
				$template->assign_block_vars("expires", array(
					'L_POLL_EXPIRES' => $lang['Poll_expired'],
					'POLL_EXPIRES' => '')
				);
			}

			$vote_manage_text = '';
			if ( ($hide_vote > 4 && $poll_expired) || !$hide_vote || $auth_mod )
			{
				$vote_manage_text = $lang['Detailed_results'];
			}
			$vote_manage_text .= ( strlen($vote_manage_text) && ($auth_undo || $auth_mod) ) ? '/'.$lang['Undo_votes'] : (( $auth_undo ) ? $lang['Undo_votes'] : '');
			if ( $vote_manage_text == $lang['Undo_votes'] )
			{
				$vote_manager = '<a href="'.append_sid("vote_manage.$phpEx?vote_id=$vote_id&amp;action=undo&amp;user_id=".$userdata['user_id']).'">'.$vote_manage_text.'</a>';
			}
			else if ( strlen($vote_manage_text) )
			{
				$vote_manager = '<a href="'.append_sid("vote_manage.$phpEx?vote_id=$vote_id").'">'.$vote_manage_text.'</a>';
			}
			if ( strlen($vote_manager) )
			{
				$template->assign_block_vars("vote_manage", array(
					'VOTE_MANAGE' => $vote_manager)
				);
			}

		}
		else
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_ballot.tpl')
			);
			
			$vote_box = ( $max_vote > 1 && ($max_vote - count($vbn) > 1) ) ? 'checkbox' : 'radio';


			//	Resort the options -- the user has not voted yet,
			//	so they don't need to see them in order of what's winning
			$new_sort = array();
			for($i = 0; $i < $vote_options; $i++)
			{
				$new_sort[$vote_info[$i]['vote_option_id']] = $i;
			}
			ksort($new_sort);

			foreach ($new_sort as $i)
			
			{
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars("poll_option", array(
					'POLL_VOTE_BOX' => $vote_box,
					'POLL_OPTION_DISABLED' => $disabled,
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'])
				);
			}

			$template->assign_vars(array(
				'L_SUBMIT_VOTE' => $lang['Submit_vote'],
				'L_VIEW_RESULTS' => $lang['View_results'],

				'U_VIEW_RESULTS' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;vote=viewresult"))
			);

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
		}
		
		if ( $max_vote > 1 && ($max_vote - count($vbn) > 1) )
		{
			$vote_br = '<br/>';
			$max_vote_nb = $max_vote - count($vbn);
		}
		else
		{
			$vote_br = '';
			$lang['Max_voting_1_explain'] = '';
			$lang['Max_voting_2_explain'] = '';
			$max_vote_nb = '';
		}
		

		if ( count($orig_word) )
		{
			$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'POLL_QUESTION' => $vote_title,
			'POLL_VOTE_BR' => $vote_br,
			'MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
			'MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
			'MAX_VOTE' => $max_vote_nb,
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_POLL_ACTION' => append_sid("posting.$phpEx?mode=vote&amp;" . POST_TOPIC_URL . "=$topic_id"))
		);

		$template->assign_var_from_handle('POLL_DISPLAY', 'pollbox');
	}
}

init_display_post_attachments($forum_topic_data['topic_attachment']);

//
// Update the topic view counter
//
$sql = "UPDATE " . TOPICS_TABLE . "
	SET topic_views = topic_views + 1
	WHERE topic_id = $topic_id";
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}

$overall_total_posts = get_db_stat('postcount');
//
// Okay, let's do the loop, yeah come on baby let's do the loop
// and it goes like this ...
//

// Start add - Birthday MOD
$this_year = create_date('Y', time(), $board_config['board_timezone']);
$this_date = create_date('md', time(), $board_config['board_timezone']);
// End add - Birthday MOD

//-- mod : topics enhanced -----------------------------------------------------
//-- add
//-- topics nav buttons
$num_row = 0;
//-- fin mod : topics enhanced -------------------------------------------------
for($i = 0; $i < $total_posts; $i++)
{
	
	$cards = '';
        $red_card = false;
        $warn_level = '';
        $max_warn_level = '';
	$max_warn_level = $board_config['card_max'];
	$card_sql = "SELECT ban_userid FROM ".BANLIST_TABLE." WHERE ban_userid = '".$postrow[$i]['user_id']."' LIMIT 1";
	if( !( $card_result = $db->sql_query($card_sql) ))
	{
		message_die(GENERAL_ERROR, 'Could not read ban entry', '', __LINE__, __FILE__, $card_sql);
	}
	if( $db->sql_numrows($card_result) >= 1 )
	{
		$red_card = true;
	}	
	else if( $postrow[$i]['user_warn'] == $max_warn_level ) 
	{
		$red_card = true;
	}
	else
	{
		$red_card = false;
                if( $postrow[$i]['user_warn'] > 0 )
		{
			$j = 1;
			$p = 1;
			while( $p <= $postrow[$i]['user_warn'] )
			{
				if( $j == 4 )
				{
					$j = 0;
					$br = '<br />';
				}
				else 
				{
					$j++;
					$br = '';
				}	
				$cards .= ' <img src="'.$phpbb_root_path.'images/yellow_card.gif'.'" border="0" alt="'.$lang['yellow_card'].'" />'.$br;
	                        $p++;  		
			}
		}
		else
		{
			$j = 1;
		}	
	}
	if( $red_card === true )
	{
		$cards = '<img src="'.$phpbb_root_path.'images/red_card.gif'.'" border="0" alt="'.$lang['red_card'].'" />';
	}
	if( ( $userdata['user_level'] == ADMIN or $is_auth['auth_mod'] ) && $postrow[$i]['user_id'] != ANONYMOUS && $postrow[$i]['user_level'] != ADMIN )
	{
		$warn_red_card = '<a href="'. append_sid($phpbb_root_path.'card_report.'.$phpEx.'?mode=ban&user='.$postrow[$i]['user_id'].'&redirect=viewtopic.'.$phpEx.'?p='.$postrow[$i]['post_id']) .'"><img src="'.$phpbb_root_path.'images/red_card.gif" border="0" /></a>';
		$warn_yellow_card = '<a href="'. append_sid($phpbb_root_path.'card_report.'.$phpEx.'?mode=warn&user='.$postrow[$i]['user_id'].'&redirect=viewtopic.'.$phpEx.'?p='.$postrow[$i]['post_id']) .'"><img src="'.$phpbb_root_path.'images/yellow_card.gif" border="0" /></a>';
		$warn_green_card = '<a href="'. append_sid($phpbb_root_path.'card_report.'.$phpEx.'?mode=green&user='.$postrow[$i]['user_id'].'&redirect=viewtopic.'.$phpEx.'?p='.$postrow[$i]['post_id']) .'"><img src="'.$phpbb_root_path.'images/green_card.gif" border="0" /></a>';		
	}
        else
	{
		$warn_red_card = '';
		$warn_yellow_card = '';
		$warn_green_card = '';
	}
	
	
	//-- mod : topics enhanced -----------------------------------------------------
	//-- add
	//-- topics nav buttons
	
	
	$num_row++;

	$nav_buttons = (empty($i)) ? '<a href="' . append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $topic_id . '&amp;view=previous') . '"><img alt="" src="' . $images['nav_prev'] . '" title="' . $lang['View_previous_topic'] . '" border="0" /></a>' : '';
	$nav_buttons .= (($i == $total_posts - 1) && $total_posts != 1) ? '<a href="#top"><img alt="" src="' . $images['nav_top'] . '" title="' . $lang['Back_to_top'] . '" border="0" /></a>' : '';
	$nav_buttons .= (!empty($i)) ? '<a href="#' . ($num_row - 1) . '"><img alt="" src="' . $images['nav_prev_post'] . '" title="' . $lang['View_previous_post'] . '" border="0" /></a>' : '';
	$nav_buttons .= ($i != $total_posts - 1) ? '<a href="#' . ($num_row + 1) . '"><img alt="" src="' . $images['nav_next_post'] . '" title="' . $lang['View_next_post'] . '" border="0" /></a>' : '';
	$nav_buttons .= (empty($i)) ? '<a href="#bot"><img alt="" src="' . $images['nav_bot'] . '" title="' . $lang['Go_to_bottom'] . '" border="0" /></a>' : '';
	$nav_buttons .= (empty($i)) ? '<a href="' . append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $topic_id . '&amp;view=next') . '"><img alt="" src="' . $images['nav_next'] . '" title="' . $lang['View_next_topic'] . '" border="0" /></a>' : '';
	//-- fin mod : topics enhanced -------------------------------------------------
	
	$poster_id = $postrow[$i]['user_id'];
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
	
	// Start add - Birthday MOD
	if ( $postrow[$i]['user_birthday'] != 999999 ) 
	{
		$poster_birthdate=realdate('md', $postrow[$i]['user_birthday']);
		$poster_age = $this_year - realdate ('Y',$postrow[$i]['user_birthday']);
		if ($this_date < $poster_birthdate) $poster_age--;
		$poster_age = $lang['Age'] . ': ' . $poster_age;
	} else
	{
		$poster_age = '';
	}
	// End add - Birthday MOD
	
	//-- mod : flags ---------------------------------------------------------------
	//-- add
	$poster_flag = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $postrow[$i]['user_flag'] : '';
	//-- fin mod : flags -----------------------------------------------------------

	$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

	$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';

	$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';

	$poster_joined = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';

	$celleds =  ( $board_config['cell_allow_display_celleds'] && $postrow[$i]['user_cell_celleds'] ) ? sprintf('<br />'.$lang['Celleds_time'].'<a href="' . append_sid("courthouse.$phpEx?from=celleds_list") . '">'.$postrow[$i]['user_cell_celleds'].'</a>') : '';
	$poster_avatar = '';
	if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )
	{
		switch( $postrow[$i]['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				$poster_avatar = ( ($postrow[$i]['user_cell_time'] > 0) && $board_config['cell_allow_display_bars'] ) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $poster_avatar ;
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				$poster_avatar = ( ($postrow[$i]['user_cell_time'] > 0) && $board_config['cell_allow_display_bars']) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $postrow[$i]['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $poster_avatar ;
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				$poster_avatar = ( ($postrow[$i]['user_cell_time'] > 0) && $board_config['cell_allow_display_bars']) ? '<div style="position:absolute;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:1;"><IMG src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" border=0 width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div><div style="position:relative;padding:0px;width:'.$board_config['avatar_max_width'].'px;height:'.$board_config['avatar_max_height'].'px;z-index:2;"><IMG src="images/cell.gif" border=0 STYLE="filter:alpha(opacity=65)" width="'.$board_config['avatar_max_width'].'" height="'.$board_config['avatar_max_height'].'"></div>' : $poster_avatar ;
				break;
		}
	}
	
	// Default avatar MOD, By Manipe (Begin)
	if ((!$poster_avatar) && ($board_config['default_avatar_set'] != 3)){
		if (($board_config['default_avatar_set'] == 0) && ($poster_id == -1) && ($board_config['default_avatar_guests_url'])){
			$poster_avatar = '<img src="' . $board_config['default_avatar_guests_url'] . '" alt="" border="0" />';
		}
		else if (($board_config['default_avatar_set'] == 1) && ($poster_id != -1) && ($board_config['default_avatar_users_url']) ){
			$poster_avatar = '<img src="' . $board_config['default_avatar_users_url'] . '" alt="" border="0" />';
		}
		else if ($board_config['default_avatar_set'] == 2){
			if (($poster_id == -1) && ($board_config['default_avatar_guests_url'])){
				$poster_avatar = '<img src="' . $board_config['default_avatar_guests_url'] . '" alt="" border="0" />';
			}
			else if (($poster_id != -1) && ($board_config['default_avatar_users_url'])){
				$poster_avatar = '<img src="' . $board_config['default_avatar_users_url'] . '" alt="" border="0" />';
			}
		}
	}
	// Default avatar MOD, By Manipe (End)

	//
	// Define the little post icon
	//
	if ( $userdata['session_logged_in'] && $postrow[$i]['post_time'] > $userdata['user_lastvisit'] && $postrow[$i]['post_time'] > $topic_last_read )
	{
		$mini_post_img = $images['icon_minipost_new'];
		$mini_post_alt = $lang['New_post'];
	}
	else
	{
		$mini_post_img = $images['icon_minipost'];
		$mini_post_alt = $lang['Post'];
	}

	$mini_post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['post_id']) . '#' . $postrow[$i]['post_id'];

	//
	// Generate ranks, set them to empty string initially.
	//
	$poster_rank = '';
	$rank_image = '';
	
	//-- mod : gender --------------------------------------------------------------
	//-- add
	$gender_image = '';
	//-- fin mod : gender ----------------------------------------------------------
	
	if ( $postrow[$i]['user_id'] == ANONYMOUS )
	{
	}
	else if ( $postrow[$i]['user_rank'] )
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
	else
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}

	//
	// Handle anon users posting with usernames
	//
	if ( $poster_id == ANONYMOUS && $postrow[$i]['post_username'] != '' )
	{
		$poster = $postrow[$i]['post_username'];
		$poster_rank = $lang['Guest'];
		// Start add - Birthday MOD
		$poster_age = '';
		// End add - Birthday MOD
	}

	$temp_url = '';

	if ( $poster_id != ANONYMOUS )
	{
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';
		
		//-- mod : gender --------------------------------------------------------------
		//-- add
		switch ($postrow[$i]['user_gender'])
		{
			case 1 :
				$gender_image = $lang['Gender'] . ': <img src="' . $images['icon_minigender_male'] . '" alt="' . $lang['Male'] . '" title="' . $lang['Male'] . '" border="0" />';
				break;
			case 2 :
				$gender_image = $lang['Gender'] . ': <img src="' . $images['icon_minigender_female'] . '" alt="' . $lang['Female'] . '" title="' . $lang['Female'] . '" border="0" />';
				break;
			default :
				$gender_image = '';
		}
		//-- fin mod : gender ----------------------------------------------------------

		if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '';
			$email = '';
		}

		$www_img = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($postrow[$i]['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
			$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

		$aim_img = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
		$aim = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
		
		$regdate = $postrow[$i]['user_regdate']; 
        	$user_posts = $postrow[$i]['user_posts']; 
        	$memberdays = max(1, round( ( time() - $regdate ) / 86400 )); 
        	$posts_per_day = $user_posts / $memberdays; 
        
        	// Get the users percentage of total posts 
        	if ( $postrow[$i]['user_posts'] != 0  ) 
        	{ 
           		$percentage = ( $overall_total_posts ) ? min(100, ($user_posts / $overall_total_posts) * 100) : 0; 
        	} 
        	else 
        	{ 
           		$percentage = 0; 
        	} 
        	$post_day_stats = sprintf($lang['User_post_day_stats'], $posts_per_day); 
        	$post_percent_stats = sprintf($lang['User_post_pct_stats'], $percentage);
		
				// Start add - Online/Offline/Hidden Mod
		if ($postrow[$i]['user_session_time'] >= (time()-$board_config['online_time']))
		{
			if ($postrow[$i]['user_allow_viewonline'])
			{
				$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_online'] . '" alt="' . sprintf($lang['is_online'], $poster) . '" title="' . sprintf($lang['is_online'], $poster) . '" /></a>&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <strong><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_online'], $poster) . '"' . $online_color . '>' . $lang['Online'] . '</a></strong>';
			}
			else if ( $is_auth['auth_mod'] || $userdata['user_id'] == $poster_id )
			{
				$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_hidden'] . '" alt="' . sprintf($lang['is_hidden'], $poster) . '" title="' . sprintf($lang['is_hidden'], $poster) . '" /></a>&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <strong><em><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_hidden'], $poster) . '"' . $hidden_color . '>' . $lang['Hidden'] . '</a></em></strong>';
			}
			else
			{
				$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $poster) . '" title="' . sprintf($lang['is_offline'], $poster) . '" />&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <span title="' . sprintf($lang['is_offline'], $poster) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
			}
		}
		else
		{
			$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $poster) . '" title="' . sprintf($lang['is_offline'], $poster) . '" />&nbsp;';
			$online_status = '<br />' . $lang['Online_status'] . ': <span title="' . sprintf($lang['is_offline'], $poster) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
		}
		// End add - Online/Offline/Hidden Mod
	}
	else
	{
		$profile_img = '';
		$profile = '';
		$pm_img = '';
		$pm = '';
		$email_img = '';
		$email = '';
		$www_img = '';
		$www = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$aim_img = '';
		$aim = '';
		$msn_img = '';
		$msn = '';
		$yim_img = '';
		$yim = '';
		$post_day_stats = ''; 
        	$post_percent_stats = '';
		// Start add - Online/Offline/Hidden Mod
		$online_status_img = '';
		$online_status = '';
		// End add - Online/Offline/Hidden Mod
	}

	$temp_url = append_sid("posting.$phpEx?mode=quote&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
	$quote_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_quote'] . '" alt="' . $lang['Reply_with_quote'] . '" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>';
	$quote = '<a href="' . $temp_url . '">' . $lang['Reply_with_quote'] . '</a>';
	
	//-- mod : quick post es -------------------------------------------------------
	//-- add
	$qp_quote_img = (!empty($qp_form) && empty($qp_lite)) ? '&nbsp;<img alt="' . $lang['Reply_with_quote'] . '" src="' . $images['qp_quote'] . '" title="' . $lang['Reply_with_quote'] . '" onmousedown="addquote(' . $postrow[$i]['post_id'] . ', \'' . str_replace('\'', '\\\'', (($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username'] != '') ? $postrow[$i]['post_username'] : $lang['Guest']) : $postrow[$i]['username'])) . '\')" style="cursor:pointer;" border="0" />' : '';
	//-- fin mod : quick post es ---------------------------------------------------

	$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts");
	$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" title="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" border="0" /></a>';
	$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '</a>';
	
		if ( $board_config['vault_display_topics'] )
	{
		$sql = " SELECT * FROM " . VAULT_USERS_TABLE . " 
			WHERE owner_id =  $poster_id "; 
		if( !($result = $db->sql_query($sql))) 
		{ 
			message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql); 
		} 
		$shares = $db->sql_fetchrow($result); 

		$share = '<br />'.$lang['Vault_on_account'].(( $shares['account_protect'] && $userdata['user_level'] != ADMIN ) ? $lang['Vault_confidential'] : intval($shares['account_sum']).'&nbsp;'.$board_config['points_name']);
		$share .= '<br />'.$lang['Vault_loan_account'].(( $shares['loan_protect'] && $userdata['user_level'] != ADMIN ) ? $lang['Vault_confidential'] : intval($shares['loan_sum']).'&nbsp;'.$board_config['points_name']);

	}

	if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )
	{
		$temp_url = append_sid("posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
		$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
		$edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
	}
	else
	{
		$edit_img = '';
		$edit = '';
	}

	if ( $is_auth['auth_mod'] )
	{
		$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
		$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

		$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
		$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
		$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
	}
	else
	{
		$ip_img = '';
		$ip = '';

		if ( $userdata['user_id'] == $poster_id && $is_auth['auth_delete'] && $forum_topic_data['topic_last_post_id'] == $postrow[$i]['post_id'] )
		{
			$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
			$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
			$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		}
		else
		{
			$delpost_img = '';
			$delpost = '';
		}
	}

	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';
	
	//-- mod : quick title edition -------------------------------------------------
	//-- add
	if ( !$i )
	{
		$qte->attr($post_subject, $postrow[$i]['topic_attribute']);
	}
	//-- fin mod : quick title edition ---------------------------------------------
	
	//-- mod : post description ----------------------------------------------------
	//-- add
	$post_sub_title = !empty($postrow[$i]['post_sub_title']) ? ( count($orig_word) ? preg_replace($orig_word, $replacement_word, $postrow[$i]['post_sub_title']) : $postrow[$i]['post_sub_title'] ) : '';
	//-- fin mod : post description ------------------------------------------------

	$message = $postrow[$i]['post_text'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];

	$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig'] ) ? $postrow[$i]['user_sig'] : '';
	$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];
	
	if ($poster_id != ANONYMOUS)
	{
		$user_points = ($userdata['user_level'] == ADMIN || user_is_authed($userdata['user_id'])) ? '<a href="' . append_sid("pointscp.$phpEx?" . POST_USERS_URL . "=" . $postrow[$i]['user_id']) . '" class="gensmall" title="' . sprintf($lang['Points_link_title'], $board_config['points_name']) . '">' . $board_config['points_name'] . '</a>' : $board_config['points_name'];
		$user_points = '<br />' . $user_points . ': ' . $postrow[$i]['user_points'];

		if ($board_config['points_donate'] && $userdata['user_id'] != ANONYMOUS && $userdata['user_id'] != $poster_id)
		{
			$donate_points = '<br />' . sprintf($lang['Points_donate'], '<a href="' . append_sid("pointscp.$phpEx?mode=donate&amp;" . POST_USERS_URL . "=" . $postrow[$i]['user_id']) . '" class="gensmall" title="' . sprintf($lang['Points_link_title_2'], $board_config['points_name']) . '">', '</a>');
		}
		else
		{
			$donate_points = '';
		}
	}
	else
	{
		$user_points = '';
		$donate_points = '';
	}

	//
	// Note! The order used for parsing the message _is_ important, moving things around could break any
	// output
	//

	//
	// If the board has HTML off but the post has HTML
	// on then we process it, else leave it alone
	//
	if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
	{
		if ( $user_sig != '' )
		{
			$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
		}

		if ( $postrow[$i]['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}
	}

	//
	// Parse message and/or sig for BBCode if reqd
	//
	if ($user_sig != '' && $user_sig_bbcode_uid != '')
	{
		$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
	}

	if ($bbcode_uid != '')
	{
		$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
	}

	if ( $user_sig != '' )
	{
		$user_sig = make_clickable($user_sig);
	}
	$message = make_clickable($message);

	//
	// Parse smilies
	//
	if ( $board_config['allow_smilies'] )
	{
		if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
		{
			$user_sig = smilies_pass($user_sig);
		}

		if ( $postrow[$i]['enable_smilies'] )
		{
			$message = smilies_pass($message);
			$post_subject = smilies_pass($post_subject);
		}
	}

	//
	// Highlight active words (primarily for search)
	//
	if ($highlight_match)
	{
		// This has been back-ported from 3.0 CVS
		$message = preg_replace('#(?!<.*)(?<!\w)(' . $highlight_match . ')(?!\w|[^<>]*>)#i', '<b style="color:#'.$theme['fontcolor3'].'">\1</b>', $message);
	}

	//
	// Replace naughty words
	//
	if (count($orig_word))
	{
		$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);

		if ($user_sig != '')
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
		}

		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
	}

	//
	// Replace newlines (we use this rather than nl2br because
	// till recently it wasn't XHTML compliant)
	//
	if ( $user_sig != '' )
	{
		$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
	}

	$message = str_replace("\n", "\n<br />\n", $message);

	//
	// Editing information
	//
	if ( $postrow[$i]['post_edit_count'] )
	{
		$l_edit_time_total = ( $postrow[$i]['post_edit_count'] == 1 ) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];

		$l_edited_by = '<br /><br />' . sprintf($l_edit_time_total, $poster, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
	}
	else
	{
		$l_edited_by = '';
	}
	
	// Medal MOD
	$medal ='';
	$sql = "SELECT m.medal_id, m.medal_name
		FROM " . MEDAL_TABLE . " m, " . MEDAL_USER_TABLE . " mu
		WHERE mu.user_id = '" . $postrow[$i]['user_id'] . "'
		AND m.medal_id = mu.medal_id
		ORDER BY m.medal_name";
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Error getting medal information", "", __LINE__, __FILE__, $sql);
	}

	$medal_list = $db->sql_fetchrowset($result);
	$medal_count = count($medal_list);

	if ( $postrow[$i]['user_id'] == ANONYMOUS )
	{
		$medal_count = '';
	} 
	else
	{
		$medal_count = ($medal_count) ? $lang['Medals'] . ': <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $postrow[$i]['user_id'] . "#medal") . '" class="gensmall">' . $medal_count . '</a>' . ' (<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $postrow[$i]['user_id'] . "#medal") . '" class="gensmall">' . $lang['View_More'] . '</a>)' : $lang['Medals'] . ': ' . $lang['None'];
	}
	

	//
	// Again this will be handled by the templating
	// code at some point
	//
	

	include_once($phpbb_root_path .'language/lang_'. $board_config['default_lang'] .'/lang_mood_mod.'. $phpEx);
	$user_mood_1 	= explode('.', $postrow[$i]['user_mood_mod']);
	$user_mood_2 	= explode('/', $user_mood_1[1]);
	$mood_count		= count($user_mood_2);
	$user_mood 		= str_replace('_', ' ', $user_mood_2[($mood_count - 1)]);
	$user_mood 		= ucwords(strtolower($user_mood));
	
	$current_user_mood = $user_mood;
	
	$user_mood_1 	= explode('.', $postrow[$i]['poster_mood']);
	$user_mood_2 	= explode('/', $user_mood_1[1]);
	$mood_count		= count($user_mood_2);
	$user_mood 		= str_replace('_', ' ', $user_mood_2[($mood_count - 1)]);
	$user_mood 		= ucwords(strtolower($user_mood));
	
	$postrow_mood = $user_mood;
	
	$mood_display = '';
	$mood_display .= ($postrow[$i]['user_mood_mod']) ? '<br><hr>' : '';
	$mood_display .= ($postrow[$i]['user_mood_mod']) ? $lang['MM_current_mood'] .'<br /><img src="'. $postrow[$i]['user_mood_mod'] .'" border="0" alt="'. $current_user_mood .'" title="'. $current_user_mood .'">' : '';
	//$mood_display .= ($postrow[$i]['poster_mood']) ? '&nbsp;&nbsp;&nbsp;'. $lang['MM_post_mood'] .'&nbsp;&nbsp;<img src="'. $postrow[$i]['poster_mood'] .'" border="0" alt="'. $postrow_mood .'" title="'. $postrow_mood .'">' : '';
	$mood_display .= ( ($postrow[$i]['user_mood_mod']) && ($postrow[$i]['user_id'] == $userdata['user_id']) ) ? '<br /><a href="javascript:void(0)" onclick="window.open(\'mood_mod.'. $phpEx .'?sid='. $userdata['session_id'] .'\', \'popup\', \'width=400, height=400,resizable=yes,scrollbars=yes,\');return false;">'. $lang['MM_profile_link'] .'</a>' : '';
	$mood_display .= ($postrow[$i]['user_mood_mod']) ? '<br>' : '';


	
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	$template->assign_block_vars('postrow', array(
		'ROW_COLOR' => '#' . $row_color,
		'ROW_CLASS' => $row_class,
		//-- mod : rank color system ---------------------------------------------------
		//-- delete
		/*-MOD
		'POSTER_NAME' => $poster,
		MOD-*/
		'POST_DAY_STATS' => $post_day_stats, 
		'POST_PERCENT_STATS' => $post_percent_stats,
		'POSTER_NAME' => ($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username'] != '') ? $postrow[$i]['post_username'] : $lang['Guest']) : $rcs->get_colors($postrow[$i], $postrow[$i]['username']),
		//-- fin mod : rank color system -----------------------------------------------
		//-- mod : gender --------------------------------------------------------------
		//-- add
		'POSTER_GENDER' => $gender_image,
		'POSTER_AGE' => $poster_age,
		'L_GENDER' => $lang['Gender'],
		//-- fin mod : gender ----------------------------------------------------------
		'POSTER_RANK' => $poster_rank,
		'RANK_IMAGE' => $rank_image,
		'POSTER_JOINED' => $poster_joined,
		'POSTER_POSTS' => $poster_posts,
		'POSTER_FROM' => $poster_from,
		'POSTER_AVATAR' => $poster_avatar,
		'POSTER_MEDAL_COUNT' => $medal_count,	// Medal MOD
		// Start add - Online/Offline/Hidden Mod
		'POSTER_ONLINE_STATUS_IMG' => $online_status_img,
		'POSTER_ONLINE_STATUS' => $online_status,
		// End add - Online/Offline/Hidden Mod
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'MESSAGE' => $message,
		'SIGNATURE' => $user_sig,
		'EDITED_MESSAGE' => $l_edited_by,
		'POST_MOOD'=> $mood_display,
		'WARN_RED_CARD' => $warn_red_card,
		'WARN_YELLOW_CARD' => $warn_yellow_card,
		'WARN_GREEN_CARD' => $warn_green_card,   
                'WARN_CARDS' => $cards, 
		//-- mod : topics enhanced -----------------------------------------------------
		//-- add
		//-- topics nav buttons		
		'S_NUM_ROW' => $num_row,
		'S_NAV_BUTTONS' => $nav_buttons,
		//-- minitime
		'I_MINITIME' => $images['icon_minitime'],
		//-- fin mod : topics enhanced -------------------------------------------------

		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img,
		'PROFILE' => $profile,
		'SEARCH_IMG' => $search_img,
		'SEARCH' => $search,
		'POSTER_VAULT' => $share,
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
		'EDIT_IMG' => $edit_img,
		'EDIT' => $edit,
		'QUOTE_IMG' => $quote_img,
		'QUOTE' => $quote,
		'IP_IMG' => $ip_img,
		'IP' => $ip,
		'DELETE_IMG' => $delpost_img,
		'DELETE' => $delpost,
		'CELLEDS' => $celleds,
		//-- mod : quick post es -------------------------------------------------------
		//-- add
		'I_QP_QUOTE' => $qp_quote_img,
		//-- fin mod : quick post es ---------------------------------------------------
		'POINTS' => $user_points,
		'DONATE_POINTS' => $donate_points,
		'L_MINI_POST_ALT' => $mini_post_alt,

		'U_MINI_POST' => $mini_post_url,
		'U_POST_ID' => $postrow[$i]['post_id'])
	);
	
	//Medal MOD
	if ( $board_config['allow_medal_display'] )
	{
		$order = ( $board_config['medal_display_order'] ) ? "RAND()" : "m.medal_name";

		$template->assign_block_vars('postrow.medal', array());

		$sql = "SELECT m.medal_id, m.medal_name, m.medal_image
			FROM " . MEDAL_TABLE . " m, " . MEDAL_USER_TABLE . " mu
			WHERE mu.user_id = '" . $poster_id . "'
			AND m.medal_id = mu.medal_id
			ORDER BY " . $order;
	
		if ($result = $db->sql_query($sql))
		{
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$rowset[$row['medal_image']]['medal_name'] = $row['medal_name'];
				if ($rowset[$row['medal_image']]['medal_name'] == $row['medal_name'])
				$rowset[$row['medal_image']]['medal_count'] += 1;
			}

			// Check Medal config in ACP
			$medal_rows = $board_config['medal_display_row'];
			$medal_cols = $board_config['medal_display_col'];
			$medal_width = ( $board_config['medal_display_width'] ) ? 'width="'.$board_config['medal_display_width'].'"' : '';
			$medal_height = ( $board_config['medal_display_height'] ) ? 'height="'.$board_config['medal_display_height'].'"' : '';
	
			if ($medal_list)
			{
				$split_row = $medal_cols - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while (list($medal_image, $medal) = @each($rowset))
				{
					if (!$col)
			       		{ 
						$template->assign_block_vars('postrow.medal.medal_row', array()); 
					}

					$template->assign_block_vars('postrow.medal.medal_row.medal_col', array(
						'MEDAL_IMAGE' => $phpbb_root_path . $medal_image,
						'MEDAL_WIDTH' => $medal_width,
						'MEDAL_HEIGHT' => $medal_height,
						'MEDAL_NAME' => $medal['medal_name'],
						'MEDAL_COUNT' => '('. $lang['Medal_amount'] . $medal['medal_count']. ')')
					);

					$s_colspan = max($s_colspan, $col + 1);

					if ($col == $split_row)
					{
						if ($row == $medal_rows - 1) 
						{ 
							break; 
						}
						$col = 0;
						$row++;
					}
					else 
					{ 
						$col++; 
					}
				}
			}
		}
		$db->sql_freeresult($result);
	}
	
	//-- mod : post description ----------------------------------------------------
	//-- add
	display_sub_title('postrow', $post_sub_title, $board_config['sub_title_length']);
	//-- fin mod : post description ------------------------------------------------
	
	//-- mod : topics enhanced -----------------------------------------------------
	//-- add
	//-- split posts
	if ( $i != $total_posts - 1 )
	{
		$template->assign_block_vars('postrow.spacing', array());
	}
	//-- fin mod : topics enhanced -------------------------------------------------
	
	display_post_attachments($postrow[$i]['post_id'], $postrow[$i]['post_attachment']);
	//-- mod : flags ---------------------------------------------------------------
	//-- add
	display_flag($poster_flag, false, 'postrow');
	//-- fin mod : flags -----------------------------------------------------------
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
<?php

/***************************************************************************
 *                                mod_recent_topics.php
 *                            -------------------
 * 	Module Original :
 * 		Title: Recent Topics Block for Smartor's ezPortal
 * 		Author: Smartor <smartor_xp@hotmail.com> - http://smartor.is-root.com
 *
 *   Adapté pour Gf-Portail :
 * 		Par : Giefca <giefca@hotmail.com> - http://www.gf-phpbb.fr.st
 *   	le  : Mardi,5 Août, 2003
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Minimodule à intégrer dans un Gf-Portail
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_recent_topics.tpl')
);

$sql = "SELECT * FROM ". FORUMS_TABLE . " ORDER BY forum_id";
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
}
$forum_data = array();
while( $row = $db->sql_fetchrow($result) )
{
	$forum_data[] = $row;
}

$is_auth_ary = array();
$is_auth_ary = auth(AUTH_ALL, AUTH_LIST_ALL, $userdata, $forum_data);
$except_forum_id = "" ;

for ($i = 0; $i < count($forum_data); $i++)
{
	if ((!$is_auth_ary[$forum_data[$i]['forum_id']]['auth_read']) or (!$is_auth_ary[$forum_data[$i]['forum_id']]['auth_view']))
	{
			$except_forum_id .= ( $except_forum_id == "" ) ? $forum_data[$i]['forum_id'] : ',' . $forum_data[$i]['forum_id'] ;
	}
}
if ( $except_forum_id != "" ) 
{
	$sql_except = " AND t.forum_id NOT IN ( $except_forum_id ) " ;
}
else
{
	$sql_except = "" ;
}

$sql = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.forum_id, p.post_id, p.poster_id, p.post_time, u.user_id, u.username
		FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p, " . USERS_TABLE . " AS u
		WHERE t.topic_status <> 2
			$sql_except 
			AND p.post_id = t.topic_last_post_id
			AND p.poster_id = u.user_id
		ORDER BY p.post_id DESC
		LIMIT 0," . $portal_config['number_recent_topics'];

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query recent topics information', '', __LINE__, __FILE__, $sql);
}

$number_recent_topics = $db->sql_numrows($result);
if ( $number_recent_topics == 0 ) return ;
$recent_topic_row = array();

while ($row = $db->sql_fetchrow($result))
{
	$recent_topic_row[] = $row;
}

$template_mod->assign_vars(	array(
	'SCROLL_WAY' => ( $portal_config['scroll_up'] ) ? 'up' : 'down',
	'SCROLL_HEIGHT' => $portal_config['scroll_height'],
	'SCROLL_DELAY' => $portal_config['scroll_delay'],
	'SCROLL_STEP' => $portal_config['scroll_step'],
	'BY' => $lang['topic_by'],
	'ON' => $lang['topic_on'],	
	'L_RECENT_TOPICS' => $lang['Recent_topics'])
	);

if ( $portal_config['scrolling_topics'] )
{
	$template_mod->assign_block_vars('scrolling_row',array());
	for ($i = 0; $i < $number_recent_topics; $i++)
	{
	$template_mod->assign_block_vars('scrolling_row.recent_topic_row', array(
		'U_TITLE' => append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $recent_topic_row[$i]['post_id']) . '#' .$recent_topic_row[$i]['post_id'],
		'L_TITLE' => $recent_topic_row[$i]['topic_title'],
		'U_POSTER' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $recent_topic_row[$i]['user_id']),
		'S_POSTER' => $recent_topic_row[$i]['username'],
		'S_POSTTIME' => create_date($board_config['default_dateformat'], $recent_topic_row[$i]['post_time'], $board_config['board_timezone'])
		)
	);	
	}
}
else
{
	$template_mod->assign_block_vars('classical_row',array());
	for ($i = 0; $i < $number_recent_topics; $i++)
	{
	$template_mod->assign_block_vars('classical_row.recent_topic_row', array(
		'U_TITLE' => append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $recent_topic_row[$i]['post_id']) . '#' .$recent_topic_row[$i]['post_id'],
		'L_TITLE' => $recent_topic_row[$i]['topic_title'],
		'U_POSTER' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $recent_topic_row[$i]['user_id']),
		'S_POSTER' => $recent_topic_row[$i]['username'],
		'S_POSTTIME' => create_date($board_config['default_dateformat'], $recent_topic_row[$i]['post_time'], $board_config['board_timezone'])
		)
	);
	}

}

$modvar = $template_mod->pparse_mod('body');

?>
<?php

/***************************************************************************
 *                                mod_statistiques.php
 *                            -------------------
 *   fait le                : Dimanche,20 Juillet, 2003
 *   Par : giefca - giefca@hotmail.com - http://www.gf-phpbb.fr.st
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
   'body' => 'mod_statistiques.tpl')
);

//$total_posts = get_db_stat('postcount');
//$total_topics = get_db_stat('topiccount');

$total_posts = get_db_stat('postcount');
$total_topics = get_db_stat('topiccount'); 

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


$template_mod->assign_vars( array(
	'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
	'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
	'TOTAL_TOPICS' => sprintf($lang['total_topics'], $total_topics),
	'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'),
	'L_STATISTICS' => $lang['Statistics']));
	
$modvar = $template_mod->pparse_mod('body');

?>
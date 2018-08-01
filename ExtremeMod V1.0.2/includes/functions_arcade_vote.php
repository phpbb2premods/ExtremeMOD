<?php
/***************************************************************************
*                               functions_arcade_vote.php
*                              ---------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
//
// Cette fonction insère la note du jeu dans la table des votes et vérifie si l'utilisateur peut revoter
//
function rate_game($user_id, $game_id, $rating)
{
	global $db, $lang, $phpEx;

	$sql = 'INSERT INTO ' . ARCADE_VOTE_TABLE . "
		   (user_id, game_id, rating, rating_time)
		   VALUES ($user_id, $game_id, $rating, " . time() . ")";		
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des votes", '', __LINE__, __FILE__, $sql);
	}
	message_die(GENERAL_MESSAGE, $lang['Game_Rated'] . "<br /><br />" . sprintf($lang['Click_return_Game'], "<a href=\"" . append_sid("games.$phpEx?gid=" . $game_id . "") . "\">", "</a>"));
	return;
}
//
// Cette fonction vérifie si l\'utilisateur a déjà noté ce jeu et retourne faux si ce n\'est pas le cas
//
function rating_inserted($user_id, $game_id)
{
	global $db;
	
	$sql = 'SELECT rating FROM ' . ARCADE_VOTE_TABLE . "
	   WHERE user_id = $user_id
	       AND game_id = $game_id
	       LIMIT 1";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des votes", '', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);
	return (isset($row['rating'])) ? TRUE : FALSE;
}
//
// Cette fonction retourne la note donnée par l\'utilisateur pour le jeu
//
function rating_value($user_id, $game_id)
{
	global $db;
	$sql = 'SELECT rating FROM ' . ARCADE_VOTE_TABLE . "
	   WHERE user_id = $user_id	
	   AND game_id = $game_id
	   LIMIT 1";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des votes", '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	return $row['rating'];
}
//
// Cette fonction retourne les statistiques du jeu
//
function rate_stats($game_id)
{
	global $db;
	
	$sql = "SELECT AVG(rating) AS average,
	   MIN(rating) AS minimum,
	   MAX(rating) AS maximum,
	   COUNT(rating) AS number_of_rates
	   FROM " . ARCADE_VOTE_TABLE . "
	   WHERE game_id = $game_id";
	
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des votes", '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	return $row;
}
//
// Cette fonction retourne la note moyenne attribuée au jeu
//
function ratings_view_game($game_id)
{
	global $db;
	
	$sql = 'SELECT AVG(rating) AS average
	   		   FROM ' . ARCADE_VOTE_TABLE . "
	   	   	   WHERE game_id = $game_id";
	
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des votes", '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	
	return $row['average'];
}
?>
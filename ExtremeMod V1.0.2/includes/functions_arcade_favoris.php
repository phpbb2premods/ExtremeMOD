<?php

/***************************************************************************
 *                                functions_arcade_favoris.php
 *                                ----------------------------
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//
// Cette fonction vérifie si l\'utilisateur a déjà ce jeu et retourne faux si ce n\'est pas le cas
//
function favoris_inserted($user_id, $gid)
{
	global $db;
	
	$sql = 'SELECT user_id, game_id FROM ' . ARCADE_FAV_TABLE . "
	   WHERE user_id = $user_id
	   AND game_id = $gid
	       LIMIT 1";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des favoris", '', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);
	return (isset($row['game_id'])) ? TRUE : FALSE;
}

?>
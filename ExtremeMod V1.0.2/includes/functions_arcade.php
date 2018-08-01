<?php
/***************************************************************************
*                               functions_arcade.php
*                              ----------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// Cette fonction retourne le tableau des paramètres de configuration du 
// mod Arcade.
//
function read_arcade_config()
{
	global $db;
	$arcade_config = array();
	$sql = "SELECT * FROM " . ARCADE_TABLE;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query arcade config information", "", __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$arcade_config[$row['arcade_name']] = $row['arcade_value'];
	}
	return $arcade_config;
}

//Cette fonction retourne la liste des catégories visibles ou accessibles par un utilisateur
function get_arcade_categories($user_id, $user_level, $mode)
{
  global $db;
  $liste_cat = '';
  $nbcat = 0;
  switch ($mode)
  {
   case 'view':
	$liste_auth = "0,1,3,5";
  	$liste_auth .= ( $user_level == ADMIN ) ? ',2,4,6' : ( ( $user_level == MOD ) ? ',4' : '');
	break;
	
   case 'play':
	$liste_auth = "0";
  	$liste_auth .= ( $user_level == ADMIN ) ? ',1,2,3,4,5,6' : ( ( $user_level == MOD ) ? ',3,4' : '');
    break;
  }
  
  $sql = "SELECT arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catauth IN ($liste_auth)";
  if ( !($result = $db->sql_query($sql)) )
  {
	 message_die(GENERAL_ERROR, 'Could not select info from arcade_categories table', '', __LINE__, __FILE__, $sql);
  }

  while( $row = $db->sql_fetchrow($result) )
  {
    $liste_cat .= ( $liste_cat == '' ) ? $row['arcade_catid'] : ',' . $row['arcade_catid'];
  }

  
  $sql = "SELECT aa.arcade_catid FROM " . AUTH_ARCADE_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE. " g WHERE ug.user_id = $user_id AND g.group_id = ug.group_id AND aa.group_id = ug.group_id AND ug.user_pending=0";
  if ( !($result = $db->sql_query($sql)) )
  {
	message_die(GENERAL_ERROR, 'Could not select info from user/user_group table', '', __LINE__, __FILE__, $sql);
  }

  while( $row = $db->sql_fetchrow($result) )
  {
    $liste_cat .= ( $liste_cat == '' ) ? $row['arcade_catid'] : ',' . $row['arcade_catid'];
  }
  
  return $liste_cat ;
}

// Récupèration des couleurs de rang
function user_color($username, $user_level)
{
	global $db, $userdata, $theme, $arcade_config;

$style_color = '';
if ($arcade_config['color_use'])
{
switch ($user_level)
 {
	case ADMIN: $style_color = 'style="color:#' . $arcade_config['color_admin'] . '"';
		break;
	case MOD: $style_color = 'style="color:#' . $arcade_config['color_mod'] . '"';
		break;
	case USER: $style_color = 'style="color:#' . $arcade_config['color_user'] . '"';
		break;
 }
} else {
switch ($user_level)
 {
	case ADMIN: $style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
		break;
	case MOD: $style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
		break;
	case USER: $style_color = $username;
		break;
	}
}
	return $style_color;
}

?>
<?php
/***************************************************************************
*                               whoisplaying.php
*                              ------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if(!function_exists('get_arcade_categories'))
{
	include( $phpbb_root_path . 'includes/functions_arcade.' . $phpEx);
}

//chargement du template
$template->set_filenames(array(
  'whoisplaying' => 'whoisplaying_body.tpl')
  );

$template->assign_vars(array(
	"L_WHOISPLAYING" => $lang['whoisplaying'])
  );
	
if (!isset($liste_cat_auth))
{
	//récupération de la liste des catégories privées auxquelles l'utilisateur à acces
	$liste_cat_auth = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'view');
	if( $liste_cat_auth == '' ) $liste_cat_auth = "''";
}

$sql = "SELECT u.username, u.user_id, u.user_level, u.user_allow_viewonline, g.game_name, g.game_id FROM " . GAMEHASH_TABLE . " gh LEFT JOIN " . SESSIONS_TABLE
		. " s ON gh.user_id = s.session_user_id LEFT JOIN " . USERS_TABLE . " u ON gh.user_id = u.user_id LEFT JOIN "
		. GAMES_TABLE . " g ON gh.game_id = g.game_id 
		 WHERE gh.hash_date >= s.session_time AND (" . time() . "- gh.hash_date <= 300) AND g.arcade_catid IN ($liste_cat_auth) ORDER BY gh.hash_date DESC";

//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------

if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
  $players[] = $row;
}	
	
$last_game = '';
$list_player = '';
$prev_user_id = '';
$class = '';

$nbplayers = count($players);
$listeid = array();
$games_players = array();
$games_names = array();

for($i=0 ; $i< $nbplayers ; $i++)
{
  if( !isset($listeid[ $players[$i]['user_id'] ]) )
  {
  $listeid[ $players[$i]['user_id'] ] = true ;

  //$style_color = user_color($players[$i]['username'], $players[$i]['user_level']);
  $style_color = $rcs->get_colors($players[$i]);
  
  
  if ( $players[$i]['user_id'] == ANONYMOUS ){
  $player_link = $players[$i]['username'];
  } else {
  $player_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $players[$i]['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '" title="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '"' . $style_color .'>' . $players[$i]['username'] . '</a>';
  }

	if ( $players[$i]['user_allow_viewonline'] )
	{
  if ( $players[$i]['user_id'] == ANONYMOUS ){
  $player_link = $players[$i]['username'];
  } else {
  $player_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $players[$i]['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '" title="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '"' . $style_color .'>' . $players[$i]['username'] . '</a>';
  }
	}	else {
  if ( $players[$i]['user_id'] == ANONYMOUS ){
  $player_link = $players[$i]['username'];
  } else {
  $player_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $players[$i]['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '" title="' . $lang['Read_profile'] .' '. $players[$i]['username'] . '"' . $style_color .'><i>' . $players[$i]['username'] . '</i></a>';
	}
}
	if ( $players[$i]['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
	{	    
		if(!isset($games_names[ $players[$i]['game_id'] ]) )
		{
	  		$games_names[ $players[$i]['game_id'] ] = $players[$i]['game_name'] ;
		    $games_players[ $players[$i]['game_id'] ] = $player_link ;
	    } else {
	  		$games_players[ $players[$i]['game_id'] ] .=  ', ' . $player_link ;
		  }
	  }
  }
}

foreach( $games_names AS $key => $val )
{
	if ( $games_players[$key]!='' )
	{
 	 $class = ( $class == 'row1' ) ? 'row2' : 'row1';
	 $template->assign_block_vars('whoisplaying_row', array(
		  'CLASS' => $class,
		  'GAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $key) . '">' . $val . '</a>',
		  'PLAYER_LIST' => $games_players[$key])
	    );
   }
}

$template->assign_var_from_handle('WHOISPLAYING', 'whoisplaying');		

?>
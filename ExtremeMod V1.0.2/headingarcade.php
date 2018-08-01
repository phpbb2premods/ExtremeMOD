<?php
/***************************************************************************
*                               headingarcade.php
*                              -------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//chargement du template
$template->set_filenames(array(
  'headingarcade' => 'headingarcade_body.tpl')
  );

$class = ($class == 'row1') ? 'row2' : 'row1'; 
$template->assign_block_vars('arcaderow3',array(  
	'CLASS' => $class,  
  'U_TOPARCADE' => append_sid("toparcade.$phpEx"), 
  'BEST_SCORES' => $lang['best_scores']) 
  );

$style_color = user_color($userdata['username'], $userdata['user_level']);
if ( $userdata['user_id'] == ANONYMOUS ){
  $username = '<font color="#000000">' . $userdata['username'] . '</font>';
} else {
  $username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $userdata['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $userdata['username'] . '" title="' . $lang['Read_profile'] .' '. $userdata['username'] . '"' . $style_color .'>' . $userdata['username'] . '</a>';
}

$template->assign_vars(array(
	'ARCADE_VICTOIRES' => $nbvictoires,
	'AVATAR_IMG' => $avatar_img,
	'USERNAME' => $username,
	'POSTER_RANK' => $poster_rank,
	'RANK_IMAGE' => $rank_image,
	'L_POSTER_RANK' => $lang['Poster_rank'],
	'TOP_PLAYER' => $lang['Topgamers'],
	'PLAYER' => $lang['Player'],
	'VICTOIRES' => $lang['Victoires'],
	'L_AVATAR' => $lang['Avatar'], 
	'MAXSIZE_AVATAR' => intval($arcade_config['maxsize_avatar'])  ) 
	); 
//Fin de chargement du template

// Début de la récuperation des top10 joueur de l'arcade
$sql = "SELECT COUNT(*) AS nbvictoires, g.game_highuser, u.user_id, u.username, u.user_level FROM " . GAMES_TABLE . " g LEFT JOIN
	 " . USERS_TABLE . " u on g.game_highuser = u.user_id WHERE g.game_highuser<>0 GROUP BY g.game_highuser ORDER BY nbvictoires DESC LIMIT 0,10  ";
	 
	 
	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
	//-- fin mod : rank color system ----------------------------------------------- 
	
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
	}

  $arcade_victories = '';
	$place=0;
	$nbvictprec=15;
	while ( $row = $db->sql_fetchrow($result) )
	{
	 if ($nbvictprec<>$row['nbvictoires'])
		{
		 $place++;
		 $nbvictprec=$row['nbvictoires'];
		}
     $style_color = $rcs->get_colors($row);
     
    //$style_color = user_color($row['username'], $row['user_level']);
		$temp_url = append_sid("arcade_victories.$phpEx?" . POST_USERS_URL . "=" .$row['user_id'] ." ");
		$img = '<img src="./images/arcades/couronne.gif" border="0" alt="Voir les coupes de ce joueur" title="Voir les coupes de ce joueur" >';
		$arcade_victories = '<a href="#" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=500,height=300,scrollbars=yes,resizable=yes\');return(false)">' . $img . '</a>';

    if ( $row['user_id'] == ANONYMOUS ){
    $user_online_link = $row['username'];
    } else {
  	$user_online_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
    }

		$template->assign_block_vars('player_row', array(
			'CLASSEMENT' => $place,
			'VICTORIES' => $arcade_victories,
			'USERNAME' => $user_online_link,
			'VICTOIRES' => $row['nbvictoires'])
		);
	}
// Fin de la récuperation des top10 joueur de l'arcade

// Début de la recupération du dernier record aux jeux 
   $sqlArcade = " SELECT g.* , u.user_id, u.username, u.user_level FROM " . GAMES_TABLE . " g left join " . USERS_TABLE . " u on g.game_highuser = u.user_id ORDER BY game_highdate DESC LIMIT 0,6  "; 
   
   //-- mod : rank color system ---------------------------------------------------
//-- add
	$sqlArcade = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sqlArcade);
//-- fin mod : rank color system -----------------------------------------------
   
   if ( !($resultArcade = $db->sql_query($sqlArcade)) ) 
   { 
      message_die(GENERAL_ERROR, 'Impossible d\'acceder aux tables games/users', '', __LINE__, __FILE__, $sqlArcade); 
   } 
$template->assign_block_vars('arcaderow2',array());
   while($rowArcade = $db->sql_fetchrow($resultArcade)) 
   {
 
   $style_color = $rcs->get_colors($rowArcade);
  //$style_color = user_color($rowArcade['username'], $rowArcade['user_level']);
  if ( $rowArcade['user_id'] == ANONYMOUS ){
  $last_user_record = $rowArcade['username'];
  } else {
  $last_user_record = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $rowArcade['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $rowArcade['username'] . '" title="' . $lang['Read_profile'] .' '. $rowArcade['username'] . '"' . $style_color .'>' . $rowArcade['username'] . '</a>';
  }

	$class = ($class == 'row1') ? 'row2' : 'row1' ; 
	$template->assign_block_vars('arcaderow2.bestscore2',array( 
	   'CLASS' => $class,
     'LAST_SCOREGAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $rowArcade['game_id']) . '">' . $rowArcade['game_name'] . '</a>', 
     'LAST_SCOREDATE' => create_date($board_config['default_dateformat'], $rowArcade['game_highdate'] , $board_config['board_timezone']), 
     'LAST_SCOREUSER' => $last_user_record, 
     'LAST_SCORE' => $rowArcade['game_highscore']) 
     ); 
    } 
// Fin de la récuperation du dernier record aux jeux 

// Début de la recupération du dernier score éfféctué
$sqlScore = " SELECT u.user_id, u.username, u.user_level, s.game_id, s.score_game, s.score_date, g.game_name FROM " . SCORES_TABLE . " s LEFT JOIN " . USERS_TABLE . " u on s.user_id = u.user_id LEFT JOIN " . GAMES_TABLE . " g ON s.game_id = g.game_id ORDER BY score_date DESC LIMIT 0,1 ";

//-- mod : rank color system ---------------------------------------------------
//-- add
	$sqlScore = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sqlScore);
//-- fin mod : rank color system -----------------------------------------------

   if ( !($resultScore = $db->sql_query($sqlScore)) )
   {
      message_die(GENERAL_ERROR, 'Impossible d\'acceder aux tables scores/users', '', __LINE__, __FILE__, $sqlScore);
   }
   if($rowScore = $db->sql_fetchrow($resultScore))
   {

  //$style_color = user_color($rowScore['username'], $rowScore['user_level']);
  $style_color = $rcs->get_colors($rowScore);  
  
  
  if ( $rowScore['user_id'] == ANONYMOUS ){
  $last_user_score = $rowScore['username'];
  } else {
  $last_user_score = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $rowScore['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $rowScore['username'] . '" title="' . $lang['Read_profile'] .' '. $rowScore['username'] . '"' . $style_color .'>' . $rowScore['username'] . '</a>';
  }

  $template->assign_block_vars('arcaderow3.score3',array(
    'LAST_SCOREGAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $rowScore['game_id']) . '">' . $rowScore['game_name'] . '</a>',
    'LAST_SCOREDATE' => create_date($board_config['default_dateformat'], $rowScore['score_date'], $board_config['board_timezone']),
    'LAST_SCOREUSER' => $last_user_score,
    'LAST_SCORE' => $rowScore['score_game'])
    );
   }
// Fin de la récuperation du dernier score éfféctué

// Début des recupérations des données du rang
$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

$poster_rank = '';
$rank_image = '';
if ( $userdata['user_rank'] )
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $userdata['user_rank'] == $ranksrow[$i]['rank_id'] && $ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
} else {
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $userdata['user_posts'] >= $ranksrow[$i]['rank_min'] && !$ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}
// Fin des recupérations des données du rang

// Début de la recupération du nombre de victoire du membre
$sql = "SELECT COUNT(*) AS nbvictoires FROM " . GAMES_TABLE . " WHERE game_highuser = " . $userdata['user_id'];
if( !$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not obtain games information', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$nbvictoires = $row['nbvictoires'];
// Fin de la recupération du nombre de victoire du membre

// Début des données pour l'avatar
$avatar_img = '';
if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
{
	switch( $userdata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" onload="resize_avatar(this)"/>' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" onload="resize_avatar(this)"/>' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" onload="resize_avatar(this)"/>' : '';
			break;
	}
}
IF ( empty($avatar_img) ) 
{ 
   $avatar_img = '<img src="images/arcades/noavatar.gif" alt="Aucun Avatar" border="0" />'; 
}
// Fin des données pour l'avatar

// Chargement du template No 2

$template->assign_block_vars('arcaderow2',array(  
   'U_TOPARCADE' => append_sid("toparcade.$phpEx"), 
   'BEST_SCORES' => $lang['best_scores']) 
   ); 

$template->assign_block_vars('arcaderow3',array(  
   'U_TOPARCADE' => append_sid("toparcade.$phpEx"), 
   'BEST_SCORES' => $lang['best_scores']) 
   ); 

$template->assign_vars(array( 
	 "AVATAR_IMG" => $avatar_img, 
   "COURONNE" =>'<img src="images/arcades/couronne.gif" border="0" />', 
	 "POSTER_RANK" => $poster_rank,
	 "ARCADE_VICTOIRES" => $nbvictoires) 
	 ); 

$template->assign_var_from_handle('HEADINGARCADE', 'headingarcade');		

?>
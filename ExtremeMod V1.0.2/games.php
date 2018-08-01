<?php
/***************************************************************************
*                               games.php
*                              -----------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);
define('ARCADE', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);
include($phpbb_root_path . 'includes/functions_jumpbox_arcade.'.$phpEx);
include($phpbb_root_path . 'includes/arca_bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);
//
// End session management
//

$arcade_config = array();
$arcade_config = read_arcade_config();
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Start auth check
//
if (( !$userdata['session_logged_in']) AND (!$arcade_config['auths_play']))
{
	$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
	header($header_location . append_sid("login.$phpEx?redirect=games.$phpEx", true));
	exit;
 }

//
// vérification du nombre de parties du joueur
//
$sql = "SELECT arcade_value FROM " . ARCADE_TABLE . " WHERE arcade_name = 'quota_games'";
if( !($result = $db->sql_query($sql)) )
{
 message_die(GENERAL_ERROR, "Couldn't read arcade table", '', __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
 $quota = $row['arcade_value'];
}

$sql = "SELECT user_nb_game, user_date_game FROM " . USERS_TABLE . " WHERE user_id = " . $userdata['user_id'];
if( !($result = $db->sql_query($sql)) )
{
 message_die(GENERAL_ERROR, "Impossible de déterminer le nombre de parties jouées", '', __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
 $nb = $row['user_nb_game'];
 $lastuserdate = $row['user_date_game'];
}

// lecture de la date système
$date = getdate();
$formatdate = $date[year] . $date[mon] . $date[mday];

// Si le quota est renseigné, on vérifie qu'il n'est pas dépassé
if ($quota != '')
{
 if ( $quota <= 0 || ($lastuserdate == $formatdate && $nb >= $quota))
 {
  message_die(GENERAL_MESSAGE, 'vous venez d\'atteindre le nombre de ' . $nb . ' parties autorisés pour aujourd\'hui.', $lang['quota_depasse']);
 }
}

//
// End of auth check
//
$present = $arcade_config['present_fid'];
if ($arcade_config['game_pres'])
{
$sql = 'SELECT COUNT(topic_id) as number_topics FROM ' . TOPICS_TABLE . ' WHERE topic_poster=' . $userdata['user_id'] . ' AND forum_id=' . $present . '';

if (!$result=$db->sql_query($sql))
{
message_die(GENERAL_ERROR, 'Error while retrieving information');
}
$row = $db->sql_fetchrow($result);
 if (!$row['number_topics'])
 {
 if ($arcade_config['message_pres'])
  {
    message_die(GENERAL_ERROR, 'Vous devez faire votre présentation avant de pouvoir acceder aux jeux<br />Cliquer <a href="posting.php?mode=newtopic&f=' . $present . '" alt="Cliquer ici pour faire votre présentation" title="Cliquer ici pour faire votre présentation"><b><u>ici</u></b></a> pour faire votre présentation<br />.');
  } else {
    redirect(append_sid("posting.php?mode=newtopic&f=" . $present . "", true));
  }
 }
}

if (($userdata['session_logged_in']) && ($arcade_config['favoris_seeg']))
 {
   include_once($phpbb_root_path . 'arcade_favoris.'.$phpEx);
 }

if (!empty($HTTP_POST_VARS['gid']) || !empty($HTTP_GET_VARS['gid']))
 {
	 $gid = (!empty($HTTP_POST_VARS['gid'])) ? intval($HTTP_POST_VARS['gid']) : intval($HTTP_GET_VARS['gid']);
 } else {
	 message_die(GENERAL_ERROR, "Aucun jeu n'est précisé"); 
 }

$sql = "SELECT g.* , MAX(s.score_game) as highscore FROM " . GAMES_TABLE . " g left join " . SCORES_TABLE . " s on g.game_id = s.game_id WHERE g.game_id = $gid GROUP BY g.game_id,g.game_highscore" ; 
if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
 }

if ( !( $row = $db->sql_fetchrow($result) ) )
 {
	 message_die(GENERAL_ERROR, "Ce jeu n'existe pas", '', __LINE__, __FILE__, $sql); 
 }

if (( !$userdata['session_logged_in']) && ($row['game_auth_acc']!=1))
 {
	$message = $lang['Guest_no_gamelist'] . "<br /><br />" . sprintf($lang['Click_return_guest_gamelist'], "<a href=\"" . append_sid("arcade.$phpEx") . "\">", "</a>");
  message_die(GENERAL_MESSAGE, $message);
 }

$highscore_type = $row['game_highscore_type'];
$game_cheatcontrol = $row['game_cheat_control'];

if ($arcade_config['use_points_mod'] && $arcade_config['use_points_pay_mod'])
{
  $nbpoint = $userdata['user_points']; 

	if($arcade_config['pay_all_games']==1)
		{
		$cost=$arcade_config['points_pay'];
		if ($arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit'])
			{
			$cost=$arcade_config['points_pay'];
			}
		}
	else
		{
		$cost= $row['point_pay'];
		if ($arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit'])
			{
			$cost=$row['point_pay'];
			}
		}

if($nbpoint < $cost && $userdata['session_logged_in'])
 {
	$page_title = $lang['arcade_game']; 
	$template->assign_vars(array( 'META' => '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">'));
	$message .= sprintf($lang['Sorry_Arcade_Pay'], $cost, $board_config['points_name']) . "<br /><br />" . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
	}	else {
	$pay=0;
	$pay = intval($HTTP_GET_VARS['pay']);
	if(($pay==0 && $cost>0) && ($arcade_config['use_points_pay_charging'] && (!$arcade_config['use_points_pay_submit'])))
	{			
  if ($userdata['session_logged_in'])
	{	
		$message .='<br /><br /><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"><tr><td class="catHead" align="center" height="28"><span class="cattitle">Information</span></td></tr><tr><td class="row1" align="center"><span class="gen">'.sprintf($lang['game_cost'], $cost, $board_config['points_name']) . "<br /><br />" . sprintf ($lang['confirmation'],'<a href="' . append_sid("games.$phpEx?gid=". $gid ."&pay=1") .'">','</a>','<a href="' . append_sid("arcade.$phpEx") . '">', '</a>').'</span></td></tr></table><br /><br />'; 
		include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
		echo $message; 
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}	else {	
		$message .='<br /><br /><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"><tr><td class="catHead" align="center" height="28"><span class="cattitle">Information</span></td></tr><tr><td class="row1" align="center"><span class="gen">'.sprintf($lang['game_cost'], 0, $board_config['points_name']) . "<br /><br />Comme vous ne possèdez aucun points et que vous n'êtes pas encore éffectué votre <a href=" . append_sid("profile.$phpEx?mode=register") . "><font color='green'>inscription</font></a><br />les parties seront gratuites. mais vous ne remporterez aucun " . $board_config['points_name'] . " non plus.<br /><br />" . sprintf ($lang['confirmation'],'<a href="' . append_sid("games.$phpEx?gid=". $gid ."&pay=1") .'">','</a>','<a href="' . append_sid("arcade.$phpEx") . '">', '</a>').'<br /><br /></span></td></tr></table><br /><br />'; 
		include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
		echo $message; 
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

if ($arcade_config['use_points_pay_charging'] and (!$arcade_config['use_points_pay_submit']))
{
	$nbpoint = $nbpoint - $cost;  
} elseif ($arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit'])
{
	$nbpoint = $nbpoint - ($cost/2);  
}

$sql = "update " . USERS_TABLE . " set user_points = $nbpoint where user_id = " . $userdata['user_id'] ; 
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible de modifier les points du joueur.", '', __LINE__, __FILE__, $sql); 
}

if($arcade_config['limit_by_posts'] && $userdata['user_level'] != ADMIN)
 {
  $secs = 86400;
  $uid = $userdata['user_id'];

  $days = $arcade_config['days_limit'];
  $posts = $arcade_config['posts_needed'];

  $current_time = time();
  $old_time = $current_time - ($secs * $days);

if($arcade_config['limit_type']=='posts')
 {
  $sql = "SELECT * FROM " . POSTS_TABLE . " WHERE poster_id = $uid";
 } else {
  $sql = "SELECT * FROM " . POSTS_TABLE . " WHERE poster_id = $uid and post_time BETWEEN $old_time AND $current_time";
 }
if(!($result = $db->sql_query($sql)) )
 {
   message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
 }
  $Amount_Of_Posts = $db->sql_numrows( $result );
if($Amount_Of_Posts < $posts)
 {
  $diff_posts = $posts - $Amount_Of_Posts;
if($userdata['session_logged_in'])
{
if($arcade_config['limit_type']=='posts')
 {
  $message = "Vous devez possèder $posts messages pour pouvoir jouer dans l'arcade.<br/>Il vous faut encore $diff_posts messages supplémentaire.";
 } else {
  $message = "Vous devez possèder $posts messages depuis les $days derniers jours pour pouvoir jouer dans l'arcade.<br/>Il vous faut encore $diff_posts messages supplémentaire.";
 }
   message_die(GENERAL_MESSAGE, $message);
 }
 }
}

$liste_cat_auth_play = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'play');
$tbauth_play = array();
$tbauth_play = explode(',',$liste_cat_auth_play);

if( !in_array($row['arcade_catid'],$tbauth_play))
 {
	message_die(GENERAL_MESSAGE, $lang['game_forbidden']);
 }

//chargement du template
$template->set_filenames(array(
  'body' => 'games_body.tpl')
);

if (( !$userdata['session_logged_in']) AND ($arcade_config['auths_play']) AND (!$arcade_config['auths_score']))
{
$template->assign_block_vars('auth_scoreno',array(
	'L_INFO' => $lang['auth_score_no'],
	'AUTH' => $userdata['username'])
	);
}	

if (( !$userdata['session_logged_in']) AND ($arcade_config['auths_play']) AND ($arcade_config['auths_score']))
{
$template->assign_block_vars('auth_scoreok',array(
	'L_INFO' => $lang['auth_score_yes'],
	'AUTH' => $userdata['username'])
	);
}

$sql = "DELETE FROM " . GAMEHASH_TABLE . " WHERE hash_date < " . (time() - 72000 ) ;
if( !$db->sql_query($sql) )
 {
	 message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }

if ( $row['game_type'] == 3 )
{
// Jeu type V2
$type_v2 = true ;
$template->assign_block_vars('game_type_V2',array());
$gamehash_id = md5(uniqid($user_ip));

$sql = "INSERT INTO " . GAMEHASH_TABLE . " ( gamehash_id , game_id , user_id , hash_date ) VALUES ( '$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')" ;
if( !($result = $db->sql_query($sql)) )
 {
	message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }
}
elseif ($row['game_type'] == 4)
{
 $template->assign_block_vars('game_type_V2',array());
 setcookie('gidstarted', '', time() - 3600);
 setcookie('gidstarted',$gid);
 setcookie('timestarted', '', time() - 3600);
 setcookie('timestarted', time());

 $gamehash_id = md5($user_ip);

$sql = "INSERT INTO " . GAMEHASH_TABLE . " (gamehash_id , game_id , user_id , hash_date) VALUES ('$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')";
if (!($result = $db->sql_query($sql)))
 {
//message_die(GENERAL_ERROR, "Couldn't update hashtable", '', __LINE__, __FILE__, $sql);
 }
$sql = "UPDATE " . GAMES_TABLE . " SET game_set = game_set+1 WHERE game_id =  '$gid'";
$db->sql_query($sql);
if ($game_cheatcontrol)
 {
  //Enregistrement de la session du jeu
  $gamesessid = md5(uniqid(mt_rand(), true));
  $sql = "INSERT INTO " . ARCADE_TIME_TEMP . " (game_sessid, user_id, game_id, date_enreg) VALUES ('" . $gamesessid . "', '" . $userdata['user_id'] . "','$gid', '" . time() . "')";
  if (!($result = $db->sql_query($sql)))
   {
    message_die(GENERAL_ERROR, "Couldn't insert values in table games_time", '', __LINE__, __FILE__, $sql);
   }
  }
} else {
// Jeu type V1
 	$type_v2 = false ;
	$template->assign_block_vars('game_type_V1',array());
	$gamehash_id = md5(uniqid($user_ip)) ;

$sql = "INSERT INTO " . GAMEHASH_TABLE . " ( gamehash_id , game_id , user_id , hash_date ) VALUES ( '$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')" ;
if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }

$sql = "UPDATE " . GAMES_TABLE . " SET game_set = game_set+1 WHERE game_id =  '$gid'";
$db->sql_query($sql) ;
}

$scriptpath = substr($board_config['script_path'] , strlen( $board_config['script_path'] ) - 1 , 1 ) == '/' ? substr( $board_config['script_path'] , 0 , strlen( $board_config['script_path'] ) - 1 ) : $board_config['script_path'];
$scriptpath = "http://" . $board_config['server_name'] .$scriptpath;

if($arcade_config['use_fav_category'])
{
 $sql = "SELECT COUNT(*) AS nbfav from ".ARCADE_FAV_TABLE." where user_id= ".$userdata['user_id']." and game_id= ".$row['game_id'];
 if( !($result = $db->sql_query($sql)) )
	{
	 message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des favoris", '', __LINE__, __FILE__, $sql);
	}
	$rowf = $db->sql_fetchrow($result);
	$nbfav = $rowf['nbfav'];
 }

include($phpbb_root_path . 'includes/functions_arcade_favoris.'.$phpEx);

$favtest = favoris_inserted($userdata['user_id'], $gid);
if (($favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('no_fav', array(
  'ADD_FAV' => $lang['Cant_add_fav'])
  );
}
elseif ((!$favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('fav', array(
  'ADD_FAV' => ($arcade_config['use_fav_category'] + !$nbfav)?'<a href="' . append_sid("arcade.$phpEx?favori=" . $row['game_id'] ) .'" alt="'.$lang['add_fav'].'" title="'.$lang['add_fav'].'" class="nav"><img src="' . append_sid("images/arcades/favs.gif").'" border=0>'.$lang['add_fav'].'<img src="' . append_sid("images/arcades/favs.gif").'" border=0></a>':'')
  );
}

if (($arcade_config['use_fav_category']) && ($userdata['session_logged_in']))
 {
  $favolink = '- [ <nobr><a class="nav" href="' . append_sid("arcade.$phpEx?mode=favoris" . $row['arcade_favoris'] ) . '">' . $lang['Rfavoris'] . '</a></nobr> ]&nbsp;';
 } else {
 	$favolink = '';
}
if ($arcade_config['use_category_mod'])
 {
  $catlink = '- [ <nobr><a class="nav" href="' . append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ) . '" alt="'.$lang['Rcategory'].'" title="'.$lang['Rcategory'].'">' . $lang['Rcategory'] . '</a></nobr> ]&nbsp;';
 } else {
 	$catlink = '';
}

$template->assign_vars(array(
	'U_URL' => append_sid("" ),
	'MAXSIZE_AVATAR' => intval($arcade_config['maxsize_avatar']),
	'SWF_GAME' => $row['game_swf'],
  'GAME_WIDTH' => $row['game_width'],
  'GAME_HEIGHT' => $row['game_height'],
	'L_GAME' => $row['game_name'],
	'L_TOP' => $lang['best_scores'] ,
	'GID' => $gid,
  'GSID' => $gamesessid,
	'UIP' => $user_ip,
	'BBTITLE' => str_replace('"','',$board_config['sitename']),
	'SCRIPT_PATH' => $scriptpath,
	'SID' => ( $sid != '' ) ? "&sid=$sid" : "",
	'GAMEHASH' => $gamehash_id,
	'USER_NAME' => $userdata['username'],
	'HIGHSCORE' => $row['highscore'],
	'SETTIME' => time(),
	'NAV_DESC' => '<a class="nav" href="' . append_sid("arcade.$phpEx") . '">Arcade</a> ' ,
  'URL_FAV' => $favolink,
  'URL_CAT' => $catlink,
	'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $userdata['user_id'] ) . '">' . $lang['statuser'] . '</a></nobr> ',
  'SEARCHGAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['searchgames'] . '</a></nobr> ',
	'MANAGE_COMMENTS' => '<nobr><a class="nav" href="' . append_sid("comments_list.$phpEx") . '">' . $lang['comments'] . '</a></nobr> ',
  'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '">' . $lang['Arcade_game_alea'] . '</a></nobr> ',
	'URL_SEARCH_GAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '">' . $lang['search_games_arcade'] . '</a></nobr> ',
	'URL_ARCADE' => '<nobr><a class="nav" href="' . append_sid("arcade.$phpEx") . '">' . $lang['lib_arcade'] . '</a></nobr> ',
	'URL_BESTSCORES' => '<nobr><a class="nav" href="' . append_sid("toparcade.$phpEx") . '">' . $lang['best_scores'] . '</a></nobr> ',
	'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=$gid") . '">' . $lang['scoreboard'] . '</a></nobr> ')
	);

if ($userdata['session_logged_in'])
 {
  $template->assign_block_vars('switch_jumpbox',array());
 }

// Catégories dans l'index
	$sql = "SELECT c.arcade_cattitle, c.arcade_catid, g.arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . " c, " . GAMES_TABLE . " g
	WHERE c.arcade_catid = g.arcade_catid
	AND game_id = $gid ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
	}
	if ( $row = $db->sql_fetchrow($result))
	{
   		$nomcat = $row['arcade_cattitle'];
	}

  if ($arcade_config['use_category_mod'])
  {
    $navlink = '&nbsp;- &nbsp;<nobr><a class="cattitle" href="' . append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ) . '" alt="' . $nomcat . '" title="' . $nomcat . '">' . $nomcat . '</a></nobr>&nbsp;&nbsp;';
  } else {
 	  $navlink = '';
  }

$template->assign_vars(array(
  'NAV_CAT' => $navlink)
  );

//Les meilleurs scores
$sql = "SELECT s.*score_set, u.username, u.user_level, u.user_avatar_type, u.user_allowavatar, u.user_avatar FROM " . SCORES_TABLE . " s left join " . USERS_TABLE . " u on s.user_id = u.user_id WHERE game_id = $gid ORDER BY s.score_game DESC, s.score_date ASC LIMIT 0,15 " ;

//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------

$clause_order = ($highscore_type == 0) ? "ORDER BY s.score_game DESC" : "ORDER BY s.score_game ASC";
$sql = str_replace("ORDER BY s.score_game DESC", $clause_order, $sql);

if( !($result = $db->sql_query($sql)) )
{
 message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
}

$sql ='SELECT * FROM ' . COMMENTS_TABLE . ' WHERE game_id = '.$gid;
if( !($result_comment = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error retrieving comment from comment table', '', __LINE__, __FILE__, $sql);
}
$row_comment = $db->sql_fetchrow($result_comment);
$comment= str_replace("\n", "\n<br />\n", $row_comment['message']);
if( $comment)
{
if ( $board_config['allow_smilies'] )
 {
	$comment = smilies_pass2($comment);
 }
	$comment =  bbencode_pass($comment);
	$comment = wordwrap($comment, 78, "\n", 1);
if (count($orig_word))
 {
	$comment = str_replace('\"', '"', substr(preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $comment . '<'), 1, -1));
 }
	$comment = '<marquee scrollamount="3" width="100%" length="100%">' .$comment .'</marquee>';
	$couronne = '<img src="templates/' . $theme['template_name'] . '/images/couronne.gif">';
}

$pos = 0 ;
$posreelle = 0;
$lastscore = 0;
while ( $row = $db->sql_fetchrow($result) )
{
$style_color = $rcs->get_colors($row);
// $style_color = user_color($row['username'], $row['user_level']);
 if ( $row['user_id'] == ANONYMOUS ){
 $username = $row['username'];
 } else {
 $username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
 }

$posreelle++ ;
if ( $posreelle == 1)
 {
  $user_avatar_type = $row['user_avatar_type'];
  $user_allowavatar = $row['user_allowavatar'];
  $user_avatar = $row['user_avatar'];
  $best_user = $username;
  $user_record = $row['score_game'];
}

if( $row['score_set'] == 1 )
 {
  $row['score_set'] = $row['score_set'].' '.$lang['playing'];
 }
if( $row['score_set'] > 1 )
 {
  $row['score_set'] = $row['score_set'].' '.$lang['playings'];
 }

if ($lastscore!=$row['score_game'])$pos = $posreelle;
$lastscore = $row['score_game'];

if ($arcade_config['scorerow_position']=='right')
 {
 $template->assign_block_vars('scoreright', array(
	'POS' => $pos,
	'USERNAME' => $username,
  'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $row['user_id'] ) . '">' . "<img src='templates/" . $theme['template_name'] . "/images/loupe.gif' align='absmiddle' border='0' alt='" . $lang['statuser'] . " " . $row['username'] . "'>" . '</a></nobr> ',
  'PLAY' => $row['score_set'],
	'GAMEDESC' => $row['game_desc'],
	'NOSCORE' => ( $row['score_game'] == 0 ) ? $lang['no_record'] : '',
	'SCORE' => $row['score_game'],
	'DATEHIGH' => create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'])
	));
 } else {
  $template->assign_block_vars('scoreleft', array(
	'POS' => $pos,
	'USERNAME' => $username,
  'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $row['user_id'] ) . '">' . "<img src='templates/" . $theme['template_name'] . "/images/loupe.gif' align='absmiddle' border='0' alt='" . $lang['statuser'] . " " . $row['username'] . "'>" . '</a></nobr> ',
  'PLAY' => $row['score_set'],
	'GAMEDESC' => $row['game_desc'],
	'SCORE' => $row['score_game'],
	'DATEHIGH' => create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'])
	));
 }
}

if ($arcade_config['scorerow_position']=='right')
 {
   $template->assign_block_vars('switch_right',array()); } else {
   $template->assign_block_vars('switch_left',array());
 }

$avatar_img = '';
if ( $user_avatar_type && $user_allowavatar )
{
switch( $user_avatar_type )
 {
  case USER_AVATAR_UPLOAD:
   $avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" border="0" hspace="20" align="center" valign="center" onload="resize_avatar(this)"/>' : '';
   break;
  case USER_AVATAR_REMOTE:
   $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center"  onload="resize_avatar(this)"/>' : '';
   break;
  case USER_AVATAR_GALLERY:
   $avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center"  onload="resize_avatar(this)"/>' : '';
   break;
  }
}

if ( empty($avatar_img) )
 {
  $avatar_img = '<img src="images/arcades/noavatar.gif" alt="Aucun Avatar" border="0" />';
 }

if ($arcade_config['display_winner_avatar']) {
if ($arcade_config['winner_avatar_position']=='right') {
	 $template->assign_block_vars('avatar_best_player_right',array()); } else {
	 $template->assign_block_vars('avatar_best_player_left',array());
 }

$admin_link_modo = (( $userdata['user_level'] == ADMIN) OR ( $userdata['user_level'] == MOD )) ? '<a href="modo_arcade_comments.' . $phpEx . '?mode=edit&gid=' .$gid.'&sid=' . $userdata['session_id'] . '"><img src=templates/' . $theme['template_name'] . '/images/commentedit.gif border="0"></a>' : '';
$modo_admin_record  = (( $userdata['user_level'] == ADMIN) OR ( $userdata['user_level'] == MOD )) ? '<a href="modoadminrecord.' . $phpEx . '?mode=edit&gid=' .$gid.'&sid=' . $userdata['session_id'] . '"><img src=templates/' . $theme['template_name'] . '/images/supprecord.gif border="0"></a>' : '';
make_arcadejumpbox('games.'.$phpEx);

$template->assign_vars(array(
  'U_PROFIL' => $profil,
  'WIDTH' => $width,
  'L_ACTUAL_WINNER' => $lang['Actual_winner'],
  'BEST_USER_NAME' => $best_user,
	'BEST_SCORE' => ( $user_record != 0 ) ? '<font color="green"><b>' . $user_record . '</b></font>' : '<font color="red"><b>' . $lang['no_record'] . '</b></font>',
	'COMMENTS' => $comment,
  'EDITCOMMENT' => $admin_link_modo,
	'MODOADMINRECORD' => $modo_admin_record,
  'COURONNE' => $couronne,
  'FIRST_AVATAR' => $avatar_img)
  );
}

if ($arcade_config['topstats_seeg'])
{
include($phpbb_root_path . 'topstatarcade.'.$phpEx);
}
if ($arcade_config['champ_seeg'])
{
include($phpbb_root_path . 'championnatarcade.'.$phpEx);
}
if ($arcade_config['heading_seeg'])
{
include($phpbb_root_path . 'headingarcade.'.$phpEx);
}
if ($arcade_config['whoisplay_seeg'])
{
include($phpbb_root_path . 'whoisplaying.'.$phpEx);
}
if (($arcade_config['cat_seeg']) && ($userdata['session_logged_in']))
{
include($phpbb_root_path . 'arcade_cat.'.$phpEx);
}

if (($arcade_config['use_arcade_vote']==1) && ($userdata['session_logged_in']) || ($arcade_config['use_arcade_vote']==1) && (!$userdata['session_logged_in']) && ($arcade_config['auths_vote_hidden'] ))
{
	$template->assign_block_vars('use_arcade_vote',array()) ;
	include($phpbb_root_path . 'arcade_vote.'.$phpEx);
}

 $width= 100;

 $sql = "SELECT game_ultimate_highscore, game_ultimate_highuser, game_ultimate_highdate FROM ". GAMES_TABLE ." WHERE game_id = ". $gid ." LIMIT 0,1;";
 $result1 = $db->sql_query($sql);
 $row1 = $db->sql_fetchrow($result1);
 $game_ultimate_highscore = $row1['game_ultimate_highscore'];
 $game_ultimate_highdate = $row1['game_ultimate_highdate'];
 $game_ultimate_highuser = $row1['game_ultimate_highuser'];
 if($game_ultimate_highuser != 0)
  {
    $sql = "SELECT username, user_id, user_level, user_avatar_type, user_allowavatar, user_avatar FROM ". USERS_TABLE ." WHERE `user_id` = '" . $game_ultimate_highuser . "' LIMIT 0,1;";
    $result2 = $db->sql_query($sql);
    while($row2 = $db->sql_fetchrow($result2) )
    {
     $game_ultimate_user_id = $row2['user_id'];
     $style_color = user_color($row2['username'], $row2['user_level']);
     if ( $row2['user_id'] == ANONYMOUS ) {
		 $game_ultimate_username = $row2['username'];
     } else {
     $game_ultimate_username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row2['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row2['username'] . '" title="' . $lang['Read_profile'] .' '. $row2['username'] . '"' . $style_color .'>' . $row2['username'] . '</a>';
     }
     $game_ultimate_avatar = $row2['user_avatar'];
     $game_ultimate_avatar_type = $row2['user_avatar_type'];
     $game_ultimate_allowavatar = $row2['user_allowavatar'];
    }
   } else {
     $game_ultimate_username = '';
   }

//AVATAR
$avatar_img = ''; 
if ( $game_ultimate_avatar_type && $game_ultimate_allowavatar ) 
 { 
	switch( $game_ultimate_avatar_type ) 
	 { 
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
	 }
 }

if ( empty($avatar_img) ) 
 { 
   $avatar_img = '<img src="images/arcades/noavatar.gif" width="'. $width .'" alt="Aucun Avatar" title="Aucun Avatar" border="0" />'; 
 }

   $profil = append_sid("profile.$phpEx?mode=viewprofile&amp;". POST_USERS_URL .'='. $game_ultimate_user_id );
   $date_ultimate = "<nobr>" . create_date( $board_config['default_dateformat'] , $game_ultimate_highdate , $board_config['board_timezone'] ) . "</nobr>";

if ($arcade_config['display_ultime_winner_avatar']) {
if ($arcade_config['winner_ultime_avatar_position']=='right') {
	 $template->assign_block_vars('ultime_avatar_best_player_right',array()); } else {
	 $template->assign_block_vars('ultime_avatar_best_player_left',array());
 }

$template->assign_vars(array(
  'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
  'ULTIMATE_HIGHSCORE' => ( $game_ultimate_highscore != 0 ) ? '<font color="green"><b>' . $game_ultimate_highscore . '</b></font>' : '<font color="red"><b>' . $lang['no_record'] . '</b></font>',
  'ULTIMATEHIGHUSER' => ( $game_ultimate_highuser != 0 ) ? '' . $game_ultimate_username . '' : '' ,
  'ULTIMATEDATEHIGH' => ( $game_ultimate_highuser != 0 ) ? '' . $date_ultimate . '' : '',
  'ULTIMATE_AVATAR' => $avatar_img)
  );
}

//
// Output page header
$page_title = $lang['arcade_game'];
if ($game_cheatcontrol)
{
   include($phpbb_root_path . 'includes/page_header_games.'.$phpEx);
} else {
   include($phpbb_root_path . 'includes/page_header.'.$phpEx);
}
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 }
}
else
{
if($arcade_config['limit_by_posts'] && $userdata['user_level'] != ADMIN)
 {
  $secs = 86400;
  $uid = $userdata['user_id'];

  $days = $arcade_config['days_limit'];
  $posts = $arcade_config['posts_needed'];

  $current_time = time();
  $old_time = $current_time - ($secs * $days);

if($arcade_config['limit_type']=='posts')
 {
  $sql = "SELECT * FROM " . POSTS_TABLE . " WHERE poster_id = $uid";
 } else {
  $sql = "SELECT * FROM " . POSTS_TABLE . " WHERE poster_id = $uid and post_time BETWEEN $old_time AND $current_time";
 }
if(!($result = $db->sql_query($sql)) )
 {
  message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
 }
  $Amount_Of_Posts = $db->sql_numrows( $result );
if($Amount_Of_Posts < $posts)
 {
  $diff_posts = $posts - $Amount_Of_Posts;
if($userdata['session_logged_in'])
{
if($arcade_config['limit_type']=='posts')
 {
  $message = "Vous devez possèder $posts messages pour pouvoir jouer dans l'arcade.<br/>Il vous faut encore $diff_posts messages supplémentaire.";
 } else {
  $message = "Vous devez possèder $posts messages depuis les $days derniers jours pour pouvoir jouer dans l'arcade.<br/>Il vous faut encore $diff_posts messages supplémentaire.";
 }
  message_die(GENERAL_MESSAGE, $message);
 }
 }
}

$liste_cat_auth_play = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'play');
$tbauth_play = array();
$tbauth_play = explode(',',$liste_cat_auth_play);

if( !in_array($row['arcade_catid'],$tbauth_play))
 {
	message_die(GENERAL_MESSAGE, $lang['game_forbidden']);
 }

//chargement du template
$template->set_filenames(array(
  'body' => 'games_body.tpl')
);

if (( !$userdata['session_logged_in']) AND ($arcade_config['auths_play']) AND (!$arcade_config['auths_score']))
{
$template->assign_block_vars('auth_scoreno',array(
	'L_INFO' => $lang['auth_score_no'],
	'AUTH' => $userdata['username'])
	);
}	

if (( !$userdata['session_logged_in']) AND ($arcade_config['auths_play']) AND ($arcade_config['auths_score']))
{
$template->assign_block_vars('auth_scoreok',array(
	'L_INFO' => $lang['auth_score_yes'],
	'AUTH' => $userdata['username'])
	);
}

$sql = "DELETE FROM " . GAMEHASH_TABLE . " WHERE hash_date < " . (time() - 72000 );
if( !$db->sql_query($sql) )
 {
	 message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }

if ( $row['game_type'] == 3 )
{
// Jeu type V2
$type_v2 = true ;
$template->assign_block_vars('game_type_V2',array());
$gamehash_id = md5(uniqid($user_ip)) ;

$sql = "INSERT INTO " . GAMEHASH_TABLE . " ( gamehash_id , game_id , user_id , hash_date ) VALUES ( '$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')" ;
if( !($result = $db->sql_query($sql)) )
 {
	message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }
}
elseif ($row['game_type'] == 4)
{
 $template->assign_block_vars('game_type_V2',array());
 setcookie('gidstarted', '', time() - 3600);
 setcookie('gidstarted',$gid);
 setcookie('timestarted', '', time() - 3600);
 setcookie('timestarted', time());

 $gamehash_id = md5($user_ip);

$sql = "INSERT INTO " . GAMEHASH_TABLE . " (gamehash_id , game_id , user_id , hash_date) VALUES ('$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')";
if (!($result = $db->sql_query($sql)))
 {
//message_die(GENERAL_ERROR, "Couldn't update hashtable", '', __LINE__, __FILE__, $sql);
 }
$sql = "UPDATE " . GAMES_TABLE . " SET game_set = game_set+1 WHERE game_id =  '$gid'";
$db->sql_query($sql);
if ($game_cheatcontrol)
 {
  //Enregistrement de la session du jeu
  $gamesessid = md5(uniqid(mt_rand(), true));
  $sql = "INSERT INTO " . ARCADE_TIME_TEMP . " (game_sessid, user_id, game_id, date_enreg) VALUES ('" . $gamesessid . "', '" . $userdata['user_id'] . "','$gid', '" . time() . "')";
  if (!($result = $db->sql_query($sql)))
   {
    message_die(GENERAL_ERROR, "Couldn't insert values in table games_time", '', __LINE__, __FILE__, $sql);
   }
  }
}
else
{
// Jeu type V1
 	$type_v2 = false ;
	$template->assign_block_vars('game_type_V1',array());
	$gamehash_id = md5(uniqid($user_ip)) ;

$sql = "INSERT INTO " . GAMEHASH_TABLE . " ( gamehash_id , game_id , user_id , hash_date ) VALUES ( '$gamehash_id' , '$gid' , '" . $userdata['user_id'] . "' , '" . time() . "')" ;
if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
 }

$sql = "UPDATE " . GAMES_TABLE . " SET game_set = game_set+1 WHERE game_id =  '$gid'";
	$db->sql_query($sql) ;
}

$scriptpath = substr($board_config['script_path'] , strlen( $board_config['script_path'] ) - 1 , 1 ) == '/' ? substr( $board_config['script_path'] , 0 , strlen( $board_config['script_path'] ) - 1 ) : $board_config['script_path'] ;
$scriptpath = "http://" . $board_config['server_name'] .$scriptpath ;

if($arcade_config['use_fav_category'])
 {
 $sql = "SELECT COUNT(*) AS nbfav from ".ARCADE_FAV_TABLE." where user_id= ".$userdata['user_id']." and game_id= ".$row['game_id'];
 if( !($result = $db->sql_query($sql)) )
	{
	 message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des favoris", '', __LINE__, __FILE__, $sql);
	}
	$rowf = $db->sql_fetchrow($result);
	$nbfav = $rowf['nbfav'];
 }

include($phpbb_root_path . 'includes/functions_arcade_favoris.'.$phpEx);	

$favtest = favoris_inserted($userdata['user_id'], $gid);
if (($favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('no_fav', array(
  'ADD_FAV' => $lang['Cant_add_fav'])
  );
}
elseif ((!$favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('fav', array(
  'ADD_FAV' => ($arcade_config['use_fav_category'] + !$nbfav)?'<a href="' . append_sid("arcade.$phpEx?favori=" . $row['game_id'] ) .'" alt="'.$lang['add_fav'].'" title="'.$lang['add_fav'].'" class="nav"><img src="' . append_sid("images/arcades/favs.gif").'" border=0>'.$lang['add_fav'].'<img src="' . append_sid("images/arcades/favs.gif").'" border=0></a>':'')
  );
}

if (($arcade_config['use_fav_category']) && ($userdata['session_logged_in']))
 {
  $favolink = '- [ <nobr><a class="nav" href="' . append_sid("arcade.$phpEx?mode=favoris" . $row['arcade_favoris'] ) . '">' . $lang['Rfavoris'] . '</a></nobr> ]&nbsp;';
 } else {
 	$favolink = '';
}
if ($arcade_config['use_category_mod'])
 {
  $catlink = '- [ <nobr><a class="nav" href="' . append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ) . '" alt="'.$lang['Rcategory'].'" title="'.$lang['Rcategory'].'">' . $lang['Rcategory'] . '</a></nobr> ]&nbsp;';
 } else {
 	$catlink = '';
}

$template->assign_vars(array(
	'U_URL' => append_sid("" ),
	'MAXSIZE_AVATAR' => intval($arcade_config['maxsize_avatar']),
	'SWF_GAME' => $row['game_swf'],
  'GAME_WIDTH' => $row['game_width'],
  'GAME_HEIGHT' => $row['game_height'],
	'L_GAME' => $row['game_name'],
	'L_TOP' => $lang['best_scores'] ,
	'GID' => $gid,
  'GSID' => $gamesessid,
	'UIP' => $user_ip,
	'BBTITLE' => str_replace('"','',$board_config['sitename']),
	'SCRIPT_PATH' => $scriptpath,
	'SID' => ( $sid != '' ) ? "&sid=$sid" : "",
	'GAMEHASH' => $gamehash_id,
	'USER_NAME' => $userdata['username'],
	'HIGHSCORE' => $row['highscore'],
	'SETTIME' => time(),
	'NAV_DESC' => '<a class="nav" href="' . append_sid("arcade.$phpEx") . '">Arcade</a>',
  'URL_FAV' => $favolink,
  'URL_CAT' => $catlink,
	'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $userdata['user_id'] ) . '">' . $lang['statuser'] . '</a></nobr> ',
  'SEARCHGAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['searchgames'] . '</a></nobr> ',
	'MANAGE_COMMENTS' => '<nobr><a class="nav" href="' . append_sid("comments_list.$phpEx") . '">' . $lang['comments'] . '</a></nobr> ',
  'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '">' . $lang['Arcade_game_alea'] . '</a></nobr> ',
	'URL_SEARCH_GAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '">' . $lang['search_games_arcade'] . '</a></nobr> ',
	'URL_ARCADE' => '<nobr><a class="nav" href="' . append_sid("arcade.$phpEx") . '">' . $lang['lib_arcade'] . '</a></nobr> ',
	'URL_BESTSCORES' => '<nobr><a class="nav" href="' . append_sid("toparcade.$phpEx") . '">' . $lang['best_scores'] . '</a></nobr> ',
	'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=$gid") . '">' . $lang['scoreboard'] . '</a></nobr> ')
	);

if ($userdata['session_logged_in'])
 {
  $template->assign_block_vars('switch_jumpbox',array());
 }

// Catégories dans l'index
	$sql = "SELECT c.arcade_cattitle, c.arcade_catid, g.arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . " c, " . GAMES_TABLE . " g
	WHERE c.arcade_catid = g.arcade_catid
	AND game_id = $gid ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
	}
	if ( $row = $db->sql_fetchrow($result))
	{
   		$nomcat = $row['arcade_cattitle'];
	}

if ($arcade_config['use_category_mod'])
 {
  $navlink = '&nbsp;- &nbsp;<nobr><a class="nav" href="' . append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ) . '" alt="' . $nomcat . '" title="' . $nomcat . '">' . $nomcat . '</a></nobr>&nbsp;&nbsp;';
 } else {
 	$navlink = '';
}

$template->assign_vars(array(
  'NAV_CAT' => $navlink)
  );

//Les meilleurs scores
$sql = "SELECT s.*score_set, u.username, u.user_level, u.user_avatar_type, u.user_allowavatar, u.user_avatar FROM " . SCORES_TABLE . " s left join " . USERS_TABLE . " u on s.user_id = u.user_id WHERE game_id = $gid ORDER BY s.score_game DESC, s.score_date ASC LIMIT 0,15 " ;

//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------

$clause_order = ($highscore_type == 0) ? "ORDER BY s.score_game DESC" : "ORDER BY s.score_game ASC";
$sql = str_replace("ORDER BY s.score_game DESC", $clause_order, $sql);

if( !($result = $db->sql_query($sql)) )
{
 message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
}

$sql ='SELECT * FROM ' . COMMENTS_TABLE . ' WHERE game_id = '.$gid;
if( !($result_comment = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error retrieving comment from comment table', '', __LINE__, __FILE__, $sql);
}
$row_comment = $db->sql_fetchrow($result_comment);
$comment= str_replace("\n", "\n<br />\n", $row_comment['message']);
if( $comment)
{
if ( $board_config['allow_smilies'] )
 {
	$comment = smilies_pass2($comment);
 }
	$comment =  bbencode_pass($comment);
	$comment = wordwrap($comment, 78, "\n", 1);
if (count($orig_word))
 {
	$comment = str_replace('\"', '"', substr(preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $comment . '<'), 1, -1));
 }
	$comment = '<marquee scrollamount="3" width="100%" length="100%">' .$comment .'</marquee>';
	$couronne = '<img src="templates/' . $theme['template_name'] . '/images/couronne.gif">';
}

$pos = 0 ;
$posreelle = 0;
$lastscore = 0;
while ( $row = $db->sql_fetchrow($result) )
{
  $style_color = $rcs->get_colors($row);
  //$style_color = user_color($row['username'], $row['user_level']);
 if ( $row['user_id'] == ANONYMOUS ){
 $username = $row['username'];
 } else {
 $username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
 }

$posreelle++ ;
if ( $posreelle == 1)
 {
  $user_avatar_type = $row['user_avatar_type'];
  $user_allowavatar = $row['user_allowavatar'];
  $user_avatar = $row['user_avatar'];
  $best_user = $username;
  $user_record = $row['score_game'];
}

if( $row['score_set'] == 1 )
 {
  $row['score_set'] = $row['score_set'].' '.$lang['playing'];
 }
if( $row['score_set'] > 1 )
 {
  $row['score_set'] = $row['score_set'].' '.$lang['playings'];
 }

if ($lastscore!=$row['score_game'])$pos = $posreelle;
$lastscore = $row['score_game'];

if ($arcade_config['scorerow_position']=='right')
 {
 $template->assign_block_vars('scoreright', array(
	'POS' => $pos,
	'USERNAME' => $username,
  'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $row['user_id'] ) . '">' . "<img src='templates/" . $theme['template_name'] . "/images/loupe.gif' align='absmiddle' border='0' alt='" . $lang['statuser'] . " " . $row['username'] . "'>" . '</a></nobr> ',
  'PLAY' => $row['score_set'],
	'GAMEDESC' => $row['game_desc'],
	'SCORE' => $row['score_game'],
	'DATEHIGH' => create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'])
	));
 } else {
  $template->assign_block_vars('scoreleft', array(
	'POS' => $pos,
	'USERNAME' => $username,
  'URL_STATS' => '<nobr><a class="nav" href="' . append_sid("statarcade.$phpEx?uid=" . $row['user_id'] ) . '">' . "<img src='templates/" . $theme['template_name'] . "/images/loupe.gif' align='absmiddle' border='0' alt='" . $lang['statuser'] . " " . $row['username'] . "'>" . '</a></nobr> ',
  'PLAY' => $row['score_set'],
	'GAMEDESC' => $row['game_desc'],
	'SCORE' => $row['score_game'],
	'DATEHIGH' => create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'])
	));
 }
}
if ($arcade_config['scorerow_position']=='right')
 {
 $template->assign_block_vars('switch_right',array()); } else {
 $template->assign_block_vars('switch_left',array());
 }

$avatar_img = '';
if ( $user_avatar_type && $user_allowavatar )
{
switch( $user_avatar_type )
 {
  case USER_AVATAR_UPLOAD:
   $avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" border="0" hspace="20" align="center" valign="center" onload="resize_avatar(this)"/>' : '';
   break;
  case USER_AVATAR_REMOTE: 
   $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center"  onload="resize_avatar(this)"/>' : '';
   break;
  case USER_AVATAR_GALLERY: 
   $avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center"  onload="resize_avatar(this)"/>' : '';
   break;
  }
}

if ( empty($avatar_img) )
 {
  $avatar_img = '<img src="images/arcades/noavatar.gif" alt="Aucun Avatar" border="0" />';
 }

if ($arcade_config['display_winner_avatar']) {
if ($arcade_config['winner_avatar_position']=='right') {
	 $template->assign_block_vars('avatar_best_player_right',array()); } else {
	 $template->assign_block_vars('avatar_best_player_left',array());
 }

$admin_link_modo = (( $userdata['user_level'] == ADMIN) OR ( $userdata['user_level'] == MOD )) ? '<a href="modo_arcade_comments.' . $phpEx . '?mode=edit&gid=' .$gid.'&sid=' . $userdata['session_id'] . '"><img src=templates/' . $theme['template_name'] . '/images/commentedit.gif border="0"></a>' : '';
$modo_admin_record  = (( $userdata['user_level'] == ADMIN) OR ( $userdata['user_level'] == MOD )) ? '<a href="modoadminrecord.' . $phpEx . '?mode=edit&gid=' .$gid.'&sid=' . $userdata['session_id'] . '"><img src=templates/' . $theme['template_name'] . '/images/supprecord.gif border="0"></a>' : '';
make_arcadejumpbox('games.'.$phpEx);

$template->assign_vars(array(
  'U_PROFIL' => $profil,
  'WIDTH' => $width,
  'L_ACTUAL_WINNER' => $lang['Actual_winner'],
  'BEST_USER_NAME' => $best_user,
	'BEST_SCORE' => ( $user_record != 0 ) ? '<font color="green"><b>' . $user_record . '</b></font>' : '<font color="red"><b>' . $lang['no_record'] . '</b></font>',
	'COMMENTS' => $comment,
  'EDITCOMMENT' => $admin_link_modo,
	'MODOADMINRECORD' => $modo_admin_record,
  'COURONNE' => $couronne,
  'FIRST_AVATAR' => $avatar_img)
  );
}

if ($arcade_config['topstats_seeg'])
{
include($phpbb_root_path . 'topstatarcade.'.$phpEx);
}
if ($arcade_config['champ_seeg'])
{
include($phpbb_root_path . 'championnatarcade.'.$phpEx);
}
if ($arcade_config['heading_seeg'])
{
include($phpbb_root_path . 'headingarcade.'.$phpEx);
}
if ($arcade_config['whoisplay_seeg'])
{
include($phpbb_root_path . 'whoisplaying.'.$phpEx);
}
if (($arcade_config['cat_seeg']) && ($userdata['session_logged_in']))
{
include($phpbb_root_path . 'arcade_cat.'.$phpEx);
}

if (($arcade_config['use_arcade_vote']==1) && ($userdata['session_logged_in']) || ($arcade_config['use_arcade_vote']==1) && (!$userdata['session_logged_in']) && ($arcade_config['auths_vote_hidden'] ))
{
	$template->assign_block_vars('use_arcade_vote',array()) ;
	include($phpbb_root_path . 'arcade_vote.'.$phpEx);
}

 $width= 100;

 $sql = "SELECT game_ultimate_highscore, game_ultimate_highuser, game_ultimate_highdate FROM ". GAMES_TABLE ." WHERE game_id = ". $gid ." LIMIT 0,1;";
 $result1 = $db->sql_query($sql);
 $row1 = $db->sql_fetchrow($result1);
 $game_ultimate_highscore = $row1['game_ultimate_highscore'];
 $game_ultimate_highdate = $row1['game_ultimate_highdate'];
 $game_ultimate_highuser = $row1['game_ultimate_highuser'];
 if($game_ultimate_highuser != 0)
  {
    $sql = "SELECT username, user_id, user_level, user_avatar_type, user_allowavatar, user_avatar FROM ". USERS_TABLE ." WHERE `user_id` = '" . $game_ultimate_highuser . "' LIMIT 0,1;";
    
    	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
	//-- fin mod : rank color system -----------------------------------------------
    
    $result2 = $db->sql_query($sql);
    while($row2 = $db->sql_fetchrow($result2) )
    {
     $game_ultimate_user_id = $row2['user_id'];
       $style_color = $rcs->get_colors($row2);
     //$style_color = user_color($row2['username'], $row2['user_level']);
     if ( $row2['user_id'] == ANONYMOUS ) {
		 $game_ultimate_username = $row2['username'];
     } else {
     $game_ultimate_username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row2['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row2['username'] . '" title="' . $lang['Read_profile'] .' '. $row2['username'] . '"' . $style_color .'>' . $row2['username'] . '</a>';
     }
     $game_ultimate_avatar = $row2['user_avatar'];
     $game_ultimate_avatar_type = $row2['user_avatar_type'];
     $game_ultimate_allowavatar = $row2['user_allowavatar'];
    }
   } else {
     $game_ultimate_username = '';
   }

//AVATAR
$avatar_img = ''; 
if ( $game_ultimate_avatar_type && $game_ultimate_allowavatar ) 
 { 
	switch( $game_ultimate_avatar_type ) 
	 { 
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $game_ultimate_avatar . '" width="'. $width .'" alt="Voir le profil du Joueur" title="Voir le profil du Joueur" border="0" />' : '';
			break;
	 }
 }

if ( empty($avatar_img) ) 
 { 
   $avatar_img = '<img src="images/arcades/noavatar.gif" width="'. $width .'" alt="Aucun Avatar" title="Aucun Avatar" border="0" />'; 
 }

   $profil = append_sid("profile.$phpEx?mode=viewprofile&amp;". POST_USERS_URL .'='. $game_ultimate_user_id );
   $date_ultimate = "<nobr>" . create_date( $board_config['default_dateformat'] , $game_ultimate_highdate , $board_config['board_timezone'] ) . "</nobr>";

if ($arcade_config['display_ultime_winner_avatar']) {
if ($arcade_config['winner_ultime_avatar_position']=='right') {
	 $template->assign_block_vars('ultime_avatar_best_player_right',array()); } else {
	 $template->assign_block_vars('ultime_avatar_best_player_left',array());
 }

$template->assign_vars(array(
  'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
  'ULTIMATE_HIGHSCORE' => ( $game_ultimate_highscore != 0 ) ? '<font color="green"><b>' . $game_ultimate_highscore . '</b></font>' : '<font color="red"><b>' . $lang['no_record'] . '</b></font>',
  'ULTIMATEHIGHUSER' => ( $game_ultimate_highuser != 0 ) ? '' . $game_ultimate_username . '' : '' ,
  'ULTIMATEDATEHIGH' => ( $game_ultimate_highuser != 0 ) ? '' . $date_ultimate . '' : '',
  'ULTIMATE_AVATAR' => $avatar_img)
  );
}

//
// Output page header
$page_title = $lang['arcade_game'];
if ($game_cheatcontrol)
{
   include($phpbb_root_path . 'includes/page_header_games.'.$phpEx);
} else {
   include($phpbb_root_path . 'includes/page_header.'.$phpEx);
}
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

?>
<?php
/***************************************************************************
*                               statarcade.php
*                              ----------------
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
include( $phpbb_root_path . 'includes/functions_arcade.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);

$uid = get_var2(array('name'=>'uid', 'intval'=>true, 'default'=>0 ));

if( $uid == 0 )
{
	message_die(GENERAL_ERROR, "Utilisateur inconnu", ''); 
}

$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_STATARCADES);
init_userprefs($userdata);
//
// End session management
//
// Start auth check
//

$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

if ( !$userdata['session_logged_in'] )
{
	header($header_location . append_sid("login.$phpEx?redirect=statarcade.$phpEx", true));
	exit;
}
//
// End of auth check
//

//chargement du template
$template->set_filenames(array(
   'body' => 'statarcade_body.tpl')
   );

$arcade_config = array();
$arcade_config = read_arcade_config();

$sql = "SELECT username, user_id, user_level FROM " . USERS_TABLE . " WHERE user_id = " . $uid ;

//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------


if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la table users", '', __LINE__, __FILE__, $sql); 
}
$row = $db->sql_fetchrow($result);

//$style_color = user_color($row['username'], $row['user_level']);
  $style_color = $rcs->get_colors($row);
  
  
if ( $row['user_id'] == ANONYMOUS ){
$statuser = $row['username'];
} else {
$statuser = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
}

$nbcol = 2 ;

//récupération de la liste des catégories privées auxquelles l'utilisateur à acces
$liste_cat_auth = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'view');
if( $liste_cat_auth == '' ) $liste_cat_auth = "''";

$sql = "SELECT COUNT(*) as nbtot FROM " . SCORES_TABLE . " s, " . GAMES_TABLE . " g  WHERE s.game_id = g.game_id AND g.arcade_catid IN ($liste_cat_auth) AND user_id = " . $uid ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la table des scores", '', __LINE__, __FILE__, $sql);
}
if ($row=$db->sql_fetchrow($result))
{
	$total_games = $row['nbtot'];
}
else
{
	$total_games = 0;
}

$start = get_var2(array('name'=>'start', 'intval'=>true ));
$limit_sql = ( intval($arcade_config['stat_par_page'])>0 ) ? " LIMIT $start," . intval($arcade_config['stat_par_page']) : '';

$sql = "SELECT s.*, g.* FROM " . SCORES_TABLE . " s LEFT JOIN " . GAMES_TABLE . " g ON g.game_id = s.game_id WHERE g.arcade_catid IN ($liste_cat_auth) AND s.user_id = " . $uid . " ORDER BY g.game_name ASC $limit_sql";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder aux tables users/scores/games", '', __LINE__, __FILE__, $sql); 
}

$gamelist = array();
$liste_id = '';
while ($row=$db->sql_fetchrow($result))
{
	$gamelist[] = $row ;
	$liste_id .= ( $liste_id != '' ) ? ', ' : '';
	$liste_id .= "'" . $row['game_id'] . "'" ;
}

$games_par_page = intval($arcade_config['stat_par_page']);
$where_sql = ( $liste_id != '' ) ? " AND s1.game_id IN ( $liste_id )" : '';

$sql = "SET OPTION SQL_BIG_SELECTS=1 ";
$db->sql_query($sql) ;
$sql = "SELECT count(*) as pos, s1.game_id , g.game_highuser, g.game_name
      FROM " . SCORES_TABLE . " s1 left join " . SCORES_TABLE . " s2 ON s1.score_game >= s2.score_game AND s1.game_id = s2.game_id
      LEFT JOIN " . GAMES_TABLE . " g on g.game_id = s1.game_id WHERE s2.user_id = $uid
      AND (( s1.score_game > s2.score_game ) or (s1.user_id = $uid )) AND g.game_highscore_type = 0 $where_sql
      GROUP BY s1.game_id
      UNION
      SELECT count(*) as pos, s1.game_id , g.game_highuser, g.game_name
      FROM " . SCORES_TABLE . " s1 left join " . SCORES_TABLE . " s2 ON s1.score_game <= s2.score_game AND s1.game_id = s2.game_id
      LEFT JOIN " . GAMES_TABLE . " g on g.game_id = s1.game_id WHERE s2.user_id = $uid
      AND ( (s1.score_game < s2.score_game) or (s1.user_id = $uid )) AND g.game_highscore_type = 1 $where_sql
      GROUP BY s1.game_id";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des scores", '', __LINE__, __FILE__, $sql); 
}
while ( $row = $db->sql_fetchrow($result) )
{
	$tbpos[ $row['game_id'] ] = $row['pos'] ;
	$tbhighuser[ $row['game_id'] ] = $row['game_highuser'] ;
}

$fini = false ;

if (!$row = $db->sql_fetchrow($result) ) $fini=true ;
$template->assign_vars(array(
	'PAGINATION' => generate_pagination(append_sid("statarcade.$phpEx?uid=$uid"), $total_games, $games_par_page, $start),
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $games_par_page ) + 1 ), ceil( $total_games / $games_par_page )),
	'URL_ARCADE' => '<nobr><a class="cattitle" href="' . append_sid("arcade.$phpEx") . '">' . $lang['lib_arcade'] . '</a></nobr> ',
	'URL_BESTSCORES' => '<nobr><a class="cattitle" href="' . append_sid("toparcade.$phpEx") . '">' . $lang['best_scores'] . '</a></nobr> ',			
	'L_STATS' => $lang['statuser'] . ' ' . $statuser ) 
	);

$nbjeux = count($gamelist);	
$i = 0;
$fini = ( $i == $nbjeux ) ? true : false ;
while( !$fini )
{
   $template->assign_block_vars('blkligne', array() ) ;
   for ( $cg = 1 ; $cg <= $nbcol ; $cg++ )
	{
	 //mise en forme de la colonne
    $template->assign_block_vars('blkligne.blkcolonne', array() ) ;
		if (!$fini)
		{
		 if ( $gamelist[$i]['score_set'] != 0 )
		 {
			$min = intval( $gamelist[$i]['score_time'] / 60) ;
			$sec = $gamelist[$i]['score_time'] - ( $min * 60 ) ;	
			$scoremoy = round( $gamelist[$i]['score_time'] / $gamelist[$i]['score_set'] ) ;
			$minmoy = intval( $scoremoy / 60) ;
			$secmoy = $scoremoy - ( $minmoy * 60 ) ;
		 }
		    $pos = ( isset($tbpos[ $gamelist[$i]['game_id'] ]) ) ? $tbpos[ $gamelist[$i]['game_id'] ] : 1 ;
 			$template->assign_block_vars('blkligne.blkcolonne.blkgame', array(
			'GAMENAME' => '<nobr><a class="cattitle" href="' . append_sid("games.$phpEx?gid=" . $gamelist[$i]['game_id'] ) . '">' . $gamelist[$i]['game_name'] . '</a></nobr> ',
			'L_NBSET' => $lang['statnbset'],
			'NBSET' =>  ( $gamelist[$i]['score_set'] == 0 ) ? "n/a" : $gamelist[$i]['score_set'],
			'L_TPSSET' => $lang['stattottime'],
			'TPSSET' => ( $gamelist[$i]['score_set'] == 0 ) ? "n/a" : ( ($min >0 ) ? $min . " " . $lang['statminute'] . "," . $sec . " " . $lang['statseconde'] : $sec . " " . $lang['statseconde'] ),
			'L_HIGHSCR' => $lang['stathighscore'],
			'HIGHSCR' => $gamelist[$i]['score_game'],
			'L_DATHIGHSCR' => $lang['statdatehigh'],
			'DATHIGHSCR' => create_date( $board_config['default_dateformat'] , $gamelist[$i]['score_date'] , $board_config['board_timezone'] ),
			'L_POSGAME' => $lang['statposition'],
			'POSGAME' => ( $pos == 1 ) ? $pos . "er" : ( ( $pos == 2 ) ? $pos . "nd" : $pos . "ème" ),
			'IMGFIRST' => ( $tbhighuser[ $gamelist[$i]['game_id'] ] == $uid ) ? "<img src='templates/" . $theme['template_name'] . "/images/couronne.gif' align='absmiddle'>" : "" ,
			'L_TPSMOY' => $lang['statmedtime'],
			'TPSMOY' =>  ( $gamelist[$i]['score_set'] == 0 ) ? "n/a" : ( ($minmoy >0 ) ?  $minmoy . " " . $lang['statminute'] . "," . $secmoy . " " . $lang['statseconde'] : $secmoy . " " . $lang['statseconde'] ) )
			);
			
  		$i++;
			$fini = ( $i == $nbjeux ) ? true : false ;
		}// fin if !fini
  }
}

//
// Output page header
$page_title = $lang['statarcade_user'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);	
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
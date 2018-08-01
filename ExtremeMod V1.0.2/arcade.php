<?php
/***************************************************************************
 *                                arcade.php
 *                            -------------------
 *   Commencé le                : Samedi,17 Mai, 2003
 *   Par : giefca - http://www.gf-phpbb.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Affichage de la liste des jeux arcades.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
define('ARCADE', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);
include($phpbb_root_path . 'includes/functions_jumpbox_arcade.'.$phpEx);
require($phpbb_root_path . 'gf_funcs/gen_funcs.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ARCADES);
init_userprefs($userdata);
//
// End session management
//

$arcade_config = array();
$arcade_config = read_arcade_config();
//
// Start auth check
//
if (( !$userdata['session_logged_in']) AND (!$arcade_config['auths_play']))
{
	$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
	header($header_location . append_sid("login.$phpEx?redirect=arcade.$phpEx", true));
	exit;
}
//
// End of auth check
//

$sessdo = get_var2(array('name'=>'sessdo', 'method'=>'POST', 'default'=>''));

// Est-on à l'intérieur d'un jeu ?
if ($sessdo != '')
{
  $gamename = get_var2(array('name'=>'gamename', 'method'=>'POST', 'default'=>''));
  $microone = get_var2(array('name'=>'microone', 'method'=>'POST', 'default'=>''));
  $id = get_var2(array('name'=>'id', 'method'=>'POST', 'default'=>''));
  $score = get_var2(array('name'=>'score', 'method'=>'POST', 'default'=>''));
  $fakekey = get_var2(array('name'=>'fakekey', 'method'=>'POST', 'default'=>''));
  $gametime = get_var2(array('name'=>'gametime', 'method'=>'POST', 'default'=>''));

  $header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

  switch($sessdo)
  {
	case 'sessionstart' :
		//Récupération de l'id du jeu.
		$sql = "SELECT g.game_id, gh.hash_date, gh.gamehash_id FROM " . GAMES_TABLE . " g, " . GAMEHASH_TABLE . " gh WHERE g.game_id = gh.game_id AND gh.user_id = '" . $userdata['user_id'] . "' AND game_scorevar = '$gamename' ORDER BY gh.hash_date DESC" ;
		if( !($result = $db->sql_query($sql)) )
		{
	   	$connStatus = 0;
	   	echo "&connStatus=$connStatus";
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des jeux", '', __LINE__, __FILE__, $sql);
			exit;
		}
		if( !$row = $db->sql_fetchrow($result))
		{
	   	$connStatus = 0;
	   	echo "&connStatus=$connStatus";
			message_die(GENERAL_ERROR, "Aucun jeu ne correspond à cette variable score : $gamename");
			exit;
		}

		$sql = "DELETE FROM " . GAMEHASH_TABLE . " WHERE gamehash_id = '" . $row['gamehash_id'] . "'";
		$db->sql_query($sql);

		$gamehash_id = md5(uniqid($user_ip)) ;
		$sql = "INSERT INTO " . GAMEHASH_TABLE . " ( gamehash_id , game_id , user_id , hash_date ) VALUES ( '$gamehash_id' , '" . $row['game_id'] . "' , '" . $userdata['user_id'] . "' , '" . time() . "')" ;
		if( !($db->sql_query($sql)) )
		{
	   	$connStatus = 0;
	   	echo "&connStatus=$connStatus";
			message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des hash game", '', __LINE__, __FILE__, $sql);
			exit;
		}
		$sql = "UPDATE " . GAMES_TABLE . " SET game_set = game_set+1 WHERE game_id =  '" . $row['game_id'] . "' " ;
		$db->sql_query($sql) ;

   	$connStatus = 1;
   	$gametime = time();
   	$initbar = $gamename . '|' . $gamehash_id;
   	$lastid = $row['game_id'];
   	echo "&connStatus=$connStatus&gametime=$gametime&initbar=$initbar&lastid=$lastid&val=x";
		exit;
	 break;
	case 'permrequest' :
  	$validate = 1;
  	$microone = $score . '|'. $fakekey;
  	echo "&validate=$validate&microone=$microone&val=x";
		exit;
	 break;
	 
	case 'burn' :
   	$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
		$tbinfos = explode('|',$microone);
		$newhash = substr( $tbinfos[2] , 24 , 8 ) . substr( $tbinfos[2] , 0 , 24 );
		header($header_location . append_sid("proarcade.$phpEx?" . $tbinfos[1] . "=" . $tbinfos[0] . "&gid=$id&newhash=$newhash&hashoffset=8&settime=$gametime&gpaver=GFARV2", true));
		exit;
	}
}

// Est-on sur la liste des catégories ou des jeux
$arcade_catid = get_var2(array('name'=>'cid', 'intval'=>true ));
$start = get_var2(array('name'=>'start', 'intval'=>true ));

//récupération de la liste des catégories privées auxquelles l'utilisateur à acces
$liste_cat_auth = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'view');
if( $liste_cat_auth == '' ) $liste_cat_auth = "''";

$order_by = '';
switch ( $arcade_config['game_order'])
{
	case 'Alpha':
		$order_by = ' game_name ASC ';
		break;
	case 'Popular':
		$order_by = ' game_set DESC ';
		break;
	case 'Fixed':
		$order_by = ' game_order ASC ';
		break;
	case 'Random':
		$order_by = ' RAND() ';
		break;
	case 'News':
		$order_by = ' game_id DESC ';
		break;
	default :
		$order_by = ' game_order ASC ';
		break;
 }

/*--------------------------------------------------/
/ Doit-on afficher et récuperer la liste des favoris ?
/---------------------------------------------------*/
$favori = $HTTP_GET_VARS['favori'];
$delfavori = $HTTP_GET_VARS['delfavori'];
$numfav=0;

if ($actfav=$favori+$delfavori)
 {
$sql = "SELECT * from ".ARCADE_FAV_TABLE." where user_id= ".$userdata['user_id'];
if( !($result = $db->sql_query($sql)) )
 {
	message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des favoris", '', __LINE__, __FILE__, $sql);
 }
while ($row = $db->sql_fetchrow($result))
 {
  if ($actfav==$row['game_id']) $numfav=1;
	$nbfav++;
 }

if( $favori and $nbfav >= $arcade_config['nbr_games_fav'] and $arcade_config['nbr_games_fav'] <>-1)
 {
	$message = $lang['non_atorized_fav'] . "<br /><br />" . sprintf($lang['Click_return_arcade'], "<a href=\"" . append_sid("arcade.$phpEx") . "\">", "</a>") . "<br />";
	message_die(GENERAL_MESSAGE, $message);
 }
 
if ($numfav==0 and $favori and ($nbfav < $arcade_config['nbr_games_fav'] or $arcade_config['nbr_games_fav'] ==-1))
 {
  $sql = "INSERT INTO ". ARCADE_FAV_TABLE ." VALUES ('','".$userdata['user_id']."','$favori')";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des favoris", '', __LINE__, __FILE__, $sql);
	}
 }
  elseif($delfavori)
 {
	$sql = "DELETE FROM ". ARCADE_FAV_TABLE ." where user_id= ".$userdata['user_id']." AND game_id= ".$delfavori;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des favoris", '', __LINE__, __FILE__, $sql);
	}
 }
}

// Si le quota est renseigné, on l'affiche, avec le nb de parties restantes
if ($arcade_config['quota_games'] != '')
{
  // On lit les données du joueur : nb de parties et date
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
   // Si la date de la dernière partie est antérieure à la date du jour, on met le score à 0 et la date du jour
   // (pour éviter une remise à 0 inutile du score à chaque visite de la page dans la même journée...)
   // Le reste à jouer = le quota si on a changé de jour, sinon, c'est le quota moins le nb de parties jouées
   if ($lastuserdate < $formatdate)
   {
    $sql = "UPDATE " . USERS_TABLE . " set user_nb_game = 0, user_date_game = $formatdate WHERE user_id = " . $userdata['user_id'];
    if( !($result = $db->sql_query($sql)) )
    {
     message_die(GENERAL_ERROR, "Mise a Zero du compteur impossible", '', __LINE__, __FILE__, $sql);
    }
   	$reste = $arcade_config['quota_games'];
    } else {
   	$reste = $arcade_config['quota_games'] - $nb;
    }

	 $template->assign_block_vars('use_quota_mod', array(
      'L_QUOTA1' => $lang['quota1'],
      'L_QUOTA' => $lang['quota'],
      'GAMEQUOTA' => $arcade_config['quota_games'],
      'L_QUOTA_RESTE' => $lang['quota_reste'],
      'L_QUOTA_RESTE2' => $lang['quota_reste2'],
      'GAMEEND' => ( $reste < 0 ) ? 0 : $reste)
      );
}

/*--------------------------------------------------/
/ Doit-on afficher la liste des catégories ?
/---------------------------------------------------*/
$games_par_categorie = $arcade_config['category_preview_games'] ; //Nombre de jeux affichés en preview pour chaque catégorie.

$mode = $HTTP_GET_VARS['mode'];
if (( $arcade_catid == 0 ) and ( $arcade_config['use_category_mod'] ) and ( $mode!='favoris' ))
 {
 //chargement du template
 $template->set_filenames(array(
   'body' => 'arcade_cat_body.tpl')
	 );

 $template->assign_vars(array(
	 'ARCADE_COL' => ($arcade_config['use_fav_category'])? 9:8,
	 'ARCADE_COL3' => ($arcade_config['use_fav_category'])? 6:5,
	 'FAV' => $lang['fav'],
	 'U_CFI_JSLIB' => $phpbb_root_path . 'templates/collapsible_arcade.js',
	 'CFI_COOKIE_NAME' => get_cfi_cookie_name(),
	 'COOKIE_PATH' => $board_config['cookie_path'],
	 'COOKIE_DOMAIN' => $board_config['cookie_domain'],
	 'COOKIE_SECURE' => $board_config['cookie_secure'],
	 'IMG_UP_ARROW' => $phpbb_root_path . $images['up_arrow'],
	 'IMG_DW_ARROW' => $phpbb_root_path . $images['down_arrow'],
	 'IMG_PLUS' => $phpbb_root_path . $images['icon_sign_plus'],
	 'IMG_MINUS' => $phpbb_root_path . $images['icon_sign_minus'],
	 'SPACER' => $phpbb_root_path . 'images/spacer.gif',
	 'MANAGE_COMMENTS' => '<nobr><a class="nav" href="' . append_sid("comments_list.$phpEx") . '" alt="'.$lang['comments'].'" title="'.$lang['comments'].'">' . $lang['comments'] . '</a></nobr> ',
	 'URL_ARCADE' => '<nobr><a class="nav" href="' . append_sid("arcade.$phpEx") . '" alt="'.$lang['lib_arcade'].'" title="'.$lang['lib_arcade'].'">' . $lang['lib_arcade'] . '</a></nobr> ',
	 'URL_BESTSCORES' => '<nobr><a class="nav" href="' . append_sid("toparcade.$phpEx") . '" alt="'.$lang['best_scores'].'" title="'.$lang['best_scores'].'">' . $lang['best_scores'] . '</a></nobr> ',
	 'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=$gid") . '" alt="'.$lang['scoreboard'].'" title="'.$lang['scoreboard'].'">' . $lang['scoreboard'] . '</a></nobr> ',
   	'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '" alt="'.$lang['Arcade_game_alea'].'" title="'.$lang['Arcade_game_alea'].'">' . $lang['Arcade_game_alea'] . '</a></nobr> ', 
	 'URL_SEARCH_GAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['search_games_arcade'].'" title="'.$lang['search_games_arcade'].'">' . $lang['search_games_arcade'] . '</a></nobr> ',
   	'SEARCHGAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['searchgames'] . '</a></nobr> ',
	 'LINKCATITTLE_ALIGN' => ( $arcade_config['linkcatittle_align'] == '0' ) ? 'left' : ( ( $arcade_config['linkcatittle_align'] == '1' ) ? 'center' : 'right'),
	 'L_CFI_OPTIONS' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_options']),
	 'L_CFI_OPTIONS_EX' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_options_ar']),
	 'L_CFI_CLOSE' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_close']),
	 'L_CFI_DELETE' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_delete']),
	 'L_CFI_RESTORE' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_restore']),
	 'L_CFI_SAVE' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_save']),
	 'L_CFI_EXPAND_ALL' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_Expand_all']),
	 'L_CFI_COLLAPSE_ALL' => str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_Collapse_all']),
	 'L_GAME' => $lang['games'],
	 'L_VOTES' => $lang['vote_game'],
	 'L_HIGHSCORE' => $lang['highscore'],
	 'L_YOURSCORE' => $lang['yourbestscore'],
   	'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
	 'L_DESC' => $lang['desc_game'],
	 'L_ARCADE' => $lang['lib_arcade'])
	 );

if ($mode!='favoris')
{
if (($arcade_config['favoris_see']) && ($userdata['session_logged_in']))
 {
	include($phpbb_root_path . 'arcade_favoris.'.$phpEx);
 }
}

$sql_and = "";
if (( !$userdata['session_logged_in']) AND ($arcade_config['auths_play'])) 
  {
   $sql_and = "AND game_auth_acc = 1";
  }

	$liste_jeux = array();
	$sql = "SELECT g.*, u.username, u.user_id, u.user_level, s.score_game, s.score_date,AVG(rating) AS average
	 FROM " . GAMES_TABLE . " g
	 LEFT JOIN " . USERS_TABLE . " u ON g.game_highuser = u.user_id
	 LEFT JOIN " . ARCADE_VOTE_TABLE . " v ON g.game_id = v.game_id
	 LEFT JOIN " . SCORES_TABLE . " s on s.game_id = g.game_id and s.user_id = " . $userdata['user_id'] . "
	 WHERE g.arcade_catid IN ($liste_cat_auth)
	 $sql_and
   GROUP BY g.game_id, g.game_highuser
	 ORDER BY g.arcade_catid, $order_by" ;
	 
	 //-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------
	 
	 

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result))
	{
	   $liste_jeux[$row['arcade_catid']][] = $row ;
	}

	$sql = "SELECT arcade_catid, arcade_cattitle, arcade_nbelmt, arcade_catauth FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid IN ($liste_cat_auth) ORDER BY arcade_catorder";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result))
	{
	$nbjeux = sizeof($liste_jeux[$row['arcade_catid']]);
	if ($nbjeux > 0) //On affiche une catégorie seulement si elle contient au moins 1 jeu.
	 {
    $cat_id = $row['arcade_catid'];

  if ( !$userdata['session_logged_in'])
   {
    $link_cat_other = "Voir tous les jeux autorisés de la catégorie";
   } else {
    $link_cat_other = sprintf($lang['Other_games'],$row['arcade_nbelmt']);
   }

$template->assign_block_vars('cat_row',array(
		'DISPLAY' => (is_category_collapsed($cat_id) ? '' : 'none'),
		'U_ARCADE' => append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ),
	  'LINKCAT_ALIGN' => ( $arcade_config['linkcat_align'] == '0' ) ? 'left' : ( ( $arcade_config['linkcat_align'] == '1' ) ? 'center' : 'right'),
		'L_ARCADE' => $link_cat_other,
		'CAT_NAME' => $row['arcade_cattitle'],
		'CAT_ID' => $row['arcade_catid'],
		'CATTITLE' => append_sid("arcade.$phpEx?cid=$cat_id"))
		);

  $nbjeux = ( $nbjeux < $games_par_categorie ) ? $nbjeux : $games_par_categorie ;
	for ($i=0 ; $i< $nbjeux ; $i++)
	{
	if ( $liste_jeux[$row['arcade_catid']][$i]['arcade_catid'] == $cat_id )
	 {
		$game_id = $liste_jeux[$row['arcade_catid']][$i]['game_id'];
   }
  $game_pad_pic[1] = '<img src="templates/' . $theme['template_name'] . '/images/souris.gif" alt="'.$lang['souris'].'" title="'.$lang['souris'].'">'; 
  $game_pad_pic[2] = '<img src="templates/' . $theme['template_name'] . '/images/clavier.gif" alt="'.$lang['clavier'].'" title="'.$lang['clavier'].'">';
  $game_pad_pic[3] = '<img src="templates/' . $theme['template_name'] . '/images/sourisclavier.gif" alt="'.$lang['sourisclavier'].'" title="'.$lang['sourisclavier'].'">';

  //$style_color = user_color($liste_jeux[$row['arcade_catid']][$i]['username'], $liste_jeux[$row['arcade_catid']][$i]['user_level']);
  $style_color = $rcs->get_colors($liste_jeux[$row['arcade_catid']][$i]);
  
  if ( $liste_jeux[$row['arcade_catid']][$i]['user_id'] == ANONYMOUS ){
  $username = $liste_jeux[$row['arcade_catid']][$i]['username'];
  } else {
  $username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $liste_jeux[$row['arcade_catid']][$i]['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $liste_jeux[$row['arcade_catid']][$i]['username'] . '" title="' . $lang['Read_profile'] .' '. $liste_jeux[$row['arcade_catid']][$i]['username'] . '"' . $style_color .'>' . $liste_jeux[$row['arcade_catid']][$i]['username'] . '</a>';
  }

  $sql = "SELECT `game_ultimate_highscore`, `game_ultimate_highuser`, `game_ultimate_highdate` FROM ". GAMES_TABLE ." WHERE game_id LIKE ".$liste_jeux[$row['arcade_catid']][$i]['game_id']." LIMIT 0,1;";
  $result1 = $db->sql_query($sql);
  $row1 = $db->sql_fetchrow($result1);
  $game_ultimate_highscore = $row1['game_ultimate_highscore'];
  $game_ultimate_highdate = $row1['game_ultimate_highdate'];
  $game_ultimate_highuser = $row1['game_ultimate_highuser'];

if($game_ultimate_highuser != 0)
 {
  $sql = "SELECT username, user_id, user_level FROM ". USERS_TABLE ." WHERE `user_id` = '".$game_ultimate_highuser."' LIMIT 0,1;";
  
  //-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------
  
  $result2 = $db->sql_query($sql);
  while($row2 = $db->sql_fetchrow($result2) ) {
     
     $style_color = $rcs->get_colors($row2);
          
     
     if ( $row2['user_id'] == ANONYMOUS ) {
		 $game_ultimate_username = $row2['username'];
     } else {
     $game_ultimate_username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row2['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row2['username'] . '" title="' . $lang['Read_profile'] .' '. $row2['username'] . '"' . $style_color .'>' . $row2['username'] . '</a>'; }
     }
     } else {
     $game_ultimate_username = '';
     }

	$template->assign_block_vars('cat_row.game_row',array(
		 'GAME_ID' => $game_id,
		 'DISPLAY' => (is_category_collapsed($cat_id) ? 'none' : ''),
     'GAME_PAD_PIC' => $game_pad_pic[$liste_jeux[$row['arcade_catid']][$i]['game_pad']],
		 'GAMENAME' => $liste_jeux[$row['arcade_catid']][$i]['game_name'],
	   'GAMENOTE' => round($liste_jeux[$row['arcade_catid']][$i]['average'],1),
		 'GAMELINK' => '<nobr><a href="' . append_sid("games.$phpEx?gid=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) . '" alt="Cliquer ici pour ouvrir '.$liste_jeux[$row['arcade_catid']][$i]['game_name'].'" title="Cliquer ici pour ouvrir '.$liste_jeux[$row['arcade_catid']][$i]['game_name'].'">' . $liste_jeux[$row['arcade_catid']][$i]['game_name'] . '</a></nobr> ',
		 'GAMEPOPUP' => "<nobr><a href onClick=\"window.open('". append_sid("games.$phpEx?gid=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) ."', 'Jouez', 'HEIGHT=".($liste_jeux[$row['arcade_catid']][$i]['game_height']+250).", scrollbars=yes, scroll=yes, resizable=yes, WIDTH=".($liste_jeux[$row['arcade_catid']][$i]['game_width']+10)."')\" alt='Cliquer ici pour ouvrir " . $liste_jeux[$row['arcade_catid']][$i]['game_name'] . " dans une nouvelle fenêtre' title='Cliquer ici pour ouvrir " . $liste_jeux[$row['arcade_catid']][$i]['game_name'] . " dans une nouvelle fenêtre'>Nouvelle Fenêtre</a></nobr>",
		 'GAMEPIC' => ( $liste_jeux[$row['arcade_catid']][$i]['game_pic'] != '' ) ? "<a href='" . append_sid("games.$phpEx?gid=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) . "' alt='".$liste_jeux[$row['arcade_catid']][$i]['game_name']."' title='".$liste_jeux[$row['arcade_catid']][$i]['game_name']."'><img src='" . "games/pics/" . $liste_jeux[$row['arcade_catid']][$i]['game_pic'] . "' align='absmiddle' border='0' width='49' height='49' vspace='2' hspace='2'></a>" : '' ,
		 'GAMESET' => ( $liste_jeux[$row['arcade_catid']][$i]['game_set'] != 0  ) ? $lang['game_actual_nbset'] . $liste_jeux[$row['arcade_catid']][$i]['game_set'] : '',
		 'HIGHSCORE' => $liste_jeux[$row['arcade_catid']][$i]['game_highscore'],
		 'YOURHIGHSCORE' => $liste_jeux[$row['arcade_catid']][$i]['score_game'],
		 'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
     'NO_ULTIMATE_SCORE' => ( $game_ultimate_highscore == 0 ) ? $lang['no_record'] : '',
     'ULTIMATE_HIGHSCORE' => $game_ultimate_highscore,
     'ULTIMATEHIGHUSER' => ( $game_ultimate_highuser != 0 ) ? '' . $game_ultimate_username . '' : '' ,
     'ULTIMATEDATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $game_ultimate_highdate , $board_config['board_timezone'] ) . "</nobr>",
		 'NORECORD' => ( $liste_jeux[$row['arcade_catid']][$i]['game_highscore'] == 0 ) ? $lang['no_record'] : '',
		 'HIGHUSER' => ( $liste_jeux[$row['arcade_catid']][$i]['game_highuser'] != 0 ) ? '' . $username . '' : '' ,
     'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) . '" alt="' . $lang['scoreboard'] . " du jeu " .$liste_jeux[$row['arcade_catid']][$i]['game_name'] . '" title="' . $lang['scoreboard'] . " du jeu " .$liste_jeux[$row['arcade_catid']][$i]['game_name'] . '">' . "<img src='templates/" . $theme['template_name'] . "/images/scoreboard.gif' . ' align='absmiddle' border='0' alt='" . $lang['scoreboard'] . " du jeu " . $liste_jeux[$row['arcade_catid']][$i]['game_name'] . "' title='" . $lang['scoreboard'] . " du jeu " . $liste_jeux[$row['arcade_catid']][$i]['game_name'] . "'>" . '</a></nobr> ',
		 'GAMEID' => $liste_jeux[$row['arcade_catid']][$i]['game_id'],
		 'DATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $liste_jeux[$row['arcade_catid']][$i]['game_highdate'] , $board_config['board_timezone'] ) . "</nobr>",
		 'YOURDATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $liste_jeux[$row['arcade_catid']][$i]['score_date'] , $board_config['board_timezone'] ) . "</nobr>",
		 'IMGFIRST' => ( $liste_jeux[$row['arcade_catid']][$i]['game_highuser'] == $userdata['user_id'] ) ? "&nbsp;&nbsp;<img src='templates/" . $theme['template_name'] . "/images/couronne.gif' align='absmiddle'>" : "" ,
		 'COUT' => ($arcade_config['use_points_mod']==0 || $arcade_config['use_points_pay_mod']==0)?'':  (($arcade_config['pay_all_games']==1 && $arcade_config['use_points_pay_charging'] && $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($arcade_config['points_pay']),$board_config['points_name']) : (($arcade_config['pay_all_games']==1)? sprintf($lang['game_cost'],$arcade_config['points_pay'],$board_config['points_name']): (($arcade_config['pay_all_games']==0 && $liste_jeux[$row['arcade_catid']][$i]['point_pay']==0)?'': (($arcade_config['pay_all_games']==0 && $arcade_config['use_points_pay_charging'] && $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($liste_jeux[$row['arcade_catid']][$i]['point_pay']/2),$board_config['points_name']) : (($arcade_config['pay_all_games']==0)? sprintf($lang['game_cost'],$liste_jeux[$row['arcade_catid']][$i]['point_pay'],$board_config['points_name']): ''))))),
		 'PRIZE' => ($arcade_config['use_points_mod']==0 || $arcade_config['use_points_win_mod']==0)?'': (($arcade_config['prize_all_games']==1)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']): (($arcade_config['prize_all_games']==2 && $liste_jeux[$row['arcade_catid']][$i]['point_pay']>0 && $arcade_config['points_winner']>0)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']): (($arcade_config['prize_all_games']==0 && $liste_jeux[$row['arcade_catid']][$i]['point_prize']>0)? sprintf($lang['game_prize'],$liste_jeux[$row['arcade_catid']][$i]['point_prize'],$board_config['points_name']): ''))),
		 'GAMEDESC' => $liste_jeux[$row['arcade_catid']][$i]['game_desc'])
		 );

include_once($phpbb_root_path . 'includes/functions_arcade_favoris.'.$phpEx);

$favtest = favoris_inserted($userdata['user_id'], $liste_jeux[$row['arcade_catid']][$i]['game_id']);
if (($favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('cat_row.game_row.no_fav', array(
  'DELFAVORI' => '<a href="' . append_sid("arcade.$phpEx?delfavori=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) .'" alt="'.$lang['del_fav'].'" title="'.$lang['del_fav'].'"><img src="' . append_sid("images/arcades/delfavs.gif").'" border=0></a>')
  );
}
elseif ((!$favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('cat_row.game_row.fav', array(
	'ADD_FAV' => ($arcade_config['use_fav_category'])?'<a href="' . append_sid("arcade.$phpEx?favori=" . $liste_jeux[$row['arcade_catid']][$i]['game_id'] ) .'" alt="'.$lang['add_fav'].'" title="'.$lang['add_fav'].'"><img src="' . append_sid("images/arcades/favs.gif").'" border=0></a>':'')	
  );
}
	if ( $liste_jeux[$row['arcade_catid']][$i]['game_highscore'] !=0 )
	 {
		$template->assign_block_vars('cat_row.game_row.recordrow',array());
	 }
	if ( $liste_jeux[$row['arcade_catid']][$i]['score_game'] !=0 )
	 {
		$template->assign_block_vars('cat_row.game_row.yourrecordrow',array());
	 }
  if ( $game_ultimate_highscore !=0 )
   {
    $template->assign_block_vars('cat_row.game_row.ultimaterecordrow',array()) ;
   }
	}
 }
}

if ($arcade_config['topstats_see'])
{
include($phpbb_root_path . 'topstatarcade.'.$phpEx);
}
if ($arcade_config['champ_see'])
{
include($phpbb_root_path . 'championnatarcade.'.$phpEx);
}
include($phpbb_root_path . 'championnat_equipe.'.$phpEx);
if ($arcade_config['heading_see'])
{
include($phpbb_root_path . 'headingarcade.'.$phpEx);
}
if ($arcade_config['whoisplay_see'])
{
include($phpbb_root_path . 'whoisplaying.'.$phpEx);
}
if (($arcade_config['cat_see']) && ($arcade_config['use_category_mod']) && ($userdata['session_logged_in']))
{
include($phpbb_root_path . 'arcade_cat.'.$phpEx);
}

//
// Output page header
$page_title = $lang['arcade'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
exit;
}

/*--------------------------------------------------/
/ Sinon, on affiche la liste des jeux ?
/---------------------------------------------------*/
$sql_where_acc = '';
$games_par_page = $arcade_config['games_par_page'] ;
$total_games = 0;

if ( !$userdata['session_logged_in'])
 {
  $limit = "";
 } else {
  $limit = " LIMIT $start,$games_par_page ";
 }

if ($arcade_config['use_category_mod'])
{
if ( !$userdata['session_logged_in'])
 {
  $sql_guest = "g.*,";
  $sql_guest_and = "LEFT JOIN " . GAMES_TABLE . " g ON a.arcade_catid = g.arcade_catid AND g.game_auth_acc = 1";
  $sql_guest_where = " WHERE a.arcade_catid = $arcade_catid AND a.arcade_catid IN ($liste_cat_auth) AND g.game_auth_acc = 1";
 } else {
  $sql_guest = "";
  $sql_guest_and = "";
  $sql_guest_where = " WHERE a.arcade_catid = $arcade_catid AND a.arcade_catid IN ($liste_cat_auth)";
 }

  $sql = "SELECT $sql_guest a.arcade_cattitle, a.arcade_nbelmt AS nbgames 
   FROM " . ARCADE_CATEGORIES_TABLE . " a 
   $sql_guest_and
	 $sql_guest_where ";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
	}
	if ( $row = $db->sql_fetchrow($result) or $mode=='favoris' )
	{
    $total_games = $row['nbgames'];
	} else {
	 message_die(GENERAL_MESSAGE,$lang['no_arcade_cat']);
	}
	  $template->assign_block_vars('use_category_mod', array());
  } else {
  	
  if ( !$userdata['session_logged_in'])
  {
    $sql_guest_nb = " WHERE game_auth_acc = 1";
  } else {
    $sql_guest_nb = "";
  }
	$sql = "SELECT COUNT(*) AS nbgames FROM " . GAMES_TABLE . " $sql_guest_nb";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
	}
	if ( $row = $db->sql_fetchrow($result))
	{
    $total_games = $row['nbgames'];
	}
}

//chargement du template
$template->set_filenames(array(
  'body' => 'arcade_body.tpl')
  );

$template->assign_vars(array(
	'URL_ARCADE' => '<nobr><a class="nav" href="' . append_sid("arcade.$phpEx") . '" alt="'.$lang['lib_arcade'].'" title="'.$lang['lib_arcade'].'">' . $lang['lib_arcade'] . '</a></nobr> ',
	'URL_BESTSCORES' => '<nobr><a class="nav" href="' . append_sid("toparcade.$phpEx") . '" alt="'.$lang['best_scores'].'" title="'.$lang['best_scores'].'">' . $lang['best_scores'] . '</a></nobr> ',
	'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=$gid") . '" alt="'.$lang['scoreboard'].'" title="'.$lang['scoreboard'].'">' . $lang['scoreboard'] . '</a></nobr> ',
	'URL_SEARCH_GAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['search_games_arcade'] . '</a></nobr> ',
  'SEARCHGAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['searchgames'] . '</a></nobr> ',
  'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '" alt="'.$lang['Arcade_game_alea'].'" title="'.$lang['Arcade_game_alea'].'">' . $lang['Arcade_game_alea'] . '</a></nobr> ',
	'MANAGE_COMMENTS' => '<nobr><a class="nav" href="' . append_sid("comments_list.$phpEx") . '" alt="'.$lang['comments'].'" title="'.$lang['comments'].'">' . $lang['comments'] . '</a></nobr> ',	
	'CATTITLE' => $row['arcade_cattitle'],
	'PAGINATION' => ($mode!='favoris')? generate_pagination(append_sid("arcade.$phpEx?cid=$arcade_catid"), $total_games, $games_par_page, $start):'',
	'PAGE_NUMBER' => ($mode!='favoris')? sprintf($lang['Page_of'], ( floor( $start / $games_par_page ) + 1 ), ceil( $total_games / $games_par_page )):'',
	'ARCADE_COL' => ($arcade_config['use_fav_category'])? 9:8,
	'ARCADE_COL1' => ($arcade_config['use_fav_category'])? 4:3,
	'ARCADE_COL3' => ($arcade_config['use_fav_category'])? 6:5,
	'FAV' => $lang['fav'],
	'L_GAME' => $lang['games'],
	'L_VOTES' => $lang['vote_game'],
  'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
	'L_HIGHSCORE' => $lang['highscore'],
	'L_YOURSCORE' => $lang['yourbestscore'],
	'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
	'L_DESC' => $lang['desc_game'],
	'L_ARCADE' => $lang['lib_arcade'])
	);

  if (($userdata['session_logged_in']) || (! $arcade_config['use_category_mod']))
  {
   $template->assign_block_vars('switch_pagination',array());
  }

  if (($mode!='favoris' && $userdata['session_logged_in']) || ($arcade_config['auths_play']))
  {
  if ($arcade_config['favoris_see'])
  {
	 include($phpbb_root_path . 'arcade_favoris.'.$phpEx);
  }

  if ((!$userdata['session_logged_in']) && $arcade_config['use_category_mod'])
  {
   $sql_where_acc = " WHERE g.arcade_catid = $arcade_catid AND g.arcade_catid IN ($liste_cat_auth) AND g.game_auth_acc = 1";
  } elseif ($userdata['session_logged_in'] && $arcade_config['use_category_mod']) {
   $sql_where_acc = " WHERE g.arcade_catid = $arcade_catid AND g.arcade_catid IN ($liste_cat_auth)";
  }

  if ((!$userdata['session_logged_in']) && (!$arcade_config['use_category_mod']))
  {
   $sql_where_acc = " WHERE g.game_auth_acc = 1";
  } elseif ($userdata['session_logged_in'] && (!$arcade_config['use_category_mod'])) {
   $sql_where_acc = "";
  }

 $game_pad_pic[1] = '<img src="templates/' . $theme['template_name'] . '/images/souris.gif" alt="'.$lang['souris'].'" title="'.$lang['souris'].'">'; 
 $game_pad_pic[2] = '<img src="templates/' . $theme['template_name'] . '/images/clavier.gif" alt="'.$lang['clavier'].'" title="'.$lang['clavier'].'">';
 $game_pad_pic[3] = '<img src="templates/' . $theme['template_name'] . '/images/sourisclavier.gif" alt="'.$lang['sourisclavier'].'" title="'.$lang['sourisclavier'].'">';

$sql = "SELECT g.*, u.username, u.user_id, u.user_level, s.score_game, s.score_date,AVG(rating) AS average
	 FROM " . GAMES_TABLE . " g
	 LEFT JOIN " . ARCADE_VOTE_TABLE . " v ON g.game_id = v.game_id
	 left join " . USERS_TABLE . " u ON g.game_highuser = u.user_id
	 LEFT JOIN " . SCORES_TABLE . " s on s.game_id = g.game_id and s.user_id = " . $userdata['user_id'] . "
   $sql_where_acc
   GROUP BY g.game_id, g.game_highuser
	 ORDER BY $order_by $limit";
	 
	//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------
	 
   if( !($result = $db->sql_query($sql)) )
   {
	   message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
   }

while( $row = $db->sql_fetchrow($result) )
{
  	
  //$style_color = user_color($row['username'], $row['user_level']);
  $style_color = $rcs->get_colors($row);
  
  
  if ( $row['user_id'] == ANONYMOUS ){
  $username = $row['username'];
  } else {
  $username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
  }

  $sql = "SELECT `game_ultimate_highscore`, `game_ultimate_highuser`, `game_ultimate_highdate` FROM ". GAMES_TABLE ." WHERE game_id LIKE ".$row['game_id']." LIMIT 0,1;";
  
  $result1 = $db->sql_query($sql);
  $row1 = $db->sql_fetchrow($result1);
  $game_ultimate_highscore = $row1['game_ultimate_highscore'];
  $game_ultimate_highdate = $row1['game_ultimate_highdate'];
  $game_ultimate_highuser = $row1['game_ultimate_highuser'];

if($game_ultimate_highuser != 0)
 {
  $sql = "SELECT username, user_id, user_level FROM ". USERS_TABLE ." WHERE `user_id` = '".$game_ultimate_highuser."' LIMIT 0,1;";
  
  
  //-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------
  
  $result2 = $db->sql_query($sql);
  while($row2 = $db->sql_fetchrow($result2) )
  {

  $style_color = $rcs->get_colors($row2);	
  //$style_color = user_color($row2['username'], $row2['user_level']);
  if ( $row2['user_id'] == ANONYMOUS ) {
	$game_ultimate_username = $row2['username'];
  } else {
  $game_ultimate_username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row2['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row2['username'] . '" title="' . $lang['Read_profile'] .' '. $row2['username'] . '"' . $style_color .'>' . $row2['username'] . '</a>'; }
  }
  } else {
  $game_ultimate_username = '';
  }

	$template->assign_block_vars('gamerow', array(
  'GAME_PAD_PIC' => $game_pad_pic[$row['game_pad']],
	'GAMENAME' => $row['game_name'],
	'GAMENOTE' => round($row['average'],1),
	'GAMESET' => ( $row['game_set'] != 0  ) ? $lang['game_actual_nbset'] . $row['game_set'] : '',
	'COUT' => ($arcade_config['use_points_mod']==0 || $arcade_config['use_points_pay_mod']==0)?'': (($arcade_config['pay_all_games']==1 && $arcade_config['use_points_pay_charging'] && $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($arcade_config['points_pay']),$board_config['points_name']) : (($arcade_config['pay_all_games']==1)? sprintf($lang['game_cost'],$arcade_config['points_pay'],$board_config['points_name']): (($arcade_config['pay_all_games']==0 && $row['point_pay']==0)?'': (($arcade_config['pay_all_games']==0 && $arcade_config['use_points_pay_charging'] && $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($row['point_pay']),$board_config['points_name']/2) : (($arcade_config['pay_all_games']==0)? sprintf($lang['game_cost'],$row['point_pay'],$board_config['points_name']): ''))))),
	'PRIZE' => ($arcade_config['use_points_mod']==0 || $arcade_config['use_points_win_mod']==0)?'':  (($arcade_config['prize_all_games']==1)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']): (($arcade_config['prize_all_games']==2 && $row['point_pay']>0)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']): (($arcade_config['prize_all_games']==0 && $row['point_prize']>0)? sprintf($lang['game_prize'],$row['point_prize'],$board_config['points_name']): ''))),
	'GAMEDESC' => $row['game_desc'],
  'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
  'NO_ULTIMATE_SCORE' => ( $game_ultimate_highscore == 0 ) ? $lang['no_record'] : '',
  'ULTIMATE_HIGHSCORE' => $game_ultimate_highscore,
  'ULTIMATEHIGHUSER' => ( $game_ultimate_highuser != 0 ) ? '' . $game_ultimate_username . '' : '' ,
  'ULTIMATEDATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $game_ultimate_highdate , $board_config['board_timezone'] ) . "</nobr>",
	'HIGHSCORE' => $row['game_highscore'],
	'YOURHIGHSCORE' => $row['score_game'],
	'NORECORD' => ( $row['game_highscore'] == 0 ) ? $lang['no_record'] : '',
	'HIGHUSER' => ( $row['game_highuser'] != 0 ) ? '' . $username . '' : '' ,
  'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=" . $row['game_id'] ) . '" alt="' . $lang['scoreboard'] . " du jeu " . $row['game_name'] . '" title="' . $lang['scoreboard'] . " du jeu " . $row['game_name'] .'">' . "<img src='templates/" . $theme['template_name'] . "/images/scoreboard.gif' . ' align='absmiddle' border='0' alt='" . $lang['scoreboard'] . " du jeu " . $row['game_name'] . "' title='" . $lang['scoreboard'] . " du jeu " . $row['game_name'] . "'>" . '</a></nobr> ',
  'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '">' . $lang['Arcade_game_alea'] . '</a></nobr> ',
	'GAMEID' => $row['game_id'],
	'DATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $row['game_highdate'] , $board_config['board_timezone'] ) . "</nobr>",
	'YOURDATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'] ) . "</nobr>",
	'IMGFIRST' => ( $row['game_highuser'] == $userdata['user_id'] ) ? "&nbsp;&nbsp;<img src='templates/" . $theme['template_name'] . "/images/couronne.gif' align='absmiddle'>" : "" ,
	'GAMEPIC' => ( $row['game_pic'] != '' ) ? "<a href='" . append_sid("games.$phpEx?gid=" . $row['game_id'] ) . "' alt='" . $row['game_name'] . "' title='" . $row['game_name'] . "'><img src='" . "games/pics/" . $row['game_pic'] . "' align='absmiddle' border='0' width='49' height='49'></a>" : '' ,
	'GAMELINK' => '<nobr><a href="' . append_sid("games.$phpEx?gid=" . $row['game_id'] ) . '" alt="Cliquer ici pour ouvrir ' . $row['game_name'] . '" title="Cliquer ici pour ouvrir ' . $row['game_name'] . '">' . $row['game_name'] . '</a></nobr> ',
	'GAMEPOPUP' => "<nobr><a href onClick=\"window.open('". append_sid("games.$phpEx?gid=" . $row['game_id'] ) ."', 'Jouez', 'HEIGHT=".($row['game_height']+250).",scrollbars=yes,scroll=yes,resizable=yes,WIDTH=".($row['game_width']+90)."')\"  alt='Cliquer ici pour ouvrir ".$row['game_name']." dans une nouvelle fenêtre' title='Cliquer ici pour ouvrir ".$row['game_name']." dans une nouvelle fenêtre'>Nouvelle Fenêtre</a></nobr>")
	);

include_once($phpbb_root_path . 'includes/functions_arcade_favoris.'.$phpEx);
$favtest = favoris_inserted($userdata['user_id'], $row['game_id']);
if (($favtest)&& ($userdata['session_logged_in']))
{
	$template->assign_block_vars('gamerow.no_fav', array(
  'DELFAVORI' => '<a href="' . append_sid("arcade.$phpEx?delfavori=" . $row['game_id'] ) .'" alt="'.$lang['del_fav'].'" title="'.$lang['del_fav'].'"><img src="' . append_sid("images/arcades/delfavs.gif").'" border=0></a>'));
  } elseif ((!$favtest)&& ($userdata['session_logged_in'])) {
	$template->assign_block_vars('gamerow.fav', array(
	'ADD_FAV' => ($arcade_config['use_fav_category'])?'<a href="' . append_sid("arcade.$phpEx?favori=" . $row['game_id'] ) .'" alt="'.$lang['add_fav'].'" title="'.$lang['add_fav'].'"><img src="' . append_sid("images/arcades/favs.gif").'" border=0></a>':''));
}

  if ( $row['game_highscore'] !=0 )
  {
	$template->assign_block_vars('gamerow.recordrow',array());
  }
  if ( $row['score_game'] !=0 )
  {
	$template->assign_block_vars('gamerow.yourrecordrow',array());
	}
  if ( $game_ultimate_highscore !=0 )
  {
  $template->assign_block_vars('gamerow.ultimaterecordrow',array()) ;
  }
 }
}
else 
{
include($phpbb_root_path . 'arcade_favoris.'.$phpEx);
}

if ($arcade_config['topstats_see'])
{
include($phpbb_root_path . 'topstatarcade.'.$phpEx);
}
if ($arcade_config['champ_see'])
{
include($phpbb_root_path . 'championnatarcade.'.$phpEx);
}
include($phpbb_root_path . 'championnat_equipe.'.$phpEx);
if ($arcade_config['heading_see'])
{
include($phpbb_root_path . 'headingarcade.'.$phpEx);
}
if ($arcade_config['whoisplay_see'])
{
include($phpbb_root_path . 'whoisplaying.'.$phpEx);
}
if (($arcade_config['cat_see']) && ($arcade_config['use_category_mod']) && ($userdata['session_logged_in']))
{
include($phpbb_root_path . 'arcade_cat.'.$phpEx);
}

//
// Output page header
$page_title = $lang['arcade'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);	
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
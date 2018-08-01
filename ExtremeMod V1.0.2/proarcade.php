<?php
/***************************************************************************
*                               proarcade.php
*                              ---------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.'.$phpEx);

$gid = get_var2(array('name'=>'gid', 'intval'=>true, 'default'=>0));
$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

$sql = "SELECT * FROM " . GAMES_TABLE . " WHERE game_id = '$gid'";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la table des jeux", '', __LINE__, __FILE__, $sql);
}
if ( !( $row = $db->sql_fetchrow($result) ) )
{// Si l'utilisateur n'a encore aucun score pour ce jeu'
	message_die(GENERAL_ERROR, "Aucun jeu ne correspond.");
}

$costj = $row['point_pay'];
$prize = $row['point_prize'];
$highscore_type = $row['game_highscore_type'];
$hashoffset = get_var2(array('name'=>'hashoffset', 'default'=>''));
$gamehash = get_var2(array('name'=>'gamehash', 'default'=>''));
$vpaver = get_var2(array('name'=>'vpaver', 'default'=>''));
$newhash = get_var2(array('name'=>'newhash', 'default'=>''));
$gpaver = get_var2(array('name'=>'gpaver', 'default'=>''));
$settime = get_var2(array('name'=>'settime', 'intval'=>true, 'default'=>''));
$sid = get_var2(array('name'=>'sid', 'default'=>''));
$valid = get_var2(array('name'=>'valid', 'default'=>''));

$arcade_config = array();
$arcade_config = read_arcade_config();
$nbpoints = $userdata['user_points'];

if ( $row['game_type'] == 0 )
{
	$deb = 32 - $hashoffset ;
	$gamehash_id = substr( $newhash , $deb , $hashoffset ) . substr( $newhash , 0 , $deb ) ;
}

if ( $row['game_type'] == 1 )
{
 $gamehash_id = $gamehash ;
}

if ( $row['game_type'] == 2 )
{
 if ( $vpaver == "100B" )
 {
 $gamehash_id = $gamehash ;
 $vpaver = "100B2" ;
 }
}

if ( $row['game_type'] == 3 )
{
	$gamehash_id = substr( $newhash , $hashoffset , 32 ) . substr( $newhash , 0 , $hashoffset );
	$vpaver = ( $gpaver == "GFARV2") ? '100B2' : '' ;
}

if ( $row['game_type'] == 4 )
{
      $gamehash_id = md5($user_ip);
      $vpaver = ($gpaver == "GFARV2") ? '100B2' : '';
}

if ($row['game_type'] != 4)
{
  $vscore = $row['game_scorevar'];
  $score = get_var2(array('name'=>$vscore, 'intval'=>true, 'default'=>''));
}
else
{
   if (@phpversion() >= '4.0.0')
   {
      session_save_path($phpbb_root_path . './sess_arcade');
      session_name('gf_arcade');
      session_start();
      $gf_sess = session_id();
   }
   if (!empty($gf_sess))
   {
      $score = $_SESSION['gamescore'];
      $gamerealtime = $_SESSION['gamerealtime'];
      $gameflashtime = $_SESSION['gameflashtime'];
      $gamecheattype = $_SESSION['gamecheattype'];
      $gamesessid = $_SESSION['gamesessid'];
      //Les valeurs sont récupérées => on détruit la session
      if (isset($_COOKIE[session_name()]))
      {
         setcookie(session_name(), '', time()-42000, '/');
      }
      unset($_SESSION);
      session_destroy();
   }
   else
   {
      $score = $HTTP_POST_VARS['vscore'];
      $gamerealtime = $HTTP_POST_VARS['gamerealtime'];
      $gameflashtime = $HTTP_POST_VARS['gameflashtime'];
      $gamecheattype = $HTTP_POST_VARS['gamecheattype'];
      $gamesessid = $HTTP_POSTE_VARS['gamesessid'];
   }
   $settime = $_COOKIE['timestarted'];
}
$$vscore = $score;

if (( !$userdata['session_logged_in'] && ($valid=='') && (!$arcade_config['auths_play'])))
{
	header($header_location . append_sid("proarcade.$phpEx?$vscore=$score&gid=$gid&valid=X&newhash=$newhash&gamehash_id=$gamehash_id&gamehash=$gamehash&hashoffset=$hashoffset&settime=$settime&sid=$sid&vpaver=$vpaver", true));
	exit;
}
if (( !$userdata['session_logged_in'] ) && ($arcade_config['auths_play']) && (!$arcade_config['auths_score']))
{
	header($header_location . append_sid("games.$phpEx?gid=$gid", true));
	exit;
}

if($row['game_type'] != 4)
{
  $sql = "SELECT * FROM " . GAMEHASH_TABLE . " WHERE gamehash_id = '$gamehash_id' and game_id = '$gid' and user_id = '" . $userdata['user_id'] . "'";

  if (!($result = $db->sql_query($sql)))
  {
        message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des hash game", '', __LINE__, __FILE__, $sql);
  }

  // Tentative de hack ?
  if (!($row = $db->sql_fetchrow($result)) or ($vpaver != "100B2") or (!isset($$vscore)))
  {
        $sql = "INSERT INTO " . HACKGAME_TABLE . " (user_id , game_id , date_hack) VALUES ('" . $userdata['user_id'] . "' , '$gid' , '" . time() . "')";
        $db->sql_query($sql);
        header($header_location . append_sid("arcade.$phpEx", true));
        exit;
  }
}

$sql = "DELETE FROM " . GAMEHASH_TABLE . " WHERE gamehash_id = '$gamehash_id' and game_id = $gid and user_id = " . $userdata['user_id'] ;

$db->sql_query($sql);

if ($row['game_type'] == 4)
{
  //IBProArcade Game Check
  if($_COOKIE['gidstarted'] != $gid || !isset($_COOKIE['gidstarted']))
  {
    $sql = "INSERT INTO " . HACKGAME_TABLE . " (user_id , game_id , date_hack) VALUES ('" . $userdata['user_id'] . "' , '$gid' , '" . time() . "')";
    $db->sql_query($sql);
    header($header_location . append_sid("arcade.$phpEx", true));
    exit;
  }
   if ($row['game_cheat_control'])
   {
      //Si le jeu a envoyé le temps total
      if ( ($gameflashtime != 0) || ($gamecheattype) )
      {
         //Suppression des enregistrements temporaires vieux de plus de 48h pour le joueur
         $sql = "DELETE FROM " . ARCADE_TIME_TEMP . " WHERE user_id = " . $userdata['user_id'] .  " AND date_enreg < " . (time() - 172800) ;
         $result = $db->sql_query($sql);
         $games_tolerance = $arcade_config['games_time_tolerance'];
         //Si triche archivage des valeurs temps php, temps flash, jeu, joueur, date, score
         if ( ( ($gameflashtime > ($gamerealtime + $games_tolerance)) || ($gameflashtime < ($gamerealtime - $games_tolerance)) ) || ($gamecheattype) )
         {
         	$sql = "INSERT INTO " . ARCADE_CHEATER_TABLE . " (user_id, game_id, score_game, date_cheat, flashtime, realtime, cheattype)
          VALUES (" . $userdata['user_id'] . ", $gid, $score, '" . time() . "', $gameflashtime, $gamerealtime, $gamecheattype)";
          $db->sql_query($sql);
          if ( ( !($arcade_config['games_cheater_submit']) ) || ($gamecheattype == 1) )
          {
          //Envoyer un message au joueur indiquant la tentative de triche
          $message = sprintf($lang['Info_arcade_cheater'], $score, $row['game_name']);
          message_die(GENERAL_MESSAGE, $message);
          }
        }
      }
      if ( !empty($gamesessid) )
      {
        $sql = "DELETE FROM " . ARCADE_TIME_TEMP . " WHERE user_id = " . $userdata['user_id'] . " AND game_id = " . $gid . " AND game_sessid = '" . $gamesessid . "'";
        $result = $db->sql_query($sql);
      }
   }
}

//
// End of auth check
//
$arcade_config = array();
$arcade_config = read_arcade_config();

$sql = "SELECT * FROM " . SCORES_TABLE . " WHERE game_id = $gid and user_id = " . $userdata['user_id'] ;

if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des scores", '', __LINE__, __FILE__, $sql);
}

$datenow = time();
$ecart = $datenow - $settime ;

if ( !( $row = $db->sql_fetchrow($result) ) )
{// Si l'utilisateur n'a encore aucun score pour ce jeu'
	$sql = "INSERT INTO " . SCORES_TABLE . " (game_id , user_id , score_game , score_date , score_time , score_set )
	VALUES ( $gid , " . $userdata['user_id'] . " , $score , $datenow , $ecart , 1 ) ";
	$result = $db->sql_query($sql) ;
} else {
	if ($highscore_type == 0)
  {
     $score_condition = ($row['score_game'] < $score) ? true : false;
  } else {
     $score_condition = ($row['score_game'] > $score) ? true : false;
  }
  if ( $score_condition )
  {
  $sql = "UPDATE " . SCORES_TABLE . " set score_game = $score , score_set = score_set + 1 , score_date = $datenow , score_time = score_time + $ecart 
	WHERE game_id = $gid and user_id = " . $userdata['user_id'];
  $result = $db->sql_query($sql);
  } else {
    $sql = "UPDATE " . SCORES_TABLE . " set score_set = score_set + 1  , score_time = score_time + $ecart
	WHERE game_id = $gid and user_id = " . $userdata['user_id'] ;
    $result = $db->sql_query($sql) ;
  }
}

  $sql = 'SELECT g.game_id AS gid, c.* FROM ' . GAMES_TABLE. ' g LEFT JOIN '. COMMENTS_TABLE . ' c ON g.game_id = c.game_id WHERE g.game_id = '.$gid;
  $result = $db->sql_query($sql); 
  $row = $db->sql_fetchrow($result);
	$comment_id_game = $row['game_id'];
  if(	!($comment_id_game) )
  {
	$db->sql_query("INSERT INTO " . COMMENTS_TABLE . " ( game_id, message) VALUES ('$gid','')");	
  }

$sql = "SELECT * FROM " . GAMES_TABLE . " WHERE game_id = " . $gid ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
}

if ( ( $row = $db->sql_fetchrow($result) ) && ((($highscore_type == 0) && ($row['game_highscore'] < $score)) || (($highscore_type == 1) && ($row['game_highscore'] > $score)) || (($highscore_type == 1) && ($row['game_highscore'] == 0))) )
{// Si l'utilisateur a battu le record du jeu
	$sql = "UPDATE " . GAMES_TABLE . " 
	SET game_highscore = $score , 
	game_highuser = " . $userdata['user_id'] . " , 
	game_highdate = " . time() . " 
	WHERE game_id = $gid" ;
	$result = $db->sql_query($sql);

if ((($highscore_type == 0) && ($row['game_ultimate_highscore'] < $score)) || (($highscore_type == 1) && ($row['game_ultimate_highscore'] > $score)) || (($highscore_type == 1) && ($row['game_ultimate_highscore'] == 0)))
{// Si l'utilisateur a battu le record ultime du jeu
  $sql = "UPDATE " . GAMES_TABLE . " 
  SET game_ultimate_highscore = $score , 
  game_ultimate_highuser = " . $userdata['user_id'] . " , 
  game_ultimate_highdate = " . time() . " 
  WHERE game_id = $gid" ;
  $result = $db->sql_query($sql) ;
}

if ($arcade_config['use_points_mod'] && $arcade_config['use_points_win_mod'])
 {
	if ( $arcade_config['prize_all_games']==1 || ($arcade_config['prize_all_games']==2 && $arcade_config['use_points_pay_mod'] &&	($arcade_config['use_points_pay_submit'] || $arcade_config['use_points_pay_charging']) && ($arcade_config['pay_all_games'] || (!$arcade_config['pay_all_games'] && $costj>0))))
	 {
		 $pointswin = $arcade_config['points_winner'];
		 $nbpoints = $nbpoints+$pointswin; 
	 }
		 elseif($arcade_config['prize_all_games']==0)	
	 {
		 $nbpoints = $nbpoints+$prize; 
	 }	

	 $sql = "update " . USERS_TABLE . " set user_points = $nbpoints where user_id = " . $userdata['user_id'] ; 
	 if( !($result = $db->sql_query($sql)) )
	 {
		 message_die(GENERAL_ERROR, "Impossible de modifier les points du joueur.", '', __LINE__, __FILE__, $sql); 
	 }
 }

if($row['game_highuser'] != $userdata['user_id'])
 {
	 $sql = 'UPDATE ' . COMMENTS_TABLE . ' SET message = \'\' WHERE game_id = '.$gid;
	 $result = $db->sql_query($sql) ;
	 $flag = 1;
		
	 $sql = 'SELECT * FROM ' . SCORES_TABLE . ' WHERE game_id = '.$gid.' ORDER BY score_game DESC LIMIT 1,1';
   $clause_order = ($highscore_type == 0) ? "ORDER BY score_game DESC" : "ORDER BY score_game ASC";
   $sql = str_replace("ORDER BY score_game DESC", $clause_order, $sql);
	 if( !($result = $db->sql_query($sql)) )
	 {
		 message_die(GENERAL_ERROR, 'Error accessing scores table', '', __LINE__, __FILE__, $sql); 
	 }

	 if ( $row = $db->sql_fetchrow($result) )
	 {
	  //Current Champion
	  $sql= 'SELECT s.score_game, s.game_id, g.game_name, u.user_id, u.username FROM ' . SCORES_TABLE . ' s 
		LEFT JOIN ' . USERS_TABLE . ' u ON s.user_id = u.user_id 
		LEFT JOIN ' . GAMES_TABLE . '  g ON s.game_id = g.game_id 
		WHERE s.game_id = ' . $gid . ' ORDER BY score_game DESC LIMIT 0 , 1'; 
    $sql = str_replace("ORDER BY score_game DESC", $clause_order, $sql);
		$row[0] = $db->sql_fetchrow($db->sql_query($sql));

		//Old Champion
		$sql= 'SELECT s.score_game, s.game_id, g.game_name, u.user_id, u.username 
		FROM ' . SCORES_TABLE . ' s 
		LEFT JOIN ' . USERS_TABLE . ' u ON s.user_id = u.user_id 
		LEFT JOIN ' . GAMES_TABLE . ' g ON s.game_id = g.game_id 
		WHERE s.game_id = ' . $gid . ' ORDER BY score_game DESC LIMIT 1 , 1'; 
    $sql = str_replace("ORDER BY score_game DESC", $clause_order, $sql);
		$row[1] = $db->sql_fetchrow($db->sql_query($sql));
			
		$user_id = $row[1]['user_id'];
		$sql = 'UPDATE ' . USERS_TABLE . '  SET user_new_privmsg = \'1\', user_last_privmsg = \'9999999999\' WHERE user_id = '.$user_id;
		if ( !($result = $db->sql_query($sql)) )
		{
		  message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
		}
		
		$link = '<a href="' . append_sid('games.'.$phpEx.'?gid=' . $row[0]['game_id']) .'">Ici</a>';

		$privmsgs_date = date('U');
		$privmsgs_subject = str_replace("\'", "''", addslashes(sprintf($lang['arcade_pm_subject'],$row[0]['game_name'])));
		$sql = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('1', '$privmsgs_subject', '2', " . $user_id . ", " . $privmsgs_date . ", '0', '1', '1', '0')";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not insert private message sent info', '', __LINE__, __FILE__, $sql);
		}
		
		$privmsg_sent_id = $db->sql_nextid();
		$privmsgs_text = str_replace("\'", "''", addslashes(sprintf($lang['arcade_pm_text'],$row[1]['score_game'],$row[0]['game_name'],$row[0]['username'],$row[0]['score_game'],$link)));
				
		$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '$privmsgs_text')";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not insert private message sent text', '', __LINE__, __FILE__, $sql);
		}
	 }
  }
 }

//
// incrémentation du compteur du nombre de parties jouées et la date
//
$date = getdate();
$formatdate = $date[year] . $date[mon] . $date[mday];

$sql = "UPDATE " . USERS_TABLE . " set user_nb_game = user_nb_game + 1, user_date_game = $formatdate
       WHERE  user_id = " . $userdata['user_id'] ;
if( !($result = $db->sql_query($sql)) )
{
    message_die(GENERAL_ERROR, "Mise a jour du compteur du nombre de parties impossible", '', __LINE__, __FILE__, $sql);
}

$sql = "SELECT user_id FROM " . SCORES_TABLE . " WHERE game_id = $gid 
ORDER BY score_game DESC, score_date ASC LIMIT 0,20";
$clause_order = ($highscore_type == 0) ? "ORDER BY score_game DESC" : "ORDER BY score_game ASC";
$sql = str_replace("ORDER BY score_game DESC", $clause_order, $sql);
if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'acceder à la table des scores", '', __LINE__, __FILE__, $sql);
 }

$un = 0;
$deux = 0;
$trois = 0;
$quatre = 0;
$cinq = 0;
$six = 0;
$sept = 0;
$huit = 0;
$neuf = 0;
$dix = 0;
$onze=0;
$douze=0;
$treize=0;
$quatorze=0;
$quinze=0;
$seize=0;
$dixsept=0;
$dixhuit=0;
$dixneuf=0;
$vingt=0;

$j = 0;

if ($arcade_config['use_cagnotte_mod'] && $arcade_config['use_points_cagnotte'] && $arcade_config['use_points_mod'] && $arcade_config['use_points_pay_mod'])
{
	$cagnotte = $arcade_config['cagnotte'];
	$cost = $arcade_config['points_pay'];
	if ($arcade_config['use_points_pay_submit'])
	{
	 $cagnotte = $cagnotte + $cost;
	}
	if ($arcade_config['use_points_pay_charging'])
	{
	 $cagnotte = $cagnotte + $cost;
	}

	$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = $cagnotte WHERE arcade_name = 'cagnotte'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible de modifier le montant de la cagnotte.", "", __LINE__, __FILE__, $sql);
	}
}

while ($row = $db->sql_fetchrow($result)) 
{ 
 	$j++; 
 	$user_id = $row['user_id']; 
	switch($j)
	{
		case 1 :
		 $un = $user_id; 
 		 break;
		case 2 :
		 $deux = $user_id; 
 		 break;
		case 3 :
		 $trois = $user_id; 
 		 break;
		case 4 :
		 $quatre = $user_id; 
 		 break;
		case 5 :
		 $cinq = $user_id; 
 		 break;
		case 6 :
		 $six = $user_id; 
 		 break;
		case 7 :
		 $sept = $user_id; 
 		 break;
		case 8 :
		 $huit = $user_id; 
 		 break;
		case 9 :
		 $neuf = $user_id; 
 		 break;
		case 10 :
		 $dix = $user_id; 
 		 break;
		case 11 :
		 $onze = $user_id; 
 		 break;		
		case 12 :
		 $douze = $user_id; 
		 break;		
		case 13 :
		 $treize = $user_id; 
 		 break;	
		case 14 :
		 $quatorze = $user_id; 
 		 break;	
		case 15 :
		 $quinze = $user_id; 
		 break;
		case 16 :
		 $seize = $user_id; 
 		 break;		
		case 17 :
		 $dixsept = $user_id; 
		 break;		
		case 18 :
		 $dixhuit = $user_id; 
 		 break;	
		case 19 :
		 $dixneuf = $user_id; 
 		 break;	
		case 20 :
		 $vingt = $user_id; 
 		 break;
		default :
		 break;
	}
} 
  
//on vérifie l'existence de l'enregistrement pour ce jeu 
$sql = "SELECT game_id FROM " . ARCADE_CHAMPIONNAT_TABLE . " WHERE game_id = $gid"; 
if( !$result=$db->sql_query($sql) ) 
{ 
   message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat", '', __LINE__, __FILE__, $sql); 
} 

if ( $row = $db->sql_fetchrow($result)) 
{ 
//l'enregistrement existe : on le met à jour 
  $sql = "UPDATE " . ARCADE_CHAMPIONNAT_TABLE . " 
  SET one_userid = $un, 
      two_userid = $deux, 
      three_userid = $trois, 
      four_userid = $quatre, 
      five_userid = $cinq,
      six_userid = $six, 
      seven_userid = $sept, 
      eight_userid = $huit, 
      nine_userid = $neuf, 
      ten_userid = $dix,
      eleven_userid = $onze,
      twelve_userid = $douze,
      thirteen_userid = $treize,
      fourteen_userid = $quatorze,
      fiveteen_userid = $quinze,
      sixteen_userid = $seize,
      seventeen_userid = $dixsept,
      eighteen_userid = $dixhuit,
      nineteen_userid = $dixneuf,
      twenty_userid = $vingt
  WHERE game_id = $gid"; 
} 
else 
{ 
//l'enregistrement n'existe pas, on le crée 
   $sql = " INSERT INTO " . ARCADE_CHAMPIONNAT_TABLE . " (game_id, one_userid, two_userid, three_userid, four_userid, five_userid, six_userid, seven_userid, eight_userid, nine_userid, ten_userid, eleven_userid, twelve_userid, thirteen_userid, fourteen_userid, fiveteen_userid, sixteen_userid, seventeen_userid, eighteen_userid, nineteen_userid, twenty_userid) VALUES($gid, $un, $deux, $trois, $quatre, $cinq, $six, $sept, $huit, $neuf, $dix, $onze, $douze, $treize, $quatorze, $quinze, $seize, $dixsept, $dixhuit, $dixneuf, $vingt)"; 
} 

if( !$db->sql_query($sql) ) 
{ 
   message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat", '', __LINE__, __FILE__, $sql); 
}

if($flag == 1)
{
	header($header_location . append_sid("comments_new.$phpEx?gid=$gid", true));
	exit;
}
elseif ($arcade_config['use_points_pay_submit'])
{
if ($arcade_config['use_points_pay_submit'] && (!$arcade_config['use_points_pay_charging']))
{
	$cost = $arcade_config['points_pay'];
	$nbpoints = $nbpoints - $cost; 
}
 else if ($arcade_config['use_points_pay_submit'] && $arcade_config['use_points_pay_charging'])
{
	$cost = $arcade_config['points_pay'];
	$nbpoints = $nbpoints - ($cost/2); 
 }

	 $sql = "update " . USERS_TABLE . " set user_points = $nbpoints where user_id = " . $userdata['user_id'] ; 
	 if( !($result = $db->sql_query($sql)) )
	 {
		 message_die(GENERAL_ERROR, "Impossible de modifier les points du joueur.", '', __LINE__, __FILE__, $sql); 
	 }
  if (($userdata['session_logged_in']) && ($arcade_config['use_points_pay_submit'] && $arcade_config['use_points_pay_charging']))
	{	
		$message .='<br /><br /><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"><tr><td class="catHead" align="center" height="28"><span class="cattitle">Information</span></td></tr><tr><td class="row1" align="center"><span class="gen">'.sprintf($lang['game_cost'], $cost, $board_config['points_name']) . "<br />" . $cost/2 . " " . $board_config['points_name'] . " vous sont débités au début du jeu et l'autre moitié à la fin.<br /><br />" . sprintf ($lang['confirmation'],'<a href="' . append_sid("games.$phpEx?gid=". $gid ."&pay=1") .'">','</a>','<a href="' . append_sid("arcade.$phpEx") . '">', '</a>').'</span></td></tr></table><br /><br />'; 
		include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
		echo $message; 
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	 elseif (($userdata['session_logged_in']) && ($arcade_config['use_points_pay_submit'] && (!$arcade_config['use_points_pay_charging'])))
	{	
		$message .='<br /><br /><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"><tr><td class="catHead" align="center" height="28"><span class="cattitle">Information</span></td></tr><tr><td class="row1" align="center"><span class="gen">'.sprintf($lang['game_cost'], $cost, $board_config['points_name']) . "<br />" . $cost . " " . $board_config['points_name'] . " vous serons débités à chaque fin de jeu.<br /><br />" . sprintf ($lang['confirmation'],'<a href="' . append_sid("games.$phpEx?gid=". $gid ."&pay=1") .'">','</a>','<a href="' . append_sid("arcade.$phpEx") . '">', '</a>').'</span></td></tr></table><br /><br />'; 
		include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
		echo $message; 
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	 elseif (!($userdata['session_logged_in']))
  {	
		$message .='<br /><br /><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline"><tr><td class="catHead" align="center" height="28"><span class="cattitle">Information</span></td></tr><tr><td class="row1" align="center"><span class="gen">'.sprintf($lang['game_cost'], 0, $board_config['points_name']) . "<br /><br />Comme vous ne possèdez aucun points et que vous n'êtes pas encore éffectué votre <a href=" . append_sid("profile.$phpEx?mode=register") . "><font color='green'>inscription</font></a><br />les parties seront gratuites. mais vous ne remporterez aucun " . $board_config['points_name'] . " non plus.<br /><br />" . sprintf ($lang['confirmation'],'<a href="' . append_sid("games.$phpEx?gid=". $gid ."&pay=1") .'">','</a>','<a href="' . append_sid("arcade.$phpEx") . '">', '</a>').'<br /><br /></span></td></tr></table><br /><br />'; 
		include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
		echo $message; 
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}
else
{
	header($header_location . append_sid("games.$phpEx?gid=$gid", true));
	exit;
}



?>
<?php
/***************************************************************************
*                               modoadminrecord.php
*                              ---------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

global $prefix;

define('IN_PHPBB', 1); 

// 
// Let's set the root dir for phpBB 
// 
$phpbb_root_path = "./"; 
require($phpbb_root_path . 'extension.inc'); 
require('./pagestart_modo.' . $phpEx); 
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);
//
// End session management
$arcade_config = array();
$arcade_config = read_arcade_config();
//
// Start auth check
//

$mode = $HTTP_GET_VARS['mode'];

if($mode == "update")
 {
	$gid = $HTTP_GET_VARS['gid'];	
	$casesupp = $HTTP_GET_VARS['casesupp'] ;
	
$template->set_filenames(array( 
	 'body' => 'modoadminrecord_body.tpl')
	 ); 

$moderateur = $userdata['username'];
$id_moderateur = $userdata['user_id'];
if ($arcade_config['use_points_mod'])
{
   $sql = "SELECT g.*, u.user_points, u.user_id FROM " . GAMES_TABLE . " g LEFT JOIN " . USERS_TABLE . " u ON u.user_id = " . $userdata['user_id'] . " WHERE g.game_id = $gid ORDER BY g.game_highscore DESC LIMIT 0,1";    
} else {
 	 $sql = "SELECT g.*, u.user_id FROM " . GAMES_TABLE . " g LEFT JOIN " . USERS_TABLE . " u ON u.user_id = " . $userdata['user_id'] . " WHERE g.game_id = $gid ORDER BY g.game_highscore DESC LIMIT 0,1"; 
}

if( !($result = $db->sql_query($sql)) ) 
 { 
   message_die(GENERAL_ERROR, 'Impossible d\'accéder à la table des jeux', '', __LINE__, __FILE__, $sql); 
 }
 while ( $row_games = $db->sql_fetchrow($result) )
 { 
   
// en attendant:
	$commentaire_text = str_replace("\'","''",$HTTP_POST_VARS['commentaire']);
	$commentaire_text = preg_replace(array('#&(?!(\#[0-9]+;))#', '#<#', '#>#'), array('&amp;', '&lt;', '&gt;'),$commentaire_text);   
 
  $nom_du_jeu = $row_games['game_name'];

// suppression où non du gain obtenu
if ($arcade_config['use_points_mod'])
{
$casesupp = ( isset($HTTP_POST_VARS['casesupp']) ) ? ( ($HTTP_POST_VARS['casesupp']) ? TRUE : 0 ) : 0;
if ( $casesupp == true )
 {
$sql = "UPDATE " . USERS_TABLE . " SET user_points  = " . $row_games['user_points'] . " - " . $row_games['point_prize'] . " WHERE user_id = " . $row_games['game_highuser'] ;
if ( !$db->sql_query($sql) )
  { 
    message_die(GENERAL_ERROR, 'Impossible de mettre à jour les points', '', __LINE__, __FILE__, $sql); 
  } 
 }
}

// envoi MP au champion déchu

$sql3 = "UPDATE " . USERS_TABLE . " SET user_new_privmsg = '1', user_last_privmsg = '9999999999' WHERE user_id = " . $row_games['game_highuser'] . " ";  
if ( !$db->sql_query($sql3) )
 { 
   message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql3); 
 } 

//-- fix : modo admin records -------------------------------------------------- 
//-- delete 
/*-MOD 
$pm_subject = sprintf($lang['modomsgn'], $nom_du_jeu ); 
MOD-*/ 
//-- add 
$pm_subject = sprintf($lang['modomsgn'], addslashes($nom_du_jeu)); 
//-- fin fix : modo admin records ---------------------------------------------- 

$sql3 = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('0', '$pm_subject', '$id_moderateur', '" . $row_games['game_highuser'] . "', '" . time() . "', '0', '1', '1', '0')"; 
if ( !$db->sql_query($sql3) ) 
 { 
   message_die(GENERAL_ERROR, 'Could not insert private message sent info', '', __LINE__, __FILE__, $sql3); 
 } 

$privmsg_sent_id = $db->sql_nextid(); 
$commentaire_par_defaut = $lang['modomsgq'];

$sql3 = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '$commentaire_par_defaut $commentaire_text')"; 
if ( !$db->sql_query($sql3) ) 
 { 
   message_die(GENERAL_ERROR, 'Could not insert private message sent text', '', __LINE__, __FILE__, $sql3); 
 }
// fin MP	  

$sql2 = "INSERT INTO " . MODOADMINRECORD . " (modo_record_id, commentaire, jeu, moderateur, champion, score, date_effacement) VALUES ('', '$commentaire_par_defaut $commentaire_text',' " . $row_games['game_id'] . " ','$moderateur','" . $row_games['game_highuser'] . "','" . $row_games['game_highscore'] . "', '" . time() . "')";
if ( !$db->sql_query($sql2) )
 {
   message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table de modération des records.', '', __LINE__, __FILE__, $sql2);
 } 
	  
$sql2 = "DELETE FROM " . SCORES_TABLE . " WHERE game_id = " . $row_games['game_id'] . " AND user_id = " . $row_games['game_highuser'] . " ";
if ( !$db->sql_query($sql2) )
 {
   message_die(GENERAL_ERROR, 'Impossible d\'effacer le score', '', __LINE__, __FILE__, $sql2);
 }   
  
$sql2 = "SELECT * FROM " . SCORES_TABLE . " WHERE game_id = " . $row_games['game_id'] . " 
ORDER BY score_game DESC, score_date ASC LIMIT 0,1" ;
if( !($result2 = $db->sql_query($sql2)) ) 
 { 
   message_die(GENERAL_ERROR, 'Impossible d\'accéder à la tables des scores', '', __LINE__, __FILE__, $sql2); 
 }

$game_highuser = 0 ; 
$game_highscore = 0 ;
$game_highdate = 0 ; 
if ( $row_high = $db->sql_fetchrow($result2) ) 
 {
  $game_highuser = $row_high['user_id'] ; 
  $game_highscore = $row_high['score_game'] ;
  $game_highdate =  $row_high['score_date'] ;
 } 
  
$sql2 = "UPDATE " . GAMES_TABLE . " 
SET game_highuser = $game_highuser , game_highdate = $game_highdate , game_highscore = $game_highscore 
WHERE game_id = " . $row_games['game_id'] ; 
if ( !$db->sql_query($sql2) )
 {
   message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql2);
 }
} 	   
		
// record supprimé correctement!
$message = $lang['modomsgo']; 
$message .= sprintf($lang['modomsgp'], '<a href="games.php?gid=' . $gid . '  ">', '</a> '); 
$message .= "<META HTTP-EQUIV=\"refresh\" content=\"20;URL=games.php?gid=$gid\">";
message_die(GENERAL_MESSAGE, $message);
	
$template->assign_vars(array(
	'MODOMSGE' => $message)
	);
}

if($mode == "edit")
 {
  $gid = $HTTP_GET_VARS['gid'];

$template->set_filenames(array( 
	 'body' => 'modoadminrecord_body.tpl')
	 );

//On récupère les données du jeu.
$sql = "SELECT g.*, c.*, u.user_id, u.username FROM " . SCORES_TABLE . " g LEFT JOIN " . GAMES_TABLE . " c ON g.game_id = c.game_id LEFT JOIN " . USERS_TABLE ." u  ON c.game_highuser = u.user_id WHERE g.game_id = $gid ORDER BY g.score_game DESC LIMIT 0,1";
if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des scores", '', __LINE__, __FILE__, $sql); 
 }

$row = $db->sql_fetchrow($result);
// si le jeu n'a pas de record
if ($row['score_game'] == '')
 {
	$template->assign_block_vars('pas_record',array(
		 'MODOMSGA' => $lang['modomsgr'])
		 );		

$template->pparse('body'); 

include('./includes/page_tail.'.$phpEx);

}else{

// si le jeu a un record
$template->assign_block_vars('record',array(
	'GAME_NAME' => '<a href=" ' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>',
	'MODOMSGA' => $lang['modomsga'],
	'MODOMSGB' => $row['user_id'],
	'MODOMSGC' => $row['game_id'],
	'MODOMSGD' => $row['username'],
	'MODOMSGJ' => $row['score_game'],
	'S_ACTION' => append_sid('modoadminrecord.' . $phpEx . '?mode=update&gid=' . $row['game_id'] . ''))
	);
}

$template->assign_vars(array(
	'RETRAIT_OUI' => ( $casesupp ) ? 'checked="checked"' : '',
	'RETRAIT_NON' => ( !$casesupp ) ? 'checked="checked"' : '',
	'OUI' => $lang['oui'],
	'NON' => $lang['non'],
	'MODOMSGS' => $lang['modomsgs'],
	'MODOMSGK' => $lang['modomsgk'],
	'MODOMSGL' => $lang['modomsgl'],
	'MODOMSGM' => $lang['modomsgm'],
	'MODOMSGE' => $lang['Actual_winner'],
	'MODOMSGF' => $lang['boardplayer'],
	'MODOMSGG' => $lang['modomsgg'],
	'MODOMSGH' => $lang['modomsgh'],
	'MODOMSGI' => $lang['modomsgi'])
	);

if ($arcade_config['use_points_mod'])
{
	$template->assign_block_vars('switch_points',array());
}
	$template->pparse('body'); 

	include('./includes/page_tail.'.$phpEx);
}

?>
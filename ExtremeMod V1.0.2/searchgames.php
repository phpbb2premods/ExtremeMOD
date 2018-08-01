<?php
/***************************************************************************
*                               searchgames.php
*                              -----------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);
define('ARCADE', true);

$phpbb_root_path = './';
include($phpbb_root_path .'extension.inc');
include($phpbb_root_path .'common.'.$phpEx);
include($phpbb_root_path .'includes/functions_arcade.'. $phpEx);

// session management 
$userdata = session_pagestart($user_ip, PAGE_RECHERCHEJEUX);
init_userprefs($userdata); 

if(!$userdata['session_logged_in'])
{
$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
header($header_location . append_sid("login.$phpEx?redirect=searchgames.$phpEx", true));
exit;
}

$arcade_config = array();
$arcade_config = read_arcade_config();

// mode 
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
 {
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
 }
 else
 {
	$mode = "";
 }

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;
$games_par_page = 5;
$sql = "SELECT COUNT(*) AS nbgames FROM " . GAMES_TABLE ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
}

if ( $row = $db->sql_fetchrow($result))
{
  $total_games = $row['nbgames'];
}
$db->sql_freeresult($result);

$template->assign_vars(array(
  'URL_SEARCHGAMES' => '<nobr><a class="cattitle" href="' . append_sid("searchgames.$phpEx") . '" alt="' . $lang['searchgame'] . '" title="' . $lang['searchgame'] . '">' . $lang['searchgame'] . '</a></nobr> ',
  'URL_ARCADE' => '<nobr><a class="cattitle" href="' . append_sid("arcade.$phpEx") . '" alt="' . $lang['lib_arcade'] . '" title="' . $lang['lib_arcade'] . '">' . $lang['lib_arcade'] . '</a></nobr> ',
  'SEARCHGAME_BOARD' => $lang['searchgame_board'],
  'L_PRECISION' => $lang['searchgame_desc'],
  'L_TYPE_1' => $lang['type_1'],
  'L_TYPE_2' => $lang['type_2'],
  'L_TYPE_3' => $lang['type_3'],
  'L_TYPE_4' => $lang['type_4'],
  'L_TYPE_5' => $lang['type_5'],
  'L_TYPE_6' => $lang['type_6'],
  'L_TEXT' => $lang['text_search'],
  'L_TYPE_SEARCH' => $lang['type_searchgame'],
  'TOTAL_GAMES' => $total_games,
	'S_ACTION' => append_sid('searchgames.' . $phpEx))
	);

$template->set_filenames(array(
 'body' => 'searchgames_body.tpl')
 );

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if ( $mode == 'rechercher' )
 {

if ((isset($HTTP_GET_VARS['type_games']))||(isset($HTTP_POST_VARS['type_games'])))
 {
   $type = (isset($HTTP_POST_VARS['type_games'])) ? $HTTP_POST_VARS['type_games'] : $HTTP_GET_VARS['type_games'];
 }

if ((isset($HTTP_GET_VARS['nom_a_chercher']))||(isset($HTTP_POST_VARS['nom_a_chercher'])))
 {
   $nom_a_chercher = (isset($HTTP_POST_VARS['nom_a_chercher'])) ? $HTTP_POST_VARS['nom_a_chercher'] : $HTTP_GET_VARS['nom_a_chercher'];
 }

if(!($nom_a_chercher) )
{
	 $message = $lang['error_searchgame'] . "<br /><br /><br />" . sprintf($lang['Click_return_searchgame'], "<a href=\"" . append_sid("searchgames.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_arcade'], "<a href=\"" . append_sid("arcade.$phpEx") . "\">", "</a>");
	 message_die(GENERAL_MESSAGE, $message);
}
 else
{
   if (get_magic_quotes_gpc()) {
       $nom_a_chercher = stripslashes($nom_a_chercher);
   }
   // Quote if not a number or a numeric string
   if (!is_numeric($nom_a_chercher)) {
       $nom_a_chercher = mysql_real_escape_string($nom_a_chercher);
   }
}

$by = '';
if($type == 1)
  {
$by .= "game_name";
	} elseif($type == 2) {
$by .= "game_desc";
	} elseif($type == 3) {
$by .= "username";
	} elseif($type == 4) {
$by .= "game_type";
  } elseif($type == 5) {
$by .= "game_scorevar";
	}	elseif($type == 6) {
$by .= "game_id";
	} else {
$by .= "game_name";		
	}

if(($type == 4 || $type == 5 || $type == 6 ) && $userdata['user_level'] != ADMIN)
  { 
    $message = $lang['error1_searchgame'] . "<br /><br />" . sprintf($lang['Click_return_searchgame'], "<a href=\"" . append_sid("searchgames.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_arcade'], "<a href=\"" . append_sid("arcade.$phpEx?pane=right") . "\">", "</a>");
	  message_die(GENERAL_MESSAGE, $message);
  }

$i = 1;
$total_result = 0;
$sql = "SELECT g.*, s.*, u.* 
  FROM " . GAMES_TABLE . " g 
  left join " . ARCADE_CATEGORIES_TABLE . " s on g.arcade_catid = s.arcade_catid 
  left join " . USERS_TABLE . " u on g.game_highuser = u.user_id 
  WHERE  ".$by." 
  LIKE '%$nom_a_chercher%' 
  ORDER BY $by ";

if($result = $db->sql_query($sql))
 {
 	$total_result = $db->sql_numrows($result);

  while($row = $db->sql_fetchrow($result))
  {
  	
  $game_record = $row['game_highscore'];
  $game_record_user = $row['game_highuser'];
  $game_id = $row['game_id'];
  $game_name = $row['game_name'];
  $game_type = $row['game_type'];
  $game_var = $row['game_scorevar'];
  $game_desc = $row['game_desc'];
  $game_pic = "<img src =games/pics/" . $row['game_pic'] . " widht='40' height='40' alt='" . $row['game_pic'] . "' title='" . $row['game_pic'] . "' />";
  $game_link = "<a href =games.php?gid=" . $row['game_id'] . " alt='Cliquer ici pour jouer à ".$row['game_name']."' title='Cliquer ici pour jouer à ".$row['game_name']."'>Jouer à ".$row['game_name']."</a>";
  $game_cat = "<a href=arcade.php?cid=" . $row['arcade_catid'] . " alt='" . $row['arcade_cattitle'] . "' title='" . $row['arcade_cattitle'] . "'>" . $row['arcade_cattitle'] . "</a>";
  $row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2']; 
  $newsearch = '<nobr><a class="cattitle" href="' . append_sid("searchgames.$phpEx") . '" alt="' . $lang['new_searchgame'] . '" title="' . $lang['new_searchgame'] . '">' . $lang['new_searchgame'] . '</a></nobr>';

  $style_color = user_color($row['username'], $row['user_level']);
  $game_record_user = '<a href="' . append_sid("statarcade.$phpEx?uid=" . $user_id) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';

if($game_record == 0)
 { 
  $game_record = $lang['no_record'];
 }
  else
 {
  $game_record = $row['game_highscore'];
 }

if(!$game_record_user)
 { 
  $game_record_user = $lang['no_record_user'];
 }
  else
 {
  $game_record_user;
 }

$search_type = '';
if($type == 1)
  {
$search_type .= $lang['type_1'];
	} elseif($type == 2) {
$search_type .= $lang['type_2'];
	} elseif($type == 3) {
$search_type .= $lang['type_3'];
	} elseif($type == 4) {
$search_type .= $lang['type_4'];
  } elseif($type == 5) {
$search_type .= $lang['type_5'];
	}	elseif($type == 6) {
$search_type .= $lang['type_6'];
	} else {
$search_type .= "game_name";		
	}

 $template->assign_block_vars('resultas', array(
	  'ROW_COLOR'	=> $row_color, 
	  'ROW_CLASS'	=> $row_class, 		
    'GAMES_LINK' => $game_link,
    'GAMES_CAT' => $game_cat,
    'GAMES_PIC' => $game_pic,
    'GAMES_NAME' => $game_name,
	  'GAMES_DESC' => $game_desc,
    'GAMES_RECORD' => $game_record,
    'GAMES_RECORD_USER' => $game_record_user,
    'NEW_SEARCHGAMES' => $newsearch)
	  );
if( $userdata['user_level'] == ADMIN )
 { 
   $template->assign_block_vars('resultas.admin', array(
     'GAMES_TYPE' => $game_type,
     'GAMES_VAR' => $game_var,
     'GAMES_ID' => $game_id)
	   );
    }
	 $i++;
 }

if(!$total_result)
{
  $results_search = sprintf($lang['no_results_search'] . '&nbsp;' . $search_type . '&nbsp;<font color=red size=5><b>' . $nom_a_chercher . '</b></size></font>');
}
 else
{
	$results_search = sprintf($total_result . '&nbsp;' . $lang['results_find'] . '&nbsp;' . $search_type . '&nbsp;<font color=red size=5><b>' . $nom_a_chercher . '</b></size></font>');
}

$template->assign_vars( array(
    'L_TOTAL_RESULTS' => $results_search )
  );

$template->assign_block_vars('switch', array(
  'NEW_SEARCHGAMES' => $newsearch,
  'L_NO_RESULTS' => sprintf($lang['end_searchgame']))
	);

	$db->sql_freeresult($result);
  }
}
 else
{			
$template->assign_block_vars("recherche", array());
}

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
<?php
/***************************************************************************
*                               comments_new.php
*                              ------------------
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
include($phpbb_root_path .'includes/bbcode.'.$phpEx);
include($phpbb_root_path .'includes/functions_arcade.'. $phpEx);
include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management

/*
** Redirection des membres ---
*/
$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

$arcade_config = array();
$arcade_config = read_arcade_config();

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;	
$submit = (isset($HTTP_POST_VARS['submit'])) ? intval($HTTP_POST_VARS['submit']) : '';

generate_smilies('inline', PAGE_INDEX);

$template->set_filenames(array( 
	'body' => 'comments_new_body.tpl'
)); 

//Comment update section
if( $mode == 'update' )
{
	$game_id = intval($HTTP_POST_VARS['comment_id']);
	$message = ( !empty($HTTP_POST_VARS['message']) ) ? $HTTP_POST_VARS['message'] : '';

	$user_id = $userdata['user_id'];
	$sql = 'SELECT game_highuser FROM ' . GAMES_TABLE. ' WHERE game_id = '.$game_id;
	if( !($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, "Error Authenticating User", '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);
	
	if( $user_id != $row['game_highuser'] )
	{
		message_die(GENERAL_ERROR, 'Error Authenticating User - Possible hack attempt!', ''); 
	}

	$sql = 'SELECT * FROM ' . COMMENTS_TABLE  . ' WHERE game_id = '.$game_id;
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Couldnot obtain data', '', __LINE__, __FILE__, $sql);
	}			
	$avs_info = $db->sql_fetchrow($result);
	
	$avs_txt = $message;
	$avs_txt = str_replace('<', '&lt;', $avs_txt); // >> supression des balise pour evité les script
	$avs_txt = str_replace('>', '&gt;', $avs_txt); // >> supression des balise pour evité les script
	
	$sql = "UPDATE " . COMMENTS_TABLE . " SET message = '" . str_replace("\'", "''", $avs_txt) . "' WHERE game_id = $game_id";	
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not insert row in comments table', '', __LINE__, __FILE__, $sql);
	}

	header($header_location . append_sid('games.' . $phpEx . '?gid='.$game_id, true));
	exit;
}
else
{
	$game_id = (isset($HTTP_GET_VARS['gid'])) ? intval($HTTP_GET_VARS['gid']) : 0;
	$user_id = intval($userdata['user_id']);
	
	$sql = 'SELECT game_highuser FROM ' . GAMES_TABLE. ' WHERE game_id = '.$game_id;
	if( !($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Error Authenticating User', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);

	if($row['game_highuser'] != $user_id)
	{
		header($header_location . append_sid('games.' . $phpEx . '?gid='.$game_id, true));
		exit;
	}

	$sql = 'SELECT game_highdate FROM ' . GAMES_TABLE. ' WHERE game_id = '.$game_id;
	if( !($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Error Authenticating User', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);
	
	if( (time() - $row['game_highdate']) > 60)
	{
		header($header_location . append_sid('games.' . $phpEx . '?gid='.$game_id, true));
		exit;
	}

	$sql = 'SELECT g.game_id AS gid, g.game_name, c.*  FROM ' . GAMES_TABLE. ' g LEFT JOIN '. COMMENTS_TABLE . ' c ON g.game_id = c.game_id WHERE g.game_id = '.$game_id;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error retrieving comment list', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);

	$guid = $row['gid'];
	$id_game = $row['game_id'];
	$name_game = $row['game_name'];
	
	$template->assign_vars(array(
		'NAV_DESC' => '<a class="nav" href="' . append_sid("arcade.$phpEx") . '">' . $lang['arcade'] . '</a> ' ,
		'GAME_NAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $id_game) . '">' . $name_game . '</a>', 
		'GAME_ID' => $guid,
		'MESSAGE' => $message,
		'RETURN_ARCADE' => sprintf($lang['Return_without_comment'],'<a href="' . append_sid("games.$phpEx?gid=" . $id_game) . '">','</a>'),
		'QUICK_STATS' => $lang['Quick_stats'],
		'ARCADE_COMMENT' => $lang['Arcade_Comments'],
		'CONGRATULATIONS' => $lang['Arcade_congratulations'],
		'L_NEW_CHAMPION' => sprintf($lang['You_are_champion'],'<a href="' . append_sid("games.$phpEx?gid=" . $id_game) . '">' . $name_game . '</a>'),
		'L_SUBMIT' => $lang['Submit'],
		'L_BBCODE_B_HELP' => $lang['bbcode_b_help'], 
		'L_BBCODE_I_HELP' => $lang['bbcode_i_help'], 
		'L_BBCODE_U_HELP' => $lang['bbcode_u_help'], 
		'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'], 
		'L_BBCODE_C_HELP' => $lang['bbcode_c_help'], 
		'L_BBCODE_L_HELP' => $lang['bbcode_l_help'], 
		'L_BBCODE_O_HELP' => $lang['bbcode_o_help'], 
		'L_BBCODE_P_HELP' => $lang['bbcode_p_help'], 
		'L_BBCODE_W_HELP' => $lang['bbcode_w_help'], 
		'L_BBCODE_A_HELP' => $lang['bbcode_a_help'], 
		'L_BBCODE_S_HELP' => $lang['bbcode_s_help'], 
		'L_BBCODE_F_HELP' => $lang['bbcode_f_help'], 
		'L_EMPTY_MESSAGE' => $lang['Empty_message'],
		'L_FONT_COLOR' => $lang['Font_color'], 
		'L_COLOR_DEFAULT' => $lang['color_default'], 
		'L_COLOR_DARK_RED' => $lang['color_dark_red'], 
		'L_COLOR_RED' => $lang['color_red'], 
		'L_COLOR_ORANGE' => $lang['color_orange'], 
		'L_COLOR_BROWN' => $lang['color_brown'], 
		'L_COLOR_YELLOW' => $lang['color_yellow'], 
		'L_COLOR_GREEN' => $lang['color_green'], 
		'L_COLOR_OLIVE' => $lang['color_olive'], 
		'L_COLOR_CYAN' => $lang['color_cyan'], 
		'L_COLOR_BLUE' => $lang['color_blue'], 
		'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'], 
		'L_COLOR_INDIGO' => $lang['color_indigo'], 
		'L_COLOR_VIOLET' => $lang['color_violet'], 
		'L_COLOR_WHITE' => $lang['color_white'], 
		'L_COLOR_BLACK' => $lang['color_black'], 
		'L_FONT_SIZE' => $lang['Font_size'], 
		'L_FONT_TINY' => $lang['font_tiny'], 
		'L_FONT_SMALL' => $lang['font_small'], 
		'L_FONT_NORMAL' => $lang['font_normal'], 
		'L_FONT_LARGE' => $lang['font_large'], 
		'L_FONT_HUGE' => $lang['font_huge'], 
		'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'], 
		'L_STYLES_TIP' => $lang['Styles_tip'],
		'S_ACTION' => append_sid("comments_new.$phpEx?mode=update"),
	));

	//Gets Avatar based on user settings and other user stats
	$sql = 'SELECT username, user_id, user_level, user_avatar_type, user_allowavatar, user_avatar FROM ' . USERS_TABLE . ' WHERE user_id = ' . $userdata['user_id'] ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Cannot access the users table', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);

	$user_id = $userdata['user_id'];
  $style_color = user_color($row['username'], $row['user_level']);
  if ( $row['user_id'] == ANONYMOUS ){
  $user = $row['username'];
  } else {
  $user = '<a href="' . append_sid("statarcade.$phpEx?uid=" . $user_id) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
  }
	$user_avatar_type = $row['user_avatar_type']; 
	$user_allowavatar = $row['user_allowavatar']; 
	$user_avatar = $row['user_avatar']; 
	$avatar_img = ''; 

	if ( $user_avatar_type && $user_allowavatar ) 
	{ 
		switch( $user_avatar_type ) 
		{ 
			case USER_AVATAR_UPLOAD: 
				$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" border="0" hspace="20" align="center" valign="center"/>' : ''; 
			break; 
			case USER_AVATAR_REMOTE: 
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center" />' : ''; 
			break; 
			case USER_AVATAR_GALLERY: 
				$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center" />' : ''; 
			break; 
		} 
	}
	if ( empty($avatar_img) ) 
  { 
    $avatar_img = '<img src="images/arcades/noavatar.gif" alt="Aucun Avatar" border="0" />'; 
  }

	$template->assign_vars(array(
		'USER_AVATAR' => '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;u=" . $userdata['user_id'] ) . '">' . $avatar_img . '</a>',
		'USERNAME' => $user,
	));

	//Gets some user stats to display on the comment submission page
	$sql ="SELECT s.score_set, s.game_id, g.game_name FROM " . SCORES_TABLE. " s LEFT JOIN " . USERS_TABLE. " u ON s.user_id = u.user_id LEFT JOIN " . GAMES_TABLE. " g ON s.game_id = g.game_id WHERE s.user_id = " . $userdata['user_id'] . " ORDER BY score_set DESC LIMIT 1";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Cannot access user stats to display', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);

	$times_played = $row['score_set'];
	$favgame = '<a href="' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>';

	$sql="SELECT * FROM " .GAMES_TABLE ." WHERE game_highuser = " . $userdata['user_id'] . " ORDER BY game_highdate DESC";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Cannot access last high score data", '', __LINE__, __FILE__, $sql); 
	}
	$score_count = $db->sql_numrows( $result ); //Gets the number of highscores for the current user
	$row = $db->sql_fetchrow($result);
		
	$lasthigh_date = create_date( $board_config['default_dateformat'] , $row['game_highdate'] , $board_config['board_timezone'] );
	$lasthigh_game = '<a href="' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>';

	$template->assign_vars(array(
		'YOURS_QUICK_STATS' => sprintf($lang['Yours_quick_stats'],$score_count,$favgame,$times_played,$lasthigh_date,$lasthigh_game)
	));
}		

$page_title = $lang['Arcade_Comments'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->pparse('body');
include("includes/page_tail.php");
?>
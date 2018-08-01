<?php
/***************************************************************************
*                               comments_list.php
*                              -------------------
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
include_once($phpbb_root_path .'includes/arca_bbcode.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management

/*
** Redirection des membres ---
*/
$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

if ( $userdata['session_logged_in'] != 1 )
{
	header($header_location . append_sid('login.' . $phpEx . '?redirect=comments_list.'.$phpEx, true));
	exit;
}	

$arcade_config = array();
$arcade_config = read_arcade_config();

# Censure
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

$comments_sql = 'SELECT * FROM ' . COMMENTS_TABLE.' WHERE message != \'\' '; 
if ( !($result_count = $db->sql_query($comments_sql)) ) 
{ 
	message_die(GENERAL_ERROR, 'Couldnot obtain comment count.', '', __LINE__, __FILE__, $sql); 
}
$count_rows = $db->sql_fetchrowset($result_count);
$comments_total= count($count_rows);

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$comments_perpage = 15;


$template->set_filenames(array( 
	'body' => 'comments_list_body.tpl')
	); 

$template->assign_vars(array(  
	'LISTING_ARCADE_COMMENTS' => $lang['Listing_arcade_comments'],
	'ARCADE_COMMENT' => $lang['Arcade_Comments'],
	'L_COMMENTS' => $lang['Comments'],
	'L_GAMES' => $lang['games'],
	'L_SCORES' => $lang['boardscore'],
	'L_PLAYERS' => $lang['players'],
	'NAV_DESC' => '<a class="nav" href="' . append_sid("arcade.$phpEx") . '">' . $lang['arcade'] . '</a> ' , 
	));
		
$sql = 'SELECT g.*, c.*, u.* FROM ' . GAMES_TABLE. ' g  LEFT JOIN ' . COMMENTS_TABLE . ' c  ON g.game_id = c.game_id  LEFT JOIN ' . USERS_TABLE .' u  ON g.game_highuser=u.user_id WHERE message != \'\' ORDER BY game_name ASC LIMIT '.$start.', '.$comments_perpage;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error retrieving high score list', '', __LINE__, __FILE__, $sql); 
}

while ( $row = $db->sql_fetchrow($result))
{
  $style_color = user_color($row['username'], $row['user_level']);
  if ( $row['user_id'] == ANONYMOUS ){
  $username = $row['username'];
  } else {
  $username = '<a href="' . append_sid("statarcade.$phpEx?uid=" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
  }

	# Saut de ligne
	$comment= str_replace("\n", "\n<br />\n", $row['message']);
	
	# Smilies
	if ( $board_config['allow_smilies'] )
	{
		$comment = smilies_pass2($comment);
	}
	# BBcode (fonction annexe créer par le fichier arca_bbcode.php)
	$comment =  bbencode_pass($comment);
	
	# Evite les déformation
	$comment = wordwrap($comment, 78, "\n", 1);
		
	# Censure
	if (count($orig_word)) 
	{            
		$comment = str_replace('\"', '"', substr(preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $comment . '<'), 1, -1)); 
	} 

$template->assign_block_vars('commentrow', array(  
	'GAME_NAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>', 
	'COMMENTS_VALUE' =>  $comment,
	'USERNAME' => $username,
  'HIGHSCORE' =>  $row['game_highscore']
	)); 
}

$template->assign_vars(array(
	'MANAGE_COMMENTS' => '<nobr><a class="cattitle" href="' . append_sid("comments.$phpEx") . '">' . $lang['manage_comments'] . '</a></nobr> ',
	'PAGINATION' => generate_pagination("comments_list.$phpEx?", $comments_total, $comments_perpage, $start),
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $comments_perpage) + 1 ), ceil( $comments_total / $comments_perpage )),
	'L_GOTO_PAGE' => $lang['Goto_page']
  ));


// Generate the page end
$page_title = $lang['Listing_arcade_comments'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->pparse('body');
include("includes/page_tail.php");

?>
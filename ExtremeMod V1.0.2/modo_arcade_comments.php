<?php
/***************************************************************************
*                               modo_arcade_comments.php
*                              --------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

global $prefix;

define('IN_PHPBB', 1); 

if( !empty($setmodules) ) 
{ 
   $file = basename(__FILE__); 
   $module['Administration_Arcade_VPro25']['Comment_Config'] = "$file";
   return; 
}

// 
// Let's set the root dir for phpBB 
// 
$phpbb_root_path = "./"; 
require($phpbb_root_path . 'extension.inc'); 
require('./pagestart_modo.' . $phpEx); 
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;	
$start = ($start < 0) ? 0 : $start;
$submit = (isset($HTTP_POST_VARS['submit'])) ? intval($HTTP_POST_VARS['submit']) : '';

generate_smilies('inline', PAGE_INDEX);
	   
if($mode == 'update')
{
	$game_id = intval($HTTP_POST_VARS['comment_id']);
	$message = ( !empty($HTTP_POST_VARS['message']) ) ? $HTTP_POST_VARS['message'] : '';

	$avs_txt = $message;
	$avs_txt = str_replace('<', '&lt;', $avs_txt); // >> supression des balise pour evité les script
	$avs_txt = str_replace('>', '&gt;', $avs_txt); // >> supression des balise pour evité les script
	
	$sql = "UPDATE " . COMMENTS_TABLE . " SET message = '" . str_replace("\'", "''", $avs_txt) . "' WHERE game_id = $game_id";	
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not insert row in comments table', '', __LINE__, __FILE__, $sql);
	}
			
	//Comment Updated/Added Successfully
	$message = "Commentaire mis à jour."; 
  $message .= "<br /><br />Cliquez <a href=\"games.php?gid=$game_id\">ici</a> pour retourner au jeu d'où vous venez."; 
	$message .= "<META HTTP-EQUIV=\"refresh\" content=\"5;URL=games.php?gid=$game_id\">";
	
	message_die(GENERAL_MESSAGE, $message);
	}

	if($mode == "edit")
	{
		
	$gid = $HTTP_GET_VARS['gid'];

	$template->set_filenames(array( 
	   'body' => 'modo_edit_comments_body.tpl'));
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
	$template->assign_block_vars('no_record',array(
		'NO_SCORED' => $lang['no_scored']));		
 } else {
generate_smilies('inline', PAGE_INDEX);

	$template->assign_block_vars('record',array());		

	//Gets comments from database
	$game_id =  (isset($HTTP_POST_VARS['comment_id'])) ? intval($HTTP_POST_VARS['comment_id']) : 0;
	$sql = 'SELECT g.game_id AS gid, g.game_name, c.*  FROM ' . GAMES_TABLE. ' g LEFT JOIN '. COMMENTS_TABLE . ' c ON g.game_id = c.game_id WHERE g.game_id = '.$gid;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error retrieving comment list', '', __LINE__, __FILE__, $sql); 
	}
	$row = $db->sql_fetchrow($result);

	$template->assign_vars(array(
		'ARCADE_COMMENT' => $lang['Arcade_Comments'],
		'ADD_EDIT_COMMENTS' => $lang['AddEdit_comment'],
		'QUICK_STATS' => $lang['Quick_stats'],
		'L_SUBMIT' => $lang['Submit'],
		'ENTER_ARCADE_COMMENT' => $lang['Enter_arcade_comment'],
		'L_GAME_NAME' => $lang['Game_name'],
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
		'NAV_DESC' => '<a class="nav" href="' . append_sid("arcade.$phpEx") . '">' . $lang['arcade'] . '</a> ' ,
		'GAME_NAME' => '<a href="' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>', 
		'GAME_ID' => $row['game_id'],
		'MESSAGE' => $row['message'],
		'S_ACTION' => append_sid('modo_arcade_comments.' . $phpEx . '?mode=update'), 
		));

	$template->pparse('body'); 

	include('./includes/page_tail.'.$phpEx);

	}
 
	$comments_sql = "SELECT * FROM " . COMMENTS_TABLE . " WHERE message <> '' "; 

	if ( !($result_count = $db->sql_query($comments_sql)) ) 
   { 
     // Error if it fails... 
     message_die(GENERAL_ERROR, "Couldn't obtain comment count.", "", __LINE__, __FILE__, $sql); 
   }
	
	$count_rows = $db->sql_fetchrowset($result_count);
	$comments_total= count($count_rows);

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
	$comments_perpage = 30;


$template->set_filenames(array( 
   'body' => 'modo_edit_comments_body.tpl')); 

				
$sql = "SELECT g.*, c.*, u.* FROM " . GAMES_TABLE. " g LEFT JOIN " . COMMENTS_TABLE . " c ON g.game_id = c.game_id LEFT JOIN " . USERS_TABLE ." u  ON g.game_highuser=u.user_id WHERE message <> '' ORDER BY game_name ASC LIMIT $start, $comments_perpage";
			if( !($result = $db->sql_query($sql)) )
			{
			message_die(GENERAL_ERROR, "Error retrieving high score list", '', __LINE__, __FILE__, $sql); 
			}

while ( $row = $db->sql_fetchrow($result))
			{
			
			$template->assign_block_vars('commentrow', array(  
			'GAME_NAME' => '<a href=" ' . append_sid("games.$phpEx?gid=" . $row['game_id']) . '">' . $row['game_name'] . '</a>', 
			'COMMENTS_VALUE' =>  $row['message'],
			'USERNAME' => '<a href=" ' . append_sid("statarcade.$phpEx?uid=" . $row['user_id'] ) . '" class="genmed">' . $row['username'] . '</a> ',
      'EDIT_COMMENTS' => '<a href=" ' . append_sid("modo_arcade_comments.$phpEx?mode=edit&gid=" . $row['game_id']) . '">Editer le commentaire</a>')
			); 
			}

      $template->assign_vars(array(
      'PAGINATION' => generate_pagination("modo_arcade_comments.$phpEx?", $comments_total, $comments_perpage, $start),
      'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $comments_perpage) + 1 ), ceil( $comments_total / $comments_perpage )),
      'L_GOTO_PAGE' => $lang['Goto_page'])
      );
     }

//
// Generate the page end
//

$template->pparse('body'); 

include('./includes/page_tail.'.$phpEx); 

?>
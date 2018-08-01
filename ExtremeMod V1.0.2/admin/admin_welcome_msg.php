<?php
/***************************************************************************
 *                              admin_welcome_msg.php
 *                            -------------------------
 *   fait le                : 1er Août 2003
 *   Par : giefca - http://www.gf-phpbb.fr.st
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Mini module pour un Gf-Portail
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{

	$filename = basename(__FILE__);
	$module['Admin_portal_module']['Module_Bienvenue'] = $filename;
	return;
}


//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);


function generate_smilies_bm($mode)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	$inline_columns = 5;
	$inline_rows = 4;
	$window_columns = 8;

	if ( $mode == 'window' )
	{

		$gen_simple_header = TRUE;

		$page_title = $lang['Review_topic'] . " - $topic_title";

		$template->set_filenames(array(
			'smiliesbody' => 'posting_smilies.tpl')
		);
	}

	$sql = "SELECT emoticon, code, smile_url   
		FROM " . SMILIES_TABLE . " 
		ORDER BY smilies_id";
	if ( $result = $db->sql_query($sql) )
	{
		$num_smilies = 0;
		$rowset = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( empty($rowset[$row['smile_url']]) )
			{
				$rowset[$row['smile_url']]['code'] = str_replace('\\', '\\\\', str_replace("'", "\\'", $row['code']));
				$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
				$num_smilies++;
			}
		}

		if ( $num_smilies )
		{
			$smilies_count = ( $mode == 'inline' ) ? min(19, $num_smilies) : $num_smilies;
			$smilies_split_row = ( $mode == 'inline' ) ? $inline_columns - 1 : $window_columns - 1;

			$s_colspan = 0;
			$row = 0;
			$col = 0;

			while ( list($smile_url, $data) = @each($rowset) )
			{
				if ( !$col )
				{
					$template->assign_block_vars('smilies_row', array());
				}

				$template->assign_block_vars('smilies_row.smilies_col', array(
					'SMILEY_CODE' => $data['code'],
					'SMILEY_IMG' => $phpbb_root_path . $board_config['smilies_path'] . '/' . $smile_url,
					'SMILEY_DESC' => $data['emoticon'])
				);

				$s_colspan = max($s_colspan, $col + 1);

				if ( $col == $smilies_split_row )
				{
					if ( $mode == 'inline' && $row == $inline_rows - 1 )
					{
						break;
					}
					$col = 0;
					$row++;
				}
				else
				{
					$col++;
				}
			}

			if ( $mode == 'inline' && $num_smilies > $inline_rows * $inline_columns )
			{
				$template->assign_block_vars('switch_smilies_extra', array());

				$template->assign_vars(array(
					'L_MORE_SMILIES' => $lang['More_emoticons'], 
					'U_MORE_SMILIES' => append_sid("admin_welcome_msg.$phpEx?mode=smilies"))
				);
			}

			$template->assign_vars(array(
				'L_EMOTICONS' => $lang['Emoticons'], 
				'L_CLOSE_WINDOW' => $lang['Close_window'], 
				'S_SMILIES_COLSPAN' => $s_colspan)
			);
		}
	}

	if ( $mode == 'window' )
	{
		$template->pparse('smiliesbody');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}


$welcome_msg = ( isset($HTTP_POST_VARS['message']) ) ? $HTTP_POST_VARS['message'] : "(empty)";

if ( !empty($HTTP_POST_VARS['save']) )
{
	$mode = "save";
}
elseif ( !empty($HTTP_POST_VARS['preview']) )
{
	$mode = "preview";
}
else
{
	//
	// Check to see what mode we should operate in.
	//
	if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
	{
		$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	}
	else
	{
		$mode = "";
	}
}

if ( $mode == "smilies" )
{
	generate_smilies_bm('window');
	exit;
}

$template->set_filenames(array(
	'body' => 'admin/welcome_msg_body.tpl')
);

if ( $mode == 'save' )
{
	$html_on = $board_config['allow_html'];
	$bbcode_on = $board_config['allow_bbcode'];
	$smilies_on = $board_config['allow_smilies'];

		// Check welcome message
		if ( !empty($welcome_msg) )
		{
			if ( $bbcode_uid == "" ) 
			{ 
				$bbcode_uid = ( $bbcode_on ) ?  make_bbcode_uid() : '';
			}	
			$welcome_msg = prepare_message( trim( $welcome_msg ), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
		}
	
		$sql = "UPDATE " . PORTAL_WELCOME_TABLE . " SET	welcome_msg = '" . str_replace("\'", "''", $welcome_msg) . "', bbcode_uid = '" . $bbcode_uid . "'";
	
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update welcome message", "", __LINE__, __FILE__, $sql);
		}
		else
		{
			$message = $lang['welcome_msg_updated'] . "<br /><br />" . sprintf($lang['Click_return_welcome_admin'], "<a href=\"" . append_sid("admin_welcome_msg.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
}

if ( $mode == 'preview')
{
	if ( $welcome_msg != "" )
	{
		$html_on = $board_config['allow_html'];
		$bbcode_on = $board_config['allow_bbcode'];
		$smilies_on = $board_config['allow_smilies'];

		if ( ( $bbcode_uid == "" ) or !$bbcode_on )
		{ 
			$bbcode_uid = ( $bbcode_on ) ? make_bbcode_uid() : '';
		}	
		$msg_preview = prepare_message( trim($welcome_msg), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
		$msg_preview = nl2br( $msg_preview );
		$msg_preview = bbencode_second_pass( $msg_preview , $bbcode_uid ) ;
		$sv_smilies_path = $board_config['smilies_path'] ;
		$board_config['smilies_path'] = "../" . $board_config['smilies_path'] ;
		$msg_preview = smilies_pass( $msg_preview );
		$board_config['smilies_path'] = $sv_smilies_path ;
		$msg_preview = make_clickable( $msg_preview );
		$msg_preview = stripslashes($msg_preview) ;
		$welcome_msg = stripslashes($welcome_msg) ;
		}
	else
	{
		$msg_preview = "" ;
	}
	$template->assign_block_vars( 'preview_row', array(
	'MSG_PREVIEW' => $msg_preview ) 
	) ;
}
else
{	
	$sql = "SELECT * FROM " . PORTAL_WELCOME_TABLE ;
	
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query board messages', '', __LINE__, __FILE__, $sql);
	}
	
	if ( $row = $db->sql_fetchrow($result) )
	{
		$welcome_msg = $row['welcome_msg'];		
		$bbcode_uid = $row['bbcode_uid'];		

		if ( $row['bbcode_uid'] != '' )
		{
			$welcome_msg = preg_replace('/\:(([a-z0-9]:)?)' . $row['bbcode_uid'] . '/s', '', $welcome_msg);
		}

		//$welcome_msg = str_replace('<', '&lt;', $welcome_msg);
		//$welcome_msg = str_replace('>', '&gt;', $welcome_msg);
		$welcome_msg = str_replace('<br />', "\n", $welcome_msg);
	}
	else
	{
		$sql = "INSERT INTO " . PORTAL_WELCOME_TABLE . " ( welcome_msg ) VALUES ( '(empty)' ) " ;	
		$welcome_msg = '(empty)' ;
		$bbcode_uid = '' ;
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to access welcome message table", "", __LINE__, __FILE__, $sql);
		}
	}
}	


//
// HTML toggle selection
//
if ( $board_config['allow_html'] )
{
	$html_status = $lang['HTML_is_ON'];
}
else
{
	$html_status = $lang['HTML_is_OFF'];
}
	
//
// BBCode toggle selection
//
if ( $board_config['allow_bbcode'] )
{
	$bbcode_status = $lang['BBCode_is_ON'];
}
else
{
	$bbcode_status = $lang['BBCode_is_OFF'];
}

//
// Smilies toggle selection
//
if ( $board_config['allow_smilies'] )
{
	$smilies_status = $lang['Smilies_are_ON'];
}
else
{
	$smilies_status = $lang['Smilies_are_OFF'];
}
generate_smilies_bm('inline');
	
$template->set_filenames(array(
	"body" => "admin/welcome_msg_body.tpl")
		);
	
$s_hidden_fields = '<input type="hidden" name="bbcode_uid" value="' . $bbcode_uid . '" />';

$template->assign_vars(array(
	'L_WELCOME_MSG' => $lang['Adm_Bienvenue_module'],
	'L_WELCOME_MSG_EXPLAIN' => $lang['Adm_Bienvenue_explain'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'],
	'L_PREVIEW' => $lang['Preview'],
	'HTML_STATUS' => $html_status,
	'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("../faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
	'SMILIES_STATUS' => $smilies_status, 
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
	'L_ACTION' => "save", 
	'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'], 
	'L_STYLES_TIP' => $lang['Styles_tip'],

	'WELCOME_MSG' => $welcome_msg,
	'U_PREVIEW' => append_sid("admin_welcome_msg.$phpEx?mode=preview"),
	'S_HIDDEN_FIELDS' => $s_hidden_fields,
	'S_WELCOME_MSG_ACTION' => append_sid("admin_welcome_msg.$phpEx"),
));

$template->pparse("body");
include('page_footer_admin.'.$phpEx);

?>

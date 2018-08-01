<?php
/***************************************************************************
 *                            mood_mod.php
 *                           --------------
 *		Version			: 1.0.10
 *		Email			: austin@phpbb-amod.com
 *		Site			: http://phpbb-tweaks.com
 *		Copyright		: aUsTiN-Inc 2003/5
 *
 ***************************************************************************/
	
define('IN_PHPBB', true);
$phpbb_root_path = './';
include_once($phpbb_root_path .'extension.inc');
include_once($phpbb_root_path .'common.'. $phpEx);

/* Start session management */
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
/* End session management */	
	
include_once($phpbb_root_path .'language/lang_'. $board_config['default_lang'] .'/lang_mood_mod.'. $phpEx);	
$gen_simple_header = TRUE;
$page_title = $lang['MM_page_title'];
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$mode = ($_GET['mode']) ? $_GET['mode'] : $HTTP_GET_VARS['mode'];
		if (!$mode)
			$mode = ($_POST['mode']) ? $_POST['mode'] : $HTTP_POST_VARS['mode'];
			
	$action = ($_GET['action']) ? $_GET['action'] : $HTTP_GET_VARS['action'];
		if (!$action)
			$action = ($_POST['action']) ? $_POST['action'] : $HTTP_POST_VARS['action'];
			
	$template->set_filenames(array('body' => 'mood_mod_body.tpl'));

	#==== Guests cant set moods!
	if ($userdata['user_id'] == ANONYMOUS)
		echo '<body onload="window.close();"></body>';
		
	if ($mode == 'image')
		{
	$mood 	= ($_POST['mood']) ? $_POST['mood'] : $HTTP_POST_VARS['mood'];
	$folder = ($_POST['folder']) ? $_POST['folder'] : $HTTP_POST_VARS['folder'];
	
	if (empty($mood))
		message_die(GENERAL_ERROR, $lang['MM_error']);
	
	$mood = trim($mood);
	$mood = rtrim($mood);
	$mood = addslashes(stripslashes($mood));
	
	$folder = trim($folder);
	$folder = rtrim($folder);
	$folder = addslashes(stripslashes($folder));	
	
	$path = $phpbb_root_path .'images/mood_mod_images/'. $folder .'/'. $mood;
	
	$q = "UPDATE ". USERS_TABLE ."
		  SET user_mood_mod = '". $path ."'
		  WHERE user_id = '". $userdata['user_id'] ."'";
	$db->sql_query($q);
	
	message_die(GENERAL_MESSAGE, $lang['MM_saved']);
		}
		
	if ($mode == 'folder')
		{
	$folder_name = ($_POST['folder_choice']) ? $_POST['folder_choice'] : $HTTP_POST_VARS['folder_choice'];
	$template->assign_block_vars('image_select', array());	
	$image_options 	= '';
	$image_count 	= 0;
	$image_break 	= 4;
	
	$image_options	.= '<form name="image_select" method="post" action="mood_mod.'. $phpEx .'?sid='. $userdata['session_id'] .'">';
	$dir 	= $phpbb_root_path .'images/mood_mod_images/'. $folder_name .'/';
	$moods 	= @opendir($dir);
		while ($images = @readdir($moods)) 
			{			
			if ( ($images != ".") && ($images != "..") && ($images != "index.htm") )
				{
			$image_count++;
			$alt = explode('.', $images);
			$image_options .= '<img alt="'. str_replace('_', ' ', $alt[0]) .'" title="'. str_replace('_', ' ', $alt[0]) .'" src="images/mood_mod_images/'. $folder_name .'/'. $images .'" border="0">&nbsp;<input type="radio" value="'. $images .'" name="mood">&nbsp;&nbsp;';
				if ($image_count == $image_break)
					{
				$image_options .= '<br clear="all"><br>';
				$image_count = 0;
					}
				}
			}
	@closedir($moods);
	
	$image_options	.= '<input type="hidden" name="mode" value="image">';
	$image_options	.= '<input type="hidden" name="folder" value="'. $folder_name .'">';	
	$image_options	.= '<br><br><input type="submit" onclick="document.image_select.submit()" value="'. $lang['MM_option_two_sub'] .'" class="mainoption">';
	$image_options	.= '</form>';		
		}
		
	if (!$mode)
		{
	$template->assign_block_vars('folder_select', array());
	$folder_select = '<form name="folder_selection" method="post" action="mood_mod.'. $phpEx .'">';
	$folder_select .= '<select name="folder_choice">';
	$folder_select .= '<option value="" class="post">-----</option>';
	$dir 	= $phpbb_root_path .'images/mood_mod_images/';
	$moods 	= @opendir($dir);
		while ($folders = @readdir($moods)) 
			{			
			if ( ($folders != ".") && ($folders != "..") && ($folders != "index.htm") )
				$folder_select .= '<option value="'. $folders .'" class="post">'. $folders .'</option>';
			}	
	$folder_select .= '</select>';
	$folder_select .= '<input type="hidden" name="mode" value="folder">';
	$folder_select .= '<br><br><input type="submit" onclick="document.folder_selection.submit()" value="'. $lang['MM_option_one_sub'] .'" class="mainoption">';
	$folder_select .= '</form>';
	@closedir($moods);		
		}	
	
	$template->assign_vars(array(
		'CHOICES'		=> $lang['MM_option_one'],
		'IMG_CHOICES'	=> $lang['MM_option_two'],
		'FOLDERS'		=> $folder_select,
		'IMAGES'		=> $image_options)
			);
				
$template->pparse('body');

/* Give credit where credit is due. */
echo "<table width='100%' border='0'>
		<tr>
			<td align='left' valign='top' colspan='1'>
				<a style='TEXT-DECORATION:NONE;' href='http://phpbb-tweaks.com' target='_blank'><span class='gensmall'>&copy; Mood Mod</a></span>
			</td>
		</tr>
	  </table>";
include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>
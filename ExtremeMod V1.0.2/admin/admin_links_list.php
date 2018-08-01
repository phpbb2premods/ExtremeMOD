<?php
/***************************************************************************
 *								admin_links_list.php
 *								-------------------
 *   realisé par Giefca
 *   le 27 Juillet 2003
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Admin_portal_module']['Module_links'] = $filename;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Set variables
//

if ( isset($HTTP_GET_VARS['lid']) || isset($HTTP_POST_VARS['lid']) )
{
	$lid = ( isset($HTTP_GET_VARS['lid']) ) ? $HTTP_GET_VARS['lid'] : $HTTP_POST_VARS['lid'] ;
}
else
{
  	$lid = "" ;
}


if ( isset($HTTP_POST_VARS['save']) or isset($HTTP_POST_VARS['editsave']) )
{
	$link_url = ( isset($HTTP_POST_VARS['linkurl']) ) ? $HTTP_POST_VARS['linkurl'] : "" ;
	$link_text =  ( isset($HTTP_POST_VARS['linktext']) ) ? $HTTP_POST_VARS['linktext'] : "" ;
	$link_img =  ( isset($HTTP_POST_VARS['imgurl']) ) ? $HTTP_POST_VARS['imgurl'] : "" ;
	$link_imgwidth = ( isset($HTTP_POST_VARS['imgwidth']) ) ? $HTTP_POST_VARS['imgwidth'] : "" ;
	if ( $link_imgwidth != "" ) $link_imgwidth = intval( $link_imgwidth) ;	
	$link_imgheight = ( isset($HTTP_POST_VARS['imgheight']) ) ? $HTTP_POST_VARS['imgheight'] : "" ;
	if ( $link_imgheight != "" ) $link_imgheight = intval( $link_imgheight) ;
	$link_active = ( isset($HTTP_POST_VARS['linkactive']) ) ? $HTTP_POST_VARS['linkactive'] : "" ;
	if ( $link_active != "" ) $link_active = intval( $link_active) ;
	
	if ( isset($HTTP_POST_VARS['save']) )
	{
		$sql = "INSERT INTO " . LINKS_TABLE . " ( link_url, link_text, link_img, link_imgwidth, link_imgheight, link_active) 
		 VALUES ( '$link_url', '$link_text', '$link_img', '$link_imgwidth', '$link_imgheight', '$link_active') ";
	}
	else
	{
		$sql = "UPDATE " . LINKS_TABLE . " SET link_url = '$link_url', link_text = '$link_text', link_img = '$link_img', link_imgwidth = '$link_imgwidth', link_imgheight = '$link_imgheight',
		 link_active = '$link_active' WHERE link_id = '$lid'";
	}
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update Links table", "", __LINE__, __FILE__, $sql);
	}
}

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'] ;
}
else
{
  	$mode = "" ;
}

if ( $mode == 'delete' )
{
	$sql = "DELETE FROM " . LINKS_TABLE . " WHERE link_id = '$lid' " ;
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update Links table", "", __LINE__, __FILE__, $sql);
	}	
}


if ( ( $mode == 'edit' ) or ( $mode == 'add' ) )	
{
	$template->set_filenames(array(
		'body' => 'admin/link_edit_body.tpl')
	);

	$link_url = "" ;
	$link_text = "" ;
	$link_img = "" ;
	$link_imgwidth = "" ;
	$link_imgheight = "" ;
	$link_active_yes = "checked=\"checked\"" ;
	$link_active_no = "" ;	
	$s_hidden_fields = "<input type='hidden' name='lid' value='" . intval($HTTP_GET_VARS['lid']) . "' />";
	
	if ( ( $mode == 'edit' ) and isset($HTTP_GET_VARS['lid']) )
	{
		$lid = intval($HTTP_GET_VARS['lid']);
		$sql = "SELECT * FROM " . LINKS_TABLE . " WHERE link_id = '$lid'" ;
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not get Link information", "", __LINE__, __FILE__, $sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			$link_url = $row['link_url'] ;
			$link_text = $row['link_text'] ;
			$link_img = $row['link_img'] ;
			$link_imgwidth = $row['link_imgwidth'] ;
			$link_imgheight = $row['link_imgheight'] ;
			$link_active_yes = ( $row['link_active'] ) ? "checked=\"checked\"" : "";
			$link_active_no = ( !$row['link_active'] ) ? "checked=\"checked\"" : "";
		}
	}
	
	$template->assign_vars(array(
		'L_LINK_TITLE' => $lang['Manage_portal_link'],
		'L_LINK_EXPLAIN' => $lang['Manage_portal_link_explain'],
		'L_LINK_SETTINGS' => $lang['general_link_option'],
		'L_LINK_URL' => $lang['portal_link_url'],
		'L_LINK_DESCRIPTION' => $lang['portal_link_text'],
		'L_IMG_URL' => $lang['portal_link_img'],
		'L_IMG_URL_EXPLAIN' => $lang['portal_link_img_explain'],
		'L_IMG_WIDTH' => $lang['portal_link_imgwidth'],
		'L_IMG_WIDTH_EXPLAIN' => $lang['portal_link_imgwidth_explain'],
		'L_IMG_HEIGHT' => $lang['portal_link_imgheight'],
		'L_IMG_HEIGHT_EXPLAIN' => $lang['portal_link_imgheight_explain'],
		'L_ENABLED' => $lang['link_enabled'],
		'L_ENABLED_EXPLAIN' => $lang['link_enabled_explain'],		
		'LINK_ACTIVE_YES' => $link_active_yes,
		'LINK_ACTIVE_NO' => $link_active_no,
		'LINK_URL' => $link_url,
		'LINK_TEXT' => $link_text,
		'IMG_URL' => $link_img,
		'IMG_WIDTH' => $link_imgwidth,
		'IMG_HEIGHT' => $link_imgheight,
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'L_SUBMIT' => $lang['Submit'],		
		'S_SUBMIT' => ( $mode == 'add' ) ? 'save' : $mode . 'save',
		'S_HIDDEN_FIELDS' => $s_hidden_fields,		
		'S_LINK_ACTION' =>  append_sid("admin_links_list.$phpEx"))
	);
	
}
else
{
	$links_per_page = 30;
	$start = (isset($HTTP_GET_VARS['start'])) ? $HTTP_GET_VARS['start'] : 0;
	
	$template->set_filenames(array(
		'body' => 'admin/admin_links_list_body.tpl')
	);
	$s_hidden_fields = "<input type='hidden' name='mode' value='add' />";
	$template->assign_vars(array(
		'L_ADMIN_LINKS_LIST_TITLE' => $lang['Admin_Links_List_Title'],
		'L_ADMIN_LINKS_LIST_EXPLAIN' => $lang['Admin_Links_List_Explain'],
		'U_LIST_ACTION' => append_sid("admin_links_list.$phpEx"),
		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'],
		'ID_LINK' => $lang['Id_link'],
		'L_LINKURL' => $lang['Linkurl'],
		'L_LINKIMG' => $lang['Linkimg'],
		'L_LINKTEXT' => $lang['Link_description'],
		'L_LINKIMGW' => $lang['Link_img_width'],
		'L_LINKIMGH' => $lang['Link_img_height'],
		'L_LINKACTIVE' => $lang['LinkActive'],
		'L_SUBMIT' => $lang['add_portal_link'],		
		'S_SUBMIT' => 'add',		
		'S_HIDDEN_FIELDS' => $s_hidden_fields,
		'S_LINK_ACTION' =>  append_sid("admin_links_list.$phpEx"))
	);

	// Count links
	$sql = "SELECT link_id FROM " . LINKS_TABLE . " WHERE link_id > 0 ";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not count Link", "", __LINE__, __FILE__, $sql);
	}
	$total_links = $db->sql_numrows($result);

	// Query links info...
	$sql = "SELECT * FROM " . LINKS_TABLE . " WHERE link_id > 0 LIMIT " . $start . "," . $links_per_page;
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query links information", "", __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$linkrow[] = $row;
	}

	for ($i = 0; $i < $links_per_page; $i++)
	{
		if (empty($linkrow[$i]))
		{
			break;
		}
	
		$row_color = (($i % 2) == 0) ? "row1" : "row2";
		
		$template->assign_block_vars('linkrow', array(
			'COLOR' => $row_color,
			'NUMBER' => ($start + $i + 1),
			'U_EDIT_LINK' => append_sid("admin_links_list.$phpEx?mode=edit&amp;lid=" . $linkrow[$i]['link_id']),
			'U_DELETE_LINK' => append_sid("admin_links_list.$phpEx?mode=delete&amp;lid=" . $linkrow[$i]['link_id']),
			'LINKURL' => $linkrow[$i]['link_url'],
			'U_ADMIN_LINK' => append_sid("admin_links_list.$phpEx?mode=edit&amp;" . POST_USERS_URL . "=" . $userrow[$i]['user_id']),
			'LINKIMG' => $linkrow[$i]['link_img'],
			'LINKTEXT' => $linkrow[$i]['link_text'],
			'LINKACTIVE' => ( $linkrow[$i]['link_active'] ) ? $lang['Yes'] : $lang['No']
			) //end array
		);
	} // end for

	$template->assign_vars(array(
		'PAGINATION' => generate_pagination(append_sid("admin_links_list.$phpEx"), $total_links, $links_per_page, $start),
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $links_per_page ) + 1 ), ceil( $total_links / $links_per_page ))
		) // end array
	);

}

// Finally...
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
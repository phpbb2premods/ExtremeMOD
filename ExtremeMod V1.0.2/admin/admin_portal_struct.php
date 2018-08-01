<?php
/***************************************************************************
 *                              admin_portal_struct.php
 *                            -------------------------
 *   fait le                : Mercredi,23 Juillet, 2003
 *   Par : giefca - http://www.gf-phpbb.fr.st
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Mise en forme de la structure du portail. (disposition des modules).
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Admin_portal']['Struct_admin_portal'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
$moveright = ( isset($HTTP_GET_VARS['moveright']) ) ? $HTTP_GET_VARS['moveright'] : $HTTP_POST_VARS['moveright'];
$moveleft = ( isset($HTTP_GET_VARS['moveleft']) ) ? $HTTP_GET_VARS['moveleft'] : $HTTP_POST_VARS['moveleft'];

$str = ( isset($HTTP_GET_VARS['str']) ) ? intval($HTTP_GET_VARS['str']) : intval($HTTP_POST_VARS['str']);
$str2 = ( isset($HTTP_GET_VARS['str2']) ) ? intval($HTTP_GET_VARS['str2']) : intval($HTTP_POST_VARS['str2']);
$ord = ( isset($HTTP_GET_VARS['ord']) ) ? intval($HTTP_GET_VARS['ord']) : intval($HTTP_POST_VARS['ord']);
$ord2 = ( isset($HTTP_GET_VARS['ord2']) ) ? intval($HTTP_GET_VARS['ord2']) : intval($HTTP_POST_VARS['ord2']);
$colid = ( isset($HTTP_GET_VARS['colid']) ) ? intval($HTTP_GET_VARS['colid']) : intval($HTTP_POST_VARS['colid']);
$modid = ( isset($HTTP_GET_VARS['modid']) ) ? intval($HTTP_GET_VARS['modid']) : intval($HTTP_POST_VARS['modid']);

$page_id = ( isset($HTTP_GET_VARS['pid']) ) ? intval($HTTP_GET_VARS['pid']) : intval($HTTP_POST_VARS['pid']);

$page_desc = ( isset($HTTP_GET_VARS['page_desc']) ) ? $HTTP_GET_VARS['page_desc'] : $HTTP_POST_VARS['page_desc'];
$page_forum_header = ( isset($HTTP_GET_VARS['page_forum_header']) ) ? $HTTP_GET_VARS['page_forum_header'] : $HTTP_POST_VARS['page_forum_header'];
$page_defaultsize =  ( isset($HTTP_GET_VARS['page_defaultsize']) ) ? $HTTP_GET_VARS['page_defaultsize'] : $HTTP_POST_VARS['page_defaultsize'];
$page_col1width =  ( isset($HTTP_GET_VARS['page_col1width']) ) ? $HTTP_GET_VARS['page_col1width'] : $HTTP_POST_VARS['page_col1width'];
$page_col1unit =  ( isset($HTTP_GET_VARS['page_col1unit']) ) ? $HTTP_GET_VARS['page_col1unit'] : $HTTP_POST_VARS['page_col1unit'];
$page_col2width =  ( isset($HTTP_GET_VARS['page_col2width']) ) ? $HTTP_GET_VARS['page_col2width'] : $HTTP_POST_VARS['page_col2width'];
$page_col2unit =  ( isset($HTTP_GET_VARS['page_col2unit']) ) ? $HTTP_GET_VARS['page_col2unit'] : $HTTP_POST_VARS['page_col2unit'];
$page_col3width =  ( isset($HTTP_GET_VARS['page_col3width']) ) ? $HTTP_GET_VARS['page_col3width'] : $HTTP_POST_VARS['page_col3width'];
$page_col3unit =  ( isset($HTTP_GET_VARS['page_col3unit']) ) ? $HTTP_GET_VARS['page_col3unit'] : $HTTP_POST_VARS['page_col3unit'];

// Read Portal Configuration from DB
$portal_config = array();
$sql = "SELECT * FROM " . PORTAL_TABLE;

if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query portal config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$portal_config[ $row['portal_name'] ] = $row['portal_value'];
}

// si ces 2 variables n'ont pas été redéfinies dans le fichier .cfg du template, on leur donne
// des valeurs par défaut.
if ( !isset( $board_config['portal_class_balise'])) $board_config['portal_class_balise'] = "th" ; 
if ( !isset( $board_config['portal_class_title'])) $board_config['portal_class_title'] = "catTop" ;


switch ( $mode )
{
	case 'default' :
		if ( $page_id != $portal_config['default_struct'] )
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET portal_value = $page_id WHERE portal_name = 'default_struct' ";
			if(!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not update portal config table!", "", __LINE__, __FILE__, $sql);
			}
			$portal_config['default_struct'] = $page_id ;
		}
	$page_id = 0 ;
	break;
	case 'duplique' :
		$sql = "SELECT * FROM " . PORTAL_STRUCT . " WHERE page_id = $page_id " ;
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not query portal struct table!", "", __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$liste_mods[] = $row ;
		}
		$sql = "SELECT * FROM " . PORTAL_PAGE . " WHERE page_id = $page_id " ;
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not query portal page table!", "", __LINE__, __FILE__, $sql);
		}
		if ( !$row = $db->sql_fetchrow($result) )
		{
			message_die(GENERAL_ERROR, "the page : pid=$page_id , doesn\'t exist." );
		}
		$sql = "INSERT INTO " . PORTAL_PAGE . " (page_desc) VALUES ('" . $row['page_desc'] . "**')" ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal page table!", "", __LINE__, __FILE__, $sql);
		}
		$sql = "SELECT MAX(page_id) AS page_id FROM " . PORTAL_PAGE ;		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not query portal page table!", "", __LINE__, __FILE__, $sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			$new_page_id = $row['page_id'] ;
		}
		else
		{
			message_die(GENERAL_MESSAGE,'Aucune structure dans la table!');
		}
		// on duplique tous les enregistrements de la structure initiale
		for ( $i=0 ; $i<count($liste_mods) ; $i++ )
		{
			$sql = "INSERT INTO " . PORTAL_STRUCT . "( page_id, mod_id, struct_col, struct_order ) VALUES ( $new_page_id, " . $liste_mods[$i]['mod_id'] .
			", " . $liste_mods[$i]['struct_col'] . ", " . $liste_mods[$i]['struct_order'] . ")";
			if(!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not update portal struct table!", "", __LINE__, __FILE__, $sql);
			}
		}
		
	$page_id = 0 ;
	break;
	case 'deletestruct' :
		$sql = "DELETE FROM " . PORTAL_STRUCT . " WHERE page_id = $page_id " ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal struct table!", "", __LINE__, __FILE__, $sql);
		}
		$sql = "DELETE FROM " . PORTAL_PAGE . " WHERE page_id = $page_id " ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal page table!", "", __LINE__, __FILE__, $sql);
		}
	$page_id = 0 ;
	break;
	case 'createstruct'	:
	case 'editstruct' :
				if ( $mode == 'editstruct')
				{
					$sql = "SELECT * FROM " . PORTAL_PAGE . "  WHERE page_id = '$page_id' ";
					if( !$result = $db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Could not access portal page table!", "", __LINE__, __FILE__, $sql);
					}
					if ( $row = $db->sql_fetchrow($result) )
					{
					}				
					$s_hidden_fields = '<input type="hidden" name="pid" value="' . $page_id .'" />';
					$s_hidden_fields .= '<input type="hidden" name="mode" value="editsave" />';
					$defaultsize_yes = ( $row['page_defaultsize'] ) ? "checked=\"checked\"" : "";
					$defaultsize_no = ( !$row['page_defaultsize'] ) ? "checked=\"checked\"" : "";
					$page_forum_header_default = ( $row['display_header']== -1 ) ? "checked=\"checked\"" : "";
					$page_forum_header_no = ( $row['display_header'] == 0 ) ? "checked=\"checked\"" : "";
					$page_forum_header_yes = ( $row['display_header']== 1 ) ? "checked=\"checked\"" : "";

					$col1_percent = ( $row['page_col1unit'] == 'percent' ) ? "selected" : "";
					$col1_pixel = ( $row['page_col1unit'] == 'pixel' ) ? "selected" : "";
					$col2_percent = ( $row['page_col2unit'] == 'percent' ) ? "selected" : "";
					$col2_pixel = ( $row['page_col2unit'] == 'pixel' ) ? "selected" : "";
					$col3_percent = ( $row['page_col3unit'] == 'percent' ) ? "selected" : "";
					$col3_pixel = ( $row['page_col3unit'] == 'pixel' ) ? "selected" : "";
				}
				else if ( $mode == 'createstruct')
				{
					$defaultsize_yes = "checked=\"checked\"";
					$defaultsize_no = "";
					$s_hidden_fields .= '<input type="hidden" name="mode" value="createsave" />';
				}

				$template->set_filenames(array(
					"body" => "admin/page_edit_body.tpl")
				);
				
				$template->assign_vars(array(
					"S_PAGE_ACTION" => append_sid("admin_portal_struct.$phpEx"),
					"S_HIDDEN_FIELDS" => $s_hidden_fields,
					"S_SUBMIT_VALUE" => $lang['Submit'],
					"L_GENERAL_OPTION" => $lang['General_page_options'],
					"S_AUTH" => $liste_auth, 		
					"L_PAGES_TITLE" => $lang['Page_manage_portal'],
					"L_PAGES_ADD_TEXT" => $lang['Page_manage_explain'],
					"PAGE_DESC" => ($mode == 'editstruct') ? stripslashes($row['page_desc']) : stripslashes($page_desc),
					"L_PAGE_DESC" => $lang['page_description'],
					"L_PAGE_FORUM_HEADER" => $lang['Page_forum_header'],
					"L_PAGE_FORUM_HEADER_EXPLAIN" => $lang['Page_forum_header_explain'],
					"L_PORTAL_DEFAULT" => $lang['Portal_default'],
					"S_PAGE_FORUM_HEADER_DEFAULT" => $page_forum_header_default,
					"S_PAGE_FORUM_HEADER_YES" => $page_forum_header_yes,
					"S_PAGE_FORUM_HEADER_NO" => $page_forum_header_no,
					"L_PAGE_DEFAULTSIZE" => $lang['page_defaultsize'],
					"L_PAGE_DEFAULTSIZE_EXPLAIN" => $lang['page_defaultsize_explain'],
					"S_DEFAULTSIZE_YES" => $defaultsize_yes,
					"S_DEFAULTSIZE_NO" => $defaultsize_no,					
					"L_WIDTH_COL1" => $lang['Width_col1'],
					"L_WIDTH_COL2" => $lang['Width_col2'],
					"L_WIDTH_COL3" => $lang['Width_col3'],
					"L_PERCENT" => $lang['unit_percent'],
					"L_PIXEL" => $lang['unit_pixel'],
					"COL1_PERCENT" => $col1_percent,
					"COL1_PIXEL" => $col1_pixel,
					"WIDTH_COL1" => ($mode == 'editstruct') ? $row['page_col1width'] : "",
					"COL2_PERCENT" => $col2_percent,
					"COL2_PIXEL" => $col2_pixel,
					"WIDTH_COL2" => ($mode == 'editstruct') ? $row['page_col2width'] : "",
					"COL3_PERCENT" => $col3_percent,
					"COL3_PIXEL" => $col3_pixel,
					"WIDTH_COL3" => ($mode == 'editstruct') ? $row['page_col3width'] : "",
					"L_YES" => $lang['Yes'],
					"L_NO" => $lang['No'])
				);
				
				$template->pparse("body");
				include('./page_footer_admin.'.$phpEx);
	break;
	case 'createsave'	:
		$sql = "INSERT INTO " . PORTAL_PAGE . "(page_desc, display_header, page_defaultsize, page_col1width, page_col1unit, page_col2width, page_col2unit, page_col3width, page_col3unit )
		  VALUES('" . addslashes($page_desc) . "', '$page_forum_header', '$page_defaultsize', '$page_col1width', '$page_col1unit', '$page_col2width', '$page_col2unit', '$page_col3width', '$page_col3unit' )" ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal page table!", "", __LINE__, __FILE__, $sql);
		}
		$page_id = 0 ;
	break;
	case 'editsave' :
		$sql = "UPDATE " . PORTAL_PAGE . " SET page_desc='" . addslashes($page_desc) . "', display_header='$page_forum_header', page_defaultsize='$page_defaultsize', page_col1width='$page_col1width', page_col1unit='$page_col1unit',
		page_col2width='$page_col2width', page_col2unit='$page_col2unit', page_col3width='$page_col3width', page_col3unit='$page_col3unit' WHERE page_id = $page_id " ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal page table!", "", __LINE__, __FILE__, $sql);
		}
		$page_id = 0 ;
	break;	
}


if ($page_id == 0)
{
	// si aucune page n'est sélectionnée
	// on affiche la liste des pages contenues dans la table

	$sql = "SELECT * FROM " . PORTAL_PAGE . " ORDER BY page_id ASC ";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query portal_page table!", "", __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$liste_pages[] = $row ;
	}
		
	$template->set_filenames(array(
		"body" => "admin/pages_manage_body.tpl")
	);

	$template->assign_vars(array(
		"L_PAGES_TITLE" => $lang['Page_manage_portal'],
		"L_PAGES_ADD_TEXT" => $lang['Page_manage_explain'],
		"L_PAGE" => $lang['Page'],
		"S_PAGE_ACTION" => append_sid("admin_portal_struct.$phpEx"),
		"L_ACTION" => $lang['Action'],
		"L_AGENCEMENT" => $lang['Agencement_blocks'],
		"L_CREATE_STRUCT" => $lang['Create_structure'],
		"L_EDIT" => $lang['Edit'],
		"L_MANAGE" => $lang['Manage'],
		"L_DELETE" => $lang['Delete'],
		"L_DUPLIQUE" => $lang['Duplique'],
		"L_PAGE_ID" => $lang['Page_id'])
	);
				
	for($i = 0; $i < count($liste_pages); $i++)
	{
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("pages", array(
			"ROW_CLASS" => $row_class,
			"ROW_COLOR" => "#" . $row_color,
			"PAGE_DESC" => stripslashes( $liste_pages[$i]['page_desc'] ),
			"IMG_STAR" => ($liste_pages[$i]['page_id'] == $portal_config['default_struct'])? "<img src='" . $phpbb_root_path ."images/etoile.gif' align='absmiddle' alt='" . $lang['default_portal_page'] . "' />": "",
			"U_PAGE_EDIT" => append_sid("admin_portal_struct.$phpEx?mode=editstruct&amp;pid=" . $liste_pages[$i]['page_id'] ),
			"U_PAGE_MANAGE" => append_sid("admin_portal_struct.$phpEx?mode=manage&amp;pid=" . $liste_pages[$i]['page_id'] ),
			"U_PAGE_DELETE" => ( $liste_pages[$i]['page_id'] != $portal_config['default_struct'] ) ? '<a href="' . append_sid("admin_portal_struct.$phpEx?mode=deletestruct&amp;pid=" . $liste_pages[$i]['page_id'] ) . '" >' . $lang['Delete'] . '</a>' : "",
			"U_DUPLIQUE" => append_sid("admin_portal_struct.$phpEx?mode=duplique&amp;pid=" . $liste_pages[$i]['page_id'] ),
			"U_DEFINE_DEFAULT" => ( $liste_pages[$i]['page_id'] != $portal_config['default_struct'] ) ? '<a href="' . append_sid("admin_portal_struct.$phpEx?mode=default&amp;pid=" . $liste_pages[$i]['page_id'] ) . '" >' . $lang['Define_default_page'] . '</a><br />' : "",
			"S_PID" => $liste_pages[$i]['page_id'])
		);				
	}
	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}


// Si une page est sélectionnée on affiche sa structure
$sql = "SELECT * FROM " . PORTAL_PAGE . " WHERE page_id = $page_id " ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query page portal information", "", __LINE__, __FILE__, $sql);
}
if ( $row = $db->sql_fetchrow($result) )
{
	$page_desc = $row['page_desc'] ;
}
else
{
	message_die(GENERAL_MESSAGE, "Cette page n'existe pas.");
}

$sql = "SELECT MAX(struct_order) as str_ord, struct_col FROM " . PORTAL_STRUCT . " WHERE page_id = $page_id GROUP BY struct_col" ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
}
while ( $row = $db->sql_fetchrow($result) )
{
	$max_order[ $row['struct_col'] ] = $row['str_ord'] ;
}

if ( isset( $moveright ) or isset( $moveleft ) )
{
	if ( isset( $moveleft ) )
	{
		$colnew = ( $colid > 1 ) ? $colid - 1 : 3 ;
		$ordernew = ( isset( $max_order[ $colnew] ) ) ? $max_order[ $colnew] + 1 : 1 ;
		$sql = "UPDATE " . PORTAL_STRUCT . " SET struct_col = $colnew , struct_order = $ordernew WHERE struct_id = $str " ;
		if( !($result = $db->sql_query($sql))) 
		{
			message_die(CRITICAL_ERROR, "Could not upadte structure portal table", "", __LINE__, __FILE__, $sql);
		}
	}
	else if ( isset( $moveright ) )
	{
		$colnew = ( $colid < 3 ) ? $colid + 1 : 1 ;
		$ordernew = ( isset( $max_order[ $colnew] ) ) ? $max_order[ $colnew] + 1 : 1 ;
		$sql = "UPDATE " . PORTAL_STRUCT . " SET struct_col = $colnew , struct_order = $ordernew WHERE struct_id = $str " ;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not upadte structure portal table", "", __LINE__, __FILE__, $sql);
		}		
	}
}

if( $mode == 'move' || $mode == 'delete'  || $mode == 'addnew' ) 
{
	switch ( $mode )
	{
		case 'move' :
			$sql = "UPDATE " . PORTAL_STRUCT . " SET struct_order = $ord + $ord2 - struct_order WHERE struct_id = $str OR struct_id = $str2 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, "Could not update structure portal table", "", __LINE__, __FILE__, $sql);
			}				
			break ;
		case 'delete' :
			$sql = "DELETE FROM " . PORTAL_STRUCT . " WHERE struct_id = $str ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, "Could not update structure portal table", "", __LINE__, __FILE__, $sql);
			}				
			break ;
		case 'addnew' :
			$ordernew = $max_order[ $colid ] + 1 ;
			$sql = "INSERT INTO " . PORTAL_STRUCT . " ( mod_id , struct_col , struct_order , page_id ) VALUES ( $modid , $colid , $ordernew , $page_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, "Could not update structure portal table", "", __LINE__, __FILE__, $sql);
			}				
			break ;
	}
}
				
$template->set_filenames(array(
	"body" => "admin/struct_portal_body.tpl")
);

$hidden_fields = "<input type=hidden name='pid' value='$page_id' />" ;
// Affichage de la disposition des modules dans la structure
$template->assign_vars(array(
			'PORTAL_CLASS_BALISE' => $board_config['portal_class_balise'],
			'PORTAL_CLASS_TITLE' => $board_config['portal_class_title'],
			'S_STRUCT_ACTION' => append_sid("admin_portal_struct.$phpEx"),
			'S_HIDDEN_FIELDS' => $hidden_fields,
			'L_DELETE' => $lang['Delete'],
			'L_MODULE' => $lang['Module'],
			'L_MOD_LOCATION' => $lang['Mod_location'],
			'ADD_MOD_STRUCTURE' => $lang['Add_mod_structure'],
			'ADD_MOD_BUTTON' => $lang['Add_mod'],
			'L_STRUCT_HEADER' => $lang['Struct_header'],
			'L_STRUCT_FOOTER' => $lang['Struct_footer'],
			'L_STRUCT_COL1' => $lang['Struct_col1'],
			'L_STRUCT_COL2' => $lang['Struct_col2'],
			'L_STRUCT_COL3' => $lang['Struct_col3'],
			'L_PAGE_DESC' => stripslashes($page_desc),
			'L_STRUCTURE_TITLE' => $lang['Portal_structure'],
			'L_STRUCTURE_ADD_TEXT' => $lang['Structure_manage_explain'] )
			);
			
$sql = "SELECT * FROM " . PORTAL_STRUCT . "  s LEFT JOIN " . PORTAL_MOD . " m on m.mod_id = s.mod_id WHERE s.page_id = $page_id ORDER BY s.struct_col ASC, s.struct_order ASC " ;

if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}
$nbmod = 0 ;

while ( $row = $db->sql_fetchrow($result) )
{	
	$struct_array[ $nbmod ]['mod_id'] =  $row['mod_id'] ;
	$struct_array[ $nbmod ]['mod_name'] =  stripslashes($row['mod_name']) ;
	$struct_array[ $nbmod ]['struct_id'] =  $row['struct_id'] ;	
	$struct_array[ $nbmod ]['struct_col'] =  $row['struct_col'] ;	
	$struct_array[ $nbmod ]['struct_order'] =  $row['struct_order'] ;	
	$nbmod++;
}

for ( $imod = 0 ; $imod < $nbmod ; $imod++ )
{
	 $colup = ( $imod > 0 ) ? ( ( $struct_array[ $imod ]['struct_col'] == $struct_array[ $imod - 1 ]['struct_col'] ) ? $lang['Move_up'] : "" ) : "" ;

			$template->assign_block_vars('giefmod' . $struct_array[ $imod ]['struct_col'] ,array(
				'U_MOD_DELETE' => append_sid("admin_portal_struct.$phpEx?mode=delete&amp;pid=$page_id&amp;str=" . $struct_array[ $imod ]['struct_id'] ),
				'U_MOD_MOVE_UP' => append_sid("admin_portal_struct.$phpEx?mode=move&amp;move=U&amp;str=" . $struct_array[ $imod ]['struct_id'] . "&amp;pid=$page_id&amp;str2="  . $struct_array[ $imod - 1 ]['struct_id'] . 
									"&amp;ord=" .  $struct_array[ $imod ]['struct_order'] . "&amp;ord2=" .  $struct_array[ $imod - 1 ]['struct_order']),
				'U_MOD_MOVE_DOWN' => append_sid("admin_portal_struct.$phpEx?mode=move&amp;move=D&amp;str=" . $struct_array[ $imod ]['struct_id']  . "&amp;pid=$page_id&amp;str2="  . $struct_array[ $imod + 1 ]['struct_id'] . 
									"&amp;ord=" .  $struct_array[ $imod ]['struct_order'] . "&amp;ord2=" .  $struct_array[ $imod + 1 ]['struct_order']),				
				'L_UP' => ( $imod > 0 ) ? ( ( $struct_array[ $imod ]['struct_col'] == $struct_array[ $imod - 1 ]['struct_col'] ) ? $lang['Move_up'] : "" ) : "",
				'L_DOWN' => ( $imod < $nbmod ) ? ( ( $struct_array[ $imod ]['struct_col'] == $struct_array[ $imod + 1 ]['struct_col'] ) ? $lang['Move_down'] : "" ) : "",
				'STRUCT_ID' => $struct_array[ $imod ]['struct_id'],
				'STRUCT_COL' => $struct_array[ $imod ]['struct_col'],				
				'PAGE_ID' => $page_id,
				'MODNAME' => $struct_array[ $imod ]['mod_name'] )
				);
}

$sql = "SELECT * FROM " . PORTAL_MOD . " ORDER BY mod_name ASC " ;

if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query module list", "", __LINE__, __FILE__, $sql);
}
$nbmod = 0 ;

while ( $row = $db->sql_fetchrow($result) )
{	
			$template->assign_block_vars('modrow',array(
				'MODID' => $row['mod_id'],
				'MODNAME' => stripslashes($row['mod_name']) )
			);
}

$template->pparse('body');
include('./page_footer_admin.'.$phpEx); 

?>
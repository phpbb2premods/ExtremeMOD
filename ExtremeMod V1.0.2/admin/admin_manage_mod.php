<?php
/***************************************************************************
 *                              admin_manage_mod.php
 *                            -------------------
 *   fait le                : Dimanche,11 Août, 2003
 *   Par : giefca - http://www.gf-phpbb.fr.st
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Gestion des modules pour le portail.
 *
 ***************************************************************************/


define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_portal']['Module_manage_portal'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
else 
{
	$mode = "";
}

switch( $mode )
{
	case "editsave":
		$modid = ( isset($HTTP_GET_VARS['modid']) ) ? $HTTP_GET_VARS['modid'] : $HTTP_POST_VARS['modid'];
		$modauth = ( isset($HTTP_GET_VARS['modauth']) ) ? $HTTP_GET_VARS['modauth'] : $HTTP_POST_VARS['modauth'];
		$mod_name = ( isset($HTTP_GET_VARS['mod_name']) ) ? $HTTP_GET_VARS['mod_name'] : $HTTP_POST_VARS['mod_name'];
		$mod_table = ( isset($HTTP_GET_VARS['mod_table']) ) ? $HTTP_GET_VARS['mod_table'] : $HTTP_POST_VARS['mod_table'];
		$mod_title = ( isset($HTTP_GET_VARS['mod_title']) ) ? $HTTP_GET_VARS['mod_title'] : $HTTP_POST_VARS['mod_title'];
		$mod_source = ( isset($HTTP_GET_VARS['mod_source']) ) ? $HTTP_GET_VARS['mod_source'] : $HTTP_POST_VARS['mod_source'];
		$modtype = ( isset($HTTP_GET_VARS['modtype']) ) ? $HTTP_GET_VARS['modtype'] : $HTTP_POST_VARS['modtype'];
						
		if( isset($modid) )
		{
		   if ( $modid == 0 )
		   {
		   		if ( empty($mod_name) )
				{
						message_die(GENERAL_MESSAGE,  $lang['Error_name_custom_block']);
				}
		   		$sql = "INSERT INTO " . PORTAL_MOD . 
				"(mod_name, mod_auth, mod_type, mod_table, mod_title, mod_source) VALUES ( '" . addslashes($mod_name) . "', '$modauth', 1, '$mod_table', '" . addslashes($mod_title) . "', '" . addslashes($mod_source) . "')" ;
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Could not update portal_mod table!", "", __LINE__, __FILE__, $sql);
				}	
				$message = $lang['Module_updated'] . "<br /><br />" . sprintf($lang['Click_return_modulemanage'], "<a href=\"" . append_sid("admin_manage_mod.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
				message_die(GENERAL_MESSAGE, $message);
		   }
		   else
		   {
		   
		   		$sqlcustom = "" ;
				
		   		if ( $modtype == 1 )
				{
			   		if ( empty($mod_name) )
					{
						message_die(GENERAL_MESSAGE, $lang['Error_name_custom_block'] );
					}	
					$sqlcustom  = ", mod_name = '" . addslashes($mod_name) ."' " ;
					$sqlcustom .= ", mod_table = '$mod_table' ";
					$sqlcustom .= ", mod_title = '" . addslashes($mod_title) . "' ";
					$sqlcustom .= ", mod_source = '" . addslashes($mod_source) . "' ";
				} 
		   		
		   
				$sql = "UPDATE " . PORTAL_MOD . " SET "
				. "mod_auth = '" . intval($modauth) . "'"
				. $sqlcustom
				. " WHERE mod_id = '$modid' ";

				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Could not update portal_mod table!", "", __LINE__, __FILE__, $sql);
				}
		
				$message = $lang['Module_updated'] . "<br /><br />" . sprintf($lang['Click_return_modulemanage'], "<a href=\"" . append_sid("admin_manage_mod.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
				message_die(GENERAL_MESSAGE, $message);
		   }	
		}		
		break;

	case "delete":
		$modid = ( isset($HTTP_GET_VARS['modid']) ) ? urldecode($HTTP_GET_VARS['modid']) : $HTTP_POST_VARS['modid'];

		if( isset($modid) )
		{				
			$sql = "DELETE FROM " . PORTAL_STRUCT . " WHERE mod_id = '$modid' ";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not delete mod from portal_struct table!", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . PORTAL_MOD . "  WHERE mod_id = '$modid' ";		
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not delete mod from portal_mod table!", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . AUTH_PORTAL_TABLE . "  WHERE mod_id = '$modid' ";		
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not delete mod auth from auth_portal table!", "", __LINE__, __FILE__, $sql);
			}
		
			$message = $lang['Module_deleted'] . "<br /><br />" . sprintf($lang['Click_return_modulemanage'], "<a href=\"" . append_sid("admin_manage_mod.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}		
		break;
	case "edit":
		$modid = ( isset($HTTP_GET_VARS['modid']) ) ? urldecode($HTTP_GET_VARS['modid']) : $HTTP_POST_VARS['modid'];	

		if( isset($modid) )
		{				
			$sql = "SELECT * FROM " . PORTAL_MOD . "  WHERE mod_id = '$modid' ";		
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not access portal_mod table!", "", __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$template->set_filenames(array(
					"body" => "admin/block_edit_body.tpl")
				);

				$auth_all = ( $row['mod_auth'] == AUTH_ALL ) ? "selected" : "" ;
				$auth_reg = ( $row['mod_auth'] == AUTH_REG ) ? "selected" : "" ;
				// Start add - Blocs Auth MOD
				$auth_inv = ( $row['mod_auth'] == AUTH_INV ) ? "selected" : "" ;
				$auth_acl = ( $row['mod_auth'] == AUTH_ACL ) ? "selected" : "" ;
				$auth_aclx= ( $row['mod_auth'] == AUTH_ACLX) ? "selected" : "" ;
				// End add - Blocs Auth MOD
				$auth_mod = ( $row['mod_auth'] == AUTH_MOD ) ? "selected" : "" ;
				$auth_admin = ( $row['mod_auth'] == AUTH_ADMIN ) ? "selected" : "" ;

				$liste_auth  = "<option value='" . AUTH_ALL . "' $auth_all >" . $lang['Block_ALL'] . "</ option>" ;
				// Start add - Blocs Auth MOD
				$liste_auth .= "<option value='" . AUTH_INV . "' $auth_inv >" . $lang['Block_INV'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ACL . "' $auth_acl >" . $lang['Block_ACL'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ACLX . "' $auth_aclx >" . $lang['Block_ACLX'] . "</ option>" ;
				// End add - Blocs Auth MOD
				$liste_auth .= "<option value='" . AUTH_REG . "' $auth_reg >" . $lang['Block_REG'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_MOD . "' $auth_mod >" . $lang['Block_MOD'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ADMIN . "' $auth_admin >" . $lang['Block_ADMIN'] . "</ option>" ;

				$s_hidden_fields = '<input type="hidden" name="modid" value="' . $modid .'" />';
				$s_hidden_fields .= '<input type="hidden" name="modtype" value="' . $row['mod_type'] .'" />';
				$s_hidden_fields .= '<input type="hidden" name="mode" value="editsave" />';

				$template->assign_vars(array(
					"S_BLOC_ACTION" => append_sid("admin_manage_mod.$phpEx"),
					"S_HIDDEN_FIELDS" => $s_hidden_fields,
					"S_SUBMIT_VALUE" => $lang['Submit'],
					"L_VIEW_BLOCK" => $lang['View_Block'], 
					"L_GENERAL_OPTION" => $lang['General_block_options'],
					"S_AUTH" => $liste_auth, 		
					"L_MODULES_TITLE" => $lang['Module_manage_portal'],
					"L_MODULES_ADD_TEXT" => $lang['Modules_block_edit_explain'],
					"L_MODULE" => stripslashes($row['mod_name']),
					"L_BLOCK_NAME" => $lang['Custom_block_name'],
					"L_BLOCK_TABLE" => $lang['Custom_table_type'],
					"L_BLOCK_TABLE_EXPLAIN" => $lang['Custom_table_explain'],
					"L_YES" => $lang['Yes'],
					"L_NO" => $lang['No'],
					"L_BLOCK_TITRE" => $lang['Custom_block_title'],
					"L_BLOCK_TITRE_EXPLAIN" => $lang['Custom_title_explain'],
					"L_SOURCE" => $lang['Custom_block_source'],
					"L_SOURCE_EXPLAIN" => $lang['Custom_source_explain'],
					"L_EDIT" => $lang['Edit'],
					"L_DELETE" => $lang['Delete'])
				);
				if ( $row['mod_type'] == 1 )
				{
					$table_yes = ( $row['mod_table'] ) ? "checked=\"checked\"" : "";
					$table_no = ( !$row['mod_table'] ) ? "checked=\"checked\"" : "";

					$template->assign_vars(array(
						"MOD_NAME" => stripslashes($row['mod_name']),
						"MOD_TITLE" => stripslashes($row['mod_title']),
						"S_SOURCE" => stripslashes($row['mod_source']),
						"S_TABLE_YES" => $table_yes,
						"S_TABLE_NO" => $table_no
							)
						);
					$template->assign_block_vars('custom_block',array());
				}
				
				$template->pparse("body");
				include('./page_footer_admin.'.$phpEx);
			}
		}			
		break;
	case "create":

				$template->set_filenames(array(
					"body" => "admin/block_edit_body.tpl")
					);
				$mod_name = ( isset($HTTP_GET_VARS['mod_name']) ) ? $HTTP_GET_VARS['mod_name'] : $HTTP_POST_VARS['mod_name'];
				$auth_all = "selected" ;
				$auth_reg = "" ;
				// Start add - Blocs Auth MOD
				$auth_acl = "";
				$auth_aclx = "";
				// End add - Blocs Auth MOD
				$auth_mod = "" ;
				$auth_admin = "" ;

				$liste_auth  = "<option value='" . AUTH_ALL . "' $auth_all >" . $lang['Block_ALL'] . "</ option>" ;
				// Start add - Blocs Auth MOD
				$liste_auth .= "<option value='" . AUTH_INV . "' $auth_inv >" . $lang['Block_INV'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ACL . "' $auth_acl >" . $lang['Block_ACL'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ACLX . "' $auth_aclx >" . $lang['Block_ACLX'] . "</ option>" ;
				// End add - Blocs Auth MOD
				$liste_auth .= "<option value='" . AUTH_REG . "' $auth_reg >" . $lang['Block_REG'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_MOD . "' $auth_mod >" . $lang['Block_MOD'] . "</ option>" ;
				$liste_auth .= "<option value='" . AUTH_ADMIN . "' $auth_admin >" . $lang['Block_ADMIN'] . "</ option>" ;

				$s_hidden_fields = '<input type="hidden" name="modid" value="0" />';
				$s_hidden_fields .= '<input type="hidden" name="modtype" value="1" />';
				$s_hidden_fields .= '<input type="hidden" name="mode" value="editsave" />';

				$template->assign_vars(array(
					"S_BLOC_ACTION" => append_sid("admin_manage_mod.$phpEx"),
					"S_HIDDEN_FIELDS" => $s_hidden_fields,
					"S_SUBMIT_VALUE" => $lang['Submit'],
					"L_VIEW_BLOCK" => $lang['View_Block'], 
					"L_GENERAL_OPTION" => $lang['General_block_options'],
					"S_AUTH" => $liste_auth, 		
					"L_MODULES_TITLE" => $lang['Module_manage_portal'],
					"L_MODULES_ADD_TEXT" => $lang['Modules_block_edit_explain'],
					"L_MODULE" => $mod_name,
					"L_BLOCK_NAME" => $lang['Custom_block_name'],
					"L_BLOCK_TABLE" => $lang['Custom_table_type'],
					"L_BLOCK_TABLE_EXPLAIN" => $lang['Custom_table_explain'],
					"L_YES" => $lang['Yes'],
					"L_NO" => $lang['No'],
					"L_BLOCK_TITRE" => $lang['Custom_block_title'],
					"L_BLOCK_TITRE_EXPLAIN" => $lang['Custom_title_explain'],
					"L_SOURCE" => $lang['Custom_block_source'],
					"L_SOURCE_EXPLAIN" => $lang['Custom_source_explain'],
					"L_EDIT" => $lang['Edit'],
					"L_DELETE" => $lang['Delete'])
				);
					$table_yes = "checked=\"checked\"" ;
					$table_no = "";

					$template->assign_vars(array(
						"MOD_NAME" => stripslashes($mod_name),
						"MOD_TITLE" => "",
						"S_SOURCE" => "",
						"S_TABLE_YES" => $table_yes,
						"S_TABLE_NO" => $table_no
							)
						);
					$template->assign_block_vars('custom_block',array());
				$template->pparse("body");
				include('./page_footer_admin.'.$phpEx);
			break;
}		

// affichage de la liste des modules contenu dans la table
//$liste_modules = "" ;
$sql = "SELECT mod_name, mod_id, mod_type FROM " . PORTAL_MOD . " ORDER BY mod_name";
if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Could not query portal_mod table!", "", __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$liste_modules[] = $row ;
}
		
$template->set_filenames(array(
	"body" => "admin/modules_manage_body.tpl")
);

$template->assign_vars(array(
	"L_MODULES_TITLE" => $lang['Module_manage_portal'],
	"L_MODULES_ADD_TEXT" => $lang['Modules_manage_explain'],
	"L_MODULE" => $lang['Module'],
	"L_BLOCK_CUSTOM" => $lang['Custom_block'],
	"L_CREATE_CUSTOM" => $lang['Create_custom_block'],
	"L_EDIT" => $lang['Edit'],
	// Start add - Blocs Auth MOD
	"L_PERMISSIONS" => $lang['Permissions'],
	// End add - Blocs Auth MOD
	"L_DELETE" => $lang['Delete'])
);

// Start add - Blocs Auth MOD
$mod_auth_inv = array();
$mod_auth_acl = array();
$sql_auth = 'SELECT mod_id, mod_auth FROM ' . PORTAL_MOD . ' WHERE mod_auth=' . AUTH_ACL . ' OR mod_auth=' . AUTH_ACLX ;
if (!$result_auth = $db -> sql_query($sql_auth))
{
	message_die(GENERAL_ERROR, "Could not query auth_portal table!", "", __LINE__, __FILE__, $sql);
}
while ($row_auth = $db -> sql_fetchrow($result_auth))
{
	$mod_auth_acl[ $row_auth['mod_id'] ] = $row_auth['mod_auth'];
}
// End add - Blocs Auth MOD
				
for($i = 0; $i < count($liste_modules); $i++)
{
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	// Start add - Blocs Auth MOD
	$u_modules_permissions = '';
	if ($mod_auth_acl[ $liste_modules[$i]['mod_id'] ] == AUTH_ACL || $mod_auth_acl[ $liste_modules[$i]['mod_id'] ] == AUTH_ACLX)
	{
		$u_modules_permissions = '<a href="' . append_sid("admin_blocks_permissions.$phpEx?mode=edit&modid=" . $liste_modules[$i]['mod_id']) . '">' . $lang['Permissions'] . '</a>' ;
	};
	// End add - Blocs Auth MOD

	$template->assign_block_vars("modules", array(
		"ROW_CLASS" => $row_class,
		"ROW_COLOR" => "#" . $row_color,
		"IMG_CUSTOM" => ( $liste_modules[$i]['mod_type']== 1 ) ? "<img src='" . $phpbb_root_path . "images/custom.gif' alt='" . $lang['Custom_block'] . "' align='absmiddle' />" : "" ,
		"MODULE_NAME" => stripslashes($liste_modules[$i]['mod_name']),
		"U_MODULES_EDIT" => append_sid("admin_manage_mod.$phpEx?mode=edit&amp;modid=" . $liste_modules[$i]['mod_id'] ),
		// Start add - Blocs Auth MOD
		"U_MODULES_PERMISSIONS" => $u_modules_permissions,
		// End add - Blocs Auth MOD
		"U_MODULES_DELETE" => append_sid("admin_manage_mod.$phpEx?mode=delete&amp;modid=" . $liste_modules[$i]['mod_id'] ))
	);
				
}
$template->pparse("body");
include('./page_footer_admin.'.$phpEx);			

?>
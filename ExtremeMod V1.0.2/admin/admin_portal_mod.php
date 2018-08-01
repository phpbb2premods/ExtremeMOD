<?php
/***************************************************************************
 *                              admin_portal_mod.php
 *                            -------------------
 *   fait le                : Mardi,22 Juillet, 2003
 *   Par : giefca - http://www.gf-phpbb.fr.st
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Installation des modules pour le portail.
 *
 ***************************************************************************/


define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_portal']['Module_admin_portal'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : FALSE;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? TRUE : FALSE;

if ($cancel)
{
	redirect('admin/' . append_sid("admin_portal_mod.$phpEx", true));
}

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
	case "addnew":
		$module_name = ( isset($HTTP_GET_VARS['module']) ) ? urldecode($HTTP_GET_VARS['module']) : $HTTP_POST_VARS['module'];
	
		if( isset($module_name) )
		{				
			$sql = "INSERT INTO " . PORTAL_MOD . " ( mod_name ) VALUES ( '$module_name' )";
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not insert portal_mod data!", "", __LINE__, __FILE__, $sql);
			}
		
			$message = $lang['Module_installed'] . "<br /><br />" . sprintf($lang['Click_return_moduleadmin'], "<a href=\"" . append_sid("admin_portal_mod.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$installable_modules = array();
						
			$dir = @opendir("../gf_portail/gf_mods");
			while( $file = @readdir($dir) )
			{
				if( preg_match("/^mod_.*?\." . $phpEx . "$/", $file) )
				{
					$modname = substr( $file , 4 , strlen( $file ) - strlen( $phpEx ) - 5 ) ;
					$sql = "SELECT mod_id 
							FROM " . PORTAL_MOD . " 
							WHERE mod_name = '" . $modname . "'";
					if(!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, "Could not query portal_mod table!", "", __LINE__, __FILE__, $sql);
					}

					if(!$db->sql_numrows($result))
					{
						$installable_modules[] = $modname ;
					}
				}
			}
			@closedir($dir);
				
				$template->set_filenames(array(
					"body" => "admin/modules_addnew_body.tpl")
				);
				
				$template->assign_vars(array(
					"L_MODULES_TITLE" => $lang['Modules_admin'],
					"L_MODULES_ADD_TEXT" => $lang['Modules_addnew_explain'],
					"L_MODULE" => $lang['Module'],
					"L_INSTALL" => $lang['Install'],
					"L_ACTION" => $lang['Action'])
				);
					
				for($i = 0; $i < count($installable_modules); $i++)
				{
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
					$template->assign_block_vars("modules", array(
						"ROW_CLASS" => $row_class,
						"ROW_COLOR" => "#" . $row_color,
						"MODULE_NAME" => $installable_modules[$i],
						"U_MODULES_INSTALL" => append_sid("admin_portal_mod.$phpEx?mode=addnew&amp;module=" . urlencode($installable_modules[$i]) ))
					);
				
				}
				$template->pparse("body");
				include('./page_footer_admin.'.$phpEx);
					
			}
		break;
		default :
			$installable_modules = array();
						
			$dir = @opendir("../gf_portail/gf_mods");
			while( $file = @readdir($dir) )
			{
				if( preg_match("/^mod_.*?\." . $phpEx . "$/", $file) )
				{
					$modname = substr( $file , 4 , strlen( $file ) - strlen( $phpEx ) - 5 ) ;
					$sql = "SELECT mod_id 
							FROM " . PORTAL_MOD . " 
							WHERE mod_name = '" . $modname . "'";
					if(!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, "Could not query portal_mod table!", "", __LINE__, __FILE__, $sql);
					}

					if(!$db->sql_numrows($result))
					{
						$installable_modules[] = $modname ;
					}
				}
			}
			@closedir($dir);
				
				$template->set_filenames(array(
					"body" => "admin/modules_addnew_body.tpl")
				);
				
				$template->assign_vars(array(
					"L_MODULES_TITLE" => $lang['Modules_admin'],
					"L_MODULES_ADD_TEXT" => $lang['Modules_addnew_explain'],
					"L_MODULE" => $lang['Module'],
					"L_INSTALL" => $lang['Install'],
					"L_ACTION" => $lang['Action'])
				);
					
				for($i = 0; $i < count($installable_modules); $i++)
				{
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
					$template->assign_block_vars("modules", array(
						"ROW_CLASS" => $row_class,
						"ROW_COLOR" => "#" . $row_color,
						"MODULE_NAME" => $installable_modules[$i],
						"U_MODULES_INSTALL" => append_sid("admin_portal_mod.$phpEx?mode=addnew&amp;module=" . urlencode($installable_modules[$i]) ))
					);
				
				}
				$template->pparse("body");
				include('./page_footer_admin.'.$phpEx);			
		break;
}

?>
<?php
/***************************************************************************
 *                            admin_blocks_permissions.php
 *                            ----------------------------
 *   fait le                : Jeudi 2 Septembre 2004
 *	 mis à jour le			: Vendredi 24 Décembre 2004
 *   Par : Olivier Cecillon - http://olivier.cecillon.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Gestion des permissions des modules pour le portail.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_portal']['Module_blocks_permissions'] = $file;
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
	$mode = 'list';
}
if( isset($HTTP_GET_VARS['modid']) || isset($HTTP_POST_VARS['modid']) )
{

	$mod_id = ( isset($HTTP_GET_VARS['modid']) ) ? $HTTP_GET_VARS['modid'] : $HTTP_POST_VARS['modid'];
}
else 
{
	$mode='list';
}
if( isset($HTTP_GET_VARS['groupid']) || isset($HTTP_POST_VARS['groupid']) )
{
	$group_id = ( isset($HTTP_GET_VARS['groupid']) ) ? $HTTP_GET_VARS['groupid'] : $HTTP_POST_VARS['groupid'];
}
else 
{
	if ($mode == 'auth' && $mode == 'unauth')
	{
		$mode='list';
	}
}

switch ($mode)
{
	case 'edit' :
		// Informations du module
		$sql = 'SELECT * FROM ' . PORTAL_MOD . ' WHERE mod_id = ' . $mod_id;
		if (!$result = $db -> sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not get module information", "", __LINE__, __FILE__, $sql);
		}
		$mod_data = $db-> sql_fetchrow($result);
		// Groupes autorisés
		$sql = 'SELECT g.group_id, g.group_name, g.group_description, ap.mod_id
				FROM ' . GROUPS_TABLE . ' g
				LEFT  JOIN ' . AUTH_PORTAL_TABLE . ' ap
					ON ap.group_id = g.group_id
				WHERE mod_id=' . $mod_id . '
				ORDER BY g.group_name';
		if (!$result = $db -> sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not query authorized groups", "", __LINE__, __FILE__, $sql);
		}
		$i = 1;
		while ($row = $db -> sql_fetchrow($result))
		{
			$row_class = ( ($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
			$u_action = append_sid("admin_blocks_permissions.$phpEx?mode=unauth&modid=" . $row['mod_id'] . "&groupid=" . $row['group_id']);
			$template -> assign_block_vars('groups_auth', array(
				'GROUP_ID' => $row['group_id'],
				'GROUP_NAME' => $row['group_name'],
				'GROUP_DESC' => $row['group_description'],
				'ROW_CLASS' => $row_class,
				'ROW_COLOR' => $row_color,
				'U_ACTION' => $u_action
			));
			$i++;
		}
		// Groupes non autorisés
		$sql = 'SELECT g.group_id, g.group_name, g.group_description, m.mod_id, m.mod_name
				FROM ' . GROUPS_TABLE . ' g, ' . PORTAL_MOD . ' m
				LEFT JOIN ' . AUTH_PORTAL_TABLE . ' a
					ON g.group_id = a.group_id
					AND m.mod_id = a.mod_id
				WHERE a.auth_view IS NULL
					AND m.mod_id =' . $mod_id . '
					AND g.group_single_user =0
				ORDER BY g.group_name';
		if (!$result = $db -> sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not query unauthorized groups", "", __LINE__, __FILE__, $sql);
		}
		$i=1;
		while ($row = $db -> sql_fetchrow($result))
		{
			$row_color = ( ($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( ($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
			$u_action = append_sid("admin_blocks_permissions.$phpEx?mode=auth&modid=" . $row['mod_id'] . "&groupid=" . $row['group_id']);
			$template -> assign_block_vars('groups_unauth', array(
				'GROUP_ID' => $row['group_id'],
				'GROUP_NAME' => $row['group_name'],
				'GROUP_DESC' => $row['group_description'],
				'ROW_CLASS' => $row_class,
				'ROW_COLOR' => $row_color,
				'U_ACTION' => $u_action
			));
			$i++;
			$unauth_groups[] = $row;
		}
		$template->set_filenames(array(
			'body' => 'admin/blocks_permissions_edit.tpl')
		);
		$template->assign_vars(array(
			'L_MODULES_TITLE' => $lang['Module_blocks_permissions'],
			'L_MODULES_ADD_TEXT' => $lang['Blocks_permissions_explain'],
			'L_MODULE' => $lang['Module'],
			'L_GROUP_NAME' => $lang['group_name'],
			'L_GROUP_DESC' => $lang['group_description'],
			'L_AUTHORIZED_GROUPS' => $lang['Authorized_groups'],
			'L_UNAUTHORIZED_GROUPS' => $lang['Unauthorized_groups'],
			'L_ACTION' => $lang['Action'],
			'MODULE_NAME' => $mod_data['mod_name'],
			'U_BACK' => append_sid("admin_manage_mod.$phpEx"),
			'L_ADD' => $lang['Action_add'],
			'L_SUPPRESS' => $lang['Action_suppress']
		));
	break;

	case 'list' :
		// Liste des modules "privés"
				$sql = 'SELECT m.mod_id, m.mod_name
				FROM ' . PORTAL_MOD . ' m
				WHERE m.mod_auth = ' . AUTH_ACL . '
				OR m.mod_auth = ' . AUTH_ACLX . '
				ORDER BY m.mod_name';
		if (!$result = $db -> sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not get modules information", "", __LINE__, __FILE__, $sql);
		}
		while ($row_mod = $db -> sql_fetchrow($result))
		{
			$sql_group = 'SELECT g.group_name, g.group_description, g.group_moderator, u.username
						FROM ' . GROUPS_TABLE . ' g, ' . USERS_TABLE . ' u, ' . AUTH_PORTAL_TABLE . ' a
						WHERE a.mod_id =' . $row_mod['mod_id'] . '
						AND g.group_single_user=0
						AND u.user_id=g.group_moderator
						AND a.group_id = g.group_id
						ORDER BY g.group_name';
			if (!$result_group = $db -> sql_query($sql_group))
			{
				message_die(GENERAL_ERROR, "Could not get modules information", "", __LINE__, __FILE__, $sql);
			}
			$template -> assign_block_vars('row_mod', array(
				'MODULE_NAME' => $row_mod['mod_name'],
				'U_EDIT_PERMISSIONS' => append_sid("admin_blocks_permissions.$phpEx?mode=edit&modid=" . $row_mod['mod_id'])
			));
			$k=0;
			while ($row_group = $db -> sql_fetchrow($result_group))
			{
				$row_color = ( !($k % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
				$template -> assign_block_vars('row_mod.row_group', array(
					'GROUP_NAME' => $row_group['group_name'],
					'GROUP_DESC' => $row_group['group_description'],
					'GROUP_MODO' => $row_group['username'],
					'ROW_COLOR' => $row_color,
					'ROW_CLASS' => $row_class
				));
				
				$k++;
			}
			
		}
		
		
		
		$template -> assign_vars (array(
			'L_GROUP_NAME' => $lang['group_name'],
			'L_GROUP_DESC' => $lang['group_description'],
			'L_GROUP_MODO' => $lang['group_moderator'],
			'L_ACL_MODULES' => $lang['ACL_Modules'],
			'L_MODULES_TITLE' => $lang['Module_blocks_permissions'],
			'L_MODULES_ADD_TEXT' => $lang['Blocks_permissions_explain'],
			'L_AUTHORIZED_GROUPS' => $lang['Authorized_groups']
			
		));
		
		$template->set_filenames(array(
			'body' => 'admin/blocks_permissions_list.tpl')
		);
		
		
	
	break;
	
	case 'auth' :
		$sql = 'INSERT INTO ' . AUTH_PORTAL_TABLE . '(group_id , mod_id , auth_view ) 
				VALUES ( ' . $group_id . ', ' . $mod_id . ', 1)';
		if (!$result = $db -> sql_query ($sql))
		{
			message_die(GENERAL_ERROR, "Could not set group authorization", "", __LINE__, __FILE__, $sql);
		}
		$message = $lang['Group_auth_success'] . '<br /><br />' .
			sprintf(
				$lang['Click_return_previous'],
					'<a href="' . append_sid("admin_blocks_permissions.$phpEx?mode=edit&modid=" . $mod_id ) . '">',
					'</a>'
			) .
			'<br /><br />' . 
			sprintf(
				$lang['Click_return_permissions'],
					'<a href="' . append_sid("admin_manage_mod.$phpEx") . '">',
					'</a>'
			) .
			'<br /><br />' . 
			sprintf(
				$lang['Click_return_admin_index'],
					'<a href="' . append_sid("index.$phpEx?pane=right") . '">',
					'</a>'
			);
		message_die(GENERAL_MESSAGE, $message);
		break;
	case 'unauth' :
		$sql = 'DELETE FROM ' . AUTH_PORTAL_TABLE . ' WHERE group_id=' . $group_id . ' AND mod_id=' . $mod_id;
		if (!$result = $db -> sql_query ($sql))
		{
			message_die(GENERAL_ERROR, "Could not set group authorization", "", __LINE__, __FILE__, $sql);
		}
		$message = $lang['Group_unauth_success'] . '<br /><br />' .
			sprintf(
				$lang['Click_return_previous'],
					'<a href="' . append_sid("admin_blocks_permissions.$phpEx?mode=edit&modid=" . $mod_id ) . '">',
					'</a>'
			) .
			'<br /><br />' . 
			sprintf(
				$lang['Click_return_permissions'],
					'<a href="' . append_sid("admin_manage_mod.$phpEx") . '">',
					'</a>'
			) .
			'<br /><br />' . 
			sprintf(
				$lang['Click_return_admin_index'],
					'<a href="' . append_sid("index.$phpEx?pane=right") . '">',
					'</a>'
			);
		message_die(GENERAL_MESSAGE, $message);
		break;
}

$template->pparse("body");
include('./page_footer_admin.'.$phpEx);	
?>
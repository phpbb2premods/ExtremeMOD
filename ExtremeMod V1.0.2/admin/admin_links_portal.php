<?php
/***************************************************************************
 *                              admin_portal.php
 *                            -------------------
 *   begin                : Vendredi 01 Août 2003
 *   email                : giefca@hotmail.com
 *
 *
 ***************************************************************************/
/*
 * Ce fichier ne sert qu'à faire des liens depuis le panneau
 * d'admnistration :
 *  - l'un pour avoir un aperçu du portail dans l'ACP
 *  - l'autre 
 */
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	include('../extension.inc');
	language_include('admin');
	$file = basename(__FILE__);
	$module['Admin_portal']['1Preview_portal'] = '../portal.'.$phpEx;
	$module['Admin_portal']['2Goto_portal'] = $file . '?mode=goto';
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$template -> set_filenames(array('body' => 'admin/admin_links_portal.tpl'));

if (isset($_GET['mode']) && $_GET['mode'] == 'goto')
{
	$portal_url = append_sid('../portal.'.$phpEx);
	$template -> assign_vars(array(
		'MESSAGE_TEXT' => sprintf($lang['Script_nok'], $portal_url),
		'U_PORTAL' => $portal_url,
		'L_REDIRECTION' => $lang['Redirection']
	));
}

$template -> pparse('body');

?>
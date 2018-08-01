<?php
/***************************************************************************
*                               admin_cat.php
*                              ---------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
 
include_once( $phpbb_root_path . 'includes/functions_arcade.' . $phpEx);

//chargement du template
$template->set_filenames(array(
  'arcade_cat' => 'arcade_cat.tpl')
  );

 //récupération de la liste des catégories privées auxquelles l'utilisateur à acces
 $liste_cat_auth = get_arcade_categories($userdata['user_id'], $userdata['user_level'],'view');
 $liste_jeux = array();		

 $sql = "SELECT g.* FROM " . GAMES_TABLE . " g WHERE g.arcade_catid IN ($liste_cat_auth) ORDER BY g.arcade_catid" ; 
 if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
 }
 while( $row = $db->sql_fetchrow($result))
 {
	 $liste_jeux[$row['arcade_catid']][] = $row ;
 }

 $sql = "SELECT arcade_catid, arcade_cattitle, arcade_nbelmt, arcade_catauth FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid IN ($liste_cat_auth) ORDER BY arcade_catorder";
 if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
 }

 while( $row = $db->sql_fetchrow($result))
 {
	$nbjeux = sizeof($liste_jeux[$row['arcade_catid']]);
	$template->assign_block_vars('cat_tab',array(
		'U_ARCADE' => append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ),
		'NBRE_JEUX' => $nbjeux,
		'CATTITLE' => $row['arcade_cattitle'])
		);
 }	

$template->assign_vars(array(
	'L_CATEGORIE' => $lang['category'])
	);

$template->assign_var_from_handle('ARCADE_CAT', 'arcade_cat');		

?>
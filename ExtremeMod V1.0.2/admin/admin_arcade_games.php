<?php
/***************************************************************************
*                               admin_arcade_games.php
*                              ------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Administration_Arcade_VPro']['Gestions_des_Jeux'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

function resynch_arcade_categorie($catid)
{
  global $db;
  
  $sql = "SELECT COUNT(*) AS nbelmt FROM " . GAMES_TABLE . " WHERE arcade_catid = $catid";
  if( !$result = $db->sql_query($sql) )
  {
	message_die(GENERAL_ERROR, "Impossible d'accéder à la table des jeux", "", __LINE__, __FILE__, $sql);
  }
  $row = $db->sql_fetchrow($result);
  $nbelmt = $row['nbelmt'];
  $sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = $nbelmt WHERE arcade_catid = $catid";
  if( !$result = $db->sql_query($sql) )
  {
	message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
  }
}

/*---------------------------------------------/
/ Récupération des variables.
/---------------------------------------------*/
$mode   = get_var2(array('name'=>'mode'  , 'intval'=>false, 'okvar'=>array('new','edit','editsave','editcreate','delete', 'move', 'resynch', 'movedel') ));
$arcade_catid = get_var2(array('name'=>'arcade_catid', 'intval'=>true ));

/*-----------------------------------------------/
/ A-t'on demandé la resynchronisation d'une catégorie ?
/-----------------------------------------------*/
if ( $mode == 'resynch')
{
	resynch_arcade_categorie($arcade_catid);
}

/*---------------------------------------------------------/
/ A-t'on demandé déplacement + suppression d'une catégorie ?
/---------------------------------------------------------*/
if ( $mode == 'movedel')
{
	$to_catid = get_var2(array('name'=>'to_catid', 'intval'=>true ));
	$sql = "UPDATE " . GAMES_TABLE . " SET arcade_catid = $to_catid WHERE arcade_catid = $arcade_catid";
    if( !$db->sql_query($sql) )
    {
	  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des jeux", "", __LINE__, __FILE__, $sql);
    }
	$sql = "DELETE FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid = $arcade_catid";
    if( !$db->sql_query($sql) )
    {
	  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
    }
	resynch_arcade_categorie($to_catid);
}

/*-----------------------------------------------/
/ A-t'on demandé la suppression d'une catégorie ?
/-----------------------------------------------*/
if ( $mode == 'delete')
{
  // Si la categorie est vide on la supprime
  $sql = "SELECT COUNT(*) AS nb FROM " . GAMES_TABLE . " WHERE arcade_catid = $arcade_catid";
  if( !$result = $db->sql_query($sql) )
  {
	message_die(GENERAL_ERROR, "Impossible d'accéder à la table des jeux", "", __LINE__, __FILE__, $sql);
  }
  $row = $db->sql_fetchrow($result);  
  if ( $row['nb'] == 0 )
  {
    $sql = "DELETE FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid = $arcade_catid";
    if( !$result = $db->sql_query($sql) )
  	{
	  message_die(GENERAL_ERROR, "Impossible de supprimer la catégorie", "", __LINE__, __FILE__, $sql);
    }
  }
  else
  {
    //Reste t-il une catégorie où l'on peut déplacer le contenu de celle-ci
	  //avant suppression.
	  $sql = "SELECT arcade_catid, arcade_cattitle FROM " . ARCADE_CATEGORIES_TABLE ;
      if( !$result = $db->sql_query($sql) )
      {
	     message_die(GENERAL_ERROR, "Impossible d'acceder à la table des catégorie", "", __LINE__, __FILE__, $sql);
      }
	  $liste_cat = '';
	  while( $row = $db->sql_fetchrow($result))
	  {
	     if($row['arcade_catid']!=$arcade_catid)
		 {  
		    $liste_cat .= "<option value='" . $row['arcade_catid'] . "'>" . strip_htmlchars( $row['arcade_cattitle']) . "</option>\n";
		 }
		 else
		 {
		    $cattitle = $row['arcade_cattitle'];
		 }
	  }
	  // s'il n'y a plus de catégorie on ne peut pas supprimer celle là tant qu'elle n'est pas vide
      if ( $liste_cat == '')	  
	  {
	     message_die(GENERAL_ERROR, "Impossible de supprimer la catégorie, elle n'est pas vide.");
	  }

	  	$template->set_filenames(array(
		"body" => "admin/arcade_cat_delete_body.tpl")
		);

		$hidden_fields = '<input type="hidden" name="mode" value="movedel" />';
		$hidden_fields .= '<input type="hidden" name="arcade_catid" value="' . $arcade_catid . '" />';
	
		$template->assign_vars(array(
			"S_ACTION" => append_sid("admin_arcade_games.$phpEx"),
			"S_HIDDEN_FIELDS" => $hidden_fields,
			"L_TITLE" => $lang['arcade_cat_delete'],
			"L_EXPLAIN" => $lang['arcade_delete_cat_explain'],
			"L_ARCADE_CAT_DELETE" => $lang['arcade_cat_delete'],
			"L_ARCADE_CAT_TITLE" => $lang['arcade_cat_title'],
			"L_MOVE_CONTENTS" => $lang['arcade_cat_move_elmt'],
			"S_SELECT_TO" => $liste_cat,
      "CATTITLE" => $cattitle,
			"S_SUBMIT_VALUE" => $lang['arcade_cat_move_and_del'])
		);

		$template->pparse("body");

		include('./page_footer_admin.'.$phpEx);
		exit;
  }
}


/*-----------------------------------------------/
/ A-t'on demandé la création d'une nouvelle catégorie ?
/-----------------------------------------------*/
if ( $mode == 'editcreate')
{
// récupération des infos saisies
	$arcade_cattitle   = get_var2(array('name'=>'arcade_cattitle' , 'intval'=>false, 'method'=>'POST' ));
	$arcade_catauth   = get_var2(array('name'=>'arcade_catauth' , 'intval'=>true, 'okvar'=>array(0,1,2,3,4,5,6), 'default'=>0, 'method'=>'POST' ));
	if( trim($arcade_cattitle) == '')
	{
		message_die(GENERAL_ERROR, "Impossible de créer une catégorie sans nom");
	}

	$sql = "SELECT MAX(arcade_catorder) AS max_order
			FROM " . ARCADE_CATEGORIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'obtenir le dernier numéro d'ordre de la table arcade_categories", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_order = $row['max_order'];
			$next_order = $max_order + 10;

			$sql = "INSERT INTO " . ARCADE_CATEGORIES_TABLE . " ( arcade_cattitle, arcade_nbelmt, arcade_catorder )
			        VALUES ('" . str_replace("\'","''",$arcade_cattitle) . "', 0, $next_order)" ;
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
			}
}

/*-----------------------------------------------/
/ A-t'on demandé la mise à jour d'une catégorie ?
/-----------------------------------------------*/
if ( $mode == 'editsave')
{
// récupération des infos saisies
	$arcade_cattitle   = get_var2(array('name'=>'arcade_cattitle'  , 'intval'=>false, 'method'=>'POST' ));
	$arcade_catauth   = get_var2(array('name'=>'arcade_catauth' , 'intval'=>true, 'okvar'=>array(0,1,2,3,4,5,6), 'default'=>0, 'method'=>'POST' ));
	if( trim($arcade_cattitle) == '')
	{
		message_die(GENERAL_ERROR, "Impossible de créer une catégorie sans nom");
	}

	$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET 
	   arcade_cattitle = '" . str_replace("\'","''",$arcade_cattitle) . "'
	   , arcade_catauth = $arcade_catauth
	        WHERE arcade_catid = '$arcade_catid'";

	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
	}
}

/*-----------------------------------------------/
/ A-t'on demandé de déplacer une catégorie ?
/-----------------------------------------------*/
if ( $mode == 'move')
{
// récupération des infos de déplacement
	$catid2 = get_var2(array('name'=>'catid2', 'intval'=>true, 'method'=>'GET' ));
	$arcade_catorder   = get_var2(array('name'=>'arcade_catorder'  , 'intval'=>true, 'method'=>'GET' ));
	$catorder2   = get_var2(array('name'=>'catorder2'  , 'intval'=>true, 'method'=>'GET' ));

	$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET 
	   arcade_catorder = $arcade_catorder + $catorder2 - arcade_catorder
	        WHERE arcade_catid = '$arcade_catid' OR arcade_catid = '$catid2'";

	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
	}
}

/*-----------------------------------------------/
/ A-t'on demandé l'édition d'une catégorie ?
/-----------------------------------------------*/
if ( $mode == 'edit')
{
	$sql = "SELECT arcade_cattitle, arcade_catauth FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid = '$arcade_catid'";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'obtenir les infos de la table arcade_categories", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

	$template->set_filenames(array(
		"body" => "admin/arcade_catedit_body.tpl")
	);
	//Membres
	$selected0 = ( $row['arcade_catauth']==0 ) ? "selected='selected'" : "" ;
	//Privé
	$selected1 = ( $row['arcade_catauth']==1 ) ? "selected='selected'" : "" ;
	//Privé [Invisible]
	$selected2 = ( $row['arcade_catauth']==2 ) ? "selected='selected'" : "" ;
	//Modérateurs
	$selected3 = ( $row['arcade_catauth']==3 ) ? "selected='selected'" : "" ;
	//Modérateurs [Invisible]
	$selected4 = ( $row['arcade_catauth']==4 ) ? "selected='selected'" : "" ;
	//Administrateurs
	$selected5 = ( $row['arcade_catauth']==5 ) ? "selected='selected'" : "" ;
	//Administrateurs [Invisible]
	$selected6 = ( $row['arcade_catauth']==6 ) ? "selected='selected'" : "" ;

	$liste_auth = '';
	$liste_auth .= "<option value='0' $selected0 >" . $lang['arcade_auth_0']. '</options>';
	$liste_auth .= "<option value='1' $selected1 >" . $lang['arcade_auth_1']. '</options>';
	$liste_auth .= "<option value='2' $selected2 >" . $lang['arcade_auth_2']. '</options>';
	$liste_auth .= "<option value='3' $selected3 >" . $lang['arcade_auth_3']. '</options>';
	$liste_auth .= "<option value='4' $selected4 >" . $lang['arcade_auth_4']. '</options>';
	$liste_auth .= "<option value='5' $selected5 >" . $lang['arcade_auth_5']. '</options>';
	$liste_auth .= "<option value='6' $selected6 >" . $lang['arcade_auth_6']. '</options>';

	
	$hidden_fields = '<input type="hidden" name="mode" value="editsave" />';
	$hidden_fields .= '<input type="hidden" name="arcade_catid" value="' . $arcade_catid . '" />';
	
	$template->assign_vars(array(
		"S_ACTION" => append_sid("admin_arcade_games.$phpEx"),
		"S_HIDDEN_FIELDS" => $hidden_fields,
		"L_TITLE" => $lang['Admin_arcade_cat'],
		"L_EXPLAIN" => $lang['Admin_arcade_editcat_explain'],
		"L_SETTINGS" => $lang['arcade_categorie_settings'],
		"L_CAT_TITRE" => $lang['arcade_cat_titre'],
		"L_CAT_AUTH" => $lang['arcade_cat_auth'],
    "CAT_TITLE" => strip_htmlchars( $row['arcade_cattitle']),
    "S_AUTH" => $liste_auth,
		"L_SUBMIT" => $lang['Submit'])
	);

	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
	exit;
}

/*-----------------------------------------------/
/ A-t'on demandé l'édition d'une nouvelle catégorie ?
/-----------------------------------------------*/
if ( $mode == 'new' )
{
	$template->set_filenames(array(
		"body" => "admin/arcade_catedit_body.tpl")
	);

	$liste_auth = '';
	$liste_auth .= "<option value='0' selected='selected'>" . $lang['arcade_auth_0']. '</options>';
	$liste_auth .= "<option value='1' >" . $lang['arcade_auth_1']. '</options>';
	$liste_auth .= "<option value='2' >" . $lang['arcade_auth_2']. '</options>';
	$liste_auth .= "<option value='3' >" . $lang['arcade_auth_3']. '</options>';
	$liste_auth .= "<option value='4' >" . $lang['arcade_auth_4']. '</options>';
	$liste_auth .= "<option value='5' >" . $lang['arcade_auth_5']. '</options>';
	$liste_auth .= "<option value='6' >" . $lang['arcade_auth_6']. '</options>';

	$hidden_fields = '<input type="hidden" name="mode" value="editcreate" />';
	$template->assign_vars(array(
		"S_ACTION" => append_sid("admin_arcade_games.$phpEx"),
		"S_HIDDEN_FIELDS" => $hidden_fields,
    "S_AUTH" => $liste_auth,
		"L_TITLE" => $lang['Admin_arcade_cat'],
		"L_EXPLAIN" => $lang['Admin_arcade_editcat_explain'],
		"L_SETTINGS" => $lang['arcade_categorie_settings'],
		"L_CAT_TITRE" => $lang['arcade_cat_titre'],
		"L_SUBMIT" => $lang['Submit'])
	);

	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
	exit;
}

//
// Récupération de la liste des catégories pour les afficher.
//
$sql = "SELECT *
	    FROM " . ARCADE_CATEGORIES_TABLE . 
	  " ORDER BY arcade_catorder ASC ";
		
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query arcade_categorie in admin_arcade", "", __LINE__, __FILE__, $sql);
}

$template->set_filenames(array(
	"body" => "admin/arcade_cat_manage_body.tpl")
);

/*---------------------------------------------/
/ Initialisation des variables principales
/---------------------------------------------*/

$hidden_fields = '<input type="hidden" name="mode" value="new" />';

$template->assign_vars(array(
	"S_ACTION" => append_sid("admin_arcade_games.$phpEx"),
	"S_HIDDEN_FIELDS" => $hidden_fields,
	"L_TITLE" => $lang['Admin_arcade_cat'],
	"L_EXPLAIN" => $lang['Admin_arcade_cat_explain'],
	"L_DESCRIPTION" => $lang['Description'],
	"L_ACTION" => $lang['Action'],
	"L_EDIT" => $lang['Edit'],
	"L_MANAGE" => $lang['Manage'],
	"L_DELETE" => $lang['Delete'],
	"L_DEPLACE" => $lang['Deplace'],
	"L_SYNCHRO" => $lang['Resynch'],
	"L_NEWCAT" => $lang['New_category'],
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'])
);

$liste_cat = array();
// Récupération de toutes les catégories
while( $row = $db->sql_fetchrow($result) )
{
  $liste_cat[] = $row;
}

$nbcat = sizeof($liste_cat);
// Affichage des catégories
for ( $i = 0 ; $i < $nbcat ; $i++ )
{
  $td_row = ( $td_row == 'row1' ) ? 'row2' : 'row1' ;

   $template->assign_block_vars('arcade_catrow', array(
	  'TD_ROW' => $td_row,
	  'L_UP' => ( $i > 0) ? $lang['Up_arcade_cat'] . '<br />' : '',
	  'L_DOWN' => ( $i < $nbcat-1 ) ? $lang['Down_arcade_cat'] : '',
    'ARCADE_CATID' => $liste_cat[$i]['arcade_catid'],
    'ARCADE_CATTITLE' => $liste_cat[$i]['arcade_cattitle'],
	  'U_EDIT' =>  append_sid("admin_arcade_games.$phpEx?mode=edit&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
	  'U_MANAGE' =>  append_sid("arcade_elmt.$phpEx?arcade_catid=" . $liste_cat[$i]['arcade_catid']),
 	  'U_UP' => ( $i > 0) ? append_sid("admin_arcade_games.$phpEx?mode=move&amp;arcade_catid=" . $liste_cat[ $i ]['arcade_catid'] . "&amp;catid2="  . $liste_cat[ $i - 1 ]['arcade_catid'] . "&amp;arcade_catorder=" .  $liste_cat[ $i ]['arcade_catorder'] . "&amp;catorder2=" . $liste_cat[ $i - 1 ]['arcade_catorder']) : '',
 	  'U_DOWN' => ( $i < $nbcat-1 ) ? append_sid("admin_arcade_games.$phpEx?mode=move&amp;arcade_catid=" . $liste_cat[ $i ]['arcade_catid'] . "&amp;catid2="  . $liste_cat[ $i + 1 ]['arcade_catid'] . "&amp;arcade_catorder=" .  $liste_cat[ $i ]['arcade_catorder'] . "&amp;catorder2=" . $liste_cat[ $i + 1 ]['arcade_catorder']) : '',
	  'U_DELETE' => append_sid("admin_arcade_games.$phpEx?mode=delete&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
	  'U_SYNCHRO' => append_sid("admin_arcade_games.$phpEx?mode=resynch&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
	  'ARCADE_CAT_NBELMT' => $liste_cat[$i]['arcade_nbelmt'],
	  'ARCADE_CATORDER' => $liste_cat[$i]['arcade_catorder']
     )
    );
}

/*---------------------------------------------/
/ Génération de la page
/---------------------------------------------*/
$template->pparse("body");
include('./page_footer_admin.'.$phpEx);

?>
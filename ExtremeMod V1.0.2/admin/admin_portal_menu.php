<?php
/***************************************************************************
 *                              admin_portal_menu.php
 *                            -------------------
 *   begin                : Vendredi 01 Août 2003
 *   email                : giefca@hotmail.com
 *
 * Administration des menus de navigation du portail
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_portal_module']['Module_menu'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

function makepath($chemin)
{
	global $phpbb_root_path ;
	return ( substr($chemin, 0, 7) == 'http://') ? $chemin : $phpbb_root_path . $chemin ;
}
language_include('admin_menu');
$template->set_filenames(array(
	"body" => "admin/portal_menu_body.tpl")
);

// Récupération des variables textes
$params_chars = array('mode', 'move', 'update', 'new', 'navlig_langkey', 'navlig_texte', 'navlig_imgkey', 'navlig_url', 'navlig_script', 'navlig_iconeimg', 'navlig_cars','menu_desc' );
foreach($params_chars as $var)
{
	if(isset($HTTP_POST_VARS[$var]) || isset($HTTP_GET_VARS[$var]))
	{
		$$var = (isset($HTTP_POST_VARS[$var])) ? $HTTP_POST_VARS[$var] : $HTTP_GET_VARS[$var];
	}
}

// Récupération des variables entieres
$params_int = array('bid', 'lig', 'lig2', 'ord', 'ord2', 'navlig_type', 'navlig_tab', 'navlig_tabsize', 'navlig_icone', 'navlig_iconesize', 'navlig_auth', 'maf', 'page_id', 'navlig_add_sid');
foreach($params_int as $var)
{
	if(isset($HTTP_POST_VARS[$var]) || isset($HTTP_GET_VARS[$var]))
	{
		$$var = (isset($HTTP_POST_VARS[$var])) ? intval($HTTP_POST_VARS[$var]) : intval($HTTP_GET_VARS[$var]);
	}
}

//en prévision de multiple menus
$idblock = ( isset($bid)) ? $bid : 0 ;
if ( !isset($maf)) $maf = 99;//mode d'affichage par défaut : complet

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


if ( isset($mode) )
{
  switch ( $mode )
  {
   case 'duplique' :
    $sql = "INSERT INTO " . NAVMEN_TABLE . " (menu_desc) SELECT CONCAT(menu_desc,'*') FROM " . NAVMEN_TABLE . " WHERE menu_id = $idblock";
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$idnew = $db->sql_nextid();
	$sql = "INSERT INTO " . NAVIG_TABLE . " (navlig_type, navlig_langkey, navlig_texte, navlig_url, navlig_script, navlig_icone, navlig_imgkey, navlig_iconeimg, navlig_iconesize, navlig_order, navlig_tab, navlig_tabsize, navlig_auth, menu_id, navlig_cars)
	 SELECT navlig_type, navlig_langkey, navlig_texte, navlig_url, navlig_script,
	navlig_icone, navlig_imgkey, navlig_iconeimg, navlig_iconesize, navlig_order, navlig_tab, navlig_tabsize, navlig_auth, '$idnew', navlig_cars FROM " . NAVIG_TABLE . " WHERE menu_id = $idblock";
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal_navig table!", "", __LINE__, __FILE__, $sql);
	}
	$idblock = 0;
   break;

   case 'associate' :
	$sql = "UPDATE " . PAGMEN_TABLE . " SET menu_id = '$idblock' WHERE page_id = '$page_id'"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal_pagmen table!", "", __LINE__, __FILE__, $sql);
	}
    $idblock = 0;
   break;
      
   case 'savemenu' :
   $menu_desc = str_replace('\'' , "''" , stripslashes($menu_desc));
	if ( empty($menu_desc) ) message_die(GENERAL_MESSAGE, $lang['No_menu_desc']);
	$sql = "UPDATE " . NAVMEN_TABLE . " SET menu_desc = '$menu_desc' WHERE menu_id = '$idblock'"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$idblock = 0;
   break;
      
   case 'createmenu' :
   $menu_desc = str_replace('\'' , "''" , stripslashes($menu_desc));
	if ( empty($menu_desc) ) message_die(GENERAL_MESSAGE, $lang['No_menu_desc']);
	$sql = "INSERT INTO " . NAVMEN_TABLE . " (menu_desc) VALUES ('$menu_desc')"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
   break;

   case 'deletemenu' :
   	$sql = "DELETE FROM " . NAVIG_TABLE . " WHERE menu_id = $idblock"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not delete portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$sql = "DELETE FROM " . PAGMEN_TABLE . " WHERE menu_id = $idblock"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not delete portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$sql = "DELETE FROM " . NAVMEN_TABLE . " WHERE menu_id = $idblock"; 
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not delete portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$idblock = 0;
   break;   
   
   case 'default' :
    $sql = 'UPDATE ' . PORTAL_TABLE . " SET portal_value = '$idblock' WHERE portal_name = 'default_mennav'";
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update portal table!", "", __LINE__, __FILE__, $sql);
	}
	$portal_config['default_mennav'] = $idblock ;
	$idblock = 0;

   case 'editmenu' :
	$template->set_filenames(array(
		"body" => "admin/menu_edit_body.tpl")
	);
   	$sql = "SELECT menu_desc FROM " . NAVMEN_TABLE . " WHERE menu_id = $idblock"; 
	if(!$result=$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	if (!$row = $db->sql_fetchrow($result))
	{
		message_die(GENERAL_ERROR, "Le bloc n'existe pas!");
	}
	$hidden_fields = '';
	$hidden_fields .= '<input type="hidden" name="mode" value="savemenu"/>';
	$hidden_fields .= '<input type="hidden" name="bid" value="' . $idblock . '"/>';
	$template->assign_vars(array(
		"L_MENUS_TITLE" => $lang['Manage_portal_menus'],
		"L_MENUS_TEXT" => $lang['Edit_menu_explain'],
		"L_MENU" => $lang['Menu'],
		"L_MENU_DESC" => $lang['Menu_desc'],
		"MENU_DESC" => $row['menu_desc'],
		"S_SUBMIT_VALUE" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $hidden_fields,
		"S_MENUS_ACTION" => append_sid("admin_portal_menu.$phpEx")
		)
	);
	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);   
   
   default:
   break;
  }
}


//Si aucun bloc n'est sélectionné on affiche la liste des menus créés et des pages qui leur sont
//associées.
if ($idblock == 0)
{
	$sql = "SELECT * FROM " . NAVMEN_TABLE . " ORDER BY menu_id ASC ";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$liste_menus[] = $row ;
	}
		
	$liste_pages = array();	
	$sql = "SELECT p.page_id, p.page_desc, pm.page_id as pmid, pm.menu_id FROM " . PORTAL_PAGE . " p LEFT JOIN " . PAGMEN_TABLE . " pm ON p.page_id = pm.page_id ORDER BY pm.menu_id , p.page_id";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query portal_navmen table!", "", __LINE__, __FILE__, $sql);
	}
	$liste_default = ''; //Liste des pages qui ne sont encore liées à aucun bloc menu
	$tabpages = array();
	$nbpages = 0 ;
	while( $row = $db->sql_fetchrow($result) )
	{
	  if( is_null($row['menu_id']) )
	  {
	    if ( !empty($liste_default)) $liste_default .= ', ';
	    $liste_default .= "( '" . $row['page_id'] . "', '" . $portal_config['default_mennav'] . "')" ;
	    $liste_pages[$portal_config['default_mennav']][] = $row ;
		$tabpages[$nbpages]['menu_id'] = $portal_config['default_mennav'];
		$tabpages[$nbpages]['page_id'] = $row['page_id'];
		$tabpages[$nbpages]['page_desc'] = stripslashes($row['page_desc']);
	  }
	  else
	  {
  	    $liste_pages[$row['menu_id']][] = $row ;
		$tabpages[$nbpages]['menu_id'] = $row['menu_id'];
		$tabpages[$nbpages]['page_id'] = $row['page_id'];
		$tabpages[$nbpages]['page_desc'] = stripslashes($row['page_desc']);
	  }
	  $nbpages++;
	}

	//S'il existe encore des pages qui ne sont associées à aucun bloc, on les associe au bloc menu par défaut.
	if (!empty( $liste_default ))
	{
	  $sql = 'INSERT INTO ' . PAGMEN_TABLE . ' ( page_id , menu_id ) VALUES ' . $liste_default ;
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update portal_pagmen table!", "", __LINE__, __FILE__, $sql);
		}
	}
	$template->set_filenames(array(
		"body" => "admin/menus_manage_body.tpl")
	);

	$template->assign_vars(array(
		"L_MENUS_TITLE" => $lang['Manage_portal_menus'],
		"L_MENUS_TEXT" => $lang['Manage_portal_menus_explain'],
		"L_MENU" => $lang['Menu'],
		"S_MENUS_ACTION" => append_sid("admin_portal_menu.$phpEx"),
		"L_ACTION" => $lang['Action'],
		"L_MANAGE_MENUS" => $lang['Manage_menus'],
		"L_CREATE_MENU" => $lang['Create_menu'],
		"L_EDIT" => $lang['Edit'],
		"L_MANAGE" => $lang['Manage'],
		"L_DELETE" => $lang['Delete'],
		"L_DUPLIQUE" => ( intval( substr(mysql_get_server_info(),0,1) ) >= 4 ) ? $lang['Duplique'] : ''
		)
	);
				
	for($i = 0; $i < count($liste_menus); $i++)
	{
		
		$pages_associables = '';
        for($ip = 0; $ip < $nbpages; $ip++)
		{
		  if( $tabpages[$ip]['menu_id'] != $liste_menus[$i]['menu_id'])
		  {
		    $pages_associables .= '<option value="' . $tabpages[$ip]['page_id'] . '">' . $tabpages[$ip]['page_desc'] . '</option>\n' ;
		  }
		}
		$template->assign_block_vars("menu_row", array(
			"MENU_DESC" => stripslashes( $liste_menus[$i]['menu_desc'] ),
			"IMG_STAR" => ($liste_menus[$i]['menu_id'] == $portal_config['default_mennav'])? "<img src='" . $phpbb_root_path ."images/etoile.gif' align='absmiddle' alt='" . $lang['default_portal_menu'] . "' />": "",
			"U_MENU_EDIT" => append_sid("admin_portal_menu.$phpEx?mode=editmenu&amp;bid=" . $liste_menus[$i]['menu_id'] ),
			"U_MENU_MANAGE" => append_sid("admin_portal_menu.$phpEx?mode=manage&amp;bid=" . $liste_menus[$i]['menu_id'] ),
			"U_MENU_DELETE" => ( $liste_menus[$i]['menu_id'] != $portal_config['default_mennav'] ) ? '<a href="' . append_sid("admin_portal_menu.$phpEx?mode=deletemenu&amp;bid=" . $liste_menus[$i]['menu_id'] ) . '" >' . $lang['Delete'] . '</a>' : "",
			"U_DUPLIQUE" => append_sid("admin_portal_menu.$phpEx?mode=duplique&amp;bid=" . $liste_menus[$i]['menu_id'] ),
			"U_DEFINE_DEFAULT" => ( $liste_menus[$i]['menu_id'] != $portal_config['default_mennav'] ) ? '<a href="' . append_sid("admin_portal_menu.$phpEx?mode=default&amp;bid=" . $liste_menus[$i]['menu_id'] ) . '" >' . $lang['Define_default_menu'] . '</a><br />' : "",
			"S_BID" => $liste_menus[$i]['menu_id'])
		);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$nbp = sizeof( $liste_pages[ $liste_menus[$i]['menu_id'] ]);
		for ($p_ = 0 ; $p_ < $nbp ; $p_++ )
		{
			$template->assign_block_vars("menu_row.page_row", array(
				"ROW_CLASS" => $row_class,
				"ROW_COLOR" => "#" . $row_color,
				"PAGE_DESC" => stripslashes( $liste_pages[ $liste_menus[$i]['menu_id'] ][$p_]['page_desc'])
				)
			  );
		}			

		if (!empty($pages_associables))
		{
 			$template->assign_block_vars("menu_row.associate_row", array(
				"SELECT_PAGES" => $pages_associables,
				"ASSOCIATE_PAGE" => $lang['associate_page'],
				"BID" => $liste_menus[$i]['menu_id']
				 )
			);
		}
	}
	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}




// TEST S'IL Y A UNE ACTION A EFFECTUER
if ( isset($update) )
{
  $mode = 'update';
}
if ( isset($new) )
{
  $mode = 'new';
}

switch ( $mode )
{
	case 'move' :
		$sql = "UPDATE " . NAVIG_TABLE . " SET navlig_order = $ord + $ord2 - navlig_order WHERE navlig_id = $lig OR navlig_id = $lig2 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not update menu portal table", "", __LINE__, __FILE__, $sql);
		}				
		break ;
	case 'delete' :
		$sql = "DELETE FROM " . NAVIG_TABLE . " WHERE navlig_id = $lig ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not update menu portal table", "", __LINE__, __FILE__, $sql);
		}				
		break ;
	case 'new' :
		$sql = "SELECT MAX(navlig_order) AS maxorder FROM " . NAVIG_TABLE . " WHERE menu_id = $idblock ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not query menu portal table", "", __LINE__, __FILE__, $sql);
		}
		if ( $row = $db->sql_fetchrow($result))
		{ $maxorder = $row['maxorder']+1;
		 }
		else
		{
		  $maxorder = 0;
		}
		$sql = "INSERT INTO " . NAVIG_TABLE . " 
		( navlig_type, navlig_langkey, navlig_texte, navlig_url, navlig_script, navlig_icone, navlig_imgkey, navlig_iconeimg, navlig_iconesize, navlig_order, navlig_tab, navlig_tabsize, navlig_auth, menu_id, navlig_cars, navlig_add_sid)
		VALUES ( $navlig_type, '" . str_replace("\'","''",$navlig_langkey) . "', '" . str_replace("\'","''",$navlig_texte) . "', '" . str_replace("\'","''",$navlig_url) . "', '" . str_replace("\'","''",$navlig_script) . "', $navlig_icone, '" . str_replace("\'","''",$navlig_imgkey) . "', '" . str_replace("\'","''",$navlig_iconeimg) . "', $navlig_iconesize,
		$maxorder, $navlig_tab, $navlig_tabsize, $navlig_auth, $idblock, '" . str_replace("\'","''",$navlig_cars) . "', $navlig_add_sid)";
		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, "Could not update menu portal table", "", __LINE__, __FILE__, $sql);
		}				
		break;
	case 'update' :
		$sql = "UPDATE " . NAVIG_TABLE . " 
		SET navlig_type=$navlig_type, navlig_langkey='" . str_replace("\'","''",$navlig_langkey) . "', navlig_texte='" . str_replace("\'","''",$navlig_texte) . "'
		, navlig_url='" . str_replace("\'","''",$navlig_url) . "'
		, navlig_script='" . str_replace("\'","''",$navlig_script) . "'
		, navlig_icone=$navlig_icone
		, navlig_imgkey='" . str_replace("\'","''",$navlig_imgkey) . "'
		, navlig_iconeimg='" . str_replace("\'","''",$navlig_iconeimg) . "'
		, navlig_iconesize=$navlig_iconesize
		, navlig_tab=$navlig_tab
		, navlig_tabsize=$navlig_tabsize
		, navlig_auth=$navlig_auth
		, navlig_cars='" . str_replace("\'","''",$navlig_cars) . "' 
		, navlig_add_sid = $navlig_add_sid
		  WHERE navlig_id = $lig ";
		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, "Could not update menu portal table", "", __LINE__, __FILE__, $sql);
		}				
		break;

}

// DESCRIPTION DU MENU
	$sql = "SELECT * FROM " . NAVMEN_TABLE . " WHERE menu_id = $idblock " ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query menu information", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$template->assign_vars(array(
		"MENU_DESC" => $row['menu_desc'])
	);
	
// AFFICHAGE DU MENU (PARTIE GAUCHE DE L'ECRAN')
	$sql = "SELECT * FROM " . NAVIG_TABLE . " WHERE menu_id = $idblock ORDER BY navlig_order ASC " ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query menu information", "", __LINE__, __FILE__, $sql);
	}
	$template->assign_vars(array(
		'PORTAL_CLASS_BALISE' => $board_config['portal_class_balise'],
		'PORTAL_CLASS_TITLE' => $board_config['portal_class_title'],
		"L_MENU" => $lang['Board_navigation'])
	);

	$inlien = false ;
	$first = true ;
	$ligne=0;
	
	while( $row = $db->sql_fetchrow($result) )
	{
	//Selon les droits d'affichage doit-on afficher cette ligne ou pas ?
	  $auth_menu = false ;
	  
	  switch( $row['navlig_auth'] )
	  {
	   	case AUTH_ALL :
			$auth_menu = true ;
			break ;
		case AUTH_REG :
			$auth_menu = ($maf != ANONYMOUS) ;
			break;
		case ANONYMOUS :
			$auth_menu = ($maf == ANONYMOUS) ;
			break;
		case AUTH_MOD :
			$auth_menu = (($maf == AUTH_MOD) or ($maf == AUTH_ADMIN));
			break;
		case AUTH_ADMIN :
			$auth_menu = ($maf == AUTH_ADMIN) ;
			break;
	  }  
	  if ( $maf == 99 ) $auth_menu = true ;
	  if ( $auth_menu )
	  {
	  	 $menu[] = $row ;
		 $nblig++;
	  }
	}

	for ( $i=0; $i<$nblig; $i++ )
	{
		if ($i>0)
		{
		
			$linkup = append_sid("admin_portal_menu.$phpEx?mode=move&amp;bid=$idblock&amp;maf=$maf&amp;lig=" . $menu[ $i ]['navlig_id'] . "&amp;lig2="  . $menu[ $i - 1 ]['navlig_id'] . 
									"&amp;ord=" .  $menu[ $i ]['navlig_order'] . "&amp;ord2=" .  $menu[ $i - 1 ]['navlig_order']);
			$up = '<a href="' . $linkup . '">' . "<img src='../images/up.gif' border='0' alt='" . $lang['Move_up'] ."' /></a>";
		}
		else
		{
			$up = "";
		}

		if ($i<$nblig-1)
		{
			$linkdown = append_sid("admin_portal_menu.$phpEx?mode=move&amp;bid=$idblock&amp;maf=$maf&amp;lig=" . $menu[ $i ]['navlig_id']  . "&amp;lig2="  . $menu[ $i + 1 ]['navlig_id'] . 
									"&amp;ord=" .  $menu[ $i ]['navlig_order'] . "&amp;ord2=" .  $menu[ $i + 1 ]['navlig_order']);
			$down = '<a href="' . $linkdown . '">' . "<img src='../images/down.gif' border='0' alt='" . $lang['Move_down'] ."' /></a>";
		}
		else
		{
			$down = "";
		}	
		$linkdelete = append_sid("admin_portal_menu.$phpEx?mode=delete&amp;bid=$idblock&amp;maf=$maf&amp;lig=" . $menu[ $i ]['navlig_id'] );
		$delete = '<a href="' . $linkdelete . '">' . "<img src='../images/moins.gif' border='0' alt='" . $lang['Delete'] ."' /></a>";
		$linkedit = append_sid("admin_portal_menu.$phpEx?mode=edit&amp;bid=$idblock&amp;maf=$maf&amp;lig=" . $menu[ $i ]['navlig_id'] );
		$edit = '<a href="' . $linkedit . '">' . "<img src='../images/right.gif' border='0' alt='" . $lang['Edit'] ."' /></a>";
		
		switch($menu[$i]['navlig_type'])
		{
			case '0':
				//Séparation simple
				$desc = ( !empty($menu[$i]['navlig_langkey']) and !empty($lang[$menu[$i]['navlig_langkey']])) ? $lang[$menu[$i]['navlig_langkey']] : $menu[$i]['navlig_texte'] ;
				$retrait = ( !empty($menu[$i]['navlig_tab']) and !empty($menu[$i]['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $menu[$i]['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($menu[$i]['navlig_iconesize']) and $menu[$i]['navlig_iconesize']!=0 ) ? ' width="' . $menu[$i]['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($menu[$i]['navlig_imgkey']) and !empty($images[$menu[$i]['navlig_imgkey']])) ? $images[$menu[$i]['navlig_imgkey']] : $menu[$i]['navlig_iconeimg'] ;
				$icone = ( !empty($menu[$i]['navlig_icone']) and !empty( $urlicone ))? '<img src="' . makepath($urlicone) . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;
				$template->assign_block_vars('rubrique_row', array() );
				$template->assign_block_vars('rubrique_row.simple_row', array(
					"DOWN" => $down,
					"UP" => $up,
					"DELETE" => $delete,
					"EDIT" => $edit,
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $menu[$i]['navlig_cars'],
					"DESC" => $desc
					)
				);
				$inlien = false ;
				break;
			case '1':
				//Séparation entête
				$desc = ( !empty($menu[$i]['navlig_langkey']) and !empty($lang[$menu[$i]['navlig_langkey']])) ? $lang[$menu[$i]['navlig_langkey']] : $menu[$i]['navlig_texte'] ;
				$retrait = ( !empty($menu[$i]['navlig_tab']) and !empty($menu[$i]['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $menu[$i]['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($menu[$i]['navlig_iconesize']) and $menu[$i]['navlig_iconesize']!=0 ) ? ' width="' . $menu[$i]['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($menu[$i]['navlig_imgkey']) and !empty($images[$menu[$i]['navlig_imgkey']])) ? $images[$menu[$i]['navlig_imgkey']] : $menu[$i]['navlig_iconeimg'] ;
				$icone = ( !empty($menu[$i]['navlig_icone']) and !empty( $urlicone ))? '<img src="' . makepath($urlicone) . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;
				$template->assign_block_vars('rubrique_row', array() );
				$template->assign_block_vars('rubrique_row.entete_row', array(
					"DOWN" => $down,
					"UP" => $up,
					"DELETE" => $delete,
					"EDIT" => $edit,
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $menu[$i]['navlig_cars'],
					"DESC" => $desc
					)
				);
				$inlien = false ;
				break;
			case '2':
				//Séparation ligne
				$template->assign_block_vars('rubrique_row', array() );
				$template->assign_block_vars('rubrique_row.ligne_row', array(
					"DOWN" => $down,
					"UP" => $up,
					"DELETE" => $delete,
					"EDIT" => $edit
					)
				);
				$inlien = false ;
				break;
			case '3':
				//Séparation image
				$template->assign_block_vars('rubrique_row', array() );
				$template->assign_block_vars('rubrique_row.image_row', array(
					"DOWN" => $down,
					"UP" => $up,
					"DELETE" => $delete,
					"EDIT" => $edit,
					"SCRIPT" => $menu[$i]['navlig_script'],
					"URL" => append_sid(makepath($menu[$i]['navlig_url']))
					)
				);
				$inlien = false ;
				break;
			case '4':
				//Séparation Liens
				$template->assign_block_vars('rubrique_row', array() );
				$desc = ( !empty($menu[$i]['navlig_langkey']) and !empty($lang[$menu[$i]['navlig_langkey']])) ? $lang[$menu[$i]['navlig_langkey']] : $menu[$i]['navlig_texte'] ;
				$retrait = ( !empty($menu[$i]['navlig_tab']) and !empty($menu[$i]['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $menu[$i]['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($menu[$i]['navlig_iconesize']) and $menu[$i]['navlig_iconesize']!=0 ) ? ' width="' . $menu[$i]['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($menu[$i]['navlig_imgkey']) and !empty($images[$menu[$i]['navlig_imgkey']])) ? $images[$menu[$i]['navlig_imgkey']] : $menu[$i]['navlig_iconeimg'] ;
				$icone = ( !empty($menu[$i]['navlig_icone']) and !empty( $urlicone ))? '<img src="' . makepath($urlicone) . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;
				$template->assign_block_vars('rubrique_row.lien_row', array(
					"DOWN" => $down,
					"UP" => $up,
					"DELETE" => $delete,
					"EDIT" => $edit,
					"URL" => append_sid(makepath($menu[$i]['navlig_url'])),
					"SCRIPT" => $menu[$i]['navlig_script'],
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $menu[$i]['navlig_cars'],
					"DESC" => $desc)
				);

			default:
				break;
		}
		$first = false ;
	}
// FIN AFFICHAGE DU MENU

// Si on a demandé l'affichage d'une ligne
if ( $mode == 'edit' )
{
	$template->assign_block_vars('update_row',array());
	$sql = "SELECT * FROM " . NAVIG_TABLE . " WHERE navlig_id = $lig ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query menu portal table", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$s_type0 = ( $row['navlig_type']==0 ) ? "checked=\"checked\"" : "";
	$s_type1 = ( $row['navlig_type']==1 ) ? "checked=\"checked\"" : "";
	$s_type2 = ( $row['navlig_type']==2 ) ? "checked=\"checked\"" : "";
	$s_type3 = ( $row['navlig_type']==3 ) ? "checked=\"checked\"" : "";
	$s_type4 = ( $row['navlig_type']==4 ) ? "checked=\"checked\"" : "";

	$langkey = str_replace('&', '&amp;', $row['navlig_langkey']);
	$langkey = str_replace('"', '&quot;', $langkey);
	
	$s_texte = str_replace('&', '&amp;', $row['navlig_texte']);
	$s_texte = str_replace('"', '&quot;', $s_texte);
	
	$s_url = $row['navlig_url'];
	$s_script_url = str_replace('&', '&amp;', $row['navlig_script']);
	$s_script_url = str_replace('"', '&quot;', $s_script_url);
	$s_script_url = str_replace('<', '&lt;', $s_script_url);
	
	$s_add_sid_yes = ($row['navlig_add_sid']) ? 'checked="checked"' : '';
	$s_add_sid_no = (!$row['navlig_add_sid']) ? 'checked="checked"' : '';
	
	$s_retrait_yes = ( $row['navlig_tab'] ) ? "checked=\"checked\"" : "";
	$s_retrait_no = ( !$row['navlig_tab'] ) ? "checked=\"checked\"" : "";
	$s_retrait_width = $row['navlig_tabsize'];
	
	$s_icone_yes = ( $row['navlig_icone'] ) ? "checked=\"checked\"" : "";
	$s_icone_no = ( !$row['navlig_icone'] ) ? "checked=\"checked\"" : "";
	$s_icone_url = $row['navlig_iconeimg'];
	$s_icone_size = $row['navlig_iconesize'];

	$imgkey = str_replace('&', '&amp;', $row['navlig_imgkey']);
	$imgkey = str_replace('"', '&quot;', $imgkey);
	
	$s_chars = str_replace('&', '&amp;', $row['navlig_cars']);
	$s_chars = str_replace('"', '&quot;', $s_chars);
	
	$auth_vis = ( $row['navlig_auth'] == ANONYMOUS ) ? "selected" : "" ;
	$auth_all = ( $row['navlig_auth'] == AUTH_ALL ) ? "selected" : "" ;
	$auth_reg = ( $row['navlig_auth'] == AUTH_REG ) ? "selected" : "" ;
	$auth_mod = ( $row['navlig_auth'] == AUTH_MOD ) ? "selected" : "" ;
	$auth_admin = ( $row['navlig_auth'] == AUTH_ADMIN ) ? "selected" : "" ;

	$liste_auth  = "<option value='" . AUTH_ALL . "' $auth_all >" . $lang['Menu_ALL'] . "</ option>" ;
	$liste_auth .= "<option value='" . ANONYMOUS . "' $auth_vis >" . $lang['Menu_VIS'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_REG . "' $auth_reg >" . $lang['Menu_REG'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_MOD . "' $auth_mod >" . $lang['Menu_MOD'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_ADMIN . "' $auth_admin >" . $lang['Menu_ADMIN'] . "</ option>" ;
	
	$s_hidden_fields = '<input type="hidden" name="lig" value="' . $lig . '" />';
}
else
{//Sinon on mets les valeurs par défaut
	$s_type0 = "";
	$s_type1 = "";
	$s_type2 = "";
	$s_type3 = "";
	$s_type4 = "checked=\"checked\"";

	$langkey = "";
	$s_texte = "";
	$s_url = "";
	$s_script_url = "";
	
	$s_add_sid_yes = '';
	$s_add_sid_no = 'checked="checked"';
	
	$s_retrait_yes = "";
	$s_retrait_no = "checked=\"checked\"";
	$s_retrait_width = "";

	$s_icone_yes = "";
	$s_icone_no = "checked=\"checked\"";
	$imgkey = "";
	$s_icone_url = "";
	$s_icone_size = "";
	
	$s_chars = "";
	
	$liste_auth  = "<option value='" . AUTH_ALL . "' selected >" . $lang['Menu_ALL'] . "</ option>" ;
	$liste_auth .= "<option value='" . ANONYMOUS . "' >" . $lang['Menu_VIS'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_REG . "' >" . $lang['Menu_REG'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_MOD . "' >" . $lang['Menu_MOD'] . "</ option>" ;
	$liste_auth .= "<option value='" . AUTH_ADMIN . "' >" . $lang['Menu_ADMIN'] . "</ option>" ;

	//$s_hidden_fields = '<input type="hidden" name="maf" value="' . $maf .'" />';
	$s_hidden_fields = "";
}

	$maf_full = ( $maf == 99 ) ? "selected" : "" ;
	$maf_vis = ( $maf == ANONYMOUS ) ? "selected" : "" ;
	$maf_all = ( $maf == AUTH_ALL ) ? "selected" : "" ;
	$maf_reg = ( $maf == AUTH_REG ) ? "selected" : "" ;
	$maf_mod = ( $maf == AUTH_MOD ) ? "selected" : "" ;
	$maf_admin = ( $maf == AUTH_ADMIN ) ? "selected" : "" ;

	$s_maf  = "<option value='99' $maf_full >" . $lang['Menu_FULL'] . "</ option>" ;
	$s_maf .= "<option value='" . ANONYMOUS . "' $maf_vis >" . $lang['Menu_VIS'] . "</ option>" ;
	$s_maf .= "<option value='" . AUTH_REG . "' $maf_reg >" . $lang['Menu_REG'] . "</ option>" ;
	$s_maf .= "<option value='" . AUTH_MOD . "' $maf_mod >" . $lang['Menu_MOD'] . "</ option>" ;
	$s_maf .= "<option value='" . AUTH_ADMIN . "' $maf_admin >" . $lang['Menu_ADMIN'] . "</ option>" ;

$template->assign_vars(array(
	"S_MENU_ACTION" => append_sid("admin_portal_menu.$phpEx"),
	"L_MENU_TITLE" => $lang['Manage_portal_menu'],
	"L_MENU_EXPLAIN" => $lang['Manage_portal_menu_explain'],
	"L_MENU_OPTIONS" => $lang['Menu_options'],
	"L_MENU_DEBUT" => $lang['Menu_debut'],
	"L_TYPE_LIGNE" => $lang['Menu_type_ligne'],
	"L_TYPE_LIGNE_EXPLAIN" => $lang['Menu_type_ligne_explain'],
	"L_SIMPLE" => $lang['Menu_simple_ligne'],
	"L_ENTETE" => $lang['Menu_entete_ligne'],
	"L_LIGNE" => $lang['Menu_ligne'],
	"L_IMAGE" => $lang['Menu_image'],
	"L_LIEN" => $lang['Menu_lien'],
	"L_TEXTE_AFFICHABLE" => $lang['Menu_texte_affichable'],
	"L_TEXTE_AFFICHABLE_EXPLAIN" => $lang['Menu_texte_affichable_explain'],
	"L_LANGKEY" => $lang['Menu_langkey'],
	"L_TEXTE" => $lang['Menu_texte'],
	"L_URL" => $lang['Menu_url'],
	"L_URL_EXPLAIN" => $lang['Menu_url_explain'],
	"L_SCRIPT_URL" => $lang['Menu_script_url'],
	"L_SCRIPT_URL_EXPLAIN" => $lang['Menu_script_url_explain'],
    "L_ADD_SID" => $lang['Menu_add_sid'],
    "L_ADD_SID_EXPLAIN" => $lang['Menu_add_sid_explain'],
    "L_IMGKEY" => $lang['Menu_imgkey'],
	"L_ICONE" => $lang['Menu_icone'],
	"L_ICONE_EXPLAIN" => $lang['Menu_icone_explain'],
	"L_URL_ICONE" => $lang['Menu_url_icone'],
	"L_URL_ICONE_EXPLAIN" => $lang['Menu_url_icone_explain'],
	"L_ICONE_WIDTH" => $lang['Menu_icone_width'],
	"L_ICONE_WIDTH_EXPLAIN" => $lang['Menu_icone_width_explain'],	
	"L_RETRAIT" => $lang['Menu_retrait'],
	"L_RETRAIT_EXPLAIN" => $lang['Menu_retrait_explain'],
	"L_RETRAIT_WIDTH" => $lang['Menu_retrait_width'],
	"L_RETRAIT_WIDTH_EXPLAIN" => $lang['Menu_retrait_width_explain'],	
	"L_CHARS" => $lang['Menu_chars'],
	"L_CHARS_EXPLAIN" => $lang['Menu_chars_explain'],
	"L_AUTH" => $lang['Menu_auth'],
	"L_AFF_TYPE" => $lang['Menu_affichage_type'],
	"L_AFF_TYPE_EXPLAIN" => $lang['Menu_affichage_type_explain'],
	"S_LANGKEY" => $langkey,
	"S_BID" => $idblock,
	"S_TEXTE" => $s_texte,
	"S_URL" => $s_url,
	"S_SCRIPT_URL" => $s_script_url,
	"S_ADD_SID_YES" => $s_add_sid_yes,
	"S_ADD_SID_NO" => $s_add_sid_no,
	"S_TYPE_0" => $s_type0,
	"S_TYPE_1" => $s_type1,
	"S_TYPE_2" => $s_type2,
	"S_TYPE_3" => $s_type3,
	"S_TYPE_4" => $s_type4,
	"S_RETRAIT_YES" => $s_retrait_yes,
	"S_RETRAIT_NO" => $s_retrait_no,
	"S_RETRAIT_WIDTH" => $s_retrait_width,
	"S_ICONE_YES" => $s_icone_yes,
	"S_ICONE_NO" => $s_icone_no,
	"S_IMGKEY" => $imgkey,
	"S_ICONE_URL" => $s_icone_url,
	"S_ICONE_SIZE" => $s_icone_size,
	"S_CHARS" => $s_chars,
	"S_AUTHLIST" => $liste_auth,
	"S_HIDDEN_FIELDS" => $s_hidden_fields,
	"S_MAF" => $s_maf,
	"L_UPDATE" => $lang['Menu_update'],
	"L_NEW" => $lang['Menu_new'],

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	)
);

// Génération de la page

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
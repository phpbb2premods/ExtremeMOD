<?php

/***************************************************************************
 *                                mod_menu.php
 *                            -------------------
 *   commencé le                : Mardi,18 Novembre, 2003
 *   Par : giefca - giefca@hotmail.com - http://www.gf-phpbb.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Minimodule à intégrer dans un Gf-Portail
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//$idblock = 1 ;

//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_menu.tpl')
);

	$sql = "SELECT n.* FROM " . PAGMEN_TABLE . " pm, ". NAVIG_TABLE . " n WHERE pm.menu_id = n.menu_id AND pm.page_id = $page_id ORDER BY navlig_order ASC " ;
	
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query menu information", "", __LINE__, __FILE__, $sql);
	}
	if ( $db->sql_numrows($result) == 0)
	{
		$sql = "SELECT * FROM " . NAVIG_TABLE . " WHERE menu_id = '" . $portal_config['default_mennav'] . "' ORDER BY navlig_order ASC " ;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not query menu information", "", __LINE__, __FILE__, $sql);
		}
	}

	$template_mod->assign_vars(array(
		"L_MENU" => $lang['Board_navigation'])
	);

	$inlien = false ;
	
	while ( $row = $db->sql_fetchrow($result) )
	{
		//Selon les droits d'affichage doit-on afficher cette ligne ou pas ?
	  $auth_menu = false ;
	  switch( $row['navlig_auth'] )
	  {
	   	case AUTH_ALL :
			$auth_menu = true ;
			break ;
		case AUTH_REG :
			$auth_menu = $userdata['session_logged_in'] ;
			break;
		case ANONYMOUS :
			$auth_menu = !$userdata['session_logged_in'] ;
			break;
		case AUTH_MOD :
			$auth_menu = (($userdata['user_level']==MOD)or($userdata['user_level']==ADMIN));
			break;
		case AUTH_ADMIN :
			$auth_menu = ($userdata['user_level']==ADMIN);
			break;
	  }

	  if ( $auth_menu )
	  {	
		switch($row['navlig_type'])
		{
			case '0':
				//Séparation simple
				if ($inlien)
				{
					$template_mod->assign_block_vars('rubrique_row', array() );
					$template_mod->assign_block_vars('rubrique_row.fin_tr', array() );
					$inlien = false ;
				}
				$desc = ( !empty($row['navlig_langkey']) and !empty($lang[$row['navlig_langkey']])) ? $lang[$row['navlig_langkey']] : $row['navlig_texte'] ;
				$retrait = ( !empty($row['navlig_tab']) and !empty($row['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $row['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($row['navlig_iconesize']) and $row['navlig_iconesize']!=0 ) ? ' width="' . $row['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($row['navlig_imgkey']) and !empty($images[$row['navlig_imgkey']])) ? $images[$row['navlig_imgkey']] : $row['navlig_iconeimg'] ;
				$icone = ( !empty($row['navlig_icone']) and !empty( $urlicone ))? '<img src="' . $urlicone . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;
				$template_mod->assign_block_vars('rubrique_row', array() );
				$template_mod->assign_block_vars('rubrique_row.simple_row', array(
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $row['navlig_cars'],
					"DESC" => $desc,
					"TEXTE" => 'Rubrique Simple')
				);
				break;
			case '1':
				//Séparation entête
				if ($inlien)
				{
					$template_mod->assign_block_vars('rubrique_row', array() );
					$template_mod->assign_block_vars('rubrique_row.fin_tr', array() );
					$inlien = false ;
				}
				$desc = ( !empty($row['navlig_langkey']) and !empty($lang[$row['navlig_langkey']])) ? $lang[$row['navlig_langkey']] : $row['navlig_texte'] ;
				$retrait = ( !empty($row['navlig_tab']) and !empty($row['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $row['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($row['navlig_iconesize']) and $row['navlig_iconesize']!=0 ) ? ' width="' . $row['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($row['navlig_imgkey']) and !empty($images[$row['navlig_imgkey']])) ? $images[$row['navlig_imgkey']] : $row['navlig_iconeimg'] ;
				$icone = ( !empty($row['navlig_icone']) and !empty( $urlicone ))? '<img src="' . $urlicone . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;
				$template_mod->assign_block_vars('rubrique_row', array() );
				$template_mod->assign_block_vars('rubrique_row.entete_row', array(
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $row['navlig_cars'],
					"DESC" => $desc,
					"TEXTE" => 'Rubrique Entete')
				);
				break;
			case '2':
				//Séparation ligne
				if (!$inlien)
				{
					$template_mod->assign_block_vars('rubrique_row', array() );
					$template_mod->assign_block_vars('rubrique_row.debut_tr', array() );
					$inlien = true ;
				}
				$template_mod->assign_block_vars('rubrique_row', array() );
				$template_mod->assign_block_vars('rubrique_row.ligne_row', array(
					"TEXTE" => 'Rubrique Ligne')
				);
				$inlien = true ;
				break;
			case '3':
				//Séparation image
				if (!$inlien)
				{
					$template_mod->assign_block_vars('rubrique_row', array() );
					$template_mod->assign_block_vars('rubrique_row.debut_tr', array() );
					$inlien = true ;
				}
				$template_mod->assign_block_vars('rubrique_row', array() );
				$template_mod->assign_block_vars('rubrique_row.image_row', array(
					"URL" => $row['navlig_url'],
					"TEXTE" => 'Rubrique Image')
				);
				$inlien = true ;
				break;
			case '4':
				//Séparation Liens
				if (!$inlien)
				{
					$template_mod->assign_block_vars('rubrique_row', array() );
					$template_mod->assign_block_vars('rubrique_row.debut_tr', array() );
					$inlien = true ;
				}
				$desc = ( !empty($row['navlig_langkey']) and !empty($lang[$row['navlig_langkey']])) ? $lang[$row['navlig_langkey']] : $row['navlig_texte'] ;
				$retrait = ( !empty($row['navlig_tab']) and !empty($row['navlig_tab']))? '<img src="images/trans.gif" height="1" width="' . $row['navlig_tabsize'] . '"/>' : "" ;
				$sizeicone = ( !empty($row['navlig_iconesize']) and $row['navlig_iconesize']!=0 ) ? ' width="' . $row['navlig_iconesize'] . '"' : "" ;
				$urlicone = ( !empty($row['navlig_imgkey']) and !empty($images[$row['navlig_imgkey']])) ? $images[$row['navlig_imgkey']] : $row['navlig_iconeimg'] ;
				$icone = ( !empty($row['navlig_icone']) and !empty( $urlicone ))? '<img src="' . $urlicone . '" ' . $sizeicone . ' align="absmiddle" />' : "" ;

				if ($row['navlig_add_sid'])
				{
					$url = $row['navlig_url'] . (  (strpos($row['navlig_url'], '?')) !== false  ?  '&amp;' : '?' ) . 'sid=' . $userdata['session_id'];
				}
				else
				{
					$url=append_sid($row['navlig_url']);
				}
                $template_mod->assign_block_vars('rubrique_row.lien_row', array(
                    "URL" => $url,
					"SCRIPT" => $row['navlig_script'],
					"IMG" => $icone,
					"TAB" => $retrait,
					"CARS" => $row['navlig_cars'],
					"DESC" => $desc)
				);

			default:
				break;
		}
	  }
	}

	if ($inlien)
	{
		$template_mod->assign_block_vars('rubrique_row', array() );
		$template_mod->assign_block_vars('rubrique_row.fin_tr', array() );
		$inlien = true ;
	}

$modvar = $template_mod->pparse_mod('body');

?>

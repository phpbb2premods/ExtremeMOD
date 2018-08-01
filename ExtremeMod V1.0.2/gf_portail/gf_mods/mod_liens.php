<?php

/***************************************************************************
 *                                mod_liens.php
 *                            -------------------
 *   fait le                : Dimanche,20 Juillet, 2003
 *   Par : giefca - giefca@hotmail.com - http://www.gf-phpbb.fr.st
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

//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_liens.tpl')
);

//
// Links
//
	$sql = "SELECT * FROM " . LINKS_TABLE . " WHERE link_active = 1 " ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
	}

	if ( $row  = $db->sql_fetchrow($result) )
	{
		$template_mod->assign_block_vars('listlink', array() );
	}
	
	do
	{
		$imgwidth = ( $row['link_imgwidth'] != "" ) ? " width='" . $row['link_imgwidth'] ."' " : "" ;
		$imgheight = ( $row['link_imgheight'] != "" ) ? " height='" . $row['link_imgheight'] ."' " : "" ;
		$imgalt = ( $row['link_text'] != "" ) ? " alt='" . $row['link_text'] ."' " : "" ;
 		$urlimg =  ( $row['link_img'] != "" ) ? "<img src='" . $row['link_img'] . "' " . $imgwidth . $imgheight . $imgalt . " border='0' vspace='1' />"	: "" ;
		$template_mod->assign_block_vars('listlink.link', array(
			'URL' => ( $row['link_img'] != "" ) ? ( ( $row['link_url'] ) ? "<a href='" . $row['link_url'] . "' target=_blank >" . $urlimg . "</a>" : "" ) : ( ( $row['link_url'] ) ? "<a href='" . $row['link_url'] . "'  target=_blank ><span class='genmed'>" . $row['link_text'] . "</span></a>" : "" ))
		);
	} while ( $row = $db->sql_fetchrow($result) );
//
// END: Links
//
	
$modvar = $template_mod->pparse_mod('body');

?>
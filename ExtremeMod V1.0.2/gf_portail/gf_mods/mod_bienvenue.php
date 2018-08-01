<?php


/***************************************************************************
 *                                mod_bienvenue.php
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
   'body' => 'mod_bienvenue.tpl')
);

if ( $portal_config['simple_welcome'] )
{
	$welcome_text = $portal_config['welcome_text'] ;
}
else
{
 include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
 include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
$sql = "SELECT * FROM " . PORTAL_WELCOME_TABLE ;
	
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query board messages', '', __LINE__, __FILE__, $sql);
	}
	
	if ( $row = $db->sql_fetchrow($result) )
	{
		$html_on = $board_config['allow_html'];
		$bbcode_on = $board_config['allow_bbcode'];
		$smilies_on = $board_config['allow_smilies'];
	
		$welcome_text = $row['welcome_msg'];
		$bbcode_uid = $row['bbcode_uid'];

		if ( $row['bbcode_uid'] != '' )
		{
			$welcome_text = preg_replace('/\:(([a-z0-9]:)?)' . $row['bbcode_uid'] . '/s', '', $welcome_text);
		}

		$welcome_text = str_replace('<', '&lt;', $welcome_text);
		$welcome_text = str_replace('>', '&gt;', $welcome_text);
		$welcome_text = str_replace('<br />', "\n", $welcome_text);		
		$welcome_text = prepare_message( trim($welcome_text), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
		$welcome_text = nl2br( $welcome_text );
		$welcome_text = bbencode_second_pass( $welcome_text, $bbcode_uid ) ;
		$welcome_text = smilies_pass( $welcome_text );
		$welcome_text = make_clickable( $welcome_text );
	}
	else
	{
		return ;
	}
}

$template_mod->assign_vars( array(
	'WELCOME_TEXT' => $welcome_text,
	'L_NAME_WELCOME' => $lang['Welcome']));
	
$modvar = $template_mod->pparse_mod('body');

?>
<?php

/***************************************************************************
 *                                mod_sondage.php
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

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
 
//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_sondage.tpl')
);

	$sql = "SELECT t.*, vd.* FROM " . TOPICS_TABLE	 . " AS t, " . VOTE_DESC_TABLE  . " AS vd
			WHERE  t.topic_status <> 1 AND
			  t.topic_status <> 2 AND t.topic_vote = 1 AND t.topic_id = vd.topic_id
			AND vd.topic_id = '" . $portal_config['poll_id'] . "' " ;

	if ( !$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query poll information', '', __LINE__, __FILE__, $sql);
	}

	$poll = $db->sql_fetchrow( $result );

	if ($poll)
	{
		$sql = "SELECT * FROM " . VOTE_RESULTS_TABLE . " WHERE vote_id = '" . $poll['vote_id'] . 
		"' ORDER BY vote_option_id" ;

		if ( !$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query vote result information', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			$poll['options'][] = $row;
		}
	}

	$template_mod->assign_vars(array(
		'L_POLL' => $lang['Poll'],
		'L_VOTE_BUTTON' => $lang['Vote'])
		);

if (!empty($poll))
{
	$template_mod->assign_vars(array(		
		'S_POLL_QUESTION' => $poll['vote_text'],
		'S_POLL_ACTION' => append_sid('posting.'.$phpEx.'?'.POST_TOPIC_URL.'='.$poll['topic_id']),
		'S_TOPIC_ID' => $poll['topic_id'],
		'L_SUBMIT_VOTE' => $lang['Submit_vote'],
		'L_LOGIN_TO_VOTE' => $lang['Login_to_vote']		
		)
	);

	for ($i = 0; $i < count($poll['options']); $i++)
	{
		$template_mod->assign_block_vars('poll_option_row', array(
			'OPTION_ID' => $poll['options'][$i]['vote_option_id'],
			'OPTION_TEXT' => $poll['options'][$i]['vote_option_text'],
			'VOTE_RESULT' => $poll['options'][$i]['vote_result'],
			)
		);
	}	
}
else
{
	$template_mod->assign_vars(array(		
		'S_POLL_QUESTION' => $lang['No_poll'],
		'DISABLED' => 'disabled="disabled"'
		)
	);
}
	
$modvar = $template_mod->pparse_mod('body');

?>
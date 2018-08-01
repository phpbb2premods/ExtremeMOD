<?php

/***************************************************************************
 *                                mod_news.php
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

function getbblib($texte, &$pos, &$bblib )
{

	$len = strlen($texte) ;
	$bblib = "";
	$fin = false ;
	while ($pos<$len and !$fin)
	{
		$bblib .= $texte[$pos] ;
		$fin = ($texte[$pos++]==']');
	}
	$pos--;
	return ;
}

function format_trunc_post($tbchaine)
{
	$chaine_trunc = "" ;
	for ( $i=0; $i<sizeof($tbchaine) ; $i++)
	{
			$chaine_trunc .= $tbchaine[$i];
	}
	return $chaine_trunc ;
}

function trunc_post($texte,$long)
{
	$tbbcode = array();

// LISTE DES BBCODES A TRAITER
	$tbbcode[]='list';
	$tbbcode[]='color';
	$tbbcode[]='size';
	$tbbcode[]='quote';
	$tbbcode[]='code';
	$tbbcode[]='img';
	$tbbcode[]='url';
	$tbbcode[]='email';
	$tbbcode[]='b';
	$tbbcode[]='u';
	$tbbcode[]='i';
	$tbbcode[]='url';
	$tbbcode[]='align';
	$tbbcode[]='hide';
	
	$tbchaine = array();
	$nbchaine = 0 ;

	$lg = 0 ;
	
	for ($i=0 ; $i< sizeof($tbbcode) ; $i++)
	{
		$tnbb[$tbbcode[$i]]=0;
	}

	$chaine = "" ;
	$lentxt = strlen($texte);
	$bbouvert = 0;
	$nopoint = true ;
	for ($i=0 ; $i< $lentxt ; $i++)
	{
		if ( $texte[$i]=='[')
		{
		 //est-ce que ça pourrait être un bbcode ?
			 if ($i<$lentxt-1)
			 {
		 		if ( $texte[$i+1]=='/')
				//un bbcode fin ?
				{
					$j=$i+2;
					$boucle = true ;
					$bblib = "";
					while( ($j<$lentxt) and ($boucle) and strlen($bblib<10))
					{
						if (($texte[$j]=='=') or ($texte[$j]==':') or ($texte[$j]==']'))
						{
						 	$boucle = false;
						}
						else
						{
							$bblib .= $texte[$j++];
						}
					}
					if (in_array($bblib,$tbbcode))
					{			
						if ( $tnbb[$bblib]>0 )
						{						
						    $reste = $long - $lg ;
							if (strlen($chaine)>$reste)
							{
								if ($reste>0)
								{
									$chaine = substr($chaine,0,$reste) ;
									if ($nopoint)
									{ 
										$chaine.='...' ;
										$nopoint = false ;
									}
								}
								else $chaine = "";
							}
							$lg += strlen($chaine);

							$tbchaine[]=$chaine;

							if (($lg>=$long)and($bbouvert<=0))
							{
								return format_trunc_post($tbchaine);
							}

							$chaine = "" ;
							$pos = $i ;
							$tnbb[$bblib]--;
							$bbouvert--;
							$bblib = "" ;
							getbblib($texte, $pos, $bblib );

							$tbchaine[]=$bblib;	
							$i = $pos;
						}
						else
						{
							$chaine .= $texte[$i] ;		 
						}									
					}
					else
					{
						$chaine .= $texte[$i] ;		 
					}								
				}
				else
				//un bbcode début ?
				{
					$j=$i+1;
					$boucle = true;
					$bblib = "";
					while( ($j<$lentxt) and ($boucle) and strlen($bblib<10))
					{
						if (($texte[$j]=='=') or ($texte[$j]==':') or ($texte[$j]==']'))
						{
						 	$boucle = false;
						}
						else
						{
							$bblib .= $texte[$j++];
						}
					}
					if (in_array($bblib,$tbbcode))
					{
					    $reste = $long - $lg ;
						if (strlen($chaine)>$reste)
						{
							if ($reste>0)
							{
								$chaine = substr($chaine,0,$reste) ;
								if ($nopoint)
								{ 
									$chaine.='...' ;
									$nopoint = false ;
								}
							}
							else $chaine = "";
						}
						$lg += strlen($chaine);

						$tbchaine[]=$chaine;						
						if (($lg>=$long)and($bbouvert<=0))
						{
							return format_trunc_post($tbchaine);
						}

						$chaine = "" ;
						$pos = $i ;
						$tnbb[$bblib]++;
						$bbouvert++;
						$bblib = "" ;
						getbblib($texte, $pos, $bblib );

						$tbchaine[]=$bblib;
						$i = $pos ;
					}
					else
					{
						$chaine .= $texte[$i] ;		 
					}				
				}
			 }
			 else
			 {
				$chaine .= $texte[$i] ;		 
			 }
		}
		else
		{
			$chaine .= $texte[$i] ;
		}
	}

    $reste = $long - $lg ;
	if (strlen($chaine)>$reste)
	{
		if ($reste>0)
		{
			$chaine = substr($chaine,0,$reste) ;
			if ($nopoint)
			{ 
				$chaine.='...' ;
				$nopoint = false ;
			}
		}
		else $chaine = "";
	}
	$lg += strlen($chaine);

	$tbchaine[]=$chaine;
	return format_trunc_post($tbchaine);
}

//chargement du template
$template_mod->set_filenames(array(
   'body' => 'mod_news.tpl')
);


	$i = intval($HTTP_GET_VARS['article']);
$text_length = (!isset($HTTP_GET_VARS['article'])) ? $portal_config['news_length'] : 0 ;
$sql_article = ( isset($HTTP_GET_VARS['article'])) ? " AND t.topic_id = '" . intval($HTTP_GET_VARS['article']) . "' " : "" ;

$template_mod->assign_vars( array(
		'L_POSTED' => $lang['Posted'],
		'L_COMMENTS' => $lang['Comments'],
		'L_VIEW_COMMENTS' => $lang['View_comments'],
		'L_POST_COMMENT' => $lang['Post_your_comment'])
		);

$sql = "SELECT t.topic_id, t.topic_time, t.topic_title, pt.post_text, u.username, u.user_id,
		  t.topic_replies, pt.bbcode_uid, t.forum_id, t.topic_poster, t.topic_first_post_id,
		  t.topic_status, pt.post_id, p.post_id, p.enable_smilies FROM " . TOPICS_TABLE . 
		  " AS t, " . USERS_TABLE . " AS u, " . POSTS_TEXT_TABLE . " AS pt, " . POSTS_TABLE .
		  " AS p WHERE  t.forum_id = '" . $portal_config['news_forum'] . 
		  "' AND t.topic_poster = u.user_id $sql_article
		  AND t.topic_first_post_id = pt.post_id 
		  AND t.topic_first_post_id = p.post_id 
		  AND t.topic_vote <> 1
		  AND t.topic_status <> 2
		ORDER BY
		  t.topic_time DESC LIMIT 0," . $portal_config['number_of_news'] ;
//
// query the database
//
if(!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query news information', '', __LINE__, __FILE__, $sql);
}
//
// fetch all postings
//
$posts = array();
if ($row = $db->sql_fetchrow($result))
{
	$i = 0;
	//
	// define censored word matches
	//
	$orig_word = array();
	$replacement_word = array();
	obtain_word_list($orig_word, $replacement_word);
	do
	{
		$posts[$i]['bbcode_uid'] = $row['bbcode_uid'];
		$posts[$i]['enable_smilies'] = $row['enable_smilies'];
		$posts[$i]['post_text'] = $row['post_text'];
		$posts[$i]['topic_id'] = $row['topic_id'];
		$posts[$i]['topic_replies'] = $row['topic_replies'];
		$posts[$i]['topic_time'] = create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']);
		$posts[$i]['topic_title'] = $row['topic_title'];
		$posts[$i]['user_id'] = $row['user_id'];
		$posts[$i]['username'] = $row['username'];

		//
		// do a little magic
		// note: part of this comes from mds' news script and some additional magics from Smartor
		//
		stripslashes($posts[$i]['post_text']);
		$posts[$i]['post_text'] = nl2br($posts[$i]['post_text']);
		if (($text_length == 0) or (strlen($posts[$i]['post_text']) <= $text_length))
		{				
			$posts[$i]['post_text'] = bbencode_second_pass($posts[$i]['post_text'], $posts[$i]['bbcode_uid']);
			$posts[$i]['striped'] = 0;
		}
		else // strip text for news
		{
			$posts[$i]['post_text'] = trunc_post( $posts[$i]['post_text'], $text_length);
			$posts[$i]['post_text'] = bbencode_second_pass($posts[$i]['post_text'], $posts[$i]['bbcode_uid']);
			$posts[$i]['striped'] = 1;
		}
		//
		// Smilies
		//
		if ($posts[$i]['enable_smilies'] == 1)
		{
			$posts[$i]['post_text'] = smilies_pass($posts[$i]['post_text']);
		}
		$posts[$i]['post_text'] = make_clickable($posts[$i]['post_text']);

		//
		// censor text and title
		//
		if (count($orig_word))
		{
			$posts[$i]['topic_title'] = preg_replace($orig_word, $replacement_word, $posts[$i]['topic_title']);
			$posts[$i]['post_text'] = preg_replace($orig_word, $replacement_word, 	$posts[$i]['post_text']);
		}
		//$posts[$i]['post_text'] = nl2br($posts[$i]['post_text']);
		$i++;
	}
	while ($row = $db->sql_fetchrow($result));
}


if(!isset($HTTP_GET_VARS['article']))
{

	for ($i = 0; $i < count( $posts ) ; $i++)
	{
		if( $posts[$i]['striped'] == 1 )
		{
			$open_bracket = '[ ';
			$close_bracket = ' ]';
			$read_full = $lang['Read_Full'];
		}
		else
		{
			$open_bracket = '';
			$close_bracket = '';
			$read_full = '';
		}

		$template_mod->assign_block_vars('post_row', array(
			'TITLE' => $posts[$i]['topic_title'],
			'POSTER' => $posts[$i]['username'],
			'TIME' => $posts[$i]['topic_time'],
			'TEXT' => $posts[$i]['post_text'],
			'REPLIES' => $posts[$i]['topic_replies'],
			'U_VIEW_COMMENTS' => append_sid('viewtopic.' . $phpEx . '?t=' . $posts[$i]['topic_id'] ),
			'U_POST_COMMENT' => append_sid('posting.' . $phpEx . '?mode=reply&amp;t=' . $posts[$i]['topic_id'] ),
			'U_READ_FULL' => append_sid('portal.' . $phpEx . '?article=' . $posts[$i]['topic_id'] . '&amp;pid=' . $page_id ),
			'L_READ_FULL' => $read_full,
			'OPEN' => $open_bracket,
			'CLOSE' => $close_bracket)
		);
		if ( $i > 0 ) $template_mod->assign_block_vars('post_row.saut', array() );
	}
}
else
{
	$template_mod->assign_block_vars('post_row', array(
		'TITLE' => $posts[0]['topic_title'],
		'POSTER' => $posts[0]['username'],
		'TIME' => $posts[0]['topic_time'],
		'TEXT' => $posts[0]['post_text'],
		'REPLIES' => $posts[0]['topic_replies'],
		'U_VIEW_COMMENTS' => append_sid('viewtopic.' . $phpEx . '?t=' . $posts[0]['topic_id']),
		'U_POST_COMMENT' => append_sid('posting.' . $phpEx . '?mode=reply&amp;t=' . $posts[0]['topic_id'])
		)
	);
}
	
$modvar = $template_mod->pparse_mod('body');

?>
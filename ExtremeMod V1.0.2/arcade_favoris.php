<?php
/***************************************************************************
*                               arcadefavoris.php
*                              -------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
define('ARCADE', true);

$game_pad_pic[1] = '<img src="templates/' . $theme['template_name'] . '/images/souris.gif" alt="'.$lang['souris'].'" title="'.$lang['souris'].'">'; 
$game_pad_pic[2] = '<img src="templates/' . $theme['template_name'] . '/images/clavier.gif" alt="'.$lang['clavier'].'" title="'.$lang['clavier'].'">';
$game_pad_pic[3] = '<img src="templates/' . $theme['template_name'] . '/images/sourisclavier.gif" alt="'.$lang['sourisclavier'].'" title="'.$lang['sourisclavier'].'">';

//chargement du template
$template->set_filenames(array(
  'arcade_favoris' => 'arcade_favoris_body.tpl')
	);
		
if($arcade_config['use_fav_category'])
 {
	if ($arcade_config['use_hide_fav'] and $mode!='favoris')
	 {
		$limitf='LIMIT 0,' . $arcade_config['fav_nbr_in_page'];
	 }
			
		$sql = "SELECT COUNT(*) AS nbgames FROM " . ARCADE_FAV_TABLE ." WHERE user_id=".$userdata['user_id'];
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des favoris", '', __LINE__, __FILE__, $sql); 
		}
		if ( $row = $db->sql_fetchrow($result))
		{
			$nbjeux = $row['nbgames'];
		}
			
		$sql = "SELECT g.*, u.username, u.user_id, u.user_level, s.score_game, s.score_date, AVG(rating) AS average, f.* FROM "
		. GAMES_TABLE." g  LEFT JOIN " 
		. USERS_TABLE . " u ON g.game_highuser = u.user_id LEFT JOIN " 
    . ARCADE_VOTE_TABLE . " v ON g.game_id = v.game_id LEFT JOIN "
	  . SCORES_TABLE . " s on s.game_id = g.game_id and s.user_id = " . $userdata['user_id'] . " LEFT JOIN "
		. ARCADE_FAV_TABLE . " f on f.game_id = g.game_id 
		WHERE f.user_id=".$userdata['user_id'].' 
		GROUP BY g.game_id
		'.$limitf ;
		
		//-- mod : rank color system ---------------------------------------------------
		//-- add
		$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
		//-- fin mod : rank color system -----------------------------------------------
			
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des jeux favoris", '', __LINE__, __FILE__, $sql); 
		}
			
		if ($nbjeux)
		{
			$template->assign_block_vars('favrow',array()) ;
				
		while( $frow = $db->sql_fetchrow($result))
		{
    //$style_color = user_color($frow['username'], $frow['user_level']);
    $style_color = $rcs->get_colors($frow);
    
    
    if ( $frow['user_id'] == ANONYMOUS ){
    $user_fav = $frow['username'];
    } else {
  	$user_fav = '<a href="' . append_sid("statarcade.$phpEx?uid=" . $frow['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $frow['username'] . '" title="' . $lang['Read_profile'] .' '. $frow['username'] . '"' . $style_color .'>' . $frow['username'] . '</a>';
    }
    
    $game_ultimate_highscore = $frow['game_ultimate_highscore'];
    $game_ultimate_highdate = $frow['game_ultimate_highdate'];
    $game_ultimate_highuser = $frow['game_ultimate_highuser'];

    if($game_ultimate_highuser != 0)
    {
    $sql = "SELECT username, user_id, user_level FROM ". USERS_TABLE ." WHERE `user_id` = '".$game_ultimate_highuser."' LIMIT 0,1;";
    
    //-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------
    
    $result2 = $db->sql_query($sql);
    while($row2 = $db->sql_fetchrow($result2) ) {
    $style_color = $rcs->get_colors($row2);
    //$style_color = user_color($row2['username'], $row2['user_level']);
    if ( $row2['user_id'] == ANONYMOUS ) {
		$game_ultimate_username = $row2['username'];
    } else {
    $game_ultimate_username = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row2['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row2['username'] . '" title="' . $lang['Read_profile'] .' '. $row2['username'] . '"' . $style_color .'>' . $row2['username'] . '</a>'; }
    }
    } else {
    $game_ultimate_username = '';
    }

		$template->assign_block_vars('favrow.fav_row',array(
			'GAMENAMEF' => $frow['game_name'],
      'GAME_PAD_PIC' => $game_pad_pic[$frow['game_pad']],
	    'GAMENOTE' => round($frow['average'],1),
		  'GAMEPOPUP' => "<nobr><a href onClick=\"window.open('". append_sid("games.$phpEx?gid=" . $frow['game_id'] ) ."', 'Jouez', 'HEIGHT=".($frow['game_height']+250).", scrollbars=yes, scroll=yes, resizable=yes, WIDTH=".($frow['game_width']+10)."')\" alt='Cliquer ici pour ouvrir " . $frow['game_name'] . " dans une nouvelle fenêtre' title='Cliquer ici pour ouvrir " . $frow['game_name'] . " dans une nouvelle fenêtre'>Nouvelle Fenêtre</a></nobr>",
		  'DELFAVORI' => '<a href="' . append_sid("arcade.$phpEx?delfavori=" . $frow['game_id'] ) .'"><img src="' . append_sid("images/arcades/delfavs.gif").'" border=0 alt="'.$lang['del_fav'].'"></a>',
			'GAMELINKF' => '<nobr><a href="' . append_sid("games.$phpEx?gid=" . $frow['game_id'] ) . '">' . $frow['game_name'] . '</a></nobr> ',
			'GAMEPICF' => ( $frow['game_pic'] != '' ) ? "<a href='" . append_sid("games.$phpEx?gid=" . $frow['game_id'] ) . "'><img src='" . "games/pics/" . $frow['game_pic'] . "' align='absmiddle' border='0' width='49' height='49' vspace='2' hspace='2' alt='" . $frow['game_name'] . "' ></a>" : '' ,
			'GAMESETF' => ( $frow['game_set'] != 0  ) ? $lang['game_actual_nbset'] . $frow['game_set'] : '',
			'HIGHSCOREF' => $frow['game_highscore'],
			'YOURHIGHSCOREF' => $frow['score_game'],
			'NORECORDF' => ( $frow['game_highscore'] == 0 ) ? $lang['no_record'] : '',
			'HIGHUSERF' => ( $frow['game_highuser'] != 0 ) ? '' . $user_fav . '' : '' ,
			'URL_SCOREBOARDF' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=" . $frow['game_id'] ) . '">' . "<img src='templates/" . $theme['template_name'] . "/images/scoreboard.gif' align='absmiddle' border='0' alt='" . $lang['scoreboard'] . " " . $frow['game_name'] . "'>" . '</a></nobr> ',
			'GAMEIDF' => $frow['game_id'],
	 		'DATEHIGHF' => "<nobr>" . create_date( $board_config['default_dateformat'] , $frow['game_highdate'] , $board_config['board_timezone'] ) . "</nobr>",
			'YOURDATEHIGHF' => "<nobr>" . create_date( $board_config['default_dateformat'] , $frow['score_date'] , $board_config['board_timezone'] ) . "</nobr>",
			'IMGFIRSTF' => ( $frow['game_highuser'] == $userdata['user_id'] ) ? "&nbsp;&nbsp;<img src='templates/" . $theme['template_name'] . "/images/couronne.gif' align='absmiddle'>" : "" ,
      'NO_ULTIMATE_SCORE' => ( $game_ultimate_highscore == 0 ) ? $lang['no_record'] : '',
      'ULTIMATE_HIGHSCORE' => $game_ultimate_highscore,
      'ULTIMATEHIGHUSER' => ( $game_ultimate_highuser != 0 ) ? '' . $game_ultimate_username . '' : '' ,
      'ULTIMATEDATEHIGH' => "<nobr>" . create_date( $board_config['default_dateformat'] , $game_ultimate_highdate , $board_config['board_timezone'] ) . "</nobr>",
			'COUTF' => 
			($arcade_config['use_points_mod']==0 or $arcade_config['use_points_pay_mod']==0)?'':
			(($arcade_config['pay_all_games']==1 and $arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($arcade_config['points_pay']),$board_config['points_name']/2) :
			(($arcade_config['pay_all_games']==1)? sprintf($lang['game_cost'],$arcade_config['points_pay'],$board_config['points_name']):
			(($arcade_config['pay_all_games']==0 and $frow['point_pay']==0)?'':
			(($arcade_config['pay_all_games']==0 and $arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($frow['point_pay']),$board_config['points_name']) :
			(($arcade_config['pay_all_games']==0)? sprintf($lang['game_cost'],$frow['point_pay'],$board_config['points_name']):''))))),
			'COUTF' => 
			($arcade_config['use_points_mod']==0 or $arcade_config['use_points_pay_mod']==0)?'':
			(($arcade_config['pay_all_games']==1 and $arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($arcade_config['points_pay']),$board_config['points_name']) :
			(($arcade_config['pay_all_games']==1)? sprintf($lang['game_cost'],$arcade_config['points_pay'],$board_config['points_name']):
			(($arcade_config['pay_all_games']==0 and $frow['point_pay']==0)?'':
			(($arcade_config['pay_all_games']==0 and $arcade_config['use_points_pay_charging'] and $arcade_config['use_points_pay_submit']) ? sprintf($lang['game_cost'],($frow['point_pay']),$board_config['points_name']/2) :
			(($arcade_config['pay_all_games']==0)? sprintf($lang['game_cost'],$frow['point_pay'],$board_config['points_name']):''))))),
			'PRIZEF' => 
			($arcade_config['use_points_mod']==0 or $arcade_config['use_points_win_mod']==0)?'': 
			(($arcade_config['prize_all_games']==1)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']):
			(($arcade_config['prize_all_games']==2 and $frow['point_pay']>0)? sprintf($lang['game_prize'],$arcade_config['points_winner'],$board_config['points_name']):
			(($arcade_config['prize_all_games']==0 and $frow['point_prize']>0)? sprintf($lang['game_prize'],$frow['point_prize'],$board_config['points_name']):''))),
			'GAMEDESCF' => $frow['game_desc']
			));
				
			if ( $frow['game_highscore'] !=0 )
			{
				$template->assign_block_vars('favrow.fav_row.recordrow',array()) ;
			}	
			if ( $frow['score_game'] !=0 )
			{
				$template->assign_block_vars('favrow.fav_row.yourrecordrow',array()) ;
			}
      if ( $game_ultimate_highscore !=0 )
      {
        $template->assign_block_vars('favrow.fav_row.ultimaterecordrow',array()) ;
      }
		}
	}
			
	$template->assign_vars(array(
	  'URL_ARCADE' => '<nobr><a class="nav" href="' . append_sid("arcade.$phpEx") . '" alt="'.$lang['lib_arcade'].'" title="'.$lang['lib_arcade'].'">' . $lang['lib_arcade'] . '</a></nobr> ',
	  'URL_BESTSCORES' => '<nobr><a class="nav" href="' . append_sid("toparcade.$phpEx") . '" alt="'.$lang['best_scores'].'" title="'.$lang['best_scores'].'">' . $lang['best_scores'] . '</a></nobr> ',
	  'URL_SCOREBOARD' => '<nobr><a class="nav" href="' . append_sid("scoreboard.$phpEx?gid=$gid") . '" alt="'.$lang['scoreboard'].'" title="'.$lang['scoreboard'].'">' . $lang['scoreboard'] . '</a></nobr> ',
	  'URL_SEARCH_GAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['search_games_arcade'] . '</a></nobr> ',
    'SEARCHGAMES' => '<nobr><a class="nav" href="' . append_sid("searchgames.$phpEx") . '" alt="'.$lang['searchgames'].'" title="'.$lang['searchgames'].'">' . $lang['searchgames'] . '</a></nobr> ',
    'URL_JEU_AL' => '<nobr><a class="nav" href="' . append_sid("lien_ale_arcade.$phpEx") . '" alt="'.$lang['Arcade_game_alea'].'" title="'.$lang['Arcade_game_alea'].'">' . $lang['Arcade_game_alea'] . '</a></nobr> ',
	  'MANAGE_COMMENTS' => '<nobr><a class="nav" href="' . append_sid("comments_list.$phpEx") . '" alt="'.$lang['comments'].'" title="'.$lang['comments'].'">' . $lang['comments'] . '</a></nobr> ',	
		'FAV' => $lang['fav'],
	  'L_GAME' => $lang['games'],
		'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
	  'L_VOTES' => $lang['vote_game'],
	  'L_HIGHSCORE' => $lang['highscore'],
	  'L_YOURSCORE' => $lang['yourbestscore'],
    'L_ULTIMATE_HIGHSCORE' => $lang['Recordultime'],
	  'L_DESC' => $lang['desc_game'],
		'LINKCAT_ALIGN' => ( $arcade_config['linkcat_align'] == '0' ) ? 'left' : ( ( $arcade_config['linkcat_align'] == '1' ) ? 'center' : 'right'),
		'U_FAVORIS' => ($mode!='favoris' and $arcade_config['use_hide_fav'])? append_sid("arcade.$phpEx?mode=favoris"):'',
		'L_FAVORIS' => ($mode!='favoris' and $arcade_config['use_hide_fav'])? sprintf($lang['Other_fav'],$nbjeux):'')
		);
}

$template->assign_var_from_handle('ARCADE_FAVORIS', 'arcade_favoris');

?>
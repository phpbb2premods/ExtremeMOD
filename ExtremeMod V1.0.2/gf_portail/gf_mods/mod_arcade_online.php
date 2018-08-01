<?php

/***************************************************************************
 *                                mod_arcade_online.php
 *                            -------------------
 *   fait le                : Lundi 8 Mai, 2006
 *   Par : polo - zabauch@hotmail.com - http://supernova.ca.cx
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

// load template
 $template_mod->set_filenames(array(
 	 'body' => 'mod_arcade_online.tpl')
 );

 define("_TOPGAMERS", "Le Top Joueurs");
 define("_VICTOIRES", "Nombre de Victoires :");

 global $prefix, $user_prefix, $db, $ThemeSel;

/*****EDIT CONFIG SETTINGS*******/
/***** ON = 1  -  OFF = 0 *******/
//Top section of block
 $top = 1;

//Last 5 High Score section
 $last_five = 1;
//Limit of lastest highscores
 $highscore_limit = 10;

//Arcade stats sections
 $arcade_stats = 1;

//Who's playing what game section
 $whos_playing = 1;
/*****END CONFIG SETTINGS********/

		$sql = "SELECT game_id FROM " . GAMES_TABLE . "";
		$total_games = $db->sql_numrows($db->sql_query($sql));
		$recent_scores = ($total_games > $highscore_limit) ? $highscore_limit : $total_games;

    if ($top) {

		$sql = "SELECT arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . "";
    $total_cats = $db->sql_numrows($db->sql_query($sql));

    $content = "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='forumline'>";
		$content .= "<tr>";
		$content .= "<td class='rowpic' width='30%' align='center' height='20'><span class='gensmall'><b>Les Coupes</b></span></td>";
    $content .= "<td class='rowpic' width='40%' align='center' height='20'><span class='gensmall'><b>Jeu aléatoire</b></span></td>";
    $content .= "<td class='rowpic' width='30%' align='center' height='20 '><span class='gensmall'><b>Derniers Jeux</b></span></td>";
		$content .= "</tr>";
    $content .= "<tr>";
    $content .= "<td align='center' class='row1' width='30%'><marquee behavior= 'scroll' align= 'center' direction= 'up' scrollamount= '2' scrolldelay= '20' onmouseover='this.stop()' onmouseout='this.start()'><center>";

    $sql = "SELECT COUNT(*) AS nbvictoires, g.game_highuser, u.user_id, u.username FROM " . GAMES_TABLE . " g, " . USERS_TABLE . " u WHERE g.game_highuser = u.user_id AND g.game_highuser <> 0 GROUP BY g.game_highuser ORDER BY nbvictoires DESC";
    $result = $db->sql_query($sql);
		
    $place = 0;
		$nbvictprec = 0;

		while ($row = $db->sql_fetchrow($result)) {
		if ($nbvictprec <> $row['nbvictoires']) {
		$nbvictprec = $row['nbvictoires'];
		}

		$place++;

    $lastUser = $row['username'];
    $row['username'] = '<b>' . $row['username'] . '</b>';

		$content .= "<span class='gensmall'><b>$place - </b>";
		$content .= "<a href='statarcade.php?uid=".$row['user_id']."'><img src='templates/loupe.gif' border= '0' alt='Voir les stats arcade de $lastUser' title='Voir les stats arcade de $lastUser'></a> ";
		$content .= "<img src=\"images/ur-new.gif\"> <a href='profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$row['user_id']."' alt='Voir le profil de $lastUser' title='Voir le profil de $lastUser'>".$row['username']."</a> ";
		$content .= "<br> "._VICTOIRES." $nbvictprec <br>";

		$count = $count++;
		}

		$content .= "</span></center></marquee></td>";
		
		//Random Game
		$sql = "SELECT g.* , u.username FROM ". GAMES_TABLE ." g, ". USERS_TABLE ." u WHERE g.game_highuser = u.user_id ORDER BY rand() LIMIT 1";
    $row = $db->sql_fetchrow($db->sql_query($sql));
    $row['game_highscore'] = number_format($row['game_highscore']);
    $randomUser = '';
   if ($row['game_highscore']== 0){
    $randomUser = "<font color='#FF0000'><b>Personnes</b></font>";
    $game_pic = "<font color='#0000FF'><b>pas d'image</b></font><br>";
    }
     else
    {
    $randomUser = $row['username'];
    $game_pic = "<a href='games.php?games&gid=".$row['game_id']."'><img height='40' width='40' src='games/pics/".$row['game_pic']."' border= '0' alt='" .$row['game_name']. "' title='" .$row['game_name']. "'></a>";
    }
		$content .= "<td align='center' class='row2' width='40%'><a href='games.php?games&gid=".$row['game_id']."' alt='Cliquer ici pour jouer à " .$row['game_name']. "' title='Cliquer ici pour jouer à " .$row['game_name']. "'><b>".$row['game_name']."</b></a><br><br>$game_pic<br><span class='gensmall'><b>le Meilleur Score par</b>: <a href='statarcade.php?uid=".$row['game_highuser']."'><img src='templates/loupe.gif' border= '0' alt='Voir les stats arcade de " .$row['username']. "' title='Voir les stats arcade de " .$row['username']. "'></a><img src=\"images/ur-new.gif\"> <a href='profile.php?mode=viewprofile&amp;u=".$row['game_highuser']."' alt='Voir le profil de " .$row['username']. "' title='Voir le profil de " .$row['username']. "'>$randomUser</a> </b><br>avec <b>".$row['game_highscore']."</b> <br><br><b>Total des Jeux</b>: <b>$total_games</b><br>dans <b>$total_cats</b> catégories.</span></td>";
		$content .= "<td align='center' class='row1' width='30%'>";
		$content .= "<marquee behavior= 'scroll' align= 'center' direction= 'up' scrollamount= '2' scrolldelay= '20' onmouseover='this.stop()' onmouseout='this.start()'><center>";

		$sql = "SELECT game_name, game_id, game_pic FROM ". GAMES_TABLE ." ORDER BY game_order DESC LIMIT 0,$recent_scores";

		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result)) {
		$lastGame = $row['game_name'];
		$lastgameid = $row['game_id'];
		$lastgamepic = $row['game_pic'];
		$content .= "<span class='gensmall'><a href='games.php?games&gid=$lastgameid'><img height='40' width='40' src='games/pics/$lastgamepic' border= '0' alt='Cliquer ici pour jouer à " .$lastGame. "' title='Cliquer ici pour jouer à " .$lastGame. "'><br><b>$lastGame</b></span></a><br><br>";
		}

		$content .= "</center></marquee></td>";
		$content .= "</tr></table>";
}

    if ($last_five) {
    $content .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='forumline'>";
    $content .= "<tr>";
    $content .= "<td class='rowpic' colspan='5' align='center' height='20'><span class='gensmall'><b>Meilleurs Scores</b></span></td>";
    $content .= "</tr>";
    $content .= "<tr>";
    $content .= "<td class='row1' align='center'><span class='gensmall'><B>Joueur</B></span></td>";
    $content .= "<td class='row2' align='center'><span class='gensmall'><B>Score</B></span></td>";
    $content .= "<td class='row1' align='center'><span class='gensmall'><B>Jeu</B></span></td>";
    $content .= "<td class='row2' align='center'><span class='gensmall'><B>Date</B></span></td>";
    $content .= "</tr>";

		$place = 0;

		$sql = "SELECT g.* , u.username FROM ". GAMES_TABLE ." g, ". USERS_TABLE ." u WHERE g.game_highuser = u.user_id ORDER BY game_highdate DESC LIMIT 0,$recent_scores";
    $result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result)) {
		$lastUser = $row['username'];
		$row['game_highscore'] = number_format($row['game_highscore']);
		$lasthighdate = create_date($board_config['default_dateformat'], $row['game_highdate'] , $board_config['board_timezone']);

		$content .= "<tr>";
		$content .= "<td width='18%' align='left' class='row1'><span class='gensmall'><a href='statarcade.php?uid=".$row['game_highuser']."'><img src='templates/loupe.gif' border= '0' alt='Voir les stats arcade de" .$row['username']. "' title='Voir les stats arcade de " .$row['username']. "'></a><img src=\"images/ur-new.gif\"> <a href='profile.php?mode=viewprofile&amp;u=".$row['game_highuser']."' alt='Voir le profil de " .$row['username']. "' title='Voir le profil de " .$row['username']. "'>" . $lastUser . "</a> </b></span></td>";
		$content .= "<td width='18%' align='left' class='row2'><span class='gensmall'>&nbsp;&nbsp;&nbsp;<b>".$row['game_highscore']."</b></span></td>";
		$content .= "<td width='34%' align='left' class='row1'><span class='gensmall'><b>&nbsp;&nbsp;<a href='games.php?games&gid=".$row['game_id']."'><img height='20' width='20' src='games/pics/".$row['game_pic']."' border= '0' alt='" .$row['game_name']. "' title='" .$row['game_name']. "'></a>&nbsp;&nbsp;<a href='games.php?games&gid=".$row['game_id']."' alt='Cliquer ici pour jouer à " .$row['game_name']. "' title='Cliquer ici pour jouer à " .$row['game_name']. "'> - ".$row['game_name']."</b></a></span></td>";
		$content .= "<td width='30%' align='left' class='row2'><span class='gensmall'><b>$lasthighdate</b></span></td>";
		$content .= "</tr>";
		        }
		$content .= "</table>";
                   }

    if ($arcade_stats) {
    $content .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='forumline'>";
		$content .= "<tr>";
    $content .= "<td class='rowpic' width='100%' colspan='2' align='center' height='20'><span class='gensmall'><b>Arcade Stats</b></span></td>";
    $content .= "</tr>";

//Most Played Game
		$sql = "SELECT game_set, game_name, game_id FROM ". GAMES_TABLE ." ORDER BY game_set DESC LIMIT 1";
		$row = $db->sql_fetchrow($db->sql_query($sql));

		$content .= "<tr>";
    $content .= "<td width='50%' align='center' class='row1'><span class='gensmall'><b>Le plus Joué :</b></span> <span class='gensmall'><a href='games.php?games&gid=".$row['game_id']."' alt='Cliquer ici pour jouer à " .$row['game_name']. "' title='Cliquer ici pour jouer à " .$row['game_name']. "'><b>".$row['game_name']."</b> </a>avec <b>".$row['game_set']."</b> Parties.</span></td>";

//Least Played Game
		$sql = "SELECT game_set, game_name, game_id FROM ". GAMES_TABLE ." ORDER BY game_set ASC LIMIT 1";
    $row = $db->sql_fetchrow($db->sql_query($sql));

		$content .= "<td width='50%' align='center' class='row1'><span class='gensmall'><b>Le moins joué :</b></span> <span class='gensmall'><a href='games.php?games&gid=".$row['game_id']."' alt='Cliquer ici pour jouer à " .$row['game_name']. "' title='Cliquer ici pour jouer à " .$row['game_name']. "'> <b>".$row['game_name']."</b> </a>avec <b>".$row['game_set']."</b> Parties.</span></td>";
		$content .= "</tr>";
		
		//Category Stats
		$content .= "<tr>";
    $content .= "<td colspan='2' width='10%' height='20'  align='center' class='row2'><span class='gensmall'><marquee behavior= 'scroll' align= 'center' direction= 'left' width='100%' scrollamount= '2' scrolldelay= '20' onmouseover='this.stop()' onmouseout='this.start()'>";

		$sql = "SELECT arcade_cattitle, arcade_nbelmt, arcade_catid FROM ". ARCADE_CATEGORIES_TABLE ." ORDER BY arcade_cattitle";
    $result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result)) 
    {
    $content .="<a href='arcade.php?cid=".$row['arcade_catid']."' alt='Cliquer ici pour entrer dans la catégorie " .$row['arcade_cattitle']. "' title='Cliquer ici pour entrer dans la catégorie " .$row['arcade_cattitle']. "'>";
		$content .="<b>".$row['arcade_cattitle']." avec ".$row['arcade_nbelmt']." Jeux</B>";
		$content .="</a></span>&nbsp;&nbsp;-&nbsp;&nbsp;";
		}
    $content .= "</marquee></td>";
    $content .= "</tr>";
		$content .= "</table>";
}

    if ($whos_playing) {
    $content .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' class='forumline'>";
		$content .= "<tr>";
    $content .= "<td class='rowpic' width='100%' colspan='3' align='center' height='20'><span class='gensmall'><b>Qui Joue ?</b></span></td>";
    $content .= "</tr>";

		$sql = "SELECT u.username, u.user_id, user_allow_viewonline, g.game_name, g.game_id, g.game_pic FROM " . GAMEHASH_TABLE . " gh LEFT JOIN ". SESSIONS_TABLE ." s ON gh.user_id = s.session_user_id LEFT JOIN ". USERS_TABLE ." u ON gh.user_id = u.user_id LEFT JOIN ". GAMES_TABLE." g ON gh.game_id = g.game_id WHERE gh.hash_date >= s.session_time AND (" . time() . "- gh.hash_date <= 300) ORDER BY gh.hash_date DESC";

		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result)) {
		$players[] = $row;		
		}

		$nbplayers = count($players);
		$listeid = array();
		$games_players = array();
		$games_pics = array();
		$games_names = array();
		if ($nbplayers != 0) {
		$content .="<tr>";
    $content .="<td class='row1'><span class='gensmall'><B>Jeux</B></span></td>";
    $content .="<td class='row2'><span class='gensmall'><B>Joueurs</B></span></td>";

		for ($i=0 ; $i<$nbplayers ; $i++) {
		if (!isset($listeid[ $players[$i]['user_id'] ])) {
		$listeid[ $players[$i]['user_id'] ] = true ;
//  $players[$i]['username'] = $players[$i]['username'];

		if ($players[$i]['user_allow_viewonline']) 
    {
		$player_link = '<span class="gensmall"><a href=profile.php?mode=viewprofile&amp;u='.$players[$i]['user_id']. '>' . $players[$i]['username'] . '</a></span>';
    }
     else 
    {
    $player_link = '<span class="gensmall"><a href=profile.php?mode=viewprofile&amp;u='. $players[$i]['username'] . '</i></a></span>';
    }

		if ($players[$i]['user_allow_viewonline'] || $userdata['user_level'] == 2) {
		if(!isset($games_names[ $players[$i]['game_id'] ])) {
    $games_pics[ $players[$i]['game_id'] ] = "<a href='games.php?games&gid=".$players[$i]['game_id']."'><img height='20' width='20' src='games/pics/".$players[$i]['game_pic']."' border= '0' alt='" .$players[$i]['game_name']. "' title='" .$players[$i]['game_name']. "'></a>";
		$games_names[ $players[$i]['game_id'] ] = $players[$i]['game_name'] ;
		$games_players[ $players[$i]['game_id'] ] = $player_link ;
		}
		 else
		{
		$games_players[ $players[$i]['game_id'] ] .=  ', ' . $player_link ;
		}
	 }
	}
 }

		foreach($games_pics AS $key => $img) {
		if ($games_players[$key]!='') {
		$content .= "<tr>";
    $content .= "<td width='30%' class='row1'><span class='gensmall'>$img&nbsp;&nbsp;&nbsp;<a href='games.php?games&amp;gid=$key' alt='clique ici pour me rejoindre sur ce jeu : " . $games_names[$key] . "' title='clique ici pour me rejoindre sur ce jeu : " . $games_names[$key] . "'>$games_names[$key]</a></span></td>";
		$content .= "<td class='row2'><img src=\"images/ur-new.gif\">" .$games_players[$key]. "</td>";
    $content .= "</tr>";
		}
 }

		$content .= "</table>";
		}
		 else
		{
		$content .="<td colspan='2' align='center' class='row1'><span class='gensmall'>Il n'y a pas de partie en cours dans l'arcade !</span></td>";
		$content .= "</table>";
		}
 }

 $template_mod->assign_vars(array(
	  'CONTENT' => $content)
    );
  
 $modvar = $template_mod->pparse_mod('body');

?>

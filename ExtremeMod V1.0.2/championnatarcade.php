<?php
/***************************************************************************
*                               championnatarcade.php
*                              -----------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//chargement du template
$template->set_filenames(array(
  'championnatarcade' => 'championnatarcade_body.tpl')
  );

$template->assign_vars(array( 
	'CLASS' => $class,
	'CHAMPIONNAT_PLACE' => $place,
	'CHAMPIONNAT_USER' => $usr, 
	'CHAMPIONNAT_VICTORY' => $nb_victory) 
);

$cat_use = $arcade_config['cat_use'];
if($cat_use == 1)
{
	$sql = "SELECT c.* FROM " . GAMES_TABLE . " g LEFT JOIN " . ARCADE_CHAMPIONNAT_TABLE . " c ON g.game_id = c.game_id WHERE g.arcade_catid = '" . $arcade_config['championnat_cat'] . "'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat ou à la table des jeux", '', __LINE__, __FILE__, $sql); 
	}
}
else
{
	$sql = "SELECT * FROM " . ARCADE_CHAMPIONNAT_TABLE . "";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat", '', __LINE__, __FILE__, $sql); 
	}
}
$i = 0; 
$tabscore = array();
$tabtri = array();
$tabusers = array();

$nbpointsone = $arcade_config['championnat_points_one'];
$nbpointstwo = $arcade_config['championnat_points_two'];
$nbpointsthree = $arcade_config['championnat_points_three'];
$nbpointsfour = $arcade_config['championnat_points_four'];
$nbpointsfive = $arcade_config['championnat_points_five'];
$nbpointssix = $arcade_config['championnat_points_six'];
$nbpointsseven = $arcade_config['championnat_points_seven'];
$nbpointseight = $arcade_config['championnat_points_eight'];
$nbpointsnine = $arcade_config['championnat_points_nine'];
$nbpointsten = $arcade_config['championnat_points_ten'];
$nbpointseleven = $arcade_config['championnat_points_eleven'];
$nbpointstwelve = $arcade_config['championnat_points_twelve'];
$nbpointsthirteen = $arcade_config['championnat_points_thirteen'];
$nbpointsfourteen = $arcade_config['championnat_points_fourteen'];
$nbpointsfiveteen = $arcade_config['championnat_points_fiveteen'];
$nbpointssixteen = $arcade_config['championnat_points_sixteen'];
$nbpointsseventeen = $arcade_config['championnat_points_seventeen'];
$nbpointseighteen = $arcade_config['championnat_points_eighteen'];
$nbpointsnineteen = $arcade_config['championnat_points_nineteen'];
$nbpointstwenty = $arcade_config['championnat_points_twenty'];
$pos = 0;
while($row = $db->sql_fetchrow($result)) 
{ 

	if ($row['one_userid']>0)
	{
	  if (!isset($tabscore[$row['one_userid']]))
	  {
  	    $tabscore[$row['one_userid']] = $nbpointsone ;
  	    $tabtri[$row['one_userid']] = $row['one_userid'] ;
	  }
	  else
	  {
		$tabscore[$row['one_userid']] += $nbpointsone ;
	  }
	}

	if ($row['two_userid']>0)
	{
	  if (!isset($tabscore[$row['two_userid']]))
	  {
  	    $tabscore[$row['two_userid']] = $nbpointstwo ;
  	    $tabtri[$row['two_userid']] = $row['two_userid'];
	  }
	  else
	  {
  	    $tabscore[$row['two_userid']]+= $nbpointstwo ;
	  }
	}

	if ($row['three_userid']>0)
	{
	  if (!isset($tabscore[$row['three_userid']]))
	  {
	    $tabscore[$row['three_userid']] = $nbpointsthree ;
  	    $tabtri[$row['three_userid']] = $row['three_userid'] ;
	  }
	  else
	  {
	    $tabscore[$row['three_userid']] += $nbpointsthree ;
	  }
	}

	if ($row['four_userid']>0)
	{
	  if (!isset($tabscore[$row['four_userid']]))
	  {
	    $tabscore[$row['four_userid']] = $nbpointsfour ;
  	    $tabtri[$row['four_userid']] = $row['four_userid'] ;
	  }
	  else
	  {
	    $tabscore[$row['four_userid']] += $nbpointsfour ;
	  }
	}

	if ($row['five_userid']>0)
	{
	  if (!isset($tabscore[$row['five_userid']]))
	  {
	    $tabscore[$row['five_userid']] = $nbpointsfive ;
  	    $tabtri[$row['five_userid']] = $row['five_userid'] ;
	  }
	  else
	  {
	    $tabscore[$row['five_userid']] += $nbpointsfive ;
	  }
	}

	if ($row['six_userid']>0)
	{
		if (!isset($tabscore[$row['six_userid']]))
		{
		  $tabscore[$row['six_userid']] = $nbpointssix ;
			$tabtri[$row['six_userid']] = $row['six_userid'] ;
		}
		else
		{
			$tabscore[$row['six_userid']] += $nbpointssix ;
		}
	}

	if ($row['seven_userid']>0)
	{
		if (!isset($tabscore[$row['seven_userid']]))
		{
			$tabscore[$row['seven_userid']] = $nbpointsseven ;
			$tabtri[$row['seven_userid']] = $row['seven_userid'] ;
		}
	  else
		{
			$tabscore[$row['seven_userid']] += $nbpointsseven ;
		}
	}

	if ($row['eight_userid']>0)
	{
		if (!isset($tabscore[$row['eight_userid']]))
		{
			$tabscore[$row['eight_userid']] = $nbpointseight ;
			$tabtri[$row['eight_userid']] = $row['eight_userid'] ;
		}
		else
		{
			$tabscore[$row['eight_userid']] += $nbpointseight ;
		}
  }

	if ($row['nine_userid']>0)
	{
		if (!isset($tabscore[$row['nine_userid']]))
		{
			$tabscore[$row['nine_userid']] = $nbpointsnine ;
			$tabtri[$row['nine_userid']] = $row['nine_userid'] ;
		}
		else
		{
			$tabscore[$row['nine_userid']] += $nbpointsnine ;
		}
  }

	if ($row['ten_userid']>0)
		{
		if (!isset($tabscore[$row['ten_userid']]))
		{
			$tabscore[$row['ten_userid']] = $nbpointsten ;
			$tabtri[$row['ten_userid']] = $row['ten_userid'] ;
		}
		else
		{
			$tabscore[$row['ten_userid']] += $nbpointsten ;
		}
	}
	
				if ($row['eleven_userid']>0)
		{
		  if (!isset($tabscore[$row['eleven_userid']]))
		  {
			$tabscore[$row['eleven_userid']] = $nbpointseleven ;
			$tabtri[$row['eleven_userid']] = $row['eleven_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['eleven_userid']] += $nbpointseleven ;
		  }
		}
				if ($row['twelve_userid']>0)
		{
		  if (!isset($tabscore[$row['twelve_userid']]))
		  {
			$tabscore[$row['twelve_userid']] = $nbpointstwelve ;
			$tabtri[$row['twelve_userid']] = $row['twelve_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['twelve_userid']] += $nbpointstwelve ;
		  }
		}
				if ($row['thirteen_userid']>0)
		{
		  if (!isset($tabscore[$row['thirteen_userid']]))
		  {
			$tabscore[$row['thirteen_userid']] = $nbpointsthirteen ;
			$tabtri[$row['thirteen_userid']] = $row['thirteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['thirteen_userid']] += $nbpointsthirteen ;
		  }
		}
				if ($row['fourteen_userid']>0)
		{
		  if (!isset($tabscore[$row['fourteen_userid']]))
		  {
			$tabscore[$row['fourteen_userid']] = $nbpointsfourteen ;
			$tabtri[$row['fourteen_userid']] = $row['fourteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['fourteen_userid']] += $nbpointsfourteen ;
		  }
		}
				if ($row['fiveteen_userid']>0)
		{
		  if (!isset($tabscore[$row['fiveteen_userid']]))
		  {
			$tabscore[$row['fiveteen_userid']] = $nbpointsfiveteen ;
			$tabtri[$row['fiveteen_userid']] = $row['fiveteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['fiveteen_userid']] += $nbpointsfiveteen ;
		  }
		}
				if ($row['sixteen_userid']>0)
		{
		  if (!isset($tabscore[$row['sixteen_userid']]))
		  {
			$tabscore[$row['sixteen_userid']] = $nbpointssixteen ;
			$tabtri[$row['sixteen_userid']] = $row['sixteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['sixteen_userid']] += $nbpointssixteen ;
		  }
		}
				if ($row['seventeen_userid']>0)
		{
		  if (!isset($tabscore[$row['seventeen_userid']]))
		  {
			$tabscore[$row['seventeen_userid']] = $nbpointsseventeen ;
			$tabtri[$row['seventeen_userid']] = $row['seventeen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['seventeen_userid']] += $nbpointsseventeen ;
		  }
		}
				if ($row['eighteen_userid']>0)
		{
		  if (!isset($tabscore[$row['eighteen_userid']]))
		  {
			$tabscore[$row['eighteen_userid']] = $nbpointseighteen ;
			$tabtri[$row['eighteen_userid']] = $row['eighteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['eighteen_userid']] += $nbpointseighteen ;
		  }
		}
				if ($row['nineteen_userid']>0)
		{
		  if (!isset($tabscore[$row['nineteen_userid']]))
		  {
			$tabscore[$row['nineteen_userid']] = $nbpointsnineteen ;
			$tabtri[$row['nineteen_userid']] = $row['nineteen_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['nineteen_userid']] += $nbpointsnineteen ;
		  }
		}
				if ($row['twenty_userid']>0)
		{
		  if (!isset($tabscore[$row['twenty_userid']]))
		  {
			$tabscore[$row['twenty_userid']] = $nbpointstwenty ;
			$tabtri[$row['twenty_userid']] = $row['twenty_userid'] ;
		  }
		  else
		  {
			$tabscore[$row['twenty_userid']] += $nbpointstwenty ;
		  }
	 }
} 

$liste_userid = '';
foreach ( $tabtri as $key=>$val)
{
  $liste_userid = ( $liste_userid == '') ? $key : $liste_userid . ' ,' . $key;
}

if ($liste_userid!='')
{
	$sql = "SELECT user_id,username,user_level FROM " . USERS_TABLE . " WHERE user_id IN ($liste_userid)";
	
	//-- mod : rank color system ---------------------------------------------------
	//-- add
	$sql = str_replace('SELECT ', 'SELECT user_color, user_group_id, ', $sql);
	//-- fin mod : rank color system -----------------------------------------------
	
	
	
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'acceder à la table des utilisateurs", '', __LINE__, __FILE__, $sql);
	}
	
	while( $row = $db->sql_fetchrow($result))
	{

  //$style_color = user_color($row['username'], $row['user_level']);
  $style_color = $rcs->get_colors($row);  
  
  if ( $row['user_id'] == ANONYMOUS ){
  $tabusers[$row['user_id']] = $row['username'];
  } else {
  $tabusers[$row['user_id']] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '" alt ="' . $lang['Read_profile'] .' '. $row['username'] . '" title="' . $lang['Read_profile'] .' '. $row['username'] . '"' . $style_color .'>' . $row['username'] . '</a>';
  }
 }
}

// i=5 représente le nombre de joueurs représentés dans le classement du block 
array_multisort($tabscore, SORT_DESC, $tabtri);

for ($i = 0; $i < 10; $i++) 
{
	  $place = $i+1;
	  $usr = $tabusers[ $tabtri[$i] ];
	  $nb_victory = $tabscore[$i]; 
	  $class = ($class == 'row1') ? 'row2' : 'row1' ;

 $template->assign_block_vars( 'championnat_row', array( 
		'CLASS' => $class,
		'POINTS_NAME' => $board_config['points_name'],
		'TAUX' => ($place==1)?$arcade_config['championnat_taux_un']:
		(($place==2)?$arcade_config['championnat_taux_deux']:
		(($place==3)?$arcade_config['championnat_taux_trois']:
		(($place==4)?$arcade_config['championnat_taux_quatre']:
		(($place==5)?$arcade_config['championnat_taux_cinq']:
		(($place==6)?$arcade_config['championnat_taux_six']:
		(($place==7)?$arcade_config['championnat_taux_sept']:
		(($place==8)?$arcade_config['championnat_taux_huit']:
		(($place==9)?$arcade_config['championnat_taux_neuf']:
		(($place==10)?$arcade_config['championnat_taux_dix']:''))))))))),
		'PCAGNOTTE' => ($place==1)? intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_un']/100)).' '.$board_config['points_name']:
		(($place==2)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_deux']/100)).' '.$board_config['points_name']:
		(($place==3)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_trois']/100)).' '.$board_config['points_name']:
		(($place==4)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_quatre']/100)).' '.$board_config['points_name']:
		(($place==5)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_cinq']/100)).' '.$board_config['points_name']:
		(($place==6)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_six']/100)).' '.$board_config['points_name']:
		(($place==7)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_sept']/100)).' '.$board_config['points_name']:
		(($place==8)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_huit']/100)).' '.$board_config['points_name']:
		(($place==9)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_neuf']/100)).' '.$board_config['points_name']:
		(($place==10)?intval($arcade_config['cagnotte']*($arcade_config['championnat_taux_dix']/100)).' '.$board_config['points_name']:''))))))))),
		'CHAMPIONNAT_PLACE' => $place,
		'CHAMPIONNAT_USER' => $usr, 
		'CHAMPIONNAT_VICTORY' => $nb_victory
		)); 
	}

if ($arcade_config['cat_use'] == 1)
{
	$template->assign_block_vars( 'championnat_use', array());
	$sql = "SELECT arcade_catid, arcade_cattitle
		FROM " . ARCADE_CATEGORIES_TABLE . "
		WHERE arcade_catid = '" . $arcade_config['championnat_cat'] . "'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accèder à la table des catégories", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$template->assign_vars( array(
		'TPS_RESTANT' => ($arcade_config['use_auto_distrib']) ? sprintf($lang['tp_restant'],intval(($arcade_config['date_distribcagnotte']-time())/(24*60*60)),intval((($arcade_config['date_distribcagnotte']-time())/(24*60*60)-intval(($arcade_config['date_distribcagnotte']-time())/(24*60*60)))*24) ):'Temps illimité',
		'CAGNOTTE' => ($arcade_config['use_points_mod']) ? 'Cagnotte : <span class=nav>'. $arcade_config['cagnotte'] .'</span> '. $board_config['points_name']: 'indisponible',
		'CAT_TITLE'=> ($arcade_config['cat_use']==1)? "Catégorie: <a class=nav href=" . append_sid("arcade.$phpEx?cid=" . $row['arcade_catid'] ) . ">".$row['arcade_cattitle']."</a>": "<span class=nav>Toutes sections</span>"
		));
}
 elseif ($arcade_config['cat_use'] == 0)
{
	$template->assign_vars( array(
		'TPS_RESTANT' => ($arcade_config['use_auto_distrib']) ? sprintf($lang['tp_restant'],intval(($arcade_config['date_distribcagnotte']-time())/(24*60*60)),intval((($arcade_config['date_distribcagnotte']-time())/(24*60*60)-intval(($arcade_config['date_distribcagnotte']-time())/(24*60*60)))*24) ):'Temps illimité',
		'CAGNOTTE' => ($arcade_config['use_points_mod']) ? 'Cagnotte : <span class=nav>'. $arcade_config['cagnotte'] .'</span> '. $board_config['points_name']: 'indisponible',
		'CAT_TITLE'=> "<span class=nav>Toutes sections</span>"
		));
}
 else
{
	$template->assign_vars( array(
		'TPS_RESTANT'=> "<span class=nav>indisponible</span>",
		'CAGNOTTE'=> "<span class=nav>&nbsp;</span>",
		'CAT_TITLE'=> "<span class=nav>Championnat</span>"
		));
}

$template->assign_var_from_handle('CHAMPIONNATARCADE', 'championnatarcade');		

?>
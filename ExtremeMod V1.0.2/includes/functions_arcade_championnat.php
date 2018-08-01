<?php
/***************************************************************************
*                               functions_arcade_championnat.php
*                              ----------------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// Cette fonction remet à zéro le championnat des jeux d'Arcade
//
function arcade_championnat_reset()
{
	global $db,$arcade_config;
	if ($arcade_config['use_cagnotte_mod'])
	{
		distrib_cagnotte();
	}
	$sql = "TRUNCATE TABLE " . ARCADE_CHAMPIONNAT_TABLE . "";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la table du championnat", "", __LINE__, __FILE__, $sql);
	}
}

//
// Cette fonction permet de distribuer la cagnotte aux dix premiers du championnat.
//
function distrib_cagnotte()
{
	global $db,$arcade_config;
	$cagnotte_win = $arcade_config['cagnotte'];
	if($arcade_config['cat_use'] == 1)
	{
		$sql = "SELECT c.* FROM " . GAMES_TABLE . " g LEFT JOIN " . ARCADE_CHAMPIONNAT_TABLE . " c ON g.game_id = c.game_id WHERE g.arcade_catid = '" . $arcade_config['championnat_cat'] . "'";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat ou à la table des jeux", '', __LINE__, __FILE__, $sql); 
		}
	}	else {
		$sql = "SELECT * FROM " . ARCADE_CHAMPIONNAT_TABLE . "";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'acceder à la table du championnat", '', __LINE__, __FILE__, $sql); 
		}
	}

$tabtri = array();
$tabusers = array();
$tabscore = array();
$i = 0; 

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
	} 
	$liste_userid = '';
	foreach ( $tabtri as $key => $val)
	{
	  $liste_userid = ( $liste_userid == '') ? $key : $liste_userid . ' ,' . $key;
	}
	if ($liste_userid!='')
	{
		$sql = "SELECT user_id,username FROM " . USERS_TABLE . " WHERE user_id IN ($liste_userid)";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'acceder à la table des utilisateurs", '', __LINE__, __FILE__, $sql);
		}
		while( $row = $db->sql_fetchrow($result))
		{
			$tabusers[$row['user_id']] = $row['username'];
		}
	}
	array_multisort($tabscore, SORT_DESC, $tabtri);
	$cagnotte_un = $tabusers[ $tabtri[0] ];
	$cagnotte_deux = $tabusers[ $tabtri[1] ];
	$cagnotte_trois = $tabusers[ $tabtri[2] ];
	$cagnotte_quatre = $tabusers[ $tabtri[3] ];
	$cagnotte_cinq = $tabusers[ $tabtri[4] ];
	$cagnotte_six = $tabusers[ $tabtri[5] ];
	$cagnotte_sept = $tabusers[ $tabtri[6] ];
	$cagnotte_huit = $tabusers[ $tabtri[7] ];
	$cagnotte_neuf = $tabusers[ $tabtri[8] ];
	$cagnotte_dix = $tabusers[ $tabtri[9] ];
	$tauxun = $arcade_config['championnat_taux_un'];
	$tauxdeux = $arcade_config['championnat_taux_deux'];
	$tauxtrois = $arcade_config['championnat_taux_trois'];
	$tauxquatre = $arcade_config['championnat_taux_quatre'];
	$tauxcinq = $arcade_config['championnat_taux_cinq'];
	$tauxsix = $arcade_config['championnat_taux_six'];
	$tauxsept = $arcade_config['championnat_taux_sept'];
	$tauxhuit = $arcade_config['championnat_taux_huit'];
	$tauxneuf = $arcade_config['championnat_taux_neuf'];
	$tauxdix = $arcade_config['championnat_taux_dix'];
	$nbpoints1 = $cagnotte_win * ($tauxun / 100);
	$nbpoints2 = $cagnotte_win * ($tauxdeux / 100);
	$nbpoints3 = $cagnotte_win * ($tauxtrois / 100);
	$nbpoints4 = $cagnotte_win * ($tauxquatre / 100);
	$nbpoints5 = $cagnotte_win * ($tauxcinq / 100);
	$nbpoints6 = $cagnotte_win * ($tauxsix / 100);
	$nbpoints7 = $cagnotte_win * ($tauxsept / 100);
	$nbpoints8 = $cagnotte_win * ($tauxhuit / 100);
	$nbpoints9 = $cagnotte_win * ($tauxneuf / 100);
	$nbpoints10 = $cagnotte_win * ($tauxdix / 100);
	if( isset($tabusers[ $tabtri[0] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints1' WHERE username = '$cagnotte_un' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[1] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints2' WHERE username = '$cagnotte_deux' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[2] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints3' WHERE username = '$cagnotte_trois' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[3] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints4' WHERE username = '$cagnotte_quatre' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[4] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints5' WHERE username = '$cagnotte_cinq' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[5] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints6' WHERE username = '$cagnotte_six' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[6] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints7' WHERE username = '$cagnotte_sept' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[7] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints8' WHERE username = '$cagnotte_huit' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[8] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints9' WHERE username = '$cagnotte_neuf' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	if( isset($tabusers[ $tabtri[9] ]))
	{
		$sql = "UPDATE " . USERS_TABLE . " SET user_points = user_points + '$nbpoints10' WHERE username = '$cagnotte_dix' ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des utilisateurs", "", __LINE__, __FILE__, $sql);
		}
	}
	$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '0' WHERE arcade_name = 'cagnotte'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la table de configuration arcade", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '' WHERE arcade_name = 'day_distrib'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la table de configuration arcade", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '' WHERE arcade_name = 'date_distribcagnotte'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la table de configuration arcade", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '0' WHERE arcade_name = 'use_auto_distrib'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accéder à la table de configuration arcade", "", __LINE__, __FILE__, $sql);
	}
}

//
// Cette fonction retourne la liste des catégories de jeux et met à jour la catégorie du championnat.
//
function championnat_cat_select($championnat_cat, $select_name = "cat")
{
	global $db;

	$sql = "SELECT arcade_catid, arcade_cattitle
		FROM " . ARCADE_CATEGORIES_TABLE . "
		ORDER BY arcade_cattitle";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'accèder à la table des catégories", "", __LINE__, __FILE__, $sql);
	}

	$championnat_cat_select = '<select name="' . $select_name . '">';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['arcade_catid'] == $championnat_cat ) ? ' selected="selected"' : '';

		$championnat_cat_select .= '<option value="' . $row['arcade_catid'] . '"' . $selected . '>' . $row['arcade_cattitle'] . '</option>';
	}
	$championnat_cat_select .= "</select>";

	return $championnat_cat_select;
}

//
// Cette fonction supprime et recrée la table des commentaires Arcade
//
function recreate_comments()
{
	global $db,$arcade_config;

$sql = "TRUNCATE TABLE " . COMMENTS_TABLE . "";
if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Impossible de creer la table comments", "", __LINE__, __FILE__, $sql);
}

$sql = "SELECT game_id FROM " . GAMES_TABLE . " ORDER BY game_id "; 
$result = $db->sql_query($sql); 
while ($row = $db->sql_fetchrow($result)) 
 {
	$game_id = $row['game_id'];
	$message = '';
	$db->sql_query("INSERT INTO " . COMMENTS_TABLE . " ( game_id, message) VALUES ('$game_id','" . str_replace("\'", "''", $message) . "')");	
 }
}

?>
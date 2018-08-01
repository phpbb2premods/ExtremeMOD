<?php
/***************************************************************************
*                               arcade_vote.php
*                              -----------------
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
   'arcade_vote' => 'arcade_vote_body.tpl')
   );

$template->assign_vars(array(
	"L_ARCADE_VOTE" => $lang['Arcade_vote'])
  );
$phpbb_root_path = './';
include($phpbb_root_path . 'includes/functions_arcade_vote.'.$phpEx);	

$ratingtest = rating_inserted($userdata['user_id'], $gid);
$max = $arcade_config['rating_max'];
if ($ratingtest)
{
	$your_rating = rating_value($userdata['user_id'], $gid);
	$row=array();
	$row= rate_stats($gid);
	$minimum = $row['minimum'];
	$maximum = $row['maximum'];
	$number_of_rates = $row['number_of_rates'];
	$rating2 = ratings_view_game($gid);
	$rating = round($rating2,1); 
	
	$template->assign_block_vars('already_rated', array(
	"L_ARCADE_VOTE_ALREADY" => $lang['Arcade_vote_already'],
	"L_ARCADE_VOTE_YOUR_RATING_EXPLAIN" => $lang['Arcade_vote_your_rating_explain'],
	"L_ARCADE_VOTE_RATE_STATS_EXPLAIN" => $lang['Arcade_vote_rate_stats_explain'],
	"L_ARCADE_VOTE_YOUR_RATING" => $your_rating,
	"L_ARCADE_VOTE_RATE_STATS" => sprintf($lang['Arcade_vote_rate_stats'], $minimum, $maximum, $number_of_rates),
	"L_ARCADE_VOTE_RATE" => $lang['Arcade_vote_rate'],
	"S_ARCADE_VOTE_MAX" => $max,
	"S_ARCADE_VOTE_RATE_B" => ($rating*100)/$max,
	"S_ARCADE_VOTE_RATE" => $rating )
	);
}
else
{
	$select_arcade_vote_choices = "<select name=\"rating\">";
	for ($i=1; $i <= $arcade_config['rating_max']; $i++)
	{
		$select_arcade_vote_choices .= "<option value=\"" . $i . "\"$selected>" . $i . "</option>";
	}
	$select_arcade_vote_choices .= "</select>";
	$row=array();
	$row= rate_stats($gid);
	$minimum = $row['minimum'];
	$maximum = $row['maximum'];
	$number_of_rates = $row['number_of_rates'];
	$rating2 = ratings_view_game($gid);
	$rating = round($rating2,1); 
	
	$template->assign_block_vars('non_rated', array(
	"L_ARCADE_VOTE" => $lang['Arcade_vote'],
	"L_ARCADE_VOTE2" => $lang['Arcade_vote2'],
	"L_ARCADE_VOTE_RATE_STATS_EXPLAIN" => $lang['Arcade_vote_rate_stats_explain'],
	"S_ARCADE_VOTE_SELECT" => $select_arcade_vote_choices,
	"S_HIDDEN_FIELDS" => '<input type="hidden" name="game_id" value="'. $gid . '" />',
	"S_RATE_ACTION" => append_sid("arcade_vote_submit.$phpEx"),
	"L_ARCADE_VOTE_RATE_STATS" => sprintf($lang['Arcade_vote_rate_stats'], $minimum, $maximum, $number_of_rates),
	"L_ARCADE_VOTE_RATE" => $lang['Arcade_vote_rate'],
	"S_ARCADE_VOTE_MAX" => $max,
	"S_ARCADE_VOTE_RATE_B" => ($rating*100)/$max,
	"S_ARCADE_VOTE_RATE" => $rating==0? $lang['Arcade_vote_norate'] : $rating )
	);
}

$template->assign_var_from_handle('ARCADE_VOTE', 'arcade_vote');		

?>
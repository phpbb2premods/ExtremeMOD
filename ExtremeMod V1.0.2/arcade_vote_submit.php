<?php
/***************************************************************************
*                               arcade_vote_submit.php
*                              ------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

define('IN_PHPBB', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_arcade_vote.'.$phpEx);
include($phpbb_root_path . 'includes/functions_arcade.'.$phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);

$arcade_config = array();
$arcade_config = read_arcade_config();

$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);

$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";

if (( !$userdata['session_logged_in'] ) && ( !$arcade_config['auths_vote'] ))
{
	header($header_location . append_sid("login.$phpEx?redirect=games.$phpEx", true));
	exit;
}
//
// End of auth check
//

$game_id = get_var2(array('name'=>'game_id', 'default'=>''));
$rating = get_var2(array('name'=>'rating', 'default'=>''));
$user_id = $userdata['user_id'];
rate_game($user_id, $game_id, $rating);

?>
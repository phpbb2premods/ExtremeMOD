<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_tail.php,v 1.27.2.4 2005/09/14 18:14:30 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

if ( $board_config['groups_salary_cron_enable'] && ( ( time() - $board_config['groups_salary_cron_last_time'] ) > $board_config['groups_salary_cron_time'] ))
{
	include_once($php_root_path . 'includes/functions_groups_salary_cron.'.$phpEx);
}

global $do_gzip_compress;

include_once( $phpbb_root_path . 'includes/functions_arcade_championnat.' . $phpEx);
if ($arcade_config['use_auto_distrib'])
{
	if ($arcade_config['date_distribcagnotte'] == 0)
	{
		$date_day = time();
// Si la première date n'est pas définie (c'est le cas après l'installation), on met la date actuelle par défaut.
	 	$days = $arcade_config['day_distrib'];
		$date_day = $date_day + ($days*24*60*60);
// On met à jour la date de prochaine distribution de la cagnotte afin d'éviter qu'elle soit distribuée tout de suite.
		$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '$date_day' WHERE arcade_name = 'date_distribcagnotte'"; 
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible de modifier la date de distribution de la cagnotte à la date du jour.", "", __LINE__, __FILE__, $sql);
		}
	}
	else if (time() >= $arcade_config['date_distribcagnotte']) 
	{ 
		distrib_cagnotte(); 
		//cacul de la prochaine date de distribution (+X jours)
	 	$days = $arcade_config['day_distrib'];
		$next_distrib = $arcade_config['date_distribcagnotte'] + ($days*24*60*60); 
		$sql = "UPDATE " . ARCADE_TABLE . " SET arcade_value = '$next_distrib' WHERE arcade_name = 'date_distribcagnotte'"; 
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible de modifier la date de prochaine distribution.", "", __LINE__, __FILE__, $sql);
		}
	}
}

//
// Show the overall footer.
//
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);

$template->assign_vars(array(
	'TRANSLATION_INFO' => (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''),
	'EXTREMEMOD' =>  $board_config['version1'],
	'ADMIN_LINK' => $admin_link)
);

//-- mod : board generation time info ------------------------------------------
//-- delete
/*-MOD
$template->pparse('overall_footer');
MOD-*/
//-- fin mod : board generation time info --------------------------------------

//
// Close our DB connection.
//
$db->sql_close();

//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

//-- mod : board generation time info ------------------------------------------
//-- add
$endtime = microtime();
$endtime = explode(' ', microtime());
$endtime = $endtime[1] + $endtime[0];
$gentime = round(($endtime - $starttime), 5);

$gzip_status = ($board_config['gzip_compress']) ? $lang['Gzip_on'] : '';
$debug_status = (DEBUG) ? $lang['Debug_on'] : $lang['Debug_off'];
$queries_display = sprintf($lang['Queries'], $db->num_queries);
$generation_time = sprintf($lang['Generation_time'], $gentime);

$template->assign_vars(array(
	'STATISTICS' => '[ ' . $generation_time . ' ][ ' . $queries_display . ' ][ ' . $gzip_status . $debug_status . ' ]')
);
$template->pparse('overall_footer');
//-- fin mod : board generation time info --------------------------------------


exit;

?>
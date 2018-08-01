<?php

if ( $HTTP_SERVER_VARS['REQUEST_URI'] == $board_config['script_path'] )
{
   $header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
   header($header_location . append_sid("portal.$phpEx", true));
   exit;
}

/*
 * Fichiers nécessaires à Gf Portail
 */
include($phpbb_root_path . 'gf_portail/gf_includes/gf_constants.'.$phpEx);
include($phpbb_root_path . 'gf_portail/gf_includes/gf_functions.'.$phpEx);
include($phpbb_root_path . 'gf_portail/gf_includes/gf_template.'.$phpEx);

language_include('main');

if (defined('IN_ADMIN'))
{
	language_include('admin');
}
?>
<?php
/***************************************************************************
 *                                portal.php
 *                            -------------------
 *   fait le                : Samedi,19 Juillet, 2003
 *   Par : giefca -  < giefca@hotmail.com > - http://www.gf-phpbb.info
 *   Mise à jour Gf-Portail 1.2.1 du : 26 Avril 2006
 *	 Par : Pim - < pim@gf-phpbb.info > - http://www.gf-phpbb.info
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Portail version Gf-Portail.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpbb_mod_path = './gf_portail/gf_mods/';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

function url_append($url)
{
  $pos = strpos('?',$url)+1 ;
  return substr($url,0,$pos) . str_replace('?' , '&' , substr($url,$pos, strlen($url)-$pos));
}  
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PORTAL);
init_userprefs($userdata);
//
// End session management
//
language_include('main');

// Read Portal Configuration from DB
$portal_config = array();
$sql = 'SELECT portal_name, portal_value FROM ' . PORTAL_TABLE;

if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, 'Could not query portal config information', '', __LINE__, __FILE__, $sql);
}

if( !$board_config['activeportail'] ) 
{ 
   redirect(append_sid("./index.$phpEx")); 
}

while ( $row = $db->sql_fetchrow($result) )
{
	$portal_config[ $row['portal_name'] ] = $row['portal_value'];
}

// si ces 2 variables n'ont pas été redéfinies dans le fichier .cfg du template, on leur donne
// des valeurs par défaut.
if ( !isset( $board_config['portal_class_balise']))
	{ $board_config['portal_class_balise'] = 'th'; }
if ( !isset( $board_config['portal_class_title']))
	{ $board_config['portal_class_title'] = 'catTop'; }


//
// Start output of page
//

define('SHOW_ONLINE', true);
if (!empty($HTTP_POST_VARS['pid']) || !empty($HTTP_GET_VARS['pid']))
{
	$page_id = (!empty($HTTP_POST_VARS['pid'])) ? intval($HTTP_POST_VARS['pid']) : intval($HTTP_GET_VARS['pid']);
}
else
{
	$page_id = $portal_config['default_struct'] ;
}

$sql_mod = 'SELECT * FROM ' . PORTAL_PAGE . ' WHERE page_id = ' .$page_id;
if( !($result_mod = $db->sql_query($sql_mod)) )
{
	message_die(CRITICAL_ERROR, 'Could not query portal page information', '', __LINE__, __FILE__, $sql_mod);
}
if ( !$row_mod = $db->sql_fetchrow($result_mod)  )
{
	message_die(GENERAL_MESSAGE , 'La page demandée ( pid = ' . $page_id . ') est introuvable.');
}
if ($row_mod['display_header'] != -1)
	{ $portal_config['forum_header'] = ( $row_mod['display_header'] ); }

if ( !$portal_config['forum_header'] )
	{ $gen_simple_header = true; }

if ( $gen_simple_header && $portal_config['bodyline'] )
	{ $template->assign_block_vars('simple_header', array()); }

if ( $gen_simple_header )
	{ $template->assign_block_vars('simple_footer', array()); }

if ($portal_config['head_out_bodyline'])
	{ $hbodylline = 'out_'; }

if ($portal_config['foot_out_bodyline'])
	{ $fbodylline = 'out_'; }

if ($userdata['user_level'] == ADMIN)
	{ $admin_link = '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />'; }

if ( $row_mod['page_defaultsize'] )
{
	$c1size = ( $portal_config['col1_unit'] == 'pixel') ? $portal_config['col1_size'] :  $portal_config['col1_size'] . '%' ;
	$c2size = ( $portal_config['col2_unit'] == 'pixel') ? $portal_config['col2_size'] :  $portal_config['col2_size'] . '%' ;
	$c3size = ( $portal_config['col3_unit'] == 'pixel') ? $portal_config['col3_size'] :  $portal_config['col3_size'] . '%' ;
}
else
{
	$c1size = ( $row_mod['page_col1unit'] == 'pixel') ? $row_mod['page_col1width'] :  $row_mod['page_col1width'] . '%' ;
	$c2size = ( $row_mod['page_col2unit'] == 'pixel') ? $row_mod['page_col2width'] :  $row_mod['page_col2width'] . '%' ;
	$c3size = ( $row_mod['page_col3unit'] == 'pixel') ? $row_mod['page_col3width'] :  $row_mod['page_col3width'] . '%' ;
}

$page_title = $row_mod['page_desc'];

include($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->set_filenames(array(
   'body' => 'portal_body.tpl')
);

$template->assign_vars(array(
	'C1SIZE' => $c1size,
	'C2SIZE' => $c2size,
	'C3SIZE' => $c3size,
	'ADMIN_LINK' => $admin_link,
	'GF_LICENCE' => $lang['Gf_Licence'],
	'SPACE_ROW' => $portal_config['space_row'],
	'SPACE_COL' => $portal_config['space_col'])
	);

$sql_mod = 'SELECT * 
			FROM ' . PORTAL_STRUCT . '  s
			LEFT JOIN ' . PORTAL_MOD . ' m
				ON (m.mod_id = s.mod_id)
			WHERE s.page_id = ' . $page_id . '
			ORDER BY s.struct_col ASC, s.struct_order ASC;';

if( !($result_mod = $db->sql_query($sql_mod)) )
{
	message_die(CRITICAL_ERROR, 'Could not query config portal information', '', __LINE__, __FILE__, $sql_mod);
}

//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = 'login.'.$phpEx;
	$l_login_logout = $lang['Login'];
}

$s_last_visit = ( $userdata['session_logged_in'] ) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
if (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0)
{
	$l_timezone = $lang[sprintf('%.1f', $board_config['board_timezone'])];
}
else
{
	$l_timezone = $lang[number_format($board_config['board_timezone'])];
}

$nbmod = 0 ;

if ($userdata['user_level'] == USER || !$userdata['session_logged_in'])
{
	$is_admin = 0;
	$is_mod = 0;
}
elseif ($userdata['user_level'] == ADMIN)
{
	$is_admin = TRUE;
}
elseif ( $userdata['user_level'] == MOD)
{
	$is_mod = TRUE;
}

$mod_array = array();
$mod_auth = array();

$sql_auth= 'SELECT ap.group_id, ap.mod_id, ap.auth_view 
			FROM ' . AUTH_PORTAL_TABLE .' ap
			LEFT JOIN ' . USER_GROUP_TABLE . ' ug
				ON (ap.group_id=ug.group_id)
			WHERE user_pending = 0
				AND ug.user_id = ' . $userdata['user_id'] . '
				AND ap.auth_view=1;';
if (!$result_auth = $db -> sql_query($sql_auth))
{
	message_die(CRITICAL_ERROR, "Could not query portal auth information", "", __LINE__, __FILE__, $sql_auth);
}
while ( $row_auth = $db -> sql_fetchrow($result_auth))
{
	$mod_auth [$row_auth['mod_id']] = $row_auth['auth_view'];
}

while ( $row_mod = $db->sql_fetchrow($result_mod) )
{	
	$struct_array[ $nbmod ] = $row_mod ;

	if ( !isset( $mod_array[ $row_mod['mod_id'] ] ) and ( $row_mod['mod_auth'] != AUTH_ALL ) )
	{
		switch ( $row_mod['mod_auth'] )
		{
			case AUTH_INV :
				if ($userdata['session_logged_in'])
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
			
			case AUTH_REG :
				if ($userdata['user_id'] == -1)
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
			
			case AUTH_ACL :
				if (!$mod_auth[$row_mod['mod_id']] && !($is_admin) && !($is_mod))
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
			
			case AUTH_ACLX:
				if (!$mod_auth[ $row_mod['mod_id'] ] && !($is_admin))
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
			
			case AUTH_MOD :
				if (!($is_mod) && !($is_admin))
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
			case AUTH_ADMIN :
				if (!($is_admin))
					{ $mod_array[ $row_mod['mod_id'] ] = ""; }
				break;
		}
	}
	
	if ( !isset( $mod_array[ $row_mod['mod_id'] ] ) )
	{
		$template_mod = new Template_Mod();
		
		// affectation des infos générales dans l'objet template_mod
		$template_mod->assign_vars(array(
		'PORTAL_CLASS_BALISE' => $board_config['portal_class_balise'],
		'PORTAL_CLASS_TITLE' => $board_config['portal_class_title'],
		'PAGE_ID' => $page_id,
		'SPACE_ROW' => $portal_config['space_row'],
		'SPACE_COL' => $portal_config['space_col'],
		'SITENAME' => $board_config['sitename'],
		'SITE_DESCRIPTION' => $board_config['site_desc'],
		'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
		'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
		'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
		'L_USERNAME' => $lang['Username'],
		'L_PASSWORD' => $lang['Password'],
		'L_LOGIN_LOGOUT' => $l_login_logout,
		'L_LOGIN' => $lang['Login'],
		'L_LOG_ME_IN' => $lang['Log_me_in'],
		'L_AUTO_LOGIN' => $lang['Log_me_in'],
		'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
		'L_HOME' => $lang['Home'],		
		'L_REGISTER' => $lang['Register'],
		'L_PROFILE' => $lang['Profile'],
		'L_SEARCH' => $lang['Search'],
		'L_PRIVATEMSGS' => $lang['Private_Messages'],
		'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
		'L_MEMBERLIST' => $lang['Memberlist'],
		'L_FAQ' => $lang['FAQ'],
		'L_USERGROUPS' => $lang['Usergroups'],
		'L_SEARCH_NEW' => $lang['Search_new'],
		'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
		'L_SEARCH_SELF' => $lang['Search_your_posts'],
		'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
		'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),
		'U_SEARCH_UNANSWERED' => append_sid('search.'.$phpEx.'?search_id=unanswered'),
		'U_SEARCH_SELF' => append_sid('search.'.$phpEx.'?search_id=egosearch'),
		'U_SEARCH_NEW' => append_sid('search.'.$phpEx.'?search_id=newposts'),
		'U_INDEX' => append_sid('index.'.$phpEx),
		'U_PORTAL' => append_sid('portal.'.$phpEx),		
		'U_REGISTER' => append_sid('profile.'.$phpEx.'?mode=register'),
		'U_PROFILE' => append_sid('profile.'.$phpEx.'?mode=editprofile'),
		'U_PRIVATEMSGS' => append_sid('privmsg.'.$phpEx.'?folder=inbox'),
		'U_PRIVATEMSGS_POPUP' => append_sid('privmsg.'.$phpEx.'?mode=newpm'),
		'U_SEARCH' => append_sid('search.'.$phpEx),
		'U_MEMBERLIST' => append_sid('memberlist.'.$phpEx),
		'U_MODCP' => append_sid('modcp.'.$phpEx),
		'U_FAQ' => append_sid('faq.'.$phpEx),
		'U_VIEWONLINE' => append_sid('viewonline.'.$phpEx),
		'U_LOGIN_LOGOUT' => append_sid($u_login_logout),
		'U_GROUP_CP' => append_sid('groupcp.'.$phpEx),

		'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
		'S_CONTENT_ENCODING' => $lang['ENCODING'],
		'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
		'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
		'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
		'S_LOGIN_ACTION' => append_sid('login.'.$phpEx))
		);
		
		if( $userdata['session_logged_in'] )
		{
			$template_mod->assign_block_vars( 'switch_user_logged_in' , array() );
		}
		else
		{
			$template_mod->assign_block_vars( 'switch_user_logged_out' , array() );
		}
		
		$modvar = "" ;
		if ( $row_mod['mod_type'] == 1 )
		{
			$template_mod->set_filenames(array(
		   		'body' => $template_mod->root . 'standard.tpl')
			);
			if ( $row_mod['mod_table'] == 1 )
			{
				$template_mod->assign_block_vars( 'table_row' , array(
					'L_TITRE' => stripslashes($row_mod['mod_title']) )
					);
				$template_mod->assign_vars( array(
					"CLASS_TABLE_TYPE" => " class='row1' ")
					);
			}
			else
			{
				$template_mod->assign_block_vars( 'not_table_row' , array());
			}
			$template_mod->assign_vars( array(
				'S_SOURCE' => preg_replace ("#\[append\]([\w]+?.*?[^ \"\n\r\t<]*?)\[/append\]#si", url_append( append_sid("\\1" , true )), stripslashes($row_mod['mod_source']) ) )
				);
				$modvar = $template_mod->pparse_mod('body');
		}
		else
		{
			include( $phpbb_mod_path . 'mod_' . $row_mod['mod_name'] . "." . $phpEx );
		}	
		$mod_array[ $row_mod['mod_id'] ] = $modvar ;
		$template_mod->destroy();
	}
	$nbmod++ ;
}
$last_col = -1 ;
for ( $imod = 0 ; $imod <= $nbmod ; $imod++ )
{
			$modvar = $mod_array[ $struct_array[ $imod ]['mod_id'] ] ;
			switch ( $struct_array[ $imod ]['struct_col'] )
			{
				case 0 :
				$posbody = $hbodyline ;
				break;
				case 4 :
				$posbody = $fbodyline ;
				break;
				default:
				$posbody = '' ;
				break;
			}

			$template->assign_block_vars( $posbody . 'giefmod' . $struct_array[ $imod ]['struct_col'] ,array(
				'MODVAR' => $modvar)
				);
			if (( $struct_array[ $imod ]['struct_col'] == 0 ) or ( $struct_array[ $imod ]['struct_col'] == 4 ))
			{
				if (( $modvar != "") and ( $struct_array[ $imod ]['struct_col'] == $last_col ) )
				 $template->assign_block_vars( $posbody . 'giefmod' . $struct_array[ $imod ]['struct_col'] . '.saut', array() ) ;
			}
			else if ( $modvar != "" )
			{
				 $template->assign_block_vars( $posbody . 'giefmod' . $struct_array[ $imod ]['struct_col'] . '.saut', array() ) ;
			}	 
			$last_col = $struct_array[ $imod ]['struct_col'] ;
}

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
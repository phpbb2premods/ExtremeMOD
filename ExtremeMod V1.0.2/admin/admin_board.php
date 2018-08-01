<?php
/***************************************************************************
 *                              admin_board.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_board.php,v 1.51.2.16 2006/12/16 13:11:24 acydburn Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Configuration'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ($config_name == 'cookie_name')
		{
			$new['cookie_name'] = str_replace('.', '_', $new['cookie_name']);
		}

		// Attempt to prevent a common mistake with this value,
		// http:// is the protocol and not part of the server name
		if ($config_name == 'server_name')
		{
			$new['server_name'] = str_replace('http://', '', $new['server_name']);
		}

		// Attempt to prevent a mistake with this value.
		if ($config_name == 'avatar_path')
		{
			$new['avatar_path'] = trim($new['avatar_path']);
			if (strstr($new['avatar_path'], "\0") || !is_dir($phpbb_root_path . $new['avatar_path']) || !is_writable($phpbb_root_path . $new['avatar_path']))
			{
				$new['avatar_path'] = $default_config['avatar_path'];
			}
		}

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$style_select = style_select($new['default_style'], 'default_style', "../templates");
$lang_select = language_select($new['default_lang'], 'default_lang', "language");
$timezone_select = tz_select($new['board_timezone'], 'board_timezone');

$disable_board_yes = ( $new['board_disable'] ) ? "checked=\"checked\"" : "";
$disable_board_no = ( !$new['board_disable'] ) ? "checked=\"checked\"" : "";

// BEGIN Disable Registration MOD
$registration_status_yes = ( $new['registration_status'] ) ? "checked=\"checked\"" : "";
$registration_status_no = ( !$new['registration_status'] ) ? "checked=\"checked\"" : ""; 
// END Disable Registration MOD

// Default avatar MOD, By Manipe (Begin)
$default_avatar_guests = ($new['default_avatar_set'] == '0') ? "checked=\"checked\"" : "";
$default_avatar_users = ($new['default_avatar_set'] == '1') ? "checked=\"checked\"" : "";
$default_avatar_both = ($new['default_avatar_set'] == '2') ? "checked=\"checked\"" : "";
$default_avatar_none = ($new['default_avatar_set'] == '3') ? "checked=\"checked\"" : "";
// Default avatar MOD, By Manipe (End)

$cookie_secure_yes = ( $new['cookie_secure'] ) ? "checked=\"checked\"" : "";
$cookie_secure_no = ( !$new['cookie_secure'] ) ? "checked=\"checked\"" : "";

$html_tags = $new['allow_html_tags'];

$override_user_style_yes = ( $new['override_user_style'] ) ? "checked=\"checked\"" : "";
$override_user_style_no = ( !$new['override_user_style'] ) ? "checked=\"checked\"" : "";

$html_yes = ( $new['allow_html'] ) ? "checked=\"checked\"" : "";
$html_no = ( !$new['allow_html'] ) ? "checked=\"checked\"" : "";

$bbcode_yes = ( $new['allow_bbcode'] ) ? "checked=\"checked\"" : "";
$bbcode_no = ( !$new['allow_bbcode'] ) ? "checked=\"checked\"" : "";

$activation_none = ( $new['require_activation'] == USER_ACTIVATION_NONE ) ? "checked=\"checked\"" : "";
$activation_user = ( $new['require_activation'] == USER_ACTIVATION_SELF ) ? "checked=\"checked\"" : "";
$activation_admin = ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "";

$confirm_yes = ($new['enable_confirm']) ? 'checked="checked"' : '';
$confirm_no = (!$new['enable_confirm']) ? 'checked="checked"' : '';

//Ajout confirmation écrite
$question_conf_yes = ($new['question_conf_enable']) ? 'checked="checked"' : '';
$question_conf_no = (!$new['question_conf_enable']) ? 'checked="checked"' : '';
//Fin confirmation écrite

$allow_autologin_yes = ($new['allow_autologin']) ? 'checked="checked"' : '';
$allow_autologin_no = (!$new['allow_autologin']) ? 'checked="checked"' : '';

$board_email_form_yes = ( $new['board_email_form'] ) ? "checked=\"checked\"" : "";
$board_email_form_no = ( !$new['board_email_form'] ) ? "checked=\"checked\"" : "";

$gzip_yes = ( $new['gzip_compress'] ) ? "checked=\"checked\"" : "";
$gzip_no = ( !$new['gzip_compress'] ) ? "checked=\"checked\"" : "";

$privmsg_on = ( !$new['privmsg_disable'] ) ? "checked=\"checked\"" : "";
$privmsg_off = ( $new['privmsg_disable'] ) ? "checked=\"checked\"" : "";

$prune_yes = ( $new['prune_enable'] ) ? "checked=\"checked\"" : "";
$prune_no = ( !$new['prune_enable'] ) ? "checked=\"checked\"" : "";

$activeportail_yes = ( $new['activeportail'] ) ? "checked=\"checked\"" : ""; 
$activeportail_no = ( !$new['activeportail'] ) ? "checked=\"checked\"" : ""; 

// Start add - Birthday MOD
$birthday_greeting_yes = ( $new['birthday_greeting'] ) ? "checked=\"checked\"" : "";
$birthday_greeting_no = ( !$new['birthday_greeting'] ) ? "checked=\"checked\"" : "";
$birthday_required_yes = ( $new['birthday_required'] ) ? "checked=\"checked\"" : "";
$birthday_required_no = ( !$new['birthday_required'] ) ? "checked=\"checked\"" : "";
// End add - Birthday MOD

$smile_yes = ( $new['allow_smilies'] ) ? "checked=\"checked\"" : "";
$smile_no = ( !$new['allow_smilies'] ) ? "checked=\"checked\"" : "";

$sig_yes = ( $new['allow_sig'] ) ? "checked=\"checked\"" : "";
$sig_no = ( !$new['allow_sig'] ) ? "checked=\"checked\"" : "";

$namechange_yes = ( $new['allow_namechange'] ) ? "checked=\"checked\"" : "";
$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";

$annonce_globale_index_yes = ( $new['annonce_globale_index'] ) ? 'checked="checked"' : '';
$annonce_globale_index_no = ( !$new['annonce_globale_index'] ) ? 'checked="checked"' : '';

$avatars_local_yes = ( $new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_local_no = ( !$new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_remote_yes = ( $new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_remote_no = ( !$new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_upload_yes = ( $new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";
$avatars_upload_no = ( !$new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";

$smtp_yes = ( $new['smtp_delivery'] ) ? "checked=\"checked\"" : "";
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

$max_warn_level = $new['card_max'];

$template->set_filenames(array(
	"body" => "admin/board_config_body.tpl")
);

//
// Escape any quotes in the site description for proper display in the text
// box on the admin page 
//
$new['site_desc'] = str_replace('"', '&quot;', $new['site_desc']);
$new['sitename'] = str_replace('"', '&quot;', strip_tags($new['sitename']));

// BEGIN Disable Registration MOD
$new['registration_closed'] = str_replace('"', '&quot;', $new['registration_closed']);
// END Disable Registration MOD

$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	// Default Avatar MOD, By Manipe (Begin)
	"L_DEFAULT_AVATAR" => $lang['Default_avatar'],
	"L_DEFAULT_AVATAR_EXPLAIN" => $lang['Default_avatar_explain'],
	"L_DEFAULT_AVATAR_GUESTS" => $lang['Default_avatar_guests'],
	"L_DEFAULT_AVATAR_USERS" => $lang['Default_avatar_users'],
	"L_DEFAULT_AVATAR_BOTH" => $lang['Default_avatar_both'],
	"L_DEFAULT_AVATAR_NONE" => $lang['Default_avatar_none'],
	// Default Avatar MOD, By Manipe (End)
	"L_CONFIGURATION_TITLE" => $lang['General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['General_settings'],
	"L_SERVER_NAME" => $lang['Server_name'], 
	"L_SERVER_NAME_EXPLAIN" => $lang['Server_name_explain'], 
	"L_SERVER_PORT" => $lang['Server_port'], 
	"L_SERVER_PORT_EXPLAIN" => $lang['Server_port_explain'], 
	"L_SCRIPT_PATH" => $lang['Script_path'], 
	"L_SCRIPT_PATH_EXPLAIN" => $lang['Script_path_explain'], 
	"L_SITE_NAME" => $lang['Site_name'],
	"L_SITE_DESCRIPTION" => $lang['Site_desc'],
	"L_DISABLE_BOARD" => $lang['Board_disable'], 
	"L_DISABLE_BOARD_EXPLAIN" => $lang['Board_disable_explain'], 
	"L_DISABLE_BOARD_MSG" => $lang['Board_disable_msg'], 
	"L_DISABLE_BOARD_MSG_EXPLAIN" => $lang['Board_disable_msg_explain'],
	  // BEGIN Disable Registration MOD
  	"L_REGISTRATION_STATUS" => $lang['registration_status'],
  	"L_REGISTRATION_STATUS_EXPLAIN" => $lang['registration_status_explain'], 
  	"L_REGISTRATION_CLOSED" => $lang['registration_closed'],
  	"L_REGISTRATION_CLOSED_EXPLAIN" => $lang['registration_closed_explain'],
  	// END Disable Registration MOD
	"L_ACCT_ACTIVATION" => $lang['Acct_activation'], 
	//Ajout confirmation écrite
	"L_ACTIVE_QUESTION_CONF_ECRITE" => $lang['Active_question_conf_ecrite'],
	"L_QUESTION_CONF_ECRITE" => $lang['Question_conf_ecrite'],
	"L_REPONSE_CONF_ECRITE" => $lang['Reponse_conf_write'],
	//Fin confirmation écrite
	"L_NONE" => $lang['Acc_None'], 
	"L_USER" => $lang['Acc_User'], 
	"L_ADMIN" => $lang['Acc_Admin'], 
	"L_VISUAL_CONFIRM" => $lang['Visual_confirm'], 
	"L_VISUAL_CONFIRM_EXPLAIN" => $lang['Visual_confirm_explain'], 
	"L_ALLOW_AUTOLOGIN" => $lang['Allow_autologin'],
	"L_ALLOW_AUTOLOGIN_EXPLAIN" => $lang['Allow_autologin_explain'],
	"L_AUTOLOGIN_TIME" => $lang['Autologin_time'],
	"L_AUTOLOGIN_TIME_EXPLAIN" => $lang['Autologin_time_explain'],
	"L_COOKIE_SETTINGS" => $lang['Cookie_settings'], 
	"L_COOKIE_SETTINGS_EXPLAIN" => $lang['Cookie_settings_explain'], 
	"L_COOKIE_DOMAIN" => $lang['Cookie_domain'],
	"L_COOKIE_NAME" => $lang['Cookie_name'], 
	"L_COOKIE_PATH" => $lang['Cookie_path'], 
	"L_COOKIE_SECURE" => $lang['Cookie_secure'], 
	"L_COOKIE_SECURE_EXPLAIN" => $lang['Cookie_secure_explain'], 
	"L_SESSION_LENGTH" => $lang['Session_length'], 
	"L_PRIVATE_MESSAGING" => $lang['Private_Messaging'], 
	"L_INBOX_LIMIT" => $lang['Inbox_limits'], 
	"L_SENTBOX_LIMIT" => $lang['Sentbox_limits'], 
	"L_SAVEBOX_LIMIT" => $lang['Savebox_limits'], 
	"L_DISABLE_PRIVATE_MESSAGING" => $lang['Disable_privmsg'], 
	"L_ENABLED" => $lang['Enabled'], 
	"L_DISABLED" => $lang['Disabled'], 
	"L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],
	"L_MAX_POLL_OPTIONS" => $lang['Max_poll_options'],
	"L_FLOOD_INTERVAL" => $lang['Flood_Interval'],
	"L_FLOOD_INTERVAL_EXPLAIN" => $lang['Flood_Interval_explain'], 
	"L_SEARCH_FLOOD_INTERVAL" => $lang['Search_Flood_Interval'],
	"L_SEARCH_FLOOD_INTERVAL_EXPLAIN" => $lang['Search_Flood_Interval_explain'], 

	'L_MAX_LOGIN_ATTEMPTS'			=> $lang['Max_login_attempts'],
	'L_MAX_LOGIN_ATTEMPTS_EXPLAIN'	=> $lang['Max_login_attempts_explain'],
	'L_LOGIN_RESET_TIME'			=> $lang['Login_reset_time'],
	'L_LOGIN_RESET_TIME_EXPLAIN'	=> $lang['Login_reset_time_explain'],
	'MAX_LOGIN_ATTEMPTS'			=> $new['max_login_attempts'],
	'LOGIN_RESET_TIME'				=> $new['login_reset_time'],
	'WARN_LEVEL' => $max_warn_level,
	'L_WARN_LEVEL' => $lang['card_warn_level'],

	"L_BOARD_EMAIL_FORM" => $lang['Board_email_form'], 
	//-- mod : resize posted images based on max width -----------------------------
	//-- add
  	'L_IMAGES_MAX_SIZE' => $lang['Images_max_size'],
  	'L_IMAGES_MAX_SIZE_EXPLAIN' => $lang['Images_max_size_explain'],
  	'IMAGES_MAX_SIZE' => $new['images_max_size'],
	//-- fin mod : resize posted images based on max width -------------------------
	"L_BOARD_EMAIL_FORM_EXPLAIN" => $lang['Board_email_form_explain'], 
	"L_TOPICS_PER_PAGE" => $lang['Topics_per_page'],
	"L_POSTS_PER_PAGE" => $lang['Posts_per_page'],
	"L_HOT_THRESHOLD" => $lang['Hot_threshold'],
	"L_DEFAULT_STYLE" => $lang['Default_style'],
	"L_OVERRIDE_STYLE" => $lang['Override_style'],
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],
	"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
	"L_DATE_FORMAT" => $lang['Date_format'],
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],
	"L_ENABLE_GZIP" => $lang['Enable_gzip'],
	"L_ENABLE_PRUNE" => $lang['Enable_prune'],
	"L_ACTIVEPORTAIL" => $lang['activeportail'], 
	// Start add - Birthday MOD
	"L_ENABLE_BIRTHDAY_GREETING" => $lang['Enable_birthday_greeting'],
	"L_BIRTHDAY_GREETING_EXPLAIN" => $lang['Birthday_greeting_expain'],
	"L_BIRTHDAY_REQUIRED" => $lang['Birthday_required'],
	"L_MAX_USER_AGE" => $lang['Max_user_age'],
	"L_MIN_USER_AGE" => $lang['Min_user_age'],
	"L_MIN_USER_AGE_EXPLAIN" => $lang['Min_user_age_explain'],
	"L_BIRTHDAY_LOOKFORWARD" => $lang['Birthday_lookforward'],
	"L_BIRTHDAY_LOOKFORWARD_EXPLAIN" => $lang['Birthday_lookforward_explain'],
	// End add - Birthday MOD
	"L_ALLOW_HTML" => $lang['Allow_HTML'],
	"L_ALLOW_BBCODE" => $lang['Allow_BBCode'],
	"L_ALLOWED_TAGS" => $lang['Allowed_tags'],
	"L_ALLOWED_TAGS_EXPLAIN" => $lang['Allowed_tags_explain'],
	"L_ALLOW_SMILIES" => $lang['Allow_smilies'],
	"L_SMILIES_PATH" => $lang['Smilies_path'],
	"L_SMILIES_PATH_EXPLAIN" => $lang['Smilies_path_explain'],
	"L_ALLOW_SIG" => $lang['Allow_sig'],
	"L_MAX_SIG_LENGTH" => $lang['Max_sig_length'],
	"L_MAX_SIG_LENGTH_EXPLAIN" => $lang['Max_sig_length_explain'],
	"L_ALLOW_NAME_CHANGE" => $lang['Allow_name_change'],
	"L_ANNONCE_GLOBALE_INDEX" => $lang['Annonce_Globale_Index'],
	"L_AVATAR_SETTINGS" => $lang['Avatar_settings'],
	"L_ALLOW_LOCAL" => $lang['Allow_local'],
	"L_ALLOW_REMOTE" => $lang['Allow_remote'],
	"L_ALLOW_REMOTE_EXPLAIN" => $lang['Allow_remote_explain'],
	"L_ALLOW_UPLOAD" => $lang['Allow_upload'],
	"L_MAX_FILESIZE" => $lang['Max_filesize'],
	"L_MAX_FILESIZE_EXPLAIN" => $lang['Max_filesize_explain'],
	"L_MAX_AVATAR_SIZE" => $lang['Max_avatar_size'],
	"L_MAX_AVATAR_SIZE_EXPLAIN" => $lang['Max_avatar_size_explain'],
	"L_AVATAR_STORAGE_PATH" => $lang['Avatar_storage_path'],
	"L_AVATAR_STORAGE_PATH_EXPLAIN" => $lang['Avatar_storage_path_explain'],
	"L_AVATAR_GALLERY_PATH" => $lang['Avatar_gallery_path'],
	"L_AVATAR_GALLERY_PATH_EXPLAIN" => $lang['Avatar_gallery_path_explain'],
	"L_FORUM_ICON_PATH" => $lang['Forum_icon_path'], // Forum Icon MOD
	"L_FORUM_ICON_PATH_EXPLAIN" => $lang['Forum_icon_path_explain'], // Forum Icon MOD
	"L_COPPA_SETTINGS" => $lang['COPPA_settings'],
	"L_COPPA_FAX" => $lang['COPPA_fax'],
	"L_COPPA_MAIL" => $lang['COPPA_mail'],
	"L_COPPA_MAIL_EXPLAIN" => $lang['COPPA_mail_explain'],
	"L_EMAIL_SETTINGS" => $lang['Email_settings'],
	"L_ADMIN_EMAIL" => $lang['Admin_email'],
	"L_EMAIL_SIG" => $lang['Email_sig'],
	"L_EMAIL_SIG_EXPLAIN" => $lang['Email_sig_explain'],
	"L_USE_SMTP" => $lang['Use_SMTP'],
	"L_USE_SMTP_EXPLAIN" => $lang['Use_SMTP_explain'],
	"L_SMTP_SERVER" => $lang['SMTP_server'], 
	"L_SMTP_USERNAME" => $lang['SMTP_username'], 
	"L_SMTP_USERNAME_EXPLAIN" => $lang['SMTP_username_explain'], 
	"L_SMTP_PASSWORD" => $lang['SMTP_password'], 
	"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'], 
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	//-- mod : last active topic on index ------------------------------------------
	//-- add
	'L_LAST_TOPIC_TITLE_LENGTH' => $lang['Last_topic_title_length'],
	'L_LAST_TOPIC_TITLE_LENGTH_EXPLAIN' => $lang['Last_topic_title_length_explain'], 
	'LAST_TOPIC_TITLE_LENGTH' => $new['last_topic_title_length'],
	'L_LAST_TOPIC_TITLE_REDIRECT' => $lang['Last_topic_title_redirect'],
	'L_LAST_TOPIC' => $lang['Latest_topic'],
	'L_LAST_POST' => $lang['Latest_post'],
	'LAST_TOPIC_URL' => (!$new['last_topic_title_redirect']) ? 'selected="selected"' : '',
	'LAST_POST_URL' => ($new['last_topic_title_redirect']) ? 'selected="selected"' : '',
	//-- fin mod : last active topic on index --------------------------------------

	"L_SMILIES_COLONNE" => $lang['smilies_colonne'], 
	"L_SMILIES_LIGNE" => $lang['smilies_ligne'], 
	// START ADDON SEND PM ON USER REGISTRATION ADD
   	"PMOR_SUBJECT" => $board_config['register_mp_subject'],
   	"PMOR_BODY" => $board_config['register_mp'],
   	"L_PMOR_SUBJECT" => $lang['register_mp_subject'],
   	"L_PMOR_BODY" => $lang['register_mp'],
   	// END ADDON ADD
	// Start add - Online/Offline/Hidden Mod
	'L_ONLINE_TIME' => $lang['Online_time'],
	'L_ONLINE_TIME_EXPLAIN' => $lang['Online_time_explain'], 
	'ONLINE_TIME' => $new['online_time'],
	// End add - Online/Offline/Hidden Mod
	//-- mod : double post merge ---------------------------------------------------
	//-- add
	'JOIN_INTERVAL' => $new['join_interval'],

	'L_JOIN_INTERVAL' => $lang['Join_Interval'],
	'L_JOIN_INTERVAL_EXPLAIN' => $lang['Join_Interval_explain'],
	//-- fin mod : double post merge -----------------------------------------------
	"SERVER_NAME" => $new['server_name'], 
	"SCRIPT_PATH" => $new['script_path'], 
	"SERVER_PORT" => $new['server_port'], 
	"SITENAME" => $new['sitename'],
	"SITE_DESCRIPTION" => $new['site_desc'], 
	"S_DISABLE_BOARD_YES" => $disable_board_yes,
	"S_DISABLE_BOARD_NO" => $disable_board_no,
	"DISABLE_BOARD_MSG" => $new['board_disable_msg'],
	  // BEGIN Disable Registration MOD
  	"S_REGISTRATION_STATUS_YES" => $registration_status_yes,
  	"S_REGISTRATION_STATUS_NO" => $registration_status_no,
  	"REGISTRATION_CLOSED" => $new['registration_closed'], 
  	// END Disable Registration MOD
	// Default avatar MOD, By Manipe (Begin)
	"DEFAULT_AVATAR_GUESTS_URL" => $new['default_avatar_guests_url'],
	"DEFAULT_AVATAR_USERS_URL" => $new['default_avatar_users_url'],
	"DEFAULT_AVATAR_GUESTS" => $default_avatar_guests,
	"DEFAULT_AVATAR_USERS" => $default_avatar_users,
	"DEFAULT_AVATAR_BOTH" => $default_avatar_both,
	"DEFAULT_AVATAR_NONE" => $default_avatar_none,
	// Default avatar MOD, By Manipe (End)
	"ACTIVATION_NONE" => USER_ACTIVATION_NONE, 
	"ACTIVATION_NONE_CHECKED" => $activation_none,
	"ACTIVATION_USER" => USER_ACTIVATION_SELF, 
	"ACTIVATION_USER_CHECKED" => $activation_user,
	"ACTIVATION_ADMIN" => USER_ACTIVATION_ADMIN, 
	"ACTIVATION_ADMIN_CHECKED" => $activation_admin, 
	"CONFIRM_ENABLE" => $confirm_yes,
	"CONFIRM_DISABLE" => $confirm_no,
	//Ajout confirmation écrite
	"QUESTION_CONF_YES" => $question_conf_yes,
	"QUESTION_CONF_NO" => $question_conf_no,
	"QUESTION_CONF" => $new['question_conf'],
	"REPONSE_CONF" => $new['reponse_conf'],
	//Fin confirmation écrite
	'ALLOW_AUTOLOGIN_YES' => $allow_autologin_yes,
	'ALLOW_AUTOLOGIN_NO' => $allow_autologin_no,
	'AUTOLOGIN_TIME' => (int) $new['max_autologin_time'],
	"BOARD_EMAIL_FORM_ENABLE" => $board_email_form_yes, 
	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 
	"MAX_POLL_OPTIONS" => $new['max_poll_options'], 
	"FLOOD_INTERVAL" => $new['flood_interval'],
	"SEARCH_FLOOD_INTERVAL" => $new['search_flood_interval'],
	"TOPICS_PER_PAGE" => $new['topics_per_page'],
	"POSTS_PER_PAGE" => $new['posts_per_page'],
	"HOT_TOPIC" => $new['hot_threshold'],
	//-- mod : post description ----------------------------------------------------
	//-- add
	'L_SUB_TITLE_LENGTH' => $lang['Sub_title_length'],
	'L_SUB_TITLE_LENGTH_EXPLAIN' => $lang['Sub_title_length_explain'],
	'SUB_TITLE_LENGTH' => $new['sub_title_length'],
	//-- fin mod : post description ------------------------------------------------
	"STYLE_SELECT" => $style_select,
	"OVERRIDE_STYLE_YES" => $override_user_style_yes,
	"OVERRIDE_STYLE_NO" => $override_user_style_no,
	"LANG_SELECT" => $lang_select,
	"L_DATE_FORMAT_EXPLAIN" => $lang['Date_format_explain'],
	"DEFAULT_DATEFORMAT" => $new['default_dateformat'],
	"TIMEZONE_SELECT" => $timezone_select,
	"S_PRIVMSG_ENABLED" => $privmsg_on, 
	"S_PRIVMSG_DISABLED" => $privmsg_off, 
	"INBOX_LIMIT" => $new['max_inbox_privmsgs'], 
	"SENTBOX_LIMIT" => $new['max_sentbox_privmsgs'],
	"SAVEBOX_LIMIT" => $new['max_savebox_privmsgs'],
	"COOKIE_DOMAIN" => $new['cookie_domain'], 
	"COOKIE_NAME" => $new['cookie_name'], 
	"COOKIE_PATH" => $new['cookie_path'], 
	"SESSION_LENGTH" => $new['session_length'], 
	"S_COOKIE_SECURE_ENABLED" => $cookie_secure_yes, 
	"S_COOKIE_SECURE_DISABLED" => $cookie_secure_no, 
	"GZIP_YES" => $gzip_yes,
	"GZIP_NO" => $gzip_no,
	"PRUNE_YES" => $prune_yes,
	"PRUNE_NO" => $prune_no, 
	"ACTIVEPORTAIL_YES" => $activeportail_yes, 
	"ACTIVEPORTAIL_NO" => $activeportail_no,
	// Start add - Birthday MOD
	"BIRTHDAY_GREETING_YES" => $birthday_greeting_yes,
	"BIRTHDAY_GREETING_NO" => $birthday_greeting_no,
	"BIRTHDAY_REQUIRED_YES" => $birthday_required_yes,
	"BIRTHDAY_REQUIRED_NO" => $birthday_required_no, 
	"MAX_USER_AGE" => $new['max_user_age'],
	"MIN_USER_AGE" => $new['min_user_age'],
	"BIRTHDAY_LOOKFORWARD" => $new['birthday_check_day'],
	// End add - Birthday MOD
	"HTML_TAGS" => $html_tags, 
	"HTML_YES" => $html_yes,
	"HTML_NO" => $html_no,
	"BBCODE_YES" => $bbcode_yes,
	"BBCODE_NO" => $bbcode_no,
	"SMILE_YES" => $smile_yes,
	"SMILE_NO" => $smile_no,
	"SIG_YES" => $sig_yes,
	"SIG_NO" => $sig_no,
	"SIG_SIZE" => $new['max_sig_chars'], 
	"NAMECHANGE_YES" => $namechange_yes,
	"NAMECHANGE_NO" => $namechange_no,
	"ANNONCE_GLOBALE_INDEX_YES" => $annonce_globale_index_yes,
	"ANNONCE_GLOBALE_INDEX_NO" => $annonce_globale_index_no,
	"AVATARS_LOCAL_YES" => $avatars_local_yes,
	"AVATARS_LOCAL_NO" => $avatars_local_no,
	"AVATARS_REMOTE_YES" => $avatars_remote_yes,
	"AVATARS_REMOTE_NO" => $avatars_remote_no,
	"AVATARS_UPLOAD_YES" => $avatars_upload_yes,
	"AVATARS_UPLOAD_NO" => $avatars_upload_no,
	"AVATAR_FILESIZE" => $new['avatar_filesize'],
	"AVATAR_MAX_HEIGHT" => $new['avatar_max_height'],
	"AVATAR_MAX_WIDTH" => $new['avatar_max_width'],
	"AVATAR_PATH" => $new['avatar_path'], 
	"AVATAR_GALLERY_PATH" => $new['avatar_gallery_path'], 
	"FORUM_ICON_PATH" => $new['forum_icon_path'], // Forum Icon MOD
	"SMILIES_PATH" => $new['smilies_path'], 
	"SMILIES_COLONNE" => $new['smilies_colonne'], 
	"SMILIES_LIGNE" => $new['smilies_ligne'],
	//-- mod : flags ---------------------------------------------------------------
	//-- add
	'L_FLAGS_PATH' => $lang['flags_path'],
	'L_FLAGS_PATH_EXPLAIN' => $lang['flags_path_explain'],

	'FLAGS_PATH' => $new['flags_path'],
	//-- fin mod : flags -----------------------------------------------------------
	"INBOX_PRIVMSGS" => $new['max_inbox_privmsgs'], 
	"SENTBOX_PRIVMSGS" => $new['max_sentbox_privmsgs'], 
	"SAVEBOX_PRIVMSGS" => $new['max_savebox_privmsgs'], 
	"EMAIL_FROM" => $new['board_email'],
	"EMAIL_SIG" => $new['board_email_sig'],
	"SMTP_YES" => $smtp_yes,
	"SMTP_NO" => $smtp_no,
	"SMTP_HOST" => $new['smtp_host'],
	"SMTP_USERNAME" => $new['smtp_username'],
	"SMTP_PASSWORD" => $new['smtp_password'],
	"COPPA_MAIL" => $new['coppa_mail'],
	"COPPA_FAX" => $new['coppa_fax'])
);

//-- mod : date format evolved -------------------------------------------------
//-- add
dateformat_select($new['default_dateformat']);
//-- fin mod : date format evolved ---------------------------------------------

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>

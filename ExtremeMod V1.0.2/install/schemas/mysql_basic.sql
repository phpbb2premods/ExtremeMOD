#
# Basic DB data for phpBB2 devel
#
# $Id: mysql_basic.sql,v 1.29.2.29 2006/12/16 13:11:27 acydburn Exp $

# -- Config
INSERT INTO phpbb_config (config_name, config_value) VALUES ('config_id','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sitename','Extreme Mod');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('site_desc','Premod basée sur les jeux arcade');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_name','phpbb2mysql');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_path','/');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_domain','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cookie_secure','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('session_length','3600');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_html','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_html_tags','b,i,u,pre');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_bbcode','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_smilies','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_sig','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_namechange','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_theme_create','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_local','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_remote','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_avatar_upload','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('enable_confirm', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_autologin','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_autologin_time','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('override_user_style','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('posts_per_page','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('topics_per_page','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('hot_threshold','25');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_poll_options','10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_sig_chars','255');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_inbox_privmsgs','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_sentbox_privmsgs','25');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_savebox_privmsgs','50');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email_sig','Thanks, The Management');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email','youraddress@yourdomain.com');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_delivery','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_host','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_username','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smtp_password','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sendmail_fix','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('require_activation','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('flood_interval','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('search_flood_interval','15');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('search_min_chars','3');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_login_attempts', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('login_reset_time', '30');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_email_form','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_filesize','6144');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_max_width','80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_max_height','80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_path','images/avatars');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('avatar_gallery_path','images/avatars/gallery');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smilies_path','images/smiles');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('default_style','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('default_dateformat','D M d, Y g:i a');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_timezone','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('prune_enable','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('privmsg_disable','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('gzip_compress','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('coppa_fax', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('coppa_mail', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('record_online_users', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('record_online_date', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('server_name', 'www.myserver.tld');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('server_port', '80');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('script_path', '/phpBB2/');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('version', '.0.22');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rand_seed', '0');


# -- Categories
INSERT INTO phpbb_categories (cat_id, cat_title, cat_order) VALUES (1, 'Test category 1', 10);


# -- Forums
INSERT INTO phpbb_forums (forum_id, forum_name, forum_desc, cat_id, forum_order, forum_posts, forum_topics, forum_last_post_id, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_announce, auth_sticky, auth_pollcreate, auth_vote, auth_attachments) VALUES (1, 'Test Forum 1', 'This is just a test forum.', 1, 10, 1, 1, 1, 0, 0, 1, 1, 1, 1, 3, 3, 1, 1, 3);


# -- Users
INSERT INTO phpbb_users (user_id, username, user_level, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_viewemail, user_style, user_aim, user_yim, user_msnm, user_posts, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_pm, user_notify_pm, user_allow_viewonline, user_rank, user_avatar, user_lang, user_timezone, user_dateformat, user_actkey, user_newpasswd, user_notify, user_active) VALUES ( -1, 'Anonymous', 0, 0, '', '', '', '', '', '', '', '', 0, NULL, '', '', '', 0, 0, 1, 1, 1, 0, 1, 1, NULL, '', '', 0, '', '', '', 0, 0);

# -- username: admin    password: admin (change this or remove it once everything is working!)
INSERT INTO phpbb_users (user_id, username, user_level, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_viewemail, user_style, user_aim, user_yim, user_msnm, user_posts, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_pm, user_notify_pm, user_popup_pm, user_allow_viewonline, user_rank, user_avatar, user_lang, user_timezone, user_dateformat, user_actkey, user_newpasswd, user_notify, user_active) VALUES ( 2, 'Admin', 1, 0, '21232f297a57a5a743894a0e4a801fc3', 'admin@yourdomain.com', '', '', '', '', '', '', 1, 1, '', '', '', 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, '', 'english', 0, 'd M Y h:i a', '', '', 0, 1);


# -- Ranks
INSERT INTO phpbb_ranks (rank_id, rank_title, rank_min, rank_special, rank_image) VALUES ( 1, 'Site Admin', -1, 1, NULL);


# -- Groups
INSERT INTO phpbb_groups (group_id, group_name, group_description, group_single_user) VALUES (1, 'Anonymous', 'Personal User', 1);
INSERT INTO phpbb_groups (group_id, group_name, group_description, group_single_user) VALUES (2, 'Admin', 'Personal User', 1);


# -- User -> Group
INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES (1, -1, 0);
INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES (2, 2, 0);


# -- Demo Topic
INSERT INTO phpbb_topics (topic_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, forum_id, topic_status, topic_type, topic_vote, topic_first_post_id, topic_last_post_id) VALUES (1, 'Welcome to phpBB 2', 2, '972086460', 0, 0, 1, 0, 0, 0, 1, 1);


# -- Demo Post
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, post_username, poster_ip) VALUES (1, 1, 1, 2, 972086460, NULL, '7F000001');
INSERT INTO phpbb_posts_text (post_id, post_subject, post_text) VALUES (1, NULL, 'This is an example post in your phpBB 2 installation. You may delete this post, this topic and even this forum if you like since everything seems to be working!');

# -- Themes
INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3) VALUES (1, 'subSilver', 'subSilver', 'subSilver.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, ''Courier New'', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', '', '', '');

INSERT INTO phpbb_themes_name (themes_id, tr_color1_name, tr_color2_name, tr_color3_name, tr_class1_name, tr_class2_name, tr_class3_name, th_color1_name, th_color2_name, th_color3_name, th_class1_name, th_class2_name, th_class3_name, td_color1_name, td_color2_name, td_color3_name, td_class1_name, td_class2_name, td_class3_name, fontface1_name, fontface2_name, fontface3_name, fontsize1_name, fontsize2_name, fontsize3_name, fontcolor1_name, fontcolor2_name, fontcolor3_name, span_class1_name, span_class2_name, span_class3_name) VALUES (1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');


# -- Smilies
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 1, ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 2, ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 3, ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 4, ':)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 5, ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 6, ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 7, ':(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 8, ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 9, ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 10, ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 11, ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 12, ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 13, ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 14, ':?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 15, ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 16, ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 17, '8)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 18, '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 19, ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 20, ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 21, ':x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 22, ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 23, ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 24, ':P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 25, ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 26, ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 27, ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 28, ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 29, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 30, ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 31, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 32, ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 33, ';)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 34, ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 35, ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 36, ':?:', 'icon_question.gif', 'Question');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 37, ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 38, ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 39, ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 40, ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 41, ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES ( 42, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');


# -- wordlist
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 1, 'example', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 2, 'post', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 3, 'phpbb', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 4, 'installation', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 5, 'delete', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 6, 'topic', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 7, 'forum', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 8, 'since', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 9, 'everything', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 10, 'seems', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 11, 'working', 0 );
INSERT INTO phpbb_search_wordlist (word_id, word_text, word_common) VALUES ( 12, 'welcome', 0 );


# -- wordmatch
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 1, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 2, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 3, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 4, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 5, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 6, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 7, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 8, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 9, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 10, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 11, 1, 0 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 12, 1, 1 );
INSERT INTO phpbb_search_wordmatch (word_id, post_id, title_match) VALUES ( 3, 1, 1 );

# -- Version Exteme mod V1.0.2

INSERT INTO phpbb_config (config_name, config_value) VALUES ("version1","ExtremeMod v 1.0.2");

# -- Mod Subforums Plus

ALTER TABLE phpbb_forums ADD COLUMN forum_parent mediumint(8) DEFAULT '0' NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES('mod_sf_version','0.0.6');

# -- requetes Birdthay
ALTER TABLE phpbb_users ADD user_birthday INT DEFAULT "999999" not null;
ALTER TABLE phpbb_users ADD user_next_birthday_greeting INT DEFAULT 0 not null;
INSERT INTO phpbb_config (config_name, config_value) VALUES ("birthday_required", 0);
INSERT INTO phpbb_config (config_name, config_value) VALUES ("birthday_greeting", 1);
INSERT INTO phpbb_config (config_name, config_value) VALUES ("max_user_age", 100);
INSERT INTO phpbb_config (config_name, config_value) VALUES ("min_user_age", 5);
INSERT INTO phpbb_config (config_name, config_value) VALUES ("birthday_check_day", 7);

# -- Requete disabled registration

INSERT INTO `phpbb_config` VALUES ('registration_status', '0');
INSERT INTO `phpbb_config` VALUES ('registration_closed', '');

# -- Rajout requete suis gestion du mp de bienvenue par lacp

INSERT INTO phpbb_config VALUES ('register_mp_subject', 'Bienvenue !');
INSERT INTO phpbb_config VALUES ("register_mp", "Bienvenue sur le forum %s !<br /><br />Toute l équipe vous remercie de votre inscription et vous souhaite d'agréables visites sur le forum...<br /><br />L'/Administrateur."); 


# -- mod flag 0.05 de reddog

ALTER TABLE phpbb_users ADD user_flag VARCHAR(100) DEFAULT '' NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('flags_path', 'images/flags/');

# -- Mod forum_icons

ALTER TABLE phpbb_forums ADD forum_icon VARCHAR(255) DEFAULT NULL;
INSERT INTO phpbb_config VALUES('forum_icon_path','images/forum_icons');

# -- Mod gender 1.28

ALTER TABLE phpbb_users ADD user_gender TINYINT DEFAULT '0' NOT NULL;

# -- QTE 1.5.5a
INSERT INTO phpbb_config (config_name, config_value) VALUES ('qte_version', '1.5.5a');
ALTER TABLE phpbb_topics ADD topic_attribute VARCHAR(255);
ALTER TABLE phpbb_topics ADD topic_attribute_color VARCHAR(6) DEFAULT '' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attribute_position TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attribute_username VARCHAR(25) DEFAULT '' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attribute_date VARCHAR(25) DEFAULT '0' NOT NULL;

# -- Mod mini Last visit

ALTER TABLE phpbb_users ADD user_lastlogin INT(11) DEFAULT 0 NOT NULL;
UPDATE phpbb_users SET user_lastlogin = user_lastvisit WHERE user_lastlogin = '0';


# -- bbc box config
#
INSERT INTO phpbb_bbc_box VALUES (1, 'strike', '1', '0', 's', 's', 'strike', 'strike', '0', '10');
INSERT INTO phpbb_bbc_box VALUES (2, 'spoiler', '1', '0', 'spoil', 'spoil', 'spoiler', 'spoiler', '0', '20');
INSERT INTO phpbb_bbc_box VALUES (3, 'fade', '1', '0', 'fade', 'fade', 'fade', 'fade', '0', '30');
INSERT INTO phpbb_bbc_box VALUES (4, 'rainbow', '1', '0', 'rainbow', 'rainbow', 'rainbow', 'rainbow', '1', '40');
INSERT INTO phpbb_bbc_box VALUES (5, 'justify', '1', '0', 'align=justify', 'align', 'justify', 'justify', '0', '50');
INSERT INTO phpbb_bbc_box VALUES (6, 'right', '1', '0', 'align=right', 'align', 'right', 'right', '0', '60');
INSERT INTO phpbb_bbc_box VALUES (7, 'center', '1', '0', 'align=center', 'align', 'center', 'center', '0', '70');
INSERT INTO phpbb_bbc_box VALUES (8, 'left', '1', '0', 'align=left', 'align', 'left', 'left', '1', '80');
INSERT INTO phpbb_bbc_box VALUES (9, 'link', '1', '0', 'link=', 'link', 'link', 'alink', '0', '90');
INSERT INTO phpbb_bbc_box VALUES (10, 'target', '1', '0', 'target=', 'target', 'target', 'atarget', '1', '100');
INSERT INTO phpbb_bbc_box VALUES (11, 'marqd', '1', '0', 'marq=down', 'marq', 'marqd', 'marqd', '0', '110');
INSERT INTO phpbb_bbc_box VALUES (12, 'marqu', '1', '0', 'marq=up', 'marq', 'marqu', 'marqu', '0', '120');
INSERT INTO phpbb_bbc_box VALUES (13, 'marql', '1', '0', 'marq=left', 'marq', 'marql', 'marql', '0', '130');
INSERT INTO phpbb_bbc_box VALUES (14, 'marqr', '1', '0', 'marq=right', 'marq', 'marqr', 'marqr', '1', '140');
INSERT INTO phpbb_bbc_box VALUES (15, 'email', '1', '0', 'email', 'email', 'email', 'email', '0', '150');
INSERT INTO phpbb_bbc_box VALUES (16, 'flash', '1', '0', 'flash width=250 height=250', 'flash', 'flash', 'flash', '0', '160');
INSERT INTO phpbb_bbc_box VALUES (17, 'video', '1', '0', 'video width=400 height=350', 'video', 'video', 'video', '0', '170');
INSERT INTO phpbb_bbc_box VALUES (18, 'stream', '1', '0', 'stream', 'stream', 'stream', 'stream', '0', '180');
INSERT INTO phpbb_bbc_box VALUES (19, 'real', '1', '0', 'ram width=220 height=140', 'ram', 'real', 'real', '0', '190');
INSERT INTO phpbb_bbc_box VALUES (20, 'quick', '1', '0', 'quick width=480 height=224', 'quick', 'quick', 'quick', '1', '200');
INSERT INTO phpbb_bbc_box VALUES (21, 'sup', '1', '0', 'sup', 'sup', 'sup', 'sup', '0', '210');
INSERT INTO phpbb_bbc_box VALUES (22, 'sub', '1', '0', 'sub', 'sub', 'sub', 'sub', '1', '220');
INSERT INTO phpbb_bbc_box (bbc_name, bbc_value, bbc_auth, bbc_before, bbc_after, bbc_helpline, bbc_img, bbc_divider) VALUES ('youtube', '1', '0', 'youtube', 'youtube', 'youtube', 'youtube', '0');

# -- bbc box config
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_box_on', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_advanced', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_per_row', '14');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_time_regen', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bbc_style_path', 'default');

# -- requete confirmation ecrite

INSERT INTO `phpbb_config` VALUES ('question_conf', 'Combien font 6 + 2 ? la réponse doit être écrite en toute lettre');
INSERT INTO `phpbb_config` VALUES ('question_conf_enable', '0');
INSERT INTO `phpbb_config` VALUES ('reponse_conf', 'huit');
ALTER TABLE phpbb_users ADD reponse_conf VARCHAR(255) AFTER username;

# -- Mod Quick reply

INSERT INTO phpbb_config (config_name, config_value) VALUES ('users_qp_settings', '1-0-1-1-1-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anons_qp_settings', '1-0-1-1-1-1');
ALTER TABLE phpbb_forums ADD forum_qpes tinyint(1) DEFAULT '1' NOT NULL; 
ALTER TABLE phpbb_users ADD user_qp_settings varchar(25) DEFAULT '0' NOT NULL; 
UPDATE phpbb_users SET user_qp_settings = '1-0-1-1-1-1' WHERE user_qp_settings = '0';

ALTER TABLE phpbb_forums ADD auth_download TINYINT(2) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_auth_access ADD auth_download TINYINT(1) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_posts ADD post_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_topics ADD topic_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_privmsgs ADD privmsgs_attachment TINYINT(1) DEFAULT '0' NOT NULL;

# -- attachments_config

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_dir','files');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_img','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('topic_icon','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('display_order','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize','262144');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_quota','52428800');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize_pm','262144');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments','3');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments_pm','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('disable_mod','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_pm_attach','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_topic_review','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_ftp_upload','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('show_apcp','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attach_version','2.4.5');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_upload_quota', '0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_pm_quota', '0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_server','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('download_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_user','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pass','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pasv_mode','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_display_inlined','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_create_thumbnail','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_min_thumb_filesize','12000');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_imagick', '');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('use_gd2','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('wma_autoplay','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('flash_autoplay','0');

# -- forbidden_extensions


INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (1,'php');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (2,'php3');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (3,'php4');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (4,'phtml');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (5,'pl');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (6,'asp');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (7,'cgi');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (8,'php5');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (9,'php6');

# -- extension_groups

INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (1,'Images',1,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (2,'Archives',0,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (3,'Plain Text',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (4,'Documents',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (5,'Real Media',0,0,2,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (6,'Streams',2,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (7,'Flash Files',3,0,1,'',0,'');

# -- extensions

INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (1, 1,'gif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (2, 1,'png', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (3, 1,'jpeg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (4, 1,'jpg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (5, 1,'tif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (6, 1,'tga', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (7, 2,'gtar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (8, 2,'gz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (9, 2,'tar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (10, 2,'zip', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (11, 2,'rar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (12, 2,'ace', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (13, 3,'txt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (14, 3,'c', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (15, 3,'h', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (16, 3,'cpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (17, 3,'hpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (18, 3,'diz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (19, 4,'xls', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (20, 4,'doc', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (21, 4,'dot', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (22, 4,'pdf', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (23, 4,'ai', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (24, 4,'ps', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (25, 4,'ppt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (26, 5,'rm', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (27, 6,'wma', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (28, 7,'swf', '');

# -- default quota limits

INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (1, 'Low', 262144);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (2, 'Medium', 2097152);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (3, 'High', 5242880);

# -- banlist

INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (1, 0, '', '*@francite.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (2, 0, '', '*@quebecemail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (3, 0, '', '*@imel.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (4, 0, '', '*@passport.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (5, 0, '', '*@lavache.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (6, 0, '', '*@tycwao.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (7, 0, '', '*@yandex.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (8, 0, '', '*@yahoo.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (9, 0, '', '*@fuckfreetits.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (10, 0, '', '*@hack.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (11, 0, '', '*@girlstitsfree.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (12, 0, '', '*@pornoamateurtits.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (13, 0, '', '*@porno.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (14, 0, '', '*@porno.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (15, 0, '', '*@mail.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (16, 0, '', '*@list.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (17, 0, '', '*@bk.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (18, 0, '', '*@inbox.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (19, 0, '', '*@gratimail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (20, 0, '', '*@meloo.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (21, 0, '', '*@bluebottle.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (22, 0, '', '*@jetable.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (23, 0, '', '*@jetable.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (24, 0, '', '*@porno.free');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (25, 0, '', '*@porno.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (26, 0, '', '*@lycos.de');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (27, 0, '', '*@gmail.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (28, 0, '', '*@mail15.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (29, 0, '', '*@cashette.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (30, 0, '', '*@mail333.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (31, 0, '', '*@fromru.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (32, 0, '', '*@pochta.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (33, 0, '', '*@hotbox.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (34, 0, '', '*@good-realty.msk.su');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (35, 0, '', '*@gawab.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (36, 0, '', '*@bigmailbox.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (37, 0, '', '*@buzlas.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (38, 0, '', '*@fr.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (39, 0, '', '*@tpg.com.au');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (40, 0, '', '*@usermail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (41, 0, '', '*@bigmailbox.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (42, 0, '', '*@berahe.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (43, 0, '', '*@rotover.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (44, 0, '', '*@sibmail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (45, 0, '', '*@icrot.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (46, 0, '', '*@porno.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (47, 0, '', '*@porno.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (48, 0, '', '*@porno.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (49, 0, '', '*@xyonline.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (50, 0, '', '*@techemail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (51, 0, '', '*@yourmedserv.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (52, 0, '', '*@iqsearch.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (53, 0, '', '*@finance-here.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (54, 0, '', '*@bekiso.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (55, 0, '', '*@bigfatsearch.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (56, 0, '', '*@btinternet.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (57, 0, '', '*@cvg8hette.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (58, 0, '', '*@cute-boys.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (59, 0, '', '*@fresh-news.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (60, 0, '', '*@girlmail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (61, 0, '', '*@goolook.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (62, 0, '', '*@medafo.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (63, 0, '', '*@bazehost.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (64, 0, '', '*@wxxx.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (65, 0, '', '*@a.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (66, 0, '', '*@inmail24.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (67, 0, '', '*@ither.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (68, 0, '', '*@nfomoz.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (69, 0, '', '*@host.sk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (70, 0, '', '*@infomoz.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (71, 0, '', '*@fin-fin.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (72, 0, '', '*@vip2fatal.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (73, 0, '', '*@mail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (74, 0, '', '*@slot.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (75, 0, '', '*@gmail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (76, 0, '', '*@online-search-casino.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (77, 0, '', '*@xxx-search.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (78, 0, '', '*@youremailsoftware.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (79, 0, '', '*@dotfreeemail.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (80, 0, '', '*@fatal-job.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (81, 0, '', '*@freehardcorevideo.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (82, 0, '', '*@*.com.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (83, 0, '', '*@*.jp');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (84, 0, '', '*@*.kr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (85, 0, '', '*@*.ro');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (86, 0, '', '*@*.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (87, 0, '', '*@*.yu');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (88, 0, '', '*@*.1go.dk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (89, 0, '', '*@*.cnnty.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (90, 0, '', '*@*.dasyt.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (91, 0, '', '*@*.knoll-lumber.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (92, 0, '', '*@*.osarex.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (93, 0, '', '*@*.pidor.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (94, 0, '', '*@*.regvista.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (95, 0, '', '*@*.sexwwwinfo.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (96, 0, '', '*@1go.dk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (97, 0, '', '*@anonymous*.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (98, 0, '', '*@bigfreemail.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (99, 0, '', '*@bigmir.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (100, 0, '', '*@cnnty.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (101, 0, '', '*@dar-vocet.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (102, 0, '', '*@dasyt.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (103, 0, '', '*@diem-perdidi.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (104, 0, '', '*@diplomy.com.ua');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (105, 0, '', '*@dodgeit.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (106, 0, '', '*@doh75.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (107, 0, '', '*@drugs-online.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (108, 0, '', '*@email.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (109, 0, '', '*@ephemail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (110, 0, '', '*@ephemail.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (111, 0, '', '*@ephemail.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (112, 0, '', '*@foryou74.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (113, 0, '', '*@foteret.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (114, 0, '', '*@freenet.de');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (115, 0, '', '*@gewhiz1.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (116, 0, '', '*@haltospam.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (117, 0, '', '*@haltospam.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (118, 0, '', '*@haltospam.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (119, 0, '', '*@haltospam.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (120, 0, '', '*@jetable.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (121, 0, '', '*@justopt.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (122, 0, '', '*@kasmail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (123, 0, '', '*@kg.sbb.co.yu');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (124, 0, '', '*@lwz.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (125, 0, '', '*@mail.ro');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (126, 0, '', '*@mamiev.com.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (127, 0, '', '*@masterbell.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (128, 0, '', '*@microolap.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (129, 0, '', '*@moo321.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (130, 0, '', '*@netcourrier.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (132, 0, '', '*@nil-admirari.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (133, 0, '', '*@osarex.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (134, 0, '', '*@pills-search.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (135, 0, '', '*@play-sex-game.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (136, 0, '', '*@poker.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (137, 0, '', '*@poolmail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (138, 0, '', '*@pornoroxx.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (139, 0, '', '*@pu-blocker.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (140, 0, '', '*@qsrch.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (141, 0, '', '*@rbc.ru');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (142, 0, '', '*@regvista.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (143, 0, '', '*@sexcom-xxx.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (144, 0, '', '*@sexwwwinfo.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (145, 0, '', '*@spamday.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (146, 0, '', '*@spamgourmet.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (147, 0, '', '*@spamgourmet.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (148, 0, '', '*@spamgourmet.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (149, 0, '', '*@splitcamera.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (150, 0, '', '*@straightedgeonline.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (151, 0, '', '*@tempus-fugit.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (152, 0, '', '*@tierramedia.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (153, 0, '', '*@ukr.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (154, 0, '', '*@ultrid.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (155, 0, '', '*@vidihol.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (156, 0, '', '*@wormx-crew.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (157, 0, '', '*@xxx-news.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (158, 0, '', '*@zeebede.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (159, 0, '', '*@ziplip.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (160, 0, '', '*@onlymail2007.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (161, 0, '', '*@tipro.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (162, 0, '', '*@menja.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (163, 0, '', '*@s*.onlinehome.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (164, 0, '', '*@lycos.co.uk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (165, 0, '', '*@gmail.de');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (166, 0, '', '*@gmail.uk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (167, 0, '', '*@fortnox.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (168, 0, '', '*@mail.voila.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (169, 0, '', '*@fairesuivre.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (170, 0, '', '*@pochtamt.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (171, 0, '', '*@fhgate.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (172, 0, '', '*@gala.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (173, 0, '', '*@gm6.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (174, 0, '', '*@*.cn');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (175, 0, '', '*@*.asso.ws');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (176, 0, '', '*@*.be.tf');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (177, 0, '', '*@*.best.cd');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (178, 0, '', '*@*.bsd-fan.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (179, 0, '', '*@*.c0m.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (180, 0, '', '*@*.c0m.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (181, 0, '', '*@*.ca.tc');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (182, 0, '', '*@*.clan.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (183, 0, '', '*@*.com02.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (184, 0, '', '*@*.com4.ws');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (185, 0, '', '*@*.corps.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (186, 0, '', '*@*.euro.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (187, 0, '', '*@*.euro.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (188, 0, '', '*@*.euro.tm');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (189, 0, '', '*@*.fr.fm');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (190, 0, '', '*@*.fr.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (191, 0, '', '*@*.fr.vu');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (192, 0, '', '*@*.gr.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (193, 0, '', '*@*.ht.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (194, 0, '', '*@*.int.ms');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (195, 0, '', '*@*.it.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (196, 0, '', '*@*.java-fan.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (197, 0, '', '*@*.linux-fan.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (198, 0, '', '*@*.mac-fan.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (199, 0, '', '*@*.mp3.ms');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (200, 0, '', '*@*.mp3.ms');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (201, 0, '', '*@*.n0n.be');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (202, 0, '', '*@*.perso.tc');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (203, 0, '', '*@*.perso.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (204, 0, '', '*@*.perso.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (205, 0, '', '*@*.qc.tc');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (206, 0, '', '*@*.sg.gg');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (207, 0, '', '*@*.site.tc');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (208, 0, '', '*@*.societe.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (209, 0, '', '*@*.sp.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (210, 0, '', '*@*.suisse.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (211, 0, '', '*@*.t2u.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (212, 0, '', '*@*.unixlover.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (213, 0, '', '*@*.wb.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (214, 0, '', '*@*.zik.mut');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (215, 0, '', '*@amazing.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (216, 0, '', '*@ambitious.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (217, 0, '', '*@attractive.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (218, 0, '', '*@australian.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (219, 0, '', '*@batty.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (220, 0, '', '*@brilliant.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (221, 0, '', '*@british.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (222, 0, '', '*@c0m.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (223, 0, '', '*@c0m.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (224, 0, '', '*@ca.gg');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (225, 0, '', '*@ca.tc');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (226, 0, '', '*@celebrity.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (227, 0, '', '*@cheeky.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (228, 0, '', '*@clan.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (229, 0, '', '*@com02.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (230, 0, '', '*@com4.ws');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (231, 0, '', '*@confident.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (232, 0, '', '*@cool.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (233, 0, '', '*@corps.st');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (234, 0, '', '*@crap.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (235, 0, '', '*@dangerous.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (236, 0, '', '*@daring.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (237, 0, '', '*@dead.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (238, 0, '', '*@deadly.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (239, 0, '', '*@disgusting.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (240, 0, '', '*@drunk.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (241, 0, '', '*@fantastic.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (242, 0, '', '*@flash.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (243, 0, '', '*@evil.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (244, 0, '', '*@funky.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (245, 0, '', '*@gorgeous.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (246, 0, '', '*@insane.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (247, 0, '', '*@invincible.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (248, 0, '', '*@juicy.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (249, 0, '', '*@official.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (250, 0, '', '*@popular.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (251, 0, '', '*@religious.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (252, 0, '', '*@xdir.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (253, 0, '', '*@xdir.fr');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (254, 0, '', '*@hotpop.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (256, 0, '', '*@1and1.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (257, 0, '', '*@web.de');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (258, 0, '', '*@uaxc.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (259, 0, '', '*@*.info');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (260, 0, '', '*@vzxi.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (261, 0, '', '*@rpfhwrihwiruhw432.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (262, 0, '', '*@uixj.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (263, 0, '', '*@domain*.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (264, 0, '', '*@pet.us');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (265, 0, '', '*@ovxe.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (266, 0, '', '*@xqce.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (267, 0, '', '*@qkmv.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (268, 0, '', '*@best-finance.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (269, 0, '', '*@bestboyfilms.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (270, 0, '', '*@mature-bondage.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (271, 0, '', '*@telegraf.by');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (272, 0, '', '*@ifrance.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (273, 0, '', '*@alsado.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (274, 0, '', '*@econudeworld.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (275, 0, '', '*@tut.by');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (276, 0, '', '*@cracklord.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (277, 0, '', '*@anticheba.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (278, 0, '', '*@*.as');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (279, 0, '', '*@xpescripu.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (280, 0, '', '*@xnail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (281, 0, '', '*@maila.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (282, 0, '', '*@mymail-in.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (283, 0, '', '*@xonline.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (284, 0, '', '*@nerdshack.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (285, 0, '', '*@s-mail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (286, 0, '', '*@zqwe.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (287, 0, '', '*@kisenfad.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (288, 0, '', '*@ocvbore.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (289, 0, '', '*@drugscheap.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (290, 0, '', '*@pharmbuy.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (291, 0, '', '*@gmx.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (292, 0, '', '*@picspics.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (293, 0, '', '*@kvado.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (294, 0, '', '*@anymail.net');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (295, 0, '', '*@junglesite.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (296, 0, '', '*@greatemailaddress.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (297, 0, '', '*@ecarta.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (298, 0, '', '*@putoncondoms.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (299, 0, '', '*@astrolgical-fortune.co.uk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (300, 0, '', '*@yvyl.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (301, 0, '', '*@hostidmai1w.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (302, 0, '', '*@siteboxes.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (303, 0, '', '*@themailcontact.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (304, 0, '', '*@themailadresses.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (305, 0, '', '*@freemailnow.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (306, 0, '', '*@freebibblemail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (307, 0, '', '*@freetechemail.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (308, 0, '', '*@domaine226.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (309, 0, '', '*@inbox.lv');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (310, 0, '', '*@hoodialife.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (311, 0, '', '*@pochta.ws');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (312, 0, '', '*@mail.uz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (313, 0, '', '*@fateback.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (314, 0, '', '*@meta.ua');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (315, 0, '', '*@xm1.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (316, 0, '', '*@movieserv.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (317, 0, '', '*@mylove-mail.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (318, 0, '', '*@gh208hsd8gh.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (319, 0, '', '*@kenw.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (320, 0, '', '*@fastmessage.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (321, 0, '', '*@finance-on-line.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (322, 0, '', '*@sofxo.pl');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (323, 0, '', '*@jolinsm.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (324, 0, '', '*@refinancce.biz');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (325, 0, '', '*@znahov.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (326, 0, '', '*@yahoo.co.uk');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (327, 0, '', '*@genericpharmacydrug.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (328, 0, '', '*@me.by');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (329, 0, '', '*@somadrug.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (330, 0, '', '*@voltaren.org');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (331, 0, '', '*@maElCnB.com');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (332, 0, '', '*@o2.pl');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (333, 0, '', '*@gawab.comi');
INSERT INTO phpbb_banlist (ban_id, ban_userid, ban_ip, ban_email) VALUES (334, 0, '', '*@baycip.org');


# Mod points system

ALTER TABLE phpbb_forums ADD points_disabled TINYINT(1) NOT NULL AFTER prune_enable;
ALTER TABLE  phpbb_users ADD user_notify_donation TINYINT(1) NOT NULL AFTER user_notify_pm;
ALTER TABLE  phpbb_users ADD user_points INT NOT NULL;
ALTER TABLE  phpbb_users ADD admin_allow_points TINYINT(1) DEFAULT '1' NOT NULL;
INSERT INTO phpbb_config VALUES ('points_reply', '1');
INSERT INTO phpbb_config VALUES ('points_topic', '2');
INSERT INTO phpbb_config VALUES ('points_page', '1');
INSERT INTO phpbb_config VALUES ('points_post', '1');
INSERT INTO phpbb_config VALUES('points_browse', '1');
INSERT INTO phpbb_config VALUES ('points_donate', '1');
INSERT INTO phpbb_config VALUES ('points_name', 'Points');
INSERT INTO phpbb_config VALUES ('points_user_group_auth_ids', '');
INSERT INTO phpbb_config VALUES ('points_system_version', '2.1.1');

# Mod online-Offline

ALTER TABLE phpbb_themes ADD online_color varchar(6) DEFAULT '008500' NOT NULL;
ALTER TABLE phpbb_themes ADD offline_color varchar(6) DEFAULT 'DF0000' NOT NULL;
ALTER TABLE phpbb_themes ADD hidden_color varchar(6) DEFAULT 'EBD400' NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('online_time', '60');

# -- Mod avatar par défault

INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_guests_url', 'templates/subSilver/images/guest_avatar.gif');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_users_url', 'templates/subSilver/images/no_avatar.gif');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('default_avatar_set', '3');



# -- RCS 1.0.5

INSERT INTO phpbb_rcs VALUES (1, 'Administrator', 'CC0000', 0, 0, 10);
ALTER TABLE phpbb_groups ADD group_color mediumint(8) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_color mediumint(8) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_group_id mediumint(8) NOT NULL DEFAULT '0';
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cache_rcs', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_level_admin', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_level_mod', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('rcs_ranks_stats', '1');
ALTER TABLE phpbb_themes ADD rcs_admincolor varchar(6) NOT NULL DEFAULT '';
ALTER TABLE phpbb_themes ADD rcs_modcolor varchar(6) NOT NULL DEFAULT '';
ALTER TABLE phpbb_themes ADD rcs_usercolor varchar(6) NOT NULL DEFAULT '';
UPDATE phpbb_themes SET rcs_admincolor = 'FFA34F';
UPDATE phpbb_themes SET rcs_modcolor = '006600';
UPDATE phpbb_themes SET rcs_usercolor = '006699';

# -- Portal gf 1.2.1

INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('welcome_text', 'Bienvenue sur la version de portail : <b>Gf-Portail</b>.<br/>Vous pouvez changer ce message dans la configuration générale du portail.<br/>Ce portail est entièrement <b>paramétrable</b> depuis l\'ACP.<br/>J\'espère qu\'il vous plaîra.<br/><i>Giefca</i>');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('number_of_news', '4');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('news_length', '200');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('news_forum', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('poll_id', '');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('forum_header', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('space_row', '3');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('space_col', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col1_size', '20');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col1_unit', 'percent');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col2_size', '60');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col2_unit', 'percent');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col3_size', '20');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('col3_unit', 'percent');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('bodyline', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('head_out_bodyline', '0');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('foot_out_bodyline', '0');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('guest_avatar', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('simple_welcome', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('number_recent_topics', '10');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('scrolling_topics', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('scroll_height', '200');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('scroll_up', '1');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('scroll_delay', '100');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('scroll_step', '2');
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('default_struct', '1') ;
INSERT INTO phpbb_portal (portal_name, portal_value) VALUES ('gf_version', '1.2.1');

INSERT INTO phpbb_portal_links ( link_url, link_text, link_img, link_active ) VALUES ('http://www.ezcom-fr.com', 'Ezcom', 'images/ezcom.gif', 1);

INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'bienvenue');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'liens');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'login');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'menu');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'news');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'sondage');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'statistiques');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'welcome');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'whoisonline');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'entete');
INSERT INTO phpbb_portal_mod ( mod_name ) VALUES ( 'recent_topics');

INSERT INTO phpbb_portal_page (page_id, page_desc) VALUES(1, 'page principale');

INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 1, 2, 1);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 2, 1, 2);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 3, 3, 2);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 4, 1, 1);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 5, 2, 2);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 6, 1, 4);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 7, 1, 3);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 8, 3, 1);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 9, 3, 9);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 10, 0, 1);
INSERT INTO phpbb_portal_struct ( page_id, mod_id, struct_col, struct_order) VALUES ( 1, 11, 3, 8);

INSERT INTO phpbb_portal ( portal_name , portal_value ) VALUES ('default_mennav', '1');
INSERT INTO phpbb_portal_navmen ( menu_id , menu_desc ) VALUES (1, 'Menu principal');

INSERT INTO `phpbb_portal_navig` VALUES (1, 1, '', 'Menu', '', '', 0, '', '', 0, 1, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (2, 4, 'Home', '', 'portal.php', '', 1, '', 'images/menu/menu_home.png', 16, 2, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (3, 4, 'FAQ', '', 'faq.php', '', 1, '', 'images/menu/menu_faq.png', 16, 5, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (4, 4, 'Forum', '', 'index.php', '', 1, '', 'images/menu/menu_forum.png', 16, 3, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (5, 4, 'Search', '', 'search.php', '', 1, '', 'images/menu/menu_search.png', 16, 4, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (6, 4, 'Memberlist', '', 'memberlist.php', '', 1, '', 'images/menu/menu_memberlist.png', 16, 6, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (7, 4, 'Usergroups', '', 'groupcp.php', '', 1, '', 'images/menu/menu_groups.png', 16, 7, 0, 0, 0, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (8, 4, 'Private_Messaging', '', 'privmsg.php', '', 1, '', 'images/menu/menu_pm.png', 16, 9, 0, 0, 1, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (9, 4, 'Profile', '', 'profile.php?mode=editprofile', '', 1, '', 'images/menu/menu_profile.png', 16, 7, 0, 0, 1, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (10, 4, 'Login', '', 'login.php', '', 1, '', 'images/menu/menu_login.png', 16, 8, 0, 0, -1, 1, '', 1);
INSERT INTO `phpbb_portal_navig` VALUES (11, 4, 'Logout', '', 'login.php?logout=true', '', 1, '', 'images/menu/menu_logout.png', 16, 11, 0, 0, 1, 1, '', 1);
INSERT INTO `phpbb_portal_navig` VALUES (12, 2, '', '', '', '', 0, '', '', 0, 13, 0, 0, 5, 1, '', 0);
INSERT INTO `phpbb_portal_navig` VALUES (13, 4, 'Admin', '', 'admin/index.php', '', 1, '', 'images/menu/menu_acp.png', 16, 14, 0, 0, 5, 1, '', 1);
INSERT INTO `phpbb_portal_navig` VALUES (14, 4, 'Register', '', 'profile.php?mode=register', '', 1, '', 'images/menu/menu_register.png', 16, 12, 0, 0, -1, 1, '', 0);


ALTER TABLE phpbb_vote_desc ADD vote_max INT( 3 ) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_voted INT( 7 ) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_hide TINYINT( 1 ) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_undo TINYINT ( 1 ) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_voters ADD vote_option_id TINYINT( 4 ) DEFAULT '-1' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('images_max_size', '400');

INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('vault_loan_enable', 1);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('interests_rate', 4);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('interests_time', 86400);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('loan_interests', 15);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('loan_interests_time', 864000);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('loan_max_sum', 5000);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('loan_requirements', 0);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('stock_max_change', 10);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('stock_min_change', 0);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('base_amount', 10);
INSERT INTO phpbb_vault_general (config_name, config_value) VALUES ('num_items', 30);

INSERT INTO phpbb_vault_exchange (stock_id, stock_name, stock_desc, stock_price, stock_previous_price, stock_best_price, stock_worst_price) VALUES (1, 'Vault_action_name_1', 'Vault_action_desc_1', 100, 100, 100, 100);
INSERT INTO phpbb_vault_exchange (stock_id, stock_name, stock_desc, stock_price, stock_previous_price, stock_best_price, stock_worst_price) VALUES (2, 'Vault_action_name_2', 'Vault_action_desc_2', 200, 200, 200, 200);
INSERT INTO phpbb_vault_exchange (stock_id, stock_name, stock_desc, stock_price, stock_previous_price, stock_best_price, stock_worst_price) VALUES (3, 'Vault_action_name_3', 'Vault_action_desc_3', 300, 300, 300, 300);

INSERT INTO phpbb_config (config_name, config_value) VALUES ('vault_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vault_name', 'Vault');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_use', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_time', '86400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('stock_last_change', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vault_display_profile', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vault_display_topics', '0');

ALTER TABLE phpbb_users ADD user_cell_time INT(11) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_time_judgement INT(11) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_caution INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_sentence TEXT DEFAULT '';
ALTER TABLE phpbb_users ADD user_cell_enable_caution INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_enable_free INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_celleds INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_cell_punishment TINYINT(1) DEFAULT '0' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_allow_display_bars', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_allow_display_celleds', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_allow_user_caution', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_allow_user_judge', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_allow_user_blank', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_amount_user_blank', '5000');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_user_judge_voters', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cell_user_judge_posts', '2');

ALTER TABLE phpbb_users ADD user_boulet VARCHAR(255) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_vote_voters ADD vote_cast TINYINT( 4 ) DEFAULT '0' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('sub_title_length', '100');
ALTER TABLE phpbb_posts_text ADD post_sub_title VARCHAR(255) DEFAULT NULL;
ALTER TABLE phpbb_topics ADD topic_sub_title VARCHAR(255) DEFAULT NULL;

ALTER TABLE phpbb_forums ADD COLUMN forum_color varchar(6) DEFAULT '' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('smilies_colonne', 4);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('smilies_ligne', 5);

ALTER TABLE phpbb_users ADD user_inactive_emls TINYINT( 1 ) NOT NULL ;
ALTER TABLE phpbb_users ADD user_inactive_last_eml INT( 11 ) NOT NULL ;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('removed_users', '0') ;


INSERT INTO phpbb_arcade_categories(arcade_catid, arcade_cattitle, arcade_catorder) VALUES (1, 'Les jeux du forums', 1);

INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('version_arcade','Pro.3.0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_category_mod','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('category_preview_games','2');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('games_par_page','10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('game_order','Fixed');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('display_winner_avatar','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('stat_par_page','10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('winner_avatar_position','left');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('winner_ultime_avatar_position','left');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('maxsize_avatar','200');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('linkcatittle_align','2');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('linkcat_align','2');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('limit_by_posts','0'); 
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('limit_type','date'); 
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('posts_needed','15'); 
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('days_limit','4'); 
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('rating_max', '10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_arcade_vote', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_mod','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_pay_mod','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_win_mod','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_pay_charging','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_pay_submit','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('points_winner','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('points_pay','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_fav_category', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('nbr_games_fav', '-1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_hide_fav', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('fav_nbr_in_page', '10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('pay_all_games', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('prize_all_games', '');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('quota_games', '');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('game_pres', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('present_fid', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('auths_play', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('auths_score', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('auths_vote', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('auths_vote_hidden', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_one', '30');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_two', '19');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_three', '18');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_four', '17');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_five', '16');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_six', '15');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_seven', '14');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_eight', '13');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_nine', '12');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_ten', '11');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_eleven', '10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_twelve', '9');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_thirteen', '8');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_fourteen', '7');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_fiveteen', '6');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_sixteen', '5');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_seventeen', '4');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_eighteen', '3');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_nineteen', '2');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_points_twenty', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_cat','');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_un','40');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_deux','20');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_trois','10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_quatre','9');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_cinq','6');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_six','5');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_sept','4');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_huit','3');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_neuf','2');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('championnat_taux_dix','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('cat_use','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_cagnotte_mod','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_points_cagnotte','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('cagnotte','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('day_distrib','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('date_distribcagnotte','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('use_auto_distrib','0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('champ_see','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('heading_see','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('topstats_see','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('whoisplay_see','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('cat_see', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('favoris_see','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('champ_seeg','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('heading_seeg','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('topstats_seeg','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('whoisplay_seeg','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('cat_seeg', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('favoris_seeg','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('scorerow_position','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('message_pres','1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('games_time_tolerance', '10');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('games_cheater_submit', '1');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('color_use', '0');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('color_admin', 'FF0000');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('color_mod', '00FF00');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('color_user', '0000FF');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('page_guest_admin', '50');
INSERT INTO phpbb_arcade (arcade_name, arcade_value) VALUES('display_ultime_winner_avatar', '1');

ALTER TABLE phpbb_users ADD `user_nb_game` int(3) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD `user_date_game` varchar (255) DEFAULT '0' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_bbcode','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_guest','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_guest_view','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_delete','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_delete_all','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_edit','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_edit_all','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_allow_smilies','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_banned_user_id','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_banned_user_id_view','');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_count_msg','10000');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_date_format','|d M Y| H:i');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_date_on','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_delete_days','30');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_height','170');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_links_names','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_make_links','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_messages_number_on_index', '20');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_on','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_refresh_time', '120');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_text_lenght','500');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_width','100%');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('shoutbox_word_lenght','90');

## APRES VERSION 1.0.0

INSERT INTO phpbb_config (config_name, config_value) VALUES ('annonce_globale_index', '1');
ALTER TABLE phpbb_auth_access ADD auth_global_announce TINYINT(1) NOT NULL AFTER auth_announce;
ALTER TABLE phpbb_forums ADD auth_global_announce TINYINT(2) NOT NULL DEFAULT '5' AFTER auth_announce;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('last_topic_title_length', '25');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('activeportail','1');

INSERT INTO phpbb_config VALUES ('board_disable_msg', 'Le forum est fermé. Revenez plus tard. Merci');

ALTER TABLE phpbb_groups ADD group_salary INT(8) NOT NULL DEFAULT 100 ;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('groups_salary_cron_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('groups_salary_cron_time', '86400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('groups_salary_cron_last_time', '0');

ALTER TABLE phpbb_users ADD user_warn INT( 2 ) NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('card_max', '4');

INSERT INTO `phpbb_config` VALUES ('allow_medal_display', '0');
INSERT INTO `phpbb_config` VALUES ('medal_display_row', '1');
INSERT INTO `phpbb_config` VALUES ('medal_display_col', '1');
INSERT INTO `phpbb_config` VALUES ('medal_display_width', '');
INSERT INTO `phpbb_config` VALUES ('medal_display_height', '');
INSERT INTO `phpbb_config` VALUES ('medal_display_order', '');
INSERT INTO `phpbb_medal_cat` VALUES ('1', 'Default', '10');

ALTER TABLE phpbb_users ADD user_sponsor_id INT(8) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_sponsor_gain INT(11) DEFAULT '0' NOT NULL;

INSERT INTO phpbb_config (config_name, config_value) VALUES ('sponsor_enabled', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sponsor_points_enabled', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sponsor_gain_first', '150');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sponsor_gain_second', '30');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('sponsor_points_gain', '10');

ALTER TABLE `phpbb_users` ADD `user_mood_mod` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `phpbb_posts` ADD `poster_mood` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE phpbb_forums ADD forum_enter_limit MEDIUMINT(8) unsigned default '0';

INSERT INTO phpbb_config (config_name, config_value) VALUES ('join_interval', '18');




## MISE A JOUR EXTREME MOD Version 1.0.2

UPDATE phpbb_config SET config_value = '1.6.1a' WHERE config_name = 'qte_version';

ALTER TABLE phpbb_attributes ADD attribute_type SMALLINT(1) NOT NULL DEFAULT '0' AFTER attribute_id;
ALTER TABLE phpbb_attributes ADD attribute_image VARCHAR(255) NOT NULL DEFAULT '' AFTER attribute;

ALTER TABLE phpbb_topics DROP topic_attribute;
ALTER TABLE phpbb_topics DROP topic_attribute_color;
ALTER TABLE phpbb_topics DROP topic_attribute_position;
ALTER TABLE phpbb_topics DROP topic_attribute_username;
ALTER TABLE phpbb_topics DROP topic_attribute_date;

ALTER TABLE phpbb_topics ADD topic_attribute VARCHAR(25);

INSERT INTO phpbb_config (config_name, config_value) VALUES ('last_topic_title_redirect', '0');
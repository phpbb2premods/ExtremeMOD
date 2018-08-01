<?php

/***************************************************************************
 *                            lang_admin.php [french]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2004 PhpBB France
 *
 *     $Id: lang_admin.php
 *
 ****************************************************************************/

/***************************************************************************
 *   English
 *   --------
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   Francais
 *   ----------
 *   Ce programme est un logiciel libre; vous pouvez les redistribuer
 *   et/ou le modifier tel que le pr�voit la license GNU General Public License
 *   (GNU/GPL) publi�e par la Fondation des logiciels libres (Free Software Foundation)
 *   Est appliqu�e la version 2 de la licence ou n'importe qu'elle version ant�rieure
 *   de votre choix.
 *
 ***************************************************************************/

//
// Traduction : phpBB France (http://www.phpbbfrance.org/)
//

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Nombre de tentatives de connexion autoris�es';
$lang['Max_login_attempts_explain'] = 'Nombre maximum de tentatives de connexion qui, s\'il est d�pass�, bloquera l\'utilisateur pendant le temps d�fini ci dessous.';
$lang['Login_reset_time'] = 'Temps de blocage';
$lang['Login_reset_time_explain'] = 'Nombre de minutes durant lesquelles l\'utilisateur ayant d�pass� le nombre de tentatives de connexions autoris�es devra patienter pour pouvoir se connecter de nouveau.';

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Administration g�n�rale';
$lang['Users'] = 'Administration des utilisateurs';
$lang['Groups'] = 'Administration des groupes';
$lang['Forums'] = 'Administration des forums';
$lang['Styles'] = 'Administration des th�mes';

$lang['Configuration'] = 'Configuration';
$lang['Permissions'] = 'Permissions';
$lang['Manage'] = 'Gestion';
$lang['Disallow'] = 'Contr�le des noms interdits';
$lang['Prune'] = 'D�lester';
$lang['Mass_Email'] = 'E-Mails multiples';
$lang['Ranks'] = 'Rangs';
$lang['Smilies'] = 'Emotic�nes';
$lang['Ban_Management'] = 'Contr�le des exclusions';
$lang['Word_Censor'] = 'Censure';
$lang['Export'] = 'Exporter';
$lang['Create_new'] = 'Cr�er';
$lang['Add_new'] = 'Ajouter';
$lang['Backup_DB'] = 'Sauvegarder la base de donn�es';
$lang['Restore_DB'] = 'Restaurer la base de donn�es';


//
// Index
//
$lang['Admin'] = 'Administration';
$lang['Not_admin'] = 'Vous n\'�tes pas autoris� � administrer ce forum';
$lang['Welcome_phpBB'] = 'Bienvenue sur phpBB';
$lang['Admin_intro'] = 'Merci d\'avoir choisi phpBB comme syst�me de forum. Cette page vous donnera un rapide aper�u des statistiques de votre forum. Vous pouvez y revenir en cliquant sur le lien <u>Index de l\'Administration</u> sur le panneau de gauche. Pour revenir �  l\'index de votre forum, cliquez sur le logo phpBB, lui aussi situ� sur la panneau de gauche. Les autres liens situ�s �  gauche de cet �cran vous permettront de param�trer chaque aspect de votre forum. Chaque �cran contiendra des instructions concernant la mani�re d\'utiliser les outils qu\'il propose.';
$lang['Main_index'] = 'Index du forum';
$lang['Forum_stats'] = 'Statistiques du forum';
$lang['Admin_Index'] = 'Index de l\'administration';
$lang['Preview_forum'] = 'Aper�u du forum';

$lang['Click_return_admin_index'] = 'Cliquez %sici%s pour retourner �  l\'index d\'administration';

$lang['Statistic'] = 'Statistiques';
$lang['Value'] = 'Valeur';
$lang['Number_posts'] = 'Nombre de messages ';
$lang['Posts_per_day'] = 'Messages par jour ';
$lang['Number_topics'] = 'Nombre de sujets ';
$lang['Topics_per_day'] = 'Sujets par jour ';
$lang['Number_users'] = 'Nombre d\'utilisateurs ';
$lang['Users_per_day'] = 'Utilisateurs par jour ';
$lang['Board_started'] = 'Cr�ation du forum ';
$lang['Avatar_dir_size'] = 'Taille du dossier des avatars ';
$lang['Database_size'] = 'Taille de la base de donn�es ';
$lang['Gzip_compression'] ='Compression Gzip ';
$lang['Not_available'] = 'Indisponible';

$lang['ON'] = 'Activ�'; // This is for GZip compression
$lang['OFF'] = 'D�sactiv�'; 


//
// DB Utils
//
$lang['Database_Utilities'] = 'Utilitaires pour la base de donn�es';

$lang['Restore'] = 'Restaurer';
$lang['Backup'] = 'Sauvegarder';
$lang['Restore_explain'] = 'Cet utilitaire ex�cutera une restauration compl�te des tables phpBB � partir d\'un fichier. Si votre serveur le supporte, vous pouvez directement uploader un fichier compress� au format gzip. Il sera automatiquement d�compress�. <br /><b>Attention !</b> Cette op�ration �crasera toutes les donn�es existantes. Une restauration peut prendre un certain temps, veuillez patienter en restant sur cette page tant que l\'op�ration n\'est pas termin�e.';
$lang['Backup_explain'] = 'Cet utilitaire vous permet de sauvegarder toutes les donn�es relatives � phpBB. Si vous avez cr�� des tables additionnelles dans la m�me base de donn�es et que vous souhaitez les sauvegarder, entrez leurs noms s�par�s par une virgule dans la zone \'Tables Additionnelles\' ci-dessous. Si votre serveur le supporte, vous pouvez �galement compresser votre fichier de sauvegarde au format gzip  avant de le t�l�charger';
$lang['Backup_options'] = 'Options de sauvegarde';
$lang['Start_backup'] = 'D�marrer la sauvegarde';
$lang['Full_backup'] = 'Sauvegarde compl�te';
$lang['Structure_backup'] = 'Sauvegarde de la structure uniquement';
$lang['Data_backup'] = 'Sauvegarde des donn�es uniquement';
$lang['Additional_tables'] = 'Tables additionnelles';
$lang['Gzip_compress'] = 'Fichier compress� gzip';
$lang['Select_file'] = 'Choisissez un fichier';
$lang['Start_Restore'] = 'Commencer la restauration';

$lang['Restore_success'] = 'La base de donn�es a �t� restaur�e avec succ�s.<br /><br />Votre forum devrait �tre revenu dans l\'�tat dans lequel il �tait lors de la derni�re sauvegarde.';
$lang['Backup_download'] = 'Le t�l�chargement va d�marrer sous peu, attendez s\'il vous plait jusqu\'� ce qu\'il commence.';
$lang['Backups_not_supported'] = 'D�sol�, mais les sauvegardes de base de donn�es ne sont actuellement pas support�es par votre syst�me.';

$lang['Restore_Error_uploading'] = 'Erreur lors du transfert de votre fichier';
$lang['Restore_Error_filename'] = 'Probl�me sur le nom du fichier, essayez un autre fichier s\'il vous plait';
$lang['Restore_Error_decompress'] = 'Impossible de d�compresser le fichier gzip, essayez avec un fichier non compress� s\'il vous plait.';
$lang['Restore_Error_no_file'] = 'Aucun fichier n\'a �t� transf�r�';


//
// Auth pages
//
$lang['Select_a_User'] = 'Choisissez un utilisateur';
$lang['Select_a_Group'] = 'Choisissez un groupe';
$lang['Select_a_Forum'] = 'Choisissez un forum';
$lang['Auth_Control_User'] = 'Contr�le des permissions des utilisateurs'; 
$lang['Auth_Control_Group'] = 'Contr�le des permissions des groupes'; 
$lang['Auth_Control_Forum'] = 'Contr�le des permissions des forums'; 
$lang['Look_up_User'] = 'Rechercher un utilisateur'; 
$lang['Look_up_Group'] = 'Rechercher un groupe'; 
$lang['Look_up_Forum'] = 'Rechercher un forum'; 

$lang['Group_auth_explain'] = 'Cette page vous permet de modifier les permissions et statuts de mod�ration pour chaque groupe d\'utilisateurs. N\'oubliez pas qu\'en modifiant les permissions de groupe, certaines permissions individuelles peuvent toutefois permettre � un utilisateur d\'acc�der � un forum. Vous en serez inform�, le cas �ch�ant.';
$lang['User_auth_explain'] = 'Cette page vous permet de modifier les permissions et statuts de mod�ration pour chaque utilisateur. N\'oubliez pas qu\'en modifiant des permisions individuelles, certaines permissions de groupe peuvent toutefois permettre � un utilisateur d\'acc�der � un forum. Vous en serez inform� le cas �ch�ant.';
$lang['Forum_auth_explain'] = 'Cette page vous permet de modifier les permissions pour chaque forum. Vous disposez de deux modes : un mode simple et un mode avanc�. Le mode avanc� offre un plus grand choix de contr�les. N\'oubliez pas qu\'en modifiant les permissions des forums, les utilisateurs pourront en �tre affect�s.';

$lang['Simple_mode'] = 'Mode simple';
$lang['Advanced_mode'] = 'Mode avanc�';
$lang['Moderator_status'] = 'Statut des mod�rateurs';

$lang['Allowed_Access'] = 'Acc�s autoris�';
$lang['Disallowed_Access'] = 'Acc�s non autoris�';
$lang['Is_Moderator'] = 'Est mod�rateur';
$lang['Not_Moderator'] = 'N\'est pas mod�rateur';

$lang['Conflict_warning'] = 'Avertissement: Il y a un conflit d\'autorisation.';
$lang['Conflict_access_userauth'] = 'L\'utilisateur a toujours des droits d\'acc�s sur ce forum via les droits de groupe. Vous devriez peut �tre modifier les droits de groupe ou sortir l\'utilisateur du groupe afin de pr�venir tout acc�s au forum concern�. Les groupes accordant des droits (et les forums impliqu�s) sont indiqu�s ci-dessous.';
$lang['Conflict_mod_userauth'] = 'L\'utilisateur a toujours des droits de mod�ration pour ce forum via son groupe d\'appartenance. Vous devriez peut �tre modifier les droits de groupe ou sortir l\'utilisateur du groupe afin de pr�venir tout acc�s au forum concern�. Les groupes accordant des droits (et les forums impliqu�s) sont indiqu�s ci-dessous.';

$lang['Conflict_access_groupauth'] = 'L\'utilisateur concern� a toujours des droits d\'acc�s au forum via ses param�tres d\'autorisation. Vous devriez peut �tre modifier ses param�tres d\'autorisation pour lui emp�cher d\avoir des droits d\acc�s. Les droits d\'acc�s utilisateur (et les forums concern�s) sont indiqu�s ci-dessous.';
$lang['Conflict_mod_groupauth'] = 'L\'utilisateur suivant poss�de toujours des droits de mod�ration sur le forum via ses param�tre d\'autorisation. Vous devriez peut �tre modifier ses param�tres d\'autorisation pour lui emp�cher d\'avoir des droits d\'acc�s. Les droits d\'acc�s utilisateur (et les forums concern�s) sont indiqu�s ci-dessous.';

$lang['Public'] = 'Public';
$lang['Private'] = 'Priv�';
$lang['Registered'] = 'Enregistr�';
$lang['Administrators'] = 'Administrateurs';
$lang['Hidden'] = 'Cach�';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'Tous';
$lang['Forum_REG'] = 'Membres';
$lang['Forum_PRIVATE'] = 'Priv�';
$lang['Forum_MOD'] = 'Mod�rateurs';
$lang['Forum_ADMIN'] = 'Administrateurs';

$lang['View'] = 'Voir';
$lang['Read'] = 'Lire';
$lang['Post'] = 'Poster';
$lang['Reply'] = 'R�pondre';
$lang['Edit'] = 'Editer';
$lang['Delete'] = 'Supprimer';
$lang['Sticky'] = 'Faire une note';
$lang['Announce'] = 'Annoncer'; 
$lang['Vote'] = 'Voter';
$lang['Pollcreate'] = 'Cr�er un sondage';

$lang['Permissions'] = 'Permissions';
$lang['Simple_Permission'] = 'Permissions simples';

$lang['User_Level'] = 'Niveau utilisateur'; 
$lang['Auth_User'] = 'Utilisateur';
$lang['Auth_Admin'] = 'Administrateur';
$lang['Group_memberships'] = 'Composition des groupes d\'utilisateurs';
$lang['Usergroup_members'] = 'Ce groupe est compos� des membres suivants';

$lang['Forum_auth_updated'] = 'Permissions du forum mises � jour';
$lang['User_auth_updated'] = 'Permissions de l\'utilisateur mises � jour';
$lang['Group_auth_updated'] = 'Permissions de groupe mises � jour';

$lang['Auth_updated'] = 'Les permissions ont �t� mises � jour';
$lang['Click_return_userauth'] = 'Cliquez %sici%s pour retourner aux permissions utilisateurs';
$lang['Click_return_groupauth'] = 'Cliquez %sici%s pour retourner aux permissions de groupe';
$lang['Click_return_forumauth'] = 'Cliquez %sici%s pour retourner aux permissions des forums';


//
// Banning
//
$lang['Ban_control'] = 'Contr�le des exclusions';
$lang['Ban_explain'] = 'Cette page vous permet de contr�ler l\'exclusion des utilisateurs. Vous pouvez exclure un utilisateur sp�cifique ou toute une plage d\'adresses IP ou de noms de serveur (ou de domaine). Ces deux m�thodes emp�cheront purement et simplement un utilisateur d\'acc�der � la page d\'accueil du forum. Pour emp�cher un utilisateur de s\'enregistrer sous un autre nom, vous pouvez �galement exclure son e-mail. Veuillez noter qu\'exclure uniquement l\'adresse e-mail n\'empechera pas un utilisateur de se connecter et de poster. Pour cela, vous devrez utiliser une des deux premi�res m�thodes d\'exclusion cit�es ci-dessus.';
$lang['Ban_explain_warn'] = 'Veuillez noter qu\'entrer un intervalle d\'adresses IP aura pour r�sultat de prendre en compte toutes les adresses entre l\'IP de d�part et l\'IP de fin dans la liste d\'exclusion. Des essais seront effectu�s afin de r�duire le nombre d\'adresses IP ajout�es � la base de donn�es en introduisant des jokers automatiquement aux endroits appropri�s. Si vous devez r�ellement entrer un intervalle, essayez de le garder r�duit ou au mieux, fixez des adresses sp�cifiques.';

$lang['Select_username'] = 'Choisissez un nom d\'utilisateur';
$lang['Select_ip'] = 'Choisissez une adresse IP';
$lang['Select_email'] = 'Choisissez une adresse e-mail';

$lang['Ban_username'] = 'Exclure un ou plusieurs utilisateurs sp�cifiques';
$lang['Ban_username_explain'] = 'Vous pouvez exclure plusieurs utilisateurs en une seule op�ration en utilisant les s�lections multiples avec le clavier et la souris (en g�n�ral ctrl+clic)';

$lang['Ban_IP'] = 'Exclure une ou plusieurs adresses IP et noms d\'h�te';
$lang['IP_hostname'] = 'Adresses IP et noms d\'h�tes';
$lang['Ban_IP_explain'] = 'Pour sp�cifier plusieurs adresses IP diff�rentes ou plusieurs noms de serveur/domaine, utiliser des virgules comme s�parateur. Pour sp�cifier une plage d\'adresses IP, utilisez le tiret (-) pour s�parer le d�but et la fin de la plage; utilisez l\'ast�risque (*) pour utiliser un joker.';


$lang['Ban_email'] = 'Exclure une ou plusieurs adresses e-mail';
$lang['Ban_email_explain'] = 'Pour sp�cifier plus d\'une adresse e-mail, s�parez les avec des virgules, Pour utiliser un joker, utilisez un ast�risque, exemple: *@hotmail.com.';

$lang['Unban_username'] = 'Accepter � nouveau un ou plusieurs utilisateurs';
$lang['Unban_username_explain'] = 'Vous pouvez accepter � nouveau plusieurs utilisateurs d\'un coup en utilisant la bonne combinaison des touches configur�es pour votre clavier et navigateur (en g�n�ral ctrl+clic)';

$lang['Unban_IP'] = 'Accepter � nouveau une ou plusieurs adresses IP';
$lang['Unban_IP_explain'] = 'Vous pouvez accepter � nouveau une ou plusieurs adresses IP d\'un coup en utilisant la bonne combinaison des touches configur�es pour votre clavier et navigateur (en g�n�ral ctrl+clic)';

$lang['Unban_email'] = 'Accepter � nouveau une ou plusieurs adresses e-mail';
$lang['Unban_email_explain'] = 'Vous pouvez accepter � nouveau une ou plusieurs adresses e-mail d\'un coup en utilisant la bonne combinaison des touches configur�es pour votre clavier et navigateur (en g�n�ral ctrl+clic)';

$lang['No_banned_users'] = 'Aucun nom d\'utilisateur exclu';
$lang['No_banned_ip'] = 'Aucune adresse IP exclue';
$lang['No_banned_email'] = 'Aucune adresse e-mail exclue';

$lang['Ban_update_sucessful'] = 'La liste d\'exclusion � �t� mise � jour correctement.';
$lang['Click_return_banadmin'] = 'Cliquez %sici%s pour retourner au panneau de contr�le des exclusionss';


//
// Configuration
//
$lang['General_Config'] = 'Configuration g�n�rale';
$lang['Config_explain'] = 'Cette page vous permet de personnaliser toutes les options g�n�rales du forum. Pour personnaliser les options relatives aux utilisateurs ou aux rubriques, veuillez utiliser les liens appropri�s dans le menu de gauche.';
$lang['Click_return_config'] = 'Cliquez %sici%s pour retourner � la configuration g�n�rale.';

$lang['General_settings'] = 'Configuration g�n�rale du forum';
$lang['Server_name'] = 'Nom de domaine';
$lang['Server_name_explain'] = 'Le nom de domaine sur lequel le forum est install�';
$lang['Script_path'] = 'Chemin du script';
$lang['Script_path_explain'] = 'Le chemin o� phpBB2 est situ� relativement � la racine du domaine';
$lang['Server_port'] = 'Port du serveur';
$lang['Server_port_explain'] = 'Le port sur lequel votre serveur est �tabli, classiquement le port 80. Ne changez cette valeur que si c\'est n�cessaire';
$lang['Site_name'] = 'Nom du site';
$lang['Site_desc'] = 'Description du site';
$lang['Board_disable'] = 'D�sactiver le forum';
$lang['activeportail'] = "Activer portail";
$lang['Board_disable_explain'] = 'Le forum sera inaccessible aux utilisateurs. Cependant les administrateurs gardent un acc�s au panneau d\'administration.';
$lang['Board_disable_msg'] = 'Message de d�sactivation du forum';
$lang['Board_disable_msg_explain'] = 'Ce message apparaitra si vous d�sactivez le forum.';
$lang['Acct_activation'] = 'Activer la validation des comptes';
$lang['Acc_None'] = 'Aucune';  // These three entries are the type of activation
$lang['Acc_User'] = 'Utilisateur';
$lang['Acc_Admin'] = 'Administrateur';

$lang['Abilities_settings'] = 'Options de base des utilisateurs et du forum';
$lang['Max_poll_options'] = 'Nombre maximum de choix dans les sondages';
$lang['Flood_Interval'] = 'Intervalle de flood';
$lang['Flood_Interval_explain'] = 'Nombre de secondes d\'attente entre chaque message post�'; 
$lang['Board_email_form'] = 'Messagerie e-mail via le forum';
$lang['Board_email_form_explain'] = 'Les utilisateurs peuvent s\'envoyer des e-mails via le forum';
$lang['Topics_per_page'] = 'Nombre de sujets par page';
$lang['Posts_per_page'] = 'Nombre de messages par page';
$lang['Hot_threshold'] = 'Nombre de messages pour qu\'un sujet soit \'populaire\'';

$lang['Default_style'] = 'Th�me par d�faut';
$lang['Override_style'] = 'Imposer un th�me aux utilisateurs';
$lang['Override_style_explain'] = 'Remplace le th�me choisi par l\'utilisateur par le th�me par d�faut';
$lang['Default_language'] = 'Langue par d�faut';
$lang['Date_format'] = 'Format de la date';
$lang['System_timezone'] = 'Fuseau horaire';
$lang['Enable_gzip'] = 'Activer la compression GZip';
$lang['Enable_prune'] = 'Activer le d�lestage du forum';
$lang['Allow_HTML'] = 'Autoriser le HTML (non recommand�)';
$lang['Allow_BBCode'] = 'Autoriser le BBCode';
$lang['Allowed_tags'] = 'Balises HTML admises';
$lang['Allowed_tags_explain'] = 'Utilisez des virgules pour s�parer les balises admises';
$lang['Allow_smilies'] = 'Autoriser les em�ticones';
$lang['Smilies_path'] = 'Chemin de stockage des �motic�nes';
$lang['Smilies_path_explain'] = 'Chemin � partir de la racine phpBB, ex: images/smiles';
$lang['Allow_sig'] = 'Autoriser les signatures';
$lang['Max_sig_length'] = 'Longueur maximum des signatures';
$lang['Max_sig_length_explain'] = 'Nombre maximum de caract�res dans les signatures utilis�es par les utilisateurs';
$lang['Allow_name_change'] = 'Autoriser les changements de nom d\'utilisateur';

$lang['Avatar_settings'] = 'Param�tres des avatars';
$lang['Allow_local'] = 'Activer la galerie d\'avatars';
$lang['Allow_remote'] = 'Autoriser les avatars distants';
$lang['Allow_remote_explain'] = 'Les avatars sont li�s � partir d\'une autre adresse.';
$lang['Allow_upload'] = 'Autoriser l\'upload d\'avatar';
$lang['Max_filesize'] = 'Taille maximum des fichiers d\'avatar';
$lang['Max_filesize_explain'] = 'Pour les fichiers d\'avatar upload�s';
$lang['Max_avatar_size'] = 'Dimensions maximales des avatars';
$lang['Max_avatar_size_explain'] = '(hauteur x largeur en pixels)';
$lang['Avatar_storage_path'] = 'Chemin de stockage des avatars';
$lang['Avatar_storage_path_explain'] = 'Chemin � partir de la racine phpBB, ex: images/avatars';
$lang['Avatar_gallery_path'] = 'Chemin de la galerie d\'avatars';
$lang['Avatar_gallery_path_explain'] = 'Chemin � partir de la racine phpBB pour les avatars pr�-�tablis, ex: images/avatars/galerie';

$lang['COPPA_settings'] = 'Configuration COPPA';
$lang['COPPA_fax'] = 'Num�ro de fax COPPA';
$lang['COPPA_mail'] = 'Adresse postale COPPA';
$lang['COPPA_mail_explain'] = 'Adresse � laquelle les parents enverront leur formulaire COPPA';

$lang['Email_settings'] = 'Configuration des e-mails';
$lang['Admin_email'] = 'Adresse e-mail de l\'administrateur';
$lang['Email_sig'] = 'Signature des e-mails';
$lang['Email_sig_explain'] = 'Ce texte sera ajout� en bas des e-mails envoy�s via le forum';
$lang['Use_SMTP'] = 'Utiliser un serveur SMTP pour les e-mails';
$lang['Use_SMTP_explain'] = 'Cochez oui si vous souhaitez envoyer les e-mails via un serveur SMTP plut�t que par la fonction mail() locale.';
$lang['SMTP_server'] = 'Adresse du serveur SMTP';
$lang['SMTP_username'] = 'Nom d\'utilsateur SMTP';
$lang['SMTP_username_explain'] = 'Entrez un nom d\'utilisateur seulement si vous serveur SMTP en requiert un';
$lang['SMTP_password'] = 'Mot de passe SMTP';
$lang['SMTP_password_explain'] = 'Entrez un mot de passe seulement si vous serveur SMTP en requiert un';

$lang['Disable_privmsg'] = 'Messages priv�s';
$lang['Inbox_limits'] = 'Nombre maximum de messages dans la bo�te priv�e';
$lang['Sentbox_limits'] = 'Nombre maximum de messages dans la bo�te d\'envoi';
$lang['Savebox_limits'] = 'Nombre maximum de messages dans la bo�te de sauvegarde';

$lang['Cookie_settings'] = 'Configuration des cookies'; 
$lang['Cookie_settings_explain'] = 'Ces d�tails d�finissent la mani�re dont les cookies sont envoy�s sur l\'ordinateur de vos utilisateurs. Dans la plupart des cas, la valeur par d�faut sera adapt�e. La modification de ces valeurs est recommand� aux utilisateurs avertis : la saisie de valeurs erron�es pourrait emp�cher vos utilisateurs de se connecter au forum.';

$lang['Cookie_domain'] = 'Domaine du cookie';
$lang['Cookie_name'] = 'Nom du cookie';
$lang['Cookie_path'] = 'Chemin du cookie';
$lang['Cookie_secure'] = 'Cookie securis�';
$lang['Cookie_secure_explain'] = 'Si votre serveur poss�de une extension SSL, activez cette option, sinon laissez la telle quelle.';
$lang['Session_length'] = 'Dur�e de la session [ en secondes ]';


// Visual Confirmation

$lang['Visual_confirm'] = 'Activer la confirmation visuelle';
$lang['Visual_confirm_explain'] = 'Oblige les utilisateurs � saisir un code d�fini par une image � l\'enregistrement.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Autoriser les connexions automatiques';
$lang['Allow_autologin_explain'] = 'D�termine si les utilisateurs du forum peuvent utiliser l\'option de connexion automatique';
$lang['Autologin_time'] = 'Expiration de la clef de connexion automatique';
$lang['Autologin_time_explain'] = 'Nombre de jours durant laquelle la clef de connexion automatique reste valide. Mettre 0 pour d�sactiver l\'expiration de clefs.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Intervalles de flood pour la recherche';
$lang['Search_Flood_Interval_explain'] = 'Nombre de secondes durant lequel un utilisateur doit patienter avant de pouvoir effectuer une nouvelle recherche.'; 
$lang['Confirm_delete_smiley'] = '�tes-vous s�r de vouloir supprimer ce smiley ?';
$lang['Confirm_delete_word'] = '�tes-vous s�r de vouloir supprimer ce mot censur� ?';

$lang['Confirm_delete_rank'] = '�tes-vous s�r de vouloir supprimer ce rang ?';


//
// Forum Management
//

$lang['Forum_admin'] = 'Administration des forums';
$lang['Forum_admin_explain'] = 'Vous pouvez ajouter, supprimer, �diter, r�ordonner et resynchroniser les cat�gories et les forums depuis cette page';
$lang['Edit_forum'] = '�diter un forum';
$lang['Create_forum'] = 'Cr�er un nouveau forum';
$lang['Create_category'] = 'Cr�er une nouvelle cat�gorie';
$lang['Remove'] = 'Enlever';
$lang['Action'] = 'Action';
$lang['Update_order'] = 'Mettre � jour l\'ordre';
$lang['Config_updated'] = 'La Configuration du forum a �t� correctement mise � jour';
$lang['Edit'] = '�diter';
$lang['Delete'] = 'Supprimer';
$lang['Move_up'] = 'Monter';
$lang['Move_down'] = 'Descendre';
$lang['Resync'] = 'Resynchroniser';
$lang['No_mode'] = 'Aucun mode n\'a �t� d�fini';
$lang['Forum_edit_delete_explain'] = 'Le formulaire ci-dessous vous permet de modifier les options g�n�rales du forum. Pour la configuration de utilisateurs et des forums, veuillez utiliser les liens relatifs dans le volet de gauche.';
$lang['Forum_color'] = 'Donner une couleur a votre forum';
$lang['Forum_color_explain'] = 'Indiquez la couleur du forum (Ex:F5F5DC).Ne pas saisir le \'#\'!!!!';
$lang['Move_contents'] = 'D�placer tout le contenu vers';
$lang['Forum_delete'] = 'Supprimer un forum';
$lang['Forum_delete_explain'] = 'Le formulaire ci-dessous vous permet de supprimer un forum (ou une cat�gorie) et de choisir l\'endroit o� vous souhaitez d�placer les sujets (ou forums) qu\'il contient.';
$lang['Status_locked'] = 'Verrouill�';
$lang['Status_unlocked'] = 'D�verrouill�';
$lang['Forum_settings'] = 'Options g�n�rales des forums';
$lang['Forum_name'] = 'Nom du forum';
$lang['Forum_desc'] = 'Description';
$lang['Forum_status'] = 'Statut du forum';
$lang['Forum_pruning'] = 'Auto-d�lestage';
$lang['prune_freq'] = 'V�rifier l\'�ge des sujets tous les ';
$lang['prune_days'] = 'Supprimer les sujets n\'ayant pas eu de r�ponses depuis';
$lang['Set_prune_data'] = 'Vous avez activer l\'auto-d�lestage pour ce forum mais n\'avez pas d�fini une fr�quence ou un nombre de jours � d�lester. Veuillez revenir en arri�re et le faire.';
$lang['Move_and_Delete'] = 'D�placer et supprimer';
$lang['Delete_all_posts'] = 'Supprimer tous les messages';
$lang['Nowhere_to_move'] = 'Nulle part o� d�placer';
$lang['Edit_Category'] = '�diter une cat�gorie';
$lang['Edit_Category_explain'] = 'Utilisez ce formulaire pour modifer le nom d\'une cat�gorie.';
$lang['Forums_updated'] = 'Les informations du forum et de la cat�gorie ont �t� correctement mise � jour';

$lang['Must_delete_forums'] = 'Vous devez supprimer tous les forums avant de pouvoir supprimer cette cat�gorie';
$lang['Click_return_forumadmin'] = 'Cliquez %sici%s pour revenir � l\'administration des forums';


//
// Smiley Management
//
$lang['smiley_title'] = 'Gestion des �motic�nes';
$lang['smile_desc'] = 'Vous pouvez ajouter, supprimer et �diter les �moticons ou les �motic�nes que vos utilisateurs peuvent utiliser dans leurs messages et dans leurs messages priv�s depuis cette page.';
$lang['smiley_config'] = 'Configuration des �motic�nes';
$lang['smiley_code'] = 'Code de l\'�motic�ne';
$lang['smiley_url'] = 'Fichier image de l\'�motic�ne';
$lang['smiley_emot'] = 'Emotic�ne';
$lang['smile_add'] = 'Ajouter un nouvel �motic�ne';
$lang['Smile'] = 'Image';
$lang['Emotion'] = 'Emotic�ne';
$lang['Select_pak'] = 'S�lectionnez un fichier pack (.pak)';
$lang['replace_existing'] = 'Remplacer les �motic�nes existants';
$lang['keep_existing'] = 'Conserver les �motic�nes existants';
$lang['smiley_import_inst'] = 'Vous devez d�compresser le pack d\'�motic�nes et uploader tous les fichiers dans le r�pertoire appropri� pour l\'installation. Ensuite compl�tez correctement les informations du formulaire pour importer votre pack.';
$lang['smiley_import'] = 'Importer un pack d\'�motic�nes';
$lang['choose_smile_pak'] = 'Choisir un pack d\'�motic�nes (fichier .pak)';
$lang['import'] = 'Importer les �motic�nes';
$lang['smile_conflicts'] = 'Que faire en cas de conflits ?';
$lang['del_existing_smileys'] = 'Supprimer les �motic�nes existants avant l\'importation';
$lang['import_smile_pack'] = 'Importer un pack d\'�motic�nes';
$lang['export_smile_pack'] = 'Cr�er un pack de �motic�nes';
$lang['export_smiles'] = 'Pour cr�er un pack d\'�motic�nes � partir de vos �motic�nes actuellement install�s, cliquez %sici%s pour t�l�charger le fichier smiles.pak. Renommez-le si besoin est en prennant soin de concerver l\'extension .pak. Cr�ez ensuite un fichier zip contenant toutes les images de vos �motic�nes, ainsi que le fichier de configuration (.pak).';
$lang['smiley_add_success'] = 'L\'�motic�ne a bien �t� ajout�';
$lang['smiley_edit_success'] = 'L\'�motic�ne a �t� correctement mis � jour';
$lang['smiley_import_success'] = 'Le pack d\'�motic�ne a �t� correctement import� !';
$lang['smiley_del_success'] = 'L\'�motic�ne a bien �t� supprim�';
$lang['Click_return_smileadmin'] = 'Cliquez %sici%s pour revenir � la gestion des �motic�nes';


//
// User Management
//
$lang['User_admin'] = 'Administration des utilisateurs';
$lang['User_admin_explain'] = 'Vous pouvez changer ici les informations des utilisateurs et certaines options sp�cifiques. Pour modifier les permissions des utilisateurs, veuillez utiliser les syst�mes de permissions des utilisateurs et de groupes.';
$lang['Look_up_user'] = 'Rechercher l\'utilisateur';
$lang['Admin_user_fail'] = 'Impossible de mettre � jour le profil de l\'utilisateur.';
$lang['Admin_user_updated'] = 'Le profil de l\'utilisateur a �t� correctement mis � jour.';
$lang['Click_return_useradmin'] = 'Cliquez %sici%s pour revenir � l\'administration des utilisateurs';
$lang['User_delete'] = 'Supprimer cet utilisateur';
$lang['User_delete_explain'] = 'Cliquez ici pour supprimer l\'utilisateur. Attention, cette op�ration est irr�versible !';
$lang['User_deleted'] = 'L\'utilisateur a bien �t� supprim�.';
$lang['User_status'] = 'L\'utilisateur est actif';
$lang['User_allowpm'] = 'L\'utilisateur peut envoyer des messages priv�s';
$lang['User_allowavatar'] = 'L\'utilisateur peut afficher un avatar';
$lang['Admin_avatar_explain'] = 'Vous pouvez voir et supprimer l\'avatar actuel de l\'utilisateur ici.';
$lang['User_special'] = 'Champs r�serv�s � l\'administration uniquement';
$lang['User_special_explain'] = 'Ces champs ne sont pas modifiables par les utilisateurs. Vous pouvez y d�finir leur statut ainsi que diverses options non donn�es aux utilisateurs.';


//
// Group Management
//

$lang['Group_administration'] = 'Administration des groupes';
$lang['Group_admin_explain'] = 'Depuis cette page, vous pouvez administrer tous les groupes. Il est possible de supprimer, ajouter et �diter les groupes existants. Vous pouvez choisir des mod�rateurs, d�finir le statut (ouvert, ferm� ou invisible) ainsi que les noms et descriptions des groupes';
$lang['Error_updating_groups'] = 'Une erreur s\'est produite lors de la mise � jour des groupes';
$lang['Updated_group'] = 'Le groupe a �t� correctement mis � jour';
$lang['Added_new_group'] = 'Le nouveau groupe a bien �t� cr��';
$lang['Deleted_group'] = 'Le groupe a bien �t� supprim�';
$lang['New_group'] = 'Cr�er un nouveau groupe';
$lang['Edit_group'] = 'Editer un groupe';
$lang['group_name'] = 'Nom du groupe';
$lang['group_description'] = 'Description du groupe';
$lang['group_moderator'] = 'Mod�rateur du groupe';
$lang['group_status'] = 'Statut du groupe';
$lang['group_open'] = 'Groupe ouvert';
$lang['group_closed'] = 'Groupe ferm�';
$lang['group_hidden'] = 'Groupe invisible';
$lang['group_delete'] = 'Supprimer le groupe';
$lang['group_delete_check'] = 'Cochez cette case pour supprimer le groupe';
$lang['submit_group_changes'] = 'Soumettre les modifications';
$lang['reset_group_changes'] = 'Remettre � z�ro';
$lang['No_group_name'] = 'Vous devez pr�ciser un nom pour ce groupe';
$lang['No_group_moderator'] = 'Vous devez pr�ciser un mod�rateur pour ce groupe';
$lang['No_group_mode'] = 'Vous devez pr�ciser le statut du groupe : ouvert, ferm� ou invisible';
$lang['No_group_action'] = 'Aucune action n\'a �t� sp�cifi�e';
$lang['delete_group_moderator'] = 'Supprimer l\'ancien mod�rateur du groupe ?';
$lang['delete_moderator_explain'] = 'Si vous changez le mod�rateur du groupe, cochez cette case pour que l\'ancien mod�rateur ne soit plus dans le groupe. Autrement, vous pouvez ne pas la cocher et il deviendra simplement membre du groupe.';
$lang['Click_return_groupsadmin'] = 'Cliquez %sici%s pour revenir � l\'administration des groupes.';
$lang['Select_group'] = 'S�lectionner un groupe';
$lang['Look_up_group'] = 'Rechercher un groupe';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'D�lestage des forums';
$lang['Forum_Prune_explain'] = 'Cette op�ration va supprimer tous les sujets n\'ayant pas eu de r�ponses depuis x jour(s), o� vous avez choisi x. Si vous ne choisissez pas de nombre x, tous les sujets seront supprim�s. En revanche, cela ne supprimera pas les sujets dans lesquels un sondage est encore en cours, ni les annonces. Vous devrez supprimer vous-m�me ces sujets.';
$lang['Do_Prune'] = 'D�lester';
$lang['All_forums'] = 'Tous les forums';
$lang['Prune_topics_not_posted'] = 'D�lester les sujets n\'ayant pas eu de r�ponses depuis '; // La phrase n'est volontairement pas finie afin de laisser la case � remplir, puis jour
$lang['Topics_pruned'] = 'Sujets d�lest�s';
$lang['Posts_pruned'] = 'Messages d�lest�s';
$lang['Prune_success'] = 'Le d�lestage des forums a �t� correctement effectu�';

//
// Word censor
//
$lang['Words_title'] = 'Censure du contenu';
$lang['Words_explain'] = 'Vous pouvez ajouter, �diter et supprimer les mots qui seront automatiquement censur�s sur vos forums depuis cette page. De plus, les utilisateurs ne pourront s\'enregistrer avec des noms contenant ces mots. Les jokers (*) sont accept�s. Par exemple, le mot *test* va prendre en compte le mot detestable, test* va prendre en compte le mot tester et *test va prendre en compte le mot psychotest.';
$lang['Word'] = 'Mot';
$lang['Edit_word_censor'] = 'Editer le mot � censurer';
$lang['Replacement'] = 'Remplacer par';
$lang['Add_new_word'] = 'Ajouter un nouveau mot';
$lang['Update_word'] = 'Mettre � jour le mot � censurer';
$lang['Must_enter_word'] = 'Vous devez entrer un mot ainsi que son rempla�ant';
$lang['No_word_selected'] = 'Aucun mot n\'a �t� selectionn� pour l\'�dition';
$lang['Word_updated'] = 'Le mot � censurer s�lectionn� a �t� correctement mis � jour';
$lang['Word_added'] = 'Le mot � censurer a bien �t� ajout�';
$lang['Word_removed'] = 'Le mot � censurer a bien �t� supprim�';
$lang['Click_return_wordadmin'] = 'Cliquez %sici%s pour revenir � la censure du contenu';

//
// Mass Email
//
$lang['Mass_email_explain'] = 'Cette page vous permet d\'envoyer des e-mails � tous vos utilisateurs ou � tous les utilisateurs d\'un groupe sp�cifique. Pour ce faire, un e-mail sera envoy� � l\'administrateur, et chaque destinataire recevra une copie cach�e. Lors de l\'envoi d\'un e-mail � un grand nombre de personnes, veuillez patienter  et ne pas interrompre le chargement de la page. L\'envoi d\'e-mail en masse peut, en effet, prendre un peu de temps, vous serez averti d�s la fin de l\'op�ration.';
$lang['Compose'] = 'R�diger'; 
$lang['Recipients'] = 'Destinataires'; 
$lang['All_users'] = 'Tous les utilisateurs';
$lang['Email_successfull'] = 'Votre message a �t� envoy�';
$lang['Click_return_massemail'] = 'Cliquez %sici%s pour revenir au formulaire d\'envoi d\'e-mails de masse';

//
// Ranks admin
//
$lang['Ranks_title'] = 'Administration des rangs';
$lang['Ranks_explain'] = 'Vous pouvez voir, ajouter, �diter et supprimer les rangs sur cette page. Vous pouvez aussi cr�er des rangs personnalis�s qui seront assign�s aux utilisateurs via l\'outil de gestion des utilisateurs';
$lang['Add_new_rank'] = 'Ajouter un nouveau rang';
$lang['Rank_title'] = 'Nom du rang';
$lang['Rank_special'] = 'D�finir en tant que rang sp�cial';
$lang['Rank_minimum'] = 'Messages minimum';
$lang['Rank_maximum'] = 'Messages maximum';
$lang['Rank_image'] = 'Url de l\'image associ�e au rang';
$lang['Rank_img'] = 'Rank Image';
$lang['Rank_image_explain'] = '(relative au chemin de phpBB)';
$lang['Must_select_rank'] = 'Vous devez s�lectionner un rang';
$lang['No_assigned_rank'] = 'Aucun rang sp�cial assign�';
$lang['Rank_updated'] = 'Le rang a �t� correctement mis � jour';
$lang['Rank_added'] = 'Le rang a bien �t� ajout�';
$lang['Rank_removed'] = 'Le rang a bien �t� supprim�';
$lang['No_update_ranks'] = 'Le rang a bien �t� supprim�, toutefois les comptes des utilisateurs ayant ce rang n\'ont pas �t� mis � jour. Vous devrez modifier le rang de chacun de ces utilisateurs manuellement';
$lang['Click_return_rankadmin'] = 'Cliquez %sici%s pour revenir � l\'administration des rangs';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Panneau de restriction des noms d\'utilisateurs';
$lang['Disallow_explain'] = 'Cette page vous permet de g�rer les noms d\'utilisateurs interdit � l\'usage. Les noms d\'utilisateurs interdits peuvent contenir des jokers (*). Veuillez noter qu\'il est impossible d\'interdire le nom d\'un utilisateur d�j� enregistr�. Vous devrez pr�alablement supprimer le compte de cet utilisateur avant d\'en interdire le nom.';
$lang['Delete_disallow'] = 'Supprimer';
$lang['Delete_disallow_title'] = 'Supprimer un nom d\'utilisateur interdit';
$lang['Delete_disallow_explain'] = 'Vous pouvez supprimer un nom d\'utilisateur interdit en le s�lectionnant dans la liste puis en cliquant sur \'Supprimer\'';
$lang['Add_disallow'] = 'Ajouter';
$lang['Add_disallow_title'] = 'Ajouter un nom d\'utilisateur interdit';
$lang['Add_disallow_explain'] = 'Vous pouvez interdire un nom d\'utilisateur en utilisant des jokers (*) pour remplacer n\'importe quel caract�re';
$lang['No_disallowed'] = 'Aucun nom d\'utilisateur interdit';
$lang['Disallowed_deleted'] = 'Le nom d\'utilisateur interdit a �t� correctement supprim�';
$lang['Disallow_successful'] = 'Le nom d\'utilisateur interdit a bien �t� ajout�';
$lang['Disallowed_already'] = 'Le nom que vous avez entr� ne peut �tre interdit. Soit il existe d�j� dans la liste des noms d\'utilisateurs interdit, soit il figure dans la liste des mots censur�s, soit il est actuellement utilis� par un utilisateur enregistr�.';
$lang['Click_return_disallowadmin'] = 'Cliquez %sici%s pour revenir au panneau de restriction des noms d\'utilisateurs';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administration des th�mes';
$lang['Styles_explain'] = 'Cette page vous permet d\'ajouter, supprimer et g�rer les styles (mod�les de documents et th�mes) disponibles aupr�s des utilisateurs';
$lang['Styles_addnew_explain'] = 'La liste suivante contient tous les th�mes qui sont disponibles dans votre dossier /templates, et non install�s. Pour installer un th�me, cliquez simplement sur le lien installer � c�t� du nom du th�me.';
$lang['Select_template'] = 'S�lectionner un mod�le de document';
$lang['Style'] = 'Th�me';
$lang['Template'] = 'Mod�le de document';
$lang['Install'] = 'Installer';
$lang['Download'] = 'T�l�charger';
$lang['Edit_theme'] = 'Editer un th�me';
$lang['Edit_theme_explain'] = 'Vous pouvez modifier les r�glages du th�me s�lectionn� dans le formulaire suivant';
$lang['Create_theme'] = 'Cr�er un th�me';
$lang['Create_theme_explain'] = 'Utilisez le formulaire ci-dessous pour cr�er un nouveau th�me pour le mod�le de document s�lectionn�. Lorsque vous entrez une couleur (le code hexad�cimal est imp�ratif) vous ne devrez pas inclure le # initial. Autrement dit : CCCCCC est valide, #CCCCCC ne l\'est pas';
$lang['Export_themes'] = 'Exporter des th�mes';
$lang['Export_explain'] = 'Cette page vous permet d\'exporter les informations d\'un th�me pour le mod�le de document s�lectionn�. Selectionnez un mod�le de document depuis la liste ci-dessous et un fichier de configuration du th�me sera cr�� et sauvegard� dans le dossier du mod�le de document. Si le fichier de configuration ne peut �tre sauvegard�, il vous sera propos� de le t�l�charger. Pour permettre la sauvegarde du fichier, vous devez donner les droits d\'�criture sur le r�pertoire du th�me (chmod 666 minimum). Pour plus de renseignements, consultez le guide des utilisateurs de phpBB 2.';
$lang['Theme_installed'] = 'Le th�me s�lectionn� a �t� correctement install�';
$lang['Style_removed'] = 'Le th�me s�lectionn� a bien �t� supprim� de la base de donn�es. Pour le supprimer totalement vous devez effacer les fichiers contenus dans le r�pertoire du mod�le de document.';
$lang['Theme_info_saved'] = 'Les informations du th�me pour le mod�le de document s�lectionn� ont �t� correctement sauvegard�es. Vous devriez d�s � pr�sent remettre les permissions du fichier theme_info.cfg (et si possible celle du r�pertoire du mod�le de document selectionn�) en lecture seule';
$lang['Theme_updated'] = 'Le th�me s�lectionn� a �t� correctement mis � jour. Vous devriez d�s � pr�sent exporter les nouveaux param�tres du th�me';
$lang['Theme_created'] = 'Le th�me a bien �t� cr�e. Vous devriez d�s � pr�sent exporter le th�me vers un fichier de configuration de th�me afin de le conserver en lieu sur ou de le r�utiliser plus tard.';
$lang['Confirm_delete_style'] = 'Voulez-vous vraiment supprimer ce th�me ?';
$lang['Download_theme_cfg'] = 'Le script d\'exportation ne peut pas �crire le fichier d\'information du th�me. Cliquez sur le bouton ci-dessous pour t�l�charger le fichier avec votre navigateur. Une fois t�l�charg�, vous pouvez le transf�rer dans le r�pertoire contenant les fichiers du th�me. Vous pouvez ensuite cr�er un pack de ces fichiers pour le distribuer ou l\'utiliser autrement si vous le souhaitez';
$lang['No_themes'] = 'Le mod�le de document que vous avez s�lectionn� ne poss�de pas de th�me associ�. Pour cr�er un nouveau th�me cliquez sur le lien cr�er un th�me dans le volet de gauche';
$lang['No_template_dir'] = 'Impossible d\'ouvrir le r�pertoire du mod�le de document. Il est peut-�tre illisible par le serveur ou n\'existe pas';
$lang['Cannot_remove_style'] = 'Vous ne pouvez pas supprimer le th�me tant qu\'il est d�finit comme �tant le th�me par d�faut du forum. Veuillez changer le th�me par d�faut et essayer � nouveau.';
$lang['Style_exists'] = 'Le nom du th�me choisi existe d�j�, veuillez revenir en arri�re et choisir un nom diff�rent.';
$lang['Click_return_styleadmin'] = 'Cliquez %sici%s pour revenir � l\'administration des th�mes';
$lang['Theme_settings'] = 'Options du th�me';
$lang['Theme_element'] = 'Element du th�me';
$lang['Simple_name'] = 'Nom Simple';
$lang['Value'] = 'Valeur';
$lang['Save_Settings'] = 'Sauvegarder les param�tres';
$lang['Stylesheet'] = 'Feuille de style CSS';
$lang['Background_image'] = 'Image de fond';
$lang['Background_color'] = 'Couleur de fond';
$lang['Theme_name'] = 'Nom du th�me';
$lang['Link_color'] = 'Couleur du lien';
$lang['Text_color'] = 'Couleur du texte';
$lang['VLink_color'] = 'Couleur du lien visit�';
$lang['ALink_color'] = 'Couleur du lien actif';
$lang['HLink_color'] = 'Couleur du lien survol�';
$lang['Tr_color1'] = 'Couleur 1 des lignes';
$lang['Tr_color2'] = 'Couleur 2 des lignes';
$lang['Tr_color3'] = 'Couleur 3 des lignes';
$lang['Tr_class1'] = 'Classe 1 des lignes';
$lang['Tr_class2'] = 'Classe 2 des lignes';
$lang['Tr_class3'] = 'Classe 3 des lignes';
$lang['Th_color1'] = 'Couleur 1 des cellules en-t�te';
$lang['Th_color2'] = 'Couleur 2 des cellules en-t�te';
$lang['Th_color3'] = 'Couleur 3 des cellules en-t�te';
$lang['Th_class1'] = 'Classe 1 des cellules en-t�te';
$lang['Th_class2'] = 'Classe 2 des cellules en-t�te';
$lang['Th_class3'] = 'Classe 3 des cellules en-t�te';
$lang['Td_color1'] = 'Couleur 1 des cellules';
$lang['Td_color2'] = 'Couleur 2 des cellules';
$lang['Td_color3'] = 'Couleur 3 des cellules';
$lang['Td_class1'] = 'Classe 1 des cellules';
$lang['Td_class2'] = 'Classe 2 des cellules';
$lang['Td_class3'] = 'Classe 3 des cellules';
$lang['fontface1'] = 'Nom de la police 1';
$lang['fontface2'] = 'Nom de la police 2';
$lang['fontface3'] = 'Nom de la police 3';
$lang['fontsize1'] = 'Taille de la police 1';
$lang['fontsize2'] = 'Taille de la police 2';
$lang['fontsize3'] = 'Taille de la police 3';
$lang['fontcolor1'] = 'Couleur de la police 1';
$lang['fontcolor2'] = 'Couleur de la police 2';
$lang['fontcolor3'] = 'Couleur de la police 3';
$lang['span_class1'] = 'Span Classe 1';
$lang['span_class2'] = 'Span Classe 2';
$lang['span_class3'] = 'Span Classe 3';
$lang['img_poll_size'] = 'Taille des barres de sondage [px]';
$lang['img_pm_size'] = 'Taille des barres de la messagerie priv�e [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Bienvenue � l\'installation de phpBB 2';
$lang['Initial_config'] = 'Configuration de base';
$lang['DB_config'] = 'Configuration de la base de donn�es';
$lang['Admin_config'] = 'Configuration du compte administrateur';
$lang['continue_upgrade'] = 'Une fois le fichier de configuration t�l�charg� sur votre ordinateur, vous pouvez cliquer sur le bouton \'Continuer la mise � jour\' ci-dessous afin de continuer le processus de mise � jour. Veuillez patienter jusqu\'� la fin de la mise � jour avant d\'uploader le fichier de configuration (config.php).';
$lang['upgrade_submit'] = 'Continuer la mise � jour';

$lang['Installer_Error'] = 'Une erreur s\'est produite au cours de l\'installation';
$lang['Previous_Install'] = 'Une installation ant�rieure de phpBB a �t� d�tect�e';
$lang['Install_db_error'] = 'Une erreur s\'est produite lors de la tentative de mise � jour de la base de donn�es';

$lang['Re_install'] = 'Votre installation ant�rieure est toujours active.<br /><br />Si vous souhaitez r�-installer phpBB 2, cliquez sur le bouton \'Oui\' ci-dessous. Veuillez noter que ceci va supprimer toutes les informations et qu\'aucune sauvegarde ne sera faite ! Le nom et le mot de passe de l\'administrateur vont �tre recr��s apr�s la r�-installation, rien d\'autre ne sera conserv�.<br /><br />R�fl�chissez � deux fois avant de cliquer sur \'Oui\' !';

$lang['Inst_Step_0'] = 'Merci d\'avoir choisi phpBB 2. Afin de poursuivre l\'installation, veuillez compl�ter soigneusement le formulaire ci-dessous. Veuillez noter que la base de donn�es dans laquelle vous allez installer devrait d�j� exister. Si vous �tes en train d\'installer sur une base de donn�es qui utilise ODBC, MS Access par exemple, vous devez d\'abord lui cr�er un SGBD avant de continuer.';

$lang['Start_Install'] = 'Commencer l\'installation';
$lang['Finish_Install'] = 'Terminer l\'installation';

$lang['Default_lang'] = 'Langue utilis�e par d�faut sur le forum';
$lang['DB_Host'] = 'Nom du serveur de base de donn�es / SGBD';
$lang['DB_Name'] = 'Nom de votre base de donn�es';
$lang['DB_Username'] = 'Nom d\'utilisateur de la base de donn�es';
$lang['DB_Password'] = 'Mot de passe de la base de donn�es';
$lang['Database'] = 'Votre base de donn�es';
$lang['Install_lang'] = 'Choisissez la langue pour l\'installation';
$lang['dbms'] = 'Type de la base de donn�es';
$lang['Table_Prefix'] = 'Pr�fixe des tables';
$lang['Admin_Username'] = 'Nom d\'utilisateur de l\'administrateur';
$lang['Admin_Password'] = 'Mot de passe de l\'administrateur';
$lang['Admin_Password_confirm'] = 'Confirmez le mot de passe de l\'administrateur';

$lang['Inst_Step_2'] = 'Votre nom d\'utilisateur (administrateur) a �t� cr��. � ce point, l\'installation basique du forum est termin�e. Vous allez maintenant �tre redirig� vers une page qui vous permettra d\'administrer votre nouvelle installation. Veuillez vous assurer de v�rifier les d�tails de la configuration g�n�rale et d\'op�rer les changements qui s\'imposent. Merci d\'avoir choisi phpBB 2.';

$lang['Unwriteable_config'] = 'Votre fichier de configuration est en lecture seule actuellement. Une copie du fichier va vous �tre proposer en t�l�chargement d�s que vous aurez cliqu� sur le bouton ci-dessous. Vous devrez uploader ce fichier � la racine de votre forum. Une fois r�alis�, vous pourrez vous connecter en tant qu\'administrateur avec le nom et le mot de passe donn�s dans le formulaire pr�c�dent. Vous pourrez visiter le panneau d\'administration (un lien apparra�tra en bas de chaque page une fois connect�) pour v�rifier la configuration g�n�rale. Merci d\'avoir choisi phpBB 2.';
$lang['Download_config'] = 'T�l�charger le fichier de configuration';

$lang['ftp_choose'] = 'Choisir la m�thode de t�l�chargement';
$lang['ftp_option'] = '<br />Tant que les extensions FTP seront activ�es dans cette version de PHP, l\'option d\'essayer d\'envoyer automatiquement le fichier config sur un ftp peut vous �tre donn�e.';
$lang['ftp_instructs'] = 'Vous avez choisi de transferer automatiquement le fichier vers le r�pertoire contenant phpBB 2 par FTP. Veuillez compl�ter les informations ci-dessous afin de faciliter le processus. Notez que le chemin du FTP doit �tre exactement celui du r�pertoire o� est install� votre forum, comme si vous �tiez en train d\'envoyer le fichier avec n\'importe quel client FTP.';
$lang['ftp_info'] = 'Entrez vos informations FTP';
$lang['Attempt_ftp'] = 'Essayer de transf�rer le fichier de configuration vers un serveur FTP';
$lang['Send_file'] = 'Juste m\'envoyer le fichier et je l\'enverrai manuellement sur le serveur FTP';
$lang['ftp_path'] = 'Chemin de phpBB2 sur le FTP';
$lang['ftp_username'] = 'Votre nom d\'utilisateur sur le FTP';
$lang['ftp_password'] = 'Votre mot de passe sur le FTP';
$lang['Transfer_config'] = 'D�marrer le transfert';
$lang['NoFTP_config'] = 'La tentative d\'envois du fichier de configuration par FTP a �chou�. Veuillez t�l�charger le fichier et le mettre en ligne manuellement.';

$lang['Install'] = 'Installation';
$lang['Upgrade'] = 'mise � jour';
$lang['Install_Method'] = 'Choix du type d\'installation';
$lang['Install_No_Ext'] = 'La configuration de PHP sur votre serveur ne supporte pas le type de base de donn�es que vous avez choisi';
$lang['Install_No_PCRE'] = 'phpBB 2 requiert le support des expressions r�guli�res Perl pour PHP. Il semblerait que votre configuration de PHP ne le supporte pas !';


//
// Version Check
//
$lang['Version_up_to_date'] = 'Votre installation est � jour, il n\'y a pas de nouvelle version actuellement.';
$lang['Version_not_up_to_date'] = 'Votre installation <b>n\'est pas</b> � jour. Veuillez visiter <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/</a> ou un site de <a href="http://www.phpbb.fr" target="_new">support</a> pour obtenir la version la plus r�cente, ainsi que les informations n�cessaires � la mise � jour de votre installation.';
$lang['Latest_version_info'] = 'La version la plus r�cente est <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Vous utilisez <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Impossible d\'�tablir une connexion vers le serveur du site officiel. L\'erreur signal�e est :<br />%s';
$lang['Socket_functions_disabled'] = 'Les fonctions sockets semblent avoir �t� d�sactiv�es, il est impossible de les utiliser.';
$lang['Mailing_list_subscribe_reminder'] = 'Pour les informations les plus r�centes sur les mises � jour pour phpBB, <a href="http://www.phpbb.com/support/" target="_new">incrivez-vous � notre liste de diffusion</a> (vous trouverez �galement une liste de diffusion en fran�ais sur votre site de <a href="http://www.phpbb.biz" target="_blank">support fran�ais</a>).';
$lang['Version_information'] = 'Information sur la version'; 


$lang['Max_login_attempts'] = 'Nombre de tentatives de connexion autoris�es';
$lang['Max_login_attempts_explain'] = 'Nombre maximum de tentatives de connexion qui, s\'il est d�pass�, bloquera l\'utilisateur pendant le temps d�fini ci dessous.';
$lang['Login_reset_time'] = 'Temps de blocage';
$lang['Login_reset_time_explain'] = 'Nombre de minutes durant lesquelles l\'utilisateur ayant d�pass� le nombre de tentatives de connexions autoris�es devra patienter pour pouvoir se connecter de nouveau.'; 


// Points System MOD - Admin
$lang['Points_updated']	= 'Configuration du syst�me de points mise � jour avec succ�s';
$lang['Click_return_points'] = 'Cliquez %sIci%s pour retourner � la configuration du syst�me de points';
$lang['Points_config_explian'] = 'Le formulaire ci-dessous vous permet d\'�diter la configuration du syst�me de points.';
$lang['Points_sys_settings'] = 'Param�tres du syst�me de points';
$lang['Points_disabled'] = 'D�sactiver les %s';
$lang['Points_enable_post']	= 'Gagner des %s en postant';
$lang['Points_enable_browse'] = 'Gagner des %s en naviguant';
$lang['Points_enable_donation']	= 'Autoriser les dons';
$lang['Points_name'] = 'Nom des points';
$lang['Points_per_reply'] = 'Points par r�ponse';
$lang['Points_per_topic'] = 'Points par nouveaux sujets';
$lang['Points_per_page'] = 'Points par page';
$lang['Points_user_group_auth'] = 'Groupes autoris�s';
$lang['Points_enable_post_explain']	= 'Laisse les utilisateurs gagner des %s en postant des nouveaux sujets et en r�pondant � ceux existants';
$lang['Points_enable_browse_explain'] = 'Laisse les utilisateurs gagner des %s en naviguant sur les forums';
$lang['Points_enable_donation_explain']	= 'Laisse les utlisateurs donner des %s � leurs amis';
$lang['Points_name_explain'] = 'Appelation des points sur votre forum ( par exemple dollars , carottes)';
$lang['Points_per_reply_explain'] = 'Montant de %s gagn�(s) par r�ponse';
$lang['Points_per_topic_explain'] = 'Montant de %s gagn�(s) pour chaque nouveau sujet cr��';
$lang['Points_per_page_explain'] = 'Montant de %s gagn�(s) pour chaque page affich�e';
$lang['Points_user_group_auth_explain'] = 'Entrez les ids des groupes autoris�s � acc�der au panneau de contr�le des points. Une seule id par ligne.';
$lang['Allow_Points'] = 'Utiliser le syst�me de points ?';
$lang['Points_reset'] = 'R�initialiser les points de tous les utilisateurs';
$lang['Points_reset_explain'] = 'Entrez un nombre puis validez : cela deviendra le nombre de points de tous les utilisateurs.';

// Start add - Online/Offline/Hidden Mod
$lang['Online_time'] = 'Dur&eacute;e du statut en ligne';
$lang['Online_time_explain'] = 'Nombre de secondes durant lequel un membre doit &ecirc;tre affich&eacute; en ligne (ne pas utiliser une valeur inf&eacute;rieur � 60).';
$lang['Online_setting'] = 'Menu du Satut';
$lang['Online_color'] = 'Couleur du texte En ligne';
$lang['Offline_color'] = 'Couleur du texte Absent';
$lang['Hidden_color'] = 'Couleur du texte Invisible';
// End add - Online/Offline/Hidden Mod

// Default avatar MOD, By Manipe (Begin)
$lang['Default_avatar'] = 'Configuration de l\'avatar par d�faut';
$lang['Default_avatar_explain'] = 'Donne aux membres qui n\'en ont pas, un avatar. D�terminez l\'avatar par d�faut des invit�s et des membres, et choisissez si vous voulez l\'afficher pour les membres, les invit�s, pour les deux ou pour personne.';
$lang['Default_avatar_guests'] = 'Invit�s';
$lang['Default_avatar_users'] = 'Membres';
$lang['Default_avatar_both'] = 'Les deux';
$lang['Default_avatar_none'] = 'Aucun';
// Default avatar MOD, By Manipe (End)

//Ajout confirmation �crite
$lang['Active_question_conf_ecrite'] = 'Voulez vous activer la confirmation �crite ?';
$lang['Question_conf_ecrite'] = 'Entrez votre question pour la confirmation de l\'inscription';
$lang['Reponse_conf_write'] = 'Entrez la r�ponse � la question pour la confirmation de l\'inscription';
//Fin confirmation �crite

$lang['Forum_icon'] = 'Ic�ne du forum'; // Forum Icon MOD
$lang['Forum_icon_path'] = 'Chemin du stockage de l\'ic�ne du forum'; // Forum Icon MOD
$lang['Forum_icon_path_explain'] = 'Chemin depuis le r�pertoire de v�tre forum phpBB, comme par exemple ceci : images/forum_icons'; // Forum Icon MOD


$lang['register_mp_subject'] = 'Objet du message priv� envoy� aux nouveaux utilisateurs enregistr�s';
$lang['register_mp'] = 'Corps du message priv� envoy� aux nouveaux utilisateurs enregistr�s';

// BEGIN Disable Registration MOD
$lang['registration_status'] = 'D�sactiver les inscriptions';
$lang['registration_status_explain'] = 'Ceci permet de d�sactiver momentan�ment les inscriptions � votre forum.';
$lang['registration_closed'] = 'Raison de la clot�re des inscriptions';
$lang['registration_closed_explain'] = 'Texte expliquant la raison de la fermeture des inscriptions, qui s\'affichera lorsqu\'un utilisateur voudra s\'inscrire. Laisser blanc pour afficher le texte par d�faut.';
// END Disable Registration MOD 

// Start add - Birthday Mod
$lang['Birthday_required'] = 'Obliger les membres � valider une date de naissance'; 
$lang['Enable_birthday_greeting'] = 'Activer la pop-up \'Joyeux Anniversaire\'';
$lang['Birthday_greeting_expain'] = 'Les membres ayant valid� leur date de naissance pourront recevoir une pop-up \'Joyeux Anniversaire\' lorsqu\'ils visiteront le forum.';
$lang['Next_birthday_greeting'] = 'Prochaine ann�e du pop-up anniversaire';
$lang['Next_birthday_greeting_expain'] = 'Ce champ garde une trace de la prochaine ann�e � laquelle l\'utilisateur recevra une pop-up \'Joyeux Anniversaire\'.';
$lang['Wrong_next_birthday_greeting'] = 'Le choix de la prochaine ann�e du pop-up Joyeux Anniversaire fourni �tait incorrect, veuillez r�essayer une nouvelle fois.';
$lang['Max_user_age'] = 'Age maximum de l\'utilisateur';
$lang['Min_user_age'] = 'Age minimum de l\'utilisateur';
$lang['Birthday_lookforward'] = 'Regarder les dates d\'anniversaires jusqu\'�';
$lang['Birthday_lookforward_explain'] = 'Il s\'agit du nombre de jours jusqu\'o� le script regardera, dans les jours qui suivent, si un membre f�te son anniversaire (en jours).';
// End add - Birthday Mod

//-- mod : resize posted images based on max width -----------------------------
//-- add
$lang['Images_max_size'] = 'Veuillez saisir la taille maximale en pixels';
$lang['Images_max_size_explain'] = 'Toute image d�passant cette valeur sera r�duite automatiquement.';
//-- fin mod : resize posted images based on max width -------------------------

$lang['Jail']='Prison';
$lang['Jail_settings']='Configuration';


//-- mod : overall forum permissions -------------------------------------------
//-- add
$lang['Overall_Permissions'] = 'Permissions Interactives';
$lang['Forum_auth_explain_overall'] = 'Ici vous pouvez changer les niveaux d\'autorisations pour chaque forum. Rappelez vous bien que changer les niveaux de permission des forums affectera les membres qui peuvent faire des opérations diverses dans ceux-ci.';
$lang['Forum_auth_explain_overall_edit'] = 'Premi�rement cliquez sur la couleur de la permission, ensuite cliquez sur la permission du forum que vous voulez changer. Utilisez "Restaurer" pour annuler les changements. Utilisez "Arr�ter l\'addition" pour cesser de faire d\'autres changements.';
$lang['Forum_auth_overall_restore'] = 'Restaurer';
$lang['Forum_auth_overall_stop'] = 'Arr�ter l\'addition';
//-- fin mod : overall forum permissions ---------------------------------------

$lang['user_boulet_title'] = 'Statut de boulet';
$lang['user_boulet_type_0'] = '- N\'est pas un boulet -';
$lang['user_boulet_type_1'] = 'Est un boulet � rediriger vers :';
$lang['user_boulet_type_2'] = 'Est un boulet qui lira le message :';
$lang['user_boulet_type_3'] = 'Est un boulet qui lira dans une page vierge le message :';

$lang['smilies_colonne'] = "Nombre de smiley dans une colonne"; 
$lang['smilies_ligne'] = "Nombre de smiley dans une ligne";

//Beginning Inactive Users

$lang['Users_Inactive'] = 'Utilisateurs inactifs';
$lang['Users_Inactive_Explain'] = 'Si dans "Activation du compte", vous avez choisi "Utilisateur" ou "Administrateur", vous aurez dans cette liste les utilisateurs qui n\'ont jamais eu leur compte activ�.<br /><br />En cliquant sur "Contacter", vous enverrez un e-mail � tous les utilisateurs s�lectionn�s.<br />En cliquant sur "Activer", vous activerez les comptes de tous les utilisateurs s�lectionn�s.<br />En cliquant sur "Supprimer", vous enverrez un e-mail et supprimerez tous les utilisateurs s�lectionn�s.';
$lang['UI_Check_None'] = '"Activation du compte" est sur <b>Aucune</b>.';
$lang['UI_Check_User'] = '"Activation du compte" est sur <b>Utilisateur</b>.';
$lang['UI_Check_Admin'] = '"Activation du compte" est sur <b>Administrateur</b>.';
$lang['UI_Check_Recom'] = '%sLe changer%s.';
$lang['UI_Removed_Users'] = 'Utilisateurs supprim�s';
$lang['UI_User'] = 'Utilisateur';
$lang['UI_Registration_Date'] = 'Registration Date';
$lang['UI_Last_Visit'] = 'Derni�re visite';
$lang['UI_Active'] = 'Actif';
$lang['UI_Email_Sents'] = 'E-mails envoy�s';
$lang['UI_Last_Email_Sents'] = 'Dernier e-mail';
$lang['UI_CheckColor'] = 'Cocher';
$lang['UI_CheckAll'] = 'Tout cocher';
$lang['UI_UncheckAll'] = 'Tout d�cocher';
$lang['UI_InvertChecked'] = 'Inverser';
$lang['UI_Contact_Users'] = 'Contacter';
$lang['UI_Delete_Users'] = 'Supprimer';
$lang['UI_Activate_Users'] = 'Activer';
$lang['UI_select_user_first'] = 'Vous devez d\'abord s�lectionner un utilisateur';
$lang['UI_return'] = 'Cliquez %sici%s pour retourner � l\'administration des utilisateurs inactifs';
$lang['UI_Deleted_Users'] = 'Les utilisateurs s�lectionn�s ont �t� supprim�s';
$lang['UI_Activated_Users'] = 'Les utilisateurs s�lectionn�s ont eu leur compte activ�';
$lang['UI_Alert_Days'] = "jours";
$lang['UI_with_zero_messages'] = "avec 0 messages";
$lang['UI_Alert_Every'] = "Tous les";
$lang['UI_Alert_UpTo'] = "Jusqu'�";
$lang['UI_Alert_Over'] = "Plus de";

//-- mod : last active topic on index ------------------------------------------
//-- add
$lang['Last_topic_title_length'] = 'Longueur du titre du dernier sujet sur l\'index';
$lang['Last_topic_title_length_explain'] = 'Choisissez la longueur en nombre de caract&egrave;res des titres des derniers messages affich&eacute;s sur la page d\'index, de mani&egrave;re &agrave; &eacute;viter une d&eacute;formation de celle-ci d�e &agrave; des titres trop long. Renseignez cette valeur &agrave; 0 si vous ne d&eacute;sirez pas raccourcir ces titres.';
$lang['Last_topic_title_redirect'] = 'Le titre du sujet sur l\'index doit rediriger vers le';
$lang['Latest_topic'] = 'Premier message';
$lang['Latest_post'] = 'Dernier message';
//-- fin mod : last active topic on index --------------------------------------

// crewstyle's mod : Annonce Globale
$lang['Global_Announce'] = 'Annonce Globale';
$lang['Annonce_Globale_Index'] = 'Afficher les Annonces Globales sur l\'Index ?';
// crewstyle's mod : Annonce Globale

//-- mod : last active topic on index ------------------------------------------
//-- add
$lang['Last_topic_title_length'] = 'Longueur du titre du dernier sujet sur l\'index';
$lang['Last_topic_title_length_explain'] = 'Choisissez la longueur en nombre de caract&egrave;res des titres des derniers messages affich&eacute;s sur la page d\'index, de mani&egrave;re &agrave; &eacute;viter une d&eacute;formation de celle-ci d�e &agrave; des titres trop long. Renseignez cette valeur &agrave; 0 si vous ne d&eacute;sirez pas raccourcir ces titres.';
//-- fin mod : last active topic on index --------------------------------------

$lang['Group_salary']='Salaire des groupes';
$lang['Group_salary_title_explain']='Ici vous pouvez �diter les salaires des groupes';
$lang['Group_salary_group_name']='Nom';
$lang['Group_salary_group_desc']='Description';
$lang['Group_salary_group']='Groupes';
$lang['Group_salary_salary']='Salaire';
$lang['Group_salary_points']='Points';
$lang['Group_salary_updated']='Mise � jour des salaires des groupes effectu�es avec succ�s';
$lang['Group_salary_return']='Cliquez %sici%s pour retourner � la gestion des salaires des groupes';
$lang['Group_salary_update_error']='Erreur durant la mise � jour des salaires des groupes';
$lang['Group_salary_settings']='Configuration'; 
$lang['Group_salary_cron']='Activer le paiement automatique des salaires'; 
$lang['Group_salary_time']='Payer les salaires tous les :';
$lang['Group_salary_manual_updated']='Paiement des salaires effectu�';
$lang['Group_salary_manual_update']='En cliquant sur le bouton ci-dessous , vous pouvez verser d�s maintenant les salaires aux membres des groupes .';

$lang['card_warn_level'] = 'Maximum de carton jaune que vous pouvez attribuer a un user.';

// Medal MOD 
$lang['Medals'] = 'Administration des m�dailles'; 
$lang['Manage'] = 'Gestion'; 
$lang['Medal_Config'] = 'Configuration des m�dailles'; 
$lang['Medal_Config_explain'] = 'Le formulaire ci-dessous vous permettra de personnaliser toutes les options g�n�rales des m�dailles.'; 
$lang['Medal_setting'] = 'Configuration des M�dailles'; 
$lang['Allow_medal'] = 'Permettre l\'affichage des m�dailles dans Viewtopic.'; 
$lang['Medal_rand'] = 'Permettre l\'affichage de m�dailles al�atoires dans Viewtopic.'; 
$lang['Medal_rand_explain'] = 'Les images seront affich� dans un ordre al�atoire. Ceci fonctionne seulement si vous permettez l\'affichage des m�dailles dans viewtopic.'; 
$lang['Medal_display'] = 'Tableau de M�dailles (Lignes x Colonnes)'; 
$lang['Medal_display_explain'] = 'D�finissez combien de lignes et de colonnes poss�dera la table des m�dailles dans <b>Viewtopic</b><br />Par exemple, 1 ligne et 1 colonne affiche une image, et 1 ligne et 2 colonnes affiche 2 images.<br />Faites en sorte de configurer ceci de fa�on � ce que votre viewtopic ne soit pas d�form�.'; 
$lang['Medal_size'] = 'Dimensions des m�dailles dans Viewtopic'; 
$lang['Medal_size_explain'] = '(Hauteur x Largeur en pixels)<br />Si vous laissez vide, les images seront affich�es en taille originale.'; 
$lang['Click_return_medalcfg'] = 'Cliquez %sIci%s pour retourner � la Configuration des M�dailles.'; 
$lang['Medal_admin'] = 'Administration des M�dailles'; 
$lang['Medal_admin_explain'] = 'A partir de ce panneau, vous pouvez administrer toutes vos m�dailles. Vous pouvez supprimer, cr�er et �diter des m�dailles. Vous pouvez choisir des mod�rateurs et d�finir les noms et descriptions des m�dailles.'; 
$lang['Updated_medal'] = 'La m�daille a �t� mise � jour avec succ�s'; 
$lang['Added_new_medal'] = 'La nouvelle m�daille a �t� cr��e avec succ�s'; 
$lang['Deleted_medal'] = 'La m�daille a �t� supprim�e avec succ�s'; 
$lang['New_medal'] = 'Cr�er'; 
$lang['medal_name'] = 'Nom de la M�daille'; 
$lang['medal_description'] = 'Description de la M�daille'; 
$lang['medal_image'] = 'Image de la M�daille'; 
$lang['medal_image_explain'] = 'Utilisez ceci pour d�finir une image associ�e a la m�daille.<br />(Relative au chemin racine de phpBB2)'; 
$lang['No_medal_name'] = 'Vous devez entrer un nom pour cette m�daille !'; 
$lang['No_medal_description'] = 'Vous devez entrer une description pour cette m�daille !'; 
$lang['No_medal_image'] = 'Vous devez sp�cifier une image pour cette m�daille !'; 
$lang['Must_select_medal'] = 'Une M�daille doit �tre sp�cifi�e'; 
$lang['Click_return_medaladmin'] = 'Cliquez %sIci%s pour retourner � l\'Administration des m�dailles.'; 
$lang['Medal_mod'] = 'Mod�rateur de la M�daille'; 
$lang['Medal_mod_admin'] = 'Administration des mod�rateurs de m�dailles'; 
$lang['Medal_mod_admin_explain'] = 'A partir de ce panneau, vous pouvez d�finir des mod�rateurs pour vos m�dailles.'; 
$lang['Medal_mod_username'] = 'Choisisser un ou plusieurs utilisateurs pour �tre mod�rateur de cette m�daille'; 
$lang['Medal_unmod_username'] = 'Retirer un ou plusieurs utilisateurs du poste de mod�rateur de cette m�daille '; 
$lang['Medal_unmod_username_explain'] = 'Vous pouvez retirer plusieurs utilisateurs en une fois en utilisant la combinaison appropri�e clavier/souris pour votre navigateur et votre ordinateur.'; 
$lang['No_medal_mod'] = 'Pas de mod�rateur'; 
$lang['Medal_mod_update_sucessful'] = 'Le mod�rateur de la m�daille a �t� mis � jour avec succ�s !'; 
$lang['Click_return_medal_mod_admin'] = 'Cliquez %sIci%s pour revenir � l\'Administration des mod�rateurs de m�dailles.';

$lang['Sponsor_settings']='Parrainage';
$lang['Sponsor_gain_register']='Gains � l\'enregistrement d\'un filleul';
$lang['Sponsor_title']='Gestion du syst�me de parrainage';
$lang['Sponsor_title_explain']='Ici vous pouvez configurer les options relatives au syst�me de parrainage';
$lang['Sponsor_gain_first']='Gain pour chaque filleul :';
$lang['Sponsor_gain_second']='Gain pour chaque petit filleul :';
$lang['Sponsor_gain_points']='Gain sur chaque point gagn� par un filleul';
$lang['Sponsor_gain_points_explain']='Pour que ceci fonctionne , vous devez utiliser les mods ADR et point system 2.0.9 et avoir install� l\'add-on correspondant';
$lang['Sponsor_base']='Activer le syst�me de gain au pourcentage';
$lang['Sponsor_points']='Pourcentage de gain';
$lang['Sponsor_points_explain']='Ceci repr�sente le pourcentage de la valeur ( arrondi � l\'inf�rieur ) qu\'un parrain gagne sur les tous les gains de ses filleuls';
$lang['Sponsor_updated']='Mise � jour du syst�me de parrainage effectu�e avec succ�s';
$lang['Sponsor_settings_return']='Cliquez %sici%s pour revenir � la configuration du syst�me de parrainage .';

$lang['Forum_enter_limit'] = 'Nombre de message minimun :';
$lang['Forum_enter_limit_error'] = 'Vous devez avoir post� messages pour acc�der a ce forum.';

// +Reorder ACP Categories
$lang['Reorder_ACP_categories'] = "R�organiser les Cat�gories";
$lang['ACP_cat_display'] = "Titre des cat�gories";
$lang['ACP_cat_title'] = "R�organiser les cat�gories apr l\'ACP";
$lang['ACP_cat_explain'] = "ACP Categories are the headings in the navigation list on the left hand pane. Use this form to change the order they are displayed in. Categories not explicitly ordered will be displayed alphabetically by internal identifier after the ordered ones.";
$lang['ACP_cat_moved'] = "Les cat�gories ont �t� correctement r�organis�es.";
$lang['Reorder'] = "R�organiser";
$lang['Click_return_catadmin'] = 'Cliquez %sici%s pour retourner a la r�organsiation des cat�gories.';
// -Reorder ACP Categories

//-- mod : Edit Forums On Index -----------------------------------------------------
//-- add
$lang['successfull_popup']	= 'Forum �dit� avec succ�s.';
$lang['close_popup'] 		= 'Fermer la fen�tre';
//-- fin mod : Edit Forums On Index -------------------------------------------------


//
// That's all Folks!
// -------------------------------------------------
?>

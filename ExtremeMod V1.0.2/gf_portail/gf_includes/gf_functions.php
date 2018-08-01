<?php

/*
 * Fonction language_include inclu les fichiers de langue
 * selon le nom de la catégorie
 * par exemple language_include('main') va inclure les fichiers
 * lang_main.php de phpBB et lang_main_portal.php de Gf
 *
 * @param $category est le nom de la categorie
 *
 */
function language_include($category) 
{ 
	global $phpbb_root_path, $board_config, $lang, $phpEx; 
	
	$filename = $phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_' . $category . '.' . $phpEx;
	$filename_gf = $phpbb_root_path . 'gf_portail/gf_lang/gf_' . $board_config['default_lang'] . '/gf_lang_' . $category . '.' . $phpEx;

	@include($filename); 
	@include($filename_gf);
}

?>
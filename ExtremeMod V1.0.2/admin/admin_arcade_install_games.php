<?php
/***************************************************************************
 *                       admin_arcade_install_games.php
 *                            -------------------
 *   Commencé le          : Samedi 23 Avril 2005
 *   Auteur               : Cig (http://www.gf-phpbb.com)
 *   version              : 1.1 (20/05/2005)
 *
 *   Les jeux (fichiers .swf) doivent être placés dans le dossier adéquat
 *   selon le type du jeu : games/install_games/typeN (où N va de 0 à 4).
 *   Les vignettes correspondantes doivent toujours être installées dans le
 *   dossier games/pics (comme pour une installation de jeux "manuelle").
 *
 *   Ce programme lit le dossier games/install_games/typeN (où N va de 0 à 4),
 *   à la recherche de fichiers d'extension SWF (jeux Flash).
 *   Il vérifie si un jeu de même nom existe déjà dans la table phpbb_games.
 *   Si le jeu n'existe pas, il crée l'enregistrement correspondant dans la
 *   table, prenant par principe le même nom pour la vignette du jeu, ainsi
 *   que pour la variable score.
 *   Il déplace ensuite le fichier .swf dans le dossier games.
 *   Il déplace ensuite le fichier .gif dans le dossier games/pics.
 ***************************************************************************/

define('IN_PHPBB', 1);

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');

if( !empty($setmodules) )
{
  include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);
	$file = basename(__FILE__);
	$module['Administration_Arcade_VPro']['Install_Jeux'] = "$file";
	return;
}

require('./pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

$categorie = 1;
install_games($categorie);

include('./page_footer_admin.'.$phpEx);
exit;

//
// Cette fonction installe les jeux dans la catégorie dont l'id est passé en paramètre
//
function install_games($categorie)
{
    global $db, $lang;
    // On vérifie l'existence de la catégorie
    $sql = "SELECT COUNT(*) AS nb  FROM " . ARCADE_CATEGORIES_TABLE . " WHERE arcade_catid = " . $categorie ;
    if( !($result = $db->sql_query($sql)) )
    {
    	message_die(GENERAL_ERROR, "Couldn't read categories table", "", __LINE__, __FILE__, $sql);
    }

    $row = $db->sql_fetchrow($result);
    if ($row['nb'] == 0)        // Si la catégorie n'existe pas, on arrête tout
    {
    	message_die(GENERAL_ERROR, $lang['Games_cat_not_exist']);
    }

    $nJeux = 0;

    // Installation pour chaque type de jeux (0 à 4)
    for ($i = 0; $i < 5; $i++)
    {
        $nJeux += install_type($i, $categorie);
    }

    // Si au moins un jeu a été installé, on synchronise la catégorie
    // et on affiche le nb de jeux installés
    if ($nJeux > 0)
    {
        // Synchro
        $sql = "SELECT COUNT(*) AS nbelmt FROM " . GAMES_TABLE . " WHERE arcade_catid = " . $categorie ;
        if( !$result = $db->sql_query($sql) )
        {
        	message_die(GENERAL_ERROR, "Couldn't read games table", "", __LINE__, __FILE__, $sql);
        }
        $row = $db->sql_fetchrow($result);
        $nbelmt = $row['nbelmt'];
        $sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = $nbelmt WHERE arcade_catid = " . $categorie ;
        if( !$result = $db->sql_query($sql) )
        {
        	message_die(GENERAL_ERROR, "Couldn't write categories table", "", __LINE__, __FILE__, $sql);
        }
        // fin synchro
    }
      
    switch ($nJeux) 
    {
        case 0:
            message_die(GENERAL_MESSAGE, $lang['No_game_added']);
            break;
        case 1:
            message_die(GENERAL_MESSAGE, $lang['One_game_added']);
            break;
        default:
            message_die(GENERAL_MESSAGE, $nJeux . $lang['Games_added']);
    }
    return;
}

//
// Cette fonction installe les jeux de type $type dans la catégorie passée en paramètre
//
function install_type($type, $categorie)
{
    global $db;
    
    $i = 0;
    $games_dir = './../games/install_games/type' . $type ;
    
    if ( !(is_dir($games_dir)) )           // Si le dossier à traiter n'existe pas, on retourne 0 jeu installé
     {
        return 0;
     }
    
    $games = opendir($games_dir);
    
    // On parcourt le dossier $games
    while (false !== ($file = readdir($games)))
    {
        if ( eregi(".swf", $file) )             // Si le fichier est un .SWF (donc un jeu)
        {                                       // on vérifie que ce jeu n'est pas déjà installé dans la table
           $sql= "select game_swf from ". GAMES_TABLE ." where game_swf = '$file'";
           $result = $db->sql_query($sql);
           if( !($result) )
           {
              message_die(GENERAL_ERROR, "Couldn't read games table", "", __LINE__, __FILE__, $sql);
           }
        
           if (!($db -> sql_fetchrow($result)))
           {
              $game_name = substr($file, 0, strlen($file) - 4);
              $game_pic = $game_name . '.gif';
        
              $sql = "INSERT INTO " . COMMENTS_TABLE . " ( game_id, message ) VALUES ('', '')";
              if( !($db->sql_query($sql)) )
              {
                message_die(GENERAL_ERROR, "Couldn't update comments table", "", __LINE__, __FILE__, $sql);
              }

              $sql = "INSERT INTO ". GAMES_TABLE ."
              (game_id, game_pic, game_desc, game_name, game_swf, game_scorevar, game_type, game_width, game_height, arcade_catid)
              values ('', '".$game_pic."', '', '".$game_name."', '".$file."', '".$game_name."', $type, '550', '380', $categorie)";
              $result = $db->sql_query($sql);
              if( !($result) )
              {
                 message_die(GENERAL_ERROR, "Couldn't write games table", "", __LINE__, __FILE__, $sql);
              }
        
              if ( !(rename($games_dir . '/' . $file, './../games/' . $file)) )
              {
                 message_die(GENERAL_ERROR, $file . $lang['Move_file']);
              }

              // S'il existe une image correspondant au jeu, on la déplace dans games/pics
              if (is_file ($games_dir . '/' . $game_pic))
              {
                  rename($games_dir . '/' . $game_pic, './../games/pics/' . $game_pic);
              }

              $i++;
           }
        }
    }
  closedir($games);    // Fermeture du dossier $games
  return $i;           // On retourne le nb de jeux installés
}

?>
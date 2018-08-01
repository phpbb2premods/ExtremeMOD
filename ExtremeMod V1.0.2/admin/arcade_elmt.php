<?php
/***************************************************************************
*                               arcade_elmt.php
*                              -----------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

 define('IN_PHPBB', 1);

$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
require( $phpbb_root_path . 'gf_funcs/gen_funcs.' . $phpEx);
include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_arcade.' . $phpEx);

$mode   = get_var2(array(
  'name' => 'mode',
	'intval' => false,
  'okvar' => array('create','edit','editsave','createsave','delete', 'move'),
	'default' => '')
	);

$arcade_catid = get_var2(array('name'=>'arcade_catid', 'intval'=>true ));
$last_catid = get_var2(array('name'=>'last_catid', 'intval'=>true ));
$game_name = get_var2(array('name'=>'game_name' ));
$game_id = get_var2(array('name'=>'game_id', 'intval'=>true ));
$game_swf = get_var2(array('name'=>'game_swf', 'method'=>'POST' ));
$game_pic = get_var2(array('name'=>'game_pic', 'method'=>'POST' ));
$game_desc = get_var2(array('name'=>'game_desc', 'method'=>'POST' ));
$game_scorevar = get_var2(array('name'=>'game_scorevar', 'method'=>'POST' ));
$game_type = get_var2(array('name'=>'game_type', 'intval'=>true, 'method'=>'POST' ));
$game_width = get_var2(array('name'=>'game_width', 'intval'=>true, 'method'=>'POST' ));
$game_height = get_var2(array('name'=>'game_height', 'intval'=>true, 'method'=>'POST' ));
$point_pay = get_var2(array('name'=>'point_pay', 'intval'=>true, 'method'=>'POST' ));
$point_prize = get_var2(array('name'=>'point_prize', 'intval'=>true, 'method'=>'POST' ));
$game_cheat_control = get_var2(array('name'=>'game_cheat_control', 'intval'=>true, 'method'=>'POST' ));
$game_pad = get_var2(array('name'=>'game_pad', 'intval'=>true, 'method'=>'POST' ));
$highscore_type = get_var2(array('name'=>'highscore_type', 'intval'=>true, 'method'=>'POST' ));
$game_auth_acc = get_var2(array('name'=>'game_auth_acc', 'intval'=>true, 'method'=>'POST' ));

if ($arcade_catid == 0 )$arcade_catid = get_var2(array('name'=>'arcade_catid', 'intval'=>true ));

/*-----------------------------------------------/
/ A-t'on demandé de déplacer un jeu ?
/-----------------------------------------------*/
if ( $mode == 'move')
{
// récupération des infos de déplacement
 $gid2 = get_var2(array('name'=>'gid2', 'intval'=>true, 'method'=>'GET' ));
 $game_order = get_var2(array('name'=>'game_order'  , 'intval'=>true, 'method'=>'GET' ));
 $gorder2 = get_var2(array('name'=>'gorder2'  , 'intval'=>true, 'method'=>'GET' ));

$sql = "UPDATE " . GAMES_TABLE . " SET
	 game_order = $game_order + $gorder2 - game_order
	 WHERE game_id = '$game_id' OR game_id = '$gid2'";

if( !$db->sql_query($sql) )
 {
	message_die(GENERAL_ERROR, "Couldn't update games table", "", __LINE__, __FILE__, $sql);
 }
}
			
if( !empty($mode) )
{
	switch($mode)
	{
		case 'create':
		case 'edit':
			if ($mode == 'edit')
			{
				$l_title = $lang['Edit_game'];
				$newmode = 'editsave';
				//récupération des infos du jeu
				$sql = "SELECT * FROM " . GAMES_TABLE . " WHERE game_id = '$game_id' ORDER BY game_order ASC";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
				}

				if( !($row = $db->sql_fetchrow($result)) )
				{
					message_die(GENERAL_ERROR, "Aucun jeu ne correspond à cet ID ($game_id)");
				}
				$arcade_catid = $row['arcade_catid'];
				$game_name = $row['game_name'];
				$game_desc = $row['game_desc'];
				$game_pic = $row['game_pic'];
				$game_swf = $row['game_swf'];
    	  $game_width = $row['game_width'];
	      $game_height = $row['game_height'];
				$point_pay = $row['point_pay'];
				$point_prize = $row['point_prize'];
				$game_scorevar = $row['game_scorevar'];
				$game_cheat_control = $row['game_cheat_control'];
        $game_pad = $row['game_pad'];
        $game_cheat_control_yes = ( $game_cheat_control ) ? "checked=\"checked\"" : "";
        $game_cheat_control_no = ( !$game_cheat_control ) ? "checked=\"checked\"" : "";
				$highscore_type = $row['game_highscore_type'];
        $highscore_type_asc = ( $highscore_type ) ? "checked=\"checked\"" : "";
        $highscore_type_desc = ( !$highscore_type ) ? "checked=\"checked\"" : "";
				$selected0 = ( $row['game_type']==0 ) ? "selected='selected'" : "" ;
				$selected1 = ( $row['game_type']==1 ) ? "selected='selected'" : "" ;
				$selected2 = ( $row['game_type']==2 ) ? "selected='selected'" : "" ;
				$selected3 = ( $row['game_type']==3 ) ? "selected='selected'" : "" ;
        $selected4 = ( $row['game_type']==4 ) ? "selected='selected'" : "" ;

        $game_auth_acc = $row['game_auth_acc'];
        $game_auth_acc_yes = ( $game_auth_acc ) ? "checked=\"checked\"" : "";
        $game_auth_acc_no = ( !$game_auth_acc ) ? "checked=\"checked\"" : "";

				// Récupération de la liste des catégories
				$sql = "SELECT arcade_cattitle, arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . " ORDER BY arcade_cattitle ASC";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Impossible d'acceder à la liste des catégories", '', __LINE__, __FILE__, $sql);
				}
				$liste_cat = '';
				while ( $row = $db->sql_fetchrow($result))
				{
				  $selected = ( $row['arcade_catid'] == $arcade_catid ) ? " selected='selected'" : "" ;
				  $liste_cat .= "<option value='" . $row['arcade_catid'] . "' $selected >" . $row['arcade_cattitle'] . "</option>\n";
				}

				$hidden_fields  = "<input type='hidden' name='mode' value='editsave' />";
				$hidden_fields .= "<input type='hidden' name='game_id' value='$game_id' />";
				$hidden_fields .= "<input type='hidden' name='last_catid' value='$arcade_catid' />";
			  } else {
				$l_title = $lang['Create_game'];
				$newmode = 'createsave';

				$game_desc = "";
				$game_pic = "";
				$game_swf = "";
	      $game_width = 550;
    	  $game_height = 380;
				$point_pay = 0;
				$point_prize = 0;
				$game_cheat_control = 0;
        $game_cheat_control_yes = ( $game_cheat_control ) ? "checked=\"checked\"" : "";
        $game_cheat_control_no = ( !$game_cheat_control ) ? "checked=\"checked\"" : "";
				$game_scorevar = "";
				$highscore_type = 0;
        $highscore_type_asc = ( $highscore_type ) ? "checked=\"checked\"" : "";
        $highscore_type_desc = ( !$highscore_type ) ? "checked=\"checked\"" : "";
				$selected0 = "";
				$selected1 = "";
				$selected2 = "";
				$game_auth_acc = 0;
				$game_auth_acc_yes = ( $game_auth_acc ) ? "checked=\"checked\"" : "";
        $game_auth_acc_no = ( !$game_auth_acc ) ? "checked=\"checked\"" : "";
				
				// Récupération de la liste des catégories
				$sql = "SELECT arcade_cattitle, arcade_catid FROM " . ARCADE_CATEGORIES_TABLE . " ORDER BY arcade_cattitle ASC";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Impossible d'acceder à la liste des catégories", '', __LINE__, __FILE__, $sql);
				}
				$liste_cat = '';
				while ( $row = $db->sql_fetchrow($result))
				{
				  $liste_cat .= "<option value='" . $row['arcade_catid'] . "' >" . $row['arcade_cattitle'] . "</option>\n";
				}

				$hidden_fields = "<input type='hidden' name='mode' value='createsave' />";
			}

			$template->set_filenames(array(
			  "body" => "admin/admin_edit_games.tpl")
			  );

		  $template->assign_vars(array(
	    "L_YES" => $lang['Yes'],
	    "L_NO" => $lang['No'],
			"L_EDIT_GAME" => $l_title,
			"L_EDIT_GAME_EXPLAIN" => $lang['Edit_game_explain'],
			"L_GAME_SETTINGS" => $lang['Game_settings'],
			"L_GAME_NAME" => $lang['Game_name'],
			"L_GAME_NAME_EXPLAIN" => $lang['Game_name_explain'],
			"L_DESCRIPTION" => $lang['Game_description'],
			"L_DESCRIPTION_EXPLAIN" => $lang['Game_description_explain'],
      "L_GAME_PAD" => $lang['Game_pad'],
      "L_GAME_PAD_EXPLAIN" => $lang['Game_pad_explain'],

      "L_GAME_AUTH_ACC" => $lang['Game_auth_acc'],
			"L_GAME_AUTH_ACC_EXPLAIN" => $lang['Game_auth_acc_explain'],

			"L_VIGNETTE" => $lang['Game_thumbail'],
			"L_VIGNETTE_EXPLAIN" => $lang['Game_thumbail_explain'],
			"L_SWF" => $lang['Game_swf'],
			"L_SWF_EXPLAIN" => $lang['Game_swf_explain'],
      "L_WIDTH" => $lang['Game_width'],
      "L_WIDTH_EXPLAIN" => $lang['Game_width_explain'],
    	"L_HEIGHT" => $lang['Game_height'],
	    "L_HEIGHT_EXPLAIN" => $lang['Game_height_explain'],
			"L_CATEGORIE" => $lang['Game_category'],
			"L_CATEGORIE_EXPLAIN" => $lang['Game_category_explain'],
			"L_SCORE_SETTINGS" => $lang['Score_settings'],
			"L_SCORE_SETTINGS_EXPLAIN" => $lang['Score_settings_explain'],
			"L_SCOREVARIABLE" => $lang['Game_scorevariable'],
			"L_SCOREVARIABLE_EXPLAIN" => $lang['Game_scorevariable_explain'],
			"L_GESTION_SCORE" => $lang['Game_typescore'],
			"L_GESTION_SCORE_EXPLAIN" => $lang['Game_typescore_explain'],
			"L_CHEAT_CONTROL" => $lang['Cheat_control'],
			"L_CHEAT_CONTROL_EXPLAIN" => $lang['Cheat_control_explain'],
      "L_POINT_PAY" => sprintf($lang['point_pay'],$board_config['points_name']),
			"L_POINT_PAY_EXPLAIN"  => sprintf($lang['point_pay_explain'],$board_config['points_name']),
			"L_POINT_PRIZE"  => sprintf($lang['point_prize'],$board_config['points_name']),
			"L_POINT_PRIZE_EXPLAIN"  => sprintf($lang['point_prize_explain'],$board_config['points_name']),
			"L_HIGHSCORE_TYPE" => $lang['Game_HsType'],
			"L_HIGHSCORE_TYPE_EXPLAIN" => $lang['Game_HsType_explain'],
      "L_ASC" => $lang['Game_asc'],
      "L_DESC" => $lang['Game_desc'],
			"L_SUBMIT" => $lang['Submit'],

			"S_ACTION" => append_sid("arcade_elmt.$phpEx"),
			"S_MODE" => $newmode,
      "GAME_PAD" => $game_pad,
			"GAME_NAME" => strip_htmlchars($game_name),
			"GAME_DESCRIPTION" => strip_htmlchars($game_desc),
			"GAME_VIGNETTE" => $game_pic,
			"GAME_SWF" => $game_swf,
      "GAME_WIDTH" => $game_width,
      "GAME_HEIGHT" => $game_height,
			"POINT_PAY"  => $point_pay,
			"POINT_PRIZE"  => $point_prize,
			"CHEAT_CONTROL_YES" => $game_cheat_control_yes,
			"CHEAT_CONTROL_NO" => $game_cheat_control_no,
			"SCOREVARIABLE" => $game_scorevar,
			"HIGHSCORE_TYPE_ASC" => $highscore_type_asc,
			"HIGHSCORE_TYPE_DESC" => $highscore_type_desc,
			"SELECTED0" => $selected0,
			"SELECTED1" => $selected1,
			"SELECTED2" => $selected2,
			"SELECTED3" => $selected3,
      "SELECTED4" => $selected4,
      "S_CATEGORIE" => $liste_cat,
      
			"GAME_AUTH_ACC_YES" => $game_auth_acc_yes,
			"GAME_AUTH_ACC_NO" => $game_auth_acc_no,

			"S_HIDDEN_FIELDS" => $hidden_fields)
		  );

		  $template->pparse('body');
		  include('page_footer_admin.'.$phpEx);
		  break;

  		case 'createsave':
			if( trim($game_name) == "" )
			{
				message_die(GENERAL_ERROR, "Impossible de créer un jeu sans nom.");
			}

			if( trim($game_swf) == "" )
			{
				message_die(GENERAL_ERROR, "Impossible de créer un jeu sans fichier swf.");
			}

			$sql = "SELECT MAX(game_order) AS max_order
				FROM " . GAMES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'obtenir le dernier numéro d'ordre de la table jeux", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_order = $row['max_order'];
			$next_order = $max_order + 10;

			$sql = "INSERT INTO " . GAMES_TABLE . " ( game_order, game_pic, game_desc, game_highscore, game_highdate, game_highuser, game_name, game_swf, game_width, game_height, game_scorevar, game_type, arcade_catid, point_pay, point_prize, game_cheat_control, game_pad, game_highscore_type, game_auth_acc ) " .
				"VALUES ($next_order, '$game_pic', '" . str_replace("\'", "''", $game_desc) . "', 0, 0, 0, '" . str_replace("\'", "''", $game_name) . "', '$game_swf', '$game_width', '$game_height', '$game_scorevar', '$game_type', '$arcade_catid', '$point_pay', '$point_prize', '$game_cheat_control', '$game_pad', '$highscore_type', '$game_auth_acc')";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in games table", "", __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = arcade_nbelmt + 1 WHERE arcade_catid = $arcade_catid";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
			}

			//Comments
			$sql = 'SELECT * FROM ' . GAMES_TABLE . ' WHERE game_order = '.$next_order; 			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldnot update comments table', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$game_id = $row['game_id'];
			
			$sql = "INSERT INTO " . COMMENTS_TABLE . " ( game_id, message ) VALUES ($game_id, '')"; 			
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldnot update comments table', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['Games_updated'] . "<br /><br />" . sprintf($lang['Click_return_gameadmin'], "<a href=\"" . append_sid("arcade_elmt.$phpEx?arcade_catid=$arcade_catid") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
			break;

		case 'editsave':
			$sql = "UPDATE " . GAMES_TABLE . " SET 
			game_name = '" . str_replace("\'", "''", $game_name) . "',
			game_desc = '" . str_replace("\'", "''", $game_desc) . "',
			game_pic = '" . $game_pic . "',
			game_scorevar = '" . $game_scorevar . "',
			game_swf = '" . $game_swf . "',
			game_width = " . $game_width . ",
			game_height = " . $game_height . ",
			point_pay = " . $point_pay . ",
			point_prize = " . $point_prize . ",
			game_cheat_control = " . $game_cheat_control . ",
			game_type = " . $game_type . ",
			arcade_catid = " . $arcade_catid . ",
      game_pad = " . $game_pad . ",
			game_highscore_type = " . $highscore_type . ",
			game_auth_acc = " . $game_auth_acc . "
			WHERE game_id = " . $game_id;
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update game informations", "", __LINE__, __FILE__, $sql);
			}

			if ($arcade_catid != $last_catid)
			{
				$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = arcade_nbelmt + 1 WHERE arcade_catid = $arcade_catid";				
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
				}

				$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = arcade_nbelmt - 1 WHERE arcade_catid = $last_catid";				
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Games_updated'] . "<br /><br />" . sprintf($lang['Click_return_gameadmin'], "<a href=\"" . append_sid("arcade_elmt.$phpEx?arcade_catid=$last_catid") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
			break;
	}
}

//on verifie si on a demandé la mise à jour des zones de sélection
$valid_select = get_var2(array(
  'name'=>'valid',
  'default'=>'')
  );

$type_select  = get_var2(array(
  'name'=> 'selection',
	'intval'  => false,
  'okvar'   => array('Z','X','S','Y','R','W','T'),
	'default' => '')
	);

if ($valid_select<>'')
{
	$selected_check = ( isset($HTTP_POST_VARS['select_list']) ) ?  $HTTP_POST_VARS['select_list'] : array();

	$select_id_sql = '';
	$csc = count($selected_check);
	
	if($csc==0)
	{
		message_die(GENERAL_MESSAGE, 'Aucun jeu n\'est sélectionné', '', __LINE__, __FILE__, $sql);
	}

	for($i = 0; $i < $csc; $i++)
	{
		$select_id_sql .= ( ( $select_id_sql != '' ) ? ', ' : '' ) . $selected_check[$i];
	}

	switch ($type_select)
	{
		case 'Z':
			$sql = "DELETE FROM " . SCORES_TABLE . "
				WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des scores', '', __LINE__, __FILE__, $sql);
			}
      $sql = "DELETE FROM " . ARCADE_CHAMPIONNAT_TABLE . "  
         WHERE game_id IN ($select_id_sql) "; 
      if ( !$db->sql_query($sql) ) 
      { 
        message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table du championnat', '', __LINE__, __FILE__, $sql); 
      }
			$sql = "UPDATE " . GAMES_TABLE . " SET game_highscore = 0, game_highuser = 0, game_highdate = 0 
				WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . COMMENTS_TABLE . " SET message = '' WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from comments table', '', __LINE__, __FILE__, $sql);
			}
			break;
		case 'X':
			$sql = "DELETE FROM " . ARCADE_VOTE_TABLE . " WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from arcade_vote table', '', __LINE__, __FILE__, $sql);
			}
			break;
		case 'S':
			$sql = "DELETE FROM " . SCORES_TABLE . " 
				WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des scores', '', __LINE__, __FILE__, $sql);
			}
      $sql = "DELETE FROM " . ARCADE_CHAMPIONNAT_TABLE . "  
         WHERE game_id IN ($select_id_sql) "; 
      if ( !$db->sql_query($sql) ) 
      { 
        message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table du championnat', '', __LINE__, __FILE__, $sql); 
      }
			$sql = "DELETE FROM " . GAMES_TABLE . " 
				WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
			}
			$sql = "DELETE FROM " . ARCADE_VOTE_TABLE . " WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from arcade_vote table', '', __LINE__, __FILE__, $sql);
			}
			$sql = "DELETE FROM " . ARCADE_CHEATER_TABLE . " WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des cheaters arcade', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . COMMENTS_TABLE . " SET message = '' WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from comments table', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . ARCADE_CATEGORIES_TABLE . " SET arcade_nbelmt = arcade_nbelmt - $csc WHERE arcade_catid = $arcade_catid";				
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
			}
			break;
		case 'Y':
			$sql = "SELECT SUM(score_set) AS nbset, game_id FROM " . SCORES_TABLE . "
				WHERE game_id IN ($select_id_sql) GROUP BY game_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible d\'accéder à la table des scores', '', __LINE__, __FILE__, $sql);
			}
			while ($row = $db->sql_fetchrow($result))
			{
				$sql2 = "UPDATE " . GAMES_TABLE . " SET game_set = " . $row['nbset'] .
					" WHERE game_id = " . $row['game_id'];
				if ( !$db->sql_query($sql2) )
				{
					message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
				}
			}
			break;
    case 'R':
      $sql = "UPDATE " . GAMES_TABLE . " SET game_set = 0
        WHERE game_id IN ($select_id_sql) ";
      if ( !$db->sql_query($sql) )
      {
        message_die(GENERAL_ERROR, 'Impossible de mettre à  jour la table des jeux', '', __LINE__, __FILE__, $sql);
      }
      break;
    case 'T':
      $sql = "UPDATE " . GAMES_TABLE . " SET game_ultimate_highscore = 0, game_ultimate_highdate = 0, game_ultimate_highuser = 0
        WHERE game_id IN ($select_id_sql) "; 
      if ( !$db->sql_query($sql) ) 
      { 
        message_die(GENERAL_ERROR, 'Impossible de mettre à  jour la table des jeux', '', __LINE__, __FILE__, $sql); 
      } 
      break;
    case 'W': 
			$sql = "DELETE FROM " . SCORES_TABLE . "
				WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des scores', '', __LINE__, __FILE__, $sql);
			}
      $sql = "DELETE FROM " . ARCADE_CHAMPIONNAT_TABLE . "  
         WHERE game_id IN ($select_id_sql) "; 
      if ( !$db->sql_query($sql) ) 
      { 
         message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table du championnat', '', __LINE__, __FILE__, $sql); 
      }
			$sql = "DELETE FROM " . ARCADE_VOTE_TABLE . " WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from arcade_vote table', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . COMMENTS_TABLE . " SET message = '' WHERE game_id IN ($select_id_sql) ";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could delete from comments table', '', __LINE__, __FILE__, $sql);
			}
      $sql = "UPDATE " . GAMES_TABLE . " SET game_highscore = 0, game_highdate = 0, game_highuser = 0, game_ultimate_highscore = 0, game_ultimate_highdate = 0, game_ultimate_highuser = 0, game_set = 0 
        WHERE game_id IN ($select_id_sql) "; 
      if ( !$db->sql_query($sql) ) 
      { 
        message_die(GENERAL_ERROR, 'Impossible de mettre à  jour la table des jeux', '', __LINE__, __FILE__, $sql); 
      } 
      break;
		default :;
	}
}
//---------------------------
$hidden_fields = "<input type='hidden' name='arcade_catid' value='$arcade_catid'/>";

$template->set_filenames(array(
		"body" => "admin/arcade_manage_body.tpl")
	);

  $template->assign_vars(array(
		"L_MANAGE_GAME" => $lang['Manage_game'],
		"L_SETS" => $lang['Arcade_sets'],
		"L_SCORES" => $lang['Arcade_scores'],
		"L_FOR_GAME_SELECTION" => $lang['For_game_selection'],
		"L_MANAGE_GAME_EXPLAIN" => $lang['Manage_game_explain'],
		"L_PATH_NEW_LOGO" => $lang['Path_new_logo'],
		"L_ACTION" => $lang['Action'],
		"L_EDIT" => $lang['Edit'],
		"L_DEPLACE" => $lang['Deplace'],
		"L_GAME" => $lang['Arcade_game'],
		"L_GAME" => $lang['Arcade_game'],
		"L_VOTES" => $lang['nb_vote_game'],
		"L_ULTIME_HIGHSCORE" => $lang['game_ultimate_highscore'],
		"L_HIGHSCORE" => $lang['Arcade_highscore'],

		"ADD_GAME" => $lang['Add_new'],
		"INITIAL_SCORE" => $lang['Initialize_score'],
		"INITIAL_ULTIME_RECORDS" => $lang['Initialize_ultime_highscore'],
		"INITIAL_VOTE" => $lang['Initialize_vote'],
		"DELETE_GAME" => $lang['Delete_game'],
		"SYNCHRO_GAME_SET" => $lang['Synchro_game_set'],
    "RESET_GAME_SET" => $lang['Reset_game_set'],
    "RESET_ARCADE_GAME" => $lang['Reset_arcade_game'],
		"HIDDEN_FIELDS" => $hidden_fields,
		"ALL_CHECKED" => $lang['All_checked'],
		"NOTHING_CHECKED" => $lang['Nothing_checked'],
		"S_ACTION" => append_sid("arcade_elmt.$phpEx"))
	  );

$sql = "SELECT COUNT(s.score_game) as nbset, g.game_id, game_order, g.game_name, g.game_highscore, g.game_ultimate_highscore, g.game_set, AVG(rating) AS average FROM " . GAMES_TABLE . " g left join " . SCORES_TABLE ." s on s.game_id = g.game_id left join ".ARCADE_VOTE_TABLE." v ON g.game_id = v.game_id WHERE g.arcade_catid = '$arcade_catid' GROUP BY g.game_id ORDER BY g.game_order";

if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql);
}

$liste_jeux = array();
while( $row = $db->sql_fetchrow($result) )
{
  $liste_jeux[] = $row;
}

$cg = count($liste_jeux);

for( $i=0 ; $i<$cg; $i++)
{
  $template->assign_block_vars('ligne_jeu', array(
    'TITRE_JEU' => $liste_jeux[$i]['game_name'],
    'NB_SETS' => $liste_jeux[$i]['game_set'],
    'NB_SCORES' => $liste_jeux[$i]['nbset'],
    'NB_VOTES' => round($liste_jeux[$i]['average'],1),
    'RECORD_JEU' => $liste_jeux[$i]['game_highscore'],
    'ULTIME_RECORD_JEU' => $liste_jeux[$i]['game_ultimate_highscore'],
	  'CHECK' => $liste_jeux[$i]['game_id'],
	  'L_UP' => ( $i > 0) ? $lang['Up_arcade_cat'] . '<br />' : '',
    'L_DOWN' => ( $i < $cg-1 ) ? $lang['Down_arcade_cat'] : '',
 	  'U_UP' => ( $i > 0) ? append_sid("arcade_elmt.$phpEx?mode=move&amp;arcade_catid=$arcade_catid&amp;game_id=" . $liste_jeux[ $i ]['game_id'] . "&amp;gid2=" . $liste_jeux[ $i - 1 ]['game_id'] . "&amp;game_order=" .  $liste_jeux[ $i ]['game_order'] . "&amp;gorder2=" . $liste_jeux[ $i - 1 ]['game_order']) : '',
 	  'U_DOWN' => ( $i < $cg-1) ? append_sid("arcade_elmt.$phpEx?mode=move&amp;arcade_catid=$arcade_catid&amp;game_id=" . $liste_jeux[ $i ]['game_id'] . "&amp;gid2=" . $liste_jeux[ $i + 1 ]['game_id'] . "&amp;game_order=" .  $liste_jeux[ $i ]['game_order'] . "&amp;gorder2=" . $liste_jeux[ $i + 1 ]['game_order']) : '',
	  'U_EDIT' => append_sid("arcade_elmt.$phpEx?mode=edit&amp;game_id=" . $liste_jeux[$i]['game_id'])
	  )
	);
}

// On affiche la combo action a effectuer sur la sélection seulement s'il existe au moins un jeu dans la liste
if ( $cg>0 )
{
  $template->assign_block_vars('switch_liste_non_vide', array());
}

  $template->pparse('body');
  include('page_footer_admin.'.$phpEx);
?>
<?php
/***************************************************************************
*                               functions_jumpbox_arcade.php
*                              ------------------------------
*     begin                : 1 Mars 2007
*     copyright            : Gf-phpbb.com
*
*
****************************************************************************/

function make_arcadejumpbox($action, $match_game_id = 0) 
{ 
   global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID; 

   $sql = "SELECT c.arcade_catid, c.arcade_cattitle, c.arcade_catorder 
      FROM " . ARCADE_CATEGORIES_TABLE . " c, " . GAMES_TABLE . " f 
      WHERE f.arcade_catid = c.arcade_catid 
      GROUP BY c.arcade_catid, c.arcade_cattitle, c.arcade_catorder 
      ORDER BY c.arcade_catorder"; 
   if ( !($result = $db->sql_query($sql)) ) 
   { 
      message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql); 
   } 
    
   $arcade_category_rows = array(); 
   while ( $row = $db->sql_fetchrow($result) ) 
   { 
      $arcade_category_rows[] = $row; 
   } 

   if ( $total_arcade_categories = count($arcade_category_rows) ) 
   { 
      $sql = "SELECT * 
         FROM " . GAMES_TABLE . " 
         ORDER BY arcade_catid, game_order"; 
      if ( !($result = $db->sql_query($sql)) ) 
      { 
         message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql); 
      } 

      $boxarcadestring = '<select name="gid" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option selected value="-1">' . $lang['Select_game'] . '</option>'; 

      $game_rows = array(); 
      while ( $row = $db->sql_fetchrow($result) ) 
      { 
         $game_rows[] = $row; 
      } 

      if ( $total_games = count($game_rows) ) 
      { 
         for($i = 0; $i < $total_arcade_categories; $i++) 
         { 
            $boxarcadestring_games = ''; 
            for($j = 0; $j < $total_games; $j++) 
            { 
               if ( $game_rows[$j]['arcade_catid'] == $arcade_category_rows[$i]['arcade_catid'] && $game_rows[$j]['auth_view'] <= AUTH_REG ) 
               { 

//               if ( $game_rows[$j]['arcade_catid'] == $arcade_category_rows[$i]['arcade_catid'] && $is_auth[$game_rows[$j]['game_id']]['auth_view'] ) 
//               { 
                  $selected = ( $game_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
                  $boxarcadestring_games .=  '<option value="' . $game_rows[$j]['game_id'] . '">|&nbsp;' . $game_rows[$j]['game_name'] . '</option>'; 

                  // 
                  // Add an array to $nav_links for the Mozilla navigation bar. 
                  // 'chapter' and 'forum' can create multiple items, therefore we are using a nested array. 
                  // 
                  $nav_links['chapter forum'][$game_rows[$j]['game_id']] = array ( 
                     'url' => append_sid("games.$phpEx?gid=" . $game_rows[$j]['game_id']), 
                     'title' => $game_rows[$j]['game_name'] 
                  ); 
                        
               } 
            } 

            if ( $boxarcadestring_games != '' ) 
            { 
               $boxarcadestring .= '<option value="-1">&nbsp;</option>'; 
               $boxarcadestring .= '<option value="-1">[' . $arcade_category_rows[$i]['arcade_cattitle'] . ']</option>'; 
               $boxarcadestring .= '<option value="-1">----------------</option>'; 
               $boxarcadestring .= $boxarcadestring_games; 
            } 
         } 
      } 

      $boxarcadestring .= '</select>'; 
   } 
   else 
   { 
      $boxarcadestring .= '<select name="gid" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>'; 
   } 

   if ( !empty($SID) ) 
   { 
      $boxarcadestring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />'; 
   } 

   $template->set_filenames(array( 
      'jumpbox_arcade' => 'jumpbox_arcade.tpl') 
   ); 
   $template->assign_vars(array( 
      'L_GO' => $lang['Go'], 
      'L_JUMP_TO' => $lang['Jump_to'], 
      'L_SELECT_GAME' => $lang['Select_game'], 

      'S_JUMPBOX_SELECT' => $boxarcadestring, 
      'S_JUMPBOX_ACTION' => append_sid($action)) 
   ); 
   $template->assign_var_from_handle('JUMPBOX_ARCADE', 'jumpbox_arcade'); 

   return; 
} 
?>
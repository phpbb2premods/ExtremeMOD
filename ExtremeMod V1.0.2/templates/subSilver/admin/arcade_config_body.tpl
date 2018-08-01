<script language="JavaScript" type="text/javascript">
<!--//
function _dom_menu()
 {
  return this;
 }
_dom_menu.prototype.objref = function(id)
 {
   return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
 }
_dom_menu.prototype.cancel_event = function()
 {
 if ( window.event )
  {
    window.event.cancelBubble = true;
  }
}
_dom_menu.prototype.set = function(menu) {
  var menus = new Array(
	'authsoptions',
	'presentoptions',
      'affichageoptions',
	'generaleoptions',
	'championnatoptions',
	'cagnotteoptions',
      'tauxoptions',
      'commentairesoptions',
	'restrictionsoptions',
	'displayoptions',
	'favorisoptions',
	'ratingoptions',
	'statsoptions',
	'pointsoptions'
	);
var object;
var opt;
var flag;
for (i=0; i < menus.length; i++)
  {
    cur_menu = menus[i];
    object = this.objref(cur_menu);
if ( object && object.style )
 {
   object.style.display = (cur_menu == menu) ? '' : 'none';
 }
opt = this.objref(cur_menu + '_opt');
if ( opt && opt.style )
 {
   opt.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
 }
flag = this.objref(cur_menu + '_flag');
if ( flag && flag.style )
 {
   flag.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
   flag.className = (cur_menu == menu) ? 'row1 gensmall' : 'row2 gensmall';
 }
}
this.cancel_event();
}
// instantiate
dom_menu = new _dom_menu();
//-->
</script>

<div class="maintitle">{L_CONFIGURATION_TITLE}</div>
<br />
<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
<table cellpadding="0" cellspacing="2" border="0" width="100%"><tr><td width="250" valign="top">

<table cellpadding="4" cellspacing="1" border="0" class="forumline" width="250">
      <tr>
        <th class="thHead" colspan="2">{L_CONFIGURATION_TITLE}</th>
      </tr>
      <tr>
        <td id="authsoptions_flag" class="row1 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('authsoptions'); return false;"><div id="authsoptions_opt" class="gensmall" style="font-weight: bold;"><a href="#" onclick="dom_menu.set('authsoptions'); return false;">{I_OPT_GUEST}</a></div></td>
      </tr>
      <tr>
        <td id="presentoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('presentoptions'); return false;"><div id="presentoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('presentoptions'); return false;">{I_OPT_PRES}</a></div></td>
      </tr>
      <tr>
        <td id="affichageoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('affichageoptions'); return false;"><div id="affichageoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('affichageoptions'); return false;">{I_OPT_TABLES}</a></div></td>
      </tr>

      <tr>
        <td id="generaleoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('generaleoptions'); return false;"><div id="generaleoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('generaleoptions'); return false;">{I_OPT_GEN}</a></div></td>
      </tr>
      <tr>
        <td id="championnatoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('championnatoptions'); return false;"><div id="championnatoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('championnatoptions'); return false;">{I_OPT_CHAMP}</a></div></td>
      </tr>
      <tr>
       <td id="cagnotteoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
       <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('cagnotteoptions'); return false;"><div id="cagnotteoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('cagnotteoptions'); return false;">{I_OPT_CAG_CHAMP}</a></div></td>
      </tr>
      <tr>
       <td id="tauxoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
       <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('tauxoptions'); return false;"><div id="tauxoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('tauxoptions'); return false;">{I_OPT_TAU_CHAMP}</a></div></td>
      </tr>
      <tr>
        <td id="commentairesoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('commentairesoptions'); return false;"><div id="commentairesoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('commentairesoptions'); return false;">{I_OPT_COMMENTS}</a></div></td>
      </tr>
      <tr>
        <td id="restrictionsoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('restrictionsoptions'); return false;"><div id="restrictionsoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('restrictionsoptions'); return false;">{I_OPT_REST}</a></div></td>
      </tr>
      <tr>
        <td id="displayoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('displayoptions'); return false;"><div id="displayoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('displayoptions'); return false;">{I_OPT_GAMES}</a></div></td>
      </tr>
      <tr>
        <td id="favorisoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('favorisoptions'); return false;"><div id="favorisoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('favorisoptions'); return false;">{I_OPT_FAV}</a></div></td>
      </tr>
      <tr>
        <td id="ratingoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('ratingoptions'); return false;"><div id="ratingoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('ratingoptions'); return false;">{I_OPT_VOTE}</a></div></td>
      </tr>
      <tr>
        <td id="statsoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('statsoptions'); return false;"><div id="statsoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('statsoptions'); return false;">{I_OPT_STATS}</a></div></td>
      </tr>
      <tr>
        <td id="pointsoptions_flag" class="row2 gensmall" align="right" width="10">&raquo;</td>
        <td style="cursor: pointer; font-weight: normal;" class="row1" onmouseover="this.className='row2'; this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.className='row1'; this.style.fontWeight='normal';" onclick="dom_menu.set('pointsoptions'); return false;"><div id="pointsoptions_opt" class="gensmall"><a href="#" onclick="dom_menu.set('pointsoptions'); return false;">{I_OPT_POINTS}</a></div></td>
      </tr>
</table>

</td><td valign="top" width="100%">

<table id="authsoptions" class="forumline" border="0" cellpadding="4" cellspacing="1" width="100%">
	<tr>
	  <th class="thHead" colspan="2">{L_AUTHS_ARCA_SETTINGS}</th>
	</tr>
<!-- auths_permissions -->
      <tr> 
        <td class="row1" width="62%">{L_AUTHS_PLAY}<br /><span class="gensmall">{L_AUTHS_PLAY_EXPLAIN}</span></td>
        <td class="row2" width="38%"> <input type="radio" name="auths_play" value="1" {S_AUTHS_PLAY_YES} />{L_YES}&nbsp; &nbsp; <input type="radio" name="auths_play" value="0" {S_AUTHS_PLAY_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="62%">{L_AUTHS_SCORE}<br /><span class="gensmall">{L_AUTHS_SCORE_EXPLAIN}</span></td>
        <td class="row2" width="38%"> <input type="radio" name="auths_score" value="1" {S_AUTHS_SCORE_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="auths_score" value="0" {S_AUTHS_SCORE_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="62%">{L_AUTHS_VOTE_HIDDEN}<br /><span class="gensmall">{L_AUTHS_VOTE_HIDDEN_EXPLAIN}</span></td>
        <td class="row2" width="38%"> <input type="radio" name="auths_vote_hidden" value="1" {S_AUTHS_VOTE_HIDDEN_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="auths_vote_hidden" value="0" {S_AUTHS_VOTE_HIDDEN_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="62%">{L_AUTHS_VOTE}<br /><span class="gensmall">{L_AUTHS_VOTE_EXPLAIN}</span></td>
        <td class="row2" width="38%"> <input type="radio" name="auths_vote" value="1" {S_AUTHS_VOTE_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="auths_vote" value="0" {S_AUTHS_VOTE_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="62%">{L_AUTHS_LIMIT_GAME}<br /><span class="gensmall">{L_AUTHS_LIMIT_GAME_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input class="post" type="text" maxlength="5" size="5" name="page_guest_admin" value="{S_PAGE_GUEST_LIMIT}" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="presentoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr>
        <th colspan="2">{L_PRESENT_SETTINGS}</th>
      </tr>
<!-- forum_presentation -->
      <tr> 
        <td class="row1" width="45%"><span class="genmed">{L_PRESENT_FID}</span></td>
        <td class="row2"><input class="post" type="text" maxlength="5" size="5" name="present_fid" value="{PRESENT_FID}" /></td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_PRES_GAME}<br /><span class="gensmall">{L_PRES_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="game_pres" value="1" {S_GAME_PRES_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="game_pres" value="0" {S_GAME_PRES_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_REDIRECTION_PRES}<br /><span class="gensmall">{L_REDIRECTION_PRES_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="message_pres" value="1" {S_MESSAGE_PRES_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="message_pres" value="0" {S_MESSAGE_PRES_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="affichageoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr>
        <th colspan="2">{L_TABLES_SEE}</th>
      </tr>
<!-- use_topstatarcade_arcade -->
      <tr> 
        <td class="row1" width="38%">{L_TOPSTATS_SEE}<br /><span class="gensmall">{L_TOPSTATS_SEE_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="topstats_see" value="1" {S_TOPSTATS_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="topstats_see" value="0" {S_TOPSTATS_SEE_NO} />{L_NO}</td>
      </tr>
<!-- use_championnat_arcade -->
      <tr> 
        <td class="row1" width="38%">{L_CHAMP_SEE}<br /><span class="gensmall">{L_CHAMP_SEE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="champ_see" value="1" {S_CHAMP_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="champ_see" value="0" {S_CHAMP_SEE_NO} />{L_NO}</td>
      </tr>
<!-- use_headingarcade_arcade -->
      <tr> 
        <td class="row1" width="62%">{L_HEADING_SEE}<br /><span class="gensmall">{L_HEADING_SEE_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="heading_see" value="1" {S_HEADING_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="heading_see" value="0" {S_HEADING_SEE_NO} />{L_NO}</td>
      </tr>
<!-- use_whoisplaying_arcade -->
      <tr> 
        <td class="row1" width="62%">{L_WHOISPLAY_SEE}<br /><span class="gensmall">{L_WHOISPLAY_SEE_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="whoisplay_see" value="1" {S_WHOISPLAY_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="whoisplay_see" value="0" {S_WHOISPLAY_SEE_NO} />{L_NO}</td>
      </tr>
<!-- use_categories_arcade -->
      <tr> 
        <td class="row1" width="62%">{L_CAT_SEE}<br /><span class="gensmall">{L_CAT_SEE_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="cat_see" value="1" {S_CAT_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="cat_see" value="0" {S_CAT_SEE_NO} />{L_NO}</td>
      </tr>
<!-- use_favoris_arcade -->
      <tr> 
        <td class="row1" width="62%">{L_FAVORIS_SEE}<br /><span class="gensmall">{L_FAVORIS_SEE_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="favoris_see" value="1" {S_FAVORIS_SEE_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="favoris_see" value="0" {S_FAVORIS_SEE_NO} />{L_NO}</td>
      </tr>
      <tr>
        <th colspan="2">{L_TABLES_SEEG}</th>
      </tr>
<!-- use_topstatarcade_game -->
      <tr> 
        <td class="row1" width="62%">{L_TOPSTATS_SEEG}<br /><span class="gensmall">{L_TOPSTATS_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="topstats_seeg" value="1" {S_TOPSTATS_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="topstats_seeg" value="0" {S_TOPSTATS_SEEG_NO} />{L_NO}</td>
      </tr>
<!-- use_championnat_game -->
      <tr> 
        <td class="row1" width="62%">{L_CHAMP_SEEG}<br /><span class="gensmall">{L_CHAMP_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"> <input type="radio" name="champ_seeg" value="1" {S_CHAMP_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="champ_seeg" value="0" {S_CHAMP_SEEG_NO} />{L_NO}</td>
      </tr>
<!-- use_headingarcade_game -->
      <tr> 
        <td class="row1" width="62%">{L_HEADING_SEEG}<br /><span class="gensmall">{L_HEADING_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="heading_seeg" value="1" {S_HEADING_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="heading_seeg" value="0" {S_HEADING_SEEG_NO} />{L_NO}</td>
      </tr>
<!-- use_whoisplaying_game -->
      <tr> 
        <td class="row1" width="62%">{L_WHOISPLAY_SEEG}<br /><span class="gensmall">{L_WHOISPLAY_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="whoisplay_seeg" value="1" {S_WHOISPLAY_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="whoisplay_seeg" value="0" {S_WHOISPLAY_SEEG_NO} />{L_NO}</td>
      </tr>
<!-- use_categories_game -->
      <tr> 
        <td class="row1" width="62%">{L_CAT_SEEG}<br /><span class="gensmall">{L_CAT_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="cat_seeg" value="1" {S_CAT_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="cat_seeg" value="0" {S_CAT_SEEG_NO} />{L_NO}</td>
      </tr>
<!-- use_favoris_arcade_game -->
      <tr> 
        <td class="row1" width="62%">{L_FAVORIS_SEEG}<br /><span class="gensmall">{L_FAVORIS_SEEG_EXPLAIN}</span></td>
        <td class="row2" width="38%"><input type="radio" name="favoris_seeg" value="1" {S_FAVORIS_SEEG_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="favoris_seeg" value="0" {S_FAVORIS_SEEG_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="generaleoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr>
        <th colspan="2">{L_GENERAL_SETTINGS}</th>
      </tr>
<!-- use_category_mod -->
      <tr> 
        <td class="row1" width="38%">{L_USE_CATEGORY_MOD}<br /><span class="gensmall">{L_USE_CATEGORY_MOD_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="use_category_mod" value="1" {S_USE_CATEGORY_MOD_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_category_mod" value="0" {S_USE_CATEGORY_MOD_NO} />{L_NO}</td>
      </tr>
<!-- category_preview_games -->
      <tr> 
        <td class="row1" width="38%">{L_CATEGORY_PREVIEW_GAMES}<br /><span class="gensmall">{L_CATEGORY_PREVIEW_GAMES_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="category_preview_games" value="{S_CATEGORY_PREVIEW_GAMES}" class="post" /></td>
      </tr>
<!-- games_par_page -->
      <tr> 
        <td class="row1" width="38%">{L_GAMES_PAR_PAGE}<br /><span class="gensmall">{L_GAMES_PAR_PAGE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="games_par_page" value="{S_GAMES_PAR_PAGE}" class="post" /></td>
      </tr>
<!-- game_order -->
      <tr> 
        <td class="row1" width="38%">{L_GAME_ORDER}<br /><span class="gensmall">{L_GAME_ORDER_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <select name='game_order' class="post" >{S_GAME_ORDER}</select></td>
      </tr>
<!-- linkcatitle_align -->
      <tr> 
        <td class="row1" width="38%">{L_LINKCATITTLE_ALIGN}<br /><span class="gensmall">{L_LINKCATITTLE_ALIGN_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <select name='linkcatittle_align' class="post" >{S_LINKCATITTLE_ALIGN}</select></td>
      </tr>
<!-- linkcat_align -->
      <tr> 
        <td class="row1" width="38%">{L_LINKCAT_ALIGN}<br /><span class="gensmall">{L_LINKCAT_ALIGN_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <select name='linkcat_align' class="post" >{S_LINKCAT_ALIGN}</select></td>
      </tr>
<!-- games_cheater_submit -->
      <tr>
        <td class="row1" width="38%">{L_GAMES_CHEATER_SUBMIT}<br /><span class="gensmall">{L_GAMES_CHEATER_SUBMIT_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="games_cheater_submit" value="1" {S_GAMES_CHEATER_SUBMIT_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="games_cheater_submit" value="0" {S_GAMES_CHEATER_SUBMIT_NO} />{L_NO}</td>
      </tr>
<!-- games_time_tolerance -->
      <tr>
        <td class="row1" width="38%">{L_GAMES_TIME_TOLERANCE}<br /><span class="gensmall">{L_GAMES_TIME_TOLERANCE_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="text" maxlength="100" size="5" name="games_time_tolerance" value="{S_GAMES_TIME_TOLERANCE}" class="post" /></td>
      </tr>
<!-- color_use -->
      <tr>
        <td class="row1" width="38%">{L_COLOR_USE}<br /><span class="gensmall">{L_COLOR_USE_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="color_use" value="1" {S_COLOR_USE_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="color_use" value="0" {S_COLOR_USE_NO} />{L_NO}</td>
      </tr>
<!-- color_admins -->
      <tr>
        <td class="row1" width="38%">{L_COLOR_ADMIN}<br /><span class="gensmall"></span></td>
        <td class="row2" width="62%">#<input type="text" maxlength="6" size="7" name="color_admin" value="{S_COLOR_ADMIN}" /></td>
      </tr>
<!-- color_mods -->
      <tr>
        <td class="row1" width="38%">{L_COLOR_MOD}<br /><span class="gensmall"></span></td>
        <td class="row2" width="62%">#<input type="text" maxlength="6" size="7" name="color_mod" value="{S_COLOR_MOD}" /></td>
      </tr>
<!-- color_users -->
      <tr>
        <td class="row1" width="38%">{L_COLOR_USER}<br /><span class="gensmall"></span></td>
        <td class="row2" width="62%">#<input type="text" maxlength="6" size="7" name="color_user" value="{S_COLOR_USER}" /></td>
      </tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="championnatoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_ARCADE_CHAMPIONNAT_AREA_SETTINGS}</th>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_ONE}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_ONE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_one" value="{S_CHAMPIONNAT_POINTS_ONE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_TWO}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_TWO_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_two" value="{S_CHAMPIONNAT_POINTS_TWO}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_THREE}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_THREE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_three" value="{S_CHAMPIONNAT_POINTS_THREE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_FOUR}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_FOUR_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_four" value="{S_CHAMPIONNAT_POINTS_FOUR}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_FIVE}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_FIVE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_five" value="{S_CHAMPIONNAT_POINTS_FIVE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_SIX}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_SIX_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_six" value="{S_CHAMPIONNAT_POINTS_SIX}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_SEVEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_SEVEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_seven" value="{S_CHAMPIONNAT_POINTS_SEVEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_EIGHT}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_EIGHT_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_eight" value="{S_CHAMPIONNAT_POINTS_EIGHT}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_NINE}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_NINE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_nine" value="{S_CHAMPIONNAT_POINTS_NINE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_TEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_TEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_ten" value="{S_CHAMPIONNAT_POINTS_TEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_ELEVEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_ELEVEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_eleven" value="{S_CHAMPIONNAT_POINTS_ELEVEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_TWELVE}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_TWELVE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_twelve" value="{S_CHAMPIONNAT_POINTS_TWELVE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_THIRTEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_THIRTEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_thirteen" value="{S_CHAMPIONNAT_POINTS_THIRTEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_FOURTEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_FOURTEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_fourteen" value="{S_CHAMPIONNAT_POINTS_FOURTEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_FIVETEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_FIVETEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_fiveteen" value="{S_CHAMPIONNAT_POINTS_FIVETEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_SIXTEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_SIXTEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_sixteen" value="{S_CHAMPIONNAT_POINTS_SIXTEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_SEVENTEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_SEVENTEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_seventeen" value="{S_CHAMPIONNAT_POINTS_SEVENTEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_EIGHTEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_EIGHTEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_eighteen" value="{S_CHAMPIONNAT_POINTS_EIGHTEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_NINETEEN}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_NINETEEN_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_nineteen" value="{S_CHAMPIONNAT_POINTS_NINETEEN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_POINTS_TWENTY}<br /><span class="gensmall">{L_CHAMPIONNAT_POINTS_TWENTY_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_points_twenty" value="{S_CHAMPIONNAT_POINTS_TWENTY}" /> </td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="reset" value="{L_CHAMPIONNAT_RESET}" class="mainoption" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="cagnotteoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_ARCADE_CHAMPIONNAT_AREA_SETTINGS}</th>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_USE_CAGNOTTE_MOD}<br /><span class="gensmall">{L_USE_CAGNOTTE_MOD_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="use_cagnotte_mod" value="1" {S_USE_CAGNOTTE_MOD_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_cagnotte_mod" value="0" {S_USE_CAGNOTTE_MOD_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CAGNOTTE}<br /><span class="gensmall">{L_CAGNOTTE_EXPLAIN}</span></td>
        <td class="row2"> <input type="text" maxlength="100" name="cagnotte" value="{S_CAGNOTTE}" /> </td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_CAGNOTTE}<br /><span class="gensmall">{L_USE_POINTS_CAGNOTTE_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_cagnotte" value="1" {S_USE_POINTS_CAGNOTTE_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_cagnotte" value="0" {S_USE_POINTS_CAGNOTTE_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="cagnotte_distrib" value="{L_CAGNOTTE_DISTRIB}" class="mainoption" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="tauxoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_ARCADE_CHAMPIONNAT_AREA_SETTINGS}</th>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_CAT_USE}<br /><span class="gensmall">{L_CAT_USE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="cat_use" value="1" {S_CAT_USE_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="cat_use" value="0" {S_CAT_USE_NO} />{L_NO}</td>
      </tr>
      <tr>
	  <td class="row1" width="38%">{L_CHAMPIONNAT_CATEGORIE}<br /><span class="gensmall">{L_CHAMPIONNAT_CATEGORIE_EXPLAIN}</span></td>
	  <td class="row2" width="62%">{CHAMPIONNAT_CAT_SELECT}</td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX}<br /><span class="gensmall">{L_CHAMPIONNAT_TAUX_EXPLAIN}</span></td></td>
        <td class="row2" width="62%"></td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_UN}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_un" value="{S_CHAMPIONNAT_TAUX_UN}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_DEUX}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_deux" value="{S_CHAMPIONNAT_TAUX_DEUX}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_TROIS}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_trois" value="{S_CHAMPIONNAT_TAUX_TROIS}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_QUATRE}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_quatre" value="{S_CHAMPIONNAT_TAUX_QUATRE}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_CINQ}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_cinq" value="{S_CHAMPIONNAT_TAUX_CINQ}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_SIX}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_six" value="{S_CHAMPIONNAT_TAUX_SIX}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_SEPT}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_sept" value="{S_CHAMPIONNAT_TAUX_SEPT}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_HUIT}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_huit" value="{S_CHAMPIONNAT_TAUX_HUIT}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_NEUF}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_neuf" value="{S_CHAMPIONNAT_TAUX_NEUF}" /> </td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_CHAMPIONNAT_TAUX_DIX}</td>
        <td class="row2"> <input type="text" maxlength="100" name="championnat_taux_dix" value="{S_CHAMPIONNAT_TAUX_DIX}" /> </td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_USE_AUTO_DISTRIB}<br /><span class="gensmall">{L_USE_AUTO_DISTRIB_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_auto_distrib" value="1" {S_USE_AUTO_DISTRIB_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_auto_distrib" value="0" {S_USE_AUTO_DISTRIB_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_DAY_DISTRIB}<br /><span class="gensmall">{L_DAY_DISTRIB_EXPLAIN}</span></td>
        <td class="row2"><input type="text" maxlength="100" name="day_distrib" value="{S_DAY_DISTRIB}" /> </td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="commentairesoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr>
        <th colspan="2" align="center">{L_COMMENTS_RECREATE}</th>
      </tr>
      <tr>
        <td class="row1" align="center" colspan="2"><span class="gensmall">{L_COMMENTS_RECREATE_EXPLAIN}</span></td>
      </tr>
      <tr> 
        <td class="row1" align="center" colspan="2"><br /><input type="submit" maxlength="100" name="recreate_comments" value="Vider la table des commentaires" /> <br /><br /></td>
      </tr>
      <tr> 
        <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS} <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp; <input type="reset" value="{L_RESET}" class="button" /></td>
      </tr>
</table>

<table id="restrictionsoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_GAME_ACCESS_SETTINGS}</th> 
      </tr> 
<!-- limit_by_posts --> 
      <tr> 
        <td class="row1" width="38%">{L_LIMIT_BY_POSTS}<br /> <span class="gensmall">{L_LIMIT_BY_POSTS_EXPLAIN}</span> </td> 
        <td class="row2" width="62%"> <input type="radio" name="limit_by_posts" value="1" {S_LIMIT_BY_POSTS_YES} /> {L_YES}&nbsp;&nbsp; <input type="radio" name="limit_by_posts" value="0" {S_LIMIT_BY_POSTS_NO} /> {L_NO} </td> 
      </tr> 
<!-- limit_type --> 
      <tr> 
        <td class="row1" width="38%">{L_LIMIT_TYPE}<br /> <span class="gensmall">{L_LIMIT_TYPE_EXPLAIN}</span> </td> 
        <td class="row2" width="62%"> <input type="radio" name="limit_type" value="posts" {S_LIMIT_TYPE_POSTS} /> {L_POSTS_ONLY}<br /> <input type="radio" name="limit_type" value="date" {S_LIMIT_TYPE_DATE} /> {L_POSTS_DATE} </td> 
      </tr> 
<!-- posts_needed --> 
      <tr> 
        <td class="row1" width="38%">{L_POSTS_NEEDED}<br /> <span class="gensmall">{L_POSTS_NEEDED_EXPLAIN}</span> </td> 
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="posts_needed" value="{S_POSTS_NEEDED}" class="post" /> </td> 
      </tr> 
<!-- days_limit --> 
      <tr> 
        <td class="row1" width="38%">{L_DAYS_LIMIT}<br /> <span class="gensmall">{L_DAYS_LIMIT_EXPLAIN}</span> </td> 
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="days_limit" value="{S_DAYS_LIMIT}" class="post" /> </td> 
      </tr>
      <tr>
        <th colspan="2">{L_QUOTA_SETTINGS}</th>
      </tr>
<!-- quotas_arcade -->
      <tr>
        <td class="row1" width="38%">{L_NB_PARTIES}<br /><span class="gensmall">{L_NB_PARTIES_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="text" maxlength="3" size="5" name="quota_games" value="{S_NB_PARTIES}" class="post" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="displayoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_GAMES_AREA_SETTINGS}</th>
      </tr>
<!-- display_score -->
      <tr> 
        <td class="row1" width="38%">{L_SCORE_POSITION}<br /><span class="gensmall">{L_SCORE_POSITION_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="scorerow_position" value="left" {S_SCORE_LEFT} />{L_LEFT}<br /><input type="radio" name="scorerow_position" value="right" {S_SCORE_RIGHT} />{L_RIGHT}</td>
      </tr>
<!-- display_ultime_winner_avatar -->
      <tr> 
        <td class="row1" width="38%">{L_DISPLAY_ULTIME_WINNER_AVATAR}<br /><span class="gensmall">{L_DISPLAY_ULTIME_WINNER_AVATAR_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="display_ultime_winner_avatar" value="1" {S_DISPLAY_ULTIME_WINNER_AVATAR_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="display_ultime_winner_avatar" value="0" {S_DISPLAY_ULTIME_WINNER_AVATAR_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_WINNER_ULTIME_AVATAR_POSITION}<br /><span class="gensmall">{L_WINNER_ULTIME_AVATAR_POSITION_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="winner_ultime_avatar_position" value="left" {S_WINNER_ULTIME_AVATAR_LEFT} />{L_LEFT}<br /><input type="radio" name="winner_ultime_avatar_position" value="right" {S_WINNER_ULTIME_AVATAR_RIGHT} />{L_RIGHT}</td>
      </tr>
<!-- display_winner_avatar -->
      <tr> 
        <td class="row1" width="38%">{L_DISPLAY_WINNER_AVATAR}<br /><span class="gensmall">{L_DISPLAY_WINNER_AVATAR_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="display_winner_avatar" value="1" {S_DISPLAY_WINNER_AVATAR_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="display_winner_avatar" value="0" {S_DISPLAY_WINNER_AVATAR_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_WINNER_AVATAR_POSITION}<br /><span class="gensmall">{L_WINNER_AVATAR_POSITION_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="winner_avatar_position" value="left" {S_WINNER_AVATAR_LEFT} />{L_LEFT}<br /><input type="radio" name="winner_avatar_position" value="right" {S_WINNER_AVATAR_RIGHT} />{L_RIGHT}</td>
      </tr>
<!-- maxsize_avatar -->
      <tr> 
        <td class="row1" width="38%">{L_MAXSIZE_AVATAR}<br /><span class="gensmall">{L_MAXSIZE_AVATAR_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="10" size="5" name="maxsize_avatar" value="{S_MAXSIZE_AVATAR}" class="post" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="favorisoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_FAV_SETTINGS}</th>
      </tr>
<!-- use_fav_category -->
      <tr> 
        <td class="row1" width="38%">{L_USE_FAV_CATEGORY}<br /><span class="gensmall">{L_USE_FAV_CATEGORY_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="use_fav_category" value="1" {S_USE_FAV_CATEGORY_YES} />{L_YES}   <input type="radio" name="use_fav_category" value="0" {S_USE_FAV_CATEGORY_NO} />{L_NO}</td>
      </tr>
<!-- nbr_games_fav -->
      <tr> 
        <td class="row1" width="38%">{L_NBR_GAMES_FAV}<br /><span class="gensmall">{L_NBR_GAMES_FAV_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="nbr_games_fav" value="{S_NBR_GAMES_FAV}" class="post" /></td>
      </tr>
<!-- use_hide_fav -->
      <tr> 
        <td class="row1" width="38%">{L_USE_HIDE_FAV}<br /><span class="gensmall">{L_USE_HIDE_FAV_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="use_hide_fav" value="1" {S_USE_HIDE_FAV_YES} />{L_YES}   <input type="radio" name="use_hide_fav" value="0" {S_USE_HIDE_FAV_NO} />{L_NO}</td>
      </tr>
<!-- fav_nbr_in_page -->
      <tr> 
        <td class="row1" width="38%">{L_FAV_NBR_IN_PAGE}<br /><span class="gensmall">{L_FAV_NBR_IN_PAGE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="fav_nbr_in_page" value="{S_FAV_NBR_IN_PAGE}" class="post" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="ratingoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_RATING_AREA}</th>
      </tr>
<!-- use_arcade_vote -->
      <tr> 
        <td class="row1" width="38%">{L_USE_ARCADE_VOTE}<br /><span class="gensmall">{L_USE_ARCADE_VOTE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="radio" name="use_arcade_vote" value="1" {S_USE_ARCADE_VOTE_YES} />{L_YES}   <input type="radio" name="use_arcade_vote" value="0" {S_USE_ARCADE_VOTE_NO} />{L_NO}</td>
      </tr>
<!-- max_rating -->
      <tr> 
        <td class="row1" width="38%">{L_RATING_MAX}<br /><span class="gensmall">{L_RATING_MAX_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="2" name="rating_max" value="{S_RATING_MAX}" class="post" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="statsoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_STATARCADE_SETTINGS}</th>
      </tr>
<!-- stat_par_page -->
      <tr> 
        <td class="row1" width="38%">{L_STAT_PAR_PAGE}<br /><span class="gensmall">{L_STAT_PAR_PAGE_EXPLAIN}</span></td>
        <td class="row2" width="62%"> <input type="text" maxlength="100" size="5" name="stat_par_page" value="{S_STAT_PAR_PAGE}" class="post" /></td>
      </tr>
      <tr>
        <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
      </tr>
</table>

<table id="pointsoptions" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr> 
        <th colspan="2">{L_POINTS_ARCADE_AREA_SETTINGS}</th>
      </tr>
<!-- use_points_mod -->
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_MOD}<br /><span class="gensmall">{L_USE_POINTS_MOD_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_mod" value="1" {S_USE_POINTS_MOD_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_mod" value="0" {S_USE_POINTS_MOD_NO} />{L_NO}</td>
      </tr>
<!-- use_points_win_mod -->
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_WIN_MOD}<br /><span class="gensmall">{L_USE_POINTS_WIN_MOD_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_win_mod" value="1" {S_USE_POINTS_WIN_MOD_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_win_mod" value="0" {S_USE_POINTS_WIN_MOD_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_POINTS_WINNER}<br /><span class="gensmall">{L_POINTS_WINNER_EXPLAIN}</span></td>
        <td class="row2">
	  <table width="100%" cellpadding="3" cellspacing="1" border="0" align="center">
	  <tr valign="middle"> 
	  <td class="row2" width="80%"><input type="radio" name="prize_all_games" value="1" {S_PRIZE_ALL_GAMES_YES} />{L_ALL} ({L_ALL_EXPLAIN_G}) </td>
	  <td class="row2" rowspan="2" ><input type="text" maxlength="100" name="points_winner" size="10" value="{S_POINTS_WINNER}" /></td>
	  </tr>
	  <tr>
	  <td class="row2"><input type="radio" name="prize_all_games" value="2" {S_PRIZE_ALL_GAMES_PGAMES} /> {L_PAYING_GAMES}</td>
	  </tr> 
	  <tr>
	  <td class="row2" colspan="2"><input type="radio" name="prize_all_games" value="0" {S_PRIZE_ALL_GAMES_NO} /> {L_EACH_GAME}</td>
	  </tr>
	  </table>
        </td>
      </tr>
<!-- use_points_pay_mod -->
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_PAY_MOD}<br /><span class="gensmall">{L_USE_POINTS_PAY_MOD_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_pay_mod" value="1" {S_USE_POINTS_PAY_MOD_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_pay_mod" value="0" {S_USE_POINTS_PAY_MOD_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_PAY_CHARGING}<br /><span class="gensmall">{L_USE_POINTS_PAY_CHARGING_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_pay_charging" value="1" {S_USE_POINTS_PAY_CHARGING_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_pay_charging" value="0" {S_USE_POINTS_PAY_CHARGING_NO} />{L_NO}</td>
      </tr>
      <tr> 
        <td class="row1" width="38%">{L_USE_POINTS_PAY_SUBMIT}<br /><span class="gensmall">{L_USE_POINTS_PAY_SUBMIT_EXPLAIN}</span></td>
        <td class="row2" width="62%"><input type="radio" name="use_points_pay_submit" value="1" {S_USE_POINTS_PAY_SUBMIT_YES} />{L_YES}&nbsp;&nbsp; <input type="radio" name="use_points_pay_submit" value="0" {S_USE_POINTS_PAY_SUBMIT_NO} />{L_NO}</td>
      </tr>
      <tr>
        <td class="row1" width="38%">{L_POINTS_PAY}<br /><span class="gensmall">{L_POINTS_PAY_EXPLAIN}</span></td>
        <td class="row2"> <input type="radio" name="pay_all_games" value="1" {S_PAY_ALL_GAMES_YES} /> {L_ALL} ({L_ALL_EXPLAIN}) <input type="text" maxlength="100" name="points_pay" value="{S_POINTS_PAY}" />  <br /><input type="radio" name="pay_all_games" value="0" {S_PAY_ALL_GAMES_NO} /> {L_EACH_GAME} </td>
      </tr>
      <tr> 
        <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS} <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp; <input type="reset" value="{L_RESET}" class="button" /></td>
      </tr>
</table>

</td></tr></table>{S_HIDDEN_FIELDS}
</form>

<table width="20%" border="0" cellpadding="1" cellspacing="1" align="center" class="bodyline">
      <tr> 
        <th colspan="2">{L_VERSION_ARCADE_SETTINGS}</th>
      </tr>
      <tr> 
        <td class="row1" width="90%" align="center"><span class="gensmall"><br />Version {VERSION_ARCADE}<br />by <a target="_blank" href="http://www.Gf-phpbb.com" alt="Gf-phpbb.com" title="Gf-phpbb.com">Gf-phpbb.com</a><br /><br /></span></td>
      </tr>
</table>
<br clear="all" />
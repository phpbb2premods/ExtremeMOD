<script language="javascript" type="text/javascript" src="{U_CFI_JSLIB}"></script>
<script language="javascript" type="text/javascript">
<!--

var CFIG_Version = "DHTML Collapsible Arcade Based on phpMiX MOD v1.1.1";

var CFIG = new _CFIG('CFIG',
		['{IMG_PLUS}', '{IMG_MINUS}'],
		['{IMG_DW_ARROW}', '{IMG_UP_ARROW}'],
		['{COOKIE_PATH}', '{COOKIE_DOMAIN}', (('{COOKIE_SECURE}' == '0') ? false : true)]);
	CFIG.T['cookie'] = '{CFI_COOKIE_NAME}';
	CFIG.T['title'] = ['{L_CFI_OPTIONS}', '{L_CFI_OPTIONS_EX}'];
	CFIG.T['close'] = '{L_CFI_CLOSE}';
	CFIG.T['delete'] = '{L_CFI_DELETE}';
	CFIG.T['restore'] = '{L_CFI_RESTORE}';
	CFIG.T['save'] = '{L_CFI_SAVE}';
	CFIG.T['expand_all'] = '{L_CFI_EXPAND_ALL}';
	CFIG.T['collapse_all'] = '{L_CFI_COLLAPSE_ALL}';
	CFIG.T['u_arcade'] = '{U_ARCADE}';
	CFIG.allowed = true;

	if( CFIG.IsEnabled() && parseInt(CFIG.getQueryVar('c')) > 0 )
	{
		window.location.replace('{U_ARCADE}');
	}
// -->
</script>


{CAT_GAMES}

<!-- affichage de la phrase d'index -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
   <tr>
	<td align="left" valign="middle" width="70%">
	<span class="nav">

<script language="javascript" type="text/javascript">
<!--
	CFIG.writeButton();
// -->
</script>

      <a href="{U_INDEX}" alt="{L_INDEX}" title="{L_INDEX}" class="nav">{L_INDEX}</a></span>
	<span class="nav">-&nbsp;{URL_ARCADE}</span></td>
	<td align="right" valign="middle" width="30%">
      <span class="nav">{SEARCHGAMES}</span></td>
    </tr>
</table>
<script language="javascript" type="text/javascript">
<!--
	CFIG.writePanel();

<!-- BEGIN cat_row -->
CFIG.C['cat_{cat_row.CAT_ID}'] = new _CFIC('{cat_row.CAT_ID}', '{cat_row.DISPLAY}');
<!-- BEGIN game_row -->
if( CFIG.C['cat_{cat_row.CAT_ID}'] ) CFIG.C['cat_{cat_row.CAT_ID}'].add('games_{cat_row.CAT_ID}_{cat_row.game_row.GAME_ID}');
<!-- END game_row -->
<!-- END cat_row -->

function CFIG_slideCat(cat_id, isLink)
{
	if( CFIG && CFIG.currentStep <= 0 )
	{
		if( CFIG.IsEnabled() && CFIG.C['cat_'+cat_id] )
		{
			if( isLink ) return false;
			CFIG.createQueue();
			CFIG.slideGames(cat_id);
			CFIG.execQueue();
			CFIG.saveArcadeState(CFIG.T['cookie']);
			return false;	// omit the default action of the link.
		}
		if( !isLink )
		{
			var u_arcade = CFIG.T['u_arcade'];
			u_arcade += ( u_arcade.indexOf('?') > 0 ? '&' : '?' ) + 'c=' + parseInt(cat_id);
			window.location.replace(u_arcade);
			return false;
		}
	}
	return true;	// let the link do its job.
}
function CFIG_onLoad()
{
	if( CFIG_oldOnLoad )
	{
		CFIG_oldOnLoad();
		CFIG_oldOnLoad = null;
	}
	if( CFIG && CFIG.IsEnabled() )
	{
		CFIG.restoreArcadeState(CFIG.T['cookie']);
	}
}
var CFIG_oldOnLoad = window.onload;
window.onload = CFIG_onLoad;
// -->
</script>

{TOPSTATARCADE}
{CHAMPIONNATARCADE}
{CHAMPIONNATEQUIPE}
{HEADINGARCADE}
{ARCADE_CAT}


<table width="99%" cellpadding="2" cellspacing="1" align="center" border="0" class="bodyline">
   {ARCADE_FAVORIS}
</table><br />

<table width="100%" cellpadding="2" cellspacing="3" border="0">
<!-- BEGIN cat_row -->
  <tr>
      <td>

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
  <tr onclick="CFIG_slideCat('{cat_row.CAT_ID}', false);" style="cursor:pointer;cursor:hand;"  title="{cat_row.CAT_NAME}">
	<td class="cat" align="center">&nbsp;<img name="icon_sign_{cat_row.CAT_ID}" src="{SPACER}" border="0" alt="Réduire / Etendre" title="Réduire / Etendre" />&nbsp;</span> </td>
      <td class="cat" colspan="{ARCADE_COL}" width="95%" align="{LINKCATITTLE_ALIGN}"><span class="cattitle">&nbsp;<a href="{cat_row.CATTITLE}" alt="{cat_row.CAT_NAME}" title="{cat_row.CAT_NAME}">{cat_row.CAT_NAME}</a></span>&nbsp;</td>
  </tr>
  <tr> 
	<td class="cat" height="28" align="center" colspan="2"><span class="cattitle">&nbsp;{L_GAME}&nbsp;</span></td>
      <td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_ULTIMATE_HIGHSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_HIGHSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_YOURSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_VOTES}&nbsp;</span></td>
	<td class="cat" colspan="{ARCADE_COL1}" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_DESC}&nbsp;</span></td>
  </tr>
<!-- BEGIN game_row -->
  <tr id="games_{cat_row.CAT_ID}_{cat_row.game_row.GAME_ID}" style="display:{cat_row.game_row.DISPLAY};">
	 <td class="row1" width="35" align="center">{cat_row.game_row.GAMEPIC}</td>
	 <td class="row1" width="20%" align="left">
	   <span class='genmed'>{cat_row.game_row.GAMELINK}<br />{cat_row.game_row.GAMEPOPUP}</span><br />
	   <span class='gensmall'>{cat_row.game_row.GAMESET}<br />{cat_row.game_row.COUT}<br />{cat_row.game_row.PRIZE}</span>
	 </td>

      <td class="row1" align="center" valign="center" >
         <span class='gen'>
         {cat_row.game_row.NO_ULTIMATE_SCORE}
         <!-- BEGIN ultimaterecordrow -->
         <b>{cat_row.game_row.ULTIMATE_HIGHSCORE}</b></span><span class='gensmall'>&nbsp;&nbsp;{cat_row.game_row.ULTIMATEHIGHUSER}<br/>
         {cat_row.game_row.ULTIMATEDATEHIGH}
         <!-- END ultimaterecordrow -->
         </span>   
      </td>

	<td class="row1" width="20%" align="center" valign="center" >
	   <span class='gen'>
	   {cat_row.game_row.NORECORD}
	   <!-- BEGIN recordrow -->
	   <b>{cat_row.game_row.HIGHSCORE}</b></span><span class='gensmall'>&nbsp;&nbsp;{cat_row.game_row.HIGHUSER}<br/>{cat_row.game_row.DATEHIGH}
	   <!-- END recordrow -->
	   </span>
	</td>

	<td class="row1" width="20%" align="center" valign="center" >
	   <span class='gen'>
	   {cat_row.game_row.NOSCORE}
	   <!-- BEGIN yourrecordrow -->
	   <b>{cat_row.game_row.YOURHIGHSCORE}{cat_row.game_row.IMGFIRST}</b></span><span class='gensmall'><br/>{cat_row.game_row.YOURDATEHIGH}
	   <!-- END yourrecordrow -->
	   </span>   
	</td>

	<td class="row1" width="5%" align="center" valign="center" >
	   <span class='gen'>
         {cat_row.game_row.GAMENOTE}
	   </span>   
	</td>

	<td class="row1" width="100%" align="center" valign="center">
	   <table width="100%">
	   <tr>
         <td align="center" valign="center">
	   <span class="name">{cat_row.game_row.GAMEDESC}</span>
	   </td>
         <td width="25">{cat_row.game_row.GAME_PAD_PIC}</td>
	   <td width="25" align="right" valign="center">{cat_row.game_row.URL_SCOREBOARD}</td>
	   <td width="10" align="right" valign="center">
         <!-- BEGIN no_fav -->
         {cat_row.game_row.no_fav.DELFAVORI}
         <!-- END no_fav -->
         <!-- BEGIN fav -->
         {cat_row.game_row.fav.ADD_FAV}
         <!-- END fav -->
         </td>
	   </tr>
	   </table>
       </td>
   </tr>
<!-- END game_row -->
   <tr>
	 <td class="row2" colspan="{ARCADE_COL}" align="{cat_row.LINKCAT_ALIGN}"><span class="gensmall"><a href="{cat_row.U_ARCADE}">{cat_row.L_ARCADE}</a></span></td>
   </tr>
</table>
       </td>  
   </tr>
<!-- END cat_row -->
</table>

{WHOISPLAYING}

<table width="100%" cellpadding="5" cellspacing="1" border="0">
   <tr>
	<td align="center">[&nbsp;{URL_ARCADE}]&nbsp;-&nbsp;[&nbsp;{URL_BESTSCORES}]&nbsp;-&nbsp;[&nbsp;{URL_JEU_AL}]&nbsp;-&nbsp;[&nbsp;{URL_SEARCH_GAMES}]&nbsp;-&nbsp;[&nbsp;{MANAGE_COMMENTS}]</td>
   </tr>
</table>
<br />
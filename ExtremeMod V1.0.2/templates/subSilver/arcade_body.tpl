 <!-- affichage de la phrase d'index -->
  <table width="100%" cellspacing="2" cellpadding="2" border="0">
    <tr>
	  <td align="left" valign="middle" width="100%">
		<span class="nav">
	      <a href="{U_INDEX}" alt="{L_INDEX}" title="{L_INDEX}" class="nav">{L_INDEX}</a></span>
		<span class="nav">-&nbsp;{URL_ARCADE}</span>
	  </td>
	  <td align="right" valign="middle" width="30%">
		<span class="nav">{SEARCHGAMES}</span>
	  </td>
    </tr>
  </table>
<!-- BEGIN use_quota_mod -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
    <tr>
    <th class="thTop"><span class="nav">{use_quota_mod.L_QUOTA1}</span></th>
    </tr>
      <td class="row2" align="center">
         <span class='genmed'>{use_quota_mod.L_QUOTA}&nbsp;<b>{use_quota_mod.GAMEQUOTA}{use_quota_mod.L_QUOTA_RESTE}&nbsp;{use_quota_mod.GAMEEND}</b>&nbsp;{use_quota_mod.L_QUOTA_RESTE2}</span>
      </tr>
   </tr>
  </table>
<!-- END use_quota_mod -->

{TOPSTATARCADE}
{CHAMPIONNATARCADE}
{CHAMPIONNATEQUIPE}
{HEADINGARCADE}
{ARCADE_CAT}


<table width="99%" cellpadding="2" cellspacing="1" align="center" border="0" class="bodyline">
  {ARCADE_FAVORIS}
</table><br />

<table width="99%" cellpadding="2" cellspacing="1" align="center" border="0" class="bodyline">
  <!-- BEGIN use_category_mod -->
  <tr> 
	<th class="cat" colspan="10" nowrap="nowrap">&nbsp;{L_ARCADE}&nbsp;</th>
  </tr>
  <tr> 
	<td class="cat" colspan="10" nowrap="nowrap" align="center"><span class="cattitle">{CATTITLE}</span></td>
  </tr>
  <tr> 
	<td class="cat" height="28" align="center" colspan="2"><span class="cattitle">&nbsp;{L_GAME}&nbsp;</span></td>
      <td class="cat" nowrap="nowrap" align="center"><span class="cattitle">{L_ULTIMATE_HIGHSCORE}</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_HIGHSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_YOURSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_VOTES}&nbsp;</span></td>
	<td class="cat" colspan="{ARCADE_COL1}" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_DESC}&nbsp;</span></td>
  </tr>
  <!-- END use_category_mod -->
  <!-- BEGIN gamerow -->
  <tr> 
	<td class="row1" height="25" width='35' align='center'>{gamerow.GAMEPIC}</td>
	<td class="row1" height="25" width="20%" align='left'>
	    <span class='genmed'>{gamerow.GAMELINK}<br />{gamerow.GAMEPOPUP}</span><br />
	    <span class='gensmall'>{gamerow.GAMESET}<br />{gamerow.COUT}<br />{gamerow.PRIZE}</span>
	</td>

      <td class="row1" align="center" valign="center" >
         <span class='gen'>
         {gamerow.NO_ULTIMATE_SCORE}
         <!-- BEGIN ultimaterecordrow -->
         <b>{gamerow.ULTIMATE_HIGHSCORE}</b></span><span class='gensmall'>&nbsp;&nbsp;{gamerow.ULTIMATEHIGHUSER}<br/>{gamerow.ULTIMATEDATEHIGH}
         <!-- END ultimaterecordrow -->
         </span>   
      </td>

	<td class="row1" width="20%" align="center" valign="center" >
	   <span class='gen'>
	   {gamerow.NORECORD}
	   <!-- BEGIN recordrow -->
	   <b>{gamerow.HIGHSCORE}</b></span><span class='gensmall'>&nbsp;&nbsp;{gamerow.HIGHUSER}<br/>{gamerow.DATEHIGH}
	   <!-- END recordrow -->
	   </span>
	</td>

	<td class="row1" width="20%" align="center" valign="center" >
	   <span class='gen'>
	   {gamerow.NOSCORE}
	   <!-- BEGIN yourrecordrow -->
	   <b>{gamerow.YOURHIGHSCORE}{gamerow.IMGFIRST}</b></span><span class='gensmall'><br/>{gamerow.YOURDATEHIGH}
	   <!-- END yourrecordrow -->
	   </span>   
	</td>

	<td class="row1" width="5%" align="center" valign="center" >
	   <span class='gen'>
	   &nbsp;&nbsp;&nbsp;{gamerow.GAMENOTE}&nbsp;&nbsp;&nbsp;
	   </span>   
	</td>

	<td class="row1" width="100%" align="center" valign="center">
	   <table width="100%">
	   <tr>
	   <td align="center" valign="center"><span class="name">{gamerow.GAMEDESC}</span></td>
         <td width="25">{gamerow.GAME_PAD_PIC}</td>
         <td width="25" align="center" valign="center">{gamerow.URL_SCOREBOARD}</td>
	   <td width="10" align="center" valign="center">
         <!-- BEGIN no_fav -->
         {gamerow.no_fav.DELFAVORI}
         <!-- END no_fav -->
         <!-- BEGIN fav -->
         {gamerow.fav.ADD_FAV}
         <!-- END fav -->
         </td>
	   </tr>
	   </table>
	</td>
  </tr>
  <!-- END gamerow -->
</table>
<!-- BEGIN switch_pagination -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr>
	<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right" valign="middle"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
<!-- END switch_pagination -->

{WHOISPLAYING}

<table width="100%" cellpadding="5" cellspacing="1" border="0">
   <tr>
	<td align="center">[&nbsp;{URL_ARCADE}]&nbsp;-&nbsp;[&nbsp;{URL_BESTSCORES}]&nbsp;-&nbsp;[&nbsp;{URL_JEU_AL}]&nbsp;-&nbsp;[&nbsp;{URL_SEARCH_GAMES}]&nbsp;-&nbsp;[&nbsp;{MANAGE_COMMENTS}]</td>
   </tr>
</table>
<br />
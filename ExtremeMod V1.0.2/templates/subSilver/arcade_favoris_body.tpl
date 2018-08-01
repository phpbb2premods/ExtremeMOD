<!-- BEGIN favrow -->
<tr>
	<td class="cat" align="center" colspan="9"><span class="cattitle">{FAV}</span></td>
</tr>
<tr> 
	<td class="cat" height="28" align="center" colspan="2"><span class="cattitle">&nbsp;{L_GAME}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_ULTIMATE_HIGHSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_HIGHSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_YOURSCORE}&nbsp;</span></td>
	<td class="cat" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_VOTES}&nbsp;</span></td>
	<td class="cat" colspan="3" nowrap="nowrap" align="center"><span class="cattitle">&nbsp;{L_DESC}&nbsp;</span></td>
</tr>
<!-- BEGIN fav_row -->
<tr>
	<td class="row1" width="35">{favrow.fav_row.GAMEPICF}</td>
	<td class="row1" width="20%" align="left"><span class='genmed'>{favrow.fav_row.GAMELINKF}<br />{favrow.fav_row.GAMEPOPUP}</span><br /><span class='gensmall'>{favrow.fav_row.GAMESETF}<br />{favrow.fav_row.COUTF}<br />{favrow.fav_row.PRIZEF}</span></td>

      <td class="row1" align="center" valign="center" >
         <span class='gen'>
         {favrow.fav_row.NO_ULTIMATE_SCORE}
         <!-- BEGIN ultimaterecordrow -->
         <b>{favrow.fav_row.ULTIMATE_HIGHSCORE}</b></span><span class='gensmall'>&nbsp;&nbsp;{favrow.fav_row.ULTIMATEHIGHUSER}<br/>{favrow.fav_row.ULTIMATEDATEHIGH}
         <!-- END ultimaterecordrow -->
         </span>   
      </td>
	
	<td class="row1" width="20%" align='center'><span class='gen'>{favrow.fav_row.NORECORDF}
      <!-- BEGIN recordrow -->
      <b>{favrow.fav_row.HIGHSCOREF}</b></span><span class='gensmall'>   {favrow.fav_row.HIGHUSERF}<br/>{favrow.fav_row.DATEHIGHF}
	<!-- END recordrow -->
	</span></td>
			
	<td class="row1" width="20%" align="center" valign="center" ><span class='gen'>{favrow.fav_row.NOSCOREF}
	<!-- BEGIN yourrecordrow -->
	<b>{favrow.fav_row.YOURHIGHSCOREF}{favrow.fav_row.IMGFIRSTF}</b></span><span class='gensmall'><br/>{favrow.fav_row.YOURDATEHIGHF}
	<!-- END yourrecordrow -->
	</span></td>
			
	<td class="row1" width="5%" align="center" valign="center" ><span class='gen'>&nbsp;&nbsp;&nbsp;{favrow.fav_row.GAMENOTE}&nbsp;&nbsp;&nbsp;</span>   </td>

	<td class="row1" width="100%" align="center" valign="center">
	<table width="100%">
	  <tr>
	    <td align="center" valign="center"><span class="name">{favrow.fav_row.GAMEDESCF}</span></td>
          <td width="25">{favrow.fav_row.GAME_PAD_PIC}</td>
	    <td width="25" align="right" valign="center">{favrow.fav_row.URL_SCOREBOARDF}</td>
	    <td width="10" align="center" valign="center">{favrow.fav_row.DELFAVORI}</td>
	  </tr>
	</table>
	</td>
  </tr>		 
<!-- END fav_row -->
<br>
<tr>
	<td class="cat" colspan="9" align="{LINKCAT_ALIGN}"><span class="gensmall"><a href="{U_FAVORIS}" class="nav">{L_FAVORIS}</a></span></td>
</tr>
<!-- END favrow -->
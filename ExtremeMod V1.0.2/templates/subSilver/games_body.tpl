<script language="JavaScript">
function resize_avatar(image)
{
  if ({MAXSIZE_AVATAR}>0)
  {
	if (image.width > {MAXSIZE_AVATAR} ) image.width={MAXSIZE_AVATAR} ;
  }
}
</script>
  <!-- affichage de la phrase d'index -->
  <table width="100%" cellspacing="2" cellpadding="2" border="0">
    <tr>
	  <td align="left" valign="middle" width="70%">
		<span class="nav">
		<a href="{U_INDEX}" alt="{L_INDEX}" title="{L_INDEX}" class="nav">{L_INDEX}</a>
		&nbsp;-&nbsp;&nbsp{NAV_DESC}&nbsp;{NAV_CAT}-&nbsp;&nbsp;{L_GAME}</span>
	  </td>
	  <td align="right" valign="middle" width="30%">
		<span class="nav">{SEARCHGAMES}</span>
	  </td>
    </tr>
  </table>
<!-- BEGIN auth_scoreno -->
<br />
<table width="90%" cellpadding="2" cellspacing="1" border="0" class="bodyline" align="center">
  <tr> 
	<td class="cat" height="28" align="center"><span class="cattitle">{auth_scoreno.AUTH}</span></td>
  </tr>
  <tr>
      <td class="row3" align="center"><span class="genmed">{auth_scoreno.L_INFO}</span></td>
  </tr>
</table>
<br />
<!-- END auth_scoreno -->
<!-- BEGIN auth_scoreok -->
<br />
<table width="90%" cellpadding="2" cellspacing="1" border="0" class="bodyline" align="center">
  <tr> 
	<td class="cat" height="28" align="center"><span class="cattitle">{auth_scoreok.AUTH}</span></td>
  </tr>
  <tr>
      <td class="row3" align="center"><span class="genmed">{auth_scoreok.L_INFO}</span></td>
  </tr>
</table>
<br />
<!-- END auth_scoreok -->


{TOPSTATARCADE}
{CHAMPIONNATARCADE}
{HEADINGARCADE}
{ARCADE_CAT}
<br />
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
  <tr> 
	<td class="cat" height="28" align="center"><span class="cattitle">{L_GAME}</span></td>
  </tr>
  <tr>
 	<td align="center">
		<table width="100%">
			<tr>
			  <td valign="top">
				<!-- BEGIN ultime_avatar_best_player_left -->
   <table width="100%" class="bodyline" cellpadding="2" cellspacing="1">
                 <tr>
                    <td class="row2" align="center" colspan="4"><span class="cattitle">{L_ULTIMATE_HIGHSCORE}</span></td>
               </tr>
                <tr>
                  <td class="row1" align="center" colspan="4"><a href="{U_PROFIL}">{ULTIMATE_AVATAR}</a></td>
               </tr>           
                 <tr>
                    <td class="row1" align="center" colspan="4"><span class="gen"><b>{ULTIMATEHIGHUSER}</b></span><br /><span class="gensmall">Ultime Record: {ULTIMATE_HIGHSCORE}<br />{ULTIMATEDATEHIGH}</span></td>
                 </tr>
			  </table>
				<table><tr><td></td></tr></table>
			      <!-- END ultime_avatar_best_player_left -->
				<!-- BEGIN avatar_best_player_left -->
               <table width="100%" class="bodyline" cellpadding="2" cellspacing="1"> 
   	           <tr> 
       	          <td class="row2" align="center" colspan="3"><span class="cattitle">{L_ACTUAL_WINNER}</span></td> 
               </tr> 
          	   <tr> 
                      <td class="row1" align="center" colspan="3">{FIRST_AVATAR}</td> 
               </tr> 
   	           <tr> 
       	          <td class="row1" align="center" colspan="3"><span class="genmed"><b>{BEST_USER_NAME}</b></span><br /><span class="gensmall">Record: {BEST_SCORE}</span></td>
           	   </tr> 
		   <tr> 
                      <td class="row1" align="center" width="5%">{COURONNE}</td>
                      <td class="row1" align="center" valign="top" width="90%"><span class="genmed">{COMMENTS}</span></td>
                      <td class="row1" align="center" width="5%">{COURONNE}</td>
               </tr>
               <tr>
                      <td class="row1" align="center" valign="middle" colspan="3">{EDITCOMMENT}</td>
               </tr>
			  </table>
				<table><tr><td></td></tr></table> 
			<!-- END avatar_best_player_left -->
					<table width="100%" class="bodyline" cellpadding="2" cellspacing="1" >
                  <!-- BEGIN switch_left -->
   	           <tr> 
       	          <td class="row2" align="center" colspan="3"><span class="cattitle">{L_TOP}</span></td>
       	          <td class="row2" align="center" valign="middle" colspan="2">{MODOADMINRECORD}</td>
            	</tr> 
                    <!-- END switch_left -->
                  <!-- BEGIN scoreleft -->
					<tr>
					<td class="row1" align="center"><span class="gensmall">{scoreleft.POS}</span></td>
					<td class="row1" align="center">
						    <table width="100%" cellspacing="0" cellpadding="0">
							<tr>
							 <td align=center><span class="gensmall">{scoreleft.USERNAME}</span></td>
							 <td width="25" align="center">{scoreleft.URL_STATS}</td>
							</tr>
							</table>
					</td>
					<td class="row1" align="center"><span class="gensmall">{scoreleft.PLAY}</span></td>
					<td class="row1" align="center"><span class='gensmall'>{scoreleft.SCORE}</span></td>
					</tr>
                    <!-- END scoreleft -->
					</table>
			  </td>
                          <td class="bodyline" align="center">
<!-- BEGIN fav -->
{fav.ADD_FAV}<br /><br />
<!-- END fav -->
<!-- BEGIN game_type_V1 --> 
       <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="{GAME_WIDTH}" height="{GAME_HEIGHT}">
         <param name="movie" value="games/{SWF_GAME}?location={SCRIPT_PATH}&username={USER_NAME}&highscore={HIGHSCORE}&gamehash={GAMEHASH}&settime={SETTIME}&gid={GID}{SID}&bbtitle={BBTITLE}"/>
                        <param name="type" value="application/x-shockwave-flash" />
                        <param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer/" />
                        <param name="menu" value="false" />
         <embed src="games/{SWF_GAME}?location={SCRIPT_PATH}&username={USER_NAME}&highscore={HIGHSCORE}&gamehash={GAMEHASH}&settime={SETTIME}&gid={GID}{SID}&bbtitle={BBTITLE}" width="{GAME_WIDTH}" height="{GAME_HEIGHT}" menu="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash">
         </embed>
      </object>
<!-- BEGIN fav -->
{fav.ADD_FAV}<br /><br />
<!-- END fav -->
<!-- END game_type_V1 -->
<!-- BEGIN game_type_V2 -->
       <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="{GAME_WIDTH}" height="{GAME_HEIGHT}">
         <param name="movie" value="games/{SWF_GAME}"/>
                        <param name="type" value="application/x-shockwave-flash" />
                        <param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer/" />
                        <param name="menu" value="false" />
                        <param name="FlashVars" value="gamesessid={GSID}&gid={GID}" />
         <embed src="games/{SWF_GAME}" menu="false" type="application/x-shockwave-flash" FlashVars="gamesessid={GSID}&gid={GID}" width="{GAME_WIDTH}" height="{GAME_HEIGHT}" pluginspage="http://www.macromedia.com/go/getflashplayer">
         </embed>
      </object>
<!-- END game_type_V2 -->
<!-- BEGIN no_fav -->
<br /><br /><span class="gensmall"><font color="FF0000"><b>{no_fav.ADD_FAV}</b></font></span>
<!-- END no_fav -->
				</td>
				<td align="left" valign="top">
				<!-- BEGIN ultime_avatar_best_player_right -->
                        <table width="100%" class="bodyline" cellpadding="2" cellspacing="1">
                 <tr>
                    <td class="row2" align="center" colspan="4"><span class="cattitle">{L_ULTIMATE_HIGHSCORE}</span></td>
               </tr>
                <tr>
                  <td class="row1" align="center" colspan="4"><a href="{U_PROFIL}">{ULTIMATE_AVATAR}</a></td>
               </tr>           
                 <tr>
                    <td class="row1" align="center" colspan="4"><span class="gen"><b>{ULTIMATEHIGHUSER}</b></span><br /><span class="gensmall">Ultime Record: {ULTIMATE_HIGHSCORE}<br />{ULTIMATEDATEHIGH}</span></td>
                 </tr>
			  </table>
				<table><tr><td></td></tr></table>
				<!-- END ultime_avatar_best_player_right -->
				<!-- BEGIN avatar_best_player_right -->
	               <table width="100%" class="bodyline" cellpadding="2" cellspacing="1"> 
    	           <tr> 
        	          <td class="row2" align="center" colspan="3"><span class="cattitle">{L_ACTUAL_WINNER}</span></td> 
               </tr> 
               <tr> 
                      <td class="row1" align="center" colspan="3">{FIRST_AVATAR}</td> 
	         </tr> 
    	         <tr> 
        	          <td class="row1" align="center" colspan="3"><span class="genmed"><b>{BEST_USER_NAME}</b></span><br /><span class="gensmall">Record: {BEST_SCORE}</span></td> 
           	   </tr>
		   <tr> 
                      <td class="row1" align="center" width="5%">{COURONNE}</td>
                      <td class="row1" align="center" valign="top" width="90%"><span class="genmed">{COMMENTS}</span></td>
                      <td class="row1" align="center" width="5%">{COURONNE}</td>
               </tr>
               <tr>
                      <td class="row1" align="center" valign="middle" colspan="3">{EDITCOMMENT}</td>
               </tr>
               	</table>
				<table><tr><td></td></tr></table> 
				<!-- END avatar_best_player_right -->
					<table width="100%" class="bodyline" cellpadding="2" cellspacing="1" >
                 <!-- BEGIN switch_right -->
   	           <tr> 
       	          <td class="row2" align="center" colspan="3"><span class="cattitle">{L_TOP}</span></td>
       	          <td class="row2" align="center" valign="middle" colspan="2">{MODOADMINRECORD}</td>
            	</tr> 
                     <!-- END switch_right -->
                <!-- BEGIN scoreright -->
					<tr>
					<td class="row1" align="center"><span class="gensmall">{scoreright.POS}</span></td>
					<td class="row1" align="center">
						    <table width="100%" cellspacing="0" cellpadding="0">
							<tr>
							 <td align=center><span class="gensmall">{scoreright.USERNAME}</span></td>
							 <td width="25" align="center">{scoreright.URL_STATS}</td>
							</tr>
							</table>
					</td>
					<td class="row1" align="center"><span class="gensmall">{scoreright.PLAY}</span></td>
					<td class="row1" align="center"><span class='gensmall'>{scoreright.SCORE}</span></td>
					</tr>
                    <!-- END scoreright -->
					</table>
				</td>
			</tr>
		</table>
	 </td>
 </tr>
</table>
<!-- BEGIN use_arcade_vote -->
<br />
{ARCADE_VOTE}
<!-- END use_arcade_vote -->
{WHOISPLAYING}
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
{ARCADE_FAVORIS}
</table>
<br />
  <table width="100%" cellpadding="5" cellspacing="1" border="0">
   <tr>
	<td align="center">[&nbsp;{URL_ARCADE}]&nbsp;-&nbsp;[&nbsp;{URL_BESTSCORES}]&nbsp;-&nbsp;[&nbsp;{URL_SCOREBOARD}]&nbsp;-&nbsp;[&nbsp;{URL_STATS}]&nbsp;-&nbsp;[&nbsp;{URL_JEU_AL}]<br /><br />[&nbsp;{URL_SEARCH_GAMES}]&nbsp;{URL_FAV}{URL_CAT}-&nbsp;[&nbsp;{MANAGE_COMMENTS}]</td>
   </tr>
  </table>

<!-- BEGIN switch_jumpbox -->
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="center">{JUMPBOX_ARCADE}</td>
  </tr>
</table>
<!-- END switch_jumpbox -->

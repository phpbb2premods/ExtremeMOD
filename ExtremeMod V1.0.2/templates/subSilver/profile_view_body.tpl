<script src="templates/toggle.js"></script>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	<td class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
  </tr>
</table>

<table width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr> 
	<td width="40%" valign="top"><table width="100%" cellspacing="1" cellpadding="2" border="0">
	  <tr>
		<td><table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
		  <tr>
			<td class="catLeft" height="28" align="center"><b class="gen">{L_AVATAR}</b></td>
		  </tr>
		  <tr>
			<td class="row1" height="6" valign="top" align="center">
				<span class="genmed">{POSTER_RANK}<br />{RANK_IMAGE}</span>
				{AVATAR_IMG}
			</td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td><table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
		  <tr>
			<td class="catLeft" align="center" height="28" colspan="2"><b class="gen">{L_CONTACT} {USERNAME}</b></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
			<td class="row1" valign="middle" width="100%"><span class="gen">{EMAIL_IMG}</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{PM_IMG}</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{MSN}</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{YIM_IMG}&nbsp;</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{AIM_IMG}</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ICQ_NUMBER}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{ICQ_IMG}</span></td>
		  </tr>
		  <tr> 
			<td class="row1" valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ONLINE_STATUS}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{ONLINE_STATUS_IMG}</span></td>
		</tr>
		</table></td>
	  </tr>
	</table>
	</td>
	
	<td width="60%" colspan ="2" valign="top">
	
	<table width="100%" cellspacing="1" cellpadding="2" border="0">
	  <tr>
		<td>
		<table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
		  <tr>
			<td class="catRight" colspan="2"><b><span class="gen">{L_ABOUT_USER}</span></b> 
				<!-- BEGIN switch_user_admin --> 
				<span class="gen">{USERADMIN_IMG}&nbsp;{PERMCONTROL_IMG}</span> 
				<!-- END switch_user_admin --> 
			</td>
			
		  </tr>
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_JOINED}:&nbsp;</span></td>
			<td class="row1" width="100%"><b class="gen">{JOINED}</b></td>
		  </tr>
		  <tr>
		  	<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_VISITED}:&nbsp;</span></td>
		  	<td class="row1" width="100%"><b class="gen">{VISITED}</b></td>
			</tr>
		  <tr>
			<td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:&nbsp;</span></td>
			<td class="row1" valign="top">
				<b class="gen">{POSTS}</b><br />
				<span class="genmed">[{POST_PERCENT_STATS} / {POST_DAY_STATS}]<br /><a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a></span>
			</td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LOCATION}:&nbsp;</span></td>
			<td class="row1"><b class="gen">{LOCATION}</b></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_WEBSITE}:&nbsp;</span></td>
			<td class="row1"><span class="gen">{WWW_IMG}</span></td>
		  </tr>
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:&nbsp;</span></td>
			<td class="row1"><b class="gen">{OCCUPATION}</b></td>
		  </tr>
		  <tr>
			<td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
			<td class="row1"><b class="gen">{INTERESTS}</b></td>
		  </tr>
		  <tr>
		  	<td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_ARCADE}:</span></td>
		  	<td td class="row1"> <span class="gen">{URL_STATS}</span></b></td>
		</tr>
		  <tr>
		  <td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_POINTS}:</span></td>
		  <td class="row1"><b><span class="gen">{POINTS}</span></b><span class="genmed">{DONATE_POINTS}</span></td>
		</tr>
		  	<!-- BEGIN celleds -->
		<tr> 
		  <td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_CELLEDS}</span></td>
		  <td><span class="gen"><a href="{U_CELLEDS}">{CELLEDS}</a></span></td>
		</tr>
		<!-- END celleds -->
		  <tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_GENDER}:</span></td>
			<td class="row1" valign="middle"><span class="gen">{GENDER}</span></td>
		</tr>
		  		<!-- BEGIN flag -->
		<tr>
			<td class="row1" valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_FLAG}:</span></td>
			<td class="row1" valign="middle"><span class="gen">
				<strong>{flag.FLAG_NAME}</strong>
				<img class="gensmall" src="{flag.FLAG_IMG}" alt="{flag.FLAG_NAME}" title="{flag.FLAG_NAME}" style="vertical-align:middle;" border="0" />
			</span></td>
		</tr>
		<!-- END flag -->
		  	<!-- Start add - Birthday MOD -->
		<tr>
		  <td class="row1" valign="top" align="right" nowrap="nowrap"><span class="gen">{L_BIRTHDAY}:</span></td>
		  <td class="row1"><b><span class="gen">{BIRTHDAY}</span></b></td>
		</tr>
			<!-- End add - Birthday MOD -->
		</table></td>
	  </tr>
	  <tr>
		<td align="right"><span class="nav"><br />{JUMPBOX}</span></td>
	  </tr>
	</table>
	

	
	
	
	</td>
  </tr>
  
  	<!-- BEGIN display_shares -->
<br clear="all" /> 

<table width="100%" border="1" cellspacing="1" cellpadding="1" class="forumline" align="center"> 
	<tr> 
		<th align="center" colspan="2">{L_ON_ACCOUNT}{ON_ACCOUNT}</th> 
	</tr> 
	<!-- BEGIN shares --> 
	<tr> 
		<td align="center" class="{display_shares.shares.SHARE_ROW}" width="65%" ><span class="gen">{display_shares.shares.SHARE_NAME}</span></td> 
		<td align="center" class="{display_shares.shares.SHARE_ROW}"><span class="gen">{display_shares.shares.SHARE_SUM}</span></td> 
	</tr> 
	<!-- END shares --> 
	<tr> 
		<th align="center" colspan="2">{L_LOAN}{LOAN}</th> 
	</tr> 
</table>
<!-- END display_shares -->



<!-- BEGIN switch_display_medal -->
<br />
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
	<td class="catLeft" align="center" height="28" colspan="2"><b><span class="gen">{L_MEDAL_INFORMATION}</span></b></td>
  </tr>
  <tr>
	<td class="row1"  align="center" valign="middle" width="10%"><span class="gen">{L_USER_MEDAL}:&nbsp;<b>{USER_MEDAL_COUNT}</b></span>
		<!-- BEGIN medal -->
		<br /><br />{switch_display_medal.medal.MEDAL_BUTTON}
		<!-- END medal -->
	</td>
	<td class="row1" valign="middle" align="left" nowrap="nowrap" width="100%">
		<!-- BEGIN details -->
		&nbsp;{switch_display_medal.details.MEDAL_IMAGE_SMALL}&nbsp;
		<!-- END details -->
	</td>
  </tr>
</table>

<br />
<div style="width: 100%; overflow: hidden; display: none;" id="toggle_medal">
<a name="medal"></a>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
	<th class="thCornerL" align="center" nowrap="nowrap">&nbsp;{L_MEDAL_NAME}&nbsp;</th>
	<th class="thCornerR" align="center" nowrap="nowrap">&nbsp;{L_MEDAL_DETAIL}&nbsp;</th>
  </tr>
<!-- BEGIN details -->
  <tr>
	<td class="row2" nowrap="nowrap">
		<table width="100%" cellspacing="1" cellpadding="3" border="0">
		<tr><td align="center"><span class="gen">{switch_display_medal.details.MEDAL_CAT}</span></td></tr>
		<tr><td align="center"><span class="genmed">{switch_display_medal.details.MEDAL_NAME}</span></td></tr>
		<tr><td align="center">{switch_display_medal.details.MEDAL_IMAGE}</td></tr>
		<tr><td align="center"><span class="gensmall">{switch_display_medal.details.MEDAL_COUNT}</span></td></tr></table></td>
	<td class="row2" valign="top">
		<table width="100%" cellspacing="1" cellpadding="3" border="0">
		<tr><td><span class="gen">{switch_display_medal.details.L_MEDAL_DESCRIPTION}: <b>{switch_display_medal.details.MEDAL_DESCRIPTION}</b></span></td></tr>
		<tr><td class="quote">
			<table width="100%" cellspacing="1" cellpadding="3" border="0">
			<tr><td><span class="genmed">{switch_display_medal.details.MEDAL_ISSUE}</span></td></tr>
			</table>
		</td></tr>
	</table></td>
  </tr>
<!-- END details -->
</table>
</a>
</div>
<!-- END switch_display_medal -->


</table>


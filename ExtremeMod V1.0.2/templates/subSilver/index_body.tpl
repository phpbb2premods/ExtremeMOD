{SHOUTBOX_BODY}

{ANNONCE_GLOBALE}

<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center"  class="bodyline">
  <tr> 
	<td class="row1" align="left" valign="bottom"><span class="gensmall">
		<!-- BEGIN switch_user_logged_in -->
		{LAST_VISIT_DATE}<br />
		<!-- END switch_user_logged_in -->
		{CURRENT_TIME}<br /></span><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span>
	</td>
	<td class="row1" align="right" valign="bottom"><span class="gensmall">
		<!-- BEGIN toolbar -->
		{toolbar.S_TOOLBAR}
		<!-- END toolbar -->
		<!-- BEGIN switch_user_logged_out -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
		<!-- END switch_user_logged_out -->
	</span></td>
  </tr>
</table>
<br />
<!-- BEGIN catrow -->


<!-- BEGINONLY -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="100%" colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{catrow.CAT_DESC}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th width="200" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  
  <!-- BEGIN cat -->
  <tr> 
	<td class="catLeft" colspan="3" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="rowpic" colspan="3" align="right">&nbsp;</td>
  </tr>
  <!-- END cat -->
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	
	<td class="row1" width="100%" height="50"><table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr><td><a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_ICON_IMG}</a></td>
			<td width="100%"><span {catrow.forumrow.FORUM_COLOR} class="forumlink"><a href="{catrow.forumrow.U_VIEWFORUM}" {catrow.forumrow.FORUM_COLOR} class="forumlink">{catrow.forumrow.FORUM_NAME}</a>{catrow.forumrow.FORUM_EDIT_IMG}<br />
  				</span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
  				</span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span>
  			</td>
  		</tr>
  	</table>
	  <!-- BEGIN sub -->
	<span class="gensmall"><b>{L_SUBFORUMS}:</b>
	<!-- BEGIN item -->
	<a href="{catrow.forumrow.sub.item.U_LAST_POST}" title="{catrow.forumrow.sub.item.L_LAST_POST}"><img src="{catrow.forumrow.sub.item.FORUM_FOLDER_IMG}" border="0" alt="{catrow.forumrow.sub.item.L_FORUM_FOLDER_ALT}" /></a>&nbsp;<a href="{catrow.forumrow.sub.item.U_VIEWFORUM}" {catrow.forumrow.sub.item.FORUM_COLOR} title="{catrow.forumrow.sub.item.FORUM_DESC_HTML}"><b>{catrow.forumrow.sub.item.FORUM_NAME}</b></a>{catrow.forumrow.sub.item.L_SEP}
	<!-- END item -->
	</span>
	<!-- END sub -->
	</td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
  </tr>
  <!-- END forumrow -->
   <!-- BEGIN arcaderow --> 
  <tr> 
   <td class="row1" align="center" valign="middle" height="75">{catrow.arcaderow.FOLDER}</td> 
   <td class="row1" colspan="1" width="100%" height="50"><span class="forumlink"> <a href="{catrow.arcaderow.U_VIEWFORUM}" class="forumlink">{catrow.arcaderow.FORUM_NAME}</a><br /> 
     </span> <span class="genmed">{catrow.arcaderow.FORUM_DESC}</span><br /> 
     <span class="forumlink"> <a href="{catrow.arcaderow.U_TOPARCADE}" class="forumlink">{catrow.arcaderow.BEST_SCORES}</a> 
   </td> 
   <td class="row2" colspan="3" width="100%" height="50" align="center"> 
  <!-- BEGIN bestscore -->    
      <span class="gensmall"> 
        {catrow.arcaderow.bestscore.LAST_SCOREDATE}<br />{catrow.arcaderow.bestscore.LAST_SCOREUSER}<br /> 
      a réalisé un score de<br />{catrow.arcaderow.bestscore.LAST_SCORE} à {catrow.arcaderow.bestscore.LAST_SCOREGAME} 
     </span> 
  <!-- END bestscore -->        
   </td> 
  </tr> 
  <!-- END arcaderow --> 
</table>
<br class="nav" /> 
<!-- END catrow -->

<!-- ENDONLY -->

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="2" class="bodyline">
  <tr> 
 	<td class="row1" align="left">
 	<!-- BEGIN switch_user_logged_in -->
 		<span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span>
 	<!-- END switch_user_logged_in -->
 	</td>
	<td class="row1" align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br />



<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
  </tr>
  <tr> 
	<td class="row1" align="center" valign="middle" rowspan="5"><img src="templates/subSilver/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>
	</td>
  </tr>
  <tr>
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE}<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
  </tr>
  
  
    <tr>
  	<td class="row1" align="left"><span class="gensmall">{L_TOTAL_TODAY}{TOTAL_TODAY_USERS}<br />{TOTAL_HOUR_USERS}<br />{L_REGISTERED_USERS}{S_TODAY_USERLIST}</span></td>
  </tr>

     <!-- Start add - Birthday MOD -->
  <tr>
	<td class="row1" align="left"><span class="gensmall">{L_WHOSBIRTHDAY_TODAY}<br />{L_WHOSBIRTHDAY_WEEK}</span><br /></td>
  </tr>
<!-- End add - Birthday MOD -->
  
  <tr>
	<td class="row1"><span class="gensmall">
		<strong>{L_LEGEND}:</strong>
		<!-- BEGIN legend -->
		[&nbsp;<a href="{legend.U_RANK}"{legend.RANK_STYLE}>{legend.RANK_NAME}</a>&nbsp;]
		<!-- END legend -->
	</span></td>
  </tr>
</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>



<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <td class="catHead" height="28"><a name="login"></a><span class="cattitle">{L_LOGIN_LOGOUT}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="center" valign="middle" height="28"><span class="gensmall">{L_USERNAME}: 
		<input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;&nbsp;{L_PASSWORD}: 
		<input class="post" type="password" name="password" size="10" maxlength="32" />
		<!-- BEGIN switch_allow_autologin -->
		&nbsp;&nbsp; &nbsp;&nbsp;{L_AUTO_LOGIN} 
		<input class="text" type="checkbox" name="autologin" />
		<!-- END switch_allow_autologin -->
		&nbsp;&nbsp;&nbsp; 
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
		</span> </td>
	</tr>
  </table>
</form>
<!-- END switch_user_logged_out -->

<!-- BEGINONLY -->
<br clear="all" />
<!-- ENDONLY -->

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="templates/subSilver/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>

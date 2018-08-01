
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	<td align="left" valign="bottom"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a></td>
	<td align="right" valign="bottom"><span class="gensmall"><b>{PAGINATION}</b></span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
	  <!-- BEGIN nav -->
<a href="{U_VIEW_FORUM}" class="nav"></a><a href="{U_VIEW_FORUM}" class="nav"></a>-&gt; <a class="nav" href="{nav.U_NAV}" title="{nav.L_NAV_DESC_HTML}">{nav.L_NAV}</a>
<!-- END nav -->
</span></td>
	<!-- BEGIN toolbar -->
	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">{toolbar.S_TOOLBAR}</span></td>
	<!-- END toolbar -->
  </tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	{POLL_DISPLAY}
	<!-- BEGIN postrow -->
	<tr align="right">
		<td class="catHead" colspan="2" height="28">
			<span class="name"><a name="{postrow.S_NUM_ROW}" id="{postrow.S_NUM_ROW}"></a></span>
			<span class="nav">{postrow.S_NAV_BUTTONS}</span>
		</td>
	</tr> 
	
	<tr>
		<th class="thLeft" width="150" height="26" nowrap="nowrap">{L_AUTHOR}</th>
		<th class="thRight" nowrap="nowrap">{L_MESSAGE}</th>
	</tr>
	
	<tr> 
		<td width="150" align="middle" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b>{postrow.I_QP_QUOTE}</span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br />
		{postrow.WARN_CARDS}<br /><br /><center>{postrow.POSTER_ONLINE_STATUS_IMG}</center><br />
		{postrow.POSTER_JOINED}<br />
		{postrow.POSTER_AGE}<br />
		{postrow.POSTER_GENDER}<br />
		{postrow.POSTER_FROM}<br />		
		<!-- BEGIN flag -->
		{L_FLAG}:&nbsp;<img class="gensmall" src="{postrow.flag.FLAG_IMG}" alt="{postrow.flag.FLAG_NAME}" title="{postrow.flag.FLAG_NAME}" style="vertical-align:text-bottom;" border="0" />
		<!-- END flag --><br /><br />
		{postrow.POSTER_POSTS}<br />&nbsp;{postrow.POST_DAY_STATS}<br />
		{postrow.POINTS}{postrow.DONATE_POINTS}<br /><br />
		{postrow.POSTER_MEDAL_COUNT}<br />
					<!-- BEGIN medal -->
			<table border="0" cellspacing="0" cellpadding="5">
				<!-- BEGIN medal_row -->
				<tr align="left" valign="middle"> 
					<!-- BEGIN medal_col -->
					<td>
						<img src="{postrow.medal.medal_row.medal_col.MEDAL_IMAGE}" border="0" alt="{postrow.medal.medal_row.medal_col.MEDAL_NAME} {postrow.medal.medal_row.medal_col.MEDAL_COUNT}" title="{postrow.medal.medal_row.medal_col.MEDAL_NAME} {postrow.medal.medal_row.medal_col.MEDAL_COUNT}" {postrow.medal.medal_row.medal_col.MEDAL_WIDTH} {postrow.medal.medal_row.medal_col.MEDAL_HEIGHT} />
					</td>
					<!-- END medal_col -->
				</tr>
				<!-- END medal_row -->
			</table>
			<!-- END medal -->
		{postrow.POST_MOOD}<br />		
		{postrow.POSTER_VAULT}<br />
		{postrow.CELLEDS}<br />
		</span>	
		</td>
		

		
		<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><img src="{postrow.I_MINITIME}" width="12" height="9" alt="" title="{L_POSTED}" /><span class="postdetails">{L_POSTED}: {postrow.POST_DATE}
					<br /><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="" title="{L_POST_SUBJECT}" border="0" />{L_POST_SUBJECT}: {postrow.POST_SUBJECT}
					<!-- BEGIN sub_title -->
					<br /><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="" title="{L_SUB_TITLE}" border="0" />{L_SUB_TITLE}: {postrow.sub_title.SUB_TITLE}
					<!-- END sub_title -->
				</span></td>
				<td valign="top" nowrap="nowrap">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} {postrow.DELETE_IMG} {postrow.IP_IMG} {postrow.WARN_YELLOW_CARD} {postrow.WARN_RED_CARD} {postrow.WARN_GREEN_CARD}</td>
			</tr>
			<tr> 
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><div id="message_{postrow.U_POST_ID}"><span class="postbody">{postrow.MESSAGE}</span></div><span class="postbody">{postrow.SIGNATURE}{postrow.ATTACHMENTS}&nbsp;</span><span class="gensmall">{postrow.EDITED_MESSAGE}&nbsp;</span></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		
		<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" colspan="2"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
			<tr> 
				<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {postrow.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{postrow.ICQ_STATUS_IMG}</div></div>');
				
				//--></script><noscript>{postrow.ICQ_IMG}</noscript></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- BEGIN spacing -->
	</table>
	<br class="nav" />
	<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<!-- END spacing -->
	<!-- END postrow -->
	<tr align="center"> 
		<td class="catBottom" colspan="2" height="28"><table cellspacing="0" cellpadding="0" border="0">
			<tr><form method="post" action="{S_POST_DAYS_ACTION}">
				<td align="center"><span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span></td>
			</form></tr>
		</table></td>
	</tr>
</table>

<!-- BEGIN qp_form -->
<BR />{QP_BOX}
<!-- END qp_form -->

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a>
			<!-- BEGIN qp_form -->
		<!-- BEGIN qp_button -->
		&nbsp;&nbsp;<a href="{qp_form.qp_button.U_QPES}"><img src="{qp_form.qp_button.I_QPES}" border="0" alt="{qp_form.qp_button.L_QPES_ALT}" align="middle" /></a>
		<!-- END qp_button -->
		<!-- END qp_form -->
	</span></td>
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
	  <!-- BEGIN nav -->
-&gt; <a class="nav" href="{nav.U_NAV}" title="{nav.L_NAV_DESC_HTML}">{nav.L_NAV}</a>
<!-- END nav -->
</span></td>

  </tr>
</table>
<br class="nav" />
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr>
	<td class="catHead" colspan="2" height="28"><span class="cattitle" valign="top"><b>{L_BT_TITLE}</b></span></td>
  </tr>
  <tr>
	<td class="row2 gensmall" width="150" nowrap="nowrap">{PAGE_NUMBER}</td>
	<td class="row1 gensmall" width="100%">{PAGINATION}</td>
	
  </tr>
  <!-- BEGIN switch_user_logged_in -->
  <tr>
	<td class="row2 gensmall" colspan="2">{S_WATCH_TOPIC}</td>
	
  </tr>
  <!-- END switch_user_logged_in -->
  <tbody id="info_display" style="display:none;">
	<tr>
		<td class="row2 gensmall" valign="top" width="150" nowrap="nowrap" valign="top"><b>{L_BT_PERMS}:</b></td>
		<td class="row1 gensmall" width="100%">{S_AUTH_LIST}</td>
	</tr>
  </tbody>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
	<td width="100%" align="left" valign="top" nowrap="nowrap">{S_TOPIC_ADMIN}</td>
	
	<td align="right" valign="top"><span class="gensmall">
		<a href="javascript:dom_toggle.toggle('info_display','info_close');"><img alt="{L_BT_SHOWHIDE_ALT}" src="{I_BT_SHOWHIDE}" title="{L_BT_SHOWHIDE_ALT}" width="22" height="12" border="0" /></a>
	</span></td>
	
	
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="left">{JUMPBOX}</td>
  </tr>
  <tr>
	<td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
	<!-- BEGIN switch_attribute -->
	<td align="right" class="nav" nowrap="nowrap"><form action="{F_ATTRIBUTE_URL}" method="POST">
		{S_ATTRIBUTE_SELECTOR}
		<input type="image" src="{I_MINI_SUBMIT}" name="attribute" title="{L_ATTRIBUTE_APPLY}" />
		<input type="hidden" name="{S_TOPIC_LINK}" value="{TOPIC_ID}" />
	</form></td>
	<!-- END switch_attribute -->
  </tr>
</table>





		  <table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25"><span class="genmed"><b>{L_NAME_WELCOME}</b></span></{PORTAL_CLASS_BALISE}>
		   </tr>
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
			<!-- BEGIN switch_user_logged_out -->
				<center><br />{AVATAR_IMG}<br />{U_NAME_LINK}
				</center>
			<!-- END switch_user_logged_out -->
			<!-- BEGIN switch_user_logged_in -->
				<center>
					<br />{AVATAR_IMG}
					<br /> {U_NAME_LINK}
				</center>
				<br />{LAST_VISIT_DATE}<br /><br />
				<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
  			<!-- END switch_user_logged_in -->
				<br />{CURRENT_TIME}<br /><br />{S_TIMEZONE}</span>
			<!-- BEGIN switch_user_logged_in -->				
				<center><br /><a href="{U_LOGOUT}" class="gensmall">{L_LOGOUT}</a><br /></center>
  			<!-- END switch_user_logged_in -->

			</td>
		   </tr>
		  </table>
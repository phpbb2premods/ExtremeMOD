		  <table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25"><span class="genmed"><b>{L_POLL}</b></span></{PORTAL_CLASS_BALISE}>
		   </tr>
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
				<form method="post" action="{S_POLL_ACTION}">
				<center><b>{S_POLL_QUESTION}</b></center><br />
				<!-- BEGIN poll_option_row -->
				<input type="radio" name="vote_id" value="{poll_option_row.OPTION_ID}">{poll_option_row.OPTION_TEXT}&nbsp;[{poll_option_row.VOTE_RESULT}]<br />
				<!-- END poll_option_row -->
				<br />
				<!-- BEGIN switch_user_logged_out -->
				<center>{L_LOGIN_TO_VOTE}</center>
				<!-- END switch_user_logged_out -->
				<!-- BEGIN switch_user_logged_in -->
				<center><input type="submit" class="mainoption" name="submit" value="{L_VOTE_BUTTON}" {DISABLED}></center>
				<input type="hidden" name="topic_id" value="{S_TOPIC_ID}">
				<input type="hidden" name="mode" value="vote">
				<!-- END switch_user_logged_in -->
				</form><br />
			</span></td>
		   </tr>
		  </table>
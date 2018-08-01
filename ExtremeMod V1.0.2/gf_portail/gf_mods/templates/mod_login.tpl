		<!-- BEGIN switch_user_logged_out -->
		  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" class="row1">
		<form method="post" action="{S_LOGIN_ACTION}">		  
		   <tr>
			<{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25" colspan="2"><span class="genmed"><b>{L_LOGIN}</b></span></{PORTAL_CLASS_BALISE}>
		   </tr>
		   <tr> 
			<td class="row1" align="right">
			<span class="gensmall" style="line-height=150%">
			<input type="hidden" name="redirect" value="{U_PORTAL}" />
			{L_USERNAME}:
			</span>
			</td>
			<td class="row1" align="left">
			&nbsp;<input class="post" type="text" name="username" size="15" />
			</td>
		   </tr>
		   <tr>	
		     <td class="row1" align="right">
 			<span class="gensmall" style="line-height=150%">
			{L_PASSWORD}:
			</span>
			 </td>
			 <td class="row1" align="left">
			    &nbsp;<input class="post" type="password" name="password" size="15" />
  			 </td>	
			</tr>
			<tr>
			  <td colspan="2" align="center" class="row1"> 
	   			<span class="gensmall" style="line-height=150%">
			<nobr><input class="text" type="checkbox" name="autologin" />&nbsp;{L_REMEMBER_ME}</nobr><br/>
			<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
			<br /><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a><br />{L_REGISTER_NEW_ACCOUNT}</span>
			   </td>
		   </tr>
		</form>		   
		  </table>
		<!-- END switch_user_logged_out -->
<form action="{S_VAULT_ACTION}" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{U_VAULT}" class="nav">{L_VAULT}</a> -> {L_PREFERENCES}</span></td>
		</span></td>
	</tr>
  </table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th colspan="2" align="center">{L_PREFERENCES}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_ACCOUNT_PROTECT}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="account_protect" value="1" {VAULT_ACCOUNT_PROTECT_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_LOAN_PROTECT}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="loan_protect" value="1" {VAULT_LOAN_PROTECT_CHECKED} /></td>
	</tr>
	<!-- BEGIN stock -->
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_VAULT_NEWSLETTER}</span></td>
		<td class="row2" align="center" valign="top"><input type="checkbox" name="newsletter" value="1" {VAULT_NEWSLETTER_CHECKED} /></td>
	</tr>
	<!-- END stock -->
	<tr>
		<td class="catBottom" colspan="9" align="center"><input type="submit" name="prefs_submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>

</form>
<br clear="all" />



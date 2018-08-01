
<h1>{L_MENUS_TITLE}</h1>

<P>{L_MENUS_TEXT}</p>
<form action="{S_MENU_ACTION}" method="post">
<table cellspacing="1" width="80%" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2">{L_MENU}</th>
	</tr>
	<tr>
		<td class="row1" width="38%">{L_MENU_DESC}</td>
		<td class="row2" width="62%"><input type="text" maxlength="100" size="40" name="menu_desc" value="{MENU_DESC}" class="post" /></td>
	</tr>
	<tr> 
		<td colspan="2" align="center" class="cat">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" />
		</td>
	</tr>
</table>
<br />
</form>

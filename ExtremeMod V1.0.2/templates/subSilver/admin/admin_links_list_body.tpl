<h1>{L_ADMIN_LINKS_LIST_TITLE}</h1>

<p>{L_ADMIN_LINKS_LIST_EXPLAIN}</p>

<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thCornerL" height="25" valign="middle" nowrap="nowrap">#</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">{L_EDIT}</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">{L_DELETE}</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">{L_LINKURL}</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">{L_LINKTEXT}</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">{L_LINKIMG}</th>
		<th class="thCornerR" height="25" valign="middle" nowrap="nowrap">{L_LINKACTIVE}</th>
	</tr>
	<!-- BEGIN linkrow -->
	<tr>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{linkrow.NUMBER}</span></td>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap">
			<span class="gensmall">
			<a href="{linkrow.U_EDIT_LINK}">{L_EDIT}</a>
			</span>
		</td>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap">
			<span class="gensmall">
			<a href="{linkrow.U_DELETE_LINK}">{L_DELETE}</a>
			</span>
		</td>		
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{linkrow.LINKURL}</span></td>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{linkrow.LINKTEXT}</span></td>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{linkrow.LINKIMG}</span></td>
		<td class="{linkrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{linkrow.LINKACTIVE}</span></td>
	</tr>
	<!-- END linkrow -->
	<tr>
		<td class="catBottom" height="28" align="center" valign="middle" colspan="7">
		<form action="{S_LINK_ACTION}" method="post">{S_HIDDEN_FIELDS} 
		<input type="submit" name="{S_SUBMIT}" value="{L_SUBMIT}" class="mainoption" />
		</form>
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="middle"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br />

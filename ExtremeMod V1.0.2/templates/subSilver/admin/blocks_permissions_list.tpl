
<h1>{L_MODULES_TITLE}</h1>

<P>{L_MODULES_ADD_TEXT}</p>
<table width="50%" align="center">
<tr>
<td>
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL" colspan="3">{L_ACL_MODULES} - {L_AUTHORIZED_GROUPS}</th>
	</tr>
</table>
<br />
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_GROUP_NAME}</th>
		<th class="thTop">{L_GROUP_DESC}</th>
		<th class="thCornerR">{L_GROUP_MODO}</th>
	</tr>
	<!-- BEGIN row_mod -->
	<tr>
		<td colspan="3" class="catSides"><span class="cattitle"><a href="{row_mod.U_EDIT_PERMISSIONS}">{row_mod.MODULE_NAME}</a></span></td>
	</tr>
	<!-- BEGIN row_group -->
	<tr>
		<td class="{row_mod.row_group.ROW_CLASS}">{row_mod.row_group.GROUP_NAME}</td>
		<td class="{row_mod.row_group.ROW_CLASS}" align="center">{row_mod.row_group.GROUP_DESC}</td>
		<td class="{row_mod.row_group.ROW_CLASS}" align="center">{row_mod.row_group.GROUP_MODO}</td>
	</tr>
	<!-- END row_group -->
	<!-- END row_mod -->
</table>
</td>
</tr>
<tr>
	<td align="center"><a href="{U_BACK"}>{BACK}</a></td>
</tr>
</table>
<br />
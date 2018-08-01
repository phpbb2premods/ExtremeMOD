
<h1>{L_MODULES_TITLE}</h1>

<P>{L_MODULES_ADD_TEXT}</p>
<table width="50%" align="center">
<tr>
<td>
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
	<tr>
		<th class="catTop" colspan="3">{L_MODULE} : {MODULE_NAME}</th>
	</tr>
</table>
<br />
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_GROUP_NAME}</th>
		<th class="thTop">{L_GROUP_DESC}</th>
		<th class="thCornerR">{L_ACTION}</th>
	</tr>
	<tr>
		<td colspan="3" class="catSides"><span class="cattitle">{L_AUTHORIZED_GROUPS}</span></td>
	</tr>
	<!-- BEGIN groups_auth -->
	<tr>
		<td class="{groups_auth.ROW_CLASS}">{groups_auth.GROUP_NAME}</td>
		<td class="{groups_auth.ROW_CLASS}" align="center">{groups_auth.GROUP_DESC}</td>
		<td class="{groups_auth.ROW_CLASS}" align="center"><a href="{groups_auth.U_ACTION}">{L_SUPPRESS}</a></td>
	</tr>
	<!-- END groups_auth -->
	<tr>
		<td colspan="3" class="catSides"><span class="cattitle">{L_UNAUTHORIZED_GROUPS}</span></td>
	</tr>
	<!-- BEGIN groups_unauth -->
	<tr>
		<td class="{groups_unauth.ROW_CLASS}">{groups_unauth.GROUP_NAME}</td>
		<td class="{groups_unauth.ROW_CLASS}" align="center">{groups_unauth.GROUP_DESC}</td>
		<td class="{groups_unauth.ROW_CLASS}" align="center"><a href="{groups_unauth.U_ACTION}">{L_ADD}</a></td>
	</tr>
	<!-- END groups_unauth -->
</table>
</td>
</tr>
<tr>
	<td align="center"><a href="{U_BACK"}>{BACK}</a></td>
</tr>
</table>
<br />
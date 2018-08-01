
<h1>{L_MODULES_TITLE}</h1>

<P>{L_MODULES_ADD_TEXT}</p>
<table width="50%" align="center">
<tr>
<td>
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
<form action="{S_BLOC_ACTION}" method="post">
	<tr>
		<th class="catTop" colspan="3">{L_BLOCK_CUSTOM}</th>
	</tr>
	<tr>
		<td class="row1" colspan="3" align="center">
		<nobr>
		<input type="text" maxlength="100" size="30" name="mod_name" class="post" />
		<input type="submit" value="{L_CREATE_CUSTOM}" class="mainoption" />
		<input type="hidden" name="mode" value="create" />
		</nobr>
		</td>
	</tr>
</form>	
</table>
<br />	
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_MODULE}</th>
		<th class="thCornerR">{L_EDIT}</th>
		<th class="thCornerR">{L_DELETE}</th>
		<th class="thCornerR">{L_PERMISSIONS}</th>
	</tr>
	<!-- BEGIN modules -->
	<tr>
		<td class="{modules.ROW_CLASS}">{modules.MODULE_NAME}&nbsp;{modules.IMG_CUSTOM}</td>
		<td class="{modules.ROW_CLASS}" align="center"><a href="{modules.U_MODULES_EDIT}">{L_EDIT}</a></td>
		<td class="{modules.ROW_CLASS}" align="center"><a href="{modules.U_MODULES_DELETE}">{L_DELETE}</a></td>
		<td class="{modules.ROW_CLASS}" align="center">{modules.U_MODULES_PERMISSIONS}</td>
	</tr>
	<!-- END modules -->
</table>
</td>
</tr>
</table>
<br />
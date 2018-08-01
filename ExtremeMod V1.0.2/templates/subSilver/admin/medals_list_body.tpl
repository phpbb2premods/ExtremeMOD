
<h1>{L_MEDAL_TITLE}</h1>

<p class="gen">{L_MEDAL_EXPLAIN}</p>

<form method="post" action="{S_MEDAL_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="catBottom" align="center" colspan="6"><input class="post" type="text" name="name" />&nbsp;<input type="submit" class="mainoption" name="addcat" value="{L_CREATE_NEW_MEDAL_CAT}" />&nbsp;&nbsp;<input type="submit" class="mainoption" name="addmedal" value="{L_CREATE_NEW_MEDAL}" />&nbsp;</td>
	</tr>
</table>
<BR>
<!-- BEGIN catrow -->
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<td class="catLeft" colspan="2"><span class="cattitle"><b>{catrow.CAT_DESC}</b></span></td>
		<td class="cat" align="center" valign="middle" nowrap="nowrap"><span class="gen"><a href="{catrow.U_CAT_MOVE_UP}">{L_MOVE_UP}</a> <a href="{catrow.U_CAT_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="cat" align="center"><span class="gen"><a href="{catrow.U_CAT_EDIT}">{L_EDIT}</a></span></td>
		<td class="catRight" align="center" colspan="2"><span class="gen"><a href="{catrow.U_CAT_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<tr>
		<th class="thCornerL" width="15%">{L_MEDAL_NAME}</th>
		<th class="thTop">{L_MEDAL_IMAGE}</th>
        	<th class="thTop" width="50%">{L_MEDAL_DESCRIPTION}</th>
		<th class="thTop" width="10%">{L_MEDAL_MOD}</th>
		<th class="thTop" NOWRAP>{L_EDIT}</th>
		<th class="thCornerR" NOWRAP>{L_DELETE}</th>
	</tr>
	<!-- BEGIN medals -->
	<tr>
		<td class="row1" align="center"><span class="gen">{catrow.medals.MEDAL_NAME}</span></td>
		<td class="row2" align="center"><span class="gen">{catrow.medals.MEDAL_IMAGE}</span></td>
	        <td class="row1" align="center"><span class="gen">{catrow.medals.MEDAL_DESCRIPTION}</span></td>
		<td class="row2" align="center"><span class="gen"><a href="{catrow.medals.U_MEDAL_MOD}">{L_MEDAL_MOD}</a></span></td>
		<td class="row1" align="center"><span class="gen">&nbsp;<a href="{catrow.medals.U_MEDAL_EDIT}">{L_EDIT}</a>&nbsp;</span></td>
		<td class="row2" align="center"><span class="gen">&nbsp;<a href="{catrow.medals.U_MEDAL_DELETE}">{L_DELETE}</a>&nbsp;</span></td>
	</tr>
	<!-- END medals -->
	<!-- BEGIN nomedals -->
	<tr>
		<td class="row1" colspan="6" align="center"><span class="gen">{catrow.nomedals.L_NO_MEDAL_IN_CAT}</span></td>
	</tr>
	<!-- END nomedals -->
	<tr>
		<td colspan="7" height="1" class="spaceRow"><img src="../templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
</table>
<BR>
<!-- END catrow -->			

</form>

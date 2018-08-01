
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="middle" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
	  -> {L_MEDALS}</span></td>
  </tr>
</table>

<!-- BEGIN catrow -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr> 
		<td class="catLeft" colspan="2" height="28"><span class="cattitle">{catrow.CAT_DESC}</span></td>
		<td class="rowpic" colspan="2" align="right">&nbsp;</td>
	</tr>
	<tr>
		<th class="thCornerL" width="15%" height="25" nowrap="nowrap">&nbsp;{L_MEDAL_NAME}&nbsp;</th>
		<th class="thTop" width="50%" nowrap="nowrap">&nbsp;{L_MEDAL_DESCRIPTION}&nbsp;</th>
		<th class="thTop" width="20%" nowrap="nowrap">&nbsp;{L_USERS_LIST}&nbsp;</th>
		<th class="thCornerR" nowrap="nowrap">&nbsp;{L_MEDAL_MODERATOR}&nbsp;</th>
	</tr>
	<!-- BEGIN medals -->
	<tr>
		<td class="row1" align="center" nowrap="nowrap">
			<span class="genmed">{catrow.medals.MEDAL_NAME}</span><br />{catrow.medals.MEDAL_IMAGE}</td>
		<td class="row1" valign="center" align="center">
			<span class="gen">{catrow.medals.MEDAL_DESCRIPTION}</span></td>
		<td class="row2" valign="center" align="center">
			<span class="gensmall">{catrow.medals.USERS_LIST}</span></td>
		<td class="row2" valign="center" align="center">
			<span class="gensmall">{catrow.medals.MEDAL_MOD}</span>
			<!-- BEGIN switch_mod_option -->
			<br /><span class="gensmall"><a href="{catrow.medals.U_MEDAL_CP}" class="gensmall">{L_LINK_TO_CP}</a></span>
			<!-- END switch_mod_option -->
		</td>
	</tr>
	<!-- END medals -->
</table>
<br />
<!-- END catrow -->

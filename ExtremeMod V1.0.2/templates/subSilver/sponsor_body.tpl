
<form method="post" action="{S_MODE_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	  <td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
  </table>
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thCornerL" nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">{L_GAIN}</th>
	  <th class="thTop" nowrap="nowrap">{L_POINTS}</th>
	</tr>
	<!-- BEGIN sponsorrow -->
	<tr> 
	  <td class="{sponsorrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{sponsorrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{sponsorrow.ROW_CLASS}" align="center"><span class="gen"><a href="{sponsorrow.U_VIEWPROFILE}" class="gen"><b>{sponsorrow.USERNAME}</b></a></span></td>
	  <td class="{sponsorrow.ROW_CLASS}" align="center"><span class="gen">{sponsorrow.GAIN}</span></td>
	  <td class="{sponsorrow.ROW_CLASS}" align="center"><span class="gen">{sponsorrow.POINTS}</span></td>
	</tr>
	<!-- BEGIN first -->
	<tr> 
	  <td class="rowpic" align="center" colspan="2"><span class="genmed">{L_SPONSOR_FIRST}</span></td>
	  <td class="{sponsorrow.first.ROW_CLASS2}" align="center" colspan="2"><span class="gen"><a href="{sponsorrow.first.U_VIEWPROFILE2}" class="gen">{sponsorrow.first.USERNAME2}</a></span></td>
	</tr>
	<!-- BEGIN second -->
	<tr> 
	  <td class="rowpic" align="center" colspan="3"><span class="genmed">{L_SPONSOR_SECOND}</span></td>
	  <td class="{sponsorrow.first.second.ROW_CLASS3}" align="center" colspan="1"><span class="gen"><a href="{sponsorrow.first.second.U_VIEWPROFILE3}" class="gen">{sponsorrow.first.second.USERNAME3}</a></span></td>
	</tr>
	<!-- END second -->
	<!-- END first -->

	<!-- END sponsorrow -->
	<tr> 
	  <th class="thCornerL" colspan="5" height="28">&nbsp;</th>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"></td>
	</tr>
  </table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
</form>

<!-- BEGIN switch_user_logged_in -->
<br clear="all" />
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<td class="row1" align="center">
		<span class="gen">{L_LINK} : </span><br />
		<span class="nav">{U_LINK}</span>
	</td>
  </tr>
</table>
<!-- END switch_user_logged_in -->
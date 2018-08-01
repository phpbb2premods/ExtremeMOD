<table border="0" cellpadding="0" cellspacing="1" width="100%" class="bodyline">
  <tr>
	<th colspan="3" nowrap="nowrap">{PAGE_TITLE}</th>
  </tr>
  <tr>
	<td colspan="3" align="center" class="row3"><span class="gensmall"><br />{L_VICTORIES}<br /><br /></span></td>
  </tr>
<!-- BEGIN record -->
  <tr>
	<th height="25" align="center" width="10%">{record.L_IMG}</th>
	<th height="25" align="center" width="30%">{record.L_GAME}</th>
	<th height="25" align="center" nowrap="nowrap">{record.L_SCORE}</th>
  </tr>
<!-- BEGIN total_record -->
  <tr>
	<td class="row1" align="center" valign="middle" width="10%"><span class="gensmall">&nbsp;&nbsp;{record.total_record.GAME_PIC}&nbsp;&nbsp;</span></td>
	<td class="row1" align="left" width="30%"><span class="gensmall">&nbsp;&nbsp;&nbsp;&nbsp;<a href="{record.total_record.U_GAME}" target="_blank"> {record.total_record.GAME_NAME}</a>&nbsp;&nbsp;</span></td>
	<td class="row1" align="center" nowrap="nowrap"><span class="gensmall">{record.total_record.GAME_SCORE}</span></td>
  </tr>
<!-- END total_record -->
  <tr>
	<td colspan="3" align="center" class="row3">&nbsp;</td>
  </tr>
<!-- END record -->
  <tr>
	<th colspan="3" nowrap="nowrap" align="center">{L_CLOSE_WINDOW}</th>
  </tr>
</table>
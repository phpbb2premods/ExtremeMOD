<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="bodyline">
   <tr>
      <td class="cat" colspan="2"><span class="cattitle" align="center">{L_ARCADE_VOTE}</span></td>
   </tr>
<!-- BEGIN non_rated -->
<form action="{non_rated.S_RATE_ACTION}" method="post">
  <tr> 
    <td class="row1" width="20%"><span class="gen">{non_rated.L_ARCADE_VOTE_RATE}</span></td>
    <td class="row2" width="80%"><span style="font-weight: bold ; color: red ; font-size : 12px"><img src="images/arcades/spacer.gif" width="{non_rated.S_ARCADE_VOTE_RATE_B}" height="8">{non_rated.S_ARCADE_VOTE_RATE}</span>

<table width="105" cellspacing="1" cellpadding="0" class="bodyline" border="2px">
  <tr> 
	<td><img src="images/arcades/voting_bar.gif" width="{non_rated.S_ARCADE_VOTE_RATE_B}" height="8" alt="{non_rated.S_ARCADE_VOTE_RATE}" /></td>
  </tr>
</table>
	  <span class="gen">0<img src="images/arcades/spacer.gif" width="93" height="8">{non_rated.S_ARCADE_VOTE_MAX}</span>
      </td>
  </tr>
  <tr> 
      <td class="row2"> <span class="gen">{non_rated.L_ARCADE_VOTE_RATE_STATS_EXPLAIN}</span></td>
      <td class="row1"><span class="gen">{non_rated.L_ARCADE_VOTE_RATE_STATS}</span></td>
  </tr>
  <tr> 
      <td class="row1" ><span class="gen">{non_rated.L_ARCADE_VOTE2}</span></td>
      <td class="row2" ><span class="gen">{non_rated.S_ARCADE_VOTE_SELECT}</span></td>
  </tr>
  <tr>
      <td class="catBottom" colspan="2" align="center">{non_rated.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{non_rated.L_ARCADE_VOTE}" class="mainoption" /></td>
  </tr>
</form>
<!-- END non_rated -->
<!-- BEGIN already_rated -->
  <tr> 
     <td class="row1" width="20%"><span class="gen">{already_rated.L_ARCADE_VOTE_RATE}</span></td>
     <td class="row2" width="80%">
	 <span style="font-weight: bold ; color: red ; font-size : 12px"><img src="images/arcades/spacer.gif" width="{already_rated.S_ARCADE_VOTE_RATE_B}" height="8">{already_rated.S_ARCADE_VOTE_RATE}</span>

<table width="105" cellspacing="1" cellpadding="0" class="bodyline" border="2px">
  <tr> 
     <td><img src="images/arcades/voting_bar.gif" width="{already_rated.S_ARCADE_VOTE_RATE_B}" height="8" alt="{already_rated.S_ARCADE_VOTE_RATE}" /></td>
  </tr>
</table>
	 <span class="gen">0<img src="images/arcades/spacer.gif" width="93" height="8">{already_rated.S_ARCADE_VOTE_MAX}</span>
     </td>
  </tr>
  <tr> 
     <td class="row1" colspan="2" align="center"><span class="gen"><b>{already_rated.L_ARCADE_VOTE_ALREADY}</span></b></td>
  </tr>
  <tr> 
     <td class="row1" ><span class="gen">{already_rated.L_ARCADE_VOTE_YOUR_RATING_EXPLAIN}</span></td>
     <td class="row2" ><span style="font-weight: bold ; color: blue ; font-size : 12px">{already_rated.L_ARCADE_VOTE_YOUR_RATING}<span></td>
  </tr>
  <tr> 
     <td class="row1" ><span class="gen">{already_rated.L_ARCADE_VOTE_RATE_STATS_EXPLAIN}</span></td>
     <td class="row2" ><span class="gen">{already_rated.L_ARCADE_VOTE_RATE_STATS}</span></td>
  </tr>
  <tr>
     <td class="cat" align="center" height="20" width="30%" colspan="2">&nbsp;</td>
  </tr>
<!-- END already_rated -->
 
</table>

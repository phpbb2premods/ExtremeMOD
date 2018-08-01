<!-- BEGIN pas_record -->
<table width="80%"  border="0" align="center" cellpadding="2" cellspacing="2" class="forumline">
  <tr>
    <td colspan="3"><div align="center"><span class="genmed"><strong><br><br>&nbsp;{pas_record.MODOMSGA}&nbsp;<br><br><br></strong></span></div></td>
  </tr>
</table>
<!-- END pas_record -->
<!-- BEGIN record -->
<p><br />
</p>
<table width="80%"  border="0" align="center" cellpadding="2" cellspacing="2">
<form method='post' name='update' action='{record.S_ACTION}'>
  <tr>
    <td colspan="3"><div align="center"><span class="genmed"><strong>{record.MODOMSGA}&nbsp;<br><br></strong></span></div></td>
    </tr>
  <tr>
    <td width="40%"><div align="right"><span class="genmed">{MODOMSGH}&nbsp;:</span></div></td>
    <td width="33%"><span class="genmed">{record.GAME_NAME}</span></td>
    <td width="27%" rowspan="4"><div align="center"><span class="genmed">{MODOMSGL}<br><br></span></div></td>
    </tr>
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGI}&nbsp;:</span></div></td>
    <td><span class="genmed">{record.MODOMSGB}</span></td>
    </tr>
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGG}&nbsp;:</span></div></td>
    <td><span class="genmed">{record.MODOMSGC}</span></td>
    </tr>
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGE}&nbsp;:</span></div></td>
    <td><span class="genmed">{record.MODOMSGD}</span></td>
    </tr>
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGK}&nbsp;:</span></div></td>
    <td><span class="genmed">{record.MODOMSGJ}</span></td>
    <td><span class="genmed">
    </span></td>
    </tr>
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGM}&nbsp;:</span>
    </div></td>
    <td class='row2'><textarea name="commentaire" cols="45" rows="5" wrap="VIRTUAL" id="commentaire"></textarea></td>
    <td><span class="genmed">
      <input type="submit" name="Submit" value="Effacer ce record">
    </span></td>
  </tr>
 <!-- END record -->
<!-- BEGIN switch_points -->
  <tr>
    <td><div align="right"><span class="genmed">{MODOMSGS}&nbsp;:</span></div></td>
    <td class='row2'><span class="genmed">{OUI}
      <input type="radio" name="casesupp" value="1" checked {RETRAIT_OUI} />
    </span>
      | 
        <input type="radio" name="casesupp" value="0" {RETRAIT_NON} />      
      <span class="genmed">{NON}</span></td>
    <td>&nbsp;</td>
  </tr>
 <!-- END switch_points -->
  </form>
</table>
<p align="center">&nbsp; </p>

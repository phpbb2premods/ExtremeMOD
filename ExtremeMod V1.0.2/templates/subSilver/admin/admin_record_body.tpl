<script language="Javascript">
function setCheckboxes(do_check)
{
    var elts      = document.forms['recordsbox'].elements['select_list[]'];
    var elts_cnt  = (typeof(elts.length) != 'undefined')? elts.length : 0;

    if (elts_cnt)
	{
        for (var i = 0; i < elts_cnt; i++)
		{
            elts[i].checked = do_check;
        }
    }
	else
	{
        elts.checked = do_check;
    }
    return true;
}
</script>
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	    <th class="thHead" colspan="8">{L_MDRAA}</th>
	</tr>
	<tr>
	    <th class="thTop">#<br /></th>
	    <th class="thTop"><nobr>{L_MDRA}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRB}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRC}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRD}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRE}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRF}</nobr></th>
	    <th class="thTop"><nobr>{L_MDRG}</nobr></th>
	</tr>
<form name="recordsbox" action="{S_ACTION}" method="post">
<!-- BEGIN ligne_records -->
	<tr>
		<td class="row1" width="5%"><input type=checkbox name="select_list[]" value="{ligne_records.MDRA}"></td>
		<td class="row1" width="5%" align="center"><span class="genmed">{ligne_records.MDRA}</span></td>
		<td class="row1" width="15%" align="center"><span class="genmed">{ligne_records.MDRB}</span></td>
		<td class="row1" width="20%" align="center"><span class="genmed">{ligne_records.MDRC}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_records.MDRD}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_records.MDRE}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_records.MDRF}</span></td>
		<td class="row1" width="25%" align="center"><span class="genmed">{ligne_records.MDRG}</span></td>
	</tr>
<!-- END ligne_records -->
<!-- BEGIN switch_liste_non_vide -->
	<tr>
		<td colspan="8" class="row2">
			<img src="../images/arcades/arrow_ltr.gif">
	        &nbsp;&nbsp;<span class="gensmall"><a href="{S_ACTION}" onclick="setCheckboxes(true); return false;">
            {ALL_CHECKED}</a>
        &nbsp;/&nbsp;
        <a href="{S_ACTION}" onclick="setCheckboxes(false); return false;">
            {NOTHING_CHECKED}</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{L_FOR_GAME_SELECTION} :
			<input type=submit name="valid" value="{L_DELETE}" class="liteoption">
		</td>
	</tr>
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <br/>
   	<tr>
   		<td><span class="nav">{PAGE_NUMBER}</span></td>
   		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
   	</tr>
   </table>
<!-- END switch_liste_non_vide -->
</form>
</table>
<div align="center"><span class="genmed">{L_VER}</span><br /><br /><br clear="all" />
</div>

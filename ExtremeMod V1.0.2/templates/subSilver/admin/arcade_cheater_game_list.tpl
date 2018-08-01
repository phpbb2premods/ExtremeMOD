<script language="Javascript">
function setCheckboxes(do_check)
{
    var elts      = document.forms['gamecheaterbox'].elements['select_list[]'];
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
<h1>{L_TITLE}</h1>
<p><span class="gensmall">{L_EXPLAIN}</span></p>
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	    <th class="thHead" colspan="8">{L_TITLE}</th>
	</tr>
	<tr>
	    <th class="thTop">#</th>
	    <th class="thTop"><nobr>{L_USER}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME}</nobr></th>
	    <th class="thTop"><nobr>{L_DATE_CHEAT}</nobr></th>
	    <th class="thTop"><nobr>{L_SCORE}</nobr></th>
	    <th class="thTop"><nobr>{L_TIME_CLIENT}</nobr></th>
	    <th class="thTop"><nobr>{L_TIME_SERVER}</nobr></th>
	    <th class="thTop"><nobr>{L_CHEAT_TYPE}</nobr></th>
	</tr>
<form name="gamecheaterbox" action="{S_ACTION}" method="post">
<!-- BEGIN ligne_cheat -->
	<tr>
		<td class="row1" width="5%"><input type=checkbox name="select_list[]" value="{ligne_cheat.CHEATER_ID}"></td>
		<td class="row1" width="15%" align="center"><span class="genmed">{ligne_cheat.CHEATER_USERS}</span></td>
		<td class="row1" width="15%" align="center"><span class="genmed">{ligne_cheat.CHEATER_GAME}</a></td>
		<td class="row1" width="25%" align="center"><span class="genmed">{ligne_cheat.CHEATER_DATE_CHEAT}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_cheat.CHEATER_SCORE}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_cheat.CHEATER_TIME_CLIENT}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_cheat.CHEATER_TIME_SERVER}</a></span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{ligne_cheat.CHEATER_TYPE}</a></span></td>
	</tr>
<!-- END ligne_cheat -->
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
<br clear="all" />

<script language="Javascript">
function setCheckboxes(do_check)
{
    var tot      = document.forms['gamesdelliste'].elements['select_del_game[]'];
    var tot_games  = (typeof(tot.length) != 'undefined')? tot.length : 0;

    if (tot_games)
	{
        for (var i = 0; i < tot_games; i++)
		{
            tot[i].checked = do_check;
        }
    }
	else
	{
        tot.checked = do_check;
    }
    return true;
}
</script>

<table cellspacing="0" cellpadding="0" border="0" align="center">
      <br/>
   	<tr>
   		<td align="center"><h1>{TITLE}</h1></td>
   	</tr>
</table>

<form action="{S_ACTION}" method="post">
<table cellspacing="0" cellpadding="1" border="0" align="center" class="bodyline">
   	<tr>
   	    <td class="row2" align="center" valign="middle"><br />&nbsp;&nbsp;<span class="genmed"><b>{TOTAL_GAMES}</b> Jeux sont actuellement visibles et disponibles pour les invités</span>&nbsp;&nbsp;<br /><br /></td>
   	</tr>
	<tr> 
	    <td class="row2" align="center" valign="middle" nowrap="nowrap">&nbsp;&nbsp;<span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;
          <select name="sort">
          <option value="ORDER BY game_name" class="genmed" {GAME_NAME_SELECTED} >Nom du jeu</option>
          <option value="ORDER BY game_set" class="genmed" {GAME_SET_SELECTED} >Nb de partie</option>
          <option value="ORDER BY game_highscore" class="genmed" {GAME_HIGHSCORE_SELECTED} >Record</option>
          <option value="ORDER BY game_ultimate_highscore" class="genmed" {GAME_ULTIMATE_HIGHSCORE_SELECTED} >Record ultime</option>
          <option value="ORDER BY arcade_catid" class="genmed" {GAME_CAT_SELECTED} >Catégorie</option>
          <option value="ORDER BY game_id" class="genmed" {GAME_ID_SELECTED} >Game id</option>
          </select>
          &nbsp;&nbsp;{L_ORDER}:&nbsp;
          <select name="order">
          <option value="" {ASC_SELECTED} >{L_SORT_ASCENDING}</option>
          <option value="DESC" {DESC_SELECTED} >{L_SORT_DESCENDING}</option>
          </select>
          &nbsp;<input type="submit" value="{L_SORT}" class="liteoption">&nbsp;&nbsp;<br /><br /></td>
	</tr>
</table>
<br />

<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	    <th class="thTop">#<br /></th>
	    <th class="thTop"><nobr>{L_GAME_PIC}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_NAME}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_SET}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_ULTIMATE_HIGHSCORE}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_HIGHSCORE}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_CAT}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_DESC}</nobr></th>
	    <th class="thTop"><nobr>{L_GAME_ID}</nobr></th>
	</tr>
<!-- BEGIN listedel -->
	<tr>
		<td class="row1" width="5%"><input type=checkbox name="select_del_game[]" value="{listedel.GAME_ID}"></td>
		<td class="row1" width="5%" align="center"><span class="genmed">{listedel.GAME_PIC}</span></td>
		<td class="row1" width="20%" align="left"><span class="genmed">&nbsp;&nbsp;{listedel.GAME_NAME}</span></td>
		<td class="row1" width="5%" align="center"><span class="genmed">{listedel.GAME_SET}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{listedel.GAME_ULTIMATE_HIGHSCORE}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{listedel.GAME_HIGHSCORE}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{listedel.CAT_NAME}</span></td>
		<td class="row1" width="30%" align="center"><span class="gensmall">{listedel.GAME_DESC}</span></td>
		<td class="row1" width="10%" align="center"><span class="genmed">{listedel.GAME_ID}</span></td>
	</tr>
<!-- END listedel -->
<!-- BEGIN switch_listedel_existante -->
	<tr>
		<td colspan="9" class="row2">
			<img src="./../images/arcades/arrow_ltr.gif">
	        &nbsp;&nbsp;<span class="gensmall"><a href="{S_ACTION}" onclick="setCheckboxes(true); return false;">
            {ALL_CHECKED}</a>
        &nbsp;/&nbsp;
        <a href="{S_ACTION}" onclick="setCheckboxes(false); return false;">
            {NOTHING_CHECKED}</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{L_FOR_GAME_SELECTION} :
			<input type=submit name="mode" value="{L_DELETE}" class="liteoption">
		</td>
	</tr>
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <br/>
   	<tr>
   		<td><span class="nav">{PAGE_NUMBER}</span></td>
   		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
   	</tr>
   </table>
<!-- END switch_listedel_existante -->
</form>
</table>
<div align="center"><span class="genmed"> </span><br /><br /><br clear="all" />
</div>

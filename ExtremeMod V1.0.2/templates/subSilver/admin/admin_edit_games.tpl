
<h1>{L_EDIT_GAME}</h1>
<p><span class="gensmall">{L_EDIT_GAME_EXPLAIN}</span></p>

<form action="{S_ACTION}" method="post">
<table width="80%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_GAME_SETTINGS}</th>
</tr>
<tr> 
<td class="row1" width="50%">{L_GAME_NAME}<br />
<span class="gensmall">{L_GAME_NAME_EXPLAIN}</span></td>
<td class="row2" width="50%"> 
<input type="text" maxlength="255" size="40" name="game_name" value="{GAME_NAME}" class="post" />
</td>
</tr>
<tr> 
<td class="row1">{L_DESCRIPTION}<br />
<span class="gensmall">{L_DESCRIPTION_EXPLAIN}</span></td>
<td class="row2"> 
<textarea name="game_desc" rows="5" cols="30" style="width: 255px" class="post">{GAME_DESCRIPTION}</textarea>
</td>
</tr>
<tr>
<td class="row1">{L_GAME_AUTH_ACC}<br />
<span class="gensmall">{L_GAME_AUTH_ACC_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="radio" name="game_auth_acc" value="1" {GAME_AUTH_ACC_YES} />
{L_YES}&nbsp;&nbsp;
<input type="radio" name="game_auth_acc" value="0" {GAME_AUTH_ACC_NO} />
{L_NO}
</td>
</tr>
<tr>
<td class="row1">{L_GAME_PAD}<br />
<span class="gensmall">{L_GAME_PAD_EXPLAIN}</span></td>
<td class="row2">
<input type="text" size="3" maxlength="1" name="game_pad" value="{GAME_PAD}" class="post" />
</td>
</tr>
<tr> 
<td class="row1">{L_VIGNETTE}<br />
<span class="gensmall">{L_VIGNETTE_EXPLAIN}</span></td>
<td class="row2"> 
<input type="text" size="40" maxlength="255" name="game_pic" value="{GAME_VIGNETTE}" class="post" />
</td>
</tr>
<tr> 
<td class="row1">{L_SWF}<br />
<span class="gensmall">{L_SWF_EXPLAIN}</span></td>
<td class="row2"> 
<input type="text" size="40" maxlength="255" name="game_swf" value="{GAME_SWF}" class="post" />
</td>
</tr>
<tr> 
<td class="row1">{L_WIDTH}<br /> 
<span class="gensmall">{L_WIDTH_EXPLAIN}</span></td> 
<td class="row2"> 
<input type="text" size="8" maxlength="5" name="game_width" value="{GAME_WIDTH}" class="post" /> 
</td> 
</tr> 
<tr> 
<td class="row1">{L_HEIGHT}<br /> 
<span class="gensmall">{L_HEIGHT_EXPLAIN}</span></td> 
<td class="row2"> 
<input type="text" size="8" maxlength="5" name="game_height" value="{GAME_HEIGHT}" class="post" /> 
</td> 
</tr>
<tr> 
<td class="row1">{L_POINT_PAY}<br /> 
<span class="gensmall">{L_POINT_PAY_EXPLAIN}</span></td> 
<td class="row2"> 
<input type="text" size="8" maxlength="5" name="point_pay" value="{POINT_PAY}" class="post" /> 
</td> 
</tr> 
<tr> 
<td class="row1">{L_POINT_PRIZE}<br /> 
<span class="gensmall">{L_POINT_PRIZE_EXPLAIN}</span></td> 
<td class="row2"> 
<input type="text" size="8" maxlength="5" name="point_prize" value="{POINT_PRIZE}" class="post" /> 
</td> 
</tr>
<tr>
<td class="row1">{L_HIGHSCORE_TYPE}<br />
<span class="gensmall">{L_HIGHSCORE_TYPE_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="radio" name="highscore_type" value="1" {HIGHSCORE_TYPE_ASC} />
{L_ASC}&nbsp;&nbsp;
<input type="radio" name="highscore_type" value="0" {HIGHSCORE_TYPE_DESC} />
{L_DESC}
</td>
</tr>
<tr>
<td class="row1">{L_CATEGORIE}<br />
<span class="gensmall">{L_CATEGORIE_EXPLAIN}</span></td>
<td class="row2"> 
<select name="arcade_catid" class="post">
{S_CATEGORIE}
</select>
</td>
</tr>
<tr>
<td class="row1">{L_CHEAT_CONTROL}<br />
<span class="gensmall">{L_CHEAT_CONTROL_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="radio" name="game_cheat_control" value="1" {CHEAT_CONTROL_YES} />
{L_YES}&nbsp;&nbsp;
<input type="radio" name="game_cheat_control" value="0" {CHEAT_CONTROL_NO} />
{L_NO}
</td>
</tr>
<tr> 
<th colspan="2">{L_SCORE_SETTINGS}</th>
</tr>
<tr>
<td class="row1" colspan="2"><span class="gensmall">{L_SCORE_SETTINGS_EXPLAIN}</span></td>
</tr>
<tr> 
<td class="row1">{L_SCOREVARIABLE}<br />
<span class="gensmall">{L_SCOREVARIABLE_EXPLAIN}</span></td>
<td class="row2"> 
<input type="text" name="game_scorevar" value="{SCOREVARIABLE}" class="post" />
</td>
</tr>
<tr>
<td class="row1">{L_GESTION_SCORE}<br />
<span class="gensmall">{L_GESTION_SCORE_EXPLAIN}</span></td>
<td class="row2"> 
<select name="game_type" class="post">
<option value="0" {SELECTED0}>Type 0</option>
<option value="1" {SELECTED1}>Type 1</option>
<option value="2" {SELECTED2}>Type 2</option>
<option value="3" {SELECTED3}>Type 3</option>
<option value="4" {SELECTED4}>Type 4</option>
</select>
</td>
</tr>
<tr> 
<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
</td>
</tr>
</table>
</form>
<br clear="all" />

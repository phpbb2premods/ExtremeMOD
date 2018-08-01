<form action="{S_SPONSOR_ACTION}" method="post">

<h1>{L_SPONSOR_TITLE}</h1>
<p>{L_SPONSOR_EXPLAIN}</p>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline" align="center">
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BASE_CHECKED}</span></td>
		<td class="row2" align="center" valign="middle">
			<input type="radio" name="sponsor_enabled" value="0" {NO_BASE_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="sponsor_enabled" value="1" {BASE_CHECKED} />{L_YES}
		</td>
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="90%" class="forumline" align="center">
	<tr>
		<th align="center" colspan="2">{L_GAIN_REGISTER}</th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_GAIN_FIRST}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="sponsor_gain_first" value="{GAIN_FIRST}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td> 
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_GAIN_SECOND}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="sponsor_gain_second" value="{GAIN_SECOND}" /><span class="gensmall">&nbsp;{L_POINTS}</span></td> 
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="2">{L_GAIN_POINTS}</span></th>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_BASE_CHECKED}</span><br /><span class="gensmall">{L_GAIN_POINTS_EXPLAIN}</span></td>
		<td class="row2" align="center" valign="middle">
			<input type="radio" name="sponsor_points_enabled" value="0" {NO_POINTS_CHECKED} />{L_NO}&nbsp;
			<input type="radio" name="sponsor_points_enabled" value="1" {POINTS_CHECKED} />{L_YES}
		</td>
	</tr>
	<tr>
		<td class="row1" width="65%"><span class="gen">{L_POINTS_CHECKED}</span><br /><span class="gensmall">{L_POINTS_CHECKED_EXPLAIN}</span></td>
		<td class="row2" align="center" ><input class="post" type="text" maxlength="8" size="8" name="sponsor_points_gain" value="{GAIN_POINTS}" /><span class="gensmall">&nbsp;%</span></td> 
	</tr>
</table>

<br clear="all" />

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="catBottom" align="center"><input class="mainoption" type="submit" value="{L_SUBMIT}" name="submit" /></td>
	</tr>
</table>

</form>
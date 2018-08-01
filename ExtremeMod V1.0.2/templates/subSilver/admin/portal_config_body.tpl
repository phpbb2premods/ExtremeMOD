<div class="maintitle">{L_CONFIGURATION_TITLE}</div>
<br />
<div class="genmed">{L_CONFIGURATION_EXPLAIN}</div>
<br />
{L_VERSION_INFO}
<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_GENERAL_SETTINGS}</th>
</tr>
<tr> 
<td class="row1" width="38%">{L_SPACE_ROW}<br />
<span class="gensmall">{L_SPACE_ROW_EXPLAIN}</span>
</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="3" name="space_row" value="{SPACE_ROW}" class="post" />
</td>
</tr>
<tr>
<td class="row1" width="38%">{L_SPACE_COL}<br />
<span class="gensmall">{L_SPACE_COL_EXPLAIN}</span>
</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="3" name="space_col" value="{SPACE_COL}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_WIDTH_COL1}</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="5" name="col1_size" value="{WIDTH_COL1}" class="post" />
&nbsp;
<select name='col1_unit' class="option">
<option value='percent' {COL1_PERCENT}>{L_PERCENT}</option>
<option value='pixel'  {COL1_PIXEL}>{L_PIXEL}</option>
</select>
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_WIDTH_COL2}</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="5" name="col2_size" value="{WIDTH_COL2}" class="post" />
&nbsp;
<select name='col2_unit' class="option">
<option value='percent' {COL2_PERCENT}>{L_PERCENT}</option>
<option value='pixel'  {COL2_PIXEL}>{L_PIXEL}</option>
</select>
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_WIDTH_COL3}</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="5" name="col3_size" value="{WIDTH_COL3}" class="post" />
&nbsp;
<select name='col3_unit' class="option">
<option value='percent' {COL3_PERCENT}>{L_PERCENT}</option>
<option value='pixel'  {COL3_PIXEL}>{L_PIXEL}</option>
</select>
</td>
</tr>
<tr>
<td class="row1" width="38%">{L_HEADER_FORUM}</td>
<td class="row2" width="62%"> 
<input type="radio" name="forum_header" value="1" {S_HEADER_FORUM_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="forum_header" value="0" {S_HEADER_FORUM_NO} />
{L_NO}
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_PORTAL_BODYLINE}<br />
<span class="gensmall">{L_USEFUL}</span>
</td>
<td class="row2" width="62%"> 
<input type="radio" name="bodyline" value="1" {S_BODYLINE_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="bodyline" value="0" {S_BODYLINE_NO} />
{L_NO}
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_HEADER_OUTBODYLINE}<br />
<span class="gensmall">{L_OUTBODYLINE_EXPLAIN}</span>
</td>
<td class="row2" width="62%"> 
<input type="radio" name="head_out_bodyline" value="1" {S_HEAD_OUTBODYLINE_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="head_out_bodyline" value="0" {S_HEAD_OUTBODYLINE_NO} />
{L_NO}
</td>
</tr>
<tr> 
	<td class="row1" width="38%">
		{L_FOOTER_OUTBODYLINE}<br />
		<span class="gensmall">{L_OUTBODYLINE_EXPLAIN}</span>
	</td>
	<td class="row2" width="62%"> 
		<input type="radio" name="foot_out_bodyline" value="1" {S_FOOT_OUTBODYLINE_YES} />
		{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="foot_out_bodyline" value="0" {S_FOOT_OUTBODYLINE_NO} />
		{L_NO}
	</td>
</tr>
<!-- Activation / Désactivation de l'avatar invité -->
<tr> 
	<td class="row1" width="38%">
		{L_GUEST_AVATAR}<br />
		<span class="gensmall">{L_GUEST_AVATAR_EXPLAIN}</span>
	</td>
	<td class="row2" width="62%"> 
		<input type="radio" name="guest_avatar" value="1" {S_GUEST_AVATAR_YES} />
		{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="guest_avatar" value="0" {S_GUEST_AVATAR_NO} />
		{L_NO}
	</td>
</tr>
		

<tr> 
<th colspan="2">{L_MODULE_BIENVENUE}</th>
</tr>
<tr> 
<td class="row1" width="38%">{L_USE_SIMPLE_TEXT}<br />
<span class="gensmall">{L_USE_SIMPLE_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<input type="radio" name="simple_welcome" value="1" {S_SIMPLE_WELCOME_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="simple_welcome" value="0" {S_SIMPLE_WELCOME_NO} />
{L_NO}
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_WELCOME_TEXT}<br />
<span class="gensmall">{L_WELCOME_TEXT_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<textarea name="welcome_text" rows="5" cols="30" style="width: 300px" class="post">{WELCOME_TEXT}</textarea>
</td>
</tr>
<tr> 
<th colspan="2">{L_MODULE_NEWS}</th>
</tr>
<tr> 
<td class="row1" width="38%">{L_NUMBER_OF_NEWS}<br />
<span class="gensmall">{L_NUMBER_OF_NEWS_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="4" name="number_of_news" value="{NUMBER_OF_NEWS}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_NEWS_LENGTH}</td>
<td class="row2" width="62%"> 
<input type="text" maxlength="255" size="4" name="news_length" value="{NEWS_LENGTH}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_NEWS_FORUM}<br />
<span class="gensmall">{L_NEWS_FORUM_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<select name='news_forum' class="post" >
{NEWS_FORUM}
</select>
</td>
</tr>
<tr> 
<th colspan="2">{L_MODULE_POLL}</th>
</tr>
<tr> 
<td class="row1" width="38%">{L_POLL_FORUM}<br />
<span class="gensmall">{L_POLL_FORUM_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<select name='poll_id' class="post" >
{POLL_ID}
</select>
</td>
</tr>
<tr> 
<th colspan="2">{L_MODULE_RECENT_TOPICS}</th>
</tr>
<tr> 
<td class="row1" width="38%">{L_NUMBER_TOPICS}<br />
<span class="gensmall">{L_NUMBER_TOPICS_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="text" maxlength="4" size="4" name="number_recent_topics" value="{S_NUMBER_TOPICS}" class="post" /> 
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_SCROLLING}<br />
<span class="gensmall">{L_SCROLLING_EXPLAIN}</span></td>
<td class="row2" width="62%"> 
<input type="radio" name="scrolling_topics" value="1" {S_SCROLLING_TOPICS_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="scrolling_topics" value="0" {S_SCROLLING_TOPICS_NO} />
{L_NO}
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_SCROLLING_WAY}<br />
<span class="gensmall">{L_SCROLLING_ONLY}</span></td>
<td class="row2" width="62%"> 
<input type="radio" name="scroll_up" value="1" {S_SCROLLING_UP} />
{L_UP}&nbsp;&nbsp; 
<input type="radio" name="scroll_up" value="0" {S_SCROLLING_DOWN} />
{L_DOWN}
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_SCROLLING_HEIGHT}<br />
<span class="gensmall">{L_SCROLLING_HEIGHT_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="text" maxlength="4" size="4" name="scroll_height" value="{S_SCROLLING_HEIGHT}" class="post" /> 
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_SCROLLING_DELAY}<br />
<span class="gensmall">{L_SCROLLING_DELAY_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="text" maxlength="4" size="4" name="scroll_delay" value="{S_SCROLLING_DELAY}" class="post" /> 
</td>
</tr>
<tr> 
<td class="row1" width="38%">{L_SCROLLING_STEP}<br />
<span class="gensmall">{L_SCROLLING_STEP_EXPLAIN}</span></td>
<td class="row2" width="62%">
<input type="text" maxlength="4" size="4" name="scroll_step" value="{S_SCROLLING_STEP}" class="post" /> 
</td>
</tr>
<tr> 
<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" class="button" />
</td>
</tr>

</table>
</form>
<br clear="all" />
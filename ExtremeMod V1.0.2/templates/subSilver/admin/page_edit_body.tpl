
<h1>{L_PAGES_TITLE}</h1>

<P>{L_PAGES_ADD_TEXT}</p>
<form action="{S_PAGE_ACTION}" method="post">
<table cellspacing="1" width="80%" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2">{L_GENERAL_OPTION}</th>
	</tr>
	<tr>
		<td class="row1" width="38%">{L_PAGE_DESC}</td>
		<td class="row2" width="62%"><input type="text" maxlength="100" size="40" name="page_desc" value="{PAGE_DESC}" class="post" /></td>		
	</tr>
	<tr>
		<td class="row1" width="38%">{L_PAGE_FORUM_HEADER}<br /><span class="gensmall">{L_PAGE_FORUM_HEADER_EXPLAIN}</span></td>
		<td class="row2" width="62%">
		<input type="radio" name="page_forum_header" value="-1" {S_PAGE_FORUM_HEADER_DEFAULT} />
			{L_PORTAL_DEFAULT}&nbsp;&nbsp; 
		<input type="radio" name="page_forum_header" value="1" {S_PAGE_FORUM_HEADER_YES} />
			{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="page_forum_header" value="0" {S_PAGE_FORUM_HEADER_NO} />
			{L_NO}
		</td>		
	</tr>
	<tr>
		<td class="row1" width="38%">{L_PAGE_DEFAULTSIZE}<br />
		<span class="gensmall">{L_PAGE_DEFAULTSIZE_EXPLAIN}</span>
		</td>
		<td class="row2" width="62%">
		<input type="radio" name="page_defaultsize" value="1" {S_DEFAULTSIZE_YES} />
			{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="page_defaultsize" value="0" {S_DEFAULTSIZE_NO} />
			{L_NO}
		</td>		
	</tr>
	<tr>
		<td class="row1" width="38%">{L_WIDTH_COL1}</td>
		<td class="row2" width="62%"> 
			<input type="text" maxlength="255" size="5" name="page_col1width" value="{WIDTH_COL1}" class="post" />
			&nbsp;
			<select name='page_col1unit' class="option">
			<option value='percent' {COL1_PERCENT}>{L_PERCENT}</option>
			<option value='pixel'  {COL1_PIXEL}>{L_PIXEL}</option>
			</select>
		</td>
	</tr>
	<tr> 
		<td class="row1" width="38%">{L_WIDTH_COL2}</td>
		<td class="row2" width="62%"> 
			<input type="text" maxlength="255" size="5" name="page_col2width" value="{WIDTH_COL2}" class="post" />
			&nbsp;
			<select name='page_col2unit' class="option">
			<option value='percent' {COL2_PERCENT}>{L_PERCENT}</option>
			<option value='pixel'  {COL2_PIXEL}>{L_PIXEL}</option>
			</select>
		</td>
	</tr>
	<tr> 
		<td class="row1" width="38%">{L_WIDTH_COL3}</td>
		<td class="row2" width="62%"> 
			<input type="text" maxlength="255" size="5" name="page_col3width" value="{WIDTH_COL3}" class="post" />
			&nbsp;
			<select name='page_col3unit' class="option">
			<option value='percent' {COL3_PERCENT}>{L_PERCENT}</option>
			<option value='pixel'  {COL3_PIXEL}>{L_PIXEL}</option>
			</select>
		</td>
	</tr>
	<tr> 
		<td colspan="2" align="center" class="cat">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" />
		</td>
	</tr>
</table>
<br />
</form>

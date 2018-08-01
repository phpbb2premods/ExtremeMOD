
<h1>{L_MODULES_TITLE}</h1>

<P>{L_MODULES_ADD_TEXT}</p>
<form action="{S_BLOC_ACTION}" method="post">
<table cellspacing="1" width="80%" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2">{L_GENERAL_OPTION} : {L_MODULE}</th>
	</tr>
	<tr>
		<td class="row1" width="38%">{L_VIEW_BLOCK}</td>
		<td class="row2" width="62%">
			<select name='modauth' class='option'>
			{S_AUTH}
			</select>
		</td>		
	</tr>
<!-- BEGIN custom_block -->	
	<tr>
		<td class="row1" width="38%">{L_BLOCK_NAME}</td>
		<td class="row2" width="62%"><input type="text" maxlength="100" size="40" name="mod_name" value="{MOD_NAME}" class="post" /></td>		
	</tr>
	<tr>
		<td class="row1" width="38%">{L_BLOCK_TABLE}<br />
		<span class="gensmall">{L_BLOCK_TABLE_EXPLAIN}</span>
		</td>
		<td class="row2" width="62%">
		<input type="radio" name="mod_table" value="1" {S_TABLE_YES} />
			{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="mod_table" value="0" {S_TABLE_NO} />
			{L_NO}
		</td>		
	</tr>
	<tr>
		<td class="row1" width="38%">{L_BLOCK_TITRE}<br />
		<span class="gensmall">{L_BLOCK_TITRE_EXPLAIN}</span>
		</td>
		<td class="row2" width="62%"><input type="text" maxlength="100" size="40" name="mod_title" value="{MOD_TITLE}" class="post" /></td>		
	</tr>	
	<tr> 
		<td class="row1" valign="top">{L_SOURCE}<br />
		<span class="gensmall">{L_SOURCE_EXPLAIN}</span>
		</td>
		<td class="row2"> 
		<textarea name="mod_source" rows="15" cols="60" style="width: 400px" class="post">{S_SOURCE}</textarea>
		</td>
	</tr>
<!-- END custom_block -->
	<tr> 
		<td colspan="2" align="center" class="cat">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" />
		</td>
	</tr>
</table>
<br />
</form>

<div class="maintitle">{L_LINK_TITLE}</div>
<br />
<div class="genmed">{L_LINK_EXPLAIN}</div>
<br />
<form action="{S_LINK_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
<tr> 
<th colspan="2">{L_LINK_SETTINGS}</th>
</tr>
<tr> 
<td class="row1" width="33%">{L_LINK_URL}</td>
<td class="row2" height="25"> 
<input type="text" size="60" name="linkurl" value="{LINK_URL}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_LINK_DESCRIPTION}</td>
<td class="row2"> 
<input type="text" size="60" name="linktext" value="{LINK_TEXT}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_IMG_URL}
<span class="gensmall"><br />{L_IMG_URL_EXPLAIN}</span>
</td>
<td class="row2" height="25"> 
<input type="text" size="60" name="imgurl" value="{IMG_URL}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_IMG_WIDTH}
<span class="gensmall"><br />{L_IMG_WIDTH_EXPLAIN}</span>
</td>
<td class="row2" height="25"> 
<input type="text" size="4" name="imgwidth" value="{IMG_WIDTH}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_IMG_HEIGHT}
<span class="gensmall"><br />{L_IMG_HEIGHT_EXPLAIN}</span>
</td>
<td class="row2" height="25"> 
<input type="text" size="4" name="imgheight" value="{IMG_HEIGHT}" class="post" />
</td>
</tr>
<tr> 
<td class="row1" width="33%">{L_ENABLED}
<span class="gensmall"><br />{L_ENABLED_EXPLAIN}</span>
</td>
<td class="row2" height="25"> 
<input type="radio" name="linkactive" value="1" {LINK_ACTIVE_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="linkactive" value="0" {LINK_ACTIVE_NO} />
{L_NO}
</td>
</tr>
<tr> 
<td colspan="2" align="center" class="cat">{S_HIDDEN_FIELDS} 
<input type="submit" name="{S_SUBMIT}" value="{L_SUBMIT}" class="mainoption" />
</td>
</tr>
</table>
</form>
		
<br clear="all" />
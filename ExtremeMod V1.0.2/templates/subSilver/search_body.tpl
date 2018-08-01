
<form name="post" action="{S_SEARCH_ACTION}" method="POST"><table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>

<table class="forumline" width="100%" cellpadding="4" cellspacing="1" border="0">
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_QUERY}</th>
	</tr>
	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br /><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_keywords" size="30" /><br /><input type="radio" name="search_terms" value="any" checked="checked" /> {L_SEARCH_ANY_TERMS}<br /><input type="radio" name="search_terms" value="all" /> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br /><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_author" size="30" /></span></td>
	</tr>
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_OPTIONS}</th>
	</tr>
	<tr> 
		<td class="row1" align="right" rowspan="2"><span class="gen">{L_FORUM}:&nbsp;</span></td>
		<td class="row2" rowspan="2"><span class="genmed"><select class="post" id="tree" name="search_tree[]" size="{S_FORUM_SIZE}" multiple="multiple" onchange="dom_tree.process();">
			<!-- BEGIN option -->
			<option value="{option.VALUE}"{option.SELECTED}>{option.INDENT}{option.L_VALUE}</option>
			<!-- END option -->
		</select></span></td>
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_SEARCH_PREVIOUS}:&nbsp;</span></td>
		<td class="row2" valign="middle"><span class="genmed"><select class="post" name="search_time">{S_TIME_OPTIONS}</select><br /><input type="radio" name="search_fields" value="all" checked="checked" /> {L_SEARCH_MESSAGE_TITLE}<br /><input type="radio" name="search_fields" value="msgonly" /> {L_SEARCH_MESSAGE_ONLY}</span></td>
	</tr>
	<tr> 
		
		<td class="row1" align="right"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row2" valign="middle" nowrap="nowrap"><span class="genmed"><select class="post" name="sort_by">{S_SORT_OPTIONS}</select><br /><input type="radio" name="sort_dir" value="ASC" /> {L_SORT_ASCENDING}<br /><input type="radio" name="sort_dir" value="DESC" checked="checked" /> {L_SORT_DESCENDING}</span>&nbsp;</td>
	</tr>
	<tr> 
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row2" nowrap="nowrap"><input type="radio" name="show_results" value="posts" /><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked" />{L_TOPICS}</span></td>
		<td class="row1" align="right"><span class="gen">{L_RETURN_FIRST}</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="return_chars">{S_CHARACTER_OPTIONS}</select> {L_CHARACTERS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="28">{S_HIDDEN_FIELDS}<input class="liteoption" type="submit" value="{L_SEARCH}" /></td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="right" valign="middle"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table></form>

<table width="100%" border="0">
	<tr>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>

<script type="text/javascript">
<!--//
function _dom_tree()
{
	this.previous = Array();
	this.is_cat = Array();
	this.mains = Array();
	this.last_child = Array();
}
	_dom_tree.prototype.init = function()
	{
		// on init, select all
		for ( i = document.post.tree.length - 1; i >= 0 ; i-- )
		{
			document.post.tree.options[i].selected = true;
			this.previous[i] = document.post.tree.options[i].selected;
		}
	}
	_dom_tree.prototype.process = function()
	{
		var select;
		var last_select_id;
		var stack_status;

		select = false;
		last_select_id = -1;
		stack_status = Array();

		// handles childs (from root to branches)
		for ( i = 0; i < document.post.tree.length; i++ )
		{
			stack_status[i] = -1;
			if ( i > last_select_id )
			{
				select = document.post.tree.options[i].selected;
				if ( (select != this.previous[i]) && (this.is_cat[i] || !this.previous[i]) )
				{
					last_select_id = this.last_child[i];
				}
			}
			document.post.tree.options[i].selected = select;
		}

		// handle the parents (from branches to root)
		for ( i = document.post.tree.length - 1; i >= 0 ; i-- )
		{
			stack_status[i] = (stack_status[i] == -1 ? true : stack_status[i]) && (this.is_cat[i] ? true : document.post.tree.options[i].selected);
			stack_status[ this.mains[i] ] = (stack_status[ this.mains[i] ] == -1 ? true : stack_status[ this.mains[i] ]) && stack_status[i];

			// final
			this.previous[i] = this.is_cat[i] ? stack_status[i] : document.post.tree.options[i].selected;
			document.post.tree.options[i].selected = false;
			document.post.tree.options[i].selected = this.previous[i];
		}
		return false;
	}

// instanciate
dom_tree = new _dom_tree();
dom_tree.is_cat = [{S_FORUM_IS_CAT}]
dom_tree.mains = [{S_FORUM_PARENT}];
dom_tree.last_child = [{S_FORUM_LAST_CHILDS}];
dom_tree.init();
//-->
</script>

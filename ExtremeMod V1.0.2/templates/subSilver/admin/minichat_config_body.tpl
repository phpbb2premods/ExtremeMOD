
<h1>{L_MINICHAT_TITLE}</h1>

<p>{L_MINICHAT_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_MINICHAT_TITLE}</th>
	</tr>
	<tr>
		<td class="row1">{L_SHOUTBOX_ON}</td>
		<td class="row2" width="45%">
		<input type="radio" name="shoutbox_on" value="1" {SHOUTBOX_ON_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_on" value="0" {SHOUTBOX_ON_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr> 
		<td class="row1">{L_DATE_ON}</td> 
		<td class="row2">
		<input type="radio" name="shoutbox_date_on" value="1" {DATE_ON_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_date_on" value="0" {DATE_ON_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr> 
	<tr>
		<td class="row1">{L_MAKE_LINKS}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_make_links" value="1" {MAKE_LINKS_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_make_links" value="0" {MAKE_LINKS_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_LINKS_NAMES}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_links_names" value="1" {LINKS_NAMES_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_links_names" value="0" {LINKS_NAMES_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_SMILIES}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_smilies" value="1" {ALLOW_SMILIES_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_smilies" value="0" {ALLOW_SMILIES_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr> 
		<td class="row1">{L_ALLOW_BBCODE}</td> 
		<td class="row2">
		<input type="radio" name="shoutbox_allow_bbcode" value="1" {ALLOW_BBCODE_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_bbcode" value="0" {ALLOW_BBCODE_NO} />
		<span class="genmed">{L_NO}</span>
		</td> 
	</tr> 
	<tr>
		<td class="row1">{L_ALLOW_EDIT}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_edit" value="1" {ALLOW_EDIT_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_edit" value="0" {ALLOW_EDIT_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_EDIT_ALL}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_edit_all" value="1" {ALLOW_EDIT_ALL_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_edit_all" value="0" {ALLOW_EDIT_ALL_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DELETE}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_delete" value="1" {ALLOW_DELETE_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_delete" value="0" {ALLOW_DELETE_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DELETE_ALL}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_delete_all" value="1" {ALLOW_DELETE_ALL_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_delete_all" value="0" {ALLOW_DELETE_ALL_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_GUEST}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_guest" value="1" {ALLOW_GUEST_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_guest" value="0" {ALLOW_GUEST_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_GUEST_VIEW}</td>
		<td class="row2">
		<input type="radio" name="shoutbox_allow_guest_view" value="1" {ALLOW_GUEST_VIEW_YES} />
		<span class="genmed">{L_YES}</span>&nbsp;
		<input type="radio" name="shoutbox_allow_guest_view" value="0" {ALLOW_GUEST_VIEW_NO} />
		<span class="genmed">{L_NO}</span>
		</td>
	</tr>
	<tr>
		<td class="row2" colspan="2"></td>
	</tr>
	<tr>
		<td class="row1">{L_COUNT_MSG}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_count_msg" value="{COUNT_MSG}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_SHOUT_MESSAGES_ON_INDEX}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_messages_number_on_index" value="{SHOUT_MESSAGES_ON_INDEX}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_DELETE_DAYS}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_delete_days" value="{DELETE_DAYS}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_TEXT_LENGHT}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_text_lenght" value="{TEXT_LENGHT}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_WORD_LENGHT}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_word_lenght" value="{WORD_LENGHT}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_DATE_FORMAT}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_date_format" value="{DATE_FORMAT}" size="10" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_SHOUT_REFRESH_TIME}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_refresh_time" value="{SHOUT_REFRESH_TIME}" size="10" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_SHOUT_SIZE}</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_width" value="{SHOUT_WIDTH}" size="4" maxlength="255" />&nbsp;x&nbsp;<input type="text" class="post" name="shoutbox_height" value="{SHOUT_HEIGHT}" size="4" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_BANNED_USER_ID}
		<br />
		<span class="gensmall">{L_BANNED_USER_ID_E}</span>
		</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_banned_user_id" value="{BANNED_USER_ID}" size="25" />
		</td>
	</tr>
	<tr>
		<td class="row1">{L_BANNED_USER_ID_VIEW}
		<br />
		<span class="gensmall">{L_BANNED_USER_ID_VIEW_E}</span>
		</td>
		<td class="row2">
		<input type="text" class="post" name="shoutbox_banned_user_id_view" value="{BANNED_USER_ID_VIEW}" size="25" />
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">
		{S_HIDDEN_FIELDS}
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;
		<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />

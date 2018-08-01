<HEAD>
<META http-equiv="refresh" content="{SHOUT_REFRESH_TIME}";url={U_SHOUTBOX_VIEW}?auto_refresh=1">
<style type="text/css">
<!--
/* Main table cell colours and backgrounds */
td.row1	{ background-color: #EFEFEF; }
td.row2	{ background-color: #DEE3E7; }
td.row3	{ background-color: #D1D7DC; }

/* Set Image style */
img, .forumline img {
	border: 0;
}
-->
</style>
</HEAD>
<!-- BEGIN shoutrow -->
<table cellpadding="0" cellspacing="1" border="0" width="100%">
<tr>
	<td class="{shoutrow.ROW_CLASS}"  width="100%">
	<span class="gensmall">
	&nbsp;{shoutrow.DELMSG}&nbsp;{shoutrow.EDITMSG}&nbsp;{shoutrow.DATE}
	{shoutrow.NAME}:&nbsp;{shoutrow.MSG}
	</span>
	</td>
</tr>
<!-- END shoutrow -->
<!-- BEGIN sb_banned_send -->
<tr>
	<td align="center" class="row1" width="100%">
	<span class="genmed">{sb_banned_send.LANG_SB_BANNED_SEND}</span>
	</td>
</tr>
<!-- END sb_banned_send -->
<!-- BEGIN login_to_shoutcast -->
<tr>
	<td align="center" class="row1" width="100%">
	<span class="genmed">{login_to_shoutcast.LANG_LOGIN_TO_SHOUT}</span>
	</td>
</tr>
<!-- END login_to_shoutcast -->
<!-- BEGIN flood -->
<tr>
	<td align="center" class="row1" width="100%">
	<span class="genmed">{flood.LANG_FLOOD}</span>
	</td>
</tr>
<!-- END flood -->
<!-- BEGIN too_long_word -->
<tr>
	<td align="center" class="row1" width="100%">
	<span class="genmed">{too_long_word.LANG_TOO_LONG_WORD}</span>
	</td>
</tr>
<!-- END too_long_word -->
</table>

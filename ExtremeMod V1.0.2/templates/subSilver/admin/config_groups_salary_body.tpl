<h1>{L_GROUP_SALARY_TITLE}</h1>

<p>{L_GROUP_SALARY_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" width="60%">{L_GROUP}</th>
		<th class="thHead">{L_SALARY}</th>
	</tr>
<!-- BEGIN row -->
	<tr>
		<td class="row1"><span class="gen"><u>{L_GROUP_NAME}</u> : {row.GROUP_NAME}<br /><span class="gensmall"><u>{L_GROUP_DESC}</u> : {row.GROUP_DESCRIPTION}<br /></span></td>
		<td class="row2" align="center"><span class="gen"><input type="post" name="{row.GROUP_ID}" maxlength="8" size="8" value="{row.GROUP_SALARY}" >&nbsp;{L_POINTS}</span></td>
	</tr>
<!-- END row -->
</table>

<br clear="all" />

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_GENERAL}</th>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CRON_SALARY}</span></td>
		<td class="row2" align="center"><input type="checkbox" value="1" name="cron_enable" {CRON_SALARY_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_CRON_SALARY_TIME}</span></td>
		<td class="row2" align="center"><input type="post" name="cron_time" maxlength="8" size="8" value="{CRON_SALARY_TIME}" />&nbsp;{L_DAYS}</td>
	</tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="row2" colspan="2" align="center"><input type="submit" value="{L_SUBMIT}" name="update" class="liteoption" /></td>
	</tr>
</table>

<br clear="all" />

<table width="100%" cellpadding="4" cellspacing="1" border="1" class="forumline">
	<tr>
		<td class="row2" align="center"><span class="gen">{L_MANUAL_UPDATE}</span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" align="center"><input type="submit" value="{L_SUBMIT}" name="manual_update" class="liteoption" /></td>
	</tr>
</table>

</form>
<br clear="all" />
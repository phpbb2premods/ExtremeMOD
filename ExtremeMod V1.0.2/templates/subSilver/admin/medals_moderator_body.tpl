
<h1>{L_MEDAL_MOD_TITLE}</h1>

<p>{L_MEDAL_MOD_EXPLAIN}</p>

<table width="90%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{MEDAL_NAME}</th>
	</tr>
	<tr> 
	  <td class="row1" width="20%">{L_MEDAL_DESCRIPTION}:</td>
	  <td class="row2">{MEDAL_DESCRIPTION}</td>
	</tr>
	<tr> 
	  <td class="row1" width="20%">{L_MEDAL_MOD}:</td>
	  <td class="row2">{MEDAL_MODERATORS}</td>
	</tr>
</table>

<form method="post" name="post" action="{S_MEDAL_ACTION}"><table width="90%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{L_MOD_USER}</th>
	</tr>
	<tr> 
	  <td class="row1" width="50%">{L_USERNAME}:</td>
	  <td class="row2"><input class="post" type="text" class="post" name="username" maxlength="50" size="20" /> <input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS} <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></td>
	</tr>
	<tr> 
	  <th class="thHead" colspan="2">{L_UNMOD_USER}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_USERNAME}: <br /><span class="gensmall">{L_UNMOD_USER_EXPLAIN}</span></td>
	  <td class="row2">{S_UNMOD_USERLIST_SELECT}</td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>

{S_HIDDEN_FIELDS}</form>

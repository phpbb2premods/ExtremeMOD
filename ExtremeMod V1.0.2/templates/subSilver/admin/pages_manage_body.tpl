
<h1>{L_PAGES_TITLE}</h1>

<P>{L_PAGES_ADD_TEXT}</p>
<table width="80%" align="center">
<tr>
<td>
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
<form action="{S_PAGE_ACTION}" method="post">
	<tr>
		<th class="catTop" colspan="4">{L_AGENCEMENT}</th>
	</tr>
	<tr>
		<td class="row1" colspan="4" align="center">
		<nobr>
		<input type="text" maxlength="100" size="30" name="page_desc" class="post" />
		<input type="submit" value="{L_CREATE_STRUCT}" class="mainoption" />
		<input type="hidden" name="mode" value="createstruct" />
		</nobr>
		</td>
	</tr>
</form>	
</table>
<br />	
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_PAGE}</th>
		<th class="thCornerL">{L_ACTION}</th>
		<th class="thCornerR">{L_EDIT}</th>
		<th class="thCornerR">{L_MANAGE}</th>
		<th class="thCornerR">{L_DELETE}</th>
		<th class="thCornerR">{L_PAGE_ID}</th>
	</tr>
	<!-- BEGIN pages -->
	<tr>
		<td class="{pages.ROW_CLASS}">
			{pages.PAGE_DESC}&nbsp;{pages.IMG_STAR}
		</td>
		<td class="{pages.ROW_CLASS}" align="center">
		 	<span class="gensmall">
			{pages.U_DEFINE_DEFAULT}
			<a href="{pages.U_DUPLIQUE}">{L_DUPLIQUE}</a>
			</span>
		</td>
		<td class="{pages.ROW_CLASS}" align="center"><a href="{pages.U_PAGE_EDIT}">{L_EDIT}</a></td>
		<td class="{pages.ROW_CLASS}" align="center"><a href="{pages.U_PAGE_MANAGE}">{L_MANAGE}</a></td>
		<td class="{pages.ROW_CLASS}" align="center">{pages.U_PAGE_DELETE}</td>
		<td class="{pages.ROW_CLASS}" align="center"><b>{pages.S_PID}</b></td>
	</tr>
	<!-- END pages -->
</table>
</td>
</tr>
</table>
<br />
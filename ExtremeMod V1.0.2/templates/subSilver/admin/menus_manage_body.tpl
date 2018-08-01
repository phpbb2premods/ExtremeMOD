
<h1>{L_MENUS_TITLE}</h1>

<P>{L_MENUS_TEXT}</p>
<table width="80%" align="center">
<tr>
<td>
<table cellspacing="1" cellpadding="4" width="100%" border="0" align="center" class="forumline">
<form action="{S_MENUS_ACTION}" method="post">
	<tr>
		<th class="catTop" colspan="4">{L_MANAGE_MENUS}</th>
	</tr>
	<tr>
		<td class="row1" colspan="4" align="center">
		<nobr>
		<input type="text" maxlength="100" size="30" name="menu_desc" class="post" />
		<input type="submit" value="{L_CREATE_MENU}" class="mainoption" />
		<input type="hidden" name="mode" value="createmenu" />
		</nobr>
		</td>
	</tr>
</form>	
</table>
<br />	
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_MENU}</th>
		<th class="thCornerL">{L_ACTION}</th>
		<th class="thCornerR">{L_EDIT}</th>
		<th class="thCornerR">{L_MANAGE}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN menu_row -->
	<tr>
		<td class="cat">
			{menu_row.MENU_DESC}&nbsp;{menu_row.IMG_STAR}
		</td>
		<td class="cat" align="center">
		 	<span class="gensmall">
			{menu_row.U_DEFINE_DEFAULT}
			<a href="{menu_row.U_DUPLIQUE}">{L_DUPLIQUE}</a>
			</span>
		</td>
		<td class="cat" align="center"><span class="gensmall"><a href="{menu_row.U_MENU_EDIT}">{L_EDIT}</a></span></td>
		<td class="cat" align="center"><span class="gensmall"><a href="{menu_row.U_MENU_MANAGE}">{L_MANAGE}</a></span></td>
		<td class="cat" align="center"><span class="gensmall">{menu_row.U_MENU_DELETE}</span></td>
	</tr>
	<!-- BEGIN page_row -->
	<tr>
		<td colspan="4" class="{menu_row.page_row.ROW_CLASS}">&nbsp;&nbsp;&nbsp;{menu_row.page_row.PAGE_DESC}</td>
		<td class="{menu_row.page_row.ROW_CLASS}"></td>
	</tr>
	<!-- END page_row -->
	<!-- BEGIN associate_row -->
	 <form action="{S_MENUS_ACTION}" method="post">
	<tr>
		<td colspan="5">
		  <select name="page_id" style="width:200px">
		  {menu_row.associate_row.SELECT_PAGES}
		  </select>
		  <input type="hidden" name="mode" value="associate" />
		  <input type="hidden" name="bid" value="{menu_row.associate_row.BID}" />
		  &nbsp;<input type="submit" class="liteoption" value="{menu_row.associate_row.ASSOCIATE_PAGE}" />
		</td>
	</tr>
   </form> 
	<!-- END associate_row -->
	<!-- END menu_row -->
</table>
</td>
</tr>
</table>
<br />
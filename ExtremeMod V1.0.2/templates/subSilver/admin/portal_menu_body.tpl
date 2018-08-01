<h1>{L_MENU_TITLE}</h1>
<p>{L_MENU_EXPLAIN}</p>
<h1>{MENU_DESC}</h1>
<form name="menu" action="{S_MENU_ACTION}" method="post">
<table width="99%" cellpadding="1" cellspacing="1" border="0" align="center" >
<tr>


<!-- AFFICHAGE DU MENU -->
<td valign="top">

		  <table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
		   <tr>
		   <td class="row1">
			{L_AFF_TYPE}&nbsp;
			<select name="maf" class="option" onchange="document.menu.submit()">
			{S_MAF}
			</select>
			<br/>
			<span class="gensmall">{L_AFF_TYPE_EXPLAIN}</span>
		  </tr>
		  </td>
		  </table>
			<br/>		  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
		   <tr>
		   <td class="row1">
		   <table width="100%" cellpadding="2" cellspacing="0" border="0">
   		   <!-- BEGIN rubrique_row -->
   		   <!-- BEGIN simple_row -->
		   <tr>
		    <td width="18">{rubrique_row.simple_row.UP}</td>
		    <td width="18">{rubrique_row.simple_row.DOWN}</td>
		    <td class="rowpic" height="20">
			<span class="genmed">{rubrique_row.simple_row.DESC}</span>
  		    </td>
		    <td width="18">{rubrique_row.simple_row.DELETE}</td>
		    <td width="18">{rubrique_row.simple_row.EDIT}</td>
		   </tr>
   		   <!-- END simple_row -->		   
   		   <!-- BEGIN entete_row -->
		   <tr>
		    <td width="18">{rubrique_row.entete_row.UP}</td>
		    <td width="18">{rubrique_row.entete_row.DOWN}</td>
		    <{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25">
			<span class="genmed"><b>{rubrique_row.entete_row.DESC}</b></span>
  		    </{PORTAL_CLASS_BALISE}>
		    <td width="18">{rubrique_row.entete_row.DELETE}</td>
		    <td width="18">{rubrique_row.entete_row.EDIT}</td>
		   </tr>
   		   <!-- END entete_row -->
   		   <!-- BEGIN ligne_row -->
		   <tr>
		    <td width="18">{rubrique_row.ligne_row.UP}</td>
		    <td width="18">{rubrique_row.ligne_row.DOWN}</td>
		    <td class="row1" align="center">
			<hr/>
  		    </td>
		    <td width="18">{rubrique_row.ligne_row.DELETE}</td>
		    <td width="18">{rubrique_row.ligne_row.EDIT}</td>
		   </tr>
   		   <!-- END ligne_row -->		   
   		   <!-- BEGIN image_row -->
		   <tr>
  		    <td width="18">{rubrique_row.image_row.UP}</td>
  		    <td width="18">{rubrique_row.image_row.DOWN}</td>
		    <td class="row1" align="center">
			<img src="{rubrique_row.image_row.URL}" alt="" />
  		    </td>
		    <td width="18">{rubrique_row.image_row.DELETE}</td>
		    <td width="18">{rubrique_row.image_row.EDIT}</td>
		   </tr>
   		   <!-- END image_row -->
   		   <!-- BEGIN lien_row -->
		   <tr>
		    <td width="18">{rubrique_row.lien_row.UP}</td>
		    <td width="18">{rubrique_row.lien_row.DOWN}</td>
		    <td class="row1">
			<span class="genmed" style="line-height: 150%">
		   {rubrique_row.lien_row.TAB}
		   {rubrique_row.lien_row.IMG}
		   {rubrique_row.lien_row.CARS}
			<a href="{rubrique_row.lien_row.URL}" {rubrique_row.lien_row.SCRIPT}>{rubrique_row.lien_row.DESC}</a>
		    </span>
  		    </td>
		    <td width="18">{rubrique_row.lien_row.DELETE}</td>
		    <td width="18">{rubrique_row.lien_row.EDIT}</td>
		   </tr>
   		   <!-- END lien_row -->
		   <!-- END rubrique_row -->		   
		   </table>
		   </td>
		   </tr>
		  </table>
<td>
<!-- FIN AFFICHAGE DU MENU -->



<td valign="top" width="70%">
<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
<tr> 
<th colspan="2">{L_MENU_OPTIONS}</th>
</tr>
<tr>
<td class="row1" valign="top">{L_TYPE_LIGNE}<br />
<span class="gensmall">{L_TYPE_LIGNE_EXPLAIN}</span>
</td>
<td class="row2" valign="top">
<input type="radio" name="navlig_type" value="0" {S_TYPE_0} />
{L_SIMPLE}<br/>
<input type="radio" name="navlig_type" value="1" {S_TYPE_1} />
{L_ENTETE}<br/>
<input type="radio" name="navlig_type" value="2" {S_TYPE_2} />
{L_LIGNE}<br/>
<input type="radio" name="navlig_type" value="3" {S_TYPE_3} />
{L_IMAGE}<br/>
<input type="radio" name="navlig_type" value="4" {S_TYPE_4} />
{L_LIEN}
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_TEXTE_AFFICHABLE}<br />
<span class="gensmall">{L_TEXTE_AFFICHABLE_EXPLAIN}</span>
</td>
<td class="row2">
<table width="100%">
<tr>
<td class="genmed"><nobr>{L_LANGKEY}</nobr></td>
<td>
<input type="text" maxlength="50" size="30" name="navlig_langkey" value="{S_LANGKEY}" class="post" />
</td>
</tr>
<tr>
<td class="genmed">{L_TEXTE}</td>
<td>
<input type="text" maxlength="100" size="30" name="navlig_texte" value="{S_TEXTE}" class="post" />
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_URL}<br />
<span class="gensmall">{L_URL_EXPLAIN}</span>
</td>
<td class="row2">
<input type="text" maxlength="100" size="30" name="navlig_url" value="{S_URL}" class="post" />
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_SCRIPT_URL}<br />
<span class="gensmall">{L_SCRIPT_URL_EXPLAIN}</span>
</td>
<td class="row2">
<input type="text" maxlength="100" size="30" name="navlig_script" value="{S_SCRIPT_URL}" class="post" />
</td>
</tr>
<tr>
	<td class="row1" valign="top">{L_ADD_SID}<br />
		<span class="gensmall">{L_ADD_SID_EXPLAIN}</span>
	</td>
	<td class="row2">
		<input type="radio" name="navlig_add_sid" value="1" {S_ADD_SID_YES} />
		{L_YES}&nbsp;&nbsp; 
		<input type="radio" name="navlig_add_sid" value="0" {S_ADD_SID_NO} />
		{L_NO}
	</td>
</tr>
<tr> 
<th colspan="2">{L_MENU_DEBUT}</th>
</tr>

<tr>
<td class="row1" valign="top">{L_RETRAIT}<br />
<span class="gensmall">{L_RETRAIT_EXPLAIN}</span>
</td>
<td class="row2">
<input type="radio" name="navlig_tab" value="1" {S_RETRAIT_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="navlig_tab" value="0" {S_RETRAIT_NO} />
{L_NO}
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_RETRAIT_WIDTH}<br />
<span class="gensmall">{L_RETRAIT_WIDTH_EXPLAIN}</span>
</td>
<td class="row2">
<input type="text" maxlength="10" size="5" name="navlig_tabsize" value="{S_RETRAIT_WIDTH}" class="post" />
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_ICONE}<br />
<span class="gensmall">{L_ICONE_EXPLAIN}</span>
</td>
<td class="row2">
<input type="radio" name="navlig_icone" value="1" {S_ICONE_YES} />
{L_YES}&nbsp;&nbsp; 
<input type="radio" name="navlig_icone" value="0" {S_ICONE_NO} />
{L_NO}
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_URL_ICONE}<br />
<span class="gensmall">{L_URL_ICONE_EXPLAIN}</span>
</td>
<td class="row2">
    <table width="100%">
    <tr>
       <td class="genmed"><nobr>{L_IMGKEY}</nobr></td>
       <td>
   <input type="text" maxlength="50" size="30" name="navlig_imgkey" value="{S_IMGKEY}" class="post" />
      </td>
   </tr>
   <tr>
     <td class="genmed">{L_URL}</td>
     <td>
   <input type="text" maxlength="100" size="30" name="navlig_iconeimg" value="{S_ICONE_URL}" class="post" />
    </td>
   </tr>
  </table>
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_ICONE_WIDTH}<br />
<span class="gensmall">{L_ICONE_WIDTH_EXPLAIN}</span>
</td>
<td class="row2">
<input type="text" maxlength="10" size="5" name="navlig_iconesize" value="{S_ICONE_SIZE}" class="post" />
</td>
</tr>
<tr>
<td class="row1" valign="top">{L_CHARS}<br />
<span class="gensmall">{L_CHARS_EXPLAIN}</span>
</td>
<td class="row2">
<input type="text" maxlength="10" size="10" name="navlig_cars" value="{S_CHARS}" class="post" />
</td>
</tr>

<tr>
<td class="row2" colspan="2" align="center">{L_AUTH}&nbsp;
<select name="navlig_auth" class="option">
{S_AUTHLIST}
</select>
</td>
</tr>
<tr> 
<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS} 
<!-- BEGIN update_row -->
<input type="submit" name="update" value="{L_UPDATE}" class="mainoption" />&nbsp;&nbsp;
<!-- END update_row -->
<input type="submit" name="new" value="{L_NEW}" class="mainoption" />&nbsp;&nbsp;
<input type="submit" name="reset" value="Reset" class="mainoption" />
</td>
</tr>

</table>
</td>
</tr>
</table>
<input type="hidden" name="bid" value="{S_BID}" />
</form>
<br clear="all" />
		  <table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
   		   <!-- BEGIN rubrique_row -->
   		   <!-- BEGIN simple_row -->
		   <tr>
		    <td class="rowpic" height="20">
			<span class="genmed">{rubrique_row.simple_row.DESC}</span>
  		    </td>
		   </tr>
   		   <!-- END simple_row -->		   
   		   <!-- BEGIN entete_row -->
		   <tr>
		    <{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25">
			<span class="genmed"><b>{rubrique_row.entete_row.DESC}</b></span>
  		    </{PORTAL_CLASS_BALISE}>
		   </tr>
   		   <!-- END entete_row -->
		   <!-- BEGIN debut_tr -->
		   <tr>
		    <td class="row1">
			<span class="genmed" style="line-height: 150%">
		   <!-- END debut_tr -->
		   <!-- BEGIN fin_tr -->
		    </span>
		    </td>
		   </tr>
		   <!-- END fin_tr -->
   		   <!-- BEGIN ligne_row -->
			<hr/>
   		   <!-- END ligne_row -->		   
   		   <!-- BEGIN image_row -->
		   <center>
			<img src="{rubrique_row.image_row.URL}" alt="" /><br/>
		   </center>
   		   <!-- END image_row -->
   		   <!-- BEGIN lien_row -->
		   {rubrique_row.lien_row.TAB}
		   {rubrique_row.lien_row.IMG}
		   {rubrique_row.lien_row.CARS}
			<a href="{rubrique_row.lien_row.URL}" {rubrique_row.lien_row.SCRIPT}>{rubrique_row.lien_row.DESC}</a><br/>
   		   <!-- END lien_row -->
		   <!-- END rubrique_row -->		   
		  </table>
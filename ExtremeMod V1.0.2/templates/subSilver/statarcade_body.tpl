<!-- affichage de la phrase d'index -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
   <tr>
	  <td align="left" valign="middle" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
   </tr>
</table>

<table width="100%" cellpadding="5" cellspacing="1" border="0" class="forumline">
  <tr> 
	 <th class="thTop" colspan="4" nowrap="nowrap">&nbsp;{L_STATS}&nbsp;</th>
  </tr>
  <tr>
	 <td colspan="4" align="center">[&nbsp;{URL_ARCADE}]&nbsp;-&nbsp;[&nbsp;{URL_BESTSCORES}]</td>
  </tr>
<!-- BEGIN blkligne -->
  <tr>
<!-- BEGIN blkcolonne -->
	 <td valign="top">

<!-- BEGIN blkgame -->
<table width="100%"  cellpadding="2" cellspacing="1" class="bodyline">
  <tr>
	 <td class="row2" colspan="2" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.GAMENAME}</span></td>
  </tr>
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_NBSET}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.NBSET}</span></td>
  </tr>
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_TPSSET}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.TPSSET}</span></td>
  </tr>		 
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_TPSMOY}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.TPSMOY}</span></td>
  </tr>		 		 
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_POSGAME}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.POSGAME}&nbsp;&nbsp;</span>{blkligne.blkcolonne.blkgame.IMGFIRST}</td>
  </tr>		 		 		 
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_HIGHSCR}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.HIGHSCR}</span></td>
  </tr>		 		 		 
  <tr>
	 <td class="row1" width="200" align="right"><span class="gensmall">{blkligne.blkcolonne.blkgame.L_DATHIGHSCR}</span></td>
	 <td class="row1" align="left"><span class="gensmall">{blkligne.blkcolonne.blkgame.DATHIGHSCR}</span></td>
  </tr>		 		 		 
</table>
<!-- END blkgame -->
	 </td>
<!-- END blkcolonne -->
  </tr>
 <!-- END blkligne -->
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr>
	 <td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
	 <td align="right" valign="middle"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
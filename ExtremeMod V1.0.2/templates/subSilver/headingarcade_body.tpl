<script language="JavaScript">
function resize_avatar(image)
{
  if ({MAXSIZE_AVATAR}>0)
  {
	if (image.width > {MAXSIZE_AVATAR} ) image.width={MAXSIZE_AVATAR} ;
  }
}
</script>

<table width="100%" cellpadding="2" cellspacing="3" border="0">
  <tr>
       <td width="100%">

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
  <tr>
	 <td class="cat" width="25%"><p align="center"><span class="cattitle">Top 10</span></p></td>
	 <td class="cat" width="60%"><p align="center"><span class="cattitle">Infos</span></p></td>
	 <td class="cat" width="15%"><p align="center"><span class="cattitle">Bienvenue</span></p></td>
  </tr>
  <tr>
	 <td class="row1" width="25%" rowspan="2" height="93">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="bodyline" align="center">
  <tr>
	 <td class="rowpic" align="center" width="5%"><p align="center"><span class="gensmall">#</span></td>
	 <td class="rowpic" align="center" width="30%"><p align="center"><span class="gensmall">Pseudo</span></td>
	 <td class="rowpic" align="center" width="10%" colspan="2"><p align="center"><span class="gensmall">Victoires</span></td>
  </tr>
<!-- BEGIN player_row -->
  <tr>
	 <td class="row2" align="center" height="2" width="5%" class="gensmall"><p align="center"><span class="gensmall">{player_row.CLASSEMENT}</span></td>
	 <td class="row1" align="center" height="2" class="gensmall" width="30%"><p align="center"><span class="gensmall">{player_row.USERNAME}</span></td>
	 <td class="row2" height="2" align="center" width="10%"><p align="center"><span class="gensmall">{player_row.VICTOIRES}</span></td>
	 <td class="row2" height="2" align="center" width="5%"><p align="center">{player_row.VICTORIES}</td>
  </tr>
<!-- END player_row -->
</table>

</td>
<td class="row1" align="center" height="20%">

<table width="99%" cellpadding="2" cellspacing="3" border="0">
  <tr>
	 <td width="99%">
<table width="99%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
  <tr>
	 <td class="cat" width="722"><p align="center"><span class="cattitle">Les derniers records</span></p></td>
  </tr>
  <tr>
	 <td class="row1" width="722" height="44">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="">
<!-- BEGIN arcaderow2 -->
<tbody>
  <tr>
       <td valign="top" align="center" width="100%">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tbody>
<!-- BEGIN bestscore2 -->
  <tr>
       <td class="{arcaderow2.bestscore2.CLASS}" align=left width="85%" valign="top"><p>&nbsp;<SPAN class=smallfont>• </SPAN><span class="gensmall">{arcaderow2.bestscore2.LAST_SCOREUSER} est devenu champion de {arcaderow2.bestscore2.LAST_SCOREGAME}</span></p></td>
       <td class="{arcaderow2.bestscore2.CLASS}" nowrap="nowrap" align="right" width="15%" valign="top"><p><span class="gensmall">{arcaderow2.bestscore2.LAST_SCOREDATE}</span><font size=1> </font></p></td>
  </tr>
<!-- END bestscore2 --> 
</tbody>
</table>
       </td>
  </tr>
</tbody>
<!-- END arcaderow2 --> 
</table>
       </td>
  </tr>
</table>
	 </td>  
  </tr>
</table>
	 </td>
	 <td class="row1" align="center" valign="center" width="15%" rowspan="2" height="93"><p align="center"><span class="cattitle">{USERNAME}<br />{POSTER_RANK}<br></span><span class="text">{AVATAR_IMG}</span><br /><span class="gensmall">Vous avez {ARCADE_VICTOIRES} {COURONNE}</span></p></td>
  </tr>
  <tr>
	 <td class="row1" width="60%" height="80%" align="center">
<table cellspacing="0" cellpadding="0" width="100%" valign="top" align="center" border="0">
  <tr>
	<td></td>
  </tr>
<!-- BEGIN arcaderow3 -->
<tbody>
  <tr>
      <td valign="top" width="100%" align="center">
<table valign="top" cellspacing="1" cellpadding="2" width="100%" border=0>
<rbody>
<!-- BEGIN score3 -->
  <tr>
      <td class=alt1 valign="top" align="left" width="85%"><p><span class=smallfont>• </span><span class="gensmall">{arcaderow3.score3.LAST_SCOREUSER} a renouvel&eacute; son score ({arcaderow3.score3.LAST_SCORE}) &agrave; {arcaderow3.score3.LAST_SCOREGAME}</span></p></td>
      <td class=alt1 valign="top" nowrap="nowrap" align="right" width="15%"><p><span class="gensmall">{arcaderow3.score3.LAST_SCOREDATE}</span><font size=1> </font></p></td>
  </tr>
<!-- END score3 --> 
</tbody>
</table>
	</td>
  </tr>
</tbody>
<!-- END arcaderow3 --> 
</table>
	</td>
  </tr>
</table>
	</td>  
  </tr>
</table>
<br />
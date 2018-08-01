<!-- affichage de la phrase d'index -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
      <td align="left" valign="middle" width="70%"><span class="nav"><a href="{U_INDEX}" alt="{L_INDEX}" title="{L_INDEX}" class="nav">{L_INDEX}</a></span><span class="nav">&nbsp;-&nbsp;{URL_ARCADE}</span></td>
      <td align="right" valign="middle" width="30%"><span class="nav">{URL_SEARCHGAMES}</span><br /></td>
  </tr>
</table>
<br />

<table width="90%" cellspacing="1" cellpadding="2" border="0" align="center" class="bodyline">
  <tr>
      <td class="cat" align="center"><span class="cattitle"><b>{SEARCHGAME_BOARD}</b></td>
  </tr>
  <tr>
      <td class="row2" align="center"><br /><span class="gen">Il y a actuellement {TOTAL_GAMES} jeux install&eacute;s sur ce site.</span><br /><br /></td>
  </tr>
  <tr>
      <td align="center" valign="middle" width="100%">

<table width="50%" cellspacing="0" cellpadding="0" border="0" align="center" class="">
  <tr>
      <td class="" colspan="2" align="center"><br /><span class="gen">{L_TOTAL_RESULTS}</span><br /></td>
  </tr>
</table>
<br />

<!-- BEGIN recherche --> 
<form method="post" action="{S_ACTION}">
<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center" class="bodyline">
  <tr>
      <td class="row2" align=center width="50%" height="44"><span class="gen">{L_PRECISION}</span><br /><br /><span class="gensmall">{L_TEXT}
      <input class="post" type="text" name="nom_a_chercher" size=20 maxlength=30><br /><br />{L_TYPE_SEARCH}</span>
      <select name="type_games">
      <option selected value="1">{L_TYPE_1}</option>
      <option value="2">{L_TYPE_2}</option>
      <option value="3">{L_TYPE_3}</option>
      <option value="4">{L_TYPE_4}</option>
      <option value="5">{L_TYPE_5}</option>
      <option value="6">{L_TYPE_6}</option>
      </select><br /><br /></td>
      <td class="row2" align="center">
      <input type="hidden" name="mode" value="rechercher">
      <input type="submit" class="mainoption" value="Lancer la recherche"></td>
  </tr>
  <tr>
      <td class="catBottom" colspan="2" align="center"></td>
  </tr>
</table>
<br /><br />
</form>
<!-- END recherche -->

<!-- BEGIN resultas --> 
<table width="60%" cellspacing="0" cellpadding="0" border="0" align="center" class="bodyline">
  <tr>
      <td width="50%" class="cat" align="left" valign="middle">{resultas.GAMES_PIC}</td>
      <td class="cat" align="center" colspan="2" valign="middle"><span class="cattitle"><b>{resultas.GAMES_NAME}</b></span></td>
      <td width="50%" class="cat" align="right" valign="middle">{resultas.GAMES_PIC}</td>
  </tr>
  <tr>
     <td width="50%" class="{resultas.ROW_CLASS}" colspan="2" align="left" valign="top"><span class="gen"><br />
      <b>Champion:</b> {resultas.GAMES_RECORD_USER}<br />
      <b>Record:</b> {resultas.GAMES_RECORD}<br />
      <b>Cat&eacute;gorie:</b> {resultas.GAMES_CAT}</a><br /><br />
<!-- BEGIN admin --> 
      <b>ID:</b> {resultas.admin.GAMES_ID}<br />
      <b>Type:</b> {resultas.admin.GAMES_TYPE}<br />
      <b>Variable:</b> {resultas.admin.GAMES_VAR}<br /><br />
<!-- END admin -->
      </span></td>
      <td width="50%" class="{resultas.ROW_CLASS}" colspan="2" align="center" valign="top"><span class="gen"><br />
      <b>Description du jeu</b><br />
      <br />{resultas.GAMES_DESC}</span><br /></td>
  </tr>
  <tr>
      <td class="cat" colspan="4" align="center" valign="middle"><span class="gen">{resultas.GAMES_LINK}</span></td>
  </tr>
</table>
<br />
<!-- END resultas -->

<!-- BEGIN switch --> 
<table width="50%" cellspacing="0" cellpadding="0" border="0" align="center" class="">
  <tr>
      <td align="center"><span class="gen">{switch.L_NO_RESULTS}<br />{switch.NEW_SEARCHGAMES}<br /><br /></span></td>
  </tr>
</table>
<!-- END switch -->
    </td>
</table>
<br />

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
      <td align="left" valign="middle" width="70%"><span class="nav"><a href="{U_INDEX}" alt="{L_INDEX}" title="{L_INDEX}" class="nav">{L_INDEX}</a></span><span class="nav">&nbsp;-&nbsp;{URL_ARCADE}</span></td>
  </tr>
</table>
<br />
<SCRIPT language=JavaScript1.2 type=text/javascript>
function popup(URL,width,height){
   /* Parametre l'url que l'on veut afficher dans la fentre */
        popupR("Popup", URL,width,height, "no", "no", "yes")
}

function popupR(titre, URL,width,height, scrolling, redimentionnee, dependent){
   var name = titre;
        var parameters = "resizable="+redimentionnee+",alwaysRaised=no,alwaysLowered=no,width="+width+",height="+height+",menubar=no,toolbar=no,locationbar=no,personalbar=no,scrollbars="+scrolling+",titlebar=no,screenY="+ (screen.height/2-height/2)+",screenX="+(screen.width/2-width/2)+",z-lock=no,hotkeys=no,directories=no,alwaysLowered=yes,dependent="+dependent;
        var newWindow=window.open(URL, name, parameters);
}
</script>
<table width="100%" cellpadding="2" cellspacing="3" border="0">
	<tr>
		<td width="100%">
		<table width="100%" cellpadding="2" cellspacing="1" border="0" class="bodyline">
			<tr>
				<td class="cat" width="100%">
					<p align="center"><span class="cattitle">Classement des Equipes {CHAMPIONNAT_DU}</span></p>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" align="center">
						<tr>
						<td class="rowpic" align="center" height="20" width="25%">
						        <p align="center"><span class="gen">Place</span></td>
						<td class="rowpic" align="center" height="20" width="30%">
						        <p align="center"><span class="gen">Equipe</span></td>
						<td class="rowpic" align="center" height="20" width="25%">
						        <p align="center"><span class="gen">Points</span></td>
						<td class="rowpic" align="center" height="20" width="20%">
						        <p align="center"><span class="gen">Victoires</span></td>
						</tr>
						<!-- BEGIN SCORE_GROUP_LIST -->
						<tr>
							<td class="row1" align="center" height="15" class="gensmall">
								<p align="center"><span class="gensmall">{SCORE_GROUP_LIST.PLACE}</span></p>
							</td>
							<td class="row1" align="center" height="15" class="gensmall">
								<p align="center">
									<span class="gensmall">
										<a href='groupcp.php?g={SCORE_GROUP_LIST.CLAN_NUM}' title='voir les membres de {SCORE_GROUP_LIST.CLAN}'{SCORE_GROUP_LIST.STYLE}>
											{SCORE_GROUP_LIST.CLAN}
										</a>
										<a href="JAVASCRIPT:popup('stat_equipe_graph.php?id_equipe={SCORE_GROUP_LIST.CLAN_NUM}{PARAMETRES}', 630,430)" title="Voir la répartition">
											<img src='./templates/loupe.gif' alt='loupe' title="Voir la répartition" border=0>
										</a>
									</span>
								</p>
							</td>
							<td class="row2" align="center" height="15" class="gensmall">
								<p align="center"><span class="gensmall">{SCORE_GROUP_LIST.NB_POINTS}</span></p>
							</td>
							<td class="row2" align="center" height="15" class="gensmall">
								<p align="center"><span class="gensmall">{SCORE_GROUP_LIST.NB_VIC}</span></p>
							</td>
						</tr>
						<!-- END SCORE_GROUP_LIST -->
						</table>
				</td>
			</tr>
		</table>
		</td>  
	</tr>
</table>
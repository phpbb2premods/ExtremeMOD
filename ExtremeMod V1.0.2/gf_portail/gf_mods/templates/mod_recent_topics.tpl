<!-- BEGIN scrolling_row -->
		  <table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<{PORTAL_CLASS_BALISE} class="{PORTAL_CLASS_TITLE}" height="25"><span class="genmed"><b>{L_RECENT_TOPICS}</b></span></{PORTAL_CLASS_BALISE}>
		   </tr>
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
			<marquee id="recent_topics" behavior="scroll" direction="{SCROLL_WAY}" height="{SCROLL_HEIGHT}" scrolldelay="{SCROLL_DELAY}" scrollamount="{SCROLL_STEP}">
			<!-- BEGIN recent_topic_row -->
			&raquo; <a href="{scrolling_row.recent_topic_row.U_TITLE}" onMouseOver="document.all.recent_topics.stop()" onMouseOut="document.all.recent_topics.start()">{scrolling_row.recent_topic_row.L_TITLE}</a><br />
			{BY} <a href="{scrolling_row.recent_topic_row.U_POSTER}" onMouseOver="document.all.recent_topics.stop()" onMouseOut="document.all.recent_topics.start()">{scrolling_row.recent_topic_row.S_POSTER}</a> {ON} {scrolling_row.recent_topic_row.S_POSTTIME}<br /><br />
			<!-- END recent_topic_row -->
			</marquee>
			</span></td>
		   </tr>
		  </table>
<!-- END scrolling_row -->		  
<!-- BEGIN classical_row -->
		  <table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="catHead" height="25"><span class="genmed"><b>{L_RECENT_TOPICS}</b></span></td>
		   </tr>
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
			<!-- BEGIN recent_topic_row -->
			&raquo; <a href="{classical_row.recent_topic_row.U_TITLE}">{classical_row.recent_topic_row.L_TITLE}</a><br />
			{BY} <a href="{classical_row.recent_topic_row.U_POSTER}">{classical_row.recent_topic_row.S_POSTER}</a> {ON} {classical_row.recent_topic_row.S_POSTTIME}<br /><br />
			<!-- END recent_topic_row -->
			</span></td>
		   </tr>
		  </table>
<!-- END classical_row -->
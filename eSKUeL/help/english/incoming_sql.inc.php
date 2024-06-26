<?php
$help = '<FONT size=+0><B>Dump insertion</B></FONT>
	<BR><BR>With this feature, you\'ll be able to restore datas with your previous backups.
	<BR>I can choose between few possibilities :
	<BR><BR>
	<B>1 - Insertion from your FTP :</B>
	<BR>You can store your backup files in the <B>incoming</B> directory which is in the eskuel\'s one. Those files must be ended by "<B>.sql</B>" extension.
	<BR>This method is really efficient if your host does not allow php uploads.
	<BR><BR>
	<B>2 - Insertion from a CSV file :</B>
	<BR>If you can upload from your browser and <B>if you have selected a table</B>, you will be able to complete a table with a CSV file (Comma Separated Values).
	<BR>You can :
	<BR>- Replace the records of the current table with your CSV datas
	<BR>- Choose the separated values (comma by default)
	<BR>- Choose the surrounded value
	<BR>- Change the special character
	<BR>- Specify by which character lines are ended
	<BR>- Specify the names of the columns you want to update (Separate them with <B>commas</B>)
	<BR><BR>
	<B>3 - Insertion from a SQL file :</B>
	<BR>You can rebuild your <B>MySQL</B> tables with thise method. Select the sql file on your hard drive and eskuel will upload and insert it in the current database.
	<BR><font color="#FF0000">You can do all those operation only if you host allow the file upload</font>.
	';
?>
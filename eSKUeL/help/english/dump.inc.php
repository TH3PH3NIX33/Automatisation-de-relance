<?php
$help = '<FONT size=+0><B>Backup a table</B></FONT>
	<BR><BR>
	You can save/backup one or more tables
	<BR>First, choose which backup you need :
	<BR>- SQL backup
	<BR>- CSV backup
	<BR><BR>
	The SQL backup allow you to keep the <B>structure and/or the datas</B> of your table.
	<BR>
	You can also add to your backup, a "<B>DROP TABLE</B>" command which allow you to restore your table even if there is already a table called as the one you\'ve saved.
	<BR>You can also ask complete insertions.
	<BR>You can too specify an SQL query fro saving only the records you want.
	<BR>You could split your backup in more small backups (like zip archives) if it is too big. Just choose the number of query per splitted backup !
	<BR><BR>
	The CSV backup allow you to use your datas in <B>Microsoft Excel</B>
	<BR>Choose the separated value (semicolon by default) and the end line character (\n).
	<BR><BR>
	Finally, choose to <B>display</B> the backup in your browser or to <B>download</B> the file.';
?>
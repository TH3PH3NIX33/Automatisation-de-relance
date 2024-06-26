<?php
$help = '<FONT size=+0><B>Change the type of a table</B></FONT>
	<BR><BR>
	Allow you to change the type of the current table.
	<BR>The available types depends on you server settings :
	<BR>
	<B>1 - BDB (Berkeley_DB)</B>
	<BR>Berkeley DB gave MySQL a managing transactions system : It is crash resistant and allow the COMMIT and ROLLBACK commands.
	<BR><BR>
	<B>2 - HEAP</B>
	<BR>HEAP tables uses hash indexes and are memory residents.
	They are very fast, but if MySQL crash, all your datas will be losts. HEAP are very efficients temporary tables. Internal MySQL tables uses HEAP tables with a 100% dynamic hash.
	<BR><BR>
	<B>3 - ISAM</B>
	<BR>If you want, you can use this obsolete format. It will disapear soon, because MyISAM is a best database format. ISAM uses a B-tree index.
	<BR><BR>
	<B>4 - InnoDB</B>
	<BR>InnoDB gives to MySQL a commit and rollback tables managing system. It offers a backup feature in case of crashes.
	<BR><BR>
	<B>5 - MERGE (MRG_MyISAM)</B>
	<BR>A MERGE table is a collection of MyISAM tables used as one table. You can only use the SELECT, DELETE, and UPDATE commands with this collection. 
	<BR><BR>
	<B>6 - MyISAM</B>
	<BR>MyISAM is THE table format of MySQL Version 3.23. It is based on ISAM code and offer a lot of useful functionnalities.';
	
?>
<?php
$help = '<FONT size=+0><B>Tabellentyp &auml;ndern</B></FONT>
	<BR>I need some help here, please. Is that somewhat correct?<BR>
	&Auml;ndert den Tabellentyp der aktuellen Tabelle
	<BR>Die verf&uuml;gbaren Typen sind von ihrem MySQL-Server abh&auml;ngig :
	<BR>
	<B>1 - BDB (Berkeley_DB)</B>
	<BR>Mit Berkeley DB  verf&uuml;gt MySQL &uuml;ber ein steuerbares(???) Transaktionssystem : Es ist Crash resitent und erlaubt das COMMIT und ROLLBACK Kommando.
	<BR><BR>
	<B>2 - HEAP</B>
	<BR>HEAP Tabellen benutzen Hashindizes und sind speicherresident.
	Sie sind sehr schnell. Wenn MySQL crasht, sind all ihre Daten verloren. HEAP Tabellen eignen sich als effiziente temporäre Tabellen. Interne MySQL Tabellen sind als HEAP Tabellen, mit einem 100% dynamischem Hash, angelegt.
	<BR><BR>
	<B>3 - ISAM</B>
	<BR>Wenn sie wollen, k&ouml;nnen sie dieses veraltete Format w&auml;hlen. Es wird aber bald nicht mehr unterst&uuml;zt werden, weil MyISAM weit &uuml;berlegen ist. ISAM benutzt einen  B-tree Index.
	<BR><BR>
	<B>4 - InnoDB</B>
	<BR>Das InnoDB Tabellenformat gibt MySQL ein weiteres System mit Commit- und Rollback-Mechanismen. Es hat ein Backup-Feature f&uuml;r den Fall eines Absturzes.
	<BR><BR>
	<B>5 - MERGE (MRG_MyISAM)</B>
	<BR>Eine MERGE Tabelle is eine Sammlung von MyISAM Tabelle, die als eine Tabelle benutzt werden. Sie k&ouml;nnen nur die Befehle SELECT, DELETE, und UPDATE verwenden. 
	<BR><BR>
	<B>6 - MyISAM</B>
	<BR>MyISAM ist DAS Tabellenformat der MySQL Version 3.23. Es basiert auf ISAM Code und bietet eine Menge an sehr n&uuml;tzlichen Funktionen.';
	
?>
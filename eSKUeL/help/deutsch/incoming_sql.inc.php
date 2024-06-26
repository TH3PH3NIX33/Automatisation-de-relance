<?php
$help = '<FONT size=+0><B>Dump einf&uuml;gen</B></FONT>
	<BR><BR>Hier k&ouml;nnen sie Daten wieder herstellen, die sie vorher mit einem Dump als Backup erstellt haben.
	<BR>Dabei haben sie folgende M&ouml;glichkeiten :
	<BR><BR>
	<B>1 - Einf&uuml;gen mit Hilfe von FTP-Upload :</B>
	<BR>Sie k&ouml;nnen ihre Backupdatei im <B>incoming</B> Verzeichnis ablegen. Diese Dateien m&uuml;ssen die Dateiendung "<B>.sql</B>" haben.
	<BR>Diese Methode ist sehr hilfreich, wenn ihr Provider keine PHP-Uploads erlaubt.
	<BR><BR>
	<B>2 - Einf&uuml;gen aus einer CSV-Datei :</B>
	<BR>Wenn sie Dateiuploads mit dem Browser durchf&uuml;hren k&ouml;nnen und eine Tabelle ausgew&auml;hlt haben, k&ouml;nnen sie Werte aus einer CSV-Datei einf&uuml;gen.
	<BR>Dabei k&ouml;nnen sie :
	<BR>- Die Daten der Tabelle durch die Werte der CSV-Datei ersetzen lassen
	<BR>- -das Trennzeichen einstellens
	<BR>- -das Feldtrennzeichen einstellen
	<BR>- -das Spezial-Zeichen (Maskierung) einstellen
	<BR>- -einstellen mit welchem Zeichen die Zeile endet
	<BR>- -festlegen, welche Felder sie importieren wollen (trennen sie die Feldnamen mit <B>Kommata</B>)
	<BR><BR>
	<B>3 - Einf&uuml;gen aus einer SQL-Datei :</B>
	<BR>Mit dieser Methode k&ouml;nnen sie ihre <B>MySQL</B> Tabellen komplett wieder herstellen (inkl. Struktur). Suchen Sie die entsprechende SQL-Datei auf ihrer Festplatte und <b>eskuel</b> l&auml;dt diese und wird diese in der aktuellen Datenbank ausf&uuml;hren.
	<BR><font color="#FF0000">Wiederum nur m&ouml;glich, wenn ihr Provider Uploads mit dem Browser erlaubt.</font>.
	';
?>
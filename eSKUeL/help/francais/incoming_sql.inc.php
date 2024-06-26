<?php
$help = '<FONT size=+0><B>Insertion dump</B></FONT>
	<BR><BR>Sur cette page, vous pouvez restaurer vos données sauvegardées précédemment.
	<BR>Vous avez plusieurs possibilités :
	<BR><BR>
	<B>1 - Insertion depuis le FTP :</B>
	<BR>Vous pouvez déposer vos fichiers de sauvegarde dans le répertoire <B>incoming</B> situé dans le répertoire
	où vous avez installé eskuel. Les fichiers stockés à cet emplacement doivent être terminés par "<B>.sql</B>" pour être
	pris en compte.
	<BR>A noter que cette méthode peut être plus pratique lorsque votre hébergeur vous interdit l\'upload de fichier.
	<BR><BR>
	<B>2 - Insertion depuis une fichier CSV :</B>
	<BR>Si vous pouvez uploader des fichiers via votre navigateur <B>et que vous avez sélectionné une table</B>, vous avez alors
	la possibilité de compléter une table avec un fichier CSV (Champs Séparés par des Virgules).
	<BR>Plusieurs options s\'offrent à vous :
	<BR>- Remplacer les données de la table en cours avec les données de votre fichier CSV
	<BR>- Spécifier le séparateur de champs, c\'est à dire le caractère qui délimite chaque champ (par défaut, le point-virgule)
	<BR>- Spécifier le caractère qui entoure les champs
	<BR>- Indiquer le caractère qui enlève (déspécialise) les caractères spéciaux
	<BR>- Spécifier le(s) caractère(s) qui termine(nt) chaque ligne de votre fichier CSV
	<BR>- Spécifier les nom des colonnes que vous souhaitez mettre à jour, en les séparant par des <B>virgules</B>
	<BR><BR>
	<B>3 - Insertion depuis un fichier SQL :</B>
	<BR>Vous pouvez reconstituer une table avec vos sauvegardes <B>MySQL</B> avec cette methode. Sélectionner juste le fichier sur votre disque dur, 
	et eskuel se chargera de l\'uploader et de l\'insérer dans la base en cours. 
	<BR><font color="#FF0000">Attention, vous ne pourrez effectuer cette opération que si
	votre hébergeur autorise l\'upload de fichier</font>.
	';
?>
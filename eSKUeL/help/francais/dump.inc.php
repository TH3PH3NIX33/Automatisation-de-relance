<?php
$help = '<FONT size=+0><B>Sauvegarder une table</B></FONT>
	<BR><BR>
	Ici, vous pouvez sauvegarder votre (ou vos) table(s).
	<BR>Choisissez d\'abord le type de sauvegarde que vous souhaitez effectuer :
	<BR>- Sauvegarde SQL
	<BR>- Sauvegarde CSV
	<BR><BR>
	La sauvegarde SQL vous permet de sauvegarder vos données de votre table afin de la restaurer
	plus tard. Vous pouvez effectuer différents types de sauvegarde : la <B>structure seule</B> qui 
	sauvegardera uniquement l\'architecture de votre table,
	<B>structure + données</B> qui sauvegardera la structure mais aussi toutes les données de votre 
	table et enfin les <B>données seules</B>.
	<BR>
	Optionnellement, vous pouvez demander de rajouter une ligne "<B>DROP TABLE</B>" qui vous permettra
	de restaurer votre table même si une table de ce nom existe déjà.
	<BR>Vous pouvez également demander d\'avoir des insertions complètes.
	<BR>De plus, vous pouvez spécifier une requête SQL pour récupérer uniquement les enregistrements
	qui vous intéressent.
	<BR>Si vos sauvegardes sont trop <B>importantes</B>, vous pouvez décider de découper votre sauvegarde
	en plusieurs petites sauvegardes (façon archive ZIP). Taper uniquement le nombre de requête par 
	petites sauvegarde, et le tour est joué !
	<BR><BR>
	La sauvegarde CSV vous permet essentiellement de récupérer vos données dans un format exploitable
	par <B>Microsoft Excel</B>.
	<BR>Spécifiez le caractère qui séparera les champs (par défaut, le point-virgule), ainsi que le 
	caractère qui marquera la fin d\'une ligne (le \n).
	<BR><BR>
	Enfin, choisissez si vous voulez <B>copier-coller</B> le résultat ou si votre navigateur vous propose de 
	le <B>sauvegarder</B>.';
?>
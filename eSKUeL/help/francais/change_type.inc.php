<?php
$help = '<FONT size=+0><B>Changer le type d\'une table</B></FONT>
	<BR><BR>
	Vous permet de changer le type de la table en cours.
	<BR>Les différents type présentés varient en fonction de la configuration de votre serveur.
	<BR>Les différents types sont :
	<BR>
	<B>1 - BDB (Berkeley_DB)</B>
	<BR>Berkeley DB a fourni à MySQL un système de gestion des transactions : il résiste aux crash et autorise les 
	commandes COMMIT et ROLLBACK avec les transactions. 
	<BR><BR>
	<B>2 - HEAP</B>
	<BR>Les tables HEAP utilisent des index sous forme de tables de hashage, et sont stockées en mémoire. 
	Cela les rend très rapides, mais si MySQL crashe, vous perdrez toutes les données. Les tables HEAP sont très pratiques pour les tables 
	temporaires. Les tables internes à MySQL utilisent des tables HEAP avec un hashage dynamique à 100%.
	<BR><BR>
	<B>3 - ISAM</B>
	<BR>Vous pouvez toujours utiliser le format de table obsolète ISAM. Il disparaitra prochainement car MyISAM est une bien meilleure implémentation. ISAM utilise un index B-tree.
	<BR><BR>
	<B>4 - InnoDB</B>
	<BR>InnoDB fournit à MySQL une gestion de table avec des commit, rollback, et des possibilités de récupération
	an cas de crash. 
	<BR><BR>
	<B>5 - MERGE (MRG_MyISAM)</B>
	<BR>Une table MERGE est une collection de tables MyISAM identiques, qui sont utilisées comme une seule table. Vous ne pouvez alors utiliser que des commandes SELECT, DELETE, et UPDATE sur ces ensembles de tables. 
	<BR><BR>
	<B>6 - MyISAM</B>
	<BR>MyISAM est le type de table par défaut de MySQL Version 3.23. Il est basé sur le code ISAM et propose de nombreuses fonctionnalités pratiques.';
	
?>
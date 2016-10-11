<!DOCTYPE>
<!--
on selectionne le mois qui nous interesse pour la formule choisie
un coworker ne peut souscrire qu'a une seule fornule pour un mois donne

1. Tester si la formule n'est pas déjà dans la table du coworker -> pas besoin, voir plus bas la justification
2. On teste le mois donne : est-ce-que le coworker a deja souscrit une formule de ce mois ? -> pas besoin, voir plus bas la justification
	- oui -> on rejette la demande
	- non -> on part en 3.
3. Est-il superieur au mois actuel ?
	- oui, on souscrit
	- non, on rejette la demande

-->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Souscription</title>
</head>
<body>
	<?php
	
	$vLogin = $_GET['login'];
	$vEspace = $_POST['espace'];
	$vFormule = $_POST['formule']; // utiliser like pour la recherche
	$vMois = $_POST['mois'];
	$vAnnee = $_POST['annee'];

// Pas besoin de tester si le coworker a deja souscrit la formule --> voir table Souscription : PRIMARY KEY(mois,annee,coworker)
// En effet, s'il l'a deja fait, sa demande ecrasera l'ancienne ou bien sera rejetee, ce qui dans tous les cas ne change rien a notre plan.
// Il ne reste donc qu'a tester la validite vis a vis de la date.

// On recupere le mois et l'annee actuelle
	date_default_timezone_set('Europe/Paris');
	$month = date('m', time());
	$year = date('y', time());
	
	$vDateCoworkerSql = "SELECT mois AS moisStr, MoisToInt(mois) AS moisInt 
		FROM Mois 
		; ";

// Il faudrait mettre Occupe a jour : on va dire que cette table est mise a jour pour chaque debut de mois

	?>
</body>
</html>
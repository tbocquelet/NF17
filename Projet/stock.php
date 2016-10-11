<!DOCTYPE>
<!--
Affichage des formules pour un espace donne.
Afficher les formules ou il reste des places.

nombre de total de places dans un espace = nbBureaux + SUM(Salle.nbPlaces)
-->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Souscription</title>
</head>
<body>
	<?php
		$vEspace = $_POST['espace'];
		$vLogin = $_GET['login'];
		
		include("connect.php");
		$vConn = fConnect();

// Afficher les formules proposees pour le mois correspondant
// Choisir une annee et un mois > mois actuel
// Afficher les formules actives pour cette periode
// Afficher les formules non deja souscrites par le coworker

// "SELECT mois AS moisStr, MoisToInt(mois) AS moisInt 
// FROM Mois 
// WHERE annee = $annee AND MoisToInt(mois) <= EXTRACT(MONTH FROM NOW()) AND espace = ".$_GET['espace']." ORDER BY MoisToInt(mois) DESC"

		$viewSql1 = "CREATE OR REPLACE VIEW vSalleIndiv
				AS
				SELECT * FROM Salle WHERE type='indiv';";

		$viewSql2 = "CREATE OR REPLACE VIEW vSalleCollec 
				AS 
				SELECT * FROM Salle WHERE type='collec';";

		$viewSql3 = "CREATE OR REPLACE VIEW vFormuleIllimite
				AS 
				SELECT * FROM Formule WHERE type='I';";

		$viewSql4 = "CREATE OR REPLACE VIEW vFormuleIllimiteBureau
				AS 
				SELECT * FROM Formule WHERE type='IBI';";

		$viewSql5 = "CREATE OR REPLACE VIEW vFormuleLimite
				AS 
				SELECT * FROM Formule WHERE type='L';";

// On instancie les vues
		$viewQuery1 = pg_query($vConn, $viewSql1);
		$viewQuery2 = pg_query($vConn, $viewSql2);
		$viewQuery3 = pg_query($vConn, $viewSql3);
		$viewQuery4 = pg_query($vConn, $viewSql4);
		$viewQuery5 = pg_query($vConn, $viewSql5);

// Utiliser la vue vSalleCollec
// probleme d'affichage lorsque la somme vaut 0


// Formules limitees - affiche les formules limitees avec le nombre de place total pour cet espace

		$vFormLSql = "SELECT F.nom, F.tarif, F.limite, F.type, SUM(S.nbPlaces) AS places
			FROM vFormuleLimite F, Salle S
			WHERE F.espace = '$vEspace' AND S.espace = '$vEspace' AND F.active = 't'
			GROUP BY F.nom, F.tarif, F.limite, F.type ;";

		$vFormLQuery = pg_query($vConn, $vFormLSql);

// Formules illimitees - affiche les formules illimitees avec le nombre de place total pour cet espace

		$vFormISql = "SELECT F.nom, F.tarif, F.limite, F.type, SUM(S.nbPlaces) AS places
			FROM vFormuleIllimite F, Salle S
			WHERE F.espace = '$vEspace' AND S.espace = '$vEspace' AND F.active = 't'
			GROUP BY F.nom, F.tarif, F.limite, F.type ;";

		$vFormIQuery = pg_query($vConn, $vFormISql);

// Formules illimitees avec bureaux - affiche les formules illimitees avec bureaux avec le nombre de place total pour cet espace

		$vFormIBISql = "SELECT F.nom, F.tarif, F.limite, F.type, SUM(S.nbPlaces) AS placessalles, E.nbBureaux AS placesbureaux
			FROM vFormuleIllimiteBureau F, Salle S, Espace E
			WHERE F.espace = '$vEspace' AND S.espace = '$vEspace' AND F.active = 't' AND E.ID = '$vEspace'
			GROUP BY F.nom, F.tarif, F.limite, F.type, E.nbBureaux ;";

		$vFormIBIQuery = pg_query($vConn, $vFormIBISql);


		echo "<p><strong>Formule(s) proposee(s) par l'espace $vEspace :</strong></p><br>";

///////////////////////
// Fornules limitess //
///////////////////////

		echo "Formules limitees<br>";

		if(pg_num_rows($vFormLQuery)!=0)
		{
			
			echo "<form action=\"souscription2.php?espace=$vEspace\" method=\"POST\">";
				echo "<p>";
					echo "<select name=\"formule\">";
						while($vResult1=pg_fetch_array($vFormLQuery))
						{ 
							echo "<option value=$vResult1[nom]>Nom : $vResult1[nom] | Tarif : $vResult1[tarif] | Limite : $vResult1[limite] | Type : $vResult1[type] | NbPlaces : $vResult1[places] </option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"submit\" value=\"Choisir cette formule\" />";
				echo "</p>";
			echo "</form>";

		}
		else { echo "L'espace ne propose aucune formule limitees pour le moment<br>"; }

/////////////////////////
// Formules illimitees //
/////////////////////////

		echo "Formules illimitees<br>";

		if(pg_num_rows($vFormIQuery)!=0)
		{
			
			echo "<form action=\"souscription2.php?espace=$vEspace\" method=\"POST\">";
				echo "<p>";
					echo "<select name=\"formule\">";
						while($vResult2=pg_fetch_array($vFormIQuery))
						{ 
							echo "<option value=$vResult2[nom]>Nom : $vResult2[nom] | Tarif : $vResult2[tarif] | Limite : $vResult2[limite] | Type : $vResult2[type] | NbPlaces : $vResult2[places] </option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"submit\" value=\"Choisir cette formule\" />";
				echo "</p>";
			echo "</form>";

		}
		else { echo "L'espace ne propose aucune formule illimitees pour le moment<br>"; }

///////////////////////////////////////
// Formules illimitees avec bureaux  //
///////////////////////////////////////

		echo "Formules illimitees avec bureaux<br>";

		if(pg_num_rows($vFormIBIQuery)!=0)
		{
			
			echo "<form action=\"souscription2.php?espace=$vEspace\" method=\"POST\">";
				echo "<p>";
					echo "<select name=\"formule\">";
						while($vResult3=pg_fetch_array($vFormIBIQuery))
						{ 
							echo "<option value=$vResult3[nom]>Nom : $vResult3[nom] | Tarif : $vResult3[tarif] | Limite : $vResult3[limite] | Type : $vResult3[type] | NbPlacesSalles : $vResult3[placessalles] | NbPlacesBureaux : $vResult3[placesbureaux] </option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"submit\" value=\"Choisir cette formule\" />";
				echo "</p>";
			echo "</form>";

		}
		else { echo "L'espace ne propose aucune formule illimitees avec bureaux pour le moment<br>"; }

	?>
</body>
</html>
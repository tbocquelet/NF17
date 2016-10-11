<?php 
$titre = "Souscription";
include "top.php"; ?>
	<?php
		$vEspace = $_POST['espace'];
		$vLogin = $_GET['login'];
		
		include("connect.php");
		$vConn = fConnect();

		$viewSql = "CREATE OR REPLACE VIEW vSalleCollec 
				AS 
				SELECT * FROM Salle WHERE type='collec';";


		$viewSql1 = "CREATE OR REPLACE VIEW vSalleIndiv
				AS
				SELECT * FROM Salle WHERE type='indiv';";

// On instancie les vues
		$viewQuery = pg_query($vConn, $viewSql);
		$viewQuery1 = pg_query($vConn, $viewSql1);	

// On recupere les informations relatives aux formules ainsi que le nombre de places dans les salles et bureaux pour chaque formule
// NbPlacesSalles -= nbBureaux puisque le type n'est pas differencie dans la requete, on compte les bureaux dans 'placessalles'
// la requete plante si la somme ne se fait pas (ex : il n'y a pas de salle dans un espace)
// pour palier a cela, il suffit d'enlever le nombre de bureaux au nombre de places dans une salle
// puisque chaque bureau vaut pour 1 place

		$vFormSql = "SELECT F.nom, F.tarif, F.limite, F.type, SUM(S.nbPlaces) AS placessalles, E.nbBureaux AS placesbureaux, M.mois, M.annee
			FROM Formule F, Salle S, Espace E, Mois M
			WHERE F.espace = '$vEspace' AND S.espace = '$vEspace' AND F.active = 't' AND E.ID = '$vEspace' AND M.formule=F.nom AND M.espace='$vEspace' AND M.active='t'
			GROUP BY F.nom, F.tarif, F.limite, F.type, E.nbBureaux, M.mois, M.annee ;";

		$vFormQuery = pg_query($vConn, $vFormSql);

		if(pg_num_rows($vFormQuery)!=0)
		{
			echo "<p><strong>Formule(s) proposee(s) par l'espace $vEspace :</strong></p><br>";

				echo "Type L : formule limitee <br>";
				echo "Type I : formule illimitee <br>";
				echo "Type IBI : formule illimitee  avec bureaux<br>";
				echo "<br>Par convention, les formules dont la limite est 0 sont valables sur tout le mois.<br>";
				
// Liste deroulante
				echo "<form action=\"souscription2.php?login=$vLogin\" method=\"POST\">"; 
					echo "<p>";
						echo "<select name=\"formule\">";

			while($vResult=pg_fetch_array($vFormQuery))
			{
				// On veut connaitre le nombre de formules deja souscrites et quel type de salle l'etait avec
				$vSouscriptionSallesSql = "SELECT Count(*) AS salles
					FROM Souscription S, vSalleCollec T
					WHERE S.espace = T.espace AND S.espace = '$vEspace' AND S.mois = '$vResult[mois]' AND S.annee = '$vResult[annee]' ";

				$vSouscriptionBureauxSql = "SELECT Count(*) AS bureaux
					FROM Souscription S, vSalleIndiv T
					WHERE S.espace = T.espace AND S.espace = '$vEspace' AND S.mois = '$vResult[mois]' AND S.annee = '$vResult[annee]' ";	

				$vSallesQuery = pg_query($vConn, $vSouscriptionSallesSql);
				$vBureauxQuery = pg_query($vConn, $vSouscriptionBureauxSql);

				$vSalles = pg_fetch_array($vSallesQuery);
				$vBureaux = pg_fetch_array($vBureauxQuery);

				$vPlacesSalles = $vResult[placessalles] - $vResult[placesbureaux] - $vSalles[salles];
				$vPlacesBureaux = $vResult[placesbureaux] - $vBureaux[bureaux];

				if ($vPlacesBureaux > 0 or $vPlacesSalles > 0){
					echo "<option value='$vResult[nom]'> Nom : $vResult[nom] | Tarif : $vResult[tarif] euros | Limite : $vResult[limite] jours | Type : $vResult[type] | Nombre de places salle restantes : $vPlacesSalles | Nombre de bureaux restants : $vPlacesBureaux | Mois : $vResult[mois] | Annee : $vResult[annee]</option>";			
				}
				else {echo "<option value=0> La formule \"$vResult[nom]\" est complete.</option>";}
				
			}
					echo"<input type=\"hidden\" name=\"espace\" value=$vEspace />"; 
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"submit\" value=\"Choisir cette formule\" />";
				echo "</p>";
			echo "</form>";
		}
		else { echo "L'espace ne propose aucune formule pour le moment<br>"; }

		pg_close($vConn);
	?>
</div>
</body>
</html>
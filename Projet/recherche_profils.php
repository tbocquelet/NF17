<?php 
$titre = "Recherche de profils";
include "top.php"; ?>

	<?php
		include("connect.php");
		$vConn = fConnect();
		$vRecherche=$_POST['recherche'];

		if(isset($vRecherche)){

			if ($vRecherche == 'espace') {
				echo "Recherche par espace. \nVoici les espaces actuellement occupes. \n"; 

				$vSql = "SELECT O.espace, E.adresse_rue, E.adresse_ville, E.adresse_codePostal 
				FROM Espace E, Occupe O 
				WHERE O.espace=E.ID AND E.active='t'
				GROUP BY O.espace, E.adresse_rue, E.adresse_ville, E.adresse_codePostal;";
				$vQuery = pg_query($vConn, $vSql);

				if(pg_num_rows($vQuery)!=0)
				{	
					echo "Selectionnez un espace : <br>";
					// Formulaire liste deroulante : on selectionne un espace
					echo "<form action=\"recherche_profils2.php\" method=\"POST\">";
					echo "<p>";
						echo "<select name=\"espace\">";
							while($vResult=pg_fetch_array($vQuery))
							{
								echo "<option value=$vResult[espace]> Espace : $vResult[espace] | Adresse : $vResult[adresse_rue] $vResult[adresse_ville] $vResult[adresse_codePostal] </option>";
							}
						echo "</select>";
						echo "<br><br>";
						echo "<input type=\"submit\" value=\"Envoyer\" />";
					echo "</p>";
					echo "</form>";
				}
				else { echo "Aucun espace ne correspond."; }

			}
			if ($vRecherche == 'situation') {
				echo "Recherche par situation professionnelle.";				

				$vSql = "SELECT C.situationProfessionnelle AS sit 
				FROM Coworker C, Occupe O 
				WHERE O.coworker=C.mail 
				GROUP BY C.situationProfessionnelle;";
				$vQuery = pg_query($vConn, $vSql);

				if(pg_num_rows($vQuery)!=0)
				{	
					echo "Selectionnez une situation : <br>";
					// Formulaire liste deroulante : on selectionne un espace
					echo "<form action=\"recherche_profils2.php\" method=\"POST\">";
					echo "<p>";
						echo "<select name=\"situation\">";
							while($vResult=pg_fetch_array($vQuery))
							{
								echo "<option value='$vResult[sit]'> Situation : $vResult[sit] </option>";
							}
						echo "</select>";
						echo "<br><br>";
						echo "<input type=\"submit\" value=\"Envoyer\" />";
					echo "</p>";
					echo "</form>";
				}
				else { echo "Aucune situation n'a ete trouvee."; }

			}
			if ($vRecherche == 'domaine') {
				echo "Recherche par domaine d'activite.";

				$vSql = "SELECT A.domaine 
				FROM Activite A, Occupe O 
				WHERE O.coworker=A.coworker
				GROUP BY A.domaine;";
				$vQuery = pg_query($vConn, $vSql);

				if(pg_num_rows($vQuery)!=0)
				{	
					echo "Selectionnez un domaine : <br>";
					// Formulaire liste deroulante : on selectionne un espace
					echo "<form action=\"recherche_profils2.php\" method=\"POST\">";
					echo "<p>";
						echo "<select name=\"domaine\">";
							while($vResult=pg_fetch_array($vQuery))
							{
								echo "<option value='$vResult[domaine]'> Domaine : $vResult[domaine] </option>";
							}
						echo "</select>";
						echo "<br><br>";
						echo "<input type=\"submit\" value=\"Envoyer\" />";
					echo "</p>";
					echo "</form>";
				}
				else { echo "Aucun domaine n'a ete trouve."; }	
			}

		}
		else echo "Erreur avec le formulaire.";

		pg_close($vConn);
	?>
</div>
</body>
</html>

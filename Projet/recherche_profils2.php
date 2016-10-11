<?php 
$titre = "Recherche de profils";
include "top.php"; ?>

	<?php
		include("connect.php");
		$vConn = fConnect();
		$vRechercheEsp=$_POST['espace'];
		$vRechercheSit=$_POST['situation'];
		$vRechercheDom=$_POST['domaine'];

		if(isset($vRechercheEsp)){

			echo "Resultat de la recherche pour l'espace \"$vRechercheEsp\""; 
// on affiche notre profil dedans
			$vSql = "SELECT C.prenom, C.nom, C.mail, C.age, C.situationProfessionnelle AS sit, C.presentation, A.domaine  
			FROM Coworker C, Occupe O, Activite A 
			WHERE O.coworker = C.mail AND A.coworker = C.mail AND O.espace='$vRechercheEsp';";
			$vQuery = pg_query($vConn, $vSql);

			if(pg_num_rows($vQuery)!=0)
			{
				
				?>

				<table border=\"1\">
	  			<tr>
					<th> Prenom </th>
					<th> Nom </th>
					<th> Mail </th>
					<th> Age </th>
					<th> Situation Professionnelle </th>
					<th> Presentation </th>
					<th> Domaine </th>
				</tr>

				<?php

				while($vResult=pg_fetch_array($vQuery))
				{
					echo "<tr>";
					echo "<td>$vResult[prenom]</td>";
					echo "<td>$vResult[nom]</td>";
					echo "<td>$vResult[mail]</td>";
					echo "<td>$vResult[age]</td>";
					echo "<td>$vResult[sit]</td>";
					echo "<td>$vResult[presentation]</td>";
					echo "<td>$vResult[domaine]</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else echo "Aucun espace a afficher.";
		}

		if (isset($vRechercheSit)) {
			echo "Resultat de la recherche pour la situation \"$vRechercheSit\"";				

			$vSql = "SELECT C.prenom, C.nom, C.mail, C.age, C.presentation, A.domaine 
			FROM Coworker C, Occupe O, Activite A 
			WHERE O.coworker=C.mail AND A.coworker=C.mail AND C.situationProfessionnelle = '$vRechercheSit'
			GROUP BY C.prenom, C.nom, C.mail, C.age, C.presentation, A.domaine  ;";
			$vQuery = pg_query($vConn, $vSql);

			if(pg_num_rows($vQuery)!=0)
			{
				?>
				<table border=\"1\">
	  			<tr>
					<th> Prenom </th>
					<th> Nom </th>
					<th> Mail </th>
					<th> Age </th>
					<th> Presentation </th>
					<th> Domaine </th>
				</tr>

				<?php

				while($vResult=pg_fetch_array($vQuery))
				{
					echo "<tr>";
					echo "<td>$vResult[prenom]</td>";
					echo "<td>$vResult[nom]</td>";
					echo "<td>$vResult[mail]</td>";
					echo "<td>$vResult[age]</td>";
					echo "<td>$vResult[presentation]</td>";
					echo "<td>$vResult[domaine]</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else echo "Aucune situation a afficher.";
		}

		if (isset($vRechercheDom)) {
			echo "Resultat de la recherche pour le domaine \"$vRechercheDom\"";

			$vSql = "SELECT C.prenom, C.nom, C.mail, C.age, C.presentation,  C.situationProfessionnelle AS sit 
			FROM Coworker C, Occupe O, Activite A 
			WHERE O.coworker=C.mail AND C.mail=A.coworker AND A.domaine = '$vRechercheDom'
			GROUP BY C.prenom, C.nom, C.mail, C.age, C.presentation,  C.situationProfessionnelle;";
			$vQuery = pg_query($vConn, $vSql);

			if(pg_num_rows($vQuery)!=0)
			{
				?>
				<table border=\"1\">
	  			<tr>
					<th> Prenom </th>
					<th> Nom </th>
					<th> Mail </th>
					<th> Age </th>
					<th> Presentation </th>
					<th> Situation Professionnelle </th>
				</tr>

				<?php

				while($vResult=pg_fetch_array($vQuery))
				{
					echo "<tr>";
					echo "<td>$vResult[prenom]</td>";
					echo "<td>$vResult[nom]</td>";
					echo "<td>$vResult[mail]</td>";
					echo "<td>$vResult[age]</td>";
					echo "<td>$vResult[presentation]</td>";
					echo "<td>$vResult[sit]</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else echo "Aucun domaine a afficher.";
		}

		pg_close($vConn);
	?>
</div>
</body>
</html>

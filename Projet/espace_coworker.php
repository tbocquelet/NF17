<?php 
$titre = "Espace coworker";
include "top.php"; ?>
		
	<?php
	if(isset($_POST['login']))
	{
		// connexion a la base de donnees
		include("connect.php");
		$vConn = fConnect();
		$vLogin=$_POST['login'];
	
//////////////////
// PRESENTATION //
//////////////////

		$vSql = "SELECT C.nom, C.prenom, C.age, C.presentation, C.situationProfessionnelle AS sit, A.domaine 
		FROM Coworker C, Activite A 
		WHERE C.mail='$vLogin' AND A.coworker='$vLogin';";
		$vQuery = pg_query($vConn, $vSql);

		if(pg_num_rows($vQuery)!=0)
		{
			$vResult = pg_fetch_array($vQuery);			
			$vPrenom = $vResult['prenom'];
			$vNom = $vResult['nom'];
			$vPres = $vResult['presentation'];
			$vSit = $vResult['sit'];
			$vDomaine = $vResult['domaine'];

			echo "<p><strong> Profil de $vPrenom $vNom </strong></p>";
			echo "Présentation : $vPres";
			echo "<br>";
			echo "Situation professionnelle : $vSit";
			echo "<br>";
			echo "Domaine d'activite : $vDomaine";
			echo "<br> <br>";
			// Lien pour modifier le profil associe a $vLogin
			echo '<a href="modifier_profil.php?login='.$vLogin.'">Modifier son profil</a><br>';
		}
		else { echo "Aucun utilisateur ne correspond.";}

/////////////////////////////
// FORMULE(S) SOUSCRITE(S) //
/////////////////////////////

		echo "<p><strong>Liste des formules souscrites pour chaque espace</strong></p>";

		// afficher la formule, son type, son nom, son tarif, le mois de validite, la salle occupe, l'espace, formule ACTIVE
		$vSql = "SELECT S.espace, S.formule, S.mois, S.annee, F.tarif, F.type AS typeform, T.numero, T.nbPlaces AS nbplaces, T.type AS typesalle 
		FROM  Souscription S, Occupe O, Formule F, Salle T
		WHERE S.coworker='$vLogin' AND S.espace=F.espace AND S.formule=F.nom AND F.active='true' AND T.numero=O.salle AND O.espace=S.espace AND O.coworker=S.coworker
		ORDER BY S.espace;";
		
		$vQuery = pg_query($vConn, $vSql);
	
		if(pg_num_rows($vQuery)!=0)
		{
			?>

			<table border="1">
  			<tr>
				<th> Espace(ID) </th>
				<th> Formule </th>
				<th> Type de formule </th>
				<th> Tarif </th>
				<th> N Salle </th>
				<th> Type de salle </th>
				<th> Nombre de places </th>
				<th> Mois </th>
				<th> Année </th>
			</tr>

			<?php

			while($vResult=pg_fetch_array($vQuery))
			{
				echo "<tr>";
				echo "<td>$vResult[espace]</td>";
				echo "<td>$vResult[formule]</td>";
				echo "<td>$vResult[typeform]</td>";
				echo "<td>$vResult[tarif]</td>";
				echo "<td>$vResult[numero]</td>";
				echo "<td>$vResult[typesalle]</td>";
				echo "<td>$vResult[nbplaces]</td>";
				echo "<td>$vResult[mois]</td>";
				echo "<td>$vResult[annee]</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		else { echo "Aucune formule n'a ete souscrite pour le moment."; }

///////////////////
// INFOS ESPACES //
///////////////////

		echo "<p><strong>Informations relatives à chaque espace</strong></p>";
		// est-ce-qu'il faut que je joins les tables information et conference ?
		$vSql = "SELECT O.espace, I.nom, I.date, I.contenu 
		FROM Information I,Publie P, Occupe O 
		WHERE O.coworker='$vLogin' AND O.espace=P.espace AND P.info=I.nom
		ORDER BY O.espace;";
		$vQuery = pg_query($vConn, $vSql);

		if(pg_num_rows($vQuery)!=0)
		{
			?>

			<table border="1">
  			<tr>
				<th> Espace </th>
				<th> Nom </th>
				<th> Contenu </th>
				<th> Date </th>
			</tr>

			<?php

			while($vResult=pg_fetch_array($vQuery))
			{
				echo "<tr>";
				echo "<td>$vResult[espace]</td>";
				echo "<td>$vResult[nom]</td>";
				echo "<td>$vResult[contenu]</td>";
				echo "<td>$vResult[date]</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		else { echo "Aucune information n'a ete remplie pour le moment."; }

////////////////////////////////////
// SOUSCRIPTION NOUVELLE FORMULE  //
////////////////////////////////////

		echo "<p><strong>Souscrire une nouvelle formule</strong></p>";

// On affiche tous les espaces, occupes ou non par le coworker - en effet, il a le droit de souscrire une formule d'un autre espace

		$vSql = "SELECT ID AS espace, adresse_rue, adresse_ville, adresse_codePostal FROM Espace WHERE active='t' ORDER BY ID;";
		$vQuery = pg_query($vConn, $vSql);

		if(pg_num_rows($vQuery)!=0)
		{	
			echo "Selectionnez un espace : <br>";
			// Formulaire liste deroulante : on selectionne un espace
			echo "<form action=\"souscription.php?login=$vLogin\" method=\"POST\">";
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

///////////////////////
// RECHERCHE PROFILS //
///////////////////////

	?>

	<p><strong>Consulter d'autres profils</strong></p>
	
Sélectionnez un mode de recherche (uniquement sur un espace occupé): 
	
	<!-- Formulaire bouton de radios -->
	<form action="recherche_profils.php" method="POST">
		<p>
		    <input type="radio" name="recherche" value="espace" id="espace" checked="checked" /> <label for="espace">Recherche par espace</label>
		    <br> 
			<input type="radio" name="recherche" value="situation" id="situation" /> <label for="situation">Recherche par situation professionnelle</label>
			<br>
			<input type="radio" name="recherche" value="domaine" id="domaine" /> <label for="domaine">Recherche par domaine d'activité</label>
		    <br>
		    <br>
		    <input type="submit" value="Valider" />
		</p>
	</form>

	<?php
	pg_close($vConn);

	}
	else { echo "Merci de rentrer un login."; }


	

	?>
</div>
</body>
</html>





















<?php 
$titre = "Modifier son profil";
include "top.php"; ?>
	<?php
		$vLogin = $_GET['login'];
		$vSit = $_POST['sit'];
		$vPresentation = $_POST['presentation'];
		$vDomaine = $_POST['domaine'];
	
	if(!empty($vSit) or !empty($vPresentation) or !empty($vDomaine))
	{
		include("connect.php");
		$vConn = fConnect();

		if(!empty($vSit)){
			$vSql = "UPDATE Coworker 
			SET situationProfessionnelle='$vSit' 
			WHERE mail='$vLogin';";
			$vQuery = pg_query($vConn, $vSql);

			echo "<p>Situation professionnelle mise a jour ! <br> </p>";
		}
		
		if(!empty($vPresentation)){
			$vSql =  "UPDATE Coworker 
			SET presentation='$vPresentation'
			WHERE mail='$vLogin';";
			$vQuery = pg_query($vConn, $vSql);

			echo "<p>Presentation mise a jour ! <br> </p>";
		}

		if(!empty($vDomaine)){
			// on supprime le tuple pour mettre a jour la cle etrangere
			$vSuppression = "DELETE FROM Activite WHERE coworker='$vLogin';";
			$vTest = "SELECT * FROM Domaine WHERE nom='$vDomaine';";
			$vInsert =  "INSERT INTO Domaine(nom) VALUES ('$vDomaine');";
			$vUpdate = "INSERT INTO Activite(domaine, coworker) VALUES ('$vDomaine','$vLogin');";
			
			$vQuery_test = pg_query($vConn, $vTest);
			// si le nouveau domaine n'est pas present dans la table Domaine, on l'ajoute
			// sinon on ne fait rien d'autre sur cette table
			if (!$vResult=pg_fetch_array($vQuery_test)) { $vQuery2 = pg_query($vConn, $vInsert); }
			$vQuery1 = pg_query($vConn, $vSuppression);
			$vQuery3 = pg_query($vConn, $vUpdate);

			echo "<p>Domaine d'activite mis a jour ! <br> </p>";
		}	
		echo "<p> <br> Retour a l'accueil :  <a href='index.php'>Retour à l'accueil</a></p>";
		pg_close($vConn);
	}
	else 
	{
		echo "Merci de remplir le formulaire.";
		echo '<a href="modifier_profil.php?login='.$vLogin.'"><br>Modifier son profil</a><br>';
	}
	
	?>

</div>
</body>
</html>
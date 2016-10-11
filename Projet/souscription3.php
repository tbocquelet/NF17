<?php 
$titre = "Souscription";
include "top.php"; ?>
<!--
on selectionne l'annee qui nous interesse pour la formule choisie
un coworker ne peut souscrire qu'a une seule fornule pour un mois donne

-->
	<?php
	
	$vLogin = $_GET['login'];
	$vFormule = $_POST['formule']; 
	$vEspace = $_POST['espace'];
	$vMois = $_POST['mois'];

	include("connect.php");
	$vConn = fConnect();

	$vSql = "SELECT annee FROM Mois WHERE formule = '$vFormule' AND espace = '$vEspace' AND active= 't' AND mois = '$vMois';";
	$vQuery = pg_query($vConn, $vSql);

	if(pg_num_rows($vQuery)!=0)
	{
		echo "<p><strong>Date(s) proposee(s) par l'espace $vEspace pour la formule $vFormule du mois de $vMois :</strong></p><br>";

		echo "<form action=\"souscription4.php?login=$vLogin\" method=\"POST\">"; 
			echo "<p>";
				echo "<select name=\"annee\">";

				while($vResult=pg_fetch_array($vQuery))
				{
					echo "<option value=$vResult[annee]> Annee : $vResult[annee]</option>";			
				}
					echo"<input type=\"hidden\" name=\"espace\" value=$vEspace />"; 
					echo"<input type=\"hidden\" name=\"formule\" value='$vFormule' />"; 
					echo"<input type=\"hidden\" name=\"mois\" value='$vMois' />"; 
			echo "</select> <br> <br>";
			echo "<input type=\"submit\" value=\"Choisir cette annee\" />";
			echo "</p>";
		echo "</form>";
	}
	else { echo "Aucune formule ne correspond.<br>"; }

	pg_close($vConn);
	?>
</div>
</body>
</html>
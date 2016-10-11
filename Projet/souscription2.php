<?php 
$titre = "Souscription";
include "top.php"; ?>
<!--
on selectionne le mois qui nous interesse pour la formule choisie
un coworker ne peut souscrire qu'a une seule fornule pour un mois donne

-->
	<?php
	
	$vLogin = $_GET['login'];
	$vFormule = $_POST['formule']; 
	$vEspace = $_POST['espace'];
	
	include("connect.php");
	$vConn = fConnect();

	$vSql = "SELECT mois, annee FROM Mois WHERE formule = '$vFormule' AND espace = '$vEspace' AND active= 't';";
	$vQuery = pg_query($vConn, $vSql);

	if(pg_num_rows($vQuery)!=0)
	{
		echo "<p><strong>Date(s) proposee(s) par l'espace $vEspace pour la formule \"$vFormule\" :</strong></p><br>";

		echo "<form action=\"souscription3.php?login=$vLogin\" method=\"POST\">"; 
			echo "<p>";
				echo "<select name=\"mois\">";

				while($vResult=pg_fetch_array($vQuery))
				{
					echo "<option value='$vResult[mois]'> Mois : $vResult[mois] | Annee : $vResult[annee]</option>";			
				}
					echo"<input type=\"hidden\" name=\"espace\" value=$vEspace />"; 
					echo"<input type=\"hidden\" name=\"formule\" value='$vFormule' />"; 
			echo "</select> <br> <br>";
			echo "<input type=\"submit\" value=\"Choisir ce mois\" />";
			echo "</p>";
		echo "</form>";
	}
	else { echo "Il ne reste aucune place disponible pour cette formule.<br>"; }

	pg_close($vConn);
	?>
</div>
</body>
</html>
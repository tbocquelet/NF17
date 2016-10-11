<?php 
$titre = "Gestion salles";
include "top.php"; ?>
	<?php
	if(isset($_GET['espace']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vEspace = $_GET['espace'];
		$vSql_salles = "SELECT * FROM Salle WHERE espace = $vEspace";
		$vQuery_salles = pg_query($vConn, $vSql_salles);
		
		
		if(pg_num_rows($vQuery_salles)!=0)
		{	
			$vResult = pg_fetch_array($vQuery_salles);
			echo '<h2>'.'Liste des salles de l\'espace n°'.$vEspace.'</h2>';
			do{			
				echo '<li>' .'Numero de la salle : ' .$vResult['numero'] .'<br>'.'Type de salle : '.$vResult['type'].'<br>'.'Nombre de places : '.$vResult['nbPlaces'];				
				echo '<br>';
				echo '<a href="modifier_salle.php?espace='.$vEspace.'&salle='.$vResult['numero'].'">Modifier cette salle</a> - ';
				echo '<a href="supprimer_salle.php?espace='.$vEspace.'&salle='.$vResult['numero'].'">Supprimer cette salle</a> - ';
				echo '</li><hr>';
			}while ($vResult = pg_fetch_array($vQuery_salles));
			
			echo '<a href="ajouter_salle.php?espace='.$vEspace.'">Cliquez ici pour ajouter une salle à cet espace</a> - ';
		}		

	}
	else
	{
		echo "<p>Espace inexistant !.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>
</div>
</body>
</html>

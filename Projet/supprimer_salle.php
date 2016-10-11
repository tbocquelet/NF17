<?php 
$titre = "Supprimer salle";
include "top.php"; ?>
	<?php
	if($_POST['sure'] == 'oui'){
		include("connect.php");
		$vConn = fConnect();
		$vSalle = $_GET['salle'];
		$vEspace = $_GET['espace'];
		$vSql_delete = "DELETE FROM Salle WHERE numero= $vSalle AND espace = $vEspace";		
		$vQuery_update = pg_query($vConn, $vSql_delete);
		$vSql_espace = "UPDATE espace SET nbSalles = nbSalles - 1 WHERE ID = $vEspace";
		$vQuery_espace = pg_query($vConn, $vSql_espace);
		echo "<p>La salle a bien été supprimée.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}

	elseif(isset($_GET['espace']) && isset($_GET['salle']))
	{
		echo '<h2>'.'Suppression de la salle n°'.$vSalle.'</h2>';
		$vSalle = $_GET['salle'];
		$vEspace = $_GET['espace'];
		?>
		<form action="supprimer_salle.php?espace=<?php echo $vEspace.'&salle='.$vSalle; ?>" method="post">
		<p>
		Etes-vous sûr de vouloir supprimer cette salle ?
		<input type="radio" name="sure" value="oui"/> <label for="oui">Oui</label>
		<input type="radio" name="sure" value="non" checked="checked" /> <label for="non">Non</label>
		<input type="submit"/>
		</p>
		</form>
		<?php
	}		
	else
	{
		echo "<p>Salle inexistante.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>

</div>
</body>
</html>

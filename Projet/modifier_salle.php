<?php 
$titre = "Modification salle";
include "top.php"; ?>
	<?php
	if($_POST['sure'] == 'oui'){
		include("connect.php");
		$vConn = fConnect();
		$vEspace = $_GET['espace'];
		$vSalle_new = $_POST['numero'];
		$vSalle_old = $_GET['salle'];
		$vNbPlaces = $_POST['nbPlaces'];
		$vType = $_POST['type'];
		$vSql_update = "UPDATE Salle SET nbPlaces = $vNbPlaces, type ='$vType', numero = $vSalle_new  WHERE espace = $vEspace AND numero= $vSalle_old";		
		$vQuery_update = pg_query($vConn, $vSql_update);
		echo "<p>Changements effectués.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}

	elseif(isset($_GET['espace']) && isset($_GET['salle']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vEspace = $_GET['espace'];
		$vSalle = $_GET['salle'];
		$vSql_salle = "SELECT * FROM Salle WHERE espace = $vEspace AND numero = $vSalle";
		$vQuery_salle = pg_query($vConn, $vSql_salle);
		
		
		if(pg_num_rows($vQuery_salle)!=0)
		{	
			$vResult = pg_fetch_array($vQuery_salle);
			echo '<h2>'.'Modification de la salle n°'.$vSalle.'</h2>';
			?>
			<form action="modifier_salle.php?espace=<?php echo $vEspace.'&salle='.$vSalle; ?>" method="post">
			<p>
			Numero de la Salle : <input type="text" name="numero" value = "<?php echo $vResult['numero']; ?>"/><br><br>
			Type : <select name="type"><option value="indiv">individuelle</option><option value="collec">collective</option></select><br><br>
			Nombre de places : <input type="text" name="nbPlaces" value = "<?php echo $vResult['nbPlaces']; ?>"/><br><br>
			Etes-vous sûr de vouloir effectuer ces modification ?
			<input type="radio" name="sure" value="oui"/> <label for="oui">Oui</label>
			<input type="radio" name="sure" value="non" checked="checked" /> <label for="non">Non</label>
			<input type="submit"/>
			</p>
			</form>
			<?php
		}		

	}
	else
	{
		echo "<p>Identifiant incorrect.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>
</div>
</body>
</html>

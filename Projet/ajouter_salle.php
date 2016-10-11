<?php 
$titre = "Modification salle";
include "top.php"; ?>
	<?php
	if($_POST['sure'] == 'oui'){
		include("connect.php");
		$vConn = fConnect();
		$vEspace = $_GET['espace'];
		$vSalle = $_POST['numero'];
		$vType = $_POST['type'];
		$vNbPlaces = $_POST['nbPlaces'];
		$vSql_add = "INSERT INTO Salle(numero, type, espace, nbPlaces) VALUES($vSalle, '$vType', $vEspace,$vNbPlaces)";
		$vSql_espace = "UPDATE espace SET nbSalles = nbSalles + 1 WHERE ID = $vEspace";		
		$vQuery_add = pg_query($vConn, $vSql_add);
		$vQuery_espace = pg_query($vConn, $vSql_espace);
		echo "<p>La salle a bien été ajoutée.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}
	elseif(isset($_GET['espace']))
	{
		$vEspace = $_GET['espace'];

		echo '<h2>'.'Ajout d\'une salle'.'</h2>';
		?>
		<form action="ajouter_salle.php?espace=<?php echo $vEspace; ?>" method="post">
		<p>
		Numero de la Salle : <input type="text" name="numero"/><br><br>
		Type : <select name="type"><option value="indiv">individuelle</option><option value="collec">collective</option></select><br><br>
		Nombre de places : <input type="text" name="nbPlaces"/><br><br>
		Etes-vous sûr de vouloir ajouter une nouvelle salle ?
		<input type="radio" name="sure" value="oui"/> <label for="oui">Oui</label>
		<input type="radio" name="sure" value="non" checked="checked" /> <label for="non">Non</label>
		<input type="submit"/>
		</p>
		</form>
		<?php
			

	}
	else
	{
		echo "<p>Espace inexistant.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>
</div>
</body>
</html>

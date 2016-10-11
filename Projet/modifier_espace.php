<?php 
$titre = "Espace Manager";
include "top.php"; ?>
	<?php
	if($_POST['sure'] == 'oui'){
		include("connect.php");
		$vConn = fConnect();
		$vRue = $_POST['rue'];
		$vVille = $_POST['ville'];
		$vPays = $_POST['pays'];
		$vCode = $_POST['code'];
		$vDescription = $_POST['description'];
		$vNbbureaux = $_POST['nbbureaux'];
		$vSurface = $_POST['surface'];
		$vNbsalles = $_POST['nbsalles'];
		$vEspace = $_GET['espace'];
		$vSql_update = "UPDATE Espace SET adresse_rue = $vRue,adresse_codepostal =$vCode,adresse_ville =$vVille,adresse_pays ='$vPays',surface =$vSurface, nbbureaux =$vNbbureaux, nbsalles =$vNbsalles,description ='$vDescription',  WHERE ID = $vEspace";		
		$vQuery_update = pg_query($vConn, $vSql_update);
		echo "<p>Changements effectués.<br><a href='index.php'>Retour à l'accueil</a></p>";
	}

	elseif(isset($_GET['espace']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vEspace = $_GET['espace'];
		$vSql_espace = "SELECT * FROM Espace e WHERE e.ID = $vEspace";
		$vQuery_espace = pg_query($vConn, $vSql_espace);
		
		
		if(pg_num_rows($vQuery_espace)!=0)
		{	
			$vResult = pg_fetch_array($vQuery_espace);
			echo '<h2>'.'Modification de l\'espace n°'.$vEspace.'</h2>';
			?>
			<form action="modifier_espace.php?espace=<?php echo $vEspace; ?>" method="post">
			<p>
			Rue : <input type="text" name="rue" value = "<?php echo $vResult['adresse_rue']; ?>"/><br><br>
			Code Postal : <input type="text" name="code" value = "<?php echo $vResult['adresse_codepostal']; ?>"/><br><br>
			Ville : <input type="text" name="ville" value = "<?php echo $vResult['adresse_ville']; ?>"/><br><br>
			Pays : <input type="text" name="pays" value = "<?php echo $vResult['adresse_pays']; ?>" /><br><br>
			Surface : <input type="text" name="surface" value = "<?php echo $vResult['surface']; ?>"/><br><br>
			Nombre de bureaux individuels : <input type="text" name="nbbureaux" value = "<?php echo $vResult['nbbureaux']; ?>"/><br><br>
			Nombre de salles collectives : <input type="text" name="nbsalles" value = "<?php echo $vResult['nbsalles']; ?>"/><br><br>
                        Description :<br> 
                        <textarea name="description" rows="10" cols="50" value = "<?php echo $vResult['description']; ?>"> </textarea><br><br>
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

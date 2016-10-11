<?php 
$titre = "Créer un espace";
include "top.php"; ?>
	<?php
	if(isset($_GET['login'], $_POST['rue'], $_POST['code'], $_POST['ville'], $_POST['pays'], $_POST['surface'], $_POST['nbbureaux'], $_POST['nbsalles'], $_POST['description']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vSql_espace = "INSERT INTO Espace VALUES(DEFAULT, '".$_POST['rue']."', ".$_POST['code'].", '".$_POST['ville']."', '".$_POST['pays']."', ".$_POST['surface'].", ".$_POST['nbbureaux'].", ".$_POST['nbsalles'].", '".$_POST['description']."', '".$_GET['login']."', TRUE)";
		if($vQuery_espace = pg_query($vConn, $vSql_espace))
                {
                    echo "<p>Insertion réussie.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
                }
                else
                {
                    echo "<p>Erreur à l'insertion.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
                }

                pg_close($vConn);
	}
	else
	{
		echo "<p>Erreur, il manque des informations.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>
</div>
</body>
</html>

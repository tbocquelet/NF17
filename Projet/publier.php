<?php 
$titre = "Créer un espace";
include "top.php"; ?>
	<?php
	if(isset($_GET['login'], $_POST['titre'], $_POST['contenu'], $_POST['espace']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vSql_espace = "INSERT INTO Information VALUES('".$_POST['titre']."', now(), '".$_POST['contenu']."', NULL, '".$_GET['login']."')";
		if($vQuery_espace = pg_query($vConn, $vSql_espace))
                {
                    foreach ($_POST['espace'] as $espace)
                    {
                        $vSql_espace = "INSERT INTO Publie VALUES('".$_POST['titre']."',$espace)";
                        $vQuery_espace = pg_query($vConn, $vSql_espace);
                    }
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

<?php 
$titre = "Archiver un espace";
include "top.php"; ?>
	<?php
	if(isset($_GET['espace']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vSql_espace = "UPDATE Espace SET active = FALSE WHERE ID = ".$_GET['espace'];
		if($vQuery_espace = pg_query($vConn, $vSql_espace))
                {
                    $vSql_espace = "UPDATE Formule SET active = FALSE WHERE espace = ".$_GET['espace'];
                    if($vQuery_espace = pg_query($vConn, $vSql_espace))
                    {
                        $vSql_espace = "UPDATE Mois SET active = FALSE WHERE espace = ".$_GET['espace'];
                        if($vQuery_espace = pg_query($vConn, $vSql_espace))
                        {
                            echo "<p>Archivage réussi.<br>
                                <a href='index.php'>Retour à l'accueil</a></p>";
                        }
                        else
                        {
                            echo "<p>Erreur à la mise à jour de Mois.<br>
                                <a href='index.php'>Retour à l'accueil</a></p>";
                        }
                    }
                    else
                    {
                        echo "<p>Erreur à la mise à jour de Formule.<br>
                            <a href='index.php'>Retour à l'accueil</a></p>";
                    }
                }
                else
                {
                    echo "<p>Erreur à la mise à jour de Espace.<br>
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

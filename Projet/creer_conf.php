<?php
    include("connect.php");
    $vConn = fConnect();
	if(isset($_GET['espace'],$_GET['login'],$_POST['titre'],$_POST['date'],$_POST['resume']))
	{
            $formValide = true;
            if($_POST['intervCoworker'] != "default")
            {
		$vSql = "INSERT INTO Conference VALUES(DEFAULT,'".$_POST['titre']."','".$_POST['date']."','".$_POST['resume']."',NULL,'".$_POST['intervCoworker']."',NULL,".$_GET['espace'].",'".$_GET['login']."')";
		
            }
            elseif($_POST['intervManager'] != "default")
            {
		$vSql = "INSERT INTO Conference VALUES(DEFAULT,'".$_POST['titre']."','".$_POST['date']."','".$_POST['resume']."',NULL,NULL,'".$_POST['intervManager']."',".$_GET['espace'].",'".$_GET['login']."')";
		
            }
            elseif($_POST['intervExterieur'] != "default")
            {
		$vSql = "INSERT INTO Conference VALUES(DEFAULT,'".$_POST['titre']."','".$_POST['date']."','".$_POST['resume']."','".$_POST['intervExterieur']."',NULL,NULL,".$_GET['espace'].",'".$_GET['login']."')";
		
            }
            elseif(!empty($_POST['mail']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age']))
            {
                $vSql = "INSERT INTO Conference VALUES(DEFAULT,'".$_POST['titre']."','".$_POST['date']."','".$_POST['resume']."','".$_POST['mail']."',NULL,NULL,".$_GET['espace'].",'".$_GET['login']."');";
		$vSqlExt = "INSERT INTO IntervenantExt VALUES('".$_POST['mail']."','".$_POST['nom']."','".$_POST['prenom']."',".$_POST['age'].")";
            }
            if(isset($vSqlExt))
            {
                $vQuery = pg_query($vConn, $vSqlExt);
            }
            if($vQuery = pg_query($vConn, $vSql))
            {
                $vSqlid = "SELECT MAX(id) AS id FROM Conference";
                $vQuery = pg_query($vConn, $vSqlid);
                $vResult = pg_fetch_array($vQuery);
                $confID = $vResult['id'];
                if(isset($_POST['espace']))
                {
                    foreach ($_POST['espace'] as $espace)
                    {
                        $vSql = "INSERT INTO Ouverte VALUES($confID,$espace)";
                        $vQuery = pg_query($vConn, $vSql);
                    }
                }
                $message="<p>Création réussie.<br>
                    <a href='index.php'>Retour à l'accueil</a></p>";
            }
            else
            {
                $message="<p>Erreur.<br>
                    <a href='index.php'>Retour à l'accueil</a></p>";
            }


	}
?>
<?php 
$titre = "Créer une conférence";
include "top.php"; ?>
	<?php 
        if($formValide)
        {
            echo $message;
        }
	elseif(isset($_GET['espace'],$_GET['login']))
	{
	?>
        <h3>Créer une conférence</h3>
        <form action="creer_conf.php?espace=<?php echo $_GET['espace']; ?>&login=<?php echo $_GET['login']; ?>" method="post">
            <p>
            Titre : <input type="text" name="titre"/><br><br>
            Date (AAAA-MM-JJ hh:mm:ss) : <input type="text" name="date"/><br><br>
            Résumé :<br>
            <textarea name="resume" rows="10" cols="50"> </textarea><br><br>
            <?php
            echo "Sélectionnez l'intervenant : <br>";
            echo "Intervenant coworker : <select name='intervCoworker'>";
            echo '<option value="default" selected>Aucun</option>';
            $vSql = "SELECT * FROM Coworker";
            $vQuery = pg_query($vConn, $vSql);
            while ($vResult = pg_fetch_array($vQuery))
            {
                echo '<option value="'.$vResult['mail'].'">'.$vResult['prenom'].' '.$vResult['nom'].'</option>';
            }
            echo "</select><br><br>";

            echo "OU : Intervenant manager : <select name='intervManager'>";
            echo '<option value="default" selected>Aucun</option>';
            $vSql = "SELECT * FROM Manager";
            $vQuery = pg_query($vConn, $vSql);
            while ($vResult = pg_fetch_array($vQuery))
            {
                echo '<option value="'.$vResult['mail'].'">'.$vResult['prenom'].' '.$vResult['nom'].'</option>';
            }
            echo "</select><br><br>";

            echo "OU : Intervenant extérieur : <select name='intervExterieur'>";
            echo '<option value="default" selected>Aucun</option>';
            $vSql = "SELECT * FROM IntervenantExt";
            $vQuery = pg_query($vConn, $vSql);
            while ($vResult = pg_fetch_array($vQuery))
            {
                echo '<option value="'.$vResult['mail'].'">'.$vResult['prenom'].' '.$vResult['nom'].'</option>';
            }
            echo "</select><br>";
            echo "OU : Entrer un nouvel intervenant extérieur :<br>";
            ?>
            Mail : <input type="text" name="mail"/><br><br>
            Nom : <input type="text" name="nom"/><br><br>
            Prénom : <input type="text" name="prenom"/><br><br>
            Age : <input type="text" name="age"/><br><br>
            
            <?php
            echo 'Sélectionner des espaces supplémentaires auxquels ouvrir la conférence : <br>';
            $vSql = "SELECT * FROM Espace WHERE ID <> ".$_GET['espace'];
            $vQuery = pg_query($vConn, $vSql);
            while ($vResult = pg_fetch_array($vQuery))
            {
                echo '<input type="checkbox" name="espace[]" value="'.$vResult['id'].'"> '.$vResult['adresse_rue'] .', '.$vResult['adresse_codepostal'].' '.$vResult['adresse_ville'].' - '. $vResult['adresse_pays'].'<br>';
            }
            ?>
            <br>
            <input type="submit"/>
            </p>
            </form>
        <?php
	}
	else
	{
		echo "<p>Erreur, il manque des informations.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
	}
        pg_close($vConn);
	?>
</div>
</body>
</html>

<?php 
$titre = "Espace Manager";
include "top.php"; ?>
	<?php
	//$_POST['login'] = "brad.pitt@gmail.com";
	if(isset($_POST['login']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vLogin = $_POST['login'];
		$vSql_espace = "SELECT * FROM Espace e, Manager m  WHERE e.gerant='$vLogin' AND m.mail='$vLogin' AND e.active = TRUE ORDER BY e.ID";
		$vQuery_espace = pg_query($vConn, $vSql_espace);
		$vSql_formule = "SELECT * FROM Formule F , Espace E, Mois M  WHERE M.formule = F.nom AND M.espace = F.espace AND E.gerant='$vLogin'"
                        . " AND M.active = TRUE AND F.active= TRUE AND F.espace = E.ID AND M.annee = EXTRACT(YEAR FROM NOW())"
                        . " AND MoisToInt(M.mois) = EXTRACT(MONTH FROM NOW())"
                        . " ORDER BY E.ID";
		$vQuery_formule = pg_query($vConn, $vSql_formule);


		if(pg_num_rows($vQuery_espace)!=0)
		{	
			$vResult = pg_fetch_array($vQuery_espace);
			echo '<h2>'.'Espaces de coworking gérés par : '.$vResult['prenom'].' '.$vResult['nom'].'</h2>';
			echo '<h3>Vos espaces actifs</h3>';
			echo '<ol>';
			do{			
				echo '<li>' .'Adresse : ' .$vResult['adresse_rue'] .', '.$vResult['adresse_codepostal'].' '.$vResult['adresse_ville'].' - '. $vResult['adresse_pays'].'<br>'.'Nombre de bureaux : '.$vResult['nbbureaux'].' - '.'Nombre de salles : '.' '.$vResult['nbsalles'].' - Surface : '.$vResult['surface'].' m<sup>2</sup><br>'.'Description : '.$vResult['description'] ;
				if(pg_num_rows($vQuery_formule)!=0)
				{
					echo '<p>Formules proposées actuellement : </p>';
					echo '<ul>';
					while($vFormule = pg_fetch_array($vQuery_formule))
					{
						echo '<li>'.'"'.$vFormule['nom'].'" '.', Type : '.$vFormule['type'].', Tarif : '. $vFormule['tarif'].' €</li>';
					} 
					echo '</ul>';
				}
				echo '<br>';
				echo '<a href="modifier_espace.php?espace='.$vResult['id'].'">Modifier l\'espace</a> - ';
				echo '<a href="gerer_salles.php?espace='.$vResult['id'].'">Gérer les salles</a> - ';
				echo '<a href="gerer_formules.php?espace='.$vResult['id'].'">Gérer les formules</a> - ';
				echo '<a href="archiver_espace.php?espace='.$vResult['id'].'">Archiver l\'espace</a> - ';
				echo '<a href="stats_espace.php?espace='.$vResult['id'].'">Statistiques de l\'espace</a> - ';
				echo '<a href="creer_conf.php?espace='.$vResult['id'].'&login='.$vLogin.'">Créer une conférence</a><br>';
				echo '</li><hr>';
			}while ($vResult = pg_fetch_array($vQuery_espace));
			echo '</ol>';
                        ?>
                        <h3>Publier sur le fil d'actualité</h3>
                        <form action="publier.php?login=<?php echo $vLogin; ?>" method="post">
                                <p>
                                Titre : <input type="text" name="titre"/><br><br>
                                Contenu :<br>
                                <textarea name="contenu" rows="10" cols="50"> </textarea><br><br>
                                Sélectionnez le ou les espaces : <br>
                                <?php
                                    pg_result_seek($vQuery_espace, 0);//on remet le pointeur au début
                                    while ($vResult = pg_fetch_array($vQuery_espace))
                                    {
                                        echo '<input type="checkbox" name="espace[]" value="'.$vResult['id'].'"> '.$vResult['adresse_rue'] .', '.$vResult['adresse_codepostal'].' '.$vResult['adresse_ville'].' - '. $vResult['adresse_pays'].'<br>';
                                    }
                                ?>
                                <input type="submit"/>
                                </p>
                        </form>
                        
                        <?php
		}
		echo '<a href="archives.php?login='.$vLogin.'">Consulter les archives</a><br>';
		?>
		<h3>Créer un nouvel espace</h3>
		<form action="creer_espace.php?login=<?php echo $vLogin; ?>" method="post">
			<p>
			Rue : <input type="text" name="rue"/><br><br>
			Code Postal : <input type="text" name="code"/><br><br>
			Ville : <input type="text" name="ville"/><br><br>
			Pays : <input type="text" name="pays" value="France" /><br><br>
			Surface : <input type="text" name="surface"/><br><br>
			Nombre de bureaux individuels : <input type="text" name="nbbureaux"/><br><br>
			Nombre de salles collectives : <input type="text" name="nbsalles"/><br><br>
                        Description :<br> 
                        <textarea name="description" rows="10" cols="50"> </textarea><br><br>
			<input type="submit"/>
			</p>
		</form>
                
                

		<?php

                pg_close($vConn);
	}
	else
	{
		echo "<p>Identifiant incorrect.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
	}
	?>
                        </div>
</body>
</html>

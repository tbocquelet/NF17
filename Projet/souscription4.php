<?php 
$titre = "Souscription";
include "top.php"; ?>
<!--
on selectionne le mois qui nous interesse pour la formule choisie
un coworker ne peut souscrire qu'a une seule fornule pour un mois donne

1. Tester si la formule n'est pas déjà dans la table du coworker 
2. On teste le mois donne : est-ce-que le coworker a deja souscrit une formule de ce mois ? 
	- oui -> on rejette la demande
	- non -> on part en 3.
3. Est-il superieur au mois actuel ?
	- oui, on souscrit
	- non, on rejette la demande

-->
	<?php
	
	$vLogin = $_GET['login'];
	$vFormule = $_POST['formule']; 
	$vEspace = $_POST['espace'];
	$vMois = $_POST['mois'];
	$vAnnee = $_POST['annee'];

	include("connect.php");
	$vConn = fConnect();
	
	// On teste si la formule a deja ete souscrite par notre coworker
	$vTestSql = "SELECT Count(*) AS test 
		FROM Souscription 
		WHERE mois = '$vMois' AND annee = '$vAnnee' AND formule = '$vFormule' AND coworker = '$vLogin' AND espace = '$vEspace';";
	$vTestQuery = pg_query($vConn, $vTestSql);
	$vResult=pg_fetch_array($vTestQuery);

	echo "<p><strong>Souscription de la formule \"$vFormule\" de l'espace $vEspace pour la periode : $vMois $vAnnee .<br></strong></p>";

	if ($vResult[test]!=0) {
		echo "La requete existe deja.<br>";
	}
	else {
		echo "La formule n'a pas encore ete souscrite. <br>";

		// On teste si le coworker n'a pas deja souscrit une formule pour le mois demande
		$vTestSql2 = "SELECT Count(*) AS test 
			FROM Souscription 
			WHERE mois = '$vMois' AND annee = '$vAnnee' AND coworker = '$vLogin';";
		$vTestQuery2 = pg_query($vConn, $vTestSql2);
		$vResult2=pg_fetch_array($vTestQuery2);

		if($vResult2[test]!=0) {
			echo "Vous avez deja souscrit une formule pour cette periode.<br>";
		}
		else {
			echo "Aucune formule n'a encore ete souscrite pour cette periode. <br>";
			
			// On recupere le mois et l'annee actuelle
			date_default_timezone_set('Europe/Paris');
			$month = date('m', time());
			$year = date('y', time());

			// $vMois est une string, on veut le numero du mois pour le comparer avec le mois actuel retourne par time()
			switch ($vMois) {
			    case "janvier":
			        $mois=1;
			        break;
			    case "fevrier":
			        $mois=2;
			        break;
			    case "mars":
			        $mois=3;
			        break;
		        case "avril":
			        $mois=4;
			        break;
			    case "mai":
			        $mois=5;
			        break;
			    case "juin":
			        $mois=6;
			        break;
			    case "juillet":
			        $mois=7;
			        break;
			    case "aout":
			        $mois=8;
			        break;
			    case "septembre":
			        $mois=9;
			        break;
			    case "octobre":
			        $mois=10;
			        break;
			    case "novembre":
			        $mois=11;
			        break;
			    case "decembre":
			        $mois=12;
			        break;
			}

			// $year contient uniquement les 2 derniers chiffres de l'anne (ex : 2016, $year contient 16)
			$year = 2000+$year;

			if( ($vAnnee > $year) or ($vAnnee==$year and $mois > $month) ) {
				$vUpdateSql = "INSERT INTO Souscription(mois, annee, formule, espace, coworker)
					VALUES ('$vMois',$vAnnee,'$vFormule',$vEspace,'$vLogin');";
				$vUpdateQuery = pg_query($vConn, $vUpdateSql);

				$vUpdateSql2 = "SELECT numero 
				FROM Salle 
				WHERE espace='$vEspace';";
				$vUpdateQuery2 = pg_query($vConn, $vUpdateSql2);
				$vResult3=pg_fetch_array($vUpdateQuery2);

				$vSalle=$vResult3[numero];

				$vUpdateSql3 = "INSERT INTO Occupe(coworker,espace,salle)
				VALUES ('$vLogin','$vEspace','$vSalle');";
				$vUpdateQuery3 = pg_query($vConn, $vUpdateSql3);

				
				echo "Formule souscrite avec succes !<br>";

			}
			else {
				echo "La periode de la formule choisie n'est pas valable. <br> Merci de choisir une formule valable sur un moins superieur au mois actuel.<br>";
			}

		
		}
	}

	pg_close($vConn);
	?>
</div>
</body>
</html>
<?php 
$titre = "Statistiques de l'espace";
include "top.php"; ?>
	<?php
	if(isset($_GET['espace']))
	{
		include("connect.php");
		$vConn = fConnect();
		$vLogin = $_POST['login'];
		$vSql_espace = "SELECT * FROM Espace e, Manager m  WHERE e.ID = ".$_GET['espace']." AND e.active = TRUE AND e.gerant = m.mail";
		$vQuery_espace = pg_query($vConn, $vSql_espace);
		$vSql_salle_indiv = "SELECT * FROM vSalleIndiv  WHERE  espace = ".$_GET['espace'];
		$vQuery_salle_indiv = pg_query($vConn, $vSql_salle_indiv);
                $vSql_salle_collec = "SELECT * FROM vSalleCollec  WHERE espace = ".$_GET['espace'];
		$vQuery_salle_collec = pg_query($vConn, $vSql_salle_collec);

		if(pg_num_rows($vQuery_espace)!=0)
		{	
			$vResult_espace = pg_fetch_array($vQuery_espace);
                        echo "<h1>Espace ".$vResult_espace['adresse_rue'] .', '.$vResult_espace['adresse_codepostal'].' '.$vResult_espace['adresse_ville'].' - '. $vResult_espace['adresse_pays']."</h1>";
			echo "Manager : ".$vResult_espace['prenom']." ".$vResult_espace['nom']."<br>";
                        
                        echo "<h2>Occupation actuelle</h2>";
                        $vSqlCapIndiv = "Select COUNT(*) AS nb FROM vSalleIndiv WHERE espace = ".$_GET['espace'];
                        $vSqlCapCollec = "Select SUM(nbPlaces) AS nb FROM vSalleCollec WHERE espace = ".$_GET['espace'];
                        $vSqlOccupIndiv = "Select COUNT(*) AS nb FROM Occupe O, vSalleIndiv S WHERE O.espace = S.espace AND O.salle = S.numero AND S.espace = ".$_GET['espace'];
                        $vSqlOccupCollec = "Select COUNT(*) AS nb FROM Occupe O, vSalleCollec S WHERE O.espace = S.espace AND O.salle = S.numero AND S.espace = ".$_GET['espace'];
                        $vQuery = pg_query($vConn,$vSqlCapIndiv);
                        $vResult = pg_fetch_array($vQuery);
                        $capIndiv = $vResult['nb'];
                        $vQuery = pg_query($vConn,$vSqlCapCollec);
                        $vResult = pg_fetch_array($vQuery);
                        $capCollec = $vResult['nb'];
                        $vQuery = pg_query($vConn,$vSqlOccupIndiv);
                        $vResult = pg_fetch_array($vQuery);
                        $occupIndiv = $vResult['nb'];
                        $vQuery = pg_query($vConn,$vSqlOccupCollec);
                        $vResult = pg_fetch_array($vQuery);
                        $occupCollec = $vResult['nb'];
                        echo "<p>";
                        echo "Bureaux individuels : ".$occupIndiv."/".$capIndiv." (".($occupIndiv/$capIndiv)*100 ."%)<br>";
                        echo "Salles collectives : ".$occupCollec."/".$capCollec." (".($occupCollec/$capCollec)*100 ."%)";
                        echo "</p>";
                        
                        echo "<h2>Formules souscrites (dont archivées) : ";
                        $vSql_annees = "SELECT DISTINCT(annee) FROM Souscription WHERE espace = ".$_GET['espace']." ORDER BY annee DESC";
                        $vQuery_annees = pg_query($vConn,$vSql_annees);
                        while(($vResult_annees = pg_fetch_array($vQuery_annees)))
                        {
                            $annee = $vResult_annees['annee'];
                            echo "<h3>Année ".$annee." :</h3>";
                            
                            $vSql_mois = "SELECT DISTINCT mois AS moisStr, MoisToInt(mois) AS moisInt FROM Souscription WHERE annee = $annee AND espace = ".$_GET['espace']." ORDER BY MoisToInt(mois) DESC";
                            $vQuery_mois = pg_query($vConn,$vSql_mois);
                            while(($vResult_mois = pg_fetch_array($vQuery_mois)))
                            {
                                $moisStr = $vResult_mois['moisstr'];
                                $moisInt = $vResult_mois['moisint'];
                                echo "<h4>Mois ".$moisStr." :</h4>";
                                //Nombre de formules
                                echo "<p>";
                                $vSql_formI = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleIllimite v, Mois m, Souscription s WHERE s.mois = m.mois AND s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.mois = '$moisStr' AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                                $vQuery_formI = pg_query($vConn,$vSql_formI);
                                $vResult_formI = pg_fetch_array($vQuery_formI);
                                $nbFormI = $vResult_formI['nb'];
                                $chiffreI = $vResult_formI['chiffre'];
                                $vSql_formIBI = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleIllimiteBureau v, Mois m, Souscription s WHERE s.mois = m.mois AND s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.mois = '$moisStr' AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                                $vQuery_formIBI = pg_query($vConn,$vSql_formIBI);
                                $vResult_formIBI = pg_fetch_array($vQuery_formIBI);
                                $nbFormIBI = $vResult_formIBI['nb'];
                                $chiffreIBI = $vResult_formIBI['chiffre'];
                                $vSql_formL = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleLimite v, Mois m, Souscription s WHERE s.mois = m.mois AND s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.mois = '$moisStr' AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                                $vQuery_formL = pg_query($vConn,$vSql_formL);
                                $vResult_formL = pg_fetch_array($vQuery_formL);
                                $nbFormL = $vResult_formL['nb'];
                                $chiffreL = $vResult_formL['chiffre'];
                                $nbFormTotal = $nbFormI + $nbFormIBI + $nbFormL;
                                $chiffreMois = $chiffreI + $chiffreIBI + $chiffreL;
                                echo "$nbFormTotal formule(s) souscrites : $nbFormI illimité, $nbFormIBI illimité avec bureau individuel, $nbFormL limité<br>";
                                echo "Chiffres d'affaire : illimité : $chiffreI €, illimité avec bureau individuel : $chiffreIBI €, limité : $chiffreL €<br>";
                                echo "Chiffre d'affaire du mois : $chiffreMois €";
                                echo "</p>";
                            }
                            
                            echo "<h4><em>Bilan année $annee : </em></h4>";
                            //Nombre de formules
                            echo "<p>";
                            $vSql_formI = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleIllimite v, Mois m, Souscription s WHERE s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                            $vQuery_formI = pg_query($vConn,$vSql_formI);
                            $vResult_formI = pg_fetch_array($vQuery_formI);
                            $nbFormI = $vResult_formI['nb'];
                            $chiffreI = $vResult_formI['chiffre'];
                            $vSql_formIBI = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleIllimiteBureau v, Mois m, Souscription s WHERE s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                            $vQuery_formIBI = pg_query($vConn,$vSql_formIBI);
                            $vResult_formIBI = pg_fetch_array($vQuery_formIBI);
                            $nbFormIBI = $vResult_formIBI['nb'];
                            $chiffreIBI = $vResult_formIBI['chiffre'];
                            $vSql_formL = "SELECT COUNT(S.formule) AS nb, COALESCE(SUM(v.tarif),0) AS chiffre FROM vFormuleLimite v, Mois m, Souscription s WHERE s.annee = m.annee AND s.formule = m.formule AND s.espace = m.espace AND m.annee = $annee AND m.formule = v.nom AND m.espace = v.espace AND v.espace =  ".$_GET['espace'];
                            $vQuery_formL = pg_query($vConn,$vSql_formL);
                            $vResult_formL = pg_fetch_array($vQuery_formL);
                            $nbFormL = $vResult_formL['nb'];
                            $chiffreL = $vResult_formL['chiffre'];
                            $nbFormTotal = $nbFormI + $nbFormIBI + $nbFormL;
                            $chiffreAnnee = $chiffreI + $chiffreIBI + $chiffreL;
                            echo "$nbFormTotal formule(s) proposées : $nbFormI illimité, $nbFormIBI illimité avec bureau individuel, $nbFormL limité<br>";
                            echo "Chiffres d'affaire : illimité : $chiffreI €, illimité avec bureau individuel : $chiffreIBI €, limité : $chiffreL €<br>";
                            echo "Chiffre d'affaire de l'annee : $chiffreAnnee €";
                            echo "</p><hr>";
                        }
                       
		}
		else
                {
                    echo "<p>Espace inconnu ou inactif.<br>
			<a href='index.php'>Retour à l'accueil</a></p>";
                }

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

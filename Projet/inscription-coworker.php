<?php 
$titre = "Inscription Coworker";
include "top.php"; ?>
<h2>Inscription coworker</h2>

<form    method="post">
<label>Adresse e-mail: <input type="text" name="email"/></label><br/>
<label>Nom: <input type="text" name="nom"/></label><br/>
<label>Prenom <input type="text" name="prenom"/></label><br/>
<label>Age: <input type="text" name="age"/></label><br/>
<label>Situation Professionelle: <input type="text" name="sit"/></label><br/>
<label>Domaine d'activité : <input type="text" name="domaine"/></label><br/>
<label>Presenation: <textarea name="presentation" rows="4" cols="20"> </textarea></label><br/>
<P></P>
<input type="submit" value="M'inscrire"/>
<input type="reset" value="Effacer" style="position:relative;left:15"/>
</from>

<?php

//if(isset($_POST['email']))
 $vMail=$_POST['email'];// else $vMail="";
//if(isset($_POST['nom']))
 $vNom=$_POST['nom'];//  else $vNom="";
//if(isset($_POST['prenom']))
$vPrenom=$_POST['prenom'];//else $vPrenom="";
//if(isset($_POST['age']))
  $vAge=$_POST['age'];//else $vAge="";
//if(isset($_POST['presentation']))
  $vPresentation=$_POST['presentation'];//else $vPresentation="";
//if(isset($_POST['sit']))
$vSit=$_POST['sit'];//else $vSit="";

$vDomaine=$_POST['domaine'];

if(empty($vMail) OR empty($vNom) OR empty($vPrenom) OR empty($vAge) OR empty($vPresentation) OR empty($vSit) OR empty($vDomaine))
 {
 echo "<p></p>" ;
 echo "inscription incomplète" ;
         }

else{
        include("connect.php");
        $vConn = fConnect();
        $vSql = "INSERT INTO Coworker(mail,nom,prenom,age,presentation,situationProfessionnelle) VALUES ('$vMail','$vNom','$vPrenom',$vAge,'$vPresentation','$vSit')";
        $vQuery = pg_query($vConn, $vSql);

        $vSql2 = "INSERT INTO Activite(domaine, coworker) VALUES ('$vDomaine','$vMail');";
        $vQuery2 = pg_query($vConn, $vSql2);
        echo "inscription faite" ;
        pg_close($vConn);
		echo "<p></p>";
        echo "inscription bien faite" ;
        echo "<li><a href='index.php'>connexion coworker</a></li>" ;


}

?>


</div>
</body>
</html>
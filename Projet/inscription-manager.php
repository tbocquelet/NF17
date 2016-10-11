<?php 
$titre = "Inscription Manager";
include "top.php"; ?>
<h2>Inscription manager</h2>

<form    method="post">
<label>Adresse e-mail: <input type="text" name="email"/></label><br/>
<label>Nom: <input type="text" name="nom"/></label><br/>
<label>Prenom <input type="text" name="prenom"/></label><br/>
<label>Age: <input type="text" name="age"/></label><br/>
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
  
if(empty($vMail) OR empty($vNom) OR empty($vPrenom) OR empty($vAge))
 {
 echo "<p></p>" ;
 echo "inscription incomplète" ;
         }

else{
        include("connect.php");
        $vConn = fConnect();
        $vSql = "INSERT INTO Manager(mail,nom,prenom,age) VALUES ('$vMail','$vNom','$vPrenom',$vAge)";
        $vQuery = pg_query($vConn, $vSql);
        echo "inscription faite" ;
        pg_close($vConn);
		 echo "<p></p>";
        echo "inscription bien faite" ;
        echo "<li><a href='index.php'>connexion manager</a></li>" ;


}

?>


</div>
</body>
</html>

<?php 
$titre = "Accueil";
include "top.php"; ?>

<h1>Accueil</h1>
<h2>Connexion coworker</h2>

<form action="espace_coworker.php"  method="post">
<p>
    <input type="text" name="login" /><br> <br>
    <input type="submit" value="Valider" />
    <input type="reset" value="Effacer" style="position:relative;left:35" />

</p>
</form>
<a href="inscription-coworker.php">Inscription coworker</a>


<h2>Connexion manager</h2>


<form action="espace_manager.php"   method="post">
<p>
    <input type="text" name="login" /> <br><br>
    <input type="submit" value="Valider" />
    <input type="reset" value="Effacer" style="position:relative;left:35" />

</p>
</form>

<a href="inscription-manager.php">Inscription manager</a>

</div>
</body>

</html>

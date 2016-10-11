<?php 
$titre = "Modifier son profil";
include "top.php"; ?>
	<?php
		$vLogin = $_GET['login'];
	?>
	N'utilisez pas d'apostrophes ou de guillements etc svp
	<form action="modifier_profil2.php?login=<?php echo $vLogin; ?>" method="POST">
		<p>
		    <input type="text" name="sit"  id="sit"/> <label for="sit">Nouvelle situation professionnelle </label>
		    <br>
		    <br>
			<input type="text" name="domaine" id="domaine" /> <label for="domaine">Nouveau domaine d'activite </label>
		    <br>
		    <br>
		   <!-- <input type="text" name="presentation" id="presentation" /> <label for="presentation">Nouvelle presentation </label> -->
		    <br>
		    <textarea name="presentation" rows="8" cols="45" id="presentation"></textarea><label for="presentation"> Nouvelle presentation </label>
		    <br> 
		    <br>
		    <input type="submit" value="Valider les modifications" />
		</p>
	</form>
	
        </div>      
</body>
</html>

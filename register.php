<?php
include('mysql.php');
?>
<!DOCTYPE html>
<html> 
<head>
	<style>
	a,a:visited,a:hover {
		color:#271549!important;
		text-decoration:none;
	}
</style>
<meta charset="UTF-8">
</head> 
<body>
	<center>
		<form method="post">
			<input type="text" name="mail" placeholder="Adresse Email" required><br><br>
			<input type="password" name="password" placeholder="Mot de passe" required><br><br>
			<button type="submit" class="btn btn-warning">Inscription</button>
		</form>
		<?php 

		function endsWith($haystack, $needle)
		{
			$length = strlen($needle);

			return $length === 0 || 
			(substr($haystack, -$length) === $needle);
		} 
		if (isset($_POST["mail"])) {
			$mail = $_POST["mail"];
			if(endsWith($mail , "@epsi.fr") || endsWith($mail , "@lyon-epsi.fr")) {
				$pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$count = $mysqli->query("select * from accounts where email='".$mail."'");
				if($count->num_rows != 0) {
					echo '<br><div class="btn btn-danger" style="cursor:default">Cette Adresse Email est déjà utilisée !</div>';

				}
				else {
					$mysqli->query("insert into accounts values ('".$mail."','".$pass."','0')");
					echo '<br><div class="btn btn-warning" style="cursor:default">Inscription terminée !</div><br><br>
					<div class="btn btn-danger"><a href="login.php">Tu peux désormais te connecter ici.</a></div>';
					send_mail($mail, "MyDIL : Inscription terminée !" , "Votre inscription à MyDIL s'est déroulée avec succès.<br><br>Vous pouvez dès à présent <a href=\"http://".$_SERVER['SERVER_NAME']."/materials.php\">Commander un produit</a>.");	

				}
			}
			else {
				echo '<br><div class="btn btn-danger" style="cursor:default">Cette Adresse Email n\'est pas valide, tu dois utiliser ton adresse Epsi !</div>';

			}
		}
		?>
	</body>
	</html>
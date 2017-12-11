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
		
		<?php 

		function endsWith($haystack, $needle)
		{
			$length = strlen($needle);

			return $length === 0 || 
			(substr($haystack, -$length) === $needle);
		} 
		if($_GET["key"] != null) {
			$count = $mysqli->query("select * from accounts where password='".$_GET["key"]."'");
			if($count->num_rows != 0) {
				$array = $count->fetch_array();
				$pass = rand();
				$pass = $pass + rand();
				$crypt = password_hash($pass, PASSWORD_DEFAULT);
				$mysqli->query("update accounts set password='".$crypt."' where password='".$_GET["key"]."'");
				send_mail($array["email"],  "MyDIL : Mot de passe réinitialisé", "Votre mot de passe à bien été réinitialisé<br><br>Nouveau mot de passe : ".$pass);

				echo '<br><div class="btn btn-warning" style="cursor:default">Votre nouveau mot de passe vous à été envoyé par mail</div>';
			}
		}
		else {

			echo '
<form method="post">
			<input type="text" name="mail" placeholder="Adresse Email" required><br><br>
			<button type="submit" class="btn btn-warning">Mot de passe oublié</button>
		</form>
			';
			if (isset($_POST["mail"])) {
				$mail = $_POST["mail"];
				$pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$count = $mysqli->query("select * from accounts where email='".$mail."'");
				if($count->num_rows != 0) {
					$array = $count->fetch_array();
					echo '<br><div class="btn btn-warning" style="cursor:default">Un email contenant les instructions pour récupérer un nouveau mot de passe vous a été envoyé !</div>';
					send_mail($mail,  "MyDIL : Mot de passe oublié", "<a href=\"http://".$_SERVER['SERVER_NAME']."/password_recover.php?key=".$array["password"]."\">Lien de réinitialisation de mot de passe</a>");
				}
				else {
					echo '<br><div class="btn btn-warning" style="cursor:default">Cette adresse n\'existe pas !</div>';
					

				}
			}
			
		}
		?>
	</body>
	</html>
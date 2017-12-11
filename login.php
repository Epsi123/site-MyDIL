<?php
include('mysql.php');
?>
	<!DOCTYPE html>
	<html> 
	<head>
		<meta charset="UTF-8">
	</head> 
	<body>
		<center>
			<form method="post">
				<input type="text" name="email" placeholder="Adresse Email" required><br><br>
				<input type="password" name="password" placeholder="Mot de passe"  style="margin-bottom:5px;" required><br>
				<a href="password_recover.php"><font color="#271549"><b><i><u>Mot de passe oublié ?</u></i></b></font></a>
				<br>
			<button type="submit" class="btn btn-primary" style="margin-top:5px;">Connexion</button>

			

			</form>
			<?php 
			 			if($_SESSION["token"] != null) {
			header('Location: index.php');	
			}
			if (isset($_POST["email"])) {
				$email = $_POST["email"];
				$pass = $_POST["password"];
				$request =	$mysqli->query("select * from accounts where email='".$email."'");
				if($request->num_rows != 0) {
					$array = $request->fetch_array();
					$passhash = $array["password"];
					if(password_verify($pass, $passhash)) {
						$mysqli->query("delete from sessions where email='".$email."'");
						$token = uniqid();
						$mysqli->query("insert into sessions values('".$email."','".$token."')");
						$_SESSION["token"] = $token;
						header('Location: account.php');
					}
					else {
						echo "
						<br>
						Combinaison Email/Mot de passe incorrecte.";
					}
				}
				else {
					echo "
					<br>
					Combinaison Email/Mot de passe incorrecte.";
				}
			}			
			
			?>
		</body>
		</html>
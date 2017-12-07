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
	
<?php

if($_SESSION["token"] != null) {
if($_SESSION["panier"] != null) {
	$demande = "";
	$panier = $_SESSION["panier"];
$request = $mysqli->query("select * from stock");
while($array = $request->fetch_array()) {
	if(count(array_keys($panier,$array["materiel"])) > 0) {
		if($demande == "") {
				$demande = count(array_keys($panier,$array["materiel"])).":".$array["materiel"];	
		}
		else {
		$demande = $demande.",".count(array_keys($panier,$array["materiel"])).":".$array["materiel"];	
		}
}
}
	   $request =  $mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
      $array = $request->fetch_array();
$mysqli->query("insert into demandes values (NULL,'".$array["email"]."','".$demande."','".strtotime($_POST["date"])."')");	
send_mail($array["email"], "MyDIL : Demande d'emprunt reçue !" , "Votre demande d'emprunt à bien été reçue par l'administration.<br><br>Elle sera traitée dans les plus brefs délais, vous recevrez un mail lorsqu'elle sera traitée."); 
unset($_SESSION["panier"]);
header('Location: account.php');
}	
}
else {
header('Location: login.php');	
}
			?>
		</body>
		</html>
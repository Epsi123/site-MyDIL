<?php
include('mysql.php');
?>
	<!DOCTYPE html>
	<html> 
	<head>
		<meta charset="UTF-8">
	<script>
function checkout() {
 var m = confirm("Envoyer une demande d'emprunt pour votre panier ?"); 
 if (m == true) {
document.location.href = "checkout.php";
}
else {

}
}
	</script>
	</head> 

	<body>
		<center>
	
			<?php 
			if($_GET["panier_remove"] != null) {
			$array = $_SESSION["panier"];
			foreach (array_keys($array, $_GET["panier_remove"] ) as $key) {
    unset($array[$key]);
    $_SESSION["panier"] = $array;
}

header('Location: panier.php');
			}
			if($_SESSION["panier"] != null && $_SESSION["panier"] != "" ) {
echo '
			<table>
			<tr>
			<td><b>Materiel</td>
			<td><b>Quantité</td>
			</tr>';;
			$panier = $_SESSION["panier"];
$request = $mysqli->query("select * from stock");
while($array = $request->fetch_array()) {
	if(count(array_keys($panier,$array["materiel"])) > 0) {
echo "<tr><td>";
echo $array["materiel"];
echo"</td><td>";
echo count(array_keys($panier,$array["materiel"]));
echo" </td><td><a href=\"panier.php?panier_remove=";
echo $array["materiel"];
echo"\" style=\"color:#271549!important;text-decoration:none;\" class=\"glyphicon glyphicon-remove\"></a></td></tr>";
		
		}
			}

			echo '
			<tr>
			<td colspan="2">
			Votre Panier</td></tr>
			</table>';		
			echo '<br><br><form action="checkout.php" method="post"><b>Date de fin : </b><input type="date" name="date" required><br><br><input type="submit" value="Demander un emprunt" style="border-radius:3px"></form>'; 
			}
			else {
				echo '<div class="btn btn-success" style="cursor:default">Votre panier est vide !</div>'; 

			}	
			?>
		</body>
		</html>
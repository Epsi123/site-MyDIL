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
		$request =	$mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
		if ($_SESSION["token"] != null && $request->num_rows != 0) {
			$session = $request->fetch_array();
			$request =	$mysqli->query("select * from accounts where email='".$session["email"]."'");
			$array = $request->fetch_array();

			$request =	$mysqli->query("select * from demandes where email='".$session["email"]."'");
			if($request->num_rows != 0) {
				echo '
				<table>
				<tr>
				<td><b>ID Demande</td>
				<td><b>Materiel</td>
				<td><b>Date de Fin</b></td>
				</tr>';
				while($array = $request->fetch_array()) {
					$produits = "";
					$materials = explode(',',$array["materiel"]);
					echo"</tr>";
					foreach($materials as $material) {
						$infos = explode(':',$material);
						
						if($produits == "") {
							$produits = $infos[0]." ".$infos[1]."(s)";	
						}
						else {
							$produits = $produits. ", " .$infos[0]." ".$infos[1]."(s)";	

						}
					}
					echo "<td>";
					echo $array["id"];
					echo "</td>";
					echo "<td>";
					echo $produits;
					echo "</td>";
					echo "<td>";
					echo date('d/m/Y', $array["date_fin"]);
					echo "</td>";
					echo "<tr>";
				}
				
				
				
				
				echo '
				<tr>
				<td colspan="3">
				Liste des demandes d\'emprunts
				</td></tr>
				</table>';
			}
			else {
				echo '<div class="btn btn-success"  style="cursor:default">Aucune demande en attente !</div>';	

			}
			echo '<br><br>';

			$request =	$mysqli->query("select * from emprunts_actifs where email='".$session["email"]."'");
			if($request->num_rows != 0) {
				echo '
				<table>
				<tr>
				<td><b>ID Emprunt</td>
				<td><b>Materiel</td>
        <td><b>Date de Fin</b></td>

				</tr>';
				while($array = $request->fetch_array()) {
					$nom = $array["material"];
					$id = $array["id"];
					echo "<tr>
					<td>$id</td>
					<td>$nom</td>
					";
echo "<td>";
          echo date('d/m/Y', $array["date_fin"]);
          echo "</td>";
					echo"</tr>";
				}	
				echo '
				<tr>
				<td style="text-align:center;" colspan="3">
				Liste des emprunts en cours</td></tr>
				</table>';
			}
			else {
				echo '<div class="btn btn-success" style="cursor:default">Aucun emprunt en cours !</div>';	

			}


		}
		else {
			header('Location: login.php');	
		}	
		?>
	</body>
	</html>
<?php
include('mysql.php');
?>
<!DOCTYPE html>
<html> 
<head>
<style>
select {
	border: 2px solid #271549;
background-color:#77649b;	
}

</style>
	<meta charset="UTF-8">
</head> 
<body>

	<?php
	


	if($_SESSION["token"] != null) {
		$request =  $mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
		$array = $request->fetch_array();
		$request2 =  $mysqli->query("select * from accounts where email='".$array["email"]."'");
		$array2 = $request2->fetch_array();
		if($array2["granted"] != 1) {
			header('Location: login.php');  
		}
	}
	else {
		header('Location: login.php');	
	}




	if(isset($_POST["add_cat"])) {
		$cat = $_POST["add_cat"];
		$request = $mysqli->query("select * from categories where categorie='".$cat."'");
		if($request->num_rows == 0) {
			$mysqli->query("insert into categories values ('','".$cat."')");
		}
	}



	if(isset($_POST["add_sub"])) {
		$sub_cat = $_POST["add_sub"];
		$cat = $_POST["add_sub_cat"];
		$request = $mysqli->query("select * from categories where categorie='".$cat."'");
		if($request->num_rows != 0) {
			$array = $request->fetch_array();
			$cat = $array["id"];	
		}
		$request = $mysqli->query("select * from sub_categories where sub_categorie='".$sub_cat."'");
		if($request->num_rows == 0) {
			$mysqli->query("insert into sub_categories values ('','".$sub_cat."', '".$cat."')");
		}
	}



	if(isset($_POST["add_product"])) {
		$sub_cat = $_POST["add_product"];
		$cat = $_POST["add_product_sub"];
		$request = $mysqli->query("select * from sub_categories where sub_categorie='".$cat."'");
		if($request->num_rows != 0) {
			$array = $request->fetch_array();
			$cat = $array["id"];	
		}
		$request = $mysqli->query("select * from stock where materiel='".$sub_cat."'");
		if($request->num_rows == 0) {
			$mysqli->query("insert into stock values ('','".$sub_cat."','".$cat."','')");
		}	
	}









	if(isset($_POST["remove_cat"])) {
		$cat = $_POST["remove_cat"];
		$mysqli->query("delete from categories where categorie ='".$cat."'");
	}






	if(isset($_POST["remove_sub"])) {
		$cat = $_POST["remove_sub"];
		$mysqli->query("delete from sub_categories where sub_categorie ='".$cat."'");
	}




	if(isset($_POST["remove_product"])) {
		$cat = $_POST["remove_product"];
		$mysqli->query("delete from stock where materiel ='".$cat."'");
	}







	if(isset($_POST["edit_cat"])) {
		$old = $_POST["edit_cat"];
		$new = $_POST["edit_cat2"];

		$mysqli->query("update categories set categorie='".$new."' where categorie ='".$old."'");
	}
	
	
	if(isset($_POST["edit_sub"])) {
		$old = $_POST["edit_sub"];
		$new = $_POST["edit_sub2"];
		$cat = $_POST["edit_sub_cat"];
		$request = $mysqli->query("select * from categories where categorie='".$cat."'");
		if($request->num_rows != 0) {
			$array = $request->fetch_array();
			$cat = $array["id"];	
		}
		$mysqli->query("update sub_categories set sub_categorie='".$new."' , id_cat ='".$cat."' where sub_categorie ='".$old."'");	
	}

	
	if(isset($_POST["edit_product"])) {
		$old = $_POST["edit_product"];
		$new = $_POST["edit_product2"];
		$cat = $_POST["edit_product_sub"];
		$amountt = $_POST["edit_product_amount"];
		$request = $mysqli->query("select * from sub_categories where sub_categorie='".$cat."'");
		if($request->num_rows != 0) {
			$array = $request->fetch_array();
			$cat = $array["id"];	
		}
		$mysqli->query("update stock set materiel='".$new."' , id_sub ='".$cat."', amount='".$amountt."' where materiel ='".$old."'");	
	}




	$choice1 = $_GET["type"];

	
	$request_cat = $mysqli->query("select * from categories");
	$request_sub = $mysqli->query("select * from sub_categories");
	$request_product = $mysqli->query("select * from stock");



	echo '<div style=""><center><div class="btn btn-success" style="margin-right:70px;cursor:default" >Editer Catégorie';
	$cat = "";
	if($_GET["type"] == "Catégorie")
		$cat = $_GET["cat"];


	echo'<form method="post" action="admin-stock.php"><br><SELECT onChange="javascript:reload2(this.value);"><OPTION>';


	while($array = $request_cat->fetch_array()) {
		echo "<option";
		if($cat == $array["categorie"]) {
			echo " selected";
		}
		echo ">";
		echo $array["categorie"];	
	}
	$request_cat->data_seek(0);

	echo "</select><br><br>";


	echo'<input type="text" style="display:none;" name="edit_cat" value="'; echo $cat; echo'" required><input type="text" placeholder="nom de la catégorie.." name="edit_cat2" value="';
	echo $cat;
	echo'" required><br><br><input type="submit" value="Editer"></form></div>';

	






	echo '<div class="btn btn-success" style="margin-right:70px;cursor:default">Editer Sous-Catégorie';
	$cat = "";
	if($_GET["type"] == "Sous-Catégorie")
		$cat = $_GET["cat"];

	
	echo'<form method="post" action="admin-stock.php"><br><SELECT onChange="javascript:reload3(this.value);"><OPTION>';
	
	while($array = $request_sub->fetch_array()) {
		echo "<option";
		if($cat == $array["sub_categorie"]) {
			$id = $array["id_cat"];
			echo " selected";
		}
		echo ">";
		echo $array["sub_categorie"];	
	}
	$request_sub->data_seek(0);
	echo "</select><br><br>";


	echo'<input type="text" style="display:none;" name="edit_sub" value="'; echo $cat; echo'" required><input type="text" placeholder="nom de la sous-catégorie.." name="edit_sub2" value="';
	echo $cat;
	echo'" required><br><br>';

	echo'<SELECT name="edit_sub_cat"><OPTION>';


	while($array = $request_cat->fetch_array()) {
		echo "<option";
		if($id == $array["id"]) {
			echo " selected";
		}
		echo ">";
		echo $array["categorie"];	
	}
	unset($id);
	$request_cat->data_seek(0);

	echo "</select><br><br>";

	echo'	<input type="submit" value="Editer"></form></div>';





	echo '<div class="btn btn-success" style="margin-right:70px;cursor:default">Editer Produit';
	$cat = "";
	if($_GET["type"] == "Produit")
		$cat = $_GET["cat"];

	
	echo'<form method="post" action="admin-stock.php"><br><SELECT onChange="javascript:reload4(this.value);"><OPTION>';
	

	while($array = $request_product->fetch_array()) {
		echo "<option";
		if($cat == $array["materiel"]) {
			$id = $array["id_sub"];
			$amount = $array["amount"];
			echo " selected";
		}
		echo ">";
		echo $array["materiel"];	
	}
	$request_product->data_seek(0);
	echo "</select><br><br>";


	echo'<input type="text" style="display:none;" name="edit_product" value="'; echo $cat; echo'" required><input type="text" placeholder="nom du produit.." name="edit_product2" value="';
	echo $cat;
	echo'" required><br><br>';

echo'Quantité : <input style="width:50px" type="number" name="edit_product_amount" value="';
echo $amount;
 echo '" min="0">';

	echo'<br><br>';

	echo'Sous-Catégorie : <SELECT name="edit_product_sub"><OPTION>';


	while($array = $request_sub->fetch_array()) {
		echo "<option";
		if($id == $array["id"]) {
			echo " selected";
		}
		echo ">";
		echo $array["sub_categorie"];	
	}
	unset($id);

	$request_sub->data_seek(0);

	echo "</select>";
	echo'<br><br><input type="submit" value="Editer"></form></div>';

	echo '</div>';




	echo '<div style="float:left;margin-left:30%">';
	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default">Ajouter Catégorie<form method="post" action="admin-stock.php"><br><input name="add_cat" type="text" placeholder="nom de la catégorie.." required><br><br><input type="submit" value="Ajouter"></form></div>';

	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default">Ajouter Sous-Catégorie<form method="post" action="admin-stock.php"><br><input type="text"  name="add_sub" placeholder="nom de la sous-catégorie.." required>

	<br><br>Dans : <select name="add_sub_cat">';

	while($array = $request_cat->fetch_array()) {
		echo "<option>";
		echo $array["categorie"];	
	}
	$request_cat->data_seek(0);


	echo'
	</select><br><br><input type="submit" value="Ajouter"></form></div>';


	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default">Ajouter Produit<form method="post" action="admin-stock.php"><br><input type="text"  name="add_product" placeholder="nom du produit.." required>


	<br><br>Dans : <select name="add_product_sub">';

	while($array = $request_sub->fetch_array()) {
		echo "<option>";
		echo $array["sub_categorie"];	
	}
	$request_sub->data_seek(0);


	echo'
	</select>
	<br><br><input type="submit" value="Ajouter"></form></div>';
	echo '</div>';







	echo '
	<script>
	function reload2(value) {
		if(value != "") {
			document.location.href = "admin-stock.php?type=Catégorie&cat="+value;	
		}
	}
	</script>
	'; 

	echo '
	<script>
	function reload3(value) {
		if(value != "") {
			document.location.href = "admin-stock.php?type=Sous-Catégorie&cat="+value;	
		}
	}
	</script>
	';


	echo '
	<script>
	function reload4(value) {
		if(value != "") {
			document.location.href = "admin-stock.php?type=Produit&cat="+value;	
		}
	}
	</script>
	'; 

	
	





	echo '<div style="float:left;">';
	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default">Supprimer Catégorie<form method="post" action="admin-stock.php"><br>';
	echo '<select name="remove_cat">';
	while($array = $request_cat->fetch_array()) {
		echo "<option>";
		echo $array["categorie"];	
	}
	$request_cat->data_seek(0);
	echo "</select>";
	echo'

	<br><br><input type="submit" value="Supprimer"></form></div>';

	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default">Supprimer Sous-Catégorie<form method="post" action="admin-stock.php"><br>';
	echo '<select name="remove_sub">';
	while($array = $request_sub->fetch_array()) {
		echo "<option>";
		echo $array["sub_categorie"];	
	}
	$request_sub->data_seek(0);
	echo "</select>";

	echo '<br><br><input type="submit" value="Supprimer"></form></div>';


	echo '<br><br><div class="btn btn-success" style="margin-right:70px;cursor:default;margin-bottom:70px;">Supprimer Produit<form method="post" action="admin-stock.php"><br>';
	echo '<select name="remove_product">';
	while($array = $request_product->fetch_array()) {
		echo "<option>";
		echo $array["materiel"];	
	}
	$request_product->data_seek(0);
	echo "</select>";
	echo'	<br><br><input type="submit" value="Supprimer"></form></div></div>';












	echo '<br><br><br>';



	?>
</body>
</html>
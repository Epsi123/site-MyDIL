<?php
$mysqli = mysqli_connect("localhost" , "root", "root");
mysqli_select_db($mysqli,"MyDIL");
$mysqli->set_charset("utf8");
if($_GET["sub"] != null) {
$request = $mysqli->query("select * from stock where id_sub='".$_GET["sub"]."'"); 
if($request->num_rows != 0) {
while($array = $request->fetch_array()) {
echo $array["materiel"];
echo ":";	
echo $array["amount"];
echo '<br><span class="glyphicon glyphicon-shopping-cart"></span>;';
}
}
else {
echo "Cet endroit est vide ou n'existe pas !";	
}

}
	?>
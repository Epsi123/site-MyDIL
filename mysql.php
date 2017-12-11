<link rel="icon" type="image/png" href="favicon.png" />
<head>
<?php
session_start();
$paths = explode('.', basename($_SERVER['PHP_SELF']));
$path = ucfirst($paths[0]);
echo "<title>MyDIL - $path</title>";

//la connexion mysql est également a modifier dans le fichier material-get.php


$mysqli = mysqli_connect("localhost" , "root", "bibibi");

$mysqli->set_charset("utf8");

$mysqli->query("create database IF NOT EXISTS MyDIL");

mysqli_select_db($mysqli,"MyDIL");

$request = $mysqli->query("select * from emprunts_actifs");
while($array = $request->fetch_array()) {
if($array["date_fin"] < time()) {
	$email = $array["email"];
$request = $mysqli->query("delete from emprunts_actifs where id='".$array["id"]."'");
 send_mail($email, "MyDIL : emprunt en cours expiré" , "Votre emprunt N°".$array["id"]." est arrivé à son terme !<br><br>Veuillez ramener le materiel dès que possible à MyDIL."); 
}	
}	
 
if(basename($_SERVER['PHP_SELF']) != "material-get.php") {
include('navbar.php');
}
require "password_hash/password.php";

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="location, mydil, epsi, lyon, informatique" />
<meta name="description" content="Site de location de matériel pour les étudiants de l'Epsi à Lyon" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
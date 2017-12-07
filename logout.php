<?php
include('mysql.php');
$mysqli->query("delete from sessions where token='".$_SESSION["token"]."'");
unset($_SESSION["token"]);
header('Location: index.php');
?>

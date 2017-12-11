


<style>
@keyframes animation1 {
  from {margin-left:2000px;}
  to {margin-left:0px;}
}
@keyframes animation2 {
  from {margin-top:-50px;}
  to {margin-top:0px;}
}
td 
{
 text-align:center;
 color:#271549;
 border: 1px solid #271549; 
 padding: 5px!important;
 background-color:#77649b;
}
::-webkit-input-placeholder {
  color:#271549!important;
}

:-moz-placeholder {
  color:#271549!important;
}

::-moz-placeholder {  
  color:#271549!important;
}

:-ms-input-placeholder {  
  color:#271549!important;
}
input {
  background-color:#77649b!important;
  border-color:#271549!important;
  border-style: solid;
  border-width: 2px!important;
  color:#271549!important;
  font-weight: bold!important;
}
.btn {
  background-color:#77649b!important;
  border-color:#271549!important;
  border-width: 2px!important;
  color:#271549!important;
  font-weight: bold!important;
}
.link {
  text-decoration:none!important;	
}
ul {
  margin: 0; 
  padding: 0;
  overflow: hidden;
}
.navbar2 .active {
 background-color:#77649b;
 color:#271549; 
 
}
li:hover .link {
 color:#271549!important;
}
li:hover  {
 background-color:#77649b; 
}
li {
 padding-left:10px;
 padding-right:10px;
 float:left;
 list-style-type: none;
 display: block;
 color:#77649b;
}
li {
 padding-left:10px;
 padding-right:10px;
 float:left;
 list-style-type: none;
 display: block;
 color:#77649b;
}
.right {
 float: right; 
}
.navbar2 {
 /*   animation-name: animation2;
 animation-duration: 2s; */
 border-radius:0px;
 background-color: #271549;
 line-height:50px;
 height:50px;
}
.navbar2 .link {
  color:#77649b!important;
  display:block;
}
body {
  background-image: url("background.jpg");  
  background-repeat: no-repeat;
}
</style>
<div class="navbar2">
  <ul>
    <?php

    function send_mail($to, $object, $content) {


      require('mailer/class.phpmailer.php');

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.bbox.fr";
 $mail->Port = 587;
$mail->SMTPSecure = 'ssl';
$mail->CharSet = 'UTF-8';
$mail->Username = 'jandaly.oriane@bbox.fr';
$mail->Password = '2B929a549';
$mail->setFrom('jandaly.oriane@bbox.fr', 'Administration MyDIL');
$mail->addAddress($to, $to);
$mail->Subject = $object;
$mail->MsgHTML($content);
$mail->send();
    }



    $path = basename($_SERVER['PHP_SELF']);
    if($path == "index.php") {
     echo '<li class="active">Accueil</li>';  
   }
   else {
     echo '<li><a class="link" href="index.php">Accueil</a></li>';          
   }
   if($_SESSION["token"] != null) {
    if($path == "account.php") {
     echo '<li class="active">Mon Compte</li>';  
   }
   else {
     echo '<li><a class="link" href="account.php">Mon Compte</a></li>';          
   }
 }

 if($path == "materials.php") {
   echo '<li class="active">Stock</li>';  
 }
 else {
   echo '<li><a class="link" href="materials.php">Stock</a></li>';          
 }
 if($_SESSION["panier"] != null) {
  $count = count($_SESSION["panier"]);
}
else {
 $count = 0; 
}
if($path == "panier.php") {
 echo '<li class="active"><span class="glyphicon glyphicon-shopping-cart"></span> ('; echo $count; echo')</li>';  
}
else {
 echo '<li><a class="link" href="panier.php"><span class="glyphicon glyphicon-shopping-cart"></span> ('; echo $count; echo')</a></li>';          
}
?>
<div class="right">

  <?php
  if($_SESSION["token"] == null) {


    if($path == "register.php") {
      echo '<li class="active"><span class="glyphicon glyphicon-user"></span> Inscription</li>';
    }
    else {
      echo '<li><a class="link" href="register.php"><span class="glyphicon glyphicon-user"></span> Inscription</a></li>';
    } 


    if($path == "login.php") {
      echo '<li class="active"><span class="glyphicon glyphicon-log-in"></span> Connexion</li>';
    }
    else {
      echo '<li><a class="link" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>';
    } 
  }
  else {
    $request =  $mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
    $array = $request->fetch_array();
    $request2 =  $mysqli->query("select * from accounts where email='".$array["email"]."'");
    $array2 = $request2->fetch_array();
    if($array2["granted"] == 1) {
     if($path == "admin.php") {
      echo '<li class="active"><span class="glyphicon glyphicon-user"></span> Administration</li>'; 
    }
    else {
     echo '<li><a class="link" href="admin.php"><span class="glyphicon glyphicon-user"></span> Administration</a></li>';         
   } 
 }
 echo '<li><a class="link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>'; 
}

?>
</div>
</ul>
</div>
<?php
if($path != "materials.php") {
  echo'<br><br>';
}
?>
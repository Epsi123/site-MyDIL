<?php
include('mysql.php');
?>
<?php
if($_SESSION["token"] != null) {
  $request =  $mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
  $array = $request->fetch_array();
  $request2 =  $mysqli->query("select * from accounts where email='".$array["email"]."'");
  $array2 = $request2->fetch_array();
  if($array2["granted"] == 1) {
    if($_GET["action"] != null && $_GET["id"] != null) {
      $action = $_GET["action"];
      $raison = $_GET["raison"];
      $id = $_GET["id"];




      if($action == "Accepter") {
 //une demande a été acceptée
       $request = $mysqli->query("select * from demandes where id='".$_GET["id"]."'");
       if($request->num_rows != 0) {
         $array = $request->fetch_array();
         $email = $array["email"];
         $date = $array["date_fin"];
         $materials = explode(',',$array["materiel"]);
         foreach($materials as $material) {
          $infos = explode(':',$material);
          $amount_request = $mysqli->query("select * from stock where materiel ='".$infos[1]."'");
          $amount_array = $amount_request->fetch_array();
          $amount = $amount_array["amount"];
          $mysqli->query("update stock set amount='".($amount-$infos[0])."'  where materiel ='".$infos[1]."'");
        }  
     
      $mysqli->query("insert into emprunts_actifs values(NULL,'".$email."','".$array["materiel"]."','".$date."')");

      $mysqli->query("delete from demandes where id='".$_GET["id"]."'");
send_mail($email, "MyDIL : Demande d'emprunt acceptée !" , "Votre demande d'emprunt N°".$_GET["id"]." à bien été acceptée par l'administration !<br><br>Vous pouvez dès à présent chercher votre emprunt à MyDIL !"); 
}
    }




     if($action == "Refuser") {
 //une demande a été refusée 
           $requ =  $mysqli->query("select * from demandes where id='".$_GET["id"]."'");
            if($requ->num_rows != 0) {
         $array = $requ->fetch_array();
      $mysqli->query("delete from demandes where id='".$_GET["id"]."'");
      send_mail($array["email"], "MyDIL : Demande d'emprunt refusée.." , "Votre demande d'emprunt N°".$_GET["id"]." à malheureusement été refusée par l'administration..<br><br>Raison : ".$raison); 
    }
  }




     if($action == "Supprimer") {
 // un emprunt a été supprimé 
   $request = $mysqli->query("select * from emprunts_actifs where id='".$_GET["id"]."'");
     if($request->num_rows != 0) {
       $array = $request->fetch_array();
       $email = $array["email"];
       $materials = explode(',',$array["material"]);
       foreach($materials as $material) {
        $infos = explode(':',$material);
        $amount_request = $mysqli->query("select * from stock where materiel ='".$infos[1]."'");
        $amount_array = $amount_request->fetch_array();
        $amount = $amount_array["amount"];
        $mysqli->query("update stock set amount='".($amount+$infos[0])."'  where materiel ='".$infos[1]."'");
      }  
        send_mail($email, "MyDIL : emprunt en cours annulé.." , "Votre emprunt N°".$_GET["id"]." à malheureusement été supprimé par l'administration, veuillez ramener le materiel dès que possible.<br><br>Raison : ".$raison); 
    }
 $mysqli->query("delete from emprunts_actifs where id='".$_GET["id"]."'");

  }




}
}
else {
  header('Location: login.php');	
}
}
else {
  header('Location: login.php');	
}

header('Location: admin.php'); 
?>



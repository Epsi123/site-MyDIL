<?php
include('mysql.php');
?>
<!DOCTYPE html>
<html> 
<head>

  <script>
function demande(action, id) {
  if(action == "Accepter") {
   var m = confirm(action+" la demande N° "+id + " ?"); 
  

 if (m == true) {
document.location.href = "admin-action.php?action="+action+"&id="+id;
}
}
else {
 var m = prompt("Raison du refus de la demande N° " + id, "");

if (m == null || m == "") {} else {
document.location.href = "admin-action.php?action="+action+"&id="+id+"&raison="+m;
}

}
}

function emprunt(id) {
  var m = prompt("Raison de la suppression de l'emprunt N° " + id, "");

if (m == null || m == "") {} else {
document.location.href = "admin-action.php?action=Supprimer&id="+id+"&raison="+m;
}

}

  </script>
	<meta charset="UTF-8">
</head> 
<body>

	<center>

		<?php
if($_SESSION["token"] != null) {
  $request =  $mysqli->query("select * from sessions where token='".$_SESSION["token"]."'");
      $array = $request->fetch_array();
            $request2 =  $mysqli->query("select * from accounts where email='".$array["email"]."'");
   $array2 = $request2->fetch_array();
   if($array2["granted"] == 1) {




   	            $result =  $mysqli->query("select * from demandes");
   	            if($result->num_rows != 0) {
   	            	echo '
<table>
  <tr>
       <td><b>Adresse Email</td>
       <td><b>Produit</td>
              <td><b>ID</td>
        <td><b>Date de Fin</b></td>

   </tr> ';
      while($row = $result->fetch_array()) {


          $produits = "";
          $materials = explode(',',$row["materiel"]);
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
          echo $row["email"];
          echo "</td>";
          echo "<td>";
          echo $produits;
          echo '</td>';

          echo'<td>';
          echo $row["id"];

echo'          </td>';
echo "<td>";
          echo date('d/m/Y', $row["date_fin"]);
          echo "</td>";
echo'           <td > <a   style="color:#271549!important;" onClick="demande(\'Accepter\',\''.$row["id"].'\')">✔</a></td>
     <td>  <a  style="color:#271549!important;" onClick="demande(\'Refuser\',\''.$row["id"].'\')">✖</a></td>';
          echo "<tr>";
        


      	echo' 

      


   </tr>';
}
echo'

<tr style="background-color:black;">      <td style="text-align:center;" colspan="4">

Liste des demandes d\'emprunts
</td></tr>


</table>
';
}
else {
echo '<div class="btn btn-success" style="cursor:default">Aucune demande d\'emprunt en attente !</div>';	
}




echo '<br><br>';


                $result =  $mysqli->query("select * from emprunts_actifs");
                if($result->num_rows != 0) {
                  echo '
<table>

  <tr>
       <td><b>Adresse Email</td>
       <td><b>Produit</td>
              <td><b>ID</td>
        <td><b>Date de Fin</b></td>

   </tr> ';
      while($row = $result->fetch_array()) {
           $produits = "";
          $materials = explode(',',$row["material"]);
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
          echo $row["email"];
          echo "</td>";
          echo "<td>";
          echo $produits;
          echo '</td>
          <td>';
          echo $row["id"];
    echo' </td>';

echo "<td>";
          echo date('d/m/Y', $row["date_fin"]);
          echo "</td>";
    echo'<td>  <a  style="color:#271549!important;" onClick="emprunt(\''.$row["id"].'\')">✖</a></td>


   </tr>';
}
echo'
<tr style="background-color:black;">      <td style="text-align:center;" colspan="4">

Liste des emprunts en cours
</td></tr>
</table>
';
}
else {
echo '<div class="btn btn-success" style="cursor:default">Aucun emprunt en cours !</div>'; 
}


echo '<br><br><br><br><a href="admin-stock.php"><div class="btn btn-success" style=" background-color:#271549!important;
      border-color:#77649b!important;
      color:#77649b!important;
   ">Gérer le stock</div></a>';

   }
   else {
header('Location: login.php');  
}
}
else {
header('Location: login.php');	
}
		?>
	</body>
	</html>
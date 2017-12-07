<?php
include('mysql.php');
?>
<!DOCTYPE html>
<html> 
<head>
	<style>
	.selection {
		float:left;
				width:165px;

		border-top: 2px #77649b solid;	
		display:inline-block;
		padding:8px;
		min-height:600px;
		color:#77649b;
		background-color:#271549;
	}
	.btn a,a:visited,a:hover {
		text-decoration: none;
		color:#271549;
  display:block;

	}
	.selection >.sub {
		list-style-type: none;
		font-size:12px;
		text-indent:15px;
	}
	.selection >.main {
		list-style-type: none;
		font-size:12px;
		text-indent:10px;
	}
	.main:before {
		content: "\f07b"; 
		font-family: FontAwesome;
		display: inline-block;
		margin-left: -1.5em; 
		width: 2.3em; 
	} 
	.sub {
		cursor: pointer;

	}
	.sub:hover {
		color:white;	
	}
	.sub:before {
		content: "\f061"; 
		font-family: FontAwesome;
		display: inline-block;
		margin-left: -1.5em; 
		width: 2.5em; 
	}
	.defaut {
		border-radius:200px;
		text-decoration: none;
		color:#271549;
		background-color:#77649b;
  display:inline-block;
  padding:10px;
  font-weight:bold;
	}
	.selection .main {
		font-weight:bold;
		text-decoration:underline;
	}
	.content {
	margin-top:50px;	
	}
</style>
<script>

	function get(object, name) {
		var elements = document.getElementsByClassName("sub");
		for (var i = 0, len = elements.length; i < len; i++) {
			elements[i].style.color = "#77649b";
		}
		object.style.color = "#fff";

		$.ajax({
			url : "material-get.php?sub="+name,
			dataType: "text",
			success : function (data) {
				if(data != "Cet endroit est vide ou n'existe pas !") {
					var res = String(data).split(";");				
					var arrayLength = res.length;
					for (var i = 0; i < arrayLength; i++) {
						var infos = res[i].split(":");
						if(infos[0] != "") {
							var content = "";
							if(i != 0) {
								content = $(".content").html();	
							}
							content = content + '<div class="btn btn-success" style="margin-right:10px"><a href="materials.php?get='+infos[0]+'">Produit : '+infos[0]+'<br>Quantité : '+infos[1]+'</a></div>';
							$(".content").html(content);

						}
					}


				}
				else {
					$(".content").html(data);

				}
			}
		});
	}
</script>
<meta charset="UTF-8">
</head> 
<body>
	<div class="selection">
		<?php
		$query = $mysqli->query("select * from categories");
		if($query->num_rows != 0) {
			$cat_used = array();
			while($array = $query->fetch_array()) {
				$categorie = $array["categorie"];
				if(in_array($categorie, $cat_used)==false) {
					echo '<div class="main">';
					echo $categorie;
					echo'</div>';
					$query2 = $mysqli->query("select * from categories where categorie='".$categorie."'");
					while($array2 = $query2->fetch_array()) {
						$query22 = $mysqli->query("select * from sub_categories where id_cat='".$array2["id"]."'");
					while($array22 = $query22->fetch_array()) {
						echo "<br>";
						$sub = $array22["sub_categorie"];
						echo '<div class="sub" Onclick="get(this,\'';
						echo $array22["id"];
						echo '\')">';
						echo $sub;
						echo '</div>';
					}
				}
					echo "<br><br>";
					array_push($cat_used, $categorie);
				}
			}
		}


echo '</div>';
?>
	<center>
		<div class="content">
			<div class="defaut">
				Veuillez choisir une catégorie à gauche.
			</div>
		</div>
	</center>
	<?php

		if($_GET["get"] != null && $_GET["get"] != "") {
			$request = $mysqli->query("select * from stock where materiel ='".$_GET["get"]."'");
			if($request->num_rows != 0) {
				$array = $request->fetch_array();
				if($array["amount"] > 0) {
				if($_SESSION["panier"] == null) {
					$_SESSION["panier"] = array();	
				}

				$panier = $_SESSION["panier"];
				array_push($panier, $_GET["get"]);
				$_SESSION["panier"] = $panier;
}
			}
			echo '
			<script>
			document.location.href = "materials.php";
			</script>
			';
		}
		?>


</body>
</html>
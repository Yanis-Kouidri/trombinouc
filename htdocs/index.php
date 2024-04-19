<?php
	session_start();
	include('./Outils/base.php');
	include('./Outils/fonctions.php');
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<?php include('./Includes/head.html'); ?>
		<title> Trombinouc : Home </title>
	</head>

	<body>
		<header>
			<h1> Trombinouc </h1>

			<?php
				//debug($_SESSION);

				if ($_SESSION && $_SESSION["logged"]) {
					echo "<p><a href='profil.php?usr=me'>Votre profil</a></p>
					<p>
				<a href='search.php'> Rechercher </a>
			</p>

			<p>
				<a href='poster.php'>Poster</a>
			</p>
			
			<p>
				<a href='galerie.php'> Galerie </a>
			</p>
			
			<p>
				<a href='deconnexion.php'>Se déconnecter</a>
			</p>";
				} else {
					echo "<p><a href='inscription.php'>S'inscrire</a>/<a href='connexion.php'>Se connecter</a></p>";
				}
			?>

		</header>
		<h2 class="post-title">Les posts</h2>	
<?php
	if ($_GET) {
		if ($_GET['msg'] == "no_admin_friend" ) {
			echo "<h3> Vous devez être administrateur ou ami avec un administrateur pour pouvoir poster sur Trombinouc </h3>";
		}
		if ($_GET['msg'] == "no_admin_friend2" ) {
			echo "<h3> Vous devez être administrateur ou ami avec un administrateur pour pouvoir commenter sur Trombinouc </h3>";
		}
		if ($_GET['msg'] == "newpost" ) {
			echo "<h3> Vous venez de poster sur Trombinouc </h3>";
		}
		if ($_GET['msg'] == "newcomm" ) {
			echo "<h3> Vous venez de commenter sur Trombinouc </h3>";
		}
	}



//Là, je fais une requête pour avoir tous les posts
	$sql = "SELECT * FROM POSTS";
	$sql = $sql." ORDER BY id DESC ";
	$req = $dbConnection -> prepare($sql);
	$req -> execute();
	$lesposts  = $req -> fetchall();
	$req -> closeCursor();

	//echo "<pre>";
	//print_r($lesposts);
	//echo "</pre>";	

	foreach($lesposts as $apost ) {
		echo "<section>";

			// ici je fais une requête pour obtenir le nom et prénom de celui qui a fait le post
		// en vrai on aurait pu les mettre dans la table post directement mais bon, comme ça on évite la redondance non ?
		$sql = "SELECT name, last_name FROM USERS WHERE username = '".$apost['user'] ."' ";
		$req = $dbConnection -> prepare($sql);
		$req -> execute();
		$nomprenom  = $req -> fetchall();
		$req -> closeCursor();
		
		
		echo "<p>";
				echo $nomprenom[0][0]." ".$nomprenom[0][1]. " a écrit le " .$apost['date']. " à ". $apost['time'] ;
		echo "</p>";

		
		echo "<p>";
			echo $apost['text'];
		echo "</p>";

		echo "<form method='post' action='./commentaires.php'>"; // Le bouton commentaires va aller sur la page commentaires.php
		
		echo ' <button id="comm" name="comm" type="submit" value="'.$apost['id'].'"> Commentaires </button>'; // bouton permettant d'aller sur la page des commentaire en embarquant l'ip unique du post
		echo "</form>";

		echo "</section>";
	}

?>
		
		
		<nav>
				
		</nav>
	</body>
</html>

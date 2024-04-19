<?php
	session_start();
	if ($_SESSION['logged'] != 1 ) {		//si vous n'êtes pas connecté, retour à la page de connexion.
		header('Location:./connexion.php?msg=nonco');
		exit();
	}

	include("./Outils/base.php");
	include("./Outils/fonctions.php");
	
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<?php include('./Includes/head.html'); ?>
		<title> Trombinouc : Recherche </title>
	</head>

	<body>
		<header>
			<p> Trombinouc : Recherche </p>
			<?php
				if ($_GET) {
					if($_GET['msg'] == "dejaamis" ) {
						echo "<h2> Vous êtes déjà amis ! </h2>";
					}
					if($_GET['msg'] == "amis" ) {
						echo "<h2> Demande d'ami envoyée ! </h2>";
					}
				}

			?>
			<?php include('./Includes/nav.html') ?>
		</header>

		
		<form method="POST" action="./search.php">

			<p>	<label for="recherche"> Rechercher par le nom ou le prénom de l'utilisateur : </label> <!-- Il faut être connecté pour effectuer une recherche  -->
				<input id="recherche" name="recherche" type="text" maxlength="30" required /> 
			</p> 
			<p>	
				<button id="rechercher" name="rechercher" type="submit" value="search"> Rechercher </button> 
			</p>
		</form>

		<section>
		<p> Les utilisateurs de trombinouc : </p>		
			<?php

				//echo "contenu de \$_POST "; 
				//echo "<pre>";
				//print_r($_POST);   //Pour le déboguage
				//echo "</pre>";
				
				if ($_POST && $_POST['rechercher'] == "search" ) {  		//Si on passe par le formulaire de recherche alors :

					$sql = "SELECT name, last_name, username FROM USERS ";
					$sql = $sql." WHERE name LIKE :prenom OR last_name LIKE :nom ";
					$req = $dbConnection-> prepare($sql);
					$marqueurs = array("prenom" => "%{$_POST['recherche']}%", "nom" => "%{$_POST['recherche']}%" ); //les pourcentages permettent de d'élargir la recherche = à * dans linux
					$req->execute($marqueurs);
					$friend = $req -> fetchall();
					$req -> closeCursor();
					//echo "Recherche cilbée :";
					//echo "<pre>";
					//print_r($friend);   //Pour le déboguage
					//echo "</pre>";


					echo "Utilisateur(s) trouvé(s) : ";
					foreach($friend as $num => $nom) {
						
						if ($nom[2] != $_SESSION['username']){	
							echo "<form method='post' action='./add.php'>"; // add.php va creer dans la table FRIENDS une nouvelle association
							echo "{$nom[0]} {$nom[1]} ";		//affiche tous les utilisateur de trombinouc
							
							echo ' <button id="add" name="add" type="submit" value="'.$nom[2].'"> Ajouter </button>'; // bouton permettant d'ajouter en ami, il a comme valeur le pseudo de l'ami
							echo "</form>";

							echo " </br> ";
						}
					}

				}

				else {			//Sinon on affiche tous les utilisateurs
					$sql = "SELECT name, last_name, username FROM USERS";
					$req = $dbConnection-> prepare($sql);
					$req->execute();
					$friend = $req -> fetchall();
					$req -> closeCursor();
					# debug($friend);   //Pour le déboguage

					

					echo "Tous les utilisateurs de Trombinouc";
					foreach($friend as $num => $nom) {

						if ($nom[2] != $_SESSION['username']){	
							echo "<form method='post' action='./add.php'>"; // add.php va creer dans la table FRIENDS une nouvelle association
							echo "<a href='profil.php?usr={$nom['username']}'>{$nom[0]} {$nom[1]}</a>";		//affiche tous les utilisateur de trombinouc
						
							echo ' <button id="add" name="add" type="submit" value="'.$nom[2].'"> Ajouter </button>'; // bouton permettant d'ajouter en ami, il a comme valeur le pseudo de l'ami
							echo "</form>";

							echo " </br> ";
						}
					}
				}
			?>
		</section>

	</body>
</html>

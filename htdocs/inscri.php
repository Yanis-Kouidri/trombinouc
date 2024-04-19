<?php
	//lorsqu'une inscription a lieu, la formulaire redirige ici
	//Premièrement on vérifie que le pseudo n'existe pas déjà, pour ça on va voir la base de donnée

	session_start();
	include("./Outils/base.php");
	include("./Outils/fonctions.php");

	if ( $_POST['mdp'] != $_POST['mdp2'] ){
		header('Location:inscription.php?msg=mdpdiff'); //on vérifie si les mots de passe saisis sont différents.
		exit();
	}
	$sql="SELECT username FROM USERS WHERE username=:pseudo";
	$req = $dbConnection -> prepare($sql);
	$marqueurs = array("pseudo" => htmlspecialchars( $_POST['login'] )  );
	$req -> execute($marqueurs);
	$reponse = $req -> fetchall();
	$req -> closeCursor();

	if ($reponse && $reponse[0] != null ) { // On vérifie que le nom d'utilisateur saisi dans le formulaire n'existe pas
		header('Location:inscription.php?msg=taken');
		exit();
	}
	else {
		$birth = $_POST['jour'].'-'.$_POST['mois'].'-'.$_POST['annee']; //je crée la date de naissance grace aux variables de $_POST
		$sql="INSERT INTO USERS (username, name, last_name, password, mail, birth, gender) 
		VALUES (:username, :name, :last_name, :password, :mail, :birth, :gender)";
		$req2 = $dbConnection -> prepare($sql);
		$marqueurs2 = array("username" => htmlspecialchars ($_POST['login']), "name" => htmlspecialchars( $_POST['prenom']) ,
			"last_name" => htmlspecialchars($_POST['nom']), "password" => hash("sha256", $_POST['mdp']), "mail" => htmlspecialchars( $_POST['mail'] ) ,
		       	"birth" => $birth ,"gender" => $_POST['genre']  );
		$req2 -> execute($marqueurs2);
		$req2 -> closeCursor(); // le compte à été créé
		
		// $marqueurs2['username'] contient le pseudo
		$_SESSION["logged"] = TRUE;
		$_SESSION["name"] = $marqueurs2['name'];
		$_SESSION["username"] = $marqueurs2["username"];
		header('Location:index.php?msg=newuser'); //renvoie vers la page principale du site avec une variable dans le lien
		exit();
	}



?>

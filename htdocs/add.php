<?php
	session_start();
	include("./Outils/base.php");
	include("./Outils/fonctions.php");
	
#	echo "Contunu de la variable SESSION";
#		debug($_SESSION);   //Pour le déboguage
	
	if ($_SESSION['logged'] != 1) {
		header('Location:connexion.php?msg=nonco');
		exit();
	}
//s'il n'est pas connecté, le rediriger vers la page de connexion

// faire en sorte de vérifier que l'utilisateur est bien log et récupérer son pseudo

//Ici je teste si l'utilisateur qui demande et l'utilisateur qui est demandé en ami ne sont pas déjà amis.
	$sql1 = "SELECT * FROM FRIENDS WHERE user1 = '{$_SESSION['username']}' AND user2='{$_POST['add']}' OR user2 = '{$_SESSION['username']}' AND user1='{$_POST['add']}' ";
	$req1 = $dbConnection-> prepare($sql1);
	$req1 -> execute();
	$dejaami = $req1 -> fetchall();
	$req1 -> closeCursor();

#	echo "le sql1 : {$sql1}";
#	echo "Résultat de la requète déjà ami :";
#	debug($dejaami);   //Pour le déboguage

	if(isset($dejaami[0])){
		header('Location:search.php?msg=dejaamis');
		exit();
	}

	//s'ils ne sont pas amis alors on ajoute un enregistrement dans la table FRIENDS
#	echo "Contenu de POST :";
#	debug($_POST);   //Pour le déboguage

	$val=array("asking" => $_SESSION['username'], "asked" => $_POST['add']);

	$sql = "INSERT INTO FRIENDS (user1, user2) VALUES (:asking,:asked)"; // ici il faut impérativement rentrer dans values des pseudo qui existent déjà dans user.
	$req = $dbConnection-> prepare($sql);
	$req -> execute($val);
	$req -> closeCursor();
	
	header('Location:search.php?msg=amis');
	exit();

?>

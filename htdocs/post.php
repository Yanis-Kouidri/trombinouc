<?php
	session_start();
	include("./Outils/fonctions.php");
	include("./Outils/base.php");
//	debug($_POST);

//	debug($_SESSION);

//	Ici je crée un enregistrement dans la table poste avec le nom de celui qui post, le contenu du post, la date et l'heure du post.

	$sql1 = "INSERT INTO POSTS (user, text, date, time) ";
	$sql1 = $sql1."VALUES (:user, :text, '".date('d-m-Y')."' , '". date('H:i:s'). "' )";
#	echo $sql1;
	$req1 = $dbConnection-> prepare($sql1);
	$marqueurs = array( "user" => $_SESSION['username'], "text" => htmlspecialchars($_POST['text'])  );
	$req1 -> execute($marqueurs);
	$req1 -> closeCursor();

	header('Location:./index.php?msg=newpost');
	exit();
?>

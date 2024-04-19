<?php
	include("./Outils/base.php");
	include("./Outils/fonctions.php");
	session_start();
//	debug($_POST);
//	debug($_SESSION);

//	Ici je crée un enregistrement dans la table COMMENTS avec le nom de celui qui commente et le contenu du commentaire..

	$sql1 = "INSERT INTO COMMENTS (parent, user, text) ";
	$sql1 = $sql1."VALUES (:parent, :user, :text )";
//	echo $sql1;
	$req1 = $dbConnection-> prepare($sql1);
	$marqueurs = array( "parent" => intval($_POST['parent']), "user" => $_SESSION['username'], "text" => htmlspecialchars($_POST['comment']) );
	$req1 -> execute($marqueurs);
	$req1 -> closeCursor();

	header('Location:./index.php?msg=newcomm');
	exit();
?>

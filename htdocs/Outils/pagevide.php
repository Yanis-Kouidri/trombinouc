<?php
	
	include("./base.php");
	include("./fonctions.php");

	session_start();
	if ($_SESSION['logged'] != 1 ) {
		header('Location:./connexion.php?msg=nonco');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="style.css">
	    <title> Un titre </title>
	</head>
	<body>
		<a href="main.php">Home</a> 




	</body>
</html>

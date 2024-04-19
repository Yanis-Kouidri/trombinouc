<?php
	session_start();
	if ($_SESSION['logged'] != 1 ) {
		header('Location:./connexion.php?msg=nonco');
		exit();
	}

    	include("./Outils/base.php");
    	include("./Outils/fonctions.php");

	$sql = 'SELECT * FROM USERS ';
	$sql = $sql.'INNER JOIN FRIENDS ON username = user1 OR username = user2 '; 
	$sql = $sql.'WHERE admin = 1 AND pending = 0 AND (user1 = \'' .$_SESSION["username"]. '\' OR user2 = \''.$_SESSION["username"].'\')';
#	echo $sql;
	$req = $dbConnection->prepare($sql);
	$req -> execute();
	$enreg = $req -> fetchall();
	$req -> closeCursor();
#	debug($enreg);

	$sql = 'SELECT admin FROM USERS ';
	$sql = $sql.'WHERE username = \''.$_SESSION["username"].'\'';
#	echo $sql;
	$req = $dbConnection->prepare($sql);
	$req -> execute();
	$admin = $req -> fetchall();
	$req -> closeCursor();

#	debug($admin);

	if ($enreg == null && $admin[0]["admin"] == 0){
		header('Location:./index.php?msg=no_admin_friend');
		exit();
	} 
	
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include('./Includes/head.html'); ?>
		<title>Poster</title>
	</head>
	<body>
	<?php include('./Includes/nav.html'); ?>
			<h1 class="message">Vous pouvez poster sur la page principale ici</h1>
			<form id="post-form" method="POST" action="post.php">
				<p>
					<textarea id="text" name="text" type="text" maxlength="20000" rows="10" cols="50"  placeholder="Quoi de neuf ?" required></textarea>
				</p>
				<p>
					<button id="post" name="post" type="submit" value="poster"> Poster </button>
				</p>
			</form>
	</body>
</html>

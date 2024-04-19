<?php
	
	include("./Outils/base.php");
	include("./Outils/fonctions.php");

	$idparent = $_POST['comm'];		//$_POST['comm'] correspond à l'id du post parent, pour plus de clarté et de simplicité, je me met dans une variable "parlante"

	session_start();
	if (!$_SESSION) {
		header('Location:./connexion.php?msg=nonco');
		exit();
	}


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
		header('Location:./index.php?msg=no_admin_friend2');
		exit();
	} 
	
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include('./Includes/head.html'); ?>
	    <title>Commentaires</title>
	</head>
	<body>
		<?php include('./Includes/nav.html'); ?>
		<h2> Le post </h2> 
<?php		//réaffiche le post
	


	$sql = "SELECT * FROM POSTS";
	$sql = $sql." WHERE id = '{$idparent}' ";
	$req = $dbConnection -> prepare($sql);
	$req -> execute();
	$lepost  = $req -> fetchall();		//récupère le post parent
	$req -> closeCursor();

	//debug($lepost);

	echo "<section>";

		// ici je fais une requête pour obtenir le nom et prénom de celui qui a fait le post
		// en vrai on aurait pu les mettre dans la table post directement mais bon, comme ça on évite la redondance non ?
		$sql = "SELECT name, last_name FROM USERS WHERE username = '".$lepost[0]['user'] ."' ";
		$req = $dbConnection -> prepare($sql);
		$req -> execute();
		$nomprenom  = $req -> fetchall();
		$req -> closeCursor();
		
		
		echo "<p>";
				echo $nomprenom[0][0]." ".$nomprenom[0][1]. " a écrit le " .$lepost[0]['date']. " à ". $lepost[0]['time'] ;
		echo "</p>";

		
		echo "<p>";
			echo $lepost[0]['text'];
		echo "</p>";

	echo "</section>";


?>

		<h2> Les commentaires : </h2>



<?php		//Affiche les commentaires du post
//	debug($_POST);
	$idparent = $_POST['comm'];		//$_POST['comm'] correspond à l'id du post parent, pour plus de clarté et de simplicité, je me met dans une variable "parlante"


	$sql = "SELECT * FROM COMMENTS";
	$sql = $sql." WHERE parent = '".$idparent ."'";
	$sql = $sql." ORDER BY id DESC ";
	// echo $sql;
	$req = $dbConnection -> prepare($sql);
	$req -> execute();
	$lescomms  = $req -> fetchall();
	$req -> closeCursor();


	foreach($lescomms as $acomm ) {
		echo "<section>";

		// ici je fais une requête pour obtenir le nom et prénom de celui qui a fait le commentaire
		$sql = "SELECT name, last_name FROM USERS WHERE username = '".$acomm['user'] ."' ";
		$req = $dbConnection -> prepare($sql);
		$req -> execute();
		$nomprenom  = $req -> fetchall();
		$req -> closeCursor();
		
		
		echo "<p>";
			echo "De " .$nomprenom[0][0]." ".$nomprenom[0][1] ;   // respécctivement nom et prénom
		echo "</p>";

		
		echo "<p>";
			echo $acomm['text'];
		echo "</p>";


		echo "</section>";
	}


?>

			<p>	Vous pouvez écrire un commentaire pour ce post ici :	</p>
			<form method="POST" action="comment.php">
				<p>
					<textarea id="comment" name="comment" type="text" maxlength="20000" rows="10" cols="50" placeholder="Qu'en pensez vous ?" required></textarea>
				</p>
				<p>
					<button id="post" name="parent" type="submit" value=" <?php echo $idparent;  ?> "  > Ajouter un commentaire </button>
				</p>
			</form>

	</body>
</html>

<?php
    include("./Outils/base.php");
    include("./Outils/fonctions.php");
	

	session_start();
	if ($_SESSION['logged'] != 1 ) {
		header('Location:./connexion.php?msg=nonco');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include('./Includes/head.html'); ?>
	    <title> Galerie photos </title>
	</head>
	<body>
	<?php include('./Includes/nav.html'); ?>
<?php
	
	$galerie = listeRep("./Galerie/"); //je récupère tout le contenu du dossier Galerie.
	//debug($galerie);
	$lesphotos = recupPhotos($galerie);
	//debug($lesphotos);
	
	foreach($lesphotos as $photo){
			echo '<img src ="./Galerie/';
			echo $photo;
			echo '" width="50%" height="50%" />';
			echo "<br>";

	}
?>



	</body>
</html>

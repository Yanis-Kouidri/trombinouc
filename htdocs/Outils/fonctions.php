<?php

function debug ($tab) {		//mini fonction qui permet de voir le contenu d'un tableau rapidement.
	echo "<pre>";
	print_r($tab);
	echo "</pre>";

}

function listeRep ($unRep) {
	$allFic=array();
	if (is_dir($unRep) == FALSE) {
		echo "{$unRep} n'est pas un répertoire !";
	}
	else {
		$rep = opendir($unRep);
		if ($rep == FALSE) {
			echo "Impossible d'ouvrir le répertoire {$unRep}";
		}
		else { 
			while (($fic = readdir($rep)) == TRUE) {
				$allFic[]=$fic;
			}
			closedir($rep);
			sort($allFic);
		}
	}
	return $allFic;
}

function recupPhotos ($listeDeFichiers) {		//cette fonction permet de lister les photos à partir d'un tableau de fichier. Elle retourne un tableau de photos.
	$lesPhotos =array();
	foreach($listeDeFichiers as $unfic) {
		$ext = substr ($unfic, -4);
		if ( $ext == ".jpg" || $ext == ".png" ) {
			$lesPhotos[] = $unfic;
		}
	
	}

return $lesPhotos;
}



function displayUserProfile($username, $dbConnection) {
    $query = "SELECT * FROM USERS WHERE username = :username";
    $stmt = $dbConnection->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $userProfile = $stmt->fetch();

    if ($userProfile) {
        echo "<section><h1>Profil de {$userProfile['name']} {$userProfile['last_name']}</h1>";

        echo "<p>Voici le profil de {$userProfile['name']} {$userProfile['last_name']}.</p>";
        if ($userProfile["admin"] == 1) {
            echo "<strong>Cette personne est admin.</strong>";
        }

        echo "</section>";

        echo "<section><h1>Ses amis :</h1>";

        displayUserFriends($username, $dbConnection);

        echo "</section>";
    }
}

function displayUserFriends($username, $dbConnection) {
	$query = "SELECT u.name, u.last_name, u.username
		FROM FRIENDS f
		INNER JOIN USERS u ON (u.username = f.user1 OR u.username = f.user2)
		WHERE (f.user1 = :username OR f.user2 = :username) AND f.pending = 0";


    $stmt = $dbConnection->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $friends = $stmt->fetchAll();

	//debug($friends);

    if (!empty($friends)) {
        foreach ($friends as $friend) {
			if ($friend['username'] !== $username) {
            	echo "<p><a href='profil.php?usr={$friend['username']}'>{$friend['name']} {$friend['last_name']}</a> est ami avec cet utilisateur.</p>";
			}
        }
    }
}
?>

<?php
    include("./Outils/base.php");
    include("./Outils/fonctions.php");
    $sql = "SELECT * FROM USERS WHERE username = :q_username";
        //q_username pour querried username
    $req = $dbConnection->prepare($sql);

    $val = array("q_username"=>$_POST["login"]);
        //la requête va utiliser la clé primaire rentrée pour comparer au mot de passe
    $req -> execute($val);

    $enreg = $req -> fetchall();

    $req -> closeCursor();

    if (!$enreg) {
        header("Location: connexion.php?msg=wrong");
    }

        //ensuite, on convertit le mot de passe en hash et on fait une simple if égalité
    if ($enreg[0]["password"] == hash("sha256", $_POST["mdp"])) {
        session_start();
        $_SESSION["logged"] = TRUE;
        $_SESSION["name"] = $enreg[0]["name"];
        $_SESSION["username"] = $enreg[0]["username"];
            //variables de session pour le nom, pseudo pour les posts, et log, pour ne pas kick l'utilisateur
        header("Location: index.php");
        exit();
    } else {
        header("Location: connexion.php?msg=wrong");
        exit();
    }
?>

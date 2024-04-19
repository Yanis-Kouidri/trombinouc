<?php
session_start();

include "./Outils/base.php";
include "./Outils/fonctions.php";

// Validation de session et redirection si non connecté
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    //debug($_SESSION);
    header('Location: ./connexion.php?msg=nonco');
    exit();
}

// Validation de l'utilisateur
if (isset($_GET["usr"]) ) {
    if ($_GET["usr"] == $_SESSION["username"]) {
        $targetUser = "me";
    }
    $targetUser = $_GET["usr"];
} else {
    header('Location: ./profil.php?usr=me');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include './Includes/head.html'; ?>
    <title>Profil</title>
</head>
<body>
    <?php include './Includes/nav.html'; ?>

    <?php
    if ($targetUser === "me") {
        displayUserProfile($_SESSION["username"], $dbConnection);
    } else if (empty($targetUser)) {
        echo "<p>After all, the cake was a lie...</p>";
    } else {
        displayUserProfile($targetUser, $dbConnection);
    }
    ?>

</body>
</html>


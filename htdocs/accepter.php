<?php
    session_start();
    include("./Outils/base.php");

    $sql = "UPDATE FRIENDS SET pending = 0 WHERE user1 = '".$_POST['ami']."' AND user2 = '".$_SESSION['username']."'";

    $req = $dbConnection->prepare($sql);
    
    $req -> execute();

    $req -> closeCursor();

    header("Location: profil.php?usr=me");
    exit();
?>

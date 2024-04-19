<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('./Includes/head.html'); ?>
    <title>Connexion</title>
</head>
<body>
    <header>
        <p>Connexion à Trombinouc !</p>
        <?php include('./Includes/nav.html'); ?>
    </header>

    <section>
        <h1>Connectez vous !</h1>

        <form method="POST" action="connecte.php">

                <?php
                    if ($_GET) {
                        if ($_GET["msg"] == "wrong") {
                            echo "<p><strong>Mauvais nom d'utilisateur ou mot de passe.</strong></p>";
                        }
    
                        if ($_GET["msg"] == "nonco") {
                            echo "<p><strong> Vous devez être connecté pour acceder à la page précédente </strong></p>"; // Message affiché si l'utilisateur tente de d'acceder à la page ami par exemple, sans être connecté.
                        }
                    }

                ?>
            <p>
                <label for="login">Nom d'utilisateur</label>
			    <input id="login" name="login" type="text" maxlength="20" minlength="4"  required />
			</p>

            <p>
                <label for="mdp">Mot de passe</label>
			    <input id="mdp" name="mdp" type="password" maxlength="20" minlength="4"  required />
            </p>

            <p>
                <button id="envoi" name="envoi" type="submit" value="envoi">Se connecter</button>
            </p>

        </form>
    </section>

</body>
</html>

<!DOCTYPE HTML>
<html>
	<head>
		<?php include('./Includes/head.html'); ?>
		<title>Inscription</title>
	</head>
	<body>
		<!-- L'en-tête -->
		<header>
			<p>Bienvenue sur Trombinouc !</p>
			<?php include('./Includes/nav.html'); ?>
		</header>
				
		<!-- Le contenu (1 seule section suffit) -->		
		<section>
			<h1>Création d'un nouveau compte</h1>
			<p>Veuillez remplir les champs suivant :</p>
			<form id="sign-up" method="POST" action="./inscri.php"> <!-- la méthode d'envoi est POST et c'est envoyé à ./inscri.php -->

				<p>	
					<label for="prenom"> Prénom </label> 	
					<input id="prenom" name="prenom" type="text" maxlength="30" required autofocus />
				</p>

				<p>	
					<label for="nom"> Nom de famille </label> 	
					<input id="nom" name="nom" type="text" maxlength="30" required />
				</p>
<?php
	if ($_GET && $_GET['msg'] == 'taken' ){
		echo "<p> <strong> Le nom d'utilisateur existe déjà, merci d'en choisir un autre. </strong> </p>";
	}
?>


				<p>	<label for="login">Nom d'utilisateur</label> <!-- doit être unique pour permettre l'autentificaton -->
					<input id="login" name="login" type="text" maxlength="20" minlength="4"  required /> <!-- entre 4 et 20 caractères -->	
				<p id="login-note"> Le nom d'utilisateur vous permettera de vous authentifier une fois votre compte créé, par défaut, il n'apparait pas sur votre profil. </p>
				</p> <!-- il faudra vérifier que ce login n'existe pas déjà -->



				<p>	
					<label for="mail"> E-mail </label> 	
					<input id="mail" name="mail" type="text" maxlength="50" />
				</p>


<?php
	if ($_GET && $_GET['msg'] == 'mdpdiff' ){
		echo "<p> <strong> Les mots de passe doivent être identiques. </strong> </p>";
	}
?>
				
				<p>	
					<label for="mdp"> Mot de passe </label> <!-- Label permet de légender la case mot de passe -->	
					<input id="mdp" name="mdp" type="password" maxlength="20" minlength="6" required />
				</p>

				<p>	
					<label for="mdp2"> Confirmer le mot de passe </label> <!-- Label permet de légender la case mot de passe -->	
					<input id="mdp2" name="mdp2" type="password" maxlength="20" minlength="6" required />
				</p>

				<p>	Indiquez votre date de naissance : <br> 
					<label for="jour"> </label> 	
					<select name="jour" id="jour" required>
						<option value=""> Jour </option>
						<?php
							for ($i=1 ; $i<=31 ; $i++) {
								echo '<option value="'.$i.'"> '.$i.' </option> ' ;
							}
						?>
					</select>


					<label for="mois"> </label> 	
					<select name="mois" id="mois" required>
						<option value=""> Mois </option>
						<?php
							for ($i=1 ; $i<=12 ; $i++) {
								echo '<option value="'.$i.'"> '.$i.' </option> ' ;
							}
						?>
					</select>
			

					<label for="annee"> </label> 	
					<select name="annee" id="annee" required>
						<option value=""> Année </option>
						<?php
							for ($i=date("Y") ; $i>=1900 ; $i--) { //date(Y) renvoi l'année courante sur complète, alors que date(y) renvoie juste le 2 dernier chiffres 
								//A priori personne n'est né avant 1900 et encore vivant aujourd'hui
								echo '<option value="'.$i.'"> '.$i.' </option> ' ;
							}
						?>
					</select>
				</p>
				
				<p id="sexe">Sexe : </p>

					<label for="homme"> Homme </label>
					<input type="radio" id="homme" name="genre" value="homme" >

					<label for="femme"> Femme </label>
					<input type="radio" id="femme" name="genre" value="femme" >
				</p>

				<p>	
					<button id="envoi" name="envoi" type="submit" value="envoi"> S'inscrire </button> 
				</p>
			</form>
		</section>
	</body>
</html>

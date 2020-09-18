<?php
// On inclut le "connecteur" à la bdd
include_once("inc/connexion.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// On teste si une session de 'User' est déjà active
if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
   header("Location:index.php?Message=0");
   exit;
   // tu t'en vas de là tu es déjà connecté donc tu retournes à l'accueil
   // et plus vite que çà hop hop hop !!...
}   

// On va vérifier qu'on a reçu des données
if(isset($_POST) && !empty($_POST)){
	//Ici $_POST existe et n'est pas vide
	// on crée les variables seulement maintenant, inutile si on ne va pas jusque là de toute façon
	$mail_user = $_POST['mail'];
	$pass_user = $_POST['pass'];
	// On vérifie que TOUS les champs obligatoires existent
	if(
		isset($mail_user) && !empty($mail_user) && 
		isset($pass_user) && !empty($pass_user)){
		// Ici tous les champs obligatoires sont remplis

		if (filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
			// On teste la validité du champ email

			if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$#', $_POST['pass'])) {
				// Ici le mot de passe est conforme au regex demandé

				// On ajoute une entrée dans la table en utilisant un 'marqueur' dans la préparation de la requête
				$login_user = $bdd->prepare('SELECT nom, password FROM user WHERE mail = :mail');
				// On l'exécute en passant la valeur du marqueur :mail dans un tableau
				$login_user->execute(array('mail' => $mail_user));
				$user = $login_user->fetch();

					// On compte le nombre de lignes affectées par la requête si il est égal à 0 c'est que la requête
					// ne s'est pas exécutée correctement et l'on gère le message à afficher sur la page en fonction des cas
				if ($login_user->rowCount()) {
					// password_verify — Vérifie qu'un mot de passe correspond à un hachage
					if (password_verify ($pass_user, $user['password'])) {
					// Ici le mot de passe est le bon

						// On mémorise le nom d'utilisateur dans la session
						// et on retourne à l'accueil
						$_SESSION['user_name'] = $user['nom'];
						header("Location:index.php");
					} else {
					// Ici on a pas le bon mot de passe	
					header("Location:index.php?Message=1");
					}
				} else {
					// Ici on a pas trouvé le mail dans la BDD
					header("Location:index.php?Message=2");
				}	
			} else {
				// Ici le mot de passe est invalide dans son format
				header("Location:index.php?Message=6");
			}	
		} else {
			// Ici le format de l'email est non valide
			header("Location:index.php?Message=5");
		}
	} else {
		// Ici il y a une erreur sur les champs remplis
		header('Location:index.php?Message=3');
	}
} else {
	// Ici $_POST n'existe pas ou est vide
	header('Location:index.php?Erreur=4');
}
?>
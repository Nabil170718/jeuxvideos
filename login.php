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
   
}   

// On va vérifier qu'on a reçu des données
if(isset($_POST) && !empty($_POST)){
	
	$mail_user = $_POST['mail'];
	$pass_user = $_POST['pass'];
	
	if(
		isset($mail_user) && !empty($mail_user) && 
		isset($pass_user) && !empty($pass_user)){
		

		if (filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
			

			if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$#', $_POST['pass'])) {
				

				// On ajoute une entrée dans la table en utilisant un 'marqueur' dans la préparation de la requête
				$login_user = $bdd->prepare('SELECT nom, password FROM user WHERE mail = :mail');
				// On l'exécute en passant la valeur du marqueur :mail dans un tableau
				$login_user->execute(array('mail' => $mail_user));
				$user = $login_user->fetch();

					
				if ($login_user->rowCount()) {
					
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
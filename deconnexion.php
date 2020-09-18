<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// On teste si une session de 'User' est active
if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
	// Si oui on l'efface
	unset($_SESSION['user_name']);
	session_destroy();
}
// On retourne à l'accueil
header("Location:index.php?");
exit;    
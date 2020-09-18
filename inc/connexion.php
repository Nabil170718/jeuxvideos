<?php
// PDO veut dire PHP Data Object et c'est un
// ORM (object-relational mapping) un 'programme' qui se place en interface entre PHP et la base de données relationnelle

// Connexion à la base de données
// host=serveur, dbname=nom de la base, charset=type d'encodage, root'= nom d'utilisateur, ''= mot de passe
try { $bdd = new PDO('mysql:host=localhost;dbname=console;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //pour afficher les erreur sql (uniquement en dev, pas en prod)
    // echo "Connecté à la base";
}
catch (Exception $e) { echo $e->getMessage(); }
// Si le try échoue, on capture l'erreur et on l'affiche

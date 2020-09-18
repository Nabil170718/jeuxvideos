<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (isset($_GET['Message'])) { header("refresh: 4; url=index.php"); }    
    // On teste si une session de 'User' est déjà active
    // Si oui on affiche le message de bienvenue et le bouton de déconnection
    if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
        echo '<a href="deconnexion.php"><button>DECONNEXION</button></a>'.
            '<span style="color: blue">  Bonjour <strong><i>'.
            $_SESSION['user_name'].
            '</i></strong></span>';
    }
?>

<!DOCTYPE html>

<html lang="FR">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>

<body>
    <p><u><strong>ENTREZ VOS INFOS DE CONNEXION</strong></u> :</strong></p>
    <form action="login.php" method="post">
        <p>
        <label for="mail">Votre Email : </label>
        <input type="email" name="mail" /><br><br>
        <label for="pass">Votre mot de passe : </label>   
        <input type="password" name="pass" />
        <p><i>(8 caractères minimum avec au moins une lettre en majuscule et minuscule, un chiffre et un caractère spécial)</i></p>  
        <input type="submit" value="Valider" />
        </p>
    </form>

<p style="color: red">
<?php
// On traite les retours de login.php en 'GET' pour afficher le message adapté
if (isset($_GET['Message'])) {
   switch ($_GET['Message']) {
        case '0':
            echo 'Vous devez vous déconnecter d\'abord !!';
            unset($_GET['Message']);
           break;
        case '1':
            echo 'Mauvais mot de passe';
            unset($_GET['Message']);            
           break;
        case '2':
            echo 'Compte inconnu';
            unset($_GET['Message']);            
           break;
        case '3':
            echo 'Erreur dans les champs';
            unset($_GET['Message']);            
           break;
        case '4':
            echo 'Aucune donnée reçue';
            unset($_GET['Message']);            
            break;
        case '5':
            echo 'l\'email est invalide';
            unset($_GET['Message']);            
            break;
        case '6':
            echo 'Format de mot de passe invalide';
            unset($_GET['Message']);            
            break;             
        case '7':
            echo '!! Merci vous êtes bien enregistré !!';
            unset($_GET['Message']);            
            break; 
       default:
           break;
   }
}?>
<hr>
</p>

    <p>
        <u><strong>Nouvel Utilisateur :</strong></u>
        <a href="inscription.php"> Cliquez-ici</a>
    </p>

</body>
</html>
<?php 
session_start(); // Assurez-vous que session_start() est appelé au début du script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $email_input = $mysqli->real_escape_string($_POST["email"]);
    $sql = sprintf("SELECT * FROM user WHERE email='%s'", $email_input);
    $result = $mysqli->query($sql);
    if ($result) {
        // Vérifiez s'il y a des lignes correspondantes
        if (mysqli_num_rows($result) > 0) {
            $user = $result->fetch_assoc();
            
            // Utilisez password_verify() pour vérifier le mot de passe
            if (password_verify($_POST["pswd"], $user["password_hash"])) {
                // Stocker l'ID de l'utilisateur dans la session
                $_SESSION["user_id"] = $user["id"];

                // Vérifier si l'utilisateur est un administrateur (ajuster le champ admin dans la base de données)
                if ($user['email'] == "admin@gmail.com") {
                    $_SESSION['admin_name'] = $user['email'];
                    header('location:parametre.html');
                    exit;
                } else {
                    // L'utilisateur n'est pas un administrateur, faire ce que vous devez faire pour un utilisateur non-administrateur
                    // Par exemple, rediriger vers une autre page pour les utilisateurs normaux
                    header('location: acceuil.html');
                    exit;
                }
            } else {
                // Mot de passe incorrect
               
                echo '<p style="color: red;">Mot de passe incorrect</p>';
            }
        } else {
            // Aucun utilisateur trouvé avec cet e-mail
            die("Aucun utilisateur trouvé avec cet e-mail");
        }
    } else {
        // Erreur dans la requête SQL
        die("Erreur dans la requête SQL: " . $mysqli->error);
    }
}
?>

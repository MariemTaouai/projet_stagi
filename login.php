<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $email_input = $_POST["email"];
    $sql = "SELECT * FROM user WHERE email=?";
    $stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email_input);
$stmt->execute();
$result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            //recep les donnes de user
            $user = $result->fetch_assoc();
            if (password_verify($_POST["pswd"], $user["password_hash"])) {
                if ($user['email'] == "admin@gmail.com") {
                    header('Location: parametre.html');
                    exit;
                } else {
                    header('Location: acceuil.html');
                    exit;
                }
            } else {
                echo '<p style="color: red;">Mot de passe incorrect</p>';
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet e-mail";
        }
    } else {
        echo "Erreur dans la requête SQL: " . $mysqli->error ;
    }
}
?>

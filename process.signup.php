<?php

if (empty($_POST["name"])) {
    echo "NAME IS REQUIRED";
} elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "INVALID EMAIL ADDRESS";
} elseif (strlen($_POST["pswd"]) < 8) {
    echo "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
} elseif (!preg_match("/[a-z]/i", $_POST["pswd"])) {
    echo "Password must contain at least one letter";
} elseif (!preg_match("/[0-9]/", $_POST["pswd"])) {
    echo "Password must contain at least one number";
} elseif ($_POST["pswd"] !== $_POST["pswd1"]) {
    echo "Verify your confirmation password";
} else {
    $mysqli = require __DIR__ . "/database.php";

    // Vérifier lexistance de l'e-mail 
    $email = $_POST["email"];
    $email_sql = "SELECT COUNT(*) FROM user WHERE email = ?";
    $check_stmt = $mysqli->prepare($email_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->bind_result($email_count);
    $check_stmt->fetch();//recep res et stocker au var co

    if ($email_count > 0) {
        echo "Cet e-mail est déjà utilisé.";
    } else {
        $name = $_POST["name"];
        $password = $_POST["pswd"];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_sql);

        if (!$insert_stmt) {
            die("Erreur SQL: " . $mysqli->error);
        }

        $insert_stmt->bind_param("sss", $name, $email, $password_hash);
        $insert_stmt->execute();

        if ($insert_stmt->affected_rows > 0) {
            echo "Inscription réussie!";
        } else {
            echo "Une erreur s'est produite lors de l'inscription.";
        }
    }
}

?>

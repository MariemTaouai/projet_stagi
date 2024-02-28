<?php

if (empty($_POST["name"])) {
    die("NAME IS REQUIRED");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("INVALID EMAIL ADDRESS");
}

if (strlen($_POST["pswd"]) < 8) {
    die("PASSWORD MUST BE AT LEAST 8 CHARACTERS");
}

if (!preg_match("/[a-z]/i", $_POST["pswd"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["pswd"])) {
    die("Password must contain at least one number");
}

if ($_POST["pswd"] !== $_POST["pswd1"]) {
    die("Verify your confirmation password");
}

// Récupérer les données du formulaire POST
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["pswd"];

// Hasher le mot de passe
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Assurez-vous que la connexion à la base de données est établie
$mysqli = require __DIR__ . "/database.php";

// Préparer la requête SQL pour l'insertion
$sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";

// Initialiser une nouvelle instruction préparée
$stmt = $mysqli->stmt_init();

// Vérifier si la préparation de la requête a réussi
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Lier les paramètres à la requête préparée
$stmt->bind_param("sss", $name, $email, $password_hash);

// Exécuter la requête
$stmt->execute();

// Vérifier si l'inscription a réussi
if ($stmt->affected_rows > 0) {
    echo "Inscription réussie!";
} else {
    echo "ce email deja utilise";
}

// Fermer l'instruction préparée
$stmt->close();

// Fermer la connexion à la base de données
$mysqli->close();
?>

<?php
$mysqli = require __DIR__ . "/database.php";

// Fonction pour envoyer un e-mail
function envoyerNotification($destinataire, $sujet, $message) {
    mail($destinataire, $sujet, $message);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $requeteEmails = "SELECT email FROM user";
    $resultatEmails = $mysqli->query($requeteEmails);

    if ($resultatEmails) {
        while ($row = $resultatEmails->fetch_assoc()) {
            $emailUtilisateur = $row['email'];
            $sujetNotification = "Modification effectuée sur STAGI";
            $messageNotification = "Cher utilisateur, une modification a été effectuée sur STAGI. Consultez le site pour plus de détails.";

            envoyerNotification($emailUtilisateur, $sujetNotification, $messageNotification);
        }

    } else {
        echo "Erreur lors de la récupération des e-mails des utilisateurs : " . $mysqli->error;
    }

}
?>


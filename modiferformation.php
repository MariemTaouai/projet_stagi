<?php
// Inclure le fichier de connexion
$mysqli = require __DIR__ . "/database.php";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $ancienNomFormation = $_POST['nomFormation'];
    $nouveauNomFormation = $_POST['nouveauFormation'];
    $nouveauLien = $_POST['nouveauLien'];
    $nouvellePhotoFormation = $_FILES['photo']['name'];
// Vérifier si le nom de fichier à modifier existe
$verifRequete = "SELECT libelle FROM formation WHERE libelle = ?";
$verifStmt = $mysqli->prepare($verifRequete);
$verifStmt->bind_param("s", $ancienNomFormation);
$verifStmt->execute();
$verifStmt->store_result();

if ($verifStmt->num_rows === 0) {
    echo "Erreur : Le nom de la formation à modifier n'existe pas.";
    exit;
}
    // Vérifier si un nouveau fichier a été téléchargé
    $nouvellePhotoFormation = "";
    if ($_FILES['product_image']['error'] === 0) {
        // Vérifier et déplacer le fichier téléchargé
        $uploadDir = __DIR__ . "/assets1/";
        $nouveauNomFichier = basename($_FILES['product_image']['name']);
        $nouveauCheminFichier = $uploadDir . $nouveauNomFichier;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $nouveauCheminFichier)) {
            $nouvellePhotoFormation = $nouveauNomFichier;
        } else {
            echo "Erreur lors du téléchargement du fichier.";
            exit;
        }
    }

    // Requête UPDATE pour modifier la formation
    $requete = "UPDATE formation SET libelle = ?, lien = ?";
    // Ajouter la colonne photo à la requête si une nouvelle photo est fournie
    if (!empty($nouvellePhotoFormation)) {
        $requete .= ", product_image = ?";
    }
    $requete .= " WHERE libelle = ?";

    $stmt = $mysqli->prepare($requete);

    // Vérifier si la préparation de la requête a réussi
    if ($stmt) {
        // Liaison des paramètres
        $stmt->bind_param("sss", $nouveauNomFormation, $nouveauLien, $ancienNomFormation);
        // Ajouter la liaison pour la colonne photo si une nouvelle photo est fournie
        if (!empty($nouvellePhotoFormation)) {
            $stmt->bind_param("sss", $nouvellePhotoFormation, $nouveauNomFormation, $nouveauLien, $ancienNomFormation);
        }

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "La formation a été modifiée avec succès.";
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        }

        // Fermeture du statement
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $mysqli->error;
    }

    // Fermeture de la connexion
    $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="modifform.css">
    <title>STAGI</title>
</head>
<body>
<form  method="post" enctype="multipart/form-data">
    <div class="cadre">
      <div >
        <div class="col-md-8 ">
              <h1>MODIFIER UNE FORMATION</h1>
  <input type="text" id="formation" name="nomFormation" placeholder="Ecrire le nom de  formation à modifier "><br><br>
  <input type="text" id="formation" name="nouveauFormation" placeholder="Ecrire le nouveau nom  "><br><br>
  <input type="text" id="formation" name="nouveauLien" placeholder="Ecrire le nouveau lien "><br><br>
  <label for="photo">Sélectionnez une nouveau  photo :</label>
    <input type="file" id="photo" name="photo" accept="image/*">
  <div class="butt">
  <button type="submit" class="btn btn-danger">modifier</button>
  <a href="courses.php">voir la page courses</a>
  </div>
</div>
      

<footer class="footer">
    STAGI © 2024 mariem TAOUAI, Inc. Tous droits réservés.
</footer>
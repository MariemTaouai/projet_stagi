<?php
$mysqli = require __DIR__ . "/database.php";

if (isset($_POST["nomFormation"] )){
    $ancienNomFormation = $_POST['nomFormation'];
    $nouveauNomFormation = $_POST['nouveauFormation'];
    $nouveauLien = $_POST['nouveauLien'];
    $nouvellePhotoFormation = $_FILES['photo']['name'];

  //verification de lexistance de form
    $verifRequete = "SELECT libelle FROM formation WHERE libelle = ?";
    $verifStmt = $mysqli->prepare($verifRequete);
    $verifStmt->bind_param("s", $ancienNomFormation);
    $verifStmt->execute();
    $verifResult = $verifStmt->get_result();
    if ($verifResult->num_rows === 0) {
        echo "Erreur : Le nom de la formation à modifier n'existe pas.";
        exit;
    }
ELSE{
    $requete = "UPDATE formation SET libelle = ?, lien = ? ,product_image = ? WHERE libelle = ?";
   
    $stmt = $mysqli->prepare($requete);


    if ($stmt) {
       
            $stmt->bind_param("ssss", $nouveauNomFormation, $nouveauLien, $nouvellePhotoFormation, $ancienNomFormation);
            
        }

    
        if ($stmt->execute()) {
            echo "La formation a été modifiée avec succès.";
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        }

        
    } 
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
    <form method="post" enctype="multipart/form-data">
        <div class="cadre">
            <div>
                <div class="col-md-8">
                    <h1>MODIFIER UNE FORMATION</h1>
                    <input type="text" id="formation" name="nomFormation" placeholder="Ecrire le nom de la formation à modifier"><br><br>
                    <input type="text" id="formation" name="nouveauFormation" placeholder="Ecrire le nouveau nom"><br><br>
                    <input type="text" id="formation" name="nouveauLien" placeholder="Ecrire le nouveau lien"><br><br>
                    <label for="photo">Sélectionnez une nouvelle photo :</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <div class="butt">
                        <button type="submit" class="btn btn-danger">modifier</button>
                        <a href="courses.php">voir la page courses</a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            STAGI © 2024 mariem TAOUAI, Inc. Tous droits réservés.
        </footer>
    </form>
</body>
</html>

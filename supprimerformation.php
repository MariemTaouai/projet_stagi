<?php
$mysqli = require __DIR__ . "/database.php";

if (isset($_POST["nomFormation"] )) {
    
    $nomFor = $_POST['nomFormation'];
    $verif = "SELECT COUNT(*) FROM formation WHERE libelle = ?";
    $verifStmt = $mysqli->prepare($verif);

    // requête a reussi
    if ($verifStmt) {
        $verifStmt->bind_param("s", $nomFor);
        $verifStmt->execute();
        $verifStmt->bind_result($count);//stcker  var count
        // Recup du resultat de count
        $verifStmt->fetch();
        $verifStmt->close();
      
        // formation existe avant suppri
        if ($count > 0) {
            $requete = "DELETE FROM formation WHERE libelle = ?";
            $stmt = $mysqli->prepare($requete);
            if ($stmt) {
                // Liaison 
                $stmt->bind_param("s", $nomFor);
                if ($stmt->execute()) {
                    echo "La formation a été supprimée avec succès.";
                } else {
                    echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
                }

             
            } 
        } else {
            echo '<span style="color: red;">La formation avec le nom ' . $nomFor . ' n\'existe pas.</span>';

        }
    } 

    
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="suppfor.css">
    <title>STAGI</title>
</head>
<body>



  <form  method="post" enctype="multipart/form-data">
    <div class="cadre">
      <div >
        <div class="col-md-8 ">
              <h1>SUPPRIMER UNE FORMATION</h1>
  <input type="text" id="formation" name="nomFormation" placeholder="Ecrire le nom de  formation à supprimer "><br><br>
  <div class="butt">
  <button type="submit" class="btn btn-danger">Supprimer</button>
  <a href="courses.php">voir la page courses</a>
  </div>
</div>
      

<footer class="footer">
    STAGI © 2024 mariem TAOUAI, Inc. Tous droits réservés.
</footer>





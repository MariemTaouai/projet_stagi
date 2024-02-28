<!--
// ajout_formation.php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

// Traitement du formulaire d'ajout de formation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que le formulaire a été soumis
    if (isset($_POST["libelle"]) && isset($_POST["lien"])) {
        // Récupérez les valeurs du formulaire
        $libelle = $_POST["libelle"];
        $url = $_POST["URL"];
        $lien=$_POST["lien"];
       
// Traitement du fichier téléchargé
if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
  $photo_name = $_FILES["photo"]["name"];
  $photo_tmp_name = $_FILES["photo"]["tmp_name"];
  move_uploaded_file($photo_tmp_name, "chemin/vers/votre/dossier/$photo_name");
  $lien = "chemin/vers/votre/dossier/$photo_name";
} else {
  // Gérez ici le cas où le téléchargement de la photo a échoué
  $lien = "";
}
        // Vous pouvez ici ajouter le code pour enregistrer ces données dans votre base de données, par exemple :
        $mysqli = require __DIR__ . "/database.php";

        // Vérifier si une formation avec le même libellé existe déjà
        $check_sql = "SELECT * FROM formation WHERE libelle = ? ";
        $check_stmt = $mysqli->prepare($check_sql);
        $check_stmt->bind_param("s", $libelle);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // La formation avec le même libellé existe déjà
            echo "Une formation avec ce libellé existe déjà. Veuillez choisir un autre libellé.";
        } else {
            // La formation n'existe pas encore, vous pouvez procéder à l'insertion
            $insert_sql = "INSERT INTO formation (libelle, url,lien) VALUES (?, ?,?)";
            $insert_stmt = $mysqli->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $libelle, $url,$lien);
            $insert_stmt->execute();

            if ($insert_stmt->affected_rows > 0) {
                echo "Formation ajoutée avec succès!";
                $new_formation_id = $insert_stmt->insert_id;
                header("Location: courses.php");
                exit;
            } else {
                echo "Erreur lors de l'ajout de la formation.";
            }

            // Fermer l'instruction préparée d'insertion
            $insert_stmt->close();
        }

        // Fermer l'instruction préparée de vérification
        $check_stmt->close();

        // Fermer la connexion à la base de données
        $mysqli->close();
    }
}
?>
-->
<?php 

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["libelle"]) && isset($_POST["URL"])) {
        $libelle = $_POST["libelle"];
        $lien = $_POST["URL"];
        $product_image = $_FILES['photo']['name'];
        $product_image_tmp_name = $_FILES['photo']['tmp_name'];

        $product_image_folder = __DIR__ . '/assets1/' . $product_image;

        if (empty($libelle) || empty($lien) || empty($product_image)) {
            echo '<p style="color: red;">Veuillez remplir tous les champs.</p>';
        } else {
            $check_sql = "SELECT * FROM formation WHERE libelle = ?";
            $check_stmt = $mysqli->prepare($check_sql);
            $check_stmt->bind_param("s", $libelle);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                echo '<p style="color: red;">Une formation avec le même libellé existe déjà. Veuillez choisir un autre libellé.</p>';
            } else {
                $insert_sql = "INSERT INTO formation (libelle, lien,product_image ) VALUES (?, ?, ?)";
                $insert_stmt = $mysqli->prepare($insert_sql);
                $insert_stmt->bind_param("sss", $libelle, $lien, $product_image);

                if ($insert_stmt->execute()) {
                    move_uploaded_file($product_image_tmp_name, $product_image_folder);
                    echo '<p style="color: green;">Nouvelle formation ajoutée avec succès!</p>';
                } else {echo '<p style="color: red;">Impossible d\'ajouter la formation!</p>'
                    ;
                }

                $insert_stmt->close();
            }

            $check_stmt->close();
        }
    } else {
        echo '<p style="color: red;">Veuillez fournir des valeurs pour libelle et URL.</p>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="modifform.css">
</head>
<body>
 
      <br><br><br>
      <form  method="post" enctype="multipart/form-data">
     
    <div class="cadre">
        <div class="col-md-8 ">
              <h1>AJOUTER  UNE FORMATION</h1>
  <input type="text" id="formation" name="libelle" placeholder="Ecrire un  nom de  formation"><br><br>
  <input type="text" id="formation" name="URL" placeholder="Ecrire le lien de site"><br><br>

  <div class="butt">
  <label for="photo">Sélectionnez une photo :</label>
    <input type="file" id="photo" name="photo" accept="image/*">

        <br>

          <button type="submit" class="btn btn-success" name="rechercher">Add</button>
          <a href="courses.php">voir la page courses</a>
  </div>
        </div>
    
  </div>
      </form>
      

<footer class="footer">
    STAGI © 2024 mariem TAOUAI, Inc. Tous droits réservés.
</footer>
 
      </div>
    </div>
  </div>
  
</body>
</html>

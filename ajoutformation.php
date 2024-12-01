
<?php 

$mysqli = require __DIR__ . "/database.php";


    if (isset($_POST["libelle"]) ) {
        $libelle = $_POST["libelle"];
        $lien = $_POST["URL"];
        $product_image = $_FILES['photo']['name'];
                                                    

        if (empty($libelle) || empty($lien) || empty($product_image)) {
            echo '<p style="color: red;"> Veuillez remplir tous les champs.</p>';
        } else {
            $check_sql = "SELECT * FROM formation WHERE libelle = ?";
            $check_stmt = $mysqli->prepare($check_sql); 
            $check_stmt->bind_param("s", $libelle);
            //insert valeurs saisies dans le form aux bons endroits 
            //dans votre requête SQL
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result->num_rows > 0) {
                echo '<p style="color: red;"> Une formation avec le même libellé existe déjà. Veuillez choisir un autre libellé.</p>';
            } else {
                $insert_sql = " INSERT INTO formation (libelle, lien,product_image ) VALUES (?, ?, ?)";
                $insert_stmt = $mysqli->prepare($insert_sql);
                $insert_stmt->bind_param("sss", $libelle, $lien, $product_image);//liaison entre les valeurs  insérer dans bdd et 
                //lesespaces réservés dans votre requête SQL.

                if ($insert_stmt->execute()) {
                    echo '<p style="color: green;">Nouvelle formation ajoutée avec succès!</p>';
                }
                 else {echo '<p style="color: red;">Impossible d\'ajouter la formation!</p>'
                    ;
                }

              
            }

        
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

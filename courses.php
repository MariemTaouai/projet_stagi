<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="coursesS123.css">
    <title>STAGI</title>
</head>

<body>

    <!-- Bouton pour ajouter une formation -->
    <form method="POST" action="">
    <div class="hero">
        <nav>
            <ul>
                <li><a href="acceuil.html">ACCEUIL</a></li>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="stage.html">STAGE</a></li>
                <li><a href="courses.php">COURSES</a></li>
            </ul>
            <div class="imagee">
                <img src="assets1/Logoo ulistrator2.png" alt="Logo">
            </div>

            <div class="container">
                <a href="login.html" class="btn">Inscrire</a>
            </div>
        </nav>
    </div>
    <a class="skip-link screen-reader-text" href="#content">Skip to content</a>

    <header class="masthead">
        <h1>Les meilleurs sites web des formations</h1>
        <div class="intro">
        <div class="search-form">
     <!-- Le même fichier courses.php pour traiter la recherche -->
        <label for="search-input">Rechercher par libellé : </label>
        <input type="text" id="search-input" name="search" placeholder="Entrez le libellé">
        <button type="submit">Rechercher</button>
    
</div>
            <p><b><span>"STAGI"</span> mettre à disposition une diversité d'opportunités de formation, garantissant à nos utilisateurs l'accès aux dernières avancées technologiques et aux tendances émergentes du secteur. Notre volonté première est de créer un environnement d'apprentissage dynamique, propice à l'amélioration continue des compétences, à l'exploration de nouvelles technologies et à la préparation en vue d'une carrière fructueuse dans le domaine de l'informatique.</b></p>
        </div>
      
    </header><!-- .masthead -->
</form>
    <?php
// Connexion à la base de données
$mysqli = require __DIR__ . "/database.php";

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    // Récupérez la valeur de recherche
    $search = mysqli_real_escape_string($mysqli, $_POST["search"]);

    // Requête SQL pour rechercher les formations par libellé
    $query = "SELECT * FROM formation WHERE libelle LIKE '%$search%'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        // Affichez les résultats de la recherche
        echo '<main id="content" class="main-area">
                <ul class="cards">';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="card-item ">
                    <a href="' . $row['lien'] . '" target="_blank" rel="nofollow">
                        <figure class="card">
                            <img src="assets1/' . $row['product_image'] . '" alt="Card image ">
                            <figcaption class="caption">
                                <h3 class="caption-title">' . $row['libelle'] . '</h3>
                            </figcaption>
                        </figure>
                    </a>
                </li>';
        }

        echo '</ul>
            </main>';
    } else {
        // Aucun résultat trouvé
        echo '<main id="content" class="main-area">
                <p>Aucune formation trouvée pour le libellé "' . $search . '".</p>
              </main>';
    }
} else {
    // Le formulaire n'a pas été soumis ou aucune recherche n'a été spécifiée
    // Affichez toutes les formations normalement
    echo '<main id="content" class="main-area">
            <ul class="cards">';

    $req3 = mysqli_query($mysqli, "SELECT * FROM formation ");
    if (mysqli_num_rows($req3) > 0) {
        while ($row = mysqli_fetch_assoc($req3)) {
            echo '<li class="card-item ">
                    <a href="' . $row['lien'] . '" target="_blank" rel="nofollow">
                        <figure class="card">
                            <img src="assets1/' . $row['product_image'] . '" alt="Card image ">
                            <figcaption class="caption">
                                <h3 class="caption-title">' . $row['libelle'] . '</h3>
                            </figcaption>
                        </figure>
                    </a>
                </li>';
        }
    } else {
        // Aucune formation trouvée dans la base de données
        echo '<p>Aucune formation disponible actuellement.</p>';
    }

    echo '</ul>
          </main>';
}
?>

<footer class="footer">
    STAGI © 2024 mariem TAOUAI, Inc. Tous droits réservés.
</footer>



  </ul>
</main>





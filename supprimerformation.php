<?php
// Inclure le fichier de connexion
$mysqli = require __DIR__ . "/database.php";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération de l'ID de la formation à supprimer
    $nomFor = $_POST['nomFormation'];

    // Requête SELECT pour vérifier si la formation existe
    $verifRequete = "SELECT COUNT(*) FROM formation WHERE libelle = ?";
    $verifStmt = $mysqli->prepare($verifRequete);

    // Vérifier si la préparation de la requête a réussi
    if ($verifStmt) {
        // Liaison du paramètre
        $verifStmt->bind_param("s", $nomFor);

        // Exécution de la requête
        $verifStmt->execute();

        // Liaison du résultat
        $verifStmt->bind_result($count);

        // Récupération du résultat
        $verifStmt->fetch();

        // Fermeture du statement de vérification
        $verifStmt->close();

        // Vérifier si la formation existe avant de la supprimer
        if ($count > 0) {
            // Requête DELETE pour supprimer la formation en utilisant une déclaration préparée
            $requete = "DELETE FROM formation WHERE libelle = ?";
            $stmt = $mysqli->prepare($requete);

            // Vérifier si la préparation de la requête a réussi
            if ($stmt) {
                // Liaison du paramètre
                $stmt->bind_param("s", $nomFor);

                // Exécution de la requête
                if ($stmt->execute()) {
                    echo "La formation a été supprimée avec succès.";
                } else {
                    echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
                }

                // Fermeture du statement
                $stmt->close();
            } else {
                echo "Erreur lors de la préparation de la requête : " . $mysqli->error;
            }
        } else {
            echo '<span style="color: red;">La formation avec le nom ' . $nomFor . ' n\'existe pas.</span>';

        }
    } else {
        echo "Erreur lors de la préparation de la requête de vérification : " . $mysqli->error;
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
    <link rel="stylesheet" href="suppfor.css">
    <title>STAGI</title>
</head>
<body>

<!---
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>

<header class="masthead">
  <h1 >
    les meilleurs sites web des formations</h1>
  <div class="intro"><p><b><span> "STAGI"</span>  mettre à disposition une diversité d'opportunités de formation, garantissant à nos utilisateurs l'accès aux dernières avancées technologiques et aux tendances émergentes du secteur. Notre volonté première est de créer un environnement d'apprentissage dynamique, propice à l'amélioration continue des compétences, à l'exploration de nouvelles technologies et à la préparation en vue d'une carrière fructueuse dans le domaine de l'informatique.

</b></p>
  </div>
</header>

<main id="content" class="main-area">
  <ul class="cards">
    <li class="card-item ">
     <a href="https://www.kaggle.com/learn" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://www.actuia.com/wp-content/uploads/2022/11/Kaggle_logo.png" alt="Beach. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">KAGGLE</h3>
           
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item ">
      <a href="https://www.coursera.org/courseraplus/?utm_medium=sem&utm_source=gg&utm_campaign=B2C_EMEA__coursera_FTCOF_courseraplus&campaignid=20858197888&adgroupid=156245795749&device=c&keyword=coursera%20cost&matchtype=b&network=g&devicemodel=&adposition=&creativeid=684297719990&hide_mobile_promo&term={term}&gclid=Cj0KCQiA-62tBhDSARIsAO7twbaCNNgLOKE0CjyCja58O1w_nFPIZmddkxYc8-RHUsTjvo-xoqcJXeEaAmp3EALw_wcB" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://studelp.com/wp-content/uploads/2022/01/Coursera-review-1024x740.webp" alt="Pyramid. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">COURSERA</h3>
            <div class="location"></div>
        
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item">
      <a href="https://www.edx.org/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="data:image/png;base64,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" alt="Fox. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">EDX</h3>
  
        
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item">
      <a href="https://unsplash.com/@andozo?photo=lr81rOg-gys" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://static-assets.codecademy.com/Courses/Learn-Redux/matching-game/codecademy_logo.png" alt="Owl. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">CODEACADEMY</h3>
         
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item">
      <a href="https://teamtreehouse.com/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://i0.wp.com/goingundercoder.com/wp-content/uploads/2018/11/Treehouse-Logo.png?fit=382%2C382&ssl=1" alt="Oslo. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">TREEHOUSE </h3>
         
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item ">
      <a href="https://www.futurelearn.com/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="data:image/png;base64,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" alt="Sunset. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">FUTURE LEARN</h3>
            
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item  ">
      <a href="https://developers.google.com/certification?hl=fr" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="data:image/png;base64,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" alt="Lake. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">GOOGLE Developers Certification
            </h3>
            
         
            
          </figcaption>
          
        </figure>

      </a>
     
    </li>
    <li class="card-item ">
      <a href="https://www.freecodecamp.org/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/FreeCodeCamp_logo.png" alt="Jump. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">FREECODECAMP</h3>
       
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item double">
      <a href="https://www.udemy.com/?utm_source=adwords-brand&utm_medium=udemyads&utm_campaign=Brand-Udemy_la.EN_cc.ROW&utm_term=_._ag_80315195513_._ad_535757779892_._de_c_._dm__._pl__._ti_kwd-296956216253_._li_9075940_._pd__._&utm_term=_._pd__._kw_udemy_._&matchtype=b&gad_source=1&gclid=Cj0KCQiA2KitBhCIARIsAPPMEhLt7euKlcttCuVhA6XmnfWWzLB83qWw_xam8SEa5arxwWDslACkvqoaAswvEALw_wcB" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://logowik.com/content/uploads/images/udemy-new-20212512.jpg" alt="Oslo Fjord. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">UDEMY</h3>
            
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item">
      <a href="https://www.sololearn.com/en/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://blob.sololearn.com/avatars/sololearn.png" alt="Oslo Fjord. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">Sololearn</h3>
           
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item ">
      <a href="https://www.udacity.com/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://cdn.sanity.io/images/tlr8oxjg/production/7cc0b59f97026b44887add8983f9ed3b5664a3eb-1200x630.webp" alt="Jump. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">UDACITY</h3>
       
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item  ">
      <a href="https://www.harvardonline.harvard.edu/" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="data:image/png;base64,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" alt="Jump. Photo by Andreas Rønningen">
          <figcaption class="caption">
            <h3 class="caption-title">HARVARD</h3>
       
          </figcaption>
        </figure>
      </a>
    </li>
    <li class="card-item  ">
      <a href="https://www.linkedin.com/learning/python-pour-la-data-science" target="_blank" rel="nofollow">
        <figure class="card">
          <img src="https://media.licdn.com/dms/image/C560BAQEWL3x6YrK4TQ/company-logo_200_200/0/1630662185108/linkedinlearning_logo?e=2147483647&v=beta&t=Xx3oZ2eRUrJWruqAJTm_SiFIBnvhy_--dEzvX-gKwiE">
          <figcaption class="caption">
            <h3 class="caption-title">LINKEDIN LEARNING</h3>
       
          </figcaption>
        </figure>
      </a>
    </li>
 
  </ul>
</main>-->

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




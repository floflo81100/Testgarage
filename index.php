<?php
include 'includes/db.php';
include 'includes/header.php';

// Récupère les commentaires approuvés depuis la table des commentaires
$stmt = $conn->query("SELECT comments.content, comments.rating, visitors.name, visitors.email FROM comments JOIN visitors ON comments.visitor_id = visitors.id WHERE comments.is_approved = 1");
$approved_comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Vincent Parrot</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
</head>

<body>

<main> 
    
    <!-- Section de Bienvenue -->
    <section class="welcome-section d-flex justify-content-center align-items-center text-center">
        <video playsinline autoplay muted loop class="welcome-video">
            <source src="video/welcome_section.mp4" type="video/mp4">
            Votre navigateur ne supporte pas la balise vidéo.
        </video>
        <div class="welcome-text">
            <h1>Venez découvrir nos véhicules d'occasion haut de gamme ainsi que nos offres de service</h1>
            <p>Depuis 2005, le garage Vincent Parrot vous offre une vaste sélection de véhicules d'occasion certifiés, ainsi que des réparations et entretiens de grande qualité.</p>
            <a href="vehicles.php" class="btn btn-primary btn-lg">Voir nos véhicules</a>
            <a href="services.php" class="btn btn-outline-light btn-lg">Voir nos services</a>
        </div>
    </section>

        <!-- Section Pourquoi Nous Choisir -->
    <section class="why-choose-us py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-center">Pourquoi Nous Choisir ?</h2>
            </div>
        </div>
        <div class="row align-items-start g-4">
            <div class="col-md-6">
                <p><strong>Expertise Professionnelle:</strong> Vincent Parrot et son équipe apportent un savoir-faire inégalé à chaque tâche.</p>
                <p><strong>Service Personnalisé:</strong> Nous comprenons que chaque client a des besoins uniques et nous nous efforçons de répondre à ces besoins avec une attention particulière.</p>
                <p><strong>Transparence et Confiance:</strong> La clarté dans nos services et la confiance de nos clients sont au cœur de notre éthique.</p>
                <p><strong>Attention Personnalisée :</strong> Votre expérience automobile est unique, c'est pourquoi nous fournissons des solutions adaptées à vos besoins spécifiques.</p>
            </div>
            <div class="col-md-6">
                <img src="img/choose_us.jpg" alt="Image représentative" class="img-fluid rounded">
            </div>
        </div>
    </div>
    </section>

    <!-- Section À propos du Garage -->
    <section class="about-garage">
        <p>Au cœur de Toulouse, le Garage Vincent Parrot se distingue par son engagement exceptionnel envers la qualité et la fiabilité. Fondé en 2021 par Vincent Parrot, un professionnel passionné avec plus de 15 ans d'expérience dans la réparation automobile, notre garage n'est pas seulement un lieu de service, mais un véritable sanctuaire dédié à la performance et à la sécurité de votre véhicule.</p>
    </section>

    <!-- Section des Services Offerts -->
    <section class="services">
        <h3>Nos Services:</h3>
        <ul>
            <li><strong>Réparation Complète:</strong> De la carrosserie délicate à la mécanique complexe, nous maîtrisons tous les aspects de la réparation automobile.</li>
            <li><strong>Entretien Régulier:</strong> Assurez la longévité et la performance de votre voiture grâce à notre service d'entretien méticuleux.</li>
            <li><strong>Vente de Véhicules d'Occasion:</strong> Découvrez notre sélection rigoureusement choisie de voitures d'occasion, offrant qualité et fiabilité à des prix compétitifs.</li>
        </ul>
    </section>

    <!-- Section Carrousel des Commentaires Approuvés -->
    <section class="approved-comments-carousel mt-5">
        <h3 class="text-center mb-4">Commentaires de nos Clients Satisfaits:</h3>
        <div id="commentsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($approved_comments as $index => $comment): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="d-block w-100">
                            <p class="carousel-comment"><?php echo htmlspecialchars($comment['content']); ?></p>
                            <p class="carousel-author"><?php echo htmlspecialchars($comment['name']); ?></p>
                            <p class="carousel-rating">
                                <?php
                                    // Convertir la note en étoiles
                                    $rating = intval($comment['rating']);
                                    for ($i = 0; $i < $rating; $i++) {
                                        echo '<i class="fas fa-star"></i>'; // Utiliser une icône d'étoile de Font Awesome
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#commentsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#commentsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>


    <!-- Section des employés -->
    <section class="employees-section">
        <h3>Nos Employés</h3>
        <div class="employees">
            <div class="employee">
                <img src="img/Logo_Garage.png" alt="Employee 1">
                <p>Nom de l'employé 1</p>
            </div>
            <div class="employee">
                <img src="img/Logo_Garage.png" alt="Employee 2">
                <p>Nom de l'employé 2</p>
            </div>
            <!-- Ajoutez d'autres employés ici -->
        </div>
    </section>

    <!-- Section Contactez-Nous -->
    <section class="contact-us">
        <p>Rendez-Nous Visite ou Contactez-Nous</p>
        <p>Planifiez votre prochaine visite ou découvrez davantage sur nos services en naviguant sur notre site. Pour toute question, n'hésitez pas à nous contacter. Au Garage Vincent Parrot, nous sommes toujours prêts à vous accueillir et à prendre soin de votre voiture comme si c'était la nôtre.</p>
    </section>
</main>


<?php
include 'includes/footer.php'; // Inclut le contenu commun du bas de la page*/
?>

<!-- Bouton Back to Top -->
<button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Inclusion de jQuery, Popper.js, et Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1do9iB5oI7yscp7OE/7gwT5LcGv1QooPnsVg3OcVC7UyssD4g8J2mP1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        // Assurez-vous que le carrousel est initialisé
        $('#commentsCarousel').carousel();
    });
</script>
<!-- Lien vers votre fichier JavaScript -->
<script src="js/back_to_top.js"></script>

</body>

</html>

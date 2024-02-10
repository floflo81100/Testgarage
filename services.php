<?php
include 'includes/db.php';
include 'includes/header.php'; // Inclut le contenu commun du haut de la page
?>

<link rel="stylesheet" href="css/services.css" />

<main>
      <section class="services-section">
          <h2>Nos Services</h2>
          <p>Bienvenue au Garage V. Parrot, votre destination de confiance pour
          tous vos besoins automobiles à Toulouse. Nous offrons une gamme
          complète de services pour garder votre véhicule en parfait état de
          marche :</p>
          <div class="services-icons">
              <?php foreach ($services as $service): ?>
                  <div class="service-icon">
                      <img src="<?php echo htmlspecialchars($service['icon_path']); ?>" alt="Service">
                      <p><?php echo htmlspecialchars($service['description']); ?></p>
                  </div>
              <?php endforeach; ?>
          </div>
      </section>
      <section class="services-presentation">
        <ul>
          <li>
            <h3>Réparation et Entretien</h3>
            <p>
              Des services complets de réparation et d'entretien pour toutes les
              marques et modèles de véhicules. Qu'il s'agisse d'une simple
              vidange d'huile ou d'une réparation complexe, notre équipe
              expérimentée est là pour vous aider.
            </p>
          </li>
          <li>
            <h3>Diagnostic et Réparation Électronique</h3>
            <p>
              Équipés de la technologie de diagnostic la plus récente, nous
              pouvons rapidement identifier et résoudre les problèmes
              électroniques de votre véhicule.
            </p>
          </li>
          <li>
            <h3>Vente de Véhicules d'Occasion</h3>
            <p>
              Parcourez notre sélection de véhicules d'occasion de qualité.
              Chaque voiture a été soigneusement inspectée et est prête à
              prendre la route.
            </p>
          </li>
          <li>
            <h3>Contrôle Technique</h3>
            <p>
              Nous offrons des services complets de contrôle technique pour
              garantir que votre véhicule répond à toutes les normes de sécurité
              et environnementales requises.
            </p>
          </li>
          <li>
            <h3>Services de Personnalisation</h3>
            <p>
              Envie de personnaliser votre voiture ? Nous proposons une gamme de
              services de personnalisation, des changements esthétiques aux
              améliorations de performance.
            </p>
          </li>
        </ul>
      </section>
</main>

<?php
include 'includes/footer.php'; // Inclut le contenu commun du bas de la page
include 'includes/back_to_top_button.php'; // Inclut le bouton Back to Top
?>

<!-- Bouton Back to Top -->
<button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Inclure le Script JavaScript pour le Bouton "Back to Top" -->
<script src="js/back_to_top.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
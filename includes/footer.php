<?php
include 'db.php';

// Récupère tous les horaires de la base de données
$stmt = $conn->query("SELECT * FROM schedules ORDER BY FIELD(day, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')");
$hours = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ... autres métadonnées ... -->
    <link rel="stylesheet" href="css/global.css"> <!-- Assurez-vous que le chemin est correct -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Informations de Contact -->
            <div class="col-md-4 footer-contact">
                <img src="img/Logo_Garage.png" alt="Logo Garage Vincent Parrot" class="footer-logo">
                <p>
                    13 Place Dupuy<br>
                    31000 Toulouse<br>
                    <strong>Téléphone:</strong> +1 234 567 8910<br>
                    <strong>Email:</strong> contact@garageparrot.com<br>
                </p>
                <!-- Google Map iframe -->
                <div class="map-iframe-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2889.2892713239703!2d1.4523302116366608!3d43.60051827098407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12aebc90376193d1%3A0xa7f277c3adc23d2e!2s13%20Pl.%20Dupuy%2C%2031000%20Toulouse!5e0!3m2!1sfr!2sfr!4v1707347473260!5m2!1sfr!2sfr"
                        width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
            <!-- Horaires d'Ouverture -->
            <div class="col-md-4 footer-hours">
                <h4>Horaires d'Ouverture</h4>
                <ul>
                    <?php foreach ($hours as $hour): ?>
                        <li><?php echo htmlspecialchars($hour['day']); ?> : <?php echo htmlspecialchars($hour['opening_hour']); ?> - <?php echo htmlspecialchars($hour['closing_hour']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Liens Rapides ou Réseaux Sociaux -->
            <div class="col-md-4 footer-links">
                <h4>Liens Utiles</h4>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="vehicles.php">Nos véhicules d'occasion</a></li>
                    <li><a href="#">Termes et Conditions</a></li>
                    <li><a href="#">Politique de Confidentialité</a></li>
                    <li><a href="admin.php">Espace administrateur</a></li>
                </ul>
            </div>
        </div>
        <!-- Footer Social Links -->
        <div class="footer-social-links">
            <h4>Suivez-nous</h4>
            <a href="https://www.facebook.com/tetstsdagsldfsf" target="_blank" class="social-link">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.instagram.com/________test123/" target="_blank" class="social-link">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://twitter.com/test123" target="_blank" class="social-link">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.tiktok.com/@test" target="_blank" class="social-link">
                <i class="fab fa-xing"></i>
            </a>
        </div>
        <!-- Droits d'Auteur et Crédits -->
        <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    &copy; <?php echo date('Y'); ?> Garage Vincent Parrot. Tous droits réservés. (Projet fictif pour Studi)
                </p>
            </div>
        </div>
    </div>
</footer>

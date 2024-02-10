<?php
session_start(); // Démarrer la session au début du script

// Inclusion du fichier de configuration de la base de données
include 'includes/db.php';

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Valide les entrées
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = 'Veuillez remplir tous les champs.';
    } else {
        // Insérer les informations du visiteur dans la table visitors
        $stmt = $conn->prepare("INSERT INTO visitors (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        $visitor_id = $conn->lastInsertId(); // Récupérer l'ID du visiteur inséré

        // Insérer le message dans la table contacts
        $stmt = $conn->prepare("INSERT INTO contacts (visitor_id, name, email, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$visitor_id, $name, $email, $message]);

        $success_message = 'Votre message a été envoyé avec succès. Nous vous répondrons dès que possible.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contactez-nous - Garage Vincent Parrot</title>
    <link rel="stylesheet" href="css/contact.css">
    <!-- Inclure d'autres fichiers CSS si nécessaire -->
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="contact-container">
    <h2>Nous contacter</h2>
    <p>Si vous avez des questions concernant nos services ou si vous êtes intéressé par un de nos véhicules, n'hésitez pas à remplir ce formulaire, nous vous répondrons par e-mail dans les plus brefs délais.</p>
    <?php if($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php else: ?>
        <form action="contact.php" method="post">
            <div class="form-group">
                <label for="name">Votre nom:</label>
                <input type="text" name="name" id="name" required />
            </div>
            <div class="form-group">
                <label for="email">Votre email:</label>
                <input type="email" name="email" id="email" required />
            </div>
            <div class="form-group">
                <label for="message">Votre message:</label>
                <textarea name="message" id="message" rows="5" required></textarea>
            </div>
            <button type="submit">Envoyer</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Bouton Back to Top -->
<button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="js/back_to_top.js"></script>

</body>
</html>

<?php
session_start();
include 'includes/db.php';

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $content = trim($_POST['content']);
    $rating = intval($_POST['rating']);

    // Valide les entrées
    if (empty($name) || empty($email) || empty($content) || $rating < 1 || $rating > 5) {
        $error_message = 'Veuillez remplir tous les champs et fournir une note valide.';
    } else {
        // Insére les informations du visiteur dans la table visitors
        $stmt = $conn->prepare("INSERT INTO visitors (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        $visitor_id = $conn->lastInsertId(); // Récupère l'ID du visiteur inséré

        // Insére le commentaire dans la table comments
        $stmt = $conn->prepare("INSERT INTO comments (visitor_id, content, rating, submitted_at, is_approved) VALUES (?, ?, ?, NOW(), FALSE)");
        $stmt->execute([$visitor_id, $content, $rating]);

        $success_message = 'Votre commentaire a été soumis avec succès, merci pour votre réponse !';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commentaires - Garage Vincent Parrot</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/submit_comment.css">
    <!-- Inclure d'autres fichiers CSS si nécessaire -->
</head>
<body>
    <?php include 'includes/header.php'; // Inclut le contenu commun du haut de la page ?>

    <div class="comment-submission-form">
        <h2>Donnez votre avis sur nos services</h2>
        <h3>Votre avis sera traité par nos équipes et sera potentiellement publié sur notre site</h3>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="submit_comment.php" method="post">
            <div class="form-group">
                <label for="name">Prénom :</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="content">Commentaire :</label>
                <textarea name="content" id="content" required></textarea>
            </div>
            <div class="form-group">
                <label>Note :</label>
                <select name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit">Soumettre le commentaire</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; // Inclut le contenu commun du bas de la page ?>

    <!-- Bouton Back to Top -->
    <button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Inclure les scripts JavaScript pour le carrousel -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Activer le carrousel
        $(document).ready(function(){
            $('.carousel').carousel();
        });
    </script>
    <!-- Inclure le Script JavaScript pour le Bouton "Back to Top" -->
    <script src="js/back_to_top.js"></script>
</body>
</html>

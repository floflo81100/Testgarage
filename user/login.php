<?php
session_start();
include '../includes/db.php'; // Assurez-vous que ce chemin est correct
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Récupérer et filtrer les données du formulaire
    $username = trim($_POST['username']); // Utilisez trim pour enlever les espaces blancs au début et à la fin
    $password = trim($_POST['password']); // Utilisez trim pour enlever les espaces blancs au début et à la fin

    // Rechercher l'utilisateur dans la base de données
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérifier le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Créer une session pour l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Rediriger vers une page d'accueil ou tableau de bord selon le rôle
        header('Location: ../admin.php'); // Assurez-vous que le chemin est correct
        exit;
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Garage Vincent Parrot</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/login.css">
    <!-- Inclure d'autres fichiers CSS si nécessaire -->
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login">Se connecter</button>
        </form>
        <!-- Afficher un message d'erreur si nécessaire -->
        <?php if ($error_message != ''): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

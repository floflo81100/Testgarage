<?php
session_start();
include 'includes/db.php'; // Assurez-vous que ce chemin est correct

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion
    exit;
}

$error_message = '';
$success_message = '';

// Récupérer les informations actuelles de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $new_username = $_POST['username'];
    $new_password = $_POST['password']; // Laisser vide si l'utilisateur ne veut pas changer de mot de passe

    // Mise à jour du nom d'utilisateur
    if ($new_username && $new_username !== $user['username']) {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$new_username, $user_id]);
        $_SESSION['username'] = $new_username; // Mettre à jour la session
        $success_message = 'Nom d\'utilisateur mis à jour.';
    }

    // Mise à jour du mot de passe
    if ($new_password) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $user_id]);
        $success_message = 'Mot de passe mis à jour.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="edit-profile-container">
        <h2>Modifier le Profil</h2>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="edit_profile.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe (laissez vide si inchangé) :</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit">Mettre à jour le profil</button>
        </form>
    </div>
</body>
</html>

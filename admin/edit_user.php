<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$error_message = '';
$success_message = ''; // Initialisée pour éviter l'avertissement d'une variable indéfinie
$user = null;

// Récupérer l'utilisateur à modifier
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error_message = "L'utilisateur demandé n'existe pas.";
    }
}

// Mettre à jour l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $job = htmlspecialchars(trim($_POST['job']));

    if (empty($username) || empty($nom) || empty($prenom) || empty($job)) {
        $error_message = 'Tous les champs sont requis.';
    } else {
        try {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, nom = ?, prenom = ?, job = ? WHERE id = ?");
                $stmt->execute([$username, $hashedPassword, $nom, $prenom, $job, $id]);
            } else {
                $stmt = $conn->prepare("UPDATE users SET username = ?, nom = ?, prenom = ?, job = ? WHERE id = ?");
                $stmt->execute([$username, $nom, $prenom, $job, $id]);
            }

            // Redirection après mise à jour réussie avec message de succès dans la session
            $_SESSION['success_message'] = 'Utilisateur mis à jour avec succès.';
            header('Location: manage_users.php');
            exit;
        } catch (PDOException $e) {
            $error_message = "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'Utilisateur</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-user-management">
        <h2>Modifier l'Utilisateur</h2>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
            <form action="edit_user.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

                <label for="password">Mot de passe (laisser vide pour ne pas changer) :</label>
                <input type="password" name="password" id="password"><br>

                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br>

                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required><br>

                <label for="job">Poste :</label>
                <input type="text" name="job" id="job" value="<?php echo htmlspecialchars($user['job']); ?>" required><br>

                <button type="submit">Mettre à jour</button>
            </form>
        <?php else: ?>
            <?php echo $error_message; ?>
        <?php endif; ?>
    </div>
</body>
</html>

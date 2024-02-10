<?php
// Assurez-vous que la session est démarrée sur toutes les pages qui incluront ce header.
if (!isset($_SESSION)) {
    session_start();
}

// Si l'utilisateur n'est pas connecté ou n'a pas le rôle requis, redirigez-le.
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Chemin relatif vers la racine du site depuis le dossier 'admin'
$rootPath = '../'; // Ajustez en fonction de votre structure de répertoire
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - <?php echo $_SESSION['role'] === 'admin' ? 'Administrateur' : 'Employé'; ?></title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-content">
            <h1>Tableau de Bord - <?php echo $_SESSION['role'] === 'admin' ? 'Administrateur' : 'Employé'; ?></h1>
            <p>Bienvenue, <?php echo $username; ?>!</p>
            <nav class="admin-header-nav">
                <ul>
                    <li><a href="<?php echo $rootPath; ?>index.php">Page d'Accueil du site</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin.php">Tableau de Bord</a></li>
                    <!-- Les liens suivants seront affichés en fonction du rôle de l'utilisateur -->
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="<?php echo $rootPath; ?>admin/manage_users.php">Gérer les utilisateurs</a></li>
                        <li><a href="<?php echo $rootPath; ?>admin/manage_hours.php">Gérer les horaires</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_cars.php">Gérer les véhicules</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_service.php">Gérer les services</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_comments.php">Gérer les commentaires</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_contact_forms.php">Gérer les formulaires de contact</a></li>
                    <li><a href="<?php echo $rootPath; ?>user/logout.php" class="logout-button">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

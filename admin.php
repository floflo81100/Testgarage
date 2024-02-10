<?php
session_start();
include 'includes/db.php'; // Assurez-vous que ce chemin est correct


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php'); // Rediriger vers la page de connexion dans le dossier 'user'
    exit;
}

// Déterminer le rôle de l'utilisateur pour adapter l'affichage
$role = $_SESSION['role'];

// Vous pouvez ajouter plus de code ici pour récupérer des informations spécifiques pour le tableau de bord si nécessaire
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - <?php echo $role === 'admin' ? 'Administrateur' : 'Employé'; ?></title>
    <link rel="stylesheet" href="css/admin.css"> <!-- Assurez-vous que le chemin est correct -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Tableau de Bord - <?php echo $role === 'admin' ? 'Administrateur' : 'Employé'; ?></h1>
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="user/logout.php" class="logout-button">Déconnexion</a> <!-- Assurez-vous que le chemin est correct -->
        </header>
        
        <aside class="admin-sidebar">
            <nav class="admin-menu">
                <ul>
                    <?php if ($role === 'admin'): ?>
                        <li><a href="admin/manage_users.php">Gérer les utilisateurs</a></li>
                    <?php endif; ?>
                    <li><a href="admin/manage_cars.php">Gérer les véhicules</a></li>
                    <li><a href="admin/manage_service.php">Gérer les services proposés</a></li>
                    <li><a href="admin/manage_comments.php">Gérer les commentaires</a></li>
                    <li><a href="admin/manage_contact_forms.php">Gérer les formulaires de contact</a></li>
                    <?php if ($role === 'admin'): ?>
                        <li><a href="admin/manage_hours.php">Gérer les horaires</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
        <!-- Contenu spécifique à chaque page de gestion peut être chargé ici -->
        <?php if ($role === 'admin'): ?>
            <p>Bienvenue dans votre espace administrateur. Vous avez la possibilité de gérer les utilisateurs, les véhicules, les services proposés, les commentaires et les formulaires de contact. Utilisez les liens du menu pour naviguer et gérer votre site.</p>
        <?php elseif ($role === 'employee'): ?>
            <p>Bienvenue dans votre espace employé. Vous avez accès à la gestion des véhicules, des services proposés, des commentaires et des formulaires de contact. Vos autorisations sont limitées à ces domaines spécifiques. Utilisez les liens du menu pour effectuer vos tâches.</p>
        <?php endif; ?>
        </main>

    </div>
    
    <!-- Inclure des fichiers JavaScript si nécessaire -->
</body>
</html>

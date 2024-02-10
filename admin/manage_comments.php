<?php
session_start();
include '../includes/db.php'; // Assurez-vous que ce chemin est correct

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: login.php'); // Rediriger vers la page de connexion
    exit;
}

// Récupérer tous les commentaires avec les informations visiteur associées
$stmt = $conn->query("SELECT comments.*, visitors.id AS visitor_id, visitors.name, visitors.email FROM comments JOIN visitors ON comments.visitor_id = visitors.id");
$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Commentaires - Administration</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclure d'autres fichiers CSS si nécessaire -->
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-comments-management">
        <h1>Gestion des Commentaires</h1>
        
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p>ID du Commentaire : <?php echo $comment['id']; ?></p>
                <p>ID du Visiteur : <?php echo $comment['visitor_id']; ?></p>
                <p>Nom du Visiteur : <?php echo htmlspecialchars($comment['name']); ?></p>
                <p>Email du Visiteur : <?php echo htmlspecialchars($comment['email']); ?></p>
                <p>Contenu : <?php echo htmlspecialchars($comment['content']); ?></p>
                <p>Note : <?php echo $comment['rating']; ?>/5</p>
                <p>Posté le : <?php echo $comment['submitted_at']; ?></p>
                <p>Status : <?php echo $comment['is_approved'] ? 'Approuvé' : 'En attente'; ?></p>
                <a href="approve_comment.php?id=<?php echo $comment['id']; ?>">Approuver</a>
                <a href="delete_comment.php?id=<?= $comment['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

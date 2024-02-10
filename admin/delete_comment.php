<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Vérifiez si l'ID du commentaire à supprimer est passé dans l'URL
if (!isset($_GET['id'])) {
    header('Location: manage_comments.php');
    exit;
}

// Récupérez l'ID du commentaire à supprimer
$comment_id = $_GET['id'];

// Supprimez le commentaire de la base de données
try {
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    header("Location: manage_comments.php");
    exit;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Vérifiez si l'ID du commentaire à supprimer est passé dans l'URL
if (!isset($_GET['id'])) {
    header('Location: manage_comments.php');
    exit;
}

// Récupérez l'ID du commentaire à supprimer
$comment_id = $_GET['id'];

// Supprimez le commentaire de la base de données
try {
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    header("Location: manage_comments.php");
    exit;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

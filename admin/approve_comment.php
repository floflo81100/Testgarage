<?php
session_start();
include '../includes/db.php'; 

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_comments.php');
    exit;
}

$comment_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_comment'])) {
    $stmt = $conn->prepare("UPDATE comments SET is_approved = 1 WHERE id = ?");
    $stmt->execute([$comment_id]);

    header('Location: manage_comments.php');
    exit;
}

// Récupérer les informations du commentaire
$stmt = $conn->prepare("SELECT comments.*, visitors.name, visitors.email FROM comments JOIN visitors ON comments.visitor_id = visitors.id WHERE comments.id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
    header('Location: manage_comments.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Approuver Commentaire - Administration</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-comments-management">
        <h1>Approuver le Commentaire</h1>
        
        <div class="comment">
            <p><?php echo htmlspecialchars($comment['content']); ?></p>
            <p>Posté par : <?php echo htmlspecialchars($comment['name']); ?> (<?php echo htmlspecialchars($comment['email']); ?>)</p>
            <p>Note : <?php echo $comment['rating']; ?>/5</p>
            <p>Posté le : <?php echo $comment['submitted_at']; ?></p>
            <p>Status : <?php echo $comment['is_approved'] ? 'Approuvé' : 'En attente'; ?></p>
        </div>

        <form action="approve_comment.php?id=<?php echo $comment_id; ?>" method="post">
            <button type="submit" name="approve_comment">Approuver le Commentaire</button>
        </form>
    </div>
</body>
</html>

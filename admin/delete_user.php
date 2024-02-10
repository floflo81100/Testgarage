<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Vérifie le rôle de l'utilisateur avant de supprimer
    $stmt_role = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt_role->execute([$id]);
    $user_role = $stmt_role->fetch(PDO::FETCH_ASSOC);

    if ($user_role && $user_role['role'] === 'admin') {
        // Ne pas supprimer si l'utilisateur est un administrateur
        $_SESSION['error_message'] = "La suppression des comptes administrateurs n'est pas autorisée.";
    } else {
        try {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success_message'] = 'Utilisateur supprimé avec succès.';
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
        }
    }
}

header('Location: manage_users.php');
exit;
?>

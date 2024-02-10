<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Vérifiez si l'ID du véhicule à supprimer est passé dans l'URL
if (!isset($_GET['id'])) {
    header('Location: manage_cars.php');
    exit;
}

// Récupérez l'ID du véhicule à supprimer
$vehicle_id = $_GET['id'];

// Supprimez le véhicule de la base de données
try {
    $stmt = $conn->prepare("DELETE FROM vehicles WHERE id = ?");
    $stmt->execute([$vehicle_id]);
    header("Location: manage_cars.php");
    exit;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

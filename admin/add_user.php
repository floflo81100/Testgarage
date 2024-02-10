<?php
session_start();
include '../includes/db.php'; // Assurez-vous que ce chemin vers le fichier de connexion à la base de données est correct.

// Vérifie si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $job = htmlspecialchars(trim($_POST['job']));
    // Le rôle est défini sur 'employee' par défaut, puisque seul un admin peut ajouter des utilisateurs.
    $role = 'employee';

    // Vérifie si les champs sont remplis
    if (empty($username) || empty($password) || empty($nom) || empty($prenom) || empty($job)) {
        $error_message = 'Tous les champs sont requis.';
    } else {
        // Hache le mot de passe avant de le stocker dans la base de données
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prépare la requête d'insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, nom, prenom, job) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Exécute la requête
        try {
            $stmt->execute([$username, $hashedPassword, $role, $nom, $prenom, $job]);
            $success_message = 'Utilisateur créé avec succès.';
        } catch (PDOException $e) {
            // Capture et affiche l'erreur si quelque chose ne va pas avec la requête
            $error_message = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        }
    }
}

// Redirige à nouveau vers le formulaire avec un message de succès ou d'erreur.
header('Location: manage_users.php?success='.urlencode($success_message).'&error='.urlencode($error_message));
exit;
?>

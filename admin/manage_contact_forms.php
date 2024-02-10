<?php
session_start();
include '../includes/db.php'; // Assurez-vous que ce chemin est correct

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php'); // Rediriger vers la page de connexion dans le dossier 'user'
    exit;
}

// Récupérer les formulaires de contact depuis la base de données
try {
    $stmt = $conn->query("SELECT * FROM contacts");
    $contact_forms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer les erreurs de requête SQL
    die("Erreur de récupération des formulaires de contact : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Formulaires de Contact</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
        <main class="admin-contact-forms-management">
            <h2>Liste des Formulaires de Contact Soumis</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Visitor ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contact_forms as $form): ?>
                        <tr>
                            <td><?php echo $form['id']; ?></td>
                            <td><?php echo $form['visitor_id']; ?></td>
                            <td><?php echo htmlspecialchars($form['name']); ?></td>
                            <td><?php echo htmlspecialchars($form['email']); ?></td>
                            <td><?php echo htmlspecialchars($form['message']); ?></td>
                            <td><?php echo $form['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    
    <!-- Inclure des fichiers JavaScript si nécessaire -->
</body>
</html>

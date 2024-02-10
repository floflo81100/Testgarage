<?php
session_start();
include '../includes/db.php'; // Vérifiez que ce chemin est correct

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../login.php'); // Rediriger vers la page de connexion
    exit;
}

// Supprimer un service si l'ID est passé en paramètre et l'action est 'delete'
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Supprimer le service de la base de données
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    
    // Rediriger vers la même page pour afficher la liste mise à jour des services
    header('Location: manage_services.php');
    exit;
}

// Récupérer tous les services de la base de données
$stmt = $conn->query("SELECT * FROM services");
$services = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">*
    <title>Gérer les services</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-services-management">
        <h2>Gérer les services</h2>
        <a href="add_service.php">Ajouter un Nouveau Service</a>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($service['icon_path']); ?>" alt="Service" width="50"></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td>
                            <a href="edit_service.php?id=<?php echo $service['id']; ?>">Modifier</a>
                            <a href="manage_services.php?action=delete&id=<?php echo $service['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

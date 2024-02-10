<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $job = htmlspecialchars(trim($_POST['job']));
    $role = 'employee'; // Par défaut, l'utilisateur ajouté aura le rôle 'employee'

    // Vérifier si le nom d'utilisateur existe déjà dans la base de données
    $stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = ?");
    $stmt_check->execute([$username]);
    $row_check = $stmt_check->fetch(PDO::FETCH_ASSOC);
    if ($row_check['count'] > 0) {
        $error_message = 'Le nom d\'utilisateur existe déjà.';
    } else {
        // Insérer l'utilisateur dans la base de données
        if (empty($username) || empty($password) || empty($nom) || empty($prenom) || empty($job)) {
            $error_message = 'Tous les champs sont requis.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $conn->prepare("INSERT INTO users (username, password, role, nom, prenom, job) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $hashedPassword, $role, $nom, $prenom, $job]);
                $success_message = 'Utilisateur ajouté avec succès.';
            } catch (PDOException $e) {
                $error_message = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs - Administration</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-user-management">
        <h2>Gestion des Utilisateurs</h2>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout d'utilisateur -->
        <h3>Ajouter un Utilisateur</h3>
        <form action="" method="post">

            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required><br>

            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required><br>

            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required><br>

            <label for="job">Poste :</label>
            <input type="text" name="job" id="job" required><br>

            <button type="submit">Ajouter Utilisateur</button>
        </form>

        <!-- Liste des utilisateurs existants -->
        <h3>Liste des Utilisateurs</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Poste</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Boucle pour afficher chaque utilisateur -->
                <?php
                $stmt = $conn->query("SELECT * FROM users");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['prenom']."</td>";
                    echo "<td>".$row['nom']."</td>";
                    echo "<td>".$row['job']."</td>";
                    echo "<td>".$row['role']."</td>"; // Ajoutez cette ligne pour afficher le rôle
                    // Conditionner l'affichage du lien de suppression
                    if ($row['role'] !== 'admin') { // Ne pas afficher le lien de suppression pour les admins
                        echo "<td><a href='edit_user.php?id=".$row['id']."'>Modifier</a> | <a href='delete_user.php?id=".$row['id']."' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</a></td>";
                    } else {
                        echo "<td><a href='edit_user.php?id=".$row['id']."'>Modifier</a></td>"; // Seulement modifier pour les admins
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>    
        </table>
    </div>
</body>
</html>

<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $year = htmlspecialchars($_POST['year']);
    $mileage = htmlspecialchars($_POST['mileage']);
    $price = htmlspecialchars($_POST['price']);
    $condition = htmlspecialchars($_POST['condition']);
    $power = htmlspecialchars($_POST['power']);
    $transmission = htmlspecialchars($_POST['transmission']);
    $fuel = htmlspecialchars($_POST['fuel']);
    $consumption = htmlspecialchars($_POST['consumption']);
    $navigation = isset($_POST['navigation']) ? 1 : 0;
    $heated_seats = isset($_POST['heated_seats']) ? 1 : 0;
    $oil_change = isset($_POST['oil_change']) ? 1 : 0;
    $technical_control = isset($_POST['technical_control']) ? 1 : 0;
    $warranty = isset($_POST['warranty']) ? 1 : 0;
    $number_doors = htmlspecialchars($_POST['number_doors']);
    $color = htmlspecialchars($_POST['color']);
    
    // Path to the upload directory
    $uploadDirectory = "../uploads/";

    // Full path of the uploaded file
    $targetFile = $uploadDirectory . basename($_FILES["photo_url"]["name"]);

    // Check if file was uploaded successfully
    if (move_uploaded_file($_FILES["photo_url"]["tmp_name"], $targetFile)) {
        try {
            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO vehicles (`brand`, `model`, `year`, `mileage`, `price`, `condition`, `power`, `transmission`, `fuel`, `consumption`, `navigation`, `heated_seats`, `oil_change`, `technical_control`, `warranty`, `number_doors`, `color`, `photo_url`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$brand, $model, $year, $mileage, $price, $condition, $power, $transmission, $fuel, $consumption, $navigation, $heated_seats, $oil_change, $technical_control, $warranty, $number_doors, $color, $targetFile]);
            header("Location: manage_cars.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Il y a une erreur dans le téléchargement de la photo
        echo "Désolé, il y a une erreur dans le téléchargement de votre photo";
    }
}

try {
    $stmt = $conn->query("SELECT * FROM vehicles");
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <main>
        <section class="admin-cars-management">
            <h1>Ajouter un véhicule</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="brand">Marque :</label>
                <input type="text" name="brand" id="brand" required><br>

                <label for="model">Modèle :</label>
                <input type="text" name="model" id="model" required><br>

                <label for="year">Année :</label>
                <input type="number" name="year" id="year" required><br>

                <label for="mileage">Kilométrage :</label>
                <input type="number" name="mileage" id="mileage" required><br>

                <label for="price">Prix :</label>
                <input type="text" name="price" id="price" required><br>

                <label for="condition">État :</label>
                <select name="condition" id="condition" required>
                    <option value="Neuf">Neuf</option>
                    <option value="Occasion">Occasion</option>
                </select><br>

                <label for="power">Puissance (CV) :</label>
                <input type="number" name="power" id="power" required><br>

                <label for="transmission">Transmission :</label>
                <input type="text" name="transmission" id="transmission" required><br>

                <label for="fuel">Carburant :</label>
                <input type="text" name="fuel" id="fuel" required><br>

                <label for="consumption">Consommation (L/100km) :</label>
                <input type="text" name="consumption" id="consumption" required><br>

                <label for="number_doors">Nombre de portes :</label>
                <input type="number" name="number_doors" id="number_doors" required><br>

                <label for="color">Couleur :</label>
                <input type="text" name="color" id="color" required><br>

                <label for="navigation">Navigation :</label>
                <input type="checkbox" name="navigation" id="navigation"><br>

                <label for="heated_seats">Sièges chauffants :</label>
                <input type="checkbox" name="heated_seats" id="heated_seats"><br>

                <label for="oil_change">Vidange nécessaire :</label>
                <input type="checkbox" name="oil_change" id="oil_change"><br>

                <label for="technical_control">Contrôle technique :</label>
                <input type="checkbox" name="technical_control" id="technical_control"><br>

                <label for="warranty">Garantie :</label>
                <input type="checkbox" name="warranty" id="warranty"><br>

                <label for="photo_url">Photo du véhicule :</label>
                <input type="file" name="photo_url" id="photo_url" required><br>

                <input type="submit" name="add_vehicle" value="Ajouter">
            </form>

            <h2>Liste des véhicules</h2>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Année</th>
                        <th>Kilométrage</th>
                        <th>Prix</th>
                        <th>État</th>
                        <th>Puissance (CV)</th>
                        <th>Transmission</th>
                        <th>Carburant</th>
                        <th>Consommation (L/100km)</th>
                        <th>Navigation</th>
                        <th>Sièges chauffants</th>
                        <th>Vidange nécessaire</th>
                        <th>Contrôle technique</th>
                        <th>Garantie</th>
                        <th>Nombre de portes</th>
                        <th>Couleur</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td><?= $vehicle['id'] ?></td>
                            <td><?= $vehicle['brand'] ?></td>
                            <td><?= $vehicle['model'] ?></td>
                            <td><?= $vehicle['year'] ?></td>
                            <td><?= $vehicle['mileage'] ?></td>
                            <td><?= $vehicle['price'] ?></td>
                            <td><?= $vehicle['condition'] ?></td>
                            <td><?= $vehicle['power'] ?></td>
                            <td><?= $vehicle['transmission'] ?></td>
                            <td><?= $vehicle['fuel'] ?></td>
                            <td><?= $vehicle['consumption'] ?></td>
                            <td><?= $vehicle['navigation'] ? 'Oui' : 'Non' ?></td>
                            <td><?= $vehicle['heated_seats'] ? 'Yes' : 'Non' ?></td>
                            <td><?= $vehicle['oil_change'] ? 'Yes' : 'Non' ?></td>
                            <td><?= $vehicle['technical_control'] ? 'Oui' : 'Non' ?></td>
                            <td><?= $vehicle['warranty'] ? 'Oui' : 'Non' ?></td>
                            <td><?= $vehicle['number_doors'] ?></td>
                            <td><?= $vehicle['color'] ?></td>
                            <td><img src="../uploads/<?= $vehicle['photo_url']; ?>" alt="Image de <?= htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>"></td>
                            <td><a href="delete_car.php?id=<?= $vehicle['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">Supprimer</a></td>
                            <td><a href="edit_car.php?id=<?= $vehicle['id']; ?>">Modifier</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </section>
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

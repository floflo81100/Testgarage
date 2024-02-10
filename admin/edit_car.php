<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

$vehicleId = $_GET['id'] ?? 0;
$vehicleData = ['brand' => '', 'model' => '', 'year' => '', 'mileage' => '', 'price' => '', 'condition' => '', 'power' => '', 'transmission' => '', 'fuel' => '', 'consumption' => '', 'navigation' => 0, 'heated_seats' => 0, 'oil_change' => 0, 'technical_control' => 0, 'warranty' => 0, 'number_doors' => '', 'color' => '', 'photo_url' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérez les données du formulaire
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $price = $_POST['price'];
    $condition = $_POST['condition'];
    $power = $_POST['power'];
    $transmission = $_POST['transmission'];
    $fuel = $_POST['fuel'];
    $consumption = isset($_POST['consumption']) ? $_POST['consumption'] : ''; // Vérifiez si la clé existe
    $navigation = isset($_POST['navigation']) ? 1 : 0;
    $heated_seats = isset($_POST['heated_seats']) ? 1 : 0;
    $oil_change = isset($_POST['oil_change']) ? 1 : 0;
    $technical_control = isset($_POST['technical_control']) ? 1 : 0;
    $warranty = isset($_POST['warranty']) ? 1 : 0;
    $number_doors = $_POST['number_doors'];
    $color = $_POST['color'];
    $photo_url = $vehicleData['photo_url']; // Initialisez la variable pour stocker le chemin de la nouvelle photo

    // Vérification et traitement de l'upload de la nouvelle image
    if (isset($_FILES['photo_url']) && $_FILES['photo_url']['size'] > 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["photo_url"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si le fichier image est réellement une image ou un faux fichier
        $check = getimagesize($_FILES["photo_url"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifier si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier
        if ($_FILES["photo_url"]["size"] > 500000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichiers
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifier si $uploadOk est défini sur 0 par une erreur
        if ($uploadOk == 1 && move_uploaded_file($_FILES["photo_url"]["tmp_name"], $target_file)) {
            $photo_url = $target_file; // Mettez à jour l'URL de la photo si une nouvelle a été téléchargée

        // Si tout est correct, essayez de télécharger le fichier
        } else {
            if (move_uploaded_file($_FILES["photo_url"]["tmp_name"], $target_file)) {
                echo "Le fichier ". htmlspecialchars( basename( $_FILES["photo_url"]["name"])). " a été téléchargé.";
                $photo_url = $target_file;
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    }

    // Mets à jour les données dans la base de données
    try {
        //La colonne photo_url est incluse seulement si une nouvelle photo a été téléchargée
        $stmt = $conn->prepare("UPDATE vehicles SET brand = ?, model = ?, year = ?, mileage = ?, price = ?, `condition` = ?, power = ?, transmission = ?, fuel = ?, consumption = ?, navigation = ?, heated_seats = ?, oil_change = ?, technical_control = ?, warranty = ?, number_doors = ?, color = ?" . (!empty($photo_url) ? ", photo_url = ?" : "") . " WHERE id = ?");
        $params = [$brand, $model, $year, $mileage, $price, $condition, $power, $transmission, $fuel, $consumption, $navigation, $heated_seats, $oil_change, $technical_control, $warranty, $number_doors, $color];
        
        // Ajoute l'URL de la photo et l'ID du véhicule aux paramètres si une nouvelle photo a été téléchargée
        if (!empty($photo_url)) {
            $params[] = $photo_url;
        }
        $params[] = $vehicleId;

        $stmt->execute($params);
        header("Location: manage_cars.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Récupère les détails du véhicule à modifier
    try {
        $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
        $stmt->execute([$vehicleId]);
        $vehicleData = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <main>
        <section class="edit-car-section">
            <h2>Modifier un Véhicule</h2>
            <form action="edit_car.php?id=<?= $vehicleId; ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="brand" placeholder="Marque" value="<?= isset($vehicleData['brand']) ? htmlspecialchars($vehicleData['brand']) : ''; ?>" required>
                <input type="text" name="model" placeholder="Modèle" value="<?= isset($vehicleData['model']) ? htmlspecialchars($vehicleData['model']) : ''; ?>" required>
                <input type="number" name="year" placeholder="Année" value="<?= isset($vehicleData['year']) ? htmlspecialchars($vehicleData['year']) : ''; ?>" required>
                <input type="number" name="mileage" placeholder="Kilométrage" value="<?= isset($vehicleData['mileage']) ? htmlspecialchars($vehicleData['mileage']) : ''; ?>" required>
                <input type="number" name="price" placeholder="Prix" value="<?= isset($vehicleData['price']) ? htmlspecialchars($vehicleData['price']) : ''; ?>" required>
                <select name="condition" required>
                    <option value="Neuf" <?= isset($vehicleData['condition']) && $vehicleData['condition'] == 'Neuf' ? 'selected' : ''; ?>>Neuf</option>
                    <option value="Occasion" <?= isset($vehicleData['condition']) && $vehicleData['condition'] == 'Occasion' ? 'selected' : ''; ?>>Occasion</option>
                </select>
                <input type="number" name="power" placeholder="Puissance (CV)" value="<?= isset($vehicleData['power']) ? htmlspecialchars($vehicleData['power']) : ''; ?>" required>
                <input type="text" name="transmission" placeholder="Transmission" value="<?= isset($vehicleData['transmission']) ? htmlspecialchars($vehicleData['transmission']) : ''; ?>" required>
                <input type="text" name="fuel" placeholder="Carburant" value="<?= isset($vehicleData['fuel']) ? htmlspecialchars($vehicleData['fuel']) : ''; ?>" required>
                <input type="text" name="consumption" placeholder="Consommation (L/100km)" value="<?= isset($vehicleData['consumption']) ? htmlspecialchars($vehicleData['consumption']) : ''; ?>" required>
                <label for="navigation">Navigation :</label>
                <input type="checkbox" name="navigation" id="navigation" <?= isset($vehicleData['navigation']) && $vehicleData['navigation'] == 1 ? 'checked' : ''; ?>>
                <label for="heated_seats">Sièges chauffants :</label>
                <input type="checkbox" name="heated_seats" id="heated_seats" <?= isset($vehicleData['heated_seats']) && $vehicleData['heated_seats'] == 1 ? 'checked' : ''; ?>>
                <label for="oil_change">Vidange nécessaire :</label>
                <input type="checkbox" name="oil_change" id="oil_change" <?= isset($vehicleData['oil_change']) && $vehicleData['oil_change'] == 1 ? 'checked' : ''; ?>>
                <label for="technical_control">Contrôle technique :</label>
                <input type="checkbox" name="technical_control" id="technical_control" <?= isset($vehicleData['technical_control']) && $vehicleData['technical_control'] == 1 ? 'checked' : ''; ?>>
                <label for="warranty">Garantie :</label>
                <input type="checkbox" name="warranty" id="warranty" <?= isset($vehicleData['warranty']) && $vehicleData['warranty'] == 1 ? 'checked' : ''; ?>>
                <input type="number" name="number_doors" placeholder="Nombre de portes" value="<?= isset($vehicleData['number_doors']) ? htmlspecialchars($vehicleData['number_doors']) : ''; ?>" required>
                <input type="text" name="color" placeholder="Couleur" value="<?= isset($vehicleData['color']) ? htmlspecialchars($vehicleData['color']) : ''; ?>" required>
                <label for="photo_url">Photo du véhicule :</label>
                <input type="file" name="photo_url" id="photo_url">
                <?php if (!empty($vehicleData['photo_url'])): ?>
                    <p>Photo actuelle :</p>
                    <img src="<?= $vehicleData['photo_url'] ?>" alt="<?= isset($vehicleData['brand']) && isset($vehicleData['model']) ? htmlspecialchars($vehicleData['brand'] . ' ' . $vehicleData['model']) : ''; ?>" width="100">
                <?php endif; ?>
                <button type="submit" name="submit">Modifier le Véhicule</button>
            </form>
        </section>
    </main>
</body>
</html>

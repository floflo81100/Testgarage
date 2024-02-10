<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marque = $_POST['brand'];
    $modele = $_POST['model'];
    $annee = $_POST['year'];
    $kilometrage = $_POST['mileage'];
    $prix = $_POST['price'];
    $etat = $_POST['condition'];
    $puissance = $_POST['power'];
    $transmission = $_POST['transmission'];
    $carburant = $_POST['fuel'];
    $consommation = $_POST['consumption'];
    $navigation = isset($_POST['navigation']) ? 1 : 0;
    $siege_chauffant = isset($_POST['heated_seats']) ? 1 : 0;
    $vidange = isset($_POST['oil_change']) ? 1 : 0;
    $controle_technique = isset($_POST['technical_control']) ? 1 : 0;
    $garantie = isset($_POST['warranty']) ? 1 : 0;
    $nombre_portes = $_POST['number_doors'];
    $couleur = $_POST['color'];

    // Gestion de l'upload de la photo
    if (isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] == 0) {
        $targetDirectory = "../uploads/"; // Assurez-vous que ce répertoire existe et est accessible en écriture
        $targetFile = $targetDirectory . basename($_FILES['photo_url']['name']);
        if (move_uploaded_file($_FILES['photo_url']['tmp_name'], $targetFile)) {
            $photo_url = 'uploads/' . basename($_FILES['photo_url']['name']);
        } else {
            // Gérer l'erreur d'upload
            echo "Erreur lors de l'upload de la photo.";
            exit;
        }
    } else {
        // Gérer l'absence de fichier ou une erreur d'upload
        echo "Erreur ou absence de fichier photo.";
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO vehicles (brand, model, year, mileage, price, condition, power, transmission, fuel, consumption, navigation, headed_seats, oil_change, technical_control, warranty, number_doors, color, photo_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$brand, $model, $year, $mileage, $price, $condition, $power, $transmission, $fuel, $consumption, $navigation, $headed_seats, $oil_change, $technical_control, $warranty, $number_doors, $color, $photo_url]);
        header("Location: manage_cars.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    header("Location: add_car.php?error=notsubmitted");
}
?>

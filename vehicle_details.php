<?php
include 'includes/db.php'; // Assurez-vous que le chemin est correct

$vehicleId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$vehicle = null;

if ($vehicleId > 0) {
    try {
        $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :id");
        $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

include 'includes/header.php'; // Assurez-vous que le chemin est correct
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Véhicule</title>
    <link rel="stylesheet" href="css/vehicle_details.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
<main class="vehicle-details-container">
    <?php if ($vehicle): ?>
        <h1><?= htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?> - Détails</h1>
        <img src="uploads/<?php echo $vehicle['photo_url']; ?>" alt="Image de <?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>">
        <div class="details-container">
            <div class="primary-details">
                <p><strong>Marque:</strong> <?= htmlspecialchars($vehicle['brand']); ?></p>
                <p><strong>Modèle:</strong> <?= htmlspecialchars($vehicle['model']); ?></p>
                <p><strong>Année:</strong> <?= htmlspecialchars($vehicle['year']); ?></p>
                <p><strong>Kilométrage:</strong> <?= number_format($vehicle['mileage']); ?> km</p>
                <p><strong>Prix:</strong> <?= number_format($vehicle['price'], 2); ?> €</p>
                <p><strong>État:</strong> <?= htmlspecialchars($vehicle['condition']); ?></p>
            </div>
            <div class="secondary-details">
                <h2>Spécifications complémentaires</h2>
                <table>
                    <tr>
                        <th>Carburant</th>
                        <td><?= htmlspecialchars($vehicle['fuel']); ?></td>
                    </tr>
                    <tr>
                        <th>Type de transmission</th>
                        <td><?= htmlspecialchars($vehicle['transmission']); ?></td>
                    </tr>
                    <tr>
                        <th>Couleur</th>
                        <td><?= htmlspecialchars($vehicle['color']); ?></td>
                    </tr>
                    <tr>
                        <th>Puissance du moteur</th>
                        <td><?= htmlspecialchars($vehicle['power']); ?> CV</td>
                    </tr>
                    <tr>
                        <th>Consommation de carburant</th>
                        <td><?= htmlspecialchars($vehicle['consumption']); ?> L/100km</td>
                    </tr>
                    <tr>
                        <th>Système de navigation</th>
                        <td><?= $vehicle['navigation'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Sièges chauffants</th>
                        <td><?= $vehicle['heated_seats'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Vidange nécessaire</th>
                        <td><?= $vehicle['oil_change'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Contrôle technique</th>
                        <td><?= $vehicle['technical_control'] ? 'À jour' : 'À faire'; ?></td>
                    </tr>
                    <tr>
                        <th>Garantie</th>
                        <td><?= $vehicle['warranty'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre de portes</th>
                        <td><?= htmlspecialchars($vehicle['number_doors']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="vehicles.php" class="back-button">Retour aux véhicules</a>
    <?php else: ?>
        <p>Véhicule non trouvé.</p>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

<!-- Bouton Back to Top -->
<button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Inclure le Script JavaScript pour le Bouton "Back to Top" -->
<script src="js/back_to_top.js"></script>

</body>
</html>

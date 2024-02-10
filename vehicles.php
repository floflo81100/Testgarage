<?php
include 'includes/db.php'; // Inclut votre script de connexion à la base de données
include 'includes/header.php'; // Inclut le contenu commun du haut de la page

try {
    // Préparation de la requête pour récupérer les véhicules
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();

    // Récupération des résultats
    $vehicles = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

// Générer des listes uniques pour les marques (brands), modèles (models), et carburants (fuels)
$brands = array_unique(array_column($vehicles, 'brand'));
$models = array_unique(array_column($vehicles, 'model'));
$fuels = array_unique(array_column($vehicles, 'fuel'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Véhicules d'Occasion - Garage Vincent Parrot</title>
    <link rel="stylesheet" href="css/vehicles.css">
</head>
<body>
    <main>
        <section class="vehicles-section">
            <h2>Nos Véhicules d'Occasion</h2>
            
            <div class="filter-container">
                <select id="filterMake">
                    <option value="">Marque</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?php echo $brand; ?>"><?php echo $brand; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <select id="filterModel">
                    <option value="">Modèle</option>
                    <?php foreach ($models as $model): ?>
                        <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="filterFuel">
                    <option value="">Carburant</option>
                    <?php foreach ($fuels as $fuel): ?>
                        <option value="<?php echo $fuel; ?>"><?php echo $fuel; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Les filtres pour le prix et le kilométrage restent les mêmes car les noms de colonnes sont déjà en anglais -->

            </div>

            <div class="vehicles-container">
                <?php foreach ($vehicles as $vehicle): ?>
                    <div class="vehicle-card" data-make="<?php echo $vehicle['brand']; ?>" data-model="<?php echo $vehicle['model']; ?>" data-price="<?php echo $vehicle['price']; ?>" data-fuel="<?php echo $vehicle['fuel']; ?>" data-mileage="<?php echo $vehicle['mileage']; ?>">
                        <img src="uploads/<?php echo $vehicle['photo_url']; ?>" alt="Image de <?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>">
                        <h3 class="card-title"><?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?></h3>
                        <p>Année: <?php echo htmlspecialchars($vehicle['year']); ?></p>
                        <p>Kilométrage: <?php echo htmlspecialchars(number_format($vehicle['mileage'])); ?> km</p>
                        <p>Prix: <?php echo htmlspecialchars(number_format($vehicle['price'], 2)); ?> €</p>
                        <a href="vehicle_details.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-primary">Voir les détails</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

<!-- Bouton Back to Top -->
<button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="js/back_to_top.js"></script>
<script src="js/vehicle.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
require '../includes/db.php'; // Assurez-vous que ce chemin est correct et que $conn est un objet PDO

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$error_message = '';
$success_message = '';
$schedule_data = [];

try {
    $query = "SELECT * FROM schedules ORDER BY id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $schedule_data[$row['day']] = ['opening_hour' => $row['opening_hour'], 'closing_hour' => $row['closing_hour']];
    }
} catch (PDOException $e) {
    $error_message = "Erreur lors de la récupération des horaires : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($schedule_data as $day => &$times) {
        if (isset($_POST[$day . '_opening_hour']) && isset($_POST[$day . '_closing_hour'])) {
            $times['opening_hour'] = $_POST[$day . '_opening_hour'];
            $times['closing_hour'] = $_POST[$day . '_closing_hour'];
            try {
                $update_query = "UPDATE schedules SET opening_hour = :opening_hour, closing_hour = :closing_hour WHERE day = :day";
                $stmt = $conn->prepare($update_query);
                $stmt->execute([
                    ':opening_hour' => $times['opening_hour'], 
                    ':closing_hour' => $times['closing_hour'], 
                    ':day' => $day
                ]);
            } catch (PDOException $e) {
                $error_message = "Erreur lors de la mise à jour des horaires pour $day : " . $e->getMessage();
                break; // Sortir de la boucle en cas d'erreur
            }
        }
    }
    if (empty($error_message)) {
        $success_message = "Les horaires ont été mis à jour avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les Horaires d'Ouverture et de Fermeture</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php   
    include '../includes/admin_header.php';
    ?>
    <div class="admin-hours-management">
    <h1>Modifier les Horaires d'Ouvertureet de Fermeture</h1>
        <?php if (!empty($success_message)): ?>
    <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    <form action="update_hours.php" method="post">
        <?php foreach ($schedule_data as $day => $times): ?>
    <div class="day-schedule">
    <h2><?php echo htmlspecialchars(ucfirst($day)); ?></h2>
        <label for="<?php echo $day; ?>_opening_hour">Heure d'ouverture:</label>
        <input type="time" name="<?php echo $day; ?>_opening_hour" id="<?php echo $day; ?>_opening_hour" value="<?php echo htmlspecialchars($times['opening_hour']); ?>">
        <label for="<?php echo $day; ?>_closing_hour">Heure de fermeture:</label>
        <input type="time" name="<?php echo $day; ?>_closing_hour" id="<?php echo $day; ?>_closing_hour" value="<?php echo htmlspecialchars($times['closing_hour']); ?>">
    </div>
        <?php endforeach; ?>
    <button type="submit">Mettre à jour</button>
    </form>
</div>
</body>
</html>
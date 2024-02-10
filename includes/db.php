<?php
$host = 'localhost'; // adresse du serveur de base de données
$dbname = 'garage_vincent_parrot'; // le nom de la base de données
$username = 'root'; // nom d'utilisateur pour la base de données
$password = 'admin'; // mot de passe pour la base de données

try {
    // Création d'une instance PDO pour la connexion à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Définition du mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exceptions pour chaque erreur SQL
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // echo "Connexion réussie"; // Ligne pour tester si la connexion est réussie.

} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}

<?php
// Set database credentials
$host = "localhost";
$dbname = "panier_js";
$username = "root";
$password = "";

// Set options for PDO connection
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_EMULATE_PREPARES => false,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
  // Create a PDO connection object
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
} catch(PDOException $e) {
  // Handle connection errors
  echo "Connection échouée: " . $e->getMessage();
}

?>
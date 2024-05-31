<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use Dotenv\Dotenv;

// Carica le variabili d'ambiente dal file .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$key = $_ENV['SECRET_KEY']; // Recupera la chiave segreta dalla variabile d'ambiente

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Decodifica il token JWT senza passare $headers per riferimento
        $decoded = JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
        $decoded_array = (array) $decoded;

        echo '<h1>Benvenuto, ' . htmlspecialchars($decoded_array['data']->username) . '!</h1>';
        echo '<p>Il token JWT è valido.</p>';
    } catch (Exception $e) {
        echo 'Token JWT non valido: ' . $e->getMessage();
    }
} else {
    echo 'Token non fornito.';
}
?>

<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

// Carica le variabili d'ambiente dal file .envs 
$dotenv = Dotenv::createImmutable(__DIR__); 
$dotenv->load();

$key = $_ENV['SECRET_KEY']; // Recupera la chiave segreta dalla variabile d'ambiente
print_r($key);

// Funzione fittizia per la verifica delle credenziali
function checkCredentials($username, $password) {
    // Sostituisci questa logica con il controllo effettivo delle credenziali
    return $username === 'admin' && $password === 'password';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (checkCredentials($username, $password)) {
        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'exp' => time() + 3600, // Token valido per 1 ora
            'data' => [
                'username' => $username
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        print_r($jwt);

        // Reindirizza a home.php con il token JWT come parametro GET
        header('Location: home.php?token=' . $jwt);
        exit();
    } else {
        echo 'Credenziali non valide';
    }
} else {
    echo 'Metodo non consentito';
}
?>

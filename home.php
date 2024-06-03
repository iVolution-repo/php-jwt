<!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Pagina con iFrame</title>
            <style>
                #iframeContainer {
                    display: none;
                    margin-top: 20px;
                }
                iframe {
                    width: 100%;
                    height: 500px;
                    border: 1px solid #ccc;
                }
            </style>
            <script>
                function showIframe() {
                    var iframeContainer = document.getElementById("iframeContainer");
                    iframeContainer.style.display = "block";
                }
            </script>
        </head>
        <body>
        <?php
            require 'vendor/autoload.php';
            use Firebase\JWT\JWT;
            use Firebase\JWT\Key;
            use Dotenv\Dotenv;

            // Carica le variabili d'ambiente dal file .env
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $key = $_ENV['SECRET_KEY']; // Recupera la chiave segreta dalla variabile d'ambiente
            $url = $_ENV['IFRAME_URL']; // Recupera la chiave segreta dalla variabile d'ambiente

            if (isset($_GET['token'])) {
                $token = $_GET['token'];

                try {
                    // Decodifica il token JWT senza passare $headers per riferimento
                    $decoded = JWT::decode($token, new Key($key, 'HS256'));
                    $decoded_array = (array) $decoded;
                    echo '<h1>Benvenuto, ' . htmlspecialchars($decoded_array['data']->username) . '!</h1>';
                    echo '<p>Il token JWT è valido.</p>';
                    echo '<p>Token:' . $token . '</p>';
                    echo '<a href="javascript:void(0);" onclick="showIframe();">Clicca qui per aprire un iframe</a>';
                    echo '<div id="iframeContainer">';
                    echo '<iframe src="'.$url.'?jwt='.$token.'"></iframe>';
                    echo '</div>';
                } catch (Exception $e) {
                    echo '<h1>Attenzione!</h1>';
                    echo '<p>Token JWT non valido: ' . $e->getMessage() . '</p>';
                }
            } else {
                echo '<h1>Attenzione!</h1>';
                echo '<p>Token JWT non fornito.</p>';
            }
        ?>

    </body>
</html>


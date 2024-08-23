<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\YouTube;

// Configurações
$API_KEY = 'AIzaSyCJOWchkjhOpzT4g08MzV4v98ncA_695EM';
$DOWNLOAD_FOLDER = 'downloads';

// Função para obter o serviço do YouTube
function getYoutubeService() {
    global $API_KEY;
    $client = new Client();
    $client->setDeveloperKey($API_KEY);
    return new YouTube($client);
}

// Função para pesquisar o vídeo no YouTube
function searchYoutube($query) {
    $youtube = getYoutubeService();
    $response = $youtube->search->listSearch('id,snippet', array(
        'q' => $query,
        'type' => 'video',
        'maxResults' => 1
    ));

    if (empty($response['items'])) {
        throw new Exception("Nenhum vídeo encontrado para a consulta.");
    }

    $videoId = $response['items'][0]['id']['videoId'];
    return 'https://www.youtube.com/watch?v=' . $videoId;
}

// Função para gerar um nome de arquivo único baseado na data e hora
function getUniqueFilename() {
    global $DOWNLOAD_FOLDER;

    // Gera um nome baseado no timestamp atual
    $timestamp = date('Ymd_His');
    return $DOWNLOAD_FOLDER . "/track_$timestamp.mp3";
}

// Função para converter o vídeo em MP3
function downloadAndConvert($url) {
    global $DOWNLOAD_FOLDER;

    if (!file_exists($DOWNLOAD_FOLDER)) {
        mkdir($DOWNLOAD_FOLDER, 0777, true);
    }

    // Gera o nome do arquivo único
    $outputFile = getUniqueFilename();

    // Cria o comando yt-dlp com o caminho de saída correto
    $cmd = 'C:\\Users\\leona\\AppData\\Roaming\\Python\\Python312\\Scripts\\yt-dlp.exe -f bestaudio --extract-audio --audio-format mp3 --ffmpeg-location ' . escapeshellarg('C:\\ffmpeg\\bin') . ' --output ' . escapeshellarg($outputFile) . ' ' . escapeshellarg($url);

    // Adiciona um log para o comando
    error_log("Comando executado: $cmd");

    // Executa o comando e captura a saída e o código de retorno
    $output = [];
    $return_var = null;
    exec($cmd . ' 2>&1', $output, $return_var);

    // Adiciona um log para a saída do comando e o código de retorno
    error_log("Saída do comando: " . implode("\n", $output));
    error_log("Código de retorno: $return_var");

    // Verifica o caminho absoluto do arquivo
    $absolutePath = realpath($DOWNLOAD_FOLDER) . DIRECTORY_SEPARATOR . basename($outputFile);
    error_log("Caminho absoluto do arquivo MP3: " . $absolutePath);

    // Verifica se o arquivo MP3 foi criado
    if (file_exists($absolutePath)) {
        error_log("Arquivo MP3 encontrado: $absolutePath");
        return $absolutePath;
    } else {
        error_log("Arquivo MP3 não encontrado.");
        return null;
    }
}


// Função para renderizar o HTML
function renderHtml($message = '') {
    echo <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Música YouTube para MP3</title>
    <style>
        :root {
            --colors-red500: #AB222E;
            --colors-red700: #7A1921;
        }
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            background-color: #000; /* Fundo preto */
            color: #fff;
        }
        .main-title { 
            font-size: 4rem; 
            margin: 20px 0; 
            color: var(--colors-red500); /* Cor sólida inicial */
            text-align: center; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            transition: color 2s linear; /* Transição suave de cor */
        }
        .container { 
            max-width: 600px; 
            width: 100%; 
            background: #fff; 
            padding: 20px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            border-radius: 8px; 
            z-index: 1;
        }
        h1 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: var(--colors-red500); 
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
            color: var(--colors-red700); 
        }
        input[type="text"] { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            padding: 10px; 
            border: none; 
            border-radius: 4px; 
            background-color: var(--colors-red500); 
            color: #fff; 
            font-size: 16px; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: var(--colors-red700); 
        }
        .result { 
            margin-top: 20px; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="main-title">Os Crias</h1>
    <div class="container">
        <h1>Conversor de Música YouTube para MP3</h1>
        <form method="get" action="">
            <div class="form-group">
                <label for="query">Digite o nome da música:</label>
                <input type="text" id="query" name="query" required>
            </div>
            <button type="submit">Converter para MP3</button>
        </form>
        <div class="result">
            $message
        </div>
    </div>
    <script>
 document.addEventListener('DOMContentLoaded', () => {
    const title = document.querySelector('.main-title');
    const colors = [
        { r: 255, g: 58, b: 58 }, // #ff3a3a
        { r: 171, g: 34, b: 46 }, // #AB222E
        { r: 122, g: 25, b: 33 }  // #7A1921
    ];
    
    let startTime = null;
    const duration = 10000; // Duração total da transição em ms
    const interval = 50; // Intervalo de atualização em ms

    function interpolateColor(color1, color2, factor) {
        const r = Math.round(color1.r + (color2.r - color1.r) * factor);
        const g = Math.round(color1.g + (color2.g - color1.g) * factor);
        const b = Math.round(color1.b + (color2.b - color1.b) * factor);
        return 'rgb(' + r + ', ' + g + ', ' + b + ')';
    }

    function updateColor(timestamp) {
        if (!startTime) startTime = timestamp;
        const elapsed = timestamp - startTime;
        const progress = (elapsed % duration) / duration;
        
        // Determine which two colors to interpolate between
        const colorIndex = Math.floor(progress * (colors.length - 1));
        const factor = (progress * (colors.length - 1)) % 1;
        const color1 = colors[colorIndex];
        const color2 = colors[colorIndex + 1];
        
        // Interpolate between the two colors
        title.style.color = interpolateColor(color1, color2, factor);

        requestAnimationFrame(updateColor);
    }

    requestAnimationFrame(updateColor);
});

    </script>
</body>
</html>
HTML;
}









// Lógica principal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = trim($_GET['query']);
    if (empty($query)) {
        renderHtml("Parâmetro 'query' é necessário");
        exit;
    }

    try {
        $url = searchYoutube($query);
        $filename = downloadAndConvert($url);
        error_log( $filename);
        error_log ("teste");  
        if ($filename) {
            $basename = basename($filename);
            renderHtml("Arquivo MP3 disponível em: <a href='downloads/$basename'>/downloads/$basename</a>");
        } else {
            renderHtml("Erro ao converter o vídeo.");
        }
    } catch (Exception $e) {
        renderHtml("Ocorreu um erro: " . htmlspecialchars($e->getMessage()));
    }
} else {
    renderHtml();
}

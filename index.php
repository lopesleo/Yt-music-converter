<?php
require_once __DIR__ . '/vendor/autoload.php';


// Inicialize o ambiente
// Carregue o arquivo .env na raiz
use Src\Config\Env;
use Src\Services\YouTubeService;
use Src\Utils\Converter;
use Src\Views\Template;

// Inicialize o ambiente
Env::load(__DIR__);


$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = trim($_GET['query']);
    if (empty($query)) {
        $message = "Parâmetro 'query' é necessário";
    } else {
        try {
            $youtubeService = new YouTubeService();
            $url = $youtubeService->searchYoutube($query);

            $converter = new Converter();
            $filename = $converter->downloadAndConvert($url);

            if ($filename) {
                $basename = basename($filename);
               
                $baseDir = __DIR__;

         
                $baseDirName = basename($baseDir);

                $filePath = "/$baseDirName/downloads/$basename";

                // Gera o link para o arquivo
                $message = "Arquivo MP3 disponível em: <a href='$filePath'>$filePath</a>";

             
            } else {
                $message = "Erro ao converter o vídeo.";
            }
        } catch (Exception $e) {
            $message = "Ocorreu um erro: " . htmlspecialchars($e->getMessage());
        }
    }
}

echo Template::render($message);

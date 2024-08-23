<?php
namespace Src\Services;

use Google\Client;
use Google\Service\YouTube;

class YouTubeService
{
    private $API_KEY;

    public function __construct()
    {
        $this->API_KEY = $_ENV['API_KEY'];
    }

    // Função para obter o serviço do YouTube
    private function getYoutubeService()
    {
        $client = new Client();
        $client->setDeveloperKey($this->API_KEY);
        return new YouTube($client);
    }

    // Função para pesquisar o vídeo no YouTube
    public function searchYoutube($query)
    {
        $youtube = $this->getYoutubeService();
        $response = $youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'type' => 'video',
            'maxResults' => 1
        ));

        if (empty($response['items'])) {
            throw new \Exception("Nenhum vídeo encontrado para a consulta.");
        }

        $videoId = $response['items'][0]['id']['videoId'];
        return 'https://www.youtube.com/watch?v=' . $videoId;
    }
}

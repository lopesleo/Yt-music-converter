<?php
namespace Src\Utils;

class Converter
{
    private $downloadFolder;

    public function __construct()
    {
        $this->downloadFolder = 'downloads';
        if (!file_exists($this->downloadFolder)) {
            mkdir($this->downloadFolder, 0777, true);
        }
    }

    private function getUniqueFilename()
    {
        $timestamp = date('Ymd_His');
        return $this->downloadFolder . "/track_$timestamp.mp3";
    }

    public function downloadAndConvert($url)
    {
        $outputFile = $this->getUniqueFilename();
        $ytdl = 'C:\\Users\\leona\\AppData\\Roaming\\Python\\Python312\\Scripts\\yt-dlp.exe';
        $cmd = $ytdl .' -f bestaudio --extract-audio --audio-format mp3 --ffmpeg-location ' . escapeshellarg('C:\\ffmpeg\\bin') . ' --output ' . escapeshellarg($outputFile) . ' ' . escapeshellarg($url);

        $output = [];
        $return_var = null;
        exec($cmd . ' 2>&1', $output, $return_var);
       
        if (file_exists($outputFile)) {
            echo 'Arquivo convertido com sucesso!';
            return realpath($outputFile);
        } else {
            echo 'Erro ao converter o arquivo!';
            return null;
        }
    }
}

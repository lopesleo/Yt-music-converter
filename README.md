# YouTube to MP3 Converter

Este projeto é um conversor de músicas do YouTube para MP3. Ele permite que os usuários pesquisem vídeos no YouTube, baixem e convertam esses vídeos para o formato MP3.

## Funcionalidades

- Pesquisa de vídeos no YouTube.
- Download de vídeos do YouTube.
- Conversão de vídeos para o formato MP3.
- Interface web simples para interação com o usuário.

## Requisitos

- PHP 7.4 ou superior
- Composer
- FFMPEG
- yt-dlp

## Instalação

1. Clone o repositório:
    ```sh
    git clone https://github.com/lopesleo/Yt-music-converter.git
    cd Yt-music-converter
    ```

2. Instale as dependências do Composer:
    ```sh
    composer install
    ```

3. Copie o arquivo `.env_example` para `.env` e configure sua chave de API do YouTube:
    ```sh
    cp .env_example .env
    ```

4. Edite o arquivo `.env` e adicione sua chave de API do YouTube:
    ```plaintext
    API_KEY=YOUR_API_KEY_HERE
    ```

5. Certifique-se de que o FFMPEG e o yt-dlp estão instalados e disponíveis no PATH do sistema.

## Uso

1. Inicie o servidor PHP:
    ```sh
    php -S localhost:8000 -t public
    ```

2. Abra seu navegador e acesse `http://localhost:8000`.

3. Digite o nome da música que deseja converter e clique em "Converter para MP3".

## Estrutura do Projeto

- `public/`: Contém os arquivos públicos acessíveis via web.
- `src/`: Contém o código-fonte da aplicação.
- `vendor/`: Contém as dependências instaladas pelo Composer.

## Dependências

- [google/apiclient](https://github.com/googleapis/google-api-php-client)
- [norkunas/youtube-dl-php](https://github.com/norkunas/youtube-dl-php)
- [php-ffmpeg/php-ffmpeg](https://github.com/PHP-FFMpeg/PHP-FFMpeg)
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)

## Licença

Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contribuição

1. Faça um fork do projeto.
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`).
3. Commit suas mudanças (`git commit -am 'Adiciona nova feature'`).
4. Faça um push para a branch (`git push origin feature/nova-feature`).
5. Crie um novo Pull Request.

## Contato

Para mais informações, entre em contato comigo.
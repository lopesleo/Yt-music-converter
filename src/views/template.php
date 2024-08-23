<?php
namespace Src\Views;

class Template
{
    public static function render($message = '')
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Conversor de Música YouTube para MP3</title>
            <link rel="stylesheet" href="/musica/public/assets/css/style.css">
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
                <div id="loading" style="display:none;">
                    <div class="spinner"></div>
                    <p>Processando...</p>
                </div>
                <div class="result">
                    <?php echo $message; ?>
                </div>
            </div>
            <script src="/musica/public/assets/js/script.js"></script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

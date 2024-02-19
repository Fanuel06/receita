<?php
session_start();

if (isset($_POST['codigo_verificacao']) && isset($_SESSION['codigo_verificacao'])) {
    $codigo_usuario = $_POST['codigo_verificacao'];
    $codigo_gerado = $_SESSION['codigo_verificacao'];

    if ($codigo_usuario == $codigo_gerado) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../styles/style-confirmarCodigo.css">
            <title>Código Verificado</title>
        </head>

        <body>
            <div class="container">
                <div id="div1">
                    <h1>Código Verificado com Sucesso</h1>
                    <p>O seu código foi verificado com sucesso. Você pode prosseguir para a página de login.</p>
                </div>
                <div class="link-container">
                    <a href="login.php">Ir para a página de Login</a>
                </div>
            </div>
        </body>

        </html>
        <?php
        exit;
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script>
                alert("Código de verificação incorreto. Por favor, tente novamente.");
                window.history.back();
            </script>
        </head>

        <body>
        </body>

        </html>
        <?php
        exit;
    }
} else {
    echo "Código de verificação não foi submetido.";
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../Exception.php";
require "../PHPMailer.php";
require "../SMTP.php";
session_start();

include('../../config.php');

$usuario = $_POST["usuario"];
$email = $_POST['email'];

$sql_verificar_usuario = "SELECT * FROM login WHERE email = :email and usuario = :usuario";
$stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
$stmt_verificar_usuario->bindParam(":email", $email);
$stmt_verificar_usuario->bindParam(":usuario", $usuario);
$stmt_verificar_usuario->execute();
$resultado = $stmt_verificar_usuario->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'financafacil@imaxsi.com';
        $mail->Password = 'FinancaFacil@1';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('financafacil@imaxsi.com', 'ReceitasDespesas');
        $mail->addAddress($email);
        $mail->isHTML(true);

        // Aqui está o link para a página que você deseja enviar por e-mail
        $link_pagina = "http://localhost/Proz/usuario/EsqueceuSenha/redefinirSenha.php";

        $mail->Subject = 'Link para redefinição de senha';
        $mail->Body = "
            <h3>Prezado(a) {$resultado['nome']},</h3>
            <p>Por favor, clique no botão abaixo para redefinir sua senha:</p>
            <p><a href='{$link_pagina}'><button style='background-color: #4CAF50; color: white; padding: 15px 32px; text-align: center; display: inline-block; font-size: 16px;'>Redefinir Senha</button></a></p>
            <p>Não compartilhe esse email com ninguém.</p>
            <p>Atenciosamente,</p>
            <p>Finança Fácil</p>
            <p>Projeto Proz</p>
        ";

        $mail->send();

        // Exibindo a mensagem de sucesso e o link para voltar à página de login
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../styles/style-enviarEmailEsqueceuSenha.css">
            <title>Email Enviado com Sucesso</title>
        </head>

        <body>

            <body>
                <div class="container">
                    <div id="div1">
                        <h1>Email Enviado com Sucesso</h1>
                        <p>Um e-mail com o link para redefinir a sua senha foi enviado para o seu endereço de e-mail.</p>
                    </div>
                    <div class="link-container">
                        <a href="../login.php">Voltar para a página de Login</a>
                    </div>
                </div>

        </html>
        <?php
        exit;
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
} else {
    // Se não encontrar o e-mail ou o usuário no banco de dados, exibe uma mensagem
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../styles/style-enviarEmailEsqueceuSenha.css">
        <title>Email não encontrado</title>
    </head>

    <body>
        <div class="container">
            <div id="div1">
                <h1>Email ou Usuário não encontrado</h1>
                <p>O email ou usuário fornecido não foi encontrado em nosso sistema.</p>
                <p>Verifique o usuário e o email e tente novamente.</p>
            </div>
            <div class="link-container">
                <a href="esqueceuSenha.html">Voltar para a página de Esqueceu Senha</a>
            </div>
        </div>
    </body>

    </html>
    <?php
    exit;
}
?>
?>
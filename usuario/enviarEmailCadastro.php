<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "Exception.php";
require "PHPMailer.php";
require "SMTP.php";

include('../config.php');
session_start();

// Verifica se os dados foram recebidos corretamente
if (!isset($_GET['nome']) || !isset($_GET['email'])) {
    echo "Erro: Nome ou e-mail não foram recebidos.";
    exit;
}

$nome = $_GET['nome'];
$email = $_GET['email'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'financafacil@imaxsi.com';
    $mail->Password = 'FinancaFacil@1'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('financafacil@imaxsi.com', 'ReceitasDespesas');
    $mail->addAddress($email, $nome);
    $mail->isHTML(true);
    
    // Gera um código de verificação aleatório
    $codigo_verificacao = gerarStringAleatoria(6);
    $_SESSION['codigo_verificacao'] = $codigo_verificacao;

    $mail->Subject = 'Código de verificação para ativação de conta';
    $mail->Body = "
        <h3>Prezado(a) $nome,</h3>
        <p>Agradecemos por se cadastrar em nosso serviço. Para garantir a segurança da sua conta, solicitamos que insira o código de verificação abaixo para concluir o processo de ativação:</p>
        <p><strong>Código de Verificação:</strong> $codigo_verificacao</p>
        <p>Este código é necessário para validar e ativar sua conta. Por favor, insira-o na página de confirmação de conta para continuar aproveitando todos os recursos de nossa plataforma.</p>
        <p>Caso não tenha solicitado a ativação da conta, por favor, entre em contato conosco imediatamente.</p>
        <p>Se precisar de assistência adicional ou tiver alguma dúvida, não hesite em nos contatar.</p>
        <p>Atenciosamente,</p>
        <p>Finança Fácil</p>
        <p>Projeto Proz</p>
        <p>finançafacil@imaxsi.com</p>
        <p>+55 34 9 9763-7577</p>
    ";

    $mail->send();
    echo "Um e-mail com o código de verificação foi enviado para o seu endereço de e-mail.";

    header("Location: confirmarCodigoPag.html");
    exit;
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}

function gerarStringAleatoria($tamanho = 6) {
    $caracteres = '0123456789';
    $string_aleatoria = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $string_aleatoria .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $string_aleatoria;
}
?>
<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verifica se o e-mail está presente no banco de dados
    include('../config.php'); // Inclui o arquivo de configuração do banco de dados

    $sql = "SELECT email FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se o e-mail digitado for igual ao e-mail no banco de dados, continue com o processo de envio do e-mail de confirmação
    if ($row && $row['email'] === $email) {
        header("Location: receita.php");
        exit;
    } else {
        echo "O email digitado não está cadastrado em nosso sistema. Por favor, verifique e tente novamente.";
        // Adicione um link para voltar à página anterior
        echo '<br><a href="getEmail.html">Voltar a pagina de confirmação do email</a>';
    }
}
?>
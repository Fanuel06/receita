<?php
include "../config.php";

if ($pdo === null) {
    die("Erro na conexão com o banco de dados");
}

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];
$nome = $_POST["nome"];
$email = $_POST['email'];

$sql_check_user = "SELECT COUNT(*) AS total FROM login WHERE usuario = :usuario";
$stmt_check_user = $pdo->prepare($sql_check_user);
$stmt_check_user->bindParam(":usuario", $usuario);
$stmt_check_user->execute();
$result = $stmt_check_user->fetch(PDO::FETCH_ASSOC);

if ($result['total'] > 0) {
    echo "Nome de usuário já existe.";
    echo '<button onclick="window.history.back();">Voltar à página de criação de conta</button>';
    exit;
}

$sql_insert_user = "INSERT INTO login (nome, usuario, senha, email) VALUES (:nome, :usuario, :senha, :email)";
$stmt = $pdo->prepare($sql_insert_user);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":usuario", $usuario);
$stmt->bindParam(":senha", $senha);
$stmt->bindParam(":email", $email);
$stmt->execute();

header("Location: enviarEmailCadastro.php?nome=" . urlencode($nome) . "&email=" . urlencode($email));
exit;
?>
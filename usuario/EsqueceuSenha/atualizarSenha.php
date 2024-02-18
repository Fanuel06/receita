<?php
$titulo_pagina = "Atualizar Senha";

session_start();

include('../../config.php');

$usuario = $_POST['usuario'];
$nova_senha = $_POST['nova_senha'];

$sql_verificar_usuario = "SELECT * FROM login WHERE usuario = :usuario";
$stmt_verificar_usuario = $pdo->prepare($sql_verificar_usuario);
$stmt_verificar_usuario->bindParam(":usuario", $usuario);
$stmt_verificar_usuario->execute();
$resultado = $stmt_verificar_usuario->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $sql_atualizar_senha = "UPDATE login SET senha = :senha WHERE usuario = :usuario";
    $stmt_atualizar_senha = $pdo->prepare($sql_atualizar_senha);
    $stmt_atualizar_senha->bindParam(":senha", $nova_senha);
    $stmt_atualizar_senha->bindParam(":usuario", $usuario);
    $stmt_atualizar_senha->execute();
    echo "Sua senha foi atualizada com sucesso.";
    ?>
    <a href="../login.php">Voltar para a página de Login</a>
    <?php
} else {
    echo "Usuário não encontrado.";
}
?>
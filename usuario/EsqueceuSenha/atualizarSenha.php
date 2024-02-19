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

    // Mostrar o alerta
    echo '<script>alert("Sua senha foi atualizada com sucesso.");';
    // Redirecionar para a página de login após clicar em OK
    echo 'window.location.href = "../login.php";</script>';
} else {
    echo '<script>alert("Usuario não encontrado. Tente novamente");';
    // Redirecionar para a página de login após clicar em OK
    echo 'window.location.href = "redefinirSenha.php";</script>';
}
?>
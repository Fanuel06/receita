<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$id = $_POST['id'];
$nome = $_POST['nome'];

$table_name = "categoria_{$user_id}_{$user_name}";

$sql = "UPDATE {$table_name} SET nome = :nome WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":nome", $nome);
$stmt->bindValue(":id", $id);

if ($stmt->execute()) {
    header("Location: categoria.php");
    exit;
} else {
    echo "Erro ao editar categoria.";
}
?>
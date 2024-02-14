<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];
$table_name = "categoria_{$user_id}_{$user_name}";

$nome= $_GET["nome"];

$sql = "INSERT INTO $table_name (nome) VALUES
        (:nome)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":nome", $nome);
$stmt->execute();

header("Location: categoria.php");
exit;
?>
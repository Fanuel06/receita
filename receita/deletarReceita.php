<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$table_name = "receitas_{$user_id}_{$user_name}";

$id = $_GET["id"];

$sql = "DELETE FROM {$table_name} WHERE id = :id";
$sql = $pdo->prepare($sql);

$sql->bindValue(":id", $id);
$sql->execute();

header("Location: receita.php");
exit;
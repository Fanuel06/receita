<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$descricao = $_GET["descricao"];

$sql = "INSERT INTO categoria (descricao, id_do_usuario) VALUES (:descricao, :user_id)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":descricao", $descricao);
$stmt->bindValue(":user_id", $user_id);
$stmt->execute();

header("Location: categoria.php");
exit;
?>
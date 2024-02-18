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
$descricao = $_POST['descricao'];

if ($id == 1 || $id == 2) {
    echo "Não é possível editar essa categoria.";
    exit;
}

$sql = "UPDATE categoria SET descricao = :descricao WHERE id = :id_categoria";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":descricao", $descricao);
$stmt->bindValue(":id_categoria", $id);

if ($stmt->execute()) {
    header("Location: categoria.php");
    exit;
} else {
    echo "Erro ao editar categoria.";
}
?>
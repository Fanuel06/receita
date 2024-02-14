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

$descricao = $_GET["descricao"];
$valor = $_GET["valor"];
$data_mvto = $_GET["data_mvto"];
$categoria = $_GET["categoria"];

$sql = "INSERT INTO $table_name (descricao, valor, data_mvto, categoria_id) VALUES
        (:descricao, :valor, :data_mvto, :categoria_id)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":descricao", $descricao);
$stmt->bindValue(":valor", $valor);
$stmt->bindValue(":data_mvto", $data_mvto);
$stmt->bindValue(":categoria_id", $categoria);
$stmt->execute();

header("Location: receita.php");
exit;
?>
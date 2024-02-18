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
$valor = $_GET["valor"];
$data_mvto = $_GET["data_mvto"];
$categoria = $_GET["categoria"];
$status = $_GET["status"];

$sql = "INSERT INTO receita (descricao, valor, status_pago, data_mvto, categoria_id, id_do_usuario)
                VALUES (:descricao, :valor, :status_pago, :data_mvto, :categoria_id, :id_do_usuario)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":descricao", $descricao);
$stmt->bindValue(":valor", $valor);
$stmt->bindValue(":status_pago", $status);
$stmt->bindValue(":data_mvto", $data_mvto);
$stmt->bindValue(":categoria_id", $categoria);
$stmt->bindValue(":id_do_usuario", $user_id);
$stmt->execute();

header("Location: receita.php");
exit;
?>
<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id = $_GET['id'];
$descricao = $_GET['descricao'];
$valor = $_GET['valor'];
$status = $_GET['status'];
$data_mvto = $_GET['data_mvto'];
$categoria = $_GET['categoria'];

$sql = "SELECT * FROM receita WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id_receita", $id);
$stmt->bindValue(":user_id", $user_id);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Você não tem permissão para editar esta receita.";
    exit;
}

$sql_update = "UPDATE receita SET descricao = :descricao, valor = :valor, data_mvto = :data_mvto, categoria_id = :categoria, status_pago = :status_pago WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt_update = $pdo->prepare($sql_update);
$stmt_update->bindValue(":descricao", $descricao);
$stmt_update->bindValue(":valor", $valor);
$stmt_update->bindValue(":status_pago", $status);
$stmt_update->bindValue(":data_mvto", $data_mvto);
$stmt_update->bindValue(":categoria", $categoria);
$stmt_update->bindValue(":id_receita", $id);
$stmt_update->bindValue(":user_id", $user_id);
$stmt_update->execute();

header("Location: receita.php");
exit;
?>
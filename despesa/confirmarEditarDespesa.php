<?php
require "../config.php";

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$table_name = "despesas_{$user_id}_{$user_name}";

$id = $_GET['id'];
$descricao = $_GET['descricao'];
$valor = $_GET['valor'];
$data_mvto = $_GET['data_mvto'];
$categoria_id = $_GET['categoria'];

$sql = "UPDATE {$table_name} SET
  descricao = :descricao,
  valor = :valor,
  data_mvto = :data_mvto,
  categoria_id = :categoria_id
WHERE id = :id";

$sql = $pdo->prepare($sql);
$sql->bindValue(":descricao", $descricao);
$sql->bindValue(":valor", $valor);
$sql->bindValue(":data_mvto", $data_mvto);
$sql->bindValue(":categoria_id", $categoria_id);
$sql->bindValue(":id", $id);

$sql->execute();

header("Location: despesa.php");
exit;


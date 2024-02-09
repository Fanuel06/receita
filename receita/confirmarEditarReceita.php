<?php
require "../config.php";

$id = $_GET['id'];
$descricao = $_GET['descricao'];
$valor = $_GET['valor'];
$data_mvto = $_GET['data_mvto'];
$categoria_id = $_GET['categoria'];

$sql = "UPDATE receita SET
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

header("Location: receita.php");
exit;


<?php
require "./config.php";

$descricao = $_GET["descricao"];
$valor = $_GET["valor"];
$data_mvto = $_GET["data_mvto"];
$categoria = $_GET["categoria"];

$sql = "INSERT INTO receita (descricao, valor, data_mvto, categoria_id) VALUES
        (:descricao, :valor, :data_mvto, :categoria_id)";

$sql = $pdo->prepare($sql);
$sql->bindValue(":descricao", $descricao);
$sql->bindValue(":valor", $valor);
$sql->bindValue(":data_mvto", $data_mvto);
$sql->bindValue(":categoria_id", 1);

$sql->execute();

header("Location: receitas.html");
exit;
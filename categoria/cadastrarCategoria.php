<?php
require "../config.php";

$categoria = $_GET["categoria"];

$sql = "INSERT INTO categoria (descricao) VALUES (:descricao)";

$sql = $pdo->prepare($sql);
$sql->bindValue(":descricao", $categoria);

$sql->execute();

header("Location: categoria.php");
exit;
?>
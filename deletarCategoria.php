<?php
require "../config.php";

$id = $_GET["id"];

$sqlDeleteReceitas = "DELETE FROM receita WHERE categoria_id = :id";
$stmtDeleteReceitas = $pdo->prepare($sqlDeleteReceitas);
$stmtDeleteReceitas->bindValue(":id", $id);
$stmtDeleteReceitas->execute();

$sqlDeleteCategoria = "DELETE FROM categoria WHERE id = :id";
$stmtDeleteCategoria = $pdo->prepare($sqlDeleteCategoria);
$stmtDeleteCategoria->bindValue(":id", $id);
$stmtDeleteCategoria->execute();

header("Location: categoria.php");
exit;
?>
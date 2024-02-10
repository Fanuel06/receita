<?php
require "../config.php";

if(isset($_GET['id']) && isset($_GET['descricao'])) {
    $id = $_GET['id'];
    $descricao = $_GET['descricao'];

    $sql = "UPDATE categoria SET descricao = :descricao WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":descricao", $descricao);
    $stmt->bindValue(":id", $id);
    
    $stmt->execute();

    header("Location: categoria.php");
    exit;
}
?>
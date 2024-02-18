<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id = $_GET["id"];

$sql = "DELETE FROM despesa WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(":id_receita", $id);
$stmt->bindValue(":user_id", $user_id);
$stmt->execute();

header("Location: despesa.php");
exit;
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

$sql_delete_notifications = "DELETE FROM notificacoes WHERE id_despesa = :id_despesa";
$stmt_delete_notifications = $pdo->prepare($sql_delete_notifications);
$stmt_delete_notifications->bindValue(":id_despesa", $id);
$stmt_delete_notifications->execute();

$sql_delete_despesa = "DELETE FROM despesa WHERE id = :id_despesa AND id_do_usuario = :user_id";
$stmt_delete_despesa = $pdo->prepare($sql_delete_despesa);
$stmt_delete_despesa->bindValue(":id_despesa", $id);
$stmt_delete_despesa->bindValue(":user_id", $user_id);
$stmt_delete_despesa->execute();

header("Location: despesa.php");
exit;
?>
<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id_notificacao = $_GET["id_not"];

// Consulta para atualizar o status_pago na tabela receita
$sql_update_receita = "UPDATE receita SET status_pago = 'Recebido' WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt_update_receita = $pdo->prepare($sql_update_receita);
$stmt_update_receita->bindParam(':id_receita', $id_notificacao, PDO::PARAM_INT);
$stmt_update_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_update_receita->execute();

// Remover a notificação após a receita ter sido recebida
$sql_delete_notificacao = "DELETE FROM notificacoes WHERE id = :id_notificacao AND user_id = :user_id";
$stmt_delete_notificacao = $pdo->prepare($sql_delete_notificacao);
$stmt_delete_notificacao->bindValue(":id_notificacao", $id_notificacao, PDO::PARAM_INT);
$stmt_delete_notificacao->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$stmt_delete_notificacao->execute();

header("Location: receita.php");
exit;
?>
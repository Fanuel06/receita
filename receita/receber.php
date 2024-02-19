<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id_receita = $_GET["id_receita"];

// Capturar o id_notificacao para remover a notificação
$id_notificacao = $_GET["id_notificacao"];

// Verificar se o id_receita não está vazio
if (!empty($id_receita)) {
  // Atualiza o status da receita para "Recebido"
  $sql_update_receita = "UPDATE receita SET status_pago = 'Recebido' WHERE id = :id_receita AND id_do_usuario = :user_id";
  $stmt_update_receita = $pdo->prepare($sql_update_receita);
  $stmt_update_receita->bindParam(':id_receita', $id_receita, PDO::PARAM_INT);
  $stmt_update_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt_update_receita->execute();
}

if (!empty($id_notificacao)) {
  // Remover a notificação correspondente
  $sql_delete_notificacao = "DELETE FROM notificacoes WHERE id = :id_notificacao AND user_id = :user_id";
  $stmt_delete_notificacao = $pdo->prepare($sql_delete_notificacao);
  $stmt_delete_notificacao->bindValue(":id_notificacao", $id_notificacao, PDO::PARAM_INT);
  $stmt_delete_notificacao->bindValue(":user_id", $user_id, PDO::PARAM_INT);
  $stmt_delete_notificacao->execute();
}

header("Location: notificacoesReceita.php");
exit;
?>
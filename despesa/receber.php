<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id_despesa = $_GET["id_despesa"];

// Capturar o id_notificacao para remover a notificação
$id_notificacao = $_GET["id_notificacao"];

// Verificar se o id_despesa não está vazio
if (!empty($id_despesa)) {
  // Atualiza o status da despesa para "Pago"
  $sql_update_despesa = "UPDATE despesa SET status_pago = 'Pago' WHERE id = :id_despesa AND id_do_usuario = :user_id";
  $stmt_update_despesa = $pdo->prepare($sql_update_despesa);
  $stmt_update_despesa->bindParam(':id_despesa', $id_despesa, PDO::PARAM_INT);
  $stmt_update_despesa->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt_update_despesa->execute();
}

if (!empty($id_notificacao)) {
  // Remover a notificação correspondente
  $sql_delete_notificacao = "DELETE FROM notificacoes WHERE id = :id_notificacao AND user_id = :user_id";
  $stmt_delete_notificacao = $pdo->prepare($sql_delete_notificacao);
  $stmt_delete_notificacao->bindValue(":id_notificacao", $id_notificacao, PDO::PARAM_INT);
  $stmt_delete_notificacao->bindValue(":user_id", $user_id, PDO::PARAM_INT);
  $stmt_delete_notificacao->execute();
}

header("Location: ./notificacoesDespesa.php");
exit;
?>
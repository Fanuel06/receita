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

$sql_verificar_notificacao = "SELECT id FROM notificacoes WHERE id_receita = :id_receita AND user_id = :user_id";
$stmt_verificar_notificacao = $pdo->prepare($sql_verificar_notificacao);
$stmt_verificar_notificacao->bindParam(':id_receita', $id, PDO::PARAM_INT);
$stmt_verificar_notificacao->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_verificar_notificacao->execute();
$notificacao = $stmt_verificar_notificacao->fetch(PDO::FETCH_ASSOC);

if ($notificacao) {
    echo "Notificação encontrada. ID da notificação: " . $notificacao['id'] . "<br>";
} else {
    echo "Nenhuma notificação encontrada para esta receita.<br>";
}

if ($notificacao) {
    $sql_delete_notificacao = "DELETE FROM notificacoes WHERE id = :id_notificacao";
    $stmt_delete_notificacao = $pdo->prepare($sql_delete_notificacao);
    $stmt_delete_notificacao->bindValue(":id_notificacao", $notificacao['id'], PDO::PARAM_INT);
    $stmt_delete_notificacao->execute();

    echo "Notificação excluída.<br>";
} else {
    echo "Nenhuma notificação para excluir.<br>";
}

$sql_delete_receita = "DELETE FROM receita WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt_delete_receita = $pdo->prepare($sql_delete_receita);
$stmt_delete_receita->bindParam(':id_receita', $id, PDO::PARAM_INT);
$stmt_delete_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_delete_receita->execute();

echo "Receita excluída.<br>";

header("Location: receita.php");
exit;
?>
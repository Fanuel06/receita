<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$sql_despesas_a_pagar = "SELECT * FROM despesa WHERE id_do_usuario = :user_id AND status_pago = 'A-pagar' AND data_mvto <= CURDATE()";
$stmt_despesas_a_pagar = $pdo->prepare($sql_despesas_a_pagar);
$stmt_despesas_a_pagar->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesas_a_pagar->execute();
$despesas_a_pagar = $stmt_despesas_a_pagar->fetchAll(PDO::FETCH_ASSOC);

$sql_notificacoes = "SELECT * FROM notificacoes WHERE user_id = :user_id";
$stmt_notificacoes = $pdo->prepare($sql_notificacoes);
$stmt_notificacoes->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_notificacoes->execute();
$notificacoes = $stmt_notificacoes->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notificações</title>
  <link rel="stylesheet" href="../styles/reset.css">
  <link rel="stylesheet" href="../styles/style-notificacao.css">
</head>

<body>
<header>
    <img src="./../Imagens/logo-finanç-branco.png" alt="">
        <div class="paginas">
            <ul>
                <li><a href="../receita/receita.php">Receitas</a></li>
                <li><a href="./despesa.php">Despesas</a></li>
                <li><a href="../categoria/categoria.php">Categorias</a></li>
                <li><a href="../graficos.php">Controle Finaceiro</a></li>    
            </ul>
        </div>
</header>
  <main>
    <section class="notificacoes">
      <h1>Notificações</h1>
      <table>
        <thead>
          <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notificacoes as $notificacao): ?>
            <tr>
              <td>
                <?= $notificacao['data'] ?>
              </td>
              <td>
                <?= $notificacao['descricao'] ?>
              </td>
              <td><a href="receber.php?id_notificacao=<?= $notificacao['id'] ?>&id_despesa=<?= $notificacao['id_despesa'] ?>"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>
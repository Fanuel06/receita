<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$sql_receitas_a_receber = "SELECT * FROM receita WHERE id_do_usuario = :user_id AND status_pago = 'A-receber' AND data_mvto <= CURDATE()";
$stmt_receitas_a_receber = $pdo->prepare($sql_receitas_a_receber);
$stmt_receitas_a_receber->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receitas_a_receber->execute();
$receitas_a_receber = $stmt_receitas_a_receber->fetchAll(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="../styles/style-notificacoes.css">
</head>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="../receita/receita.php">Receitas</a></li>
        <li><a href="../despesa/despesa.php">Despesas</a></li>
        <li><a href="../categoria/categoria.php">Categorias</a></li>
        <li><a href="../usuario/login.php">Voltar para a página de login</a></li>
      </ul>
    </nav>
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
                <?php 
                  //remover o id 
                  $descricao = preg_replace("/\(.*?\):/", ":", $notificacao['descricao']);
                  echo $descricao;
                ?>
              </td>
              <td><a href="receber.php?id_notificacao=<?= $notificacao['id'] ?>&id_receita=<?= $notificacao['id_receita'] ?>"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>
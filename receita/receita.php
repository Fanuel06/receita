<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$sql_total_notificacoes = "SELECT COUNT(*) AS total FROM notificacoes WHERE user_id = :user_id";
$stmt_total_notificacoes = $pdo->prepare($sql_total_notificacoes);
$stmt_total_notificacoes->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_total_notificacoes->execute();
$total_notificacoes = $stmt_total_notificacoes->fetchColumn();

$sql_receita = "SELECT * FROM receita WHERE id_do_usuario = :user_id";
$stmt_receita = $pdo->prepare($sql_receita);
$stmt_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita->execute();
$dados = $stmt_receita->fetchAll(PDO::FETCH_ASSOC);

$sql_categoria = "SELECT * FROM categoria WHERE id_do_usuario = :user_id OR descricao IN ('Salário', 'Bônus')";
$stmt_categoria = $pdo->prepare($sql_categoria);
$stmt_categoria->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$dadosCat = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

// Verificar se há receitas a receber cuja data foi atingida
$sql_receitas_a_receber = "SELECT * FROM receita WHERE id_do_usuario = :user_id AND status_pago = 'A-receber' AND data_mvto <= CURDATE()";
$stmt_receitas_a_receber = $pdo->prepare($sql_receitas_a_receber);
$stmt_receitas_a_receber->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receitas_a_receber->execute();
$receitas_a_receber = $stmt_receitas_a_receber->fetchAll(PDO::FETCH_ASSOC);

// Inserir notificações para as receitas a receber cuja data foi atingida
// Inserir notificações para as receitas a receber cuja data foi atingida
foreach ($receitas_a_receber as $receita) {
  $id_receita = $receita['id']; // Definindo o ID da receita

  $descricao = "Receita a receber (" . $id_receita . "): " . $receita['descricao']; // Concatenando o ID da receita com a descrição

  // Verificar se a notificação já existe antes de inseri-la novamente
  $sql_verificar_notificacao = "SELECT COUNT(*) AS count FROM notificacoes WHERE user_id = :user_id AND descricao = :descricao";
  $stmt_verificar_notificacao = $pdo->prepare($sql_verificar_notificacao);
  $stmt_verificar_notificacao->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt_verificar_notificacao->bindParam(':descricao', $descricao, PDO::PARAM_STR);
  $stmt_verificar_notificacao->execute();
  $result_verificar_notificacao = $stmt_verificar_notificacao->fetch(PDO::FETCH_ASSOC);

  if ($result_verificar_notificacao['count'] == 0) {
    // A notificação não existe, então inseri-la
    $data = date("Y-m-d"); // Data atual
    $sql_inserir_notificacao = "INSERT INTO notificacoes (user_id, descricao, id_receita, data) VALUES (:user_id, :descricao, :id_receita, :data)";
    $stmt_inserir_notificacao = $pdo->prepare($sql_inserir_notificacao);
    $stmt_inserir_notificacao->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_inserir_notificacao->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt_inserir_notificacao->bindParam(':id_receita', $id_receita, PDO::PARAM_INT); // Usando PDO::PARAM_INT para o ID da receita
    $stmt_inserir_notificacao->bindParam(':data', $data, PDO::PARAM_STR);
    $stmt_inserir_notificacao->execute();
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receitas</title>
  <link rel="stylesheet" href="./../styles/reset.css">
  <link rel="stylesheet" href="./../styles/style-receita.css">
</head>

<body>


  <header>
    <img src="./../imagens/logo-finanç-branco.png" alt="">
    <div class="paginas">
      <ul>
        <li><a href="./../receita/receita.php">Receitas</a></li>
        <li><a href="./../despesa/despesa.php">Despesas</a></li>
        <li><a href="./../categoria/categoria.php">Categorias</a></li>
        <li><a href="../grafico.php">Controle Finaceiro</a></li>
        <li><a href="./notificacoesDespesa.php">Notificações
            <?php if ($total_notificacoes > 0)
              echo " ($total_notificacoes)"; ?>
          </a></li>
        <li><a href="../pag-inicial.html">Voltar para a página inicial</a></li>
      </ul>
    </div>
  </header>
  <main>
    <form class="pesquisar-receita" action="pesquisarReceita.php" method="GET">
      <label for="categoria">Pesquisar Receitas por Categoria:</label>
      <select name="categoria" id="categoria" required>
        <option value="">Selecione uma categoria</option>
        <?php foreach ($dadosCat as $categoria): ?>
          <option value="<?= $categoria['id'] ?>">
            <?= $categoria['descricao'] ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Pesquisar</button>
    </form>
    <section class="formulario">
      <form action="./cadastrarReceita.php" method="get">

        <label>
          Descrição
          <input type="text" name="descricao" required>
        </label>

        <label>
          Valor
          <input type="text" name="valor" required pattern="^[1-9]\d*(\.\d+)?$"
            title="Por favor, insira um número válido acima de 0 (ex: 10 ou 10.50 lembre de utilizar '.' ao invés de ','">
        </label>

        <label>
          Categoria
          <select name="categoria" required>
            <?php foreach ($dadosCat as $categoria): ?>
              <option value="<?= $categoria['id'] ?>">
                <?= $categoria['descricao'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>
          Status
          <select name="status" required>
            <option value="Recebido">
              Recebido
            </option>
            <option value="A-receber">
              A receber
            </option>
          </select>
        </label>
        <label>
          Data
          <input type="date" name="data_mvto" required>
        </label>

        <button type="submit">Adicionar</button>

      </form>
    </section>

    <section class="tabela">
      <table>
        <thead>
          <tr>
            <th>Número</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Categoria</th>
            <th>Status</th>
            <th>Data</th>
            <th>Opções</th>
            <th><a target="_blank" href="emitirPDF.php">Emitir Relatório</a></th>
          </tr>
        </thead>
        <tbody>
          <?php $numero = 1; ?>
          <?php foreach ($dados as $dado): ?>
            <tr>
              <td>
                <?= $numero++ ?>
              </td>
              <td>
                <?= $dado['descricao'] ?>
              </td>
              <td>
                <?= $dado['valor'] ?>
              </td>
              <td>
                <?php
                $categoriaEncontrada = '';
                foreach ($dadosCat as $categoria) {
                  if ($categoria['id'] == $dado['categoria_id']) {
                    $categoriaEncontrada = $categoria['descricao'];
                    break;
                  }
                }
                echo $categoriaEncontrada;
                ?>
              </td>
              <td>
                <?= $dado['status_pago'] ?>
              </td>
              <td>
                <?= $dado['data_mvto'] ?>
              </td>
              <td>
                <a href="deletarReceita.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                <a href="editarReceita.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$sql_receita = "SELECT * FROM despesa WHERE id_do_usuario = :user_id";
$stmt_receita = $pdo->prepare($sql_receita);
$stmt_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita->execute();
$dados = $stmt_receita->fetchAll(PDO::FETCH_ASSOC);


$sql_categoria = "SELECT * FROM categoria WHERE id_do_usuario = :user_id OR descricao IN ('Salário', 'Bônus')";
$stmt_categoria = $pdo->prepare($sql_categoria);
$stmt_categoria->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$dadosCat = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Despesa</title>
  <link rel="stylesheet" href="../styles/style-receita.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="../receitas/receita.php">Receitas</a></li>
        <li><a href="../categoria/categoria.php">Categorias</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="formulario">
      <form action="./cadastrarDespesa.php" method="get">

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
            <option value="Pago">
              Pago
            </option>
            <option value="A-pagar">
              A pagar
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
                <a href="deletarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                <a href="editarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
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
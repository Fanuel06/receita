<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$table_name = "receitas_{$user_id}_{$user_name}";

$sql_receita = "SELECT * FROM {$table_name}";
$stmt_receita = $pdo->prepare($sql_receita);
$stmt_receita->execute();
$dados = $stmt_receita->fetchAll(PDO::FETCH_ASSOC);


$sql_categoria = "SELECT * FROM categoria_{$user_id}_{$user_name}";
$stmt_categoria = $pdo->prepare($sql_categoria);
$stmt_categoria->execute();
$dadosCat = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Receitas</title>
  <link rel="stylesheet" href="../styles/style-receita.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="../despesa/despesa.php">Despesas</a></li>
        <li><a href="../categoria/categoria.php">Categorias</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="formulario">
      <form action="./cadastrarReceita.php" method="get">

        <label>
          Descrição
          <input type="text" name="descricao" required>
        </label>

        <label>
          Valor
          <input type="number" name="valor" required>
        </label>

        <label>
          Categoria
          <select name="categoria" required>
            <option value=""></option>
            <?php foreach ($dadosCat as $categoria): ?>
              <option value="<?= $categoria['id'] ?>">
                <?= $categoria['nome'] ?>
              </option>
            <?php endforeach; ?>
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
            <th>Data</th>
            <th>Opções</th>
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
                    $categoriaEncontrada = $categoria['nome'];
                    break;
                  }
                }
                echo $categoriaEncontrada;
                ?>
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
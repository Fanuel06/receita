<?php
require "../config.php";

$sql = "SELECT * FROM despesa";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM categoria";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$dadosCat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Despesas</title>
  <link rel="stylesheet" href="../styles/style-receita.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="..//receita/receita.php">Receitas</a></li>
        <li><a href="..//categoria/categoria.php">Categorias</a></li>
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
          <input type="number" name="valor" required>
        </label>

        <label>
          Categoria
          <select name="categoria" required>
            <option value=""></option>
            <?php foreach ($dadosCat as $categoria): ?>
              <option value="<?= $categoria['id'] ?>">
                <?= $categoria['descricao'] ?>
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
                    $categoriaEncontrada = $categoria['descricao'];
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
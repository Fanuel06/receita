<?php
require "./config.php";

$sql = "SELECT * FROM receita";
$sql = $pdo->prepare($sql);
$sql->execute();

$dados = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Receitas</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="#">Receitas</a></li>
        <li><a href="#">Despesas</a></li>
        <li><a href="#">Categorias</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="formulario">
      <form action="./cadastrarReceita.php" method="get">

        <label>
          Descrição
          <input type="text" name="descricao">
        </label>

        <label>
          valor
          <input type="number" name="valor">
        </label>

        <label>
          Categoria
          <select name="categoria">
            <option value=""></option>
            <option value="salario">Salário</option>
            <option value="bonus">Bonus</option>
            <option value="premio">Prêmio</option>
            <option value="vale">Vale Alimentação</option>
          </select>
        </label>

        <label>
          Data
          <input type="date" name="data_mvto">
        </label>

        <button type="submit">Adicionar</button>


      </form>
    </section>
    <section class="tabela">

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($dados as $dado) : ?>
            <tr>
              <td><?= $dado['id'] ?></td>
              <td><?= $dado['descricao'] ?></td>
              <td><?= $dado['valor'] ?></td>
              <td><?= $dado['data_mvto'] ?></td>
              <td>
                <a href="./deletar.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
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
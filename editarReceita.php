<?php
require "./config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM receitas WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
$item = $sql->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM receitas";
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
        <li><a href="./receitas.php">Receitas</a></li>
        <li><a href="#">Despesas</a></li>
        <li><a href="#">Categorias</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="formulario">
      <form action="./confirmarEditarReceita.php" method="get">

        <input type="hidden" name="id" value="<?= $id; ?>">

        <label>
          Descrição
          <input type="text" name="descricao" value="<?= $item['descricao'] ?>">
        </label>

        <label>
          valor
          <input type="number" name="valor" value="<?= $item['valor']; ?>">
        </label>

        <label>
          Categoria
          <select name="categoria">
            <option value="salario">Salário</option>
            <option value="bonus">Bonus</option>
            <option value="premio">Prêmio</option>
            <option value="vale">Vale Alimentação</option>
          </select>
        </label>

        <label>
          Data
          <input type="date" name="data_mvto" value="<?= $item['data_mvto'] ?>">
        </label>

        <button type="submit">Editar</button>


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
                <a href="./editarReceita.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </section>
  </main>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>


</html>ed
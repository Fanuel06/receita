<?php
require "../config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM despesa WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
$item = $sql->fetch(PDO::FETCH_ASSOC);

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

  <title>Editar Despesas</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="..//despesa/despesa.php">Despesas</a></li>
        <li><a href="..//receita/receita.php">Receitas</a></li>
        <li><a href="..//categoria/categoria.php">Categorias</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="formulario">
      <form action="./confirmarEditarDespesa.php" method="get">

        <input type="hidden" name="id" value="<?= $id; ?>" required>

        <label>
          Descrição
          <input type="text" name="descricao" value="<?= $item['descricao'] ?>" required>
        </label>

        <label>
          valor
          <input type="number" name="valor" value="<?= $item['valor']; ?>" required>
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
          <input type="date" name="data_mvto" value="<?= $item['data_mvto'] ?>" required>
        </label>

        <button type="submit">Editar</button>

      </form>
    </section>
  </main>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>

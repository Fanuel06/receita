<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$table_name = "despesas_{$user_id}_{$user_name}";

$id = $_GET['id'];

$sql = "SELECT * FROM {$table_name} WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
$item = $sql->fetch(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
  <header>
    <nav>
      <ul class="rem">
        <li><a href="../receitas/receitas.php">Receitas</a></li>
        <li><a href="#">Categorias</a></li>
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
                <?= $categoria['nome'] ?>
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
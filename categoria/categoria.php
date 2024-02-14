<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$table_name = "categoria_{$user_id}_{$user_name}";

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
        <li><a href="..//receita/receita.php">Receitas</a></li>
        <li><a href="#">Despesas</a></li>
        <li><a href="#">Categorias</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="formulario">
      <form action="./cadastrarCategoria.php" method="get">

        <label>
          Categoria
          <input type="text" name="nome" required>
        </label>
        <label>
          <button type="submit">Adicionar</button>
        </label>
      </form>
    </section>
    <section class="categoriaSalvas">
      <table>
        <thead>
          <tr>
            <th>Categorias</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dadosCat as $categoria): ?>
            <tr>
              <td>
                <?= $categoria['nome'] ?>
              </td>
              <td>
                <a href="./deletarCategoria.php?id=<?= $categoria['id'] ?>">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
              <td>
                <a href="./editarCategoria.php?id=<?= $categoria['id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
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
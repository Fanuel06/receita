<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$sql_categoria = "SELECT * FROM categoria WHERE id_do_usuario = :user_id OR descricao IN ('Salário', 'Bônus','Alimentação', 'Moradia')";
$stmt_categoria = $pdo->prepare($sql_categoria);
$stmt_categoria->bindParam(':user_id', $user_id);
$stmt_categoria->execute();
$dadosCat = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Categorias</title>
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
          <input type="text" name="descricao" required>
        </label>
        <label>
          <button type="submit">Adicionar</button>
        </label>
      </form>
    </section>
    <section class="categoriaSalvas">
      <?php if (!empty($dadosCat)): ?>
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
                  <?= $categoria['descricao'] ?>
                </td>
                <td>
                  <?php if ($categoria['id'] != 1 && $categoria['id'] != 2 && $categoria['id'] != 3 && $categoria['id'] != 4): ?>
                    <a href="./deletarCategoria.php?id=<?= $categoria['id'] ?>">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                    <a href="./editarCategoria.php?id=<?= $categoria['id'] ?>">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                  <?php else: ?>
                    <a href="#" onclick="DeletarCategoriaJS()">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                    <a href="#" onclick="EditarCategoriaJS()">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Não há categorias para exibir.</p>
      <?php endif; ?>
    </section>
  </main>
  <script>
    function EditarCategoriaJS() {
      alert("Não é possível editar categorias padrões.");
    }
    function DeletarCategoriaJS() {
      alert("Não é possível deletar categorias padrões.");
    }
  </script>
  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>
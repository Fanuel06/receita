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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./../styles/reset.css">
  <link rel="stylesheet" href="./../styles/style-categoria.css">
</head>

<body>
  <header>
    <img src="./../imagens/logo-finanç-branco.png" alt="">
    <div class="paginas">
    <ul>
        <li><a href="/Proz/receita/receita.php">Receitas</a></li>
        <li><a href="despesa/despesa.php">Despesas</a></li>
        <li><a href="categoria/categoria.php">Categorias</a></li>
        <li><a href="../grafico.php">Controle Finaceiro</a></li>    
    </ul>
  </div>
  </header>

  <main>
    <section class="formulario">
      <form action="./cadastrarCategoria.php" method="get">

        <label>
          <p>Categoria</p>
          <input class="input-categoria" type="text" name="descricao" required>
        </label>
        <label>
          <button class="botao-categoria" type="submit">Adicionar</button>
        </label>
      </form>
    </section>

    <section class="categoriaSalvas">
      <?php if (!empty($dadosCat)): ?>
        <table class="tabela">
          <thead>
            <tr>
              <th>Categorias</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dadosCat as $categoria): ?>
              <tr>
                <td class="conteudo-tabela">
                  <?= $categoria['descricao'] ?>
                </td>

                <td class="td-opcoes">
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

  <footer>
    <p class="copy"><i class="bi bi-c-circle">Todos os direitos reservados.</i></p>
  </footer>

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
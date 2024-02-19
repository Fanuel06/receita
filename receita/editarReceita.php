<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$id = $_GET['id'];

$sql = "SELECT * FROM receita WHERE id = :id_receita AND id_do_usuario = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id_receita", $id); // Corrigido para :id_receita
$stmt->bindValue(":user_id", $user_id);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

$sql_categoria = "SELECT * FROM categoria WHERE id_do_usuario = :user_id OR descricao IN ('Salário', 'Bônus')";
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
  <title>Receitas</title>
  <link rel="stylesheet" href="./../styles/reset.css">
  <link rel="stylesheet" href="./../styles/style-editarReceita.css">
</head>

<body>
<header>
    <img src="./../imagens/logo-finanç-branco.png" alt="">
    <div class="paginas">
        <ul>
            <li><a href="./../receita/receita.php">Receitas</a></li>
            <li><a href="./../despesa/despesa.php">Despesas</a></li>
            <li><a href="./../categoria/categoria.php">Categorias</a></li>
            <li><a href="#">Controle Finaceiro</a></li>    
        </ul>
    </div>
  </header>

  <main>
    <section class="formulario">
      <form action="./confirmarEditarReceita.php" method="get">

        <input type="hidden" name="id" value="<?= $id; ?>" required>

        <label>
          Descrição
          <input type="text" name="descricao" value="<?= $item['descricao'] ?>" required>
        </label>

        <label>
          Valor
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
          Status
          <select name="status" required>
            <option value="Recebido">
              Recebido
            </option>
            <option value="A-receber">
              A receber
            </option>
          </select>
        </label>
        <label>
          Data
          <input type="date" name="data_mvto" value="<?= $item['data_mvto'] ?>" required>
        </label>

        <button class="botao-categoria" type="submit">Editar</button>

      </form>
    </section>
  </main>

  <footer>
        <p class="copy"><i class="bi bi-c-circle">Todos os direitos reservados.</i></p>
    </footer>


  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>
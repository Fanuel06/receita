<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$dados = []; // Inicialize a variável $dados para armazenar os resultados da pesquisa

$sql_categoria = "SELECT * FROM categoria WHERE id_do_usuario = :user_id";
$stmt_categoria = $pdo->prepare($sql_categoria);
$stmt_categoria->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$dadosCat = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria_selecionada = $_GET['categoria'];

    $sql_despesa = "SELECT * FROM despesa 
                WHERE categoria_id = :categoria_selecionada
                AND id_do_usuario = :user_id";
    $stmt_despesa = $pdo->prepare($sql_despesa);
    $stmt_despesa->bindParam(':categoria_selecionada', $categoria_selecionada, PDO::PARAM_INT);
    $stmt_despesa->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_despesa->execute();
    $dados = $stmt_despesa->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Despesas por Categoria</title>
    <link rel="stylesheet" href="../styles/style-pesquisar.css">
</head>

<body>
    <header class="header">
        <nav class="nav">
            <ul class="nav-list">
                <li><a href="../receita/receita.php">Receitas</a></li>
                <li><a href="../despesa/despesa.php">Despesas</a></li>
                <li><a href="../categoria/categoria.php">Categorias</a></li>
                <li><a href="../usuario/login.php">Voltar para a página de login</a></li>
            </ul>
        </nav>
    </header>
    <main class="main">
        <section class="results">
            <?php if (!empty($dados)): ?>
            <h2>Resultados da Pesquisa:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $numero = 1; ?>
                    <?php foreach ($dados as $dado): ?>
                    <tr>
                        <td><?= $numero++ ?></td>
                        <td><?= isset($dado['descricao']) ? $dado['descricao'] : '' ?></td>
                        <td><?= isset($dado['valor']) ? $dado['valor'] : '' ?></td>
                        <td><?= isset($dado['status_pago']) ? $dado['status_pago'] : '' ?></td>
                        <td><?= isset($dado['data_mvto']) ? $dado['data_mvto'] : '' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </section>
    </main>
    <footer class="footer">
        <p class="copy">Seu texto de direitos autorais aqui</p>
    </footer>
</body>

</html>
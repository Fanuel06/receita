<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['usuario'];

$id_categoria = $_GET["id"];

// IDs das categorias que não podem ser excluídas
$categorias_protegidas = array(1, 2, 3, 4);

if (in_array($id_categoria, $categorias_protegidas)) {
    echo "<p>Não é possível excluir esta categoria.</p>";
    echo "<p><a href='categoria.php'>Voltar para a página de Categorias</a></p>";
} else {
    // Verificar se há receitas associadas a esta categoria
    $sql_check_receitas = "SELECT * FROM receita WHERE categoria_id = :id_categoria";
    $stmt_check_receitas = $pdo->prepare($sql_check_receitas);
    $stmt_check_receitas->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    $stmt_check_receitas->execute();
    $receitas_associadas = $stmt_check_receitas->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($receitas_associadas)) {
        echo "<h2>Receitas associadas à categoria selecionada:</h2>";
        echo "<ul>";
        foreach ($receitas_associadas as $receita) {
            echo "<li>{$receita['descricao']}</li>";
        }
        echo "</ul>";
        echo "<p>Por favor, remova ou atualize estas receitas antes de excluir a categoria.</p>";
        echo "<p><a href='../receita/receita.php'>Voltar para a página de Receitas</a></p>";
    } else {
        // Não há receitas associadas, pode excluir a categoria
        $sql_delete_categoria = "DELETE FROM categoria WHERE id = :id_categoria";
        $stmt_delete_categoria = $pdo->prepare($sql_delete_categoria);
        $stmt_delete_categoria->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt_delete_categoria->execute();

        header("Location: categoria.php");
        exit;
    }
}
?>
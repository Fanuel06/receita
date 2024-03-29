<?php
require "../config.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM categoria WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <header>
        <h1>Professor lindaO!!!</h1>
        <nav>
            <ul class="rem">
                <li><a href="../despesa/despesa.php">Despesas</a></li>
                <li><a href="../receita/receita.php">Receitas</a></li>
                <li><a href="../categoria/categoria.php">Categorias</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="formulario">
            <form action="./confirmarEditarCategoria.php" method="get">
                <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                <label>
                    Categoria
                    <input type="text" name="descricao" value="<?= $categoria['descricao'] ?>" required>
                </label>
                <button type="submit">Editar</button>
            </form>
        </section>
    </main>
    <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
?>
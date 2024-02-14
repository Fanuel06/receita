<?php
include "../config.php";

// Verifica se a conexão com o banco de dados foi estabelecida corretamente
if ($pdo === null) {
    die("Erro na conexão com o banco de dados");
}

// Evite usar dados do tipo $_GET para inserções no banco de dados sem sanitização adequada
$usuario = $_GET["usuario"];
$senha = $_GET["senha"];
$nome = $_GET["nome"];

// Verifica se o usuário já existe na tabela
$sql_check_user = "SELECT COUNT(*) AS total FROM login WHERE usuario = :usuario";
$stmt_check_user = $pdo->prepare($sql_check_user);
$stmt_check_user->bindParam(":usuario", $usuario);
$stmt_check_user->execute();
$result = $stmt_check_user->fetch(PDO::FETCH_ASSOC);

if ($result['total'] > 0) {
    echo "Nome de usuário já existe.";
    echo '<button onclick="window.history.back();">Voltar à página de criação de conta</button>';
    exit; // ou redirecione o usuário de volta ao formulário de cadastro
}

// Prepare a consulta SQL para evitar injeção de SQL
$sql_insert_user = "INSERT INTO login (nome, usuario, senha) VALUES (:nome, :usuario, :senha)";
$stmt = $pdo->prepare($sql_insert_user);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":usuario", $usuario);
$stmt->bindParam(":senha", $senha);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Novo usuário inserido com sucesso\n";

    // Obtenha o ID do usuário recém-inserido
    $user_id = $pdo->lastInsertId();

    // Criar um nome de tabela único e seguro para cada usuário
    $categoria_table_name = "categoria_" . $user_id . "_" . $usuario;
    $receitas_table_name = "receitas_" . $user_id . "_" . $usuario;
    $despesas_table_name = "despesas_" . $user_id . "_" . $usuario;

    $sql_create_categoria_table = "CREATE TABLE IF NOT EXISTS $categoria_table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL
    )";

    $sql_create_receitas_table = "CREATE TABLE IF NOT EXISTS $receitas_table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        descricao VARCHAR(255) NOT NULL,
        valor DECIMAL(10, 2) NOT NULL,
        data_mvto DATE,
        categoria_id INT,
 
        FOREIGN KEY (categoria_id) REFERENCES $categoria_table_name(id)
    )";

    $sql_create_despesas_table = "CREATE TABLE IF NOT EXISTS $despesas_table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        descricao VARCHAR(255) NOT NULL,
        valor DECIMAL(10, 2) NOT NULL,
        data_mvto DATE,
        categoria_id INT,
        FOREIGN KEY (categoria_id) REFERENCES $categoria_table_name(id)
    )";

    $pdo->query($sql_create_categoria_table);
    $pdo->query($sql_create_receitas_table);
    $pdo->query($sql_create_despesas_table);
    
    $sql_insert_categoria = "INSERT INTO $categoria_table_name (nome) VALUES ('Salário'), ('Bônus')";
    $stmt_categoria = $pdo->prepare($sql_insert_categoria);
    $stmt_categoria->execute();
    
    echo "Tabelas específicas para o usuário criadas com sucesso\n";
} else {
    echo "Erro ao inserir novo usuário: " . $stmt->error;
}

header("Location: login.php");
exit;
?>
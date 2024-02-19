<?php
session_start();

include('../config.php');

$sql = "SELECT * FROM login";
$stmt = $pdo->prepare($sql);
$stmt->execute();

if (isset($_POST['usuario']) || isset($_POST['senha'])) {

        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $sql_code = "SELECT * FROM login WHERE usuario = :usuario AND senha = :senha";
        $stmt = $pdo->prepare($sql_code);
        $stmt->execute([
            ':usuario' => $usuario,
            ':senha' => $senha
        ]);

        $quantidade = $stmt->rowCount();

        if ($quantidade == 1) {

            $usuario = $stmt->fetch();

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['usuario'] = $usuario['usuario'];

            header("Location: ../pag-inicial.html");

        } else {
            echo "Usuário não encontrado, verifique seu usuario e senha";
        }

    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinançaFacil - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./../styles/style-login.css">
</head>
<body>

    <div class="login">
        <h2>FinançaFacil - Login</h2>
        <form action="" method="POST">
            <div class="inputBx">
                <input type="text" name="usuario" placeholder="Usuario">
            </div>
            
            <div class="inputBx">
                <input id="senhaInput" type="password" name="senha" placeholder="Senha">
            </div>
            
            <div class="inputBx">
                <button type="submit">Entrar</button>
            </div>
            
            <div class="links">
                <a class="criar-conta" href="criarusuario.php">Criar conta</a>
                <a class="esqueceu-senha" href="./EsqueceuSenha/esqueceuSenha.html">Esqueceu sua senha?</a>
            </div>
        </form>
    </div>

</body>

</html>
<?php
session_start();

include('../config.php');

$sql = "SELECT * FROM login";
$stmt = $pdo->prepare($sql);
$stmt->execute();

if (isset($_POST['usuario']) || isset($_POST['senha'])) {

    if (strlen($_POST['usuario']) == 0) {
        echo "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {
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
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Acesse sua conta</h1>

    <form action="" method="POST">
        <p>
            <label>E-mail</label>
            <input type="text" name="usuario">
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha">
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>

        <h1>Não tem uma conta ?</h1>
        <a href="criarusuario.php">Criar conta</a>
    </form>
</body>

</html>
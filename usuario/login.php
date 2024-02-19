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
        echo "<script>alert('Usuário não encontrado, verifique seu usuário e senha');</script>";
        header("Refresh:0; url=login.php");
        exit();
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
            <label>Usuario</label>
            <input type="text" name="usuario" required>
        </p>
        <p>
            <label>Senha</label>
            <input id="senhaInput" type="password" name="senha" required>
            <span id="togglePassword" class="password-toggle" onclick="togglePasswordVisibility()">
                <img src="lock_icon.png" alt="Mostrar Senha">
            </span>
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
        <p><a href="./EsqueceuSenha/esqueceuSenha.html">Esqueci minha senha</a></p>

        <h1>Não tem uma conta ?</h1>
        <a href="criarusuario.php">Criar conta</a>
    </form>

    <script>
        function togglePasswordVisibility() {
            var senhaInput = document.getElementById("senhaInput");
            var toggleIcon = document.getElementById("togglePassword").getElementsByTagName("img")[0];

            if (senhaInput.type === "password") {
                senhaInput.type = "text";
                toggleIcon.src = "unlock_icon.png";
            } else {
                senhaInput.type = "password";
                toggleIcon.src = "lock_icon.png";
            }
        }
    </script>
</body>

</html>
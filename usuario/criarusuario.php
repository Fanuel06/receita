<?php

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
    <h1>Crie sua conta</h1>
    <form action="./cadastrarusuario.php" method="get">
        <p>
            <label>Nome</label>
            <input required type="text" name="nome">
        </p>
        <p>
            <label>Usuario</label>
            <input required type="text" name="usuario" >
        </p>
        <p>
            <label>Senha</label>
            <input required type="password" name="senha">
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
</body>
</html>

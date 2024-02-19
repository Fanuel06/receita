<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/style-redefinirSenha.css">
    <title>
        Redefinir Senha
    </title>
    <style>
        .password-toggle {
            cursor: pointer;
            position: relative;
            display: inline-block;
        }

        .password-toggle img {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Digite sua nova senha!</h1>
        <form action="atualizarSenha.php" method="post">
            <div class="inputBx">
                <label for="usuario">Usuário</label>
                <input required type="text" name="usuario" id="usuario">
            </div>
            <div class="inputBx">
                <label for="senha">Nova Senha:</label>
                <input id="senhaInput" type="password" name="nova_senha" required>
            </div>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>

</html>
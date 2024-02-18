<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $titulo_pagina; ?>
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
    <h1>Digite sua nova senha !</h1>
    <form action="atualizarSenha.php" method="post">
        <p>
            <label>Usuário</label>
            <input required type="text" name="usuario">
        </p>
        <p>
            <label>Nova Senha:</label>
            <input id="senhaInput" type="password" name="nova_senha" required>
            <span id="togglePassword" class="password-toggle" onclick="togglePasswordVisibility()">
                <img src="lock_icon.png" alt="Mostrar Senha">
            </span>
        </p>
        <p>
            <button type="submit">Redefinir Senha</button>
        </p>
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
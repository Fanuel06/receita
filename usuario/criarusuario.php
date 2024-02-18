<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua conta</title>
</head>
<body>
    <h1>Crie sua conta</h1>
    <form id="signupForm" action="cadastrarUsuario.php" method="post">
        <p>
            <label>Nome</label>
            <input required type="text" name="nome">
        </p>
        <p>
            <label>Usuário</label>
            <input required type="text" name="usuario">
        </p>
        <p>
            <label>Senha</label>
            <input required type="password" name="senha">
        </p>
        <p>
            <label>Email</label>
            <input required type="email" id="email" name="email">
        </p>
        <p>
            <button id="submitBtn" type="submit">Cadastrar</button>
        </p>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('signupForm').addEventListener('submit', function(event) {
                var emailInput = document.getElementById('email').value;

                var confirmation = confirm('O email "' + emailInput + '" está correto?');

                if (!confirmation) {
                    event.preventDefault();\
                }
            });
        });
    </script>
</body>
</html>
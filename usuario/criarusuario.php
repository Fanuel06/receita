<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua conta</title>
    <link rel="stylesheet" href="./../styles/style-cadastro-usuario.css">
</head>
<body>
    <div class="login">
        <h2>FinançaFacil - Crie sua conta</h2>
        <form id="signupForm" action="./cadastrarusuario.php" method="post">

            <div class="inputBx">
                <input type="text" name="nome" placeholder="Nome" required>
            </div>

            <div class="inputBx">
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>

            <div class="inputBx">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="inputBx">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="inputBx">
                <button id="submitBtn" type="submit">Cadastrar</button>
            </div>
            
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
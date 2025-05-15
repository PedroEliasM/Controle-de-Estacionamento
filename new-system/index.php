<!DOCTYPE html>
<html>
    <head lang="pt-br">

        <meta charset="UTF-8">
        <title>PHP</title>

        <link rel="stylesheet" href="Sistema/Frontend/css/style-index.css">

    </head>

    <body class="body" src="Sistema/img/fundo-estacionamento.jpg">
        <div class="container">

            <div class="logo">
                <img src="Sistema/img/logo.png" alt="ParkWay Logo" class="logo">
                <h1 class="logo">ParkWay</h1>
                <h3 class="logo">Systems</h3>
            </div>

            <form method="POST" action="Sistema/Backend/validaLogin.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" placeholder="Digite seu email..." name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" placeholder="Digite sua senha..." name="senha" id="senha" required>
                </div>

                <input id="login-button" type="submit" value="Login">
            </form>

        </div>
    </body>
</html
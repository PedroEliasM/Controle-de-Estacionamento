<!DOCTYPE html>
<html>
    <head lang="pt-br">

        <meta charset="UTF-8">
        <title>PHP</title>

        <!-- CSS -->
        <link rel="stylesheet" href="Sistema/css/style-index.css">
        <!-- /.css -->

    </head>

    <body class="body">
        <div class="container">

            <div class="logo">
                <img src="Sistema/img/logo.png" alt="ParkWay Logo" class="logo">
                <h1 class="logo">ParkWay</h1>
                <h3 class="logo">Systems</h3>
            </div>

            <form method="POST" action="Sistema/php/validaLogin.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="iEmail" name="nEmail" placeholder="Digite seu email..."   required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="iSenha" name="nSenha" placeholder="Digite sua senha..."   required>
                </div>

                <input id="login-button" type="submit" value="Login">
            </form>

        </div>
    </body>
</html
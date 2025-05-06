<!DOCTYPE html>
<html>
    <head lang="pt-bt">

        <meta charset="UTF-8">
        <title>PHP</title>

        <!-- CSS -->
        <?php include('Sistema/Frontend/sidebar.php'); ?>
        <!-- Fim CSS -->

        <style>
            body{
                font-family: Arial, sans-serif;
                background-color: lightgray;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;

                background-image: url('Sistema/img/fundo-estacionamento.jpg');
                background-size: cover;
                background-repeat: no-repeat;
            }
            .form{
                border-color: red;
                width: 230px;
                height: 200px;
                background-color: aliceblue;
                margin-top: 0 auto;
                padding: 25px;
                padding-left: 60px;
                padding-bottom: 90px;
                border-radius: 10px;
                box-shadow: 10px 1px 50px transparent;
                opacity: 100%;
            }
            .campos{
                padding: 3px;
                padding-right: 10%;
                margin-top: 5px;
                margin-bottom: 10px;
                border-radius: 5px;
                border-color: lightgray;
            }
            #iButton{
                color: lightgray;
                background-color: blue;
                margin-top: 5px;
                padding: 5px;
                border-radius: 5px;
            }
            h1{
                color: black;
            }
        </style>

    </head>

    <body id="iBody" src="Sistema/img/fundo-estacionamento.jpg">

        <form class="form" method="POST" action="php/validacao.php">
            <h1>Login</h1>
            <div>
                <label for="" class="text-info">Email:</label>
                <input class="campos" type="email" placeholder="Email" name="nEmail" id="iEmail" required>
            </div>
            <div>
                <label for="" class="text-info">Senha:</label>
                <input class="campos" type="password" placeholder="Password" name="nSenha" id="iSenha" required>
            </div>

            <input id="iButton" type="submit" value="Login">
        </form>

    </body>
</html
<?php
    include("funcoes.php");

    // Buscar os dados da vaga do ID recebido por GET
    $idVaga = buscaVagaId($_GET['id_vaga']);

    //echo $usuario['nome'];
    //die()

?>

<!DOCTYPE html>
<html>
    <head lang="pt-bt">
        <title>Excluir Usuário</title>
        <meta charset="UTF-8">

        <style>
            body{
                font-family: Arial, sans-serif;
                background-color: lightgray;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .form{
                border-color: aliceblue;
                width: 230px;
                height: 200px;
                background-color: aliceblue;
                margin-top: 0 auto;
                padding: 25px;
                padding-left: 60px;
                padding-bottom: 230px;
                border-radius: 10px;
                box-shadow: 10px 5px 50px lightblue;
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
            #iButtonS{
                color: lightgray;
                background-color: red;
                margin-top: 5px;
                padding: 5px;
                border-radius: 5px;
            }
            #iButtonN{
                color: lightgray;
                background-color: green;
                margin-top: 5px;
                padding: 5px;
                border-radius: 5px;
            }
            h1{
                color: black;
            }
        </style>

    </head>

    <body id="iBody" bgcolor="lightgray">

        <form class="form" method="POST" action="php/salvaUsuario.php?opcao=E&id=<?php echo $_GET['id']; ?>">
            <h1>Excluir Usuário</h1>
            <p>
                <label for="">
                    Deseja realmente excluir o usuário "<?php echo $usuario['nome'];?>"?
                </label>
            </p>

            <a href="usuarios.php">
                <input id="iButtonN" type="button" value="Não">
            </a>
            <input id="iButtonS" type="submit" value="Sim">

        </form>

    </body>
</html
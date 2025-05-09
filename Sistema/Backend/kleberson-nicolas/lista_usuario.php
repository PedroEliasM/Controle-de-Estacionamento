<?php
    session_start();
    include("php/funcoes.php");    
?>

<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
		
		<meta charset="UTF-8">
        <title>PHP</title>

    </head>

    <body>
        
        <?php echo montaMenu(); ?>
        
        <p>
            <?php if($_SESSION['id_tipo_usuario'] == 1){ ?>

                <a href="novo_usuario.php">Novo Usuário</a>

            <?php } ?>
        </p>

        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Tipo de Usuário</th>
                <th>Nome</th>
                <th>Login</th>
                <th>Senha</th>             
                <th>Ações</th>
            </tr>
        
            <?php echo listausuario(); ?>

        </table>

    </body>

</html>
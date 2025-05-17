<?php
    session_start();
    include("backend/funcoes.php");    
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
            <?php if($_SESSION['idTipoUsuario'] == 1){ ?>

                <a href="novo-usuario.php">Novo Usuário</a>

            <?php } ?>
        </p>

        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>                              
                <th>Cidade</th>                
                <th>UF</th>                
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        
            <?php echo listaFornecedor(); ?>

        </table>

    </body>

</html>
<?php
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

        <form method="POST" action="php/salvarFornecedor.php?funcao=A&codigo=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">

            <p>
            <label for="iNomeFantasia">Nome Fantasia:</label>
                <input type="text" id="iNomeFantasia" name="nNomeFantasia" value="<?php echo nomeFornecedor($_GET['id']); ?>" maxlength="50">
            </p>

            <p>
                <label for="iCNPJ">CNPJ:</label>
                <input type="text" id="iCNPJ" name="nCNPJ" value="<?php echo cnpjFornecedor($_GET['id']); ?>" maxlength="20">
            </p>

            <p>
                <label for="iCidade">Cidade:</label>
                <input type="text" id="iCidade" name="nCidade" value="<?php echo cidadeFornecedor($_GET['id']); ?>" maxlength="80">
            </p>

            <p>
                <label for="iUF">UF:</label>
                <input type="text" id="iUF" name="nUF" value="<?php echo ufFornecedor($_GET['id']); ?>" maxlength="80">
            </p>
            
            <p>
                <input type="checkbox" id="iAtivo" name="nAtivo" <?php echo ativoUsuario($_GET['id']); ?>>
                <label for="iAtivo">Usuário Ativo</label>
            </p>            

            <p>
                <img src="<?php echo fotoUsuario($_GET['id']); ?>" width="300px">
                <label for="iLogo">Logo:</label>
                <input type="file" id="iLogo" name="Logo" accept="image/*">
            </p>


            <button type="submit">Alterar</button>

        </form>

    </body>

</html>
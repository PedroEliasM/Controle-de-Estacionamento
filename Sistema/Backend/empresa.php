<?php
    include("php/funcoes.php")
?>

<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
		
		<meta charset="UTF-8">
        <title>PHP</title>

    </head>

    <body>
        
        <?php echo montaMenu(); ?>

        <form method="POST" action="php/salvar_empresa.php?funcao=A&codigo=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
        
            <p>
                <label for="iTipo">Tipo da Empresa:</label>
                <select name="nTipoEmpresa" required>
                    <?php echo tipoAcessoEmpresa($_GET['id']); ?>                    
                </select>
            </p>

            <p>
                <label for="iNome">Nome da Empresa:</label>
                <input type="text" id="iNome" name="nNome" value="<?php echo nomeEmpresa($_GET['id']); ?>" required>
            </p>

            <p>
                <label for="iCnpj">CNPJ:</label>
                <input type="text" id="iCnpj" name="nCnpj" value="<?php echo cnpjEmpresa($_GET['id']); ?>" required>
            </p>

            <p>
                <label for="iTelefone">Telefone:</label>
                <input type="text" id="iTelefone" name="nTelefone" value="<?php echo telefoneEmpresa($_GET['id']); ?>" required>
            </p>

            <p>
                <img src="<?php echo logoEmpresa($_GET['id']); ?>" width="300px">
                <label for="iLogo">Logo:</label>
                <input type="file" id="iLogo" name="Logo" accept="image/*">
            </p>

            <button type="submit">Alterar</button>

        </form>

    </body>

</html>

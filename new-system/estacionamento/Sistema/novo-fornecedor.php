<?php
    session_start();

    //Controle de acesso: LOGADO e TIPO DE USUÁRIO
    if($_SESSION['logado'] != 1 || $_SESSION['idTipoUsuario'] != 1){
        header("location: ../");
    }
    
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

        <form method="POST" action="backend/salvarFornecedor.php?funcao=I" enctype="multipart/form-data">

            <p>
                <label for="iRazao">Razão Social:</label>
                <input type="text" id="iRazao" name="nRazao" maxlength="80">
            </p>

            <p>
                <label for="iNomeFantasia">Nome Fantasia:</label>
                <input type="text" id="iNomeFantasia" name="nNomeFantasia" maxlength="50">
            </p>

            <p>
                <label for="iCNPJ">CNPJ:</label>
                <input type="text" id="iCNPJ" name="nCNPJ" maxlength="20">
            </p>

            <p>
                <label for="iLogo">Logo:</label>
                <input type="file" id="iLogo" name="nLogo" accept="image/*">
            </p>

            <p>
                <input type="checkbox" id="iAtivo" name="nAtivo">
                <label for="iAtivo">Fornecedor Ativo</label>
            </p>

            <p>
                <label>CEP</label>
                <input name="nCEP" type="text" class="form-control cep">
            </p>

            <p>
                <label>Endereço</label>
                <input name="nEndereco" type="text" class="form-control">
            </p>

            <p>
                <label>Número</label>
                <input name="nNumero" type="text" maxlength="8" class="form-control">
            </p>

            <p>
                <label>Complemento</label>
                <input name="nComplemento" type="text" maxlength="50" class="form-control">
            </p>

            <p>
                <label>Bairro</label>
                <input name="nBairro" type="text" class="form-control">
            </p>

            <p>
                <label>Cidade</label>
                <input name="nCidade" type="text" class="form-control">
            </p>

            <p>
                <label>UF</label>
                <input name="nUF" type="text" class="form-control">
            </p>

            <button type="submit">Inserir</button>

        </form>

    </body>

</html>
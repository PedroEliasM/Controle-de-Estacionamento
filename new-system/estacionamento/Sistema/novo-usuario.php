<?php
    session_start();

    //Controle de acesso: LOGADO e TIPO DE USUÁRIO
    if($_SESSION['logado'] != 1 || $_SESSION['idTipoUsuario'] != 1){
        header("location: ../");
    }
    
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

        <form method="POST" action="php/salvarUsuario.php?funcao=I" enctype="multipart/form-data">
            
            <p>
                <label for="iNome">Tipo de Usuário:</label>
                <select name="nTipoUsuario" required>
                    <option value="">Selecione...</option>
                    <?php echo optionTipoUsuario();?>
                </select>
            </p>

            <p>
                <label for="iNome">Nome:</label>
                <input type="text" id="iNome" name="nNome" maxlength="50">
            </p>

            <p>
                <label for="iLogin">Login:</label>
                <input type="email" id="iLogin" name="nLogin" maxlength="50">
            </p>

            <p>
                <label for="iSenha">Senha:</label>
                <input type="text" id="iSenha" name="nSenha" maxlength="6">
            </p>

            <p>
                <label for="iFoto">Foto:</label>
                <input type="file" id="iFoto" name="Foto" accept="image/*">
            </p>

            <p>
                <input type="checkbox" id="iAtivo" name="nAtivo">
                <label for="iAtivo">Usuário Ativo</label>
            </p>

            <button type="submit">Inserir</button>

        </form>

    </body>

</html>
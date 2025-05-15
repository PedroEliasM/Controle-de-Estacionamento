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

        <form method="POST" action="php/salvarUsuario.php?funcao=A&codigo=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
        
            <p>
                <label for="iNome">Tipo de Usuário:</label>
                <select name="nTipoUsuario" required>
                    <?php echo tipoAcessoUsuario($_GET['id']); ?>                    
                </select>
            </p>

            <p>
                <label for="iNome">Nome:</label>
                <input type="text" id="iNome" name="nNome" value="<?php echo nomeUsuario($_GET['id']); ?>" maxlength="50">
            </p>

            <p>
                <label for="iLogin">Login:</label>
                <input type="email" id="iLogin" name="nLogin" value="<?php echo loginUsuario($_GET['id']); ?>" maxlength="50">
            </p>
<!--
            <p>
                <label for="iSenha">Senha:</label>
                <input type="text" id="iSenha" name="nSenha" maxlength="6">
            </p>
-->
            <p>
                <input type="checkbox" id="iAtivo" name="nAtivo" <?php echo ativoUsuario($_GET['id']); ?>>
                <label for="iAtivo">Usuário Ativo</label>
            </p>            

            <p>
                <img src="<?php echo fotoUsuario($_GET['id']); ?>" width="300px">
                <label for="iFoto">Foto:</label>
                <input type="file" id="iFoto" name="Foto" accept="image/*">
            </p>


            <button type="submit">Alterar</button>

        </form>

    </body>

</html>
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

        <form method="POST" action="php/salvar_usuario.php?funcao=A&codigo=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
        
            <p>
                <label for="iNome">Nome:</label>
                <input type="text" id="iNome" name="nNome" value="<?php echo nomeUsuario($_GET['id']); ?>" required>
            </p>

            <p>
                <label for="iEmail">Email:</label>
                <input type="email" id="iEmail" name="nEmail" value="<?php echo emailUsuario($_GET['id']); ?>" required>
            </p>

            <p>
                <label for="iSenha">Senha:</label>
                <input type="password" id="iSenha" name="nSenha" required>
            </p>

            <button type="submit">Alterar</button>
        </form>
    </body>
</html>

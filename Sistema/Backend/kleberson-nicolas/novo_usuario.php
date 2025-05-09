<?php
    session_start();

    //Controle de acesso: LOGADO e TIPO DE USUÁRIO
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] != 1 || $_SESSION['id_tipo_usuario'] != 1) {
        header("location: ../");
        exit;
    }

    include("php/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
</head>
<body>
    <form action="php/salvar_usuario.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="iTipo">Tipo Usuário:</label>
            <select name="nTipo" id="iTipo" required>
                <option value="">Selecionar...</option>
                <?php echo optionTipoUsuario(); ?>
            </select>
        </p>

        <p>
            <label for="iNome">Nome:</label>
            <input type="text" id="iNome" name="nNome" required>
        </p>

        <p>
            <label for="iLogin">Login:</label>
            <input type="email" id="iLogin" name="nLogin" required>
        </p>

        <p>
            <label for="iSenha">Senha:</label>
            <input type="password" id="iSenha" name="nSenha" required>
        </p>

        <p>
            <label for="iEmpresa">Empresa:</label>
            <input type="text" id="iEmpresa" name="nEmpresa" required>
        </p>

        <p>
            <label for="iFoto">Foto:</label>
            <input type="file" id="iFoto" name="Foto" accept="image/*">
        </p>

        <button type="submit">Inserir</button>
    </form>
</body>
</html>

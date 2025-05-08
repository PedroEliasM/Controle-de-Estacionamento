<?php
    session_start();

    //Controle de acesso: LOGADO e TIPO DE USUÁRIO
    if($_SESSION['logado'] != 1 || $_SESSION['id_tipo_usuario'] != 1){
        header("location: ../");
    }
    
    include("php/funcoes.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo usuario</title>
</head>
<body>
    <p>
        <label for="iNome">Tipo Usuario:</label>
        <selet name="nTipo" required>
            <option value =""> Selecionar..</option>
            
            <p>
                <label for="iNome">Nome:</label>
                <input type="text" id="iNome" name="nNome" required>
            </p>

            <p>
                <label for="iLogin">Login:</label>
                <input type="email" id="iLogin" name="nLogin"required>
            </p>

            <p>
                <label for="iSenha">Senha:</label>
                <input type="text" id="iSenha" name="nSenha" required>
            </p>
            <p>
                <label for="iEmpresa">Empresa:</label>
                <input type="text" id="iEmpresa" name="nEmpresa" required>
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

        <!-- foda -->
</body>
</html>
<?php
    session_start();

    // Controle de acesso: LOGADO e TIPO DE USUÁRIO
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
    <!-- Inclusão de um arquivo CSS para melhorar a aparência -->
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <form action="php/salvar_usuario.php" method="POST" enctype="multipart/form-data">
</head>
<body>
    <div class="container mt-5">
        <h2>Novo Usuário</h2>
        
        <!-- Verificar se há mensagens de erro ou sucesso -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success">Usuário criado com sucesso!</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="alert alert-danger">Erro ao criar o usuário. Tente novamente.</div>
        <?php endif; ?>

        <form action="php/salvar_usuario.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="iTipo">Tipo Usuário:</label>
                <select name="nTipo" id="iTipo" class="form-control" required>
                    <option value="">Selecionar...</option>
                    <?php echo optionTipoUsuario(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="iNome">Nome:</label>
                <input type="text" id="iNome" name="nNome" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="iLogin">Login:</label>
                <input type="email" id="iLogin" name="nLogin" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="iSenha">Senha:</label>
                <input type="password" id="iSenha" name="nSenha" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="iEmpresa">Empresa:</label>
                <input type="text" id="iEmpresa" name="nEmpresa" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="iFoto">Foto:</label>
                <input type="file" id="iFoto" name="Foto" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">Inserir</button>
        </form>
    </div>

    <!-- Inclusão de um arquivo JS para interações (opcional) -->
    <script src="path/to/bootstrap.bundle.js"></script>
</body>
</html>

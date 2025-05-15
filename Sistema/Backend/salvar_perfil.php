<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    include('conexao.php');
    include('funcoes.php');

    $idUsuario = $_SESSION['id'];
    $nome      = mysqli_real_escape_string($conn, $_POST['nNome']);
    $senha     = isset($_POST['nSenha']) ? mysqli_real_escape_string($conn, $_POST['nSenha']) : '';

    //Foto do perfil
    $diretorioImg = '';

    if (!empty($_FILES['nFoto']['tmp_name'])) {

        //Pega extensão e monta o novo nome do arquivo
        $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
        $novo_nome = "foto-" . $idUsuario . '.' . $ext;

        //Verifica se existe o diretório (ou cria)
        $pasta = '../dist/img/usuarios/';
        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        //Grava o arquivo no diretório
        $caminho_completo = $pasta . $novo_nome;
        if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
            //Salva o diretório para colocar na tabela do BD
            $diretorioImg = 'dist/img/usuarios/' . $novo_nome;

            //Gravação no BD
            $sql = "UPDATE usuario
                    SET foto = '$diretorioImg'
                    WHERE id_usuario = $idUsuario";
            if (!mysqli_query($conn, $sql)) {
                die("Erro ao atualizar foto: " . mysqli_error($conn));
            }
        }
    }

    //Gravação no BD
    $sql = "UPDATE usuario 
            SET nome = '$nome'
            WHERE id_usuario = $idUsuario";
    if (!mysqli_query($conn, $sql)) {
        die("Erro ao atualizar nome: " . mysqli_error($conn));
    }

    if (!empty($senha)) {
        $sql = "UPDATE usuario
                SET senha = md5('$senha')
                WHERE id_usuario = $idUsuario";
        if (!mysqli_query($conn, $sql)) {
            die("Erro ao atualizar senha: " . mysqli_error($conn));
        }
    }

    mysqli_close($conn);
    header('Location: ../painel-perfil.php');
    exit;
?>

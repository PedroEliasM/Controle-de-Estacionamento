<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include('conexao.php');
include('funcoes.php');

$idUsuario = $_SESSION['id'];
$nome      = mysqli_real_escape_string($conn, $_POST['nNome']);
$senha     = isset($_POST['nSenha']) ? mysqli_real_escape_string($conn, $_POST['nSenha']) : '';

$diretorioImg = '';

if (!empty($_FILES['nFoto']['tmp_name'])) {

    $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
    $novo_nome = "foto-" . $idUsuario . '.' . $ext;

    $pasta = '../dist/img/usuarios/';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    $caminho_completo = $pasta . $novo_nome;
    if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
        $diretorioImg = 'dist/img/usuarios/' . $novo_nome;

        $sql = "UPDATE usuario SET foto = '$diretorioImg' WHERE id_usuario = $idUsuario";
        if (!mysqli_query($conn, $sql)) {
            die("Erro ao atualizar foto: " . mysqli_error($conn));
        }
    }
}

$sql = "UPDATE usuario SET nome = '$nome' WHERE id_usuario = $idUsuario";
if (!mysqli_query($conn, $sql)) {
    die("Erro ao atualizar nome: " . mysqli_error($conn));
}

if (!empty($senha)) {
    $sql = "UPDATE usuario SET senha = md5('$senha') WHERE id_usuario = $idUsuario";
    if (!mysqli_query($conn, $sql)) {
        die("Erro ao atualizar senha: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
header('Location: ../painel-perfil.php');
exit;
?>

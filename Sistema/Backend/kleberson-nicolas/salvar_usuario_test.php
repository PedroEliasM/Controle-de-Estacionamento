<?php

include('funcoes.php');
include("conexao.php");

$tipoUsuario = mysqli_real_escape_string($conn, $_POST["nTipoUsuario"]);
$nome        = mysqli_real_escape_string($conn, $_POST["nNome"]);
$login       = mysqli_real_escape_string($conn, $_POST["nLogin"]);
$senha       = isset($_POST["nSenha"]) ? mysqli_real_escape_string($conn, $_POST["nSenha"]) : "";
$funcao      = isset($_GET["funcao"]) ? $_GET["funcao"] : "";
$idUsuario   = isset($_GET["codigo"]) ? intval($_GET["codigo"]) : 0;

$sql = "";

if ($funcao == "I") {
    $idUsuario = proxIdUsuario();

    $sql = "INSERT INTO usuarios (id_usuario, id_tipo_usuario, nome, login, senha) "
            . "VALUES ($idUsuario, $tipoUsuario, '$nome', '$login', '" . md5($senha) . "')";
} elseif ($funcao == "A") {
    $setSenha = $senha ? "senha = '" . md5($senha) . "', " : "";

    $sql = "UPDATE usuarios "
            . "SET id_tipo_usuario = $tipoUsuario, "
            . "    nome = '$nome', "
            . "    login = '$login', "
            . "    $setSenha "
            . "WHERE id_usuario = $idUsuario";
} elseif ($funcao == "D") {
    // Exclusão
    $sql = "DELETE FROM usuarios WHERE id_usuario = $idUsuario";
}

if ($sql != "") {
    $result = mysqli_query($conn, $sql) or die("Erro na query: " . mysqli_error($conn));
}

// Verifica se há imagem no input
if (isset($_FILES['Foto']) && $_FILES['Foto']['tmp_name'] != "") {
    $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
    $novoNome = md5(uniqid($_FILES['Foto']['name'], true)) . '.' . $extensao;

    $diretorio = '../img/';
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    // Move o arquivo para o diretório
    move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio . $novoNome);

    $dirImagem = '/img/' . $novoNome;

    $sqlImg = "UPDATE usuarios SET foto = '$dirImagem' WHERE id_usuario = $idUsuario";
    mysqli_query($conn, $sqlImg);
}

mysqli_close($conn);
header("Location: ../usuario.php");
exit;
?>

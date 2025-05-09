<?php
include("php/funcoes.php");

$id = $_GET['id']; // Recebe o ID do usuário via GET

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nNome'];
    $login = $_POST['nLogin'];
    $email = $_POST['nEmail'];
    $senha = $_POST['nSenha'];
    $foto = $_FILES['Foto'];

    // Foto: se foi carregada, move para a pasta "uploads"
    if ($foto['error'] === 0) {
        $fotoNome = "uploads/" . basename($foto['name']);
        move_uploaded_file($foto['tmp_name'], $fotoNome);
    } else {
        // Se não há foto, mantém a foto atual
        $usuario = getUsuarioById($id);
        $fotoNome = $usuario['foto'];
    }

    // Senha: se foi preenchida, criptografa
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    } else {
        // Se a senha não foi alterada, mantém a senha atual
        $usuario = getUsuarioById($id);
        $senhaHash = $usuario['senha'];
    }

    // Atualiza os dados no banco de dados
    $query = "UPDATE usuarios SET nome = ?, login = ?, email = ?, senha = ?, foto = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nome, $login, $email, $senhaHash, $fotoNome, $id);
    $stmt->execute();

    // Redireciona após a atualização
    header("Location: perfil.php?id=" . $id);
    exit;
}

function getUsuarioById($id) {
    global $conn;
    $query = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
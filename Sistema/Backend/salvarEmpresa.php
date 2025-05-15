<?php
include("php/funcoes.php");

$id = $_GET['id']; // Recebe o ID da empresa via GET

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nNome'];
    $cnpj = $_POST['nCnpj'];
    $telefone = $_POST['nTelefone'];

    // Atualiza os dados no banco de dados
    $query = "UPDATE empresas SET nome = ?, cnpj = ?, telefone = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nome, $cnpj, $telefone, $id);
    $stmt->execute();

    // Redireciona após a atualização
    header("Location: perfil_empresa.php?id=" . $id);
    exit;
}

function getEmpresaById($id) {
    global $conn;
    $query = "SELECT * FROM empresas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>

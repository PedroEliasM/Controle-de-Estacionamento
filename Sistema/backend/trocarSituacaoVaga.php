<?php
session_start(); // <-- Adicione esta linha no início do arquivo

include('conexao.php');
include('funcoes.php');

// Verifica se o usuário está logado e tem permissão
if (!isset($_SESSION['idTipoUsuario'])) {
    die("Acesso negado. Usuário não autenticado.");
}

$tipoUsuario = $_SESSION['idTipoUsuario'];

// Apenas tipos 1 (adm), 2 (funcionário) e 3 (dono) podem trocar a situação
if (!in_array($tipoUsuario, [1, 2, 3])) {
    die("Acesso negado. Tipo de usuário sem permissão.");
}

if (isset($_GET['id'])) {
    $idVaga = intval($_GET['id']);

    // Consulta situação atual
    $query = "SELECT situacao FROM vaga WHERE id_vaga = $idVaga";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $situacaoAtual = $row['situacao'];
        $novaSituacao = ($situacaoAtual === 'L') ? 'O' : 'L';
        $tipoMov = ($novaSituacao === 'O') ? 'E' : 'S';

        // Atualiza situação
        $sqlUpdate = "UPDATE vaga SET situacao = '$novaSituacao' WHERE id_vaga = $idVaga";
        mysqli_query($conn, $sqlUpdate);

        // Registra movimentação
        $sqlMov = "INSERT INTO movimentacao (fk_id_vaga, tipo, data)
                   VALUES ($idVaga, '$tipoMov', NOW())";
        mysqli_query($conn, $sqlMov);
    }
}

mysqli_close($conn);
header("Location: ../vagas.php");
exit;
<?php

include('funcoes.php');

$descricao   = $_POST["nDescricao"];
$situacao    = $_POST["nSituacao"];
$idEmpresa   = $_POST["nEmpresa"];
$funcao      = $_GET["funcao"];
$idVaga      = $_GET["codigo"];

include("conexao.php");

$ativo = (isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on") ? "S" : "N";

// Validar se é Inclusão, Alteração ou Exclusão
if ($funcao == "I") {

    // Busca o próximo ID na tabela
    $idVaga = proxIdVaga();

    // INSERT
    $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa)
            VALUES ($idVaga, '$descricao', '$situacao', '$ativo', $idEmpresa);";
    
    mysqli_query($conn, $sql);

} elseif ($funcao == "A") {

    // Verifica situação atual da vaga antes de atualizar
    $query = "SELECT situacao FROM vaga WHERE id_vaga = $idVaga";
    $resultado = mysqli_query($conn, $query);
    $situacaoAtual = null;
    if ($linha = mysqli_fetch_assoc($resultado)) {
        $situacaoAtual = $linha['situacao'];
    }

    // UPDATE
    $sql = "UPDATE vaga
            SET descricao = '$descricao',
                situacao = '$situacao',
                flg_ativo = '$ativo',
                fk_id_empresa = $idEmpresa
            WHERE id_vaga = $idVaga;";
    
    mysqli_query($conn, $sql);

    // Verifica se houve alteração na situação
    if ($situacaoAtual !== null && $situacaoAtual !== $situacao) {
        if ($situacao === 'O') {
            $tipoMov = 'E'; // Entrada
        } elseif ($situacao === 'L') {
            $tipoMov = 'S'; // Saída
        }

        if (isset($tipoMov)) {
            $sqlMov = "INSERT INTO movimentacao (fk_id_vaga, tipo, data)
                       VALUES ($idVaga, '$tipoMov', NOW());";
            mysqli_query($conn, $sqlMov);
        }
    }

} elseif ($funcao == "D") {

    // DELETE
    $sql = "DELETE FROM vaga WHERE id_vaga = $idVaga;";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);
header("location: ../vagas.php");

?>
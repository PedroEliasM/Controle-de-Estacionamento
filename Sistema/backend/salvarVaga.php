<?php

include('funcoes.php'); // Inclui o arquivo de funções e, consequentemente, a conexão com o DB

// Verifica se a conexão global está disponível
if (!isset($conn) || !$conn) {
    // Se a conexão não estiver disponível, tenta incluí-la novamente ou lidar com o erro
    // Isso é uma medida de segurança, mas 'funcoes.php' já deveria ter incluído 'conexao.php'
    include("conexao.php");
    if (!isset($conn) || !$conn) {
        die("Erro: Conexão com o banco de dados não estabelecida.");
    }
}

$descricao = $_POST["nDescricao"] ?? ''; // Usa o operador null coalescing para evitar notices
$situacao = $_POST["nSituacao"] ?? '';
$idEmpresa = $_POST["nEmpresa"] ?? null;
$funcao = $_GET["funcao"] ?? '';
$idVaga = $_GET["codigo"] ?? null;

// Define o status ativo/inativo
$ativo = (isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on") ? "S" : "N";

$stmt = null; // Inicializa a variável do statement

try {
    if ($funcao == "I") { // Inclusão
        $idVaga = proxIdVaga(); // Busca o próximo ID disponível

        $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a declaração INSERT: " . mysqli_error($conn));
        }
        // 'isssi' -> i: integer, s: string, s: string, s: string, i: integer
        mysqli_stmt_bind_param($stmt, "isssi", $idVaga, $descricao, $situacao, $ativo, $idEmpresa);

    } elseif ($funcao == "A") { // Alteração
        $sql = "UPDATE vaga SET descricao = ?, situacao = ?, flg_ativo = ?, fk_id_empresa = ? WHERE id_vaga = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a declaração UPDATE: " . mysqli_error($conn));
        }
        // 'sssi' -> s: string, s: string, s: string, i: integer (para fk_id_empresa), i: integer (para id_vaga)
        mysqli_stmt_bind_param($stmt, "sssi", $descricao, $situacao, $ativo, $idEmpresa, $idVaga);

    } elseif ($funcao == "D") { // Deleção
        $sql = "DELETE FROM vaga WHERE id_vaga = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a declaração DELETE: " . mysqli_error($conn));
        }
        // 'i' -> i: integer
        mysqli_stmt_bind_param($stmt, "i", $idVaga);

    } else {
        throw new Exception("Função inválida.");
    }

    // Executa a declaração preparada
    if ($stmt) {
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Erro ao executar a declaração: " . mysqli_stmt_error($stmt));
        }
    }

} catch (Exception $e) {
    // Em caso de erro, você pode logar a mensagem e/ou redirecionar para uma página de erro
    error_log($e->getMessage()); // Loga o erro para depuração
    // Opcional: Redirecionar para uma página de erro ou exibir uma mensagem
    // header("location: ../erro.php?msg=" . urlencode($e->getMessage()));
    // exit();
} finally {
    // Fecha a declaração preparada, se ela foi criada
    if ($stmt) {
        mysqli_stmt_close($stmt);
    }
    // Fecha a conexão com o banco de dados, se ela foi aberta e não é globalmente gerenciada
    // Se 'conexao.php' já gerencia o fechamento ou se a conexão é global, pode não ser necessário aqui.
    // mysqli_close($conn);
}

// Redireciona de volta para a página de vagas após a operação
header("location: ../vagas.php");
exit(); // Garante que o script pare de executar após o redirecionamento

?>

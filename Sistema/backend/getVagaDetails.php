<?php
// Inclui o arquivo de funções onde 'getVagaDetails' está definido
include("conexao.php");
include('funcaoVaga2.php');

header('Content-Type: application/json'); // Define o cabeçalho para retornar JSON

// Verifica se o ID da vaga foi passado via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idVaga = (int)$_GET['id']; // Converte para inteiro para garantir segurança

    // Chama a função para buscar os detalhes da vaga
    $vagaDetails = getVagaDetails($idVaga);

    if ($vagaDetails) {
        // Retorna os detalhes da vaga como JSON
        echo json_encode($vagaDetails);
    } else {
        // Retorna um JSON vazio ou mensagem de erro se a vaga não for encontrada
        echo json_encode(['error' => 'Vaga não encontrada.']);
    }
} else {
    // Retorna um JSON de erro se o ID não for fornecido ou for inválido
    echo json_encode(['error' => 'ID da vaga inválido ou ausente.']);
}
  mysqli_close($conn);

// É importante fechar a conexão se ela foi aberta apenas para esta requisição.
// Se 'conexao.php' já abre uma conexão global que é reutilizada, não é necessário fechar aqui.
// No seu caso, 'funcoes.php' já inclui 'conexao.php', então a conexão já está disponível.
// Se você quiser fechar a conexão explicitamente após todas as operações do script,
// você pode adicionar mysqli_close($conn); no final deste arquivo,
// mas certifique-se de que não haja outras operações pendentes.
// Por simplicidade, e assumindo que 'conexao.php' gerencia a conexão de forma global,
// não adicionaremos mysqli_close($conn); aqui, pois pode ser fechada em outro ponto.
?>

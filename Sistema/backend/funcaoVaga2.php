<?php

// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// Função para listar as vagas e gerar o HTML dos widgets
function listaVagas() {
    global $conn; // Acessa a variável de conexão global
    $lista = "";

    // Consulta SQL para obter todas as vagas
    // Adicionado JOIN com a tabela 'empresa' para obter o nome da empresa
    $sql = "SELECT v.*, e.nome AS nome_empresa FROM vaga v JOIN empresa e ON v.fk_id_empresa = e.id_empresa ORDER BY v.descricao ASC;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $coluna) {
            $statusClass = ''; // Classe CSS para a cor de fundo do widget
            $statusText = '';   // Texto para a situação da vaga

            // Lógica para definir a cor de fundo e o texto do status
            if ($coluna["flg_ativo"] == 'S') {
                if ($coluna["situacao"] == 'Livre') {
                    $statusClass = 'vaga-ativa-livre';
                    $statusText = 'Livre';
                } elseif ($coluna["situacao"] == 'Ocupada') {
                    $statusClass = 'vaga-ativa-ocupada';
                    $statusText = 'Ocupada';
                } else {
                    // Outras situações para vagas ativas (ex: Manutenção)
                    $statusClass = 'vaga-ativa-outros'; // Uma cor neutra para outros status ativos
                    $statusText = $coluna["situacao"];
                }
            } else {
                $statusClass = 'vaga-inativa';
                $statusText = 'Inativa';
            }

            // Gera cada widget com as informações da vaga
            // Adicionado 'col-6 col-sm-4 col-md-3 col-lg-2' para responsividade do Bootstrap
            // Adicionado 'vaga-widget-clickable' para o evento de clique no JavaScript
            // Adicionado 'data-id' para passar o ID da vaga para o JavaScript
            $lista .= '
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="vaga-widget ' . $statusClass . '" data-id="' . $coluna["id_vaga"] . '">
                        <div class="vaga-widget-clickable">
                            <h5>' . htmlspecialchars($coluna["descricao"]) . '</h5>
                            <p><strong>Status:</strong> ' . $statusText . '</p>
                            <p><strong>Empresa:</strong> ' . htmlspecialchars($coluna["nome_empresa"]) . '</p>
                        </div>
                        <div class="vaga-actions">
                            <button type="button" class="btn btn-warning btn-sm edit-vaga-btn" data-id="' . $coluna["id_vaga"] . '" title="Editar Vaga">
                                <i class="fas fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-vaga-btn" data-id="' . $coluna["id_vaga"] . '" data-name="' . htmlspecialchars($coluna["descricao"]) . '" title="Excluir Vaga">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        $lista = '<div class="col-12"><p class="text-center">Nenhuma vaga cadastrada.</p></div>';
    }

    // Não feche a conexão aqui se ela for usada por outras funções na mesma requisição.
    // mysqli_close($conn); 
    return $lista;
}

// Função para obter os detalhes de uma única vaga (usada via AJAX)
function getVagaDetails($idVaga) {
    global $conn; // Acessa a variável de conexão global
    $vagaDetails = null;

    // Usando prepared statements para evitar SQL Injection
    $sql = "SELECT v.*, e.nome AS nome_empresa FROM vaga v JOIN empresa e ON v.fk_id_empresa = e.id_empresa WHERE v.id_vaga = ?;";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $idVaga); // 'i' para integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $vagaDetails = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
    }
    return $vagaDetails;
}

// Função para gerar as opções de empresas para um select (mantida)
function optionEmpresa(){
    global $conn; // Acessa a variável de conexão global
    $option = "";

    $sql = "SELECT id_empresa, nome FROM empresa ORDER BY nome;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $option .= '<option value="'.$linha['id_empresa'].'">'.htmlspecialchars($linha['nome']).'</option>';
        }
    }
    return $option;
}

// As funções abaixo (ativoVaga, proxIdVaga, qtdVagasAtivas, qtdEntradas, qtdSaidas, qtdEntradasSaidas)
// não foram diretamente modificadas para o escopo dos widgets, mas são mantidas aqui.
// Recomenda-se revisar todas as funções que interagem com o DB para usar prepared statements.

function ativoVaga($idVaga){
    global $conn;
    $resp = "";
    $sql = "SELECT FlgAtivo FROM vaga WHERE id_vaga = ?;";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $idVaga);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $coluna = mysqli_fetch_assoc($result);
            if($coluna["FlgAtivo"] == 'S') $resp = 'checked'; else $resp = '';
        }
        mysqli_stmt_close($stmt);
    }
    return $resp;
}

function proxIdVaga(){
    global $conn;
    $idVaga = 1; // Valor padrão se não houver registros
    $sql = "SELECT MAX(id_vaga) AS Maior FROM vaga;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        if ($coluna["Maior"] !== null) {
            $idVaga = $coluna["Maior"] + 1;
        }
    }
    return $idVaga;
}

function qtdVagasAtivas(){
    global $conn;
    $qtd = 0;
    $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        $qtd = $coluna['Qtd'];
    }
    return $qtd;
}

function qtdEntradas(){
    global $conn;
    $qtd = 0;
    $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'E';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        $qtd = $coluna['Qtd'];
    }
    return $qtd;
}

function qtdSaidas(){
    global $conn;
    $qtd = 0;
    $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'S';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        $qtd = $coluna['Qtd'];
    }
    return $qtd;
}

function qtdEntradasSaidas(){
    global $conn;
    $descricao = "";
    $sql = "SELECT tipo, COUNT(*) AS total FROM movimentacao WHERE DATE(data) = CURDATE() GROUP BY tipo;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($coluna = mysqli_fetch_assoc($result)) {
            $data[] = $coluna['total'];
        }
        $descricao = implode(",", $data); // Formata como string separada por vírgulas
    }
    return json_encode($descricao); // Retorna como JSON
}

?>

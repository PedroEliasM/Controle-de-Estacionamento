**********************************
FUNÇÃO _________________ listaVagas() do arquivo funcaoVaga.php  _________________________
**********************************

<?php
function listaVagas(){
    $lista = "";

    include("conexao.php");

    // Verifica o tipo de usuário na sessão
    if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
        $idTipoUsuario = $_SESSION['idTipoUsuario'];
        $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

        // Ajusta a consulta SQL com base no tipo de usuário
        if ($idTipoUsuario == 3) { // Dono
            $sql = "SELECT * FROM vaga;"; // Lista todas as vagas
        } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
            $sql = "SELECT * FROM vaga WHERE fk_id_empresa = $idEmpresaUsuario;"; // Lista vagas da empresa do usuário
        } else {
            return "Tipo de usuário inválido.";
        }
    } else {
        return "Sessão não iniciada ou dados do usuário não definidos.";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    if(mysqli_num_rows($result) > 0){

        foreach ($result as $coluna) {
            $vaga_id = $coluna["id_vaga"];
            $descricao = htmlspecialchars($coluna["descricao"]);
            $situacao = htmlspecialchars($coluna["situacao"]); // Pega o valor 'L' ou 'O' diretamente do banco
            $flg_ativo = $coluna["flg_ativo"]; // Pega o 'S' ou 'N'
            $id_empresa = htmlspecialchars($coluna["fk_id_empresa"]); // Usa fk_id_empresa
            $empresa_nome = descrEmpresa($coluna["fk_id_empresa"]); 
            
            if($coluna["flg_ativo"] == 'S'){  
                $ativo_checked = 'checked'; // Alterado nome da variável para clareza
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo_checked = ''; // Alterado nome da variável para clareza
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
        
            // NOVO: Variável para determinar se o checkbox de 'Vaga Ativa' deve ser desabilitado
            // Se a situação for 'O' (Ocupada), o checkbox deve estar desabilitado.
            $ativo_disabled = ($situacao == 'O') ? 'disabled' : ''; 
            
            $card_class = '';
            $display_situacao_text = ''; 
            
            if ($flg_ativo == 'N') {
                $card_class = 'inativa';
                $display_situacao_text = 'INATIVA';
            } else {
                if ($situacao == 'L') {
                    $card_class = 'livre';
                    $display_situacao_text = 'LIVRE';
                } elseif ($situacao == 'O') {
                    $card_class = 'ocupada';
                    $display_situacao_text = 'OCUPADA';
                } else {
                    $card_class = 'inativa';
                    $display_situacao_text = 'DESCONHECIDA';
                }
            }

            $iconToggle = ($situacao == 'L') ? 'fa-toggle-off text-success' : 'fa-toggle-on text-danger';
            
            $lista .= '
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                <div class=" '. reduzTamanhoVagaFuncionario() .' ' . $card_class . '">
                    ' . mostraIdVaga($vaga_id) . '
                    <div class="vaga-descricao">'.$descricao.'</div>
                    <div class="vaga-status">'.$display_situacao_text.'</div>
                    <div class="vaga-actions">
                        '. mostraVagaActions($vaga_id, $iconToggle, $card_class) .'
                    </div>
                </div>
            </div>';
            
            $lista .= '
            <div class="modal fade" id="modalEditVaga'.$vaga_id.'">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">Alterar Vaga</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="backend/salvarVaga.php?funcao=A&codigo='.$vaga_id.'" enctype="multipart/form-data">        
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="editDescricao'.$vaga_id.'">Descrição:</label>
                                            <input type="text" id="editDescricao'.$vaga_id.'" name="nDescricao" value="'.$descricao.'" class="form-control"  maxlength="80">
                                        </div>
                                    </div>
                                    
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="editEmpresa'.$vaga_id.'">Empresa:</label>
                                            <select name="nEmpresa" id="editEmpresa'.$vaga_id.'" class="form-control" required>
                                                <option value="'.$id_empresa.'">'.$empresa_nome.'</option>';
                                                $lista .= optionEmpresa();
                                                $lista .= '
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="editSituacao'.$vaga_id.'">Situação:</label>
                                            <select class="form-control" id="editSituacao'.$vaga_id.'" name="nSituacao">
                                                <option value="L" '.($situacao == 'L' ? 'selected' : '').'>Livre</option>
                                                <option value="O" '.($situacao == 'O' ? 'selected' : '').'>Ocupada</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="editAtivo'.$vaga_id.'" name="nAtivo" '.$ativo_checked.' '.$ativo_disabled.'>
                                            <label for="editAtivo'.$vaga_id.'">Vaga Ativa</label>
                                            ';
                                            // NOVO: Adiciona uma mensagem se o checkbox estiver desabilitado
                                            if ($situacao == 'O') {
                                                $lista .= '<small class="text-danger ml-2">Vaga ocupada não pode ser inativada.</small>';
                                            }
                                            $lista .= '
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-success">Salvar</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            
            $lista .= '
            <div class="modal fade" id="modalDeleteVaga'.$vaga_id.'">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h4 class="modal-title">Excluir Vaga: '.$descricao.'</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="backend/salvarVaga.php?funcao=D&codigo='.$vaga_id.'" enctype="multipart/form-data">        
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Deseja EXCLUIR a vaga '.$descricao.'?</h5>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                                    <button type="submit" class="btn btn-success">Sim</button>
                                </div>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>';              
        }
    }

    return $lista;
}
?>

































**********************************
ARQUIVO _________________ salvarVaga.php _________________________
**********************************

<?php
    // NOVO: Inicia a sessão se ainda não estiver iniciada.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    include('funcoes.php');
    // NOVO: Inclui a conexão com o banco de dados ANTES de usar $conn.
    include("conexao.php"); 

    $descricao = $_POST["nDescricao"];
    $situacao = $_POST["nSituacao"]; // A nova situação desejada enviada pelo formulário
    $idEmpresa = $_POST["nEmpresa"];
    $funcao = $_GET["funcao"];
    $idVaga = $_GET["codigo"];

    // NOVO: Determina o status 'ativo' com base no checkbox.
    // Se o checkbox 'nAtivo' foi marcado e enviado ('on'), então 'S', caso contrário 'N'.
    $ativo = isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on" ? "S" : "N";

    // Validar se é Inclusão ou Alteração ou Deletar
    if($funcao == "I"){

        // Busca o próximo ID na tabela (Certifique-se que proxIdVaga() está definida em funcoes.php)
        $idVaga = proxIdVaga();

        // NOVO: INSERT usando Prepared Statements para segurança contra SQL Injection
        $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa) VALUES (?, ?, ?, ?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issii", $idVaga, $descricao, $situacao, $ativo, $idEmpresa);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msg'] = '<p class="text-success">Vaga cadastrada com sucesso!</p>';
        } else {
            $_SESSION['msg'] = '<p class="text-danger">Erro ao cadastrar vaga: ' . mysqli_error($conn) . '</p>';
        }
        mysqli_stmt_close($stmt);

    } elseif ($funcao == "A") {

        // NOVO: Verifica situação e status 'flg_ativo' atuais da vaga no banco de dados (USANDO PREPARED STATEMENT)
        $query_atual = "SELECT situacao, flg_ativo FROM vaga WHERE id_vaga = ?";
        $stmt_atual = mysqli_prepare($conn, $query_atual);
        mysqli_stmt_bind_param($stmt_atual, "i", $idVaga);
        mysqli_stmt_execute($stmt_atual);
        $resultado_atual = mysqli_stmt_get_result($stmt_atual);
        $dadosVagaAtual = mysqli_fetch_assoc($resultado_atual);
        mysqli_stmt_close($stmt_atual);

        $situacaoAtual = $dadosVagaAtual['situacao'] ?? null; // Pega a situação atual do banco
        $flgAtivoAtual = $dadosVagaAtual['flg_ativo'] ?? null; // Pega o flg_ativo atual do banco

        // NOVO: VALIDAÇÃO CRÍTICA: Impedir inativação de vaga ocupada
        // Se a vaga está atualmente 'O' (Ocupada) E o usuário está tentando mudá-la para 'N' (Inativa)
        if ($situacaoAtual == 'O' && $ativo == 'N') {
            $_SESSION['msg'] = '<p class="text-danger">Erro: Uma vaga ocupada não pode ser inativada.</p>';
            mysqli_close($conn); // Importante: fecha a conexão antes de redirecionar
            header("Location: ../vagas.php"); // Redireciona de volta para a página de vagas
            exit(); // Encerra o script para evitar que o UPDATE abaixo seja executado
        }
        // FIM DA VALIDAÇÃO

        // NOVO: UPDATE usando Prepared Statements para segurança
        $sql = "UPDATE vaga SET descricao = ?, situacao = ?, flg_ativo = ?, fk_id_empresa = ? WHERE id_vaga = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssii", $descricao, $situacao, $ativo, $idEmpresa, $idVaga);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msg'] = '<p class="text-success">Vaga alterada com sucesso!</p>';

            // Verifica se houve alteração na situação para registrar movimentação
            if ($situacaoAtual !== null && $situacaoAtual !== $situacao) {
                if ($situacao === 'O') {
                    $tipoMov = 'E'; // Entrada
                } elseif ($situacao === 'L') {
                    $tipoMov = 'S'; // Saída
                }
        
                if (isset($tipoMov)) {
                    // NOVO: INSERT para movimentacao usando Prepared Statements
                    $sqlMov = "INSERT INTO movimentacao (fk_id_vaga, tipo, data) VALUES (?, ?, NOW());";
                    $stmtMov = mysqli_prepare($conn, $sqlMov);
                    mysqli_stmt_bind_param($stmtMov, "is", $idVaga, $tipoMov);
                    mysqli_stmt_execute($stmtMov);
                    mysqli_stmt_close($stmtMov);
                }
            }
        } else {
            $_SESSION['msg'] = '<p class="text-danger">Erro ao alterar vaga: ' . mysqli_error($conn) . '</p>';
        }
        mysqli_stmt_close($stmt);
    
    } elseif ($funcao == "D") {

        // NOVO: Exclui primeiro da tabela movimentacao (USANDO PREPARED STATEMENT)
        $sql = "DELETE FROM movimentacao WHERE fk_id_vaga = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idVaga);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        // NOVO: Depois exclui da tabela vaga (USANDO PREPARED STATEMENT)
        $sql = "DELETE FROM vaga WHERE id_vaga = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idVaga);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['msg'] = '<p class="text-success">Vaga excluída com sucesso!</p>';
    }

    mysqli_close($conn); // Fecha a conexão no final do script
    header("location: ../vagas.php"); // Redireciona para a página de vagas
    exit(); // Garante que o script pare de executar após o redirecionamento
?>
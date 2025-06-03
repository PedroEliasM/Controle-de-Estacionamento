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
            $situacao = htmlspecialchars($coluna["situacao"]); // 'L' ou 'O'
            $flg_ativo = $coluna["flg_ativo"]; // 'S' ou 'N'
            $id_empresa = htmlspecialchars($coluna["fk_id_empresa"]);
            $empresa_nome = descrEmpresa($coluna["fk_id_empresa"]); 
            
            if($coluna["flg_ativo"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
        
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

            // Ícone toggle para o botão trocar situação
            $iconToggle = ($situacao == 'L') ? 'fa-toggle-off text-success' : 'fa-toggle-on text-danger';

            $lista .= '
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                <div class="vaga-card ' . $card_class . '">
                    <div class="vaga-id">ID: '.$vaga_id.'</div>
                    <div class="vaga-descricao">'.$descricao.'</div>
                    <div class="vaga-status">'.$display_situacao_text.'</div>
                    <div class="vaga-actions">
                        <!-- Botão trocar situação disponível para todos -->
                        <a href="backend/trocarSituacaoVaga.php?id='.$vaga_id.'" title="Trocar Situação" class="ml-2">
                            <i class="fas '.$iconToggle.'" style="font-size: 1.3em; cursor: pointer;"></i>
                        </a>';

            // Botões editar e excluir apenas para admin e dono
            if ($idTipoUsuario == 1 || $idTipoUsuario == 3) {
                $lista .= '
                        <a href="#modalEditVaga'.$vaga_id.'" data-toggle="modal" title="Alterar Vaga">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#modalDeleteVaga'.$vaga_id.'" data-toggle="modal" title="Excluir Vaga">
                            <i class="fas fa-trash"></i>
                        </a>';
            }

            $lista .= '
                    </div>
                </div>
            </div>';

            // Gerar modais apenas para admin e dono
            if ($idTipoUsuario == 1 || $idTipoUsuario == 3) {
                // Modal de edição
                $lista .= '
                <div class="modal fade" id="modalEditVaga'.$vaga_id.'">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content dark-modal">
                            <div class="modal-header bg-verde-escuro">
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
                                                <input type="text" id="editDescricao'.$vaga_id.'" name="nDescricao" value="'.$descricao.'" class="form-control" maxlength="80">
                                            </div>
                                        </div>';
                
                // Se o usuário for do tipo 3 (Dono), mostra o campo Empresa
                if ($_SESSION["idTipoUsuario"] == 3) {
                    $lista .= '
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="editEmpresa'.$vaga_id.'">Empresa:</label>
                                                <select name="nEmpresa" id="editEmpresa'.$vaga_id.'" class="form-control" required>
                                                    <option value="'.$id_empresa.'">'.$empresa_nome.'</option>';
                    $lista .= optionEmpresa();
                    $lista .= '
                                                </select>
                                            </div>
                                        </div>';
                }
            
                $lista .= '
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
                                                <input type="checkbox" id="editAtivo'.$vaga_id.'" name="nAtivo" '.$ativo.'>
                                                <label for="editAtivo'.$vaga_id.'">Vaga Ativa</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-vermelho-escuro" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-verde-escuro">Salvar</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';

                // Modal de exclusão
                $lista .= '
                <div class="modal fade" id="modalDeleteVaga'.$vaga_id.'">
                    <div class="modal-dialog">
                        <div class="modal-content dark-modal">
                            <div class="modal-header bg-verde-escuro">
                                <h4 class="modal-title">Excluir Vaga: '.$vaga_id.'</h4>
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
    }

    return $lista;
}
    function optionEmpresa(){

        $option = "";
    
        include("conexao.php");
        $sql = "SELECT id_empresa,nome FROM empresa ORDER BY nome;";        
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    
        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
                    
            $array = array();
            
            while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($array,$linha);
            }
            
            foreach ($array as $coluna) {            
                //***Verificar os dados da consulta SQL            
                $option .= '<option value="'.$coluna['id_empresa'].'">'.$coluna['nome'].'</option>';
            }        
        } 
    
        return $option;
    } 
    function ativoVaga($idVaga){

        $resp = "";
    
        include("conexao.php");
        $sql = "SELECT FlgAtivo FROM vaga WHERE id_vaga = $idVaga;";        
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    
        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                if($coluna["FlgAtivo"] == 'S') $resp = 'checked'; else $resp = '';
            }        
        } 
    
        return $resp;
    }
    function proxIdVaga(){

        $idVaga = "";
    
        include("conexao.php");
        $sql = "SELECT MAX(id_vaga) AS Maior FROM vaga;";        
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    
        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
                    
            $array = array();
            
            while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($array,$linha);
            }
            
            foreach ($array as $coluna) {            
                //***Verificar os dados da consulta SQL
                $idVaga = $coluna["Maior"] + 1;
            }        
        } 
    
        return $idVaga;
    }

    function qtdVagasAtivas(){
        $qtd = 0;

        include("conexao.php");

        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S';"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S' AND fk_id_empresa = $idEmpresaUsuario;"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdVagasAtivasDiario(){

        include("conexao.php");
        
        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S';"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S' AND fk_id_empresa = $idEmpresaUsuario;"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdEntradas(){

        include("conexao.php");
        
        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'E';"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd
                        FROM movimentacao as mov
                        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
                        WHERE tipo = 'E' AND vag.fk_id_empresa = $idEmpresaUsuario;"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }   

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdEntradasDiario(){
        $qtd = 0;

        include("conexao.php");
        
        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'E' AND date(data) =  CURDATE();"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd
                        FROM movimentacao as mov
                        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
                        WHERE tipo = 'E' AND vag.fk_id_empresa = $idEmpresaUsuario AND date(data) =  CURDATE();"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }   

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdSaidas(){

        include("conexao.php");
        
        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'S';"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd
                        FROM movimentacao as mov
                        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
                        WHERE tipo = 'S' AND vag.fk_id_empresa = $idEmpresaUsuario;"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }   

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdSaidasDiario(){
        $qtd = 0;

        include("conexao.php");
        
        // Verifica o tipo de usuário na sessão
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa']; // Empresa à qual o usuário pertence

            // Ajusta a consulta SQL com base no tipo de usuário    
            if ($idTipoUsuario == 3) { // Dono
                $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'S' AND date(data) = CURDATE();"; // Lista todas as vagas
            } else if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
                $sql = "SELECT COUNT(*) AS Qtd
                        FROM movimentacao as mov
                        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
                        WHERE tipo = 'S' AND vag.fk_id_empresa = $idEmpresaUsuario AND date(data) = CURDATE();"; // Lista vagas da empresa do usuário
            } else {
                return "Tipo de usuário inválido.";
            }
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }   

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                $qtd = $coluna['Qtd'];
            }        
        }
        
        return $qtd;
    }
    function qtdAcimaHora() {
        $qtd = 0;
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            if ($idTipoUsuario == 3) { // Dono - sem filtro de empresa
                $sql = "SELECT COUNT(*) AS acima_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            WHERE mv_e.tipo = 'E'
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) > '01:00:00';";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Funcionário ou Admin
                $sql = "SELECT COUNT(*) AS acima_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
                            WHERE mv_e.tipo = 'E'
                              AND v.fk_id_empresa = $idEmpresaUsuario
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) > '01:00:00';";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $qtd = $row['acima_1h'];
            }
    
            return $qtd;
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
    
    function qtdAbaixoHora() {
    $qtd = 0;

    include("conexao.php");

    if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
        $idTipoUsuario = $_SESSION['idTipoUsuario'];
        $idEmpresaUsuario = $_SESSION['idEmpresa'];

        if ($idTipoUsuario == 3) { // Dono - sem filtro de empresa
            $sql = "SELECT COUNT(*) AS abaixo_1h
                    FROM (
                        SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                            (
                                SELECT MIN(mv_s.data)
                                FROM movimentacao mv_s
                                WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                  AND mv_s.tipo = 'S'
                                  AND mv_s.data > mv_e.data
                            ) AS saida
                        FROM movimentacao mv_e
                        WHERE mv_e.tipo = 'E'
                    ) AS sub
                    WHERE saida IS NOT NULL 
                      AND TIMEDIFF(saida, entrada) <= '01:00:00';";
        } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Funcionário ou Admin
            $sql = "SELECT COUNT(*) AS abaixo_1h
                    FROM (
                        SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                            (
                                SELECT MIN(mv_s.data)
                                FROM movimentacao mv_s
                                WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                  AND mv_s.tipo = 'S'
                                  AND mv_s.data > mv_e.data
                            ) AS saida
                        FROM movimentacao mv_e
                        INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
                        WHERE mv_e.tipo = 'E'
                          AND v.fk_id_empresa = $idEmpresaUsuario
                    ) AS sub
                    WHERE saida IS NOT NULL 
                      AND TIMEDIFF(saida, entrada) <= '01:00:00';";
        } else {
            return "Tipo de usuário inválido.";
        }

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        if ($row = mysqli_fetch_assoc($result)) {
            $qtd = $row['abaixo_1h'];
        }

        return $qtd;
    } else {
        return "Sessão não iniciada ou dados do usuário não definidos.";
    }
    }
    
    function qtdAcimaHoraDiario() {
        $qtd = 0;
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            if ($idTipoUsuario == 3) { // Dono - sem filtro de empresa
                $sql = "SELECT COUNT(*) AS acima_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            WHERE mv_e.tipo = 'E'
                              AND DATE(mv_e.data) = CURDATE()
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) > '01:00:00';";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Funcionário ou Admin
                $sql = "SELECT COUNT(*) AS acima_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
                            WHERE mv_e.tipo = 'E'
                              AND v.fk_id_empresa = $idEmpresaUsuario
                              AND DATE(mv_e.data) = CURDATE()
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) > '01:00:00';";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $qtd = $row['acima_1h'];
            }
    
            return $qtd;
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
    
    function qtdAbaixoHoraDiario() {
        $qtd = 0;
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            if ($idTipoUsuario == 3) { // Dono - considera todas as empresas
                $sql = "SELECT COUNT(*) AS abaixo_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            WHERE mv_e.tipo = 'E'
                              AND DATE(mv_e.data) = CURDATE()
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) <= '01:00:00';";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Funcionário ou Admin - filtra por empresa
                $sql = "SELECT COUNT(*) AS abaixo_1h
                        FROM (
                            SELECT mv_e.id_movimentacao, mv_e.data AS entrada,
                                (
                                    SELECT MIN(mv_s.data)
                                    FROM movimentacao mv_s
                                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                                      AND mv_s.tipo = 'S'
                                      AND mv_s.data > mv_e.data
                                ) AS saida
                            FROM movimentacao mv_e
                            INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
                            WHERE mv_e.tipo = 'E'
                              AND v.fk_id_empresa = $idEmpresaUsuario
                              AND DATE(mv_e.data) = CURDATE()
                        ) AS sub
                        WHERE saida IS NOT NULL 
                          AND TIMEDIFF(saida, entrada) <= '01:00:00';";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $qtd = $row['abaixo_1h'];
            }
    
            return $qtd;
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
    
    function TempoMedioTotal() {
        $qtd = '00:00';
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            if ($idTipoUsuario == 3) { // Dono - sem filtro de empresa
                $sql = "SELECT 
                            SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(saida.data, entrada.data)))) AS media_tempo
                        FROM 
                            movimentacao entrada
                        JOIN 
                            movimentacao saida ON saida.fk_id_vaga = entrada.fk_id_vaga
                                               AND saida.tipo = 'S'
                                               AND saida.data = (
                                                   SELECT MIN(mv2.data)
                                                   FROM movimentacao mv2
                                                   WHERE mv2.fk_id_vaga = entrada.fk_id_vaga
                                                     AND mv2.tipo = 'S'
                                                     AND mv2.data > entrada.data
                                               )
                        WHERE 
                            entrada.tipo = 'E';";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Admin ou Funcionário - filtra por empresa
                $sql = "SELECT 
                            SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(saida.data, entrada.data)))) AS media_tempo
                        FROM 
                            movimentacao entrada
                        JOIN 
                            movimentacao saida ON saida.fk_id_vaga = entrada.fk_id_vaga
                                               AND saida.tipo = 'S'
                                               AND saida.data = (
                                                   SELECT MIN(mv2.data)
                                                   FROM movimentacao mv2
                                                   WHERE mv2.fk_id_vaga = entrada.fk_id_vaga
                                                     AND mv2.tipo = 'S'
                                                     AND mv2.data > entrada.data
                                               )
                        JOIN 
                            vaga v ON entrada.fk_id_vaga = v.id_vaga
                        WHERE 
                            entrada.tipo = 'E'
                            AND v.fk_id_empresa = $idEmpresaUsuario;";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                if ($row['media_tempo'] !== null) {
                    $qtd = substr($row['media_tempo'], 0, 5); // HH:MM
                }
            }
    
            return $qtd;
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
    
    function TempoMedioDiario() {
        $qtd = '00:00';
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            if ($idTipoUsuario == 3) { // Dono - sem filtro por empresa
                $sql = "SELECT 
                            SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(saida.data, entrada.data)))) AS media_tempo
                        FROM 
                            movimentacao entrada
                        JOIN 
                            movimentacao saida ON saida.fk_id_vaga = entrada.fk_id_vaga
                                               AND saida.tipo = 'S'
                                               AND saida.data = (
                                                   SELECT MIN(mv2.data)
                                                   FROM movimentacao mv2
                                                   WHERE mv2.fk_id_vaga = entrada.fk_id_vaga
                                                     AND mv2.tipo = 'S'
                                                     AND mv2.data > entrada.data
                                               )
                        WHERE 
                            entrada.tipo = 'E'
                            AND DATE(entrada.data) = CURDATE();";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Admin ou Funcionário - filtra por empresa
                $sql = "SELECT 
                            SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(saida.data, entrada.data)))) AS media_tempo
                        FROM 
                            movimentacao entrada
                        JOIN 
                            movimentacao saida ON saida.fk_id_vaga = entrada.fk_id_vaga
                                               AND saida.tipo = 'S'
                                               AND saida.data = (
                                                   SELECT MIN(mv2.data)
                                                   FROM movimentacao mv2
                                                   WHERE mv2.fk_id_vaga = entrada.fk_id_vaga
                                                     AND mv2.tipo = 'S'
                                                     AND mv2.data > entrada.data
                                               )
                        JOIN 
                            vaga v ON entrada.fk_id_vaga = v.id_vaga
                        WHERE 
                            entrada.tipo = 'E'
                            AND v.fk_id_empresa = $idEmpresaUsuario
                            AND DATE(entrada.data) = CURDATE();";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                if ($row['media_tempo'] !== null) {
                    $qtd = substr($row['media_tempo'], 0, 5); // HH:MM
                }
            }
    
            return $qtd;
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }    
    
    function VagaMaisUsada() {
        $vaga = 'Nenhuma';
        $qtd = 0;
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            // Define SQL com base no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono - pode ver todas as vagas
                $sql = "SELECT fk_id_vaga, COUNT(*) AS total_usos
                        FROM movimentacao
                        WHERE tipo = 'E'
                        GROUP BY fk_id_vaga
                        ORDER BY total_usos DESC
                        LIMIT 1;";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Admin ou Funcionário - apenas da empresa
                $sql = "SELECT m.fk_id_vaga, COUNT(*) AS total_usos
                        FROM movimentacao m
                        INNER JOIN vaga v ON m.fk_id_vaga = v.id_vaga
                        WHERE m.tipo = 'E' AND v.fk_id_empresa = $idEmpresaUsuario
                        GROUP BY m.fk_id_vaga
                        ORDER BY total_usos DESC
                        LIMIT 1;";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $vaga = $row['fk_id_vaga'];
                $qtd = $row['total_usos'];
            }
    
            return "$vaga, $qtd";
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
    
    function VagaMenosUsada() {
        $vaga = 'Nenhuma';
        $qtd = 0;
    
        include("conexao.php");
    
        if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
            $idTipoUsuario = $_SESSION['idTipoUsuario'];
            $idEmpresaUsuario = $_SESSION['idEmpresa'];
    
            // SQL baseado no tipo de usuário
            if ($idTipoUsuario == 3) { // Dono - pode ver todas as vagas
                $sql = "SELECT v.id_vaga, COUNT(m.id_movimentacao) AS total_usos
                        FROM vaga v
                        LEFT JOIN movimentacao m 
                            ON v.id_vaga = m.fk_id_vaga AND m.tipo = 'E'
                        GROUP BY v.id_vaga
                        ORDER BY total_usos ASC
                        LIMIT 1;";
            } else if ($idTipoUsuario == 1 || $idTipoUsuario == 2) { // Admin ou Funcionário - apenas da empresa
                $sql = "SELECT v.id_vaga, COUNT(m.id_movimentacao) AS total_usos
                        FROM vaga v
                        LEFT JOIN movimentacao m 
                            ON v.id_vaga = m.fk_id_vaga AND m.tipo = 'E'
                        WHERE v.fk_id_empresa = $idEmpresaUsuario
                        GROUP BY v.id_vaga
                        ORDER BY total_usos ASC
                        LIMIT 1;";
            } else {
                return "Tipo de usuário inválido.";
            }
    
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $vaga = $row['id_vaga'];
                $qtd = $row['total_usos'];
            }
    
            return "$vaga, $qtd";
        } else {
            return "Sessão não iniciada ou dados do usuário não definidos.";
        }
    }
?>
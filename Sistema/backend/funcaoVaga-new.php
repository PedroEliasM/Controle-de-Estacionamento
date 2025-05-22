<?php
// foreach (única coisa a ser modificada no funcaoVaga.php original para fazer os widgets)

foreach ($result as $coluna) {
    $vaga_id = $coluna["id_vaga"];
    $descricao = htmlspecialchars($coluna["descricao"]);
    $situacao = htmlspecialchars($coluna["situacao"]);
    $id_empresa = htmlspecialchars($coluna["fk_id_empresa"]); // Usa fk_id_empresa
    // Chama descrEmpresa para obter o nome da empresa, como você já faz
    $empresa_nome = descrEmpresa($coluna["fk_id_empresa"]); 
    $flg_ativo = $coluna["flg_ativo"];

    $card_class = '';
    // Normaliza a situação para aplicar o CSS correto
    $situacao_normalizada = strtolower(trim($situacao));

    switch ($situacao_normalizada) {
        case 'inativa':
            $card_class = 'inativa';
            break;
        case 'livre':
            $card_class = 'livre';
            break;
        case 'ocupada':
            $card_class = 'ocupada';
            break;
        default:
            $card_class = 'inativa'; // Default para caso a situação não seja reconhecida
            break;
    }

    // O novo HTML para o CARD (widget)
    $lista .= '
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
        <div class="vaga-card ' . $card_class . '">
            <div class="vaga-id">'.$vaga_id.'</div>
            <div class="vaga-status">'.$situacao.'</div>
            <div class="vaga-actions">
                <a href="#modalEditVaga'.$vaga_id.'" data-toggle="modal" title="Alterar Vaga">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#modalDeleteVaga'.$vaga_id.'" data-toggle="modal" title="Excluir Vaga">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
    </div>';
    
    // Modais de Edição e Exclusão (mantidos no loop, gerados para cada vaga)
    // Usamos os IDs únicos dos modais.
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
                                        // optionEmpresa() já gera todas as outras opções, mantendo a função original
                    $lista .=              optionEmpresa();
                    $lista .= '
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="editSituacao'.$vaga_id.'">Situação:</label>
                                    <input type="text" value="'.$situacao.'" class="form-control" id="editSituacao'.$vaga_id.'" name="nSituacao" maxlength="80">
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="checkbox" id="editAtivo'.$vaga_id.'" name="nAtivo" '.($flg_ativo == 'S' ? 'checked' : '').'>
                                    <label for="editAtivo'.$vaga_id.'">Vaga Ativa</label>
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
// Fim foreach modificado para widgets




























// foreach em formato excell (arquivo padrão inicial)
foreach ($result as $coluna) {

    //Ativo: S ou N
    //if($coluna["FlgAtivo"] == 'S')  $ativo = 'checked'; else $ativo = '';
    if($coluna["flg_ativo"] == 'S'){  
        $ativo = 'checked';
        $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
    }else{
        $ativo = '';
        $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
    } 
    
    
    //***Verificar os dados da consulta SQL
    $lista .= 
    '<tr>'
        .'<td align="center">'.$coluna["id_vaga"].'</td>'
        .'<td align="center">'.$coluna["fk_id_empresa"].'</td>'
        .'<td>'.$coluna["descricao"].'</td>'
        .'<td>'.$coluna["situacao"].'</td>'
        .'<td align="center">'.$icone.'</td>'
        .'<td>'
            .'<div class="row" align="center">'
                .'<div class="col-6">'
                    .'<a href="#modalEditVaga'.$coluna["id_vaga"].'" data-toggle="modal">'
                        .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Vaga"></i></h6>'
                    .'</a>'
                .'</div>'
                
                .'<div class="col-6">'
                    .'<a href="#modalDeleteVaga'.$coluna["id_vaga"].'" data-toggle="modal">'
                        .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Vaga"></i></h6>'
                    .'</a>'
                .'</div>'
            .'</div>'
        .'</td>'
    .'</tr>'
    
    .'<div class="modal fade" id="modalEditVaga'.$coluna["id_vaga"].'">'
        .'<div class="modal-dialog modal-lg">'
            .'<div class="modal-content">'
                .'<div class="modal-header bg-info">'
                    .'<h4 class="modal-title">Alterar Vaga</h4>'
                    .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                .'</div>'
                .'<div class="modal-body">'

                    .'<form method="POST" action="backend/salvarVaga.php?funcao=A&codigo='.$coluna["id_vaga"].'" enctype="multipart/form-data">'              
        
                        .'<div class="row">'
                            .'<div class="col-8">'
                                .'<div class="form-group">'
                                    .'<label for="iDescricao">Descrição:</label>'
                                    .'<input type="text" id="iDescricao" name="nDescricao" value="'.$coluna["descricao"].'" class="form-control"  maxlength="50">'
                                .'</div>'
                            .'</div>'
            
                            .'<div class="col-4">'
                                .'<div class="form-group">'
                                    .'<label for="iEmpresa">Empresa:</label>'
                                    .'<select name="nEmpresa" id="iEmpresa" class="form-control" required>'
                                        .'<option value="'.$coluna["fk_id_empresa"].'">'.descrEmpresa($coluna["fk_id_empresa"]).'</option>'
                                        .optionEmpresa()
                                    .'</select>'
                                .'</div>'
                            .'</div>'
            
                            .'<div class="col-8">'
                                .'<div class="form-group">'
                                    .'<label for="iSituacao">Situação:</label>'
                                    .'<input type="text" value="'.$coluna["situacao"].'" class="form-control" id="iSituacao" name="nSituacao" maxlength="50">'
                                .'</div>'
                            .'</div>'
         
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                    .'<label for="iAtivo">Vaga Ativa</label>'
                                .'</div>'
                            .'</div>'
        
                        .'</div>'
        
                        .'<div class="modal-footer">'
                            .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                            .'<button type="submit" class="btn btn-success">Salvar</button>'
                        .'</div>'
                        
                    .'</form>'
                    
                .'</div>'
            .'</div>'
        .'</div>'
    .'</div>'
    
    .'<div class="modal fade" id="modalDeleteVaga'.$coluna["id_vaga"].'">'
        .'<div class="modal-dialog">'
            .'<div class="modal-content">'
                .'<div class="modal-header bg-danger">'
                    .'<h4 class="modal-title">Excluir Vaga: '.$coluna["id_vaga"].'</h4>'
                    .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                .'</div>'
                .'<div class="modal-body">'

                    .'<form method="POST" action="backend/salvarVaga.php?funcao=D&codigo='.$coluna["id_vaga"].'" enctype="multipart/form-data">'              

                        .'<div class="row">'
                            .'<div class="col-12">'
                                .'<h5>Deseja EXCLUIR a vaga '.$coluna["descricao"].'?</h5>'
                            .'</div>'
                        .'</div>'
                        
                        .'<div class="modal-footer">'
                            .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                            .'<button type="submit" class="btn btn-success">Sim</button>'
                        .'</div>'
                        
                    .'</form>'
                    
                .'</div>'
            .'</div>'
        .'</div>'
    .'</div>';            
}
// fim foreach padrão inicial
?>
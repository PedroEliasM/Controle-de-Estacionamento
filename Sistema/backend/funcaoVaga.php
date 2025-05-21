<?php
    function listaVagas(){
        $lista = "";

        include("conexao.php");

        $sql = "SELECT * FROM vaga;";
        //var_dump($sql);
        //die();

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){

            

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

        $sql = "SELECT COUNT(*) AS Qtd FROM vaga WHERE flg_ativo = 'S';";

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
        $qtd = 0;

        include("conexao.php");

        $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'E';";

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
        $qtd = 0;

        include("conexao.php");

        $sql = "SELECT COUNT(*) AS Qtd FROM movimentacao WHERE tipo = 'S';";

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
    function qtdEntradasSaidas(){
    
        $descricao = "";
    
        include("conexao.php");
        $sql = "SELECT
	tipo,
	COUNT(*) AS total FROM movimentacao WHERE date(data) =  CURDATE() GROUP BY tipo;";        
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    
        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            foreach ($result as $coluna) {            
                //***Verificar os dados da consulta SQL
                if ($i < 3){
                    $descricao .= "'".$coluna['COUNT(*)']."',";
                }else{
                    $descricao .= "'".$coluna['COUNT(*)']."'";
                }
    
                $i++;
            }        
        } 
    
        return json_encode($descricao); // Retorna um array JSON válido
    }
?>
<?php
//Função para listar todos os fornecedores
function listaFornecedor(){

    include("conexao.php");
    $sql = "SELECT * FROM fornecedor ORDER BY id_fornecedor;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $ativo = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
        foreach ($result as $coluna) {

            //Ativo: S ou N
            //if($coluna["flg_ativo"] == 'S')  $ativo = 'checked'; else $ativo = '';
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
                .'<td align="center">'.$coluna["id_fornecedor"].'</td>'
                .'<td>'.$coluna["nome_fantasia"].'</td>'
                .'<td>'.$coluna["cnpj"].'</td>'
                .'<td>'.$coluna["cidade"].'</td>'
                .'<td>'.$coluna["uf"].'</td>'

                .'<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditFornecedor'.$coluna["id_fornecedor"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Fornecedor"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteFornecedor'.$coluna["id_fornecedor"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Fornecedor"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditFornecedor'.$coluna["id_fornecedor"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar fornecedor</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarFornecedor.php?funcao=A&codigo='.$coluna["id_fornecedor"].'" enctype="multipart/form-data">'
                    
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNomeFantasia">Nome Fantasia:</label>'
                                            .'<input type="text" value="'.$coluna["nome_fantasia"].'" class="form-control" id="iNomeFantasia" name="nNomeFantasia" maxlength="50">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iCNPJ">CNPJ:</label>'
                                            .'<input type="text" value="'.$coluna["cnpj"].'" class="form-control" id="iCNPJ" name="nCNPJ" maxlength="20">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iCidade">Cidade:</label>'
                                            .'<input type="text" value="'.$coluna["cidade"].'" class="form-control" id="iCidade" name="nCidade" maxlength="80">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iUF">UF:</label>'
                                            .'<input type="text" value="'.$coluna["uf"].'" class="form-control" id="iUF" name="nUF" maxlength="2">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogo">Foto:</label>'
                                            .'<input type="file" class="form-control" id="iLogo" name="nLogo" accept="image/*">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                            .'<label for="iAtivo">fornecedor Ativo</label>'
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
            
            .'<div class="modal fade" id="modalDeleteFornecedor'.$coluna["id_fornecedor"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir fornecedor: '.$coluna["id_fornecedor"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarFornecedor.php?funcao=D&codigo='.$coluna["id_fornecedor"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Deseja EXCLUIR o fornecedor '.$coluna["nome_fantasia"].'?</h5>'
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

//Próximo ID do fornecedor
function proxIdFornecedor(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(id_fornecedor) AS Maior FROM fornecedor;";        
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
            $id = $coluna["Maior"] + 1;
        }        
    } 

    return $id;
}

//Função para buscar a logo do fornecedor
function logoFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT logo FROM fornecedor WHERE id_fornecedor = $id;";        
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
            $resp = $coluna["logo"];
        }        
    } 

    return $resp;
}

//Função para buscar o nome do fornecedor
function nomeFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT nome_fantasia FROM fornecedor WHERE id_fornecedor = $id;";        
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
            $resp = $coluna["nome_fantasia"];
        }        
    } 

    return $resp;
}

//Função para buscar o CNPJ do fornecedor
function cnpjFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT cnpj FROM fornecedor WHERE id_fornecedor = $id;";        
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
            $resp = $coluna["cnpj"];
        }        
    } 

    return $resp;
}

//Função para buscar a cidade do fornecedor
function cidadeFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT cidade FROM fornecedor WHERE id_fornecedor = $id;";        
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
            $resp = $coluna["cidade"];
        }        
    } 

    return $resp;
}

//Função para buscar a UF do fornecedor
function ufFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT uf FROM fornecedor WHERE id_fornecedor = $id;";        
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
            $resp = $coluna["uf"];
        }        
    } 

    return $resp;
}

/*
//Função para buscar o login do fornecedor
function loginUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Login FROM usuarios WHERE idUsuario = $id;";        
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
            $resp = $coluna["Login"];
        }        
    } 

    return $resp;
}
*/

//Função para buscar a flag flg_ativo do fornecedor
function ativoFornecedor($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT flg_ativo FROM fornecedor WHERE id_fornecedor = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            if($coluna["flg_ativo"] == 'S') $resp = 'checked'; else $resp = '';
        }        
    } 

    return $resp;
}

//Função para retornar a qtd de fornecedores ativos
function qtdFornecedoresAtivos(){
    $qtd = 0;

    include("conexao.php");
    $sql = "SELECT COUNT(*) AS Qtd FROM fornecedor WHERE flg_ativo = 'S';";

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

?>
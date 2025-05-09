<?php
//Função para listar todos os usuários
function listaUsuario(){

    include("conexao.php");
    $sql = "SELECT * FROM usuario ORDER BY id_usuario;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td align="center">'.$coluna["id_usuario"].'</td>'
                .'<td align="center">'.descrTipoUsuario($coluna["id_tipo_usuario"]).'</td>'
                .'<td>'.$coluna["nome"].'</td>'
                .'<td>'.$coluna["login"].'</td>'
                .'<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditUsuario'.$coluna["id_usuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteUsuario'.$coluna["id_usuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditUsuario'.$coluna["id_usuario"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvar_usuario.php?funcao=A&codigo='.$coluna["id_usuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" requerid>'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Tipo de Usuário:</label>'
                                            .'<select name="nTipoUsuario" class="form-control" required>'
                                                .'<option value="'.$coluna["iid_tipo_usuario"].'">'.descrTipoUsuario($coluna["id_tipo_usuario"]).'</option>'
                                                .optionTipoUsuario()
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogin">Login:</label>'
                                            .'<input type="email" value="'.$coluna["login"].'" class="form-control" id="iLogin" name="nLogin" requerid>'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Senha:</label>'
                                            .'<input type="text" value="" class="form-control" id="iSenha" name="nSenha" requerid>'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto:</label>'
                                            .'<input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">'
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
            
            .'<div class="modal fade" id="modalDeleteUsuario'.$coluna["id_usuario"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Usuário: '.$coluna["id_usuario"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvar_usuario.php?funcao=D&codigo='.$coluna["id_usuario"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Deseja EXCLUIR o usuário '.$coluna["nome"].'?</h5>'
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


//Próximo ID do usuário
function proxIdUsuario(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(id_usuario) AS Maior FROM usuario;";        
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
            $id = $coluna["maior"] + 1;
        }        
    } 

    return $id;
}

//Função para buscar o tipo de acesso do usuário
function tipoAcessoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT id_tipo_usuario FROM usuario WHERE id_usuario = $id;";        
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
            if($coluna["id_tipo_usuario"] == 1){
                //Admin
                $resp = '<option value="1">Admin</option>'
                        .'<option value="2">funcionario</option>';
            }else if ($coluna["id_tipo_usuario"] == 2){
                //funcionario
                $resp = '<option value="2">funcionario</option>'
                        .'<option value="1">Admin</option>';
            }
        }        
    } 

    return $resp;
}

//Função para buscar a foto do usuário
function fotoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Foto FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["Foto"];
        }        
    } 

    return $resp;
}

//Função para buscar o nome do usuário
function nomeUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Nome FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["nome"];
        }        
    } 

    return $resp;
}

//Função para buscar o login do usuário
function loginUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Login FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["login"];
        }        
    } 

    return $resp;
}


?>
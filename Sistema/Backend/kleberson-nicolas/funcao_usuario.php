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
            "<tr>
                <td>"   "<td>
            <tr>";            
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
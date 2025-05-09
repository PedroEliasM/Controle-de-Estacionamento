<?php


function fotoUsuario($id){

$resp = "";

include("conexao.php");
$sql = "SELECT foto FROM usuario WHERE id_usuario = $id;";        
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
        $resp = $coluna["foto"];
    }        
} 

return $resp;
}


function nomeUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT nome FROM usuario WHERE id_usuario = $id;";        
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


function empresaUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT nome FROM empresa WHERE id_empresa = $id;";        
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
            $resp = $coluna["empresa"];
        }        
    } 

    return $resp;
}



function emailUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT email FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["email"];
        }        
    } 

    return $resp;
}

function tipoUsuario(){

    $option = "";

    include("conexao.php");
    $sql = "SELECT descricao FROM tipo_usuario WHERE id_tipo_usuario = $id;";        
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
            $option .= '<option value="'.$coluna['id_tipo_usuario'].'">'.$coluna['descricao'].'</option>';
        }        
    } 

    return $option;
}

function senhaUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT senha FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["senha"];
        }        
    } 

    return $resp;
}


?>
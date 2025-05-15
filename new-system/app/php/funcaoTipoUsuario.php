<?php

//Função para buscar a descrição do tipo de usuário
function descrTipoUsuario($id){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT Descricao FROM tipousuario WHERE idTipoUsuario = $id;";        
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
            $descricao = $coluna["Descricao"];
        }        
    } 

    return $descricao;
}

//Função para montar o select/option
function optionTipoUsuario(){

    $option = "";

    include("conexao.php");
    $sql = "SELECT idTipoUsuario, Descricao FROM tipousuario ORDER BY Descricao;";        
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
            $option .= '<option value="'.$coluna['idTipoUsuario'].'">'.$coluna['Descricao'].'</option>';
        }        
    } 

    return $option;
}

// Descrição para gráfico de barras
function descrTipoUsuarioBarras(){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT Descricao FROM tipousuario;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            if ($i < 3){
                $descricao .= "'".$coluna["Descricao"]."',";
            }else{
                $descricao .= "'".$coluna["Descricao"]."'";
            }

            $i++;
        }        
    } 

    return json_encode($descricao); // Retorna um array JSON válido
}

// Função para trazer a quantidade de usuários ativos por tipo de usuário
function qtdTipoUsuarioAtivo($tipoUsuario){

    include("conexao.php");

    $qtdTipoUsuarioAtivo = '0';

    // Monta a consulta SQL com base no tipo de usuário
    $sql = "SELECT COUNT(*) AS Qtd FROM usuarios WHERE FlgAtivo = 'S'";
    if ($tipoUsuario == '1' || $tipoUsuario == '2' || $tipoUsuario == '3') {
        $sql .= " AND idTipoUsuario = '$tipoUsuario'";
    }

    // Executa a consulta
    $result = mysqli_query($conn, $sql);
    // Fecha a conexão
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL            
            $qtdTipoUsuarioAtivo = $coluna['Qtd']; 
        }        
    }  

    return $qtdTipoUsuarioAtivo;
}

function qtdTipoUsuarioInativo($tipoUsuario){

    include("conexao.php");

    $qtdTipoUsuarioInativo = '0';

    // Monta a consulta SQL com base no tipo de usuário
    $sql = "SELECT COUNT(*) AS Qtd FROM usuarios WHERE FlgAtivo = 'N'";
    if ($tipoUsuario == '1' || $tipoUsuario == '2' || $tipoUsuario == '3') {
        $sql .= " AND idTipoUsuario = '$tipoUsuario'";
    }

    // Executa a consulta
    $result = mysqli_query($conn, $sql);
    // Fecha a conexão
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL            
            $qtdTipoUsuarioInativo = $coluna['Qtd'];
        }        
    }  

    return $qtdTipoUsuarioInativo;
}

?>
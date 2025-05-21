<?php
function listaVagas() {
    $lista = "";

    include("conexao.php");

    $sql = "SELECT * FROM vaga;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $coluna) {
            // Define a cor ou estilo com base na situação ou ativo
            $statusClass = $coluna["flg_ativo"] == 'S' ? 'vaga-ativa' : 'vaga-inativa';

            // Gera cada "quadradinho" com as informações da vaga
            $lista .= '
                <div class="vaga ' . $statusClass . '">
                    <h5>' . $coluna["descricao"] . '</h5>
                    <p>Situação: ' . $coluna["situacao"] . '</p>
                    <p>Empresa: ' . descrEmpresa($coluna["fk_id_empresa"]) . '</p>
                    <div class="acoes">
                        <a href="#modalEditVaga' . $coluna["id_vaga"] . '" data-toggle="modal" class="btn btn-info btn-sm">Editar</a>
                        <a href="#modalDeleteVaga' . $coluna["id_vaga"] . '" data-toggle="modal" class="btn btn-danger btn-sm">Excluir</a>
                    </div>
                </div>
            ';
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
?>
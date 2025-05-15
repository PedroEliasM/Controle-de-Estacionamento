<?php
    function listaVagas(){
        $lista = '';

        include("conexao.php");

        $sql = "SELECT * FROM vaga;";
        //var_dump($sql);
        //die();

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                $idVaga = $campo['id_vaga'];
                $lista .= "
                <tr>
                    <td>" . $campo['id_vaga'] . "</td>
                    <td>" . $campo['descricao'] . "</td>
                    <td>" . $campo['situacao'] . "</td>
                    <td>" .nomeEmpresa($campo['fk_id_empresa']). "</td>
                    <td>" .descrFlag($campo['flg_ativo']) . "</td>
                    <td>
                    <a href='#' onclick=openModal2();>
                    Alterar
                  </a>
                         | 
                        <a href='excluir-vaga.php?id=$idVaga'>
                            Excluir
                        </a>
                    </td>
                </tr>";
                
            }
        }

        return $lista;
    }
    
    /*function optionEmpresa($idEmpresa){

        $option = "";
    
        include("conexao.php");
        $sql = "SELECT * 
        FROM empresa
        WHERE id_empresa <> $idEmpresa;";        
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    
        //Validar se tem retorno do BD
        if (mysqli_num_rows($result) > 0) {
                foreach ($array as $coluna) {            
                //***Verificar os dados da consulta SQL            
                $option .= '<option value="'.$coluna['id_empresa'].'">'.$coluna['nome'].'</option>';
            }        
        } 
    
        return $option;
    }*/
    

    function optionEmpresa($idVaga) {
        $lista = "";

        include("conexao.php");

        $sql = "SELECT * 
        FROM empresa
        WHERE flg_ativo = 'S'
        AND id_empresa <> $idVaga;";
        //var_dump($sql);
        //die();

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                $lista .= '<option value="'. $campo['id_empresa'] .'">'. $campo['nome'] .'</option>';
            }
        }

        return $lista;
    } 
    
    function descrFlag($flag) {
        if($flag == 'S') {
            return 'Sim';
        } else {
            return 'Não';
        }
    }

    function nomeEmpresa($idVaga){

        $nomeEmpresa = "";
    
        include("conexao.php");
        $sql = "SELECT nome FROM empresa WHERE id_empresa = $idVaga;";        
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
                $nomeEmpresa = $coluna["nome"];
            }        
        } 
    
        return $nomeEmpresa;
    }

    // Dados por ID
    function buscaVagaId($idVaga) {
        include("conexao.php");

        $sql = "SELECT *
                FROM vaga
                WHERE id_vaga = $idVaga;";
        //var_dump($sql);
        //die();

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                
            }
        }
        return $campo;
    }
    function proximoIDVaga($idVaga){
        $idVaga=0;
        
        include("conexao.php");
        $sql = "SELECT MAX(id_vaga) AS id_vaga FROM vaga;";
        

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                $idVaga = $campo['id_vaga'];
            }
        }

        return $idVaga + 1;
    }
?>
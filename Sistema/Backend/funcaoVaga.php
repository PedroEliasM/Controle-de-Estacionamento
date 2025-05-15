<?php
    function listaVagas(){
        $linha = "";

        include("conexao.php");

        $sql = "SELECT * FROM vaga;";
        //var_dump($sql);
        //die();

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                $idVaga = $campo['id_vaga'];
                $linha .= "
                <tr>
                    <td>" . $campo['id_vaga'] . "</td>
                    <td>" . $campo['descricao'] . "</td>
                    <td>" . $campo['situacao'] . "</td>
                    <td>" .nomeEmpresa($campo['fk_id_empresa']). "</td>
                    <td>" .descrFlag($campo['flg_ativo']) . "</td>
                    <td>
                        <a href='alterar-vaga.php?id=$idVaga'>
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

        return $linha;
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

?>
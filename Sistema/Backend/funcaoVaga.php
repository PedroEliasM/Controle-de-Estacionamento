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
                    <td>" .$campo['fk_id_empresa']. "</td>
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
    

?>
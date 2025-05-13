<?php
    function listaUsuario(){
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
                    <td>" . $campo['id_usuario'] . "</td>
                    <td>" . $campo['nome'] . "</td>
                    <td>" . $campo['login'] . "</td>
                    <td>" .$campo['fk_id_empresa']. "</td>
                    <td>" .descrFlag($campo['flg_ativo']) . "</td>
                    <td>
                        <a href='alterar_usuario.php?id=$idusuario'>
                            Alterar
                        </a>
                         | 
                        <a href='excluir_usuario.php?id=$idusuario'>
                            Excluir
                        </a>
                    </td>
                </tr>";
                
            }
        }

        return $linha;
    }
    

?>
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
    
    function optionEmpresa($idEmpresa){

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
    }
    function optionEmpresaId($idEmpresa){
        $lista = "";

        include("conexao.php");

        $sql = "SELECT * 
        FROM empresa
        WHERE id_empresa= $idEmpresa;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
                $lista .= '<option value="'. $campo['id_empresa'] .'">'
                . $campo['nome'] .'</option>';
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
    /*function nomeEmpresa($idVaga){
        include("conexao.php");
        $sql = "SELECT em.nome
        from empresa em
        inner join vaga vg
        on em.id_empresa = vg.fk_id_empresa
        WHERE id_vaga = $idVaga;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){

            }
        }
        return $campo;
    }*/

    /*
    function nomeEmpresa($idVaga){

        $nome = "";
    
        include("conexao.php");
        $sql = "SELECT em.nome
        from empresa em
        inner join vaga vg
        on em.id_empresa = vg.fk_id_empresa
        WHERE id_vaga = $idVaga;"; 

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
                $nome = $coluna["nome"];
            }        
        } 
    
        return $nome;
    }*/

?>
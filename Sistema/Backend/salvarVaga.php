<?php

    include('funcoes.php');

    $descricao   = $_POST["nDescricao"];
    $situacao = $_POST["nSituacao"];
    $idEmpresa   = $_GET["nEmpresa"];

    include("conexao.php");
    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    //Validar se é Inclusão ou Alteração ou Deletar
    if($funcao == "I"){

        //Busca o próximo ID na tabela

        //$idVaga = proxIdVaga();

        //INSERT
        $sql = "INSERT INTO vaga (id_vaga,descricao,situacao,flg_ativo,fk_id_empresa) "
                ." VALUES (".$idVaga.","
                .$descricao.","
                .$situacao.","
                .$ativo.,","
                .$idEmpresa.");";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE vaga "
                ." SET descricao = ".$descricao.", "
                    ." situacao = '".$situacao."', "
                    ." flg_ativo = '".$ativo."', "
                    ." fk_id_empresa = '".$idEmpresa."',
                     WHERE id_vaga = ".$idVaga.";";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM vaga "
                ." WHERE id_vaga = ".$idVaga.";";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../vagas.php");

?>
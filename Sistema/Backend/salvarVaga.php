<?php

    include('funcoes.php');

    $descricao   = $_POST["nDescricao"];
    $situacao = $_POST["nSituacao"];
    $idE   = $_POST["nEmpresa"];
    $funcao = $_GET["funcao"];
    $ativo = $_POST["nAtivo"];

    include("conexao.php");
    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    //Validar se é Inclusão ou Alteração ou Deletar
    if($funcao == "I"){
        $idVaga = proximoIDVaga('usuario','id_usuario');
        //Busca o próximo ID na tabela

        //$idVaga = proxIdVaga();

        //INSERT
<<<<<<< HEAD
        $sql = "INSERT INTO vaga (id_vaga,descricao,situacao,flg_ativo,fk_id_empresa) 
                 VALUES ($idVaga,'$descricao','$situacao','$ativo',$idE);";
=======
        $sql = "INSERT INTO vaga (id_vaga,descricao,situacao,flg_ativo,fk_id_empresa) "
                ." VALUES (".$idVaga.","
                .$descricao.","
                .$situacao.","
                .$ativo.","
                .$idEmpresa.");";
>>>>>>> 77a40118fda4ff5c4cd8c270bd26d35394e3e52b

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE vaga "
                ." SET descricao = ".$descricao.", "
                    ." situacao = '".$situacao."', "
                    ." flg_ativo = '".$ativo."', "
                    ." fk_id_empresa = '".$idE."',
                     WHERE id_vaga = ".$idVaga.";";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM vaga  WHERE id_vaga = $idVaga;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../Frontend/vagas.php");

?>
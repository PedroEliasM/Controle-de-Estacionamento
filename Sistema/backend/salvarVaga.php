<?php
<<<<<<< HEAD
session_start();
include('funcoes.php');
=======

    include('funcoes.php');
>>>>>>> ed3c60125e62d1443038dc2dd1895940f0901a03

    $descricao   = $_POST["nDescricao"];
    $situacao = $_POST["nSituacao"];
    $idEmpresa   = $_POST["nEmpresa"];
    $funcao      = $_GET["funcao"];
    $idVaga   = $_GET["codigo"];

    include("conexao.php");

    if (isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on") {
    $ativo = "S";
    } else {
    $ativo = "N";
    }

<<<<<<< HEAD
    // UPDATE
    $sql = "UPDATE vaga
            SET descricao = '$descricao',
                situacao = '$situacao',
                flg_ativo = '$ativo'
            WHERE id_vaga = $idVaga;";
    
    mysqli_query($conn, $sql);
=======
    //Validar se é Inclusão ou Alteração ou Deletar
    if($funcao == "I"){
>>>>>>> ed3c60125e62d1443038dc2dd1895940f0901a03

        //Busca o próximo ID na tabela
        $idVaga = proxIdVaga();

        //INSERT
        $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa) "
     . "VALUES (" . $idVaga . ", '" . $descricao . "', '" . $situacao . "', '" . $ativo . "', " . $idEmpresa . ");";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE vaga "
     . "SET descricao = '" . $descricao . "', "
     . "    situacao = '" . $situacao . "', "
     . "    flg_ativo = '" . $ativo . "', "
     . "    fk_id_empresa = '" . $idEmpresa . "' "
     . "WHERE id_vaga = " . $idVaga . ";";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM vaga "
                ." WHERE id_vaga = ".$idVaga.";";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

<<<<<<< HEAD
    // Exclui primeiro da tabela movimentacao
    $sql = "DELETE FROM movimentacao WHERE fk_id_vaga = $idVaga;";
    mysqli_query($conn, $sql);

    // Depois exclui da tabela vaga
    $sql = "DELETE FROM vaga WHERE id_vaga = $idVaga;";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);
header("location: ../vagas.php");
=======
    header("location: ../vagas.php");
>>>>>>> ed3c60125e62d1443038dc2dd1895940f0901a03

?>
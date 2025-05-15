<?php

    include('funcoes.php');

    $descricao   = $_POST["nDescricao"];
    $idCategoria = $_POST["nCategoria"];
    $quantidade  = $_POST["nQuantidade"];
    $funcao      = $_GET["funcao"];
    $idProduto   = $_GET["codigo"];

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idProduto = proxIdProduto();

        //INSERT
        $sql = "INSERT INTO produto (idProduto,idCategoria,Descricao,Quantidade) "
                ." VALUES (".$idProduto.","
                .$idCategoria.","
                ."'$descricao',"
                .$quantidade.");";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE produto "
                ." SET idCategoria = ".$idCategoria.", "
                    ." Descricao = '".$descricao."', "
                    ." Quantidade = ".$quantidade
                ." WHERE idProduto = ".$idProduto.";";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM produto "
                ." WHERE idProduto = ".$idProduto.";";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../produtos.php");

?>
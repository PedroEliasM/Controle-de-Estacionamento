<?php
    include("conexao.php");

    $idFornecedor = $_GET['id'];

    $sql = "DELETE FROM fornecedor "
            ." WHERE md5(id_fornecedor) = '".$idFornecedor."';";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../lista-fornecedor.php");

?>
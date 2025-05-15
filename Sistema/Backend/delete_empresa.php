<?php
    include("conexao.php");

    $idEmpresa = $_GET['id'];

    $sql = "DELETE FROM empresa "
            ." WHERE id_empresa = '".$idEmpresa."';";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../lista_empresa.php");

?>
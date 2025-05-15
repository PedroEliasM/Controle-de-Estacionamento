<?php
    include("conexao.php");

    $idUsuario = $_GET['id'];

    $sql = "DELETE FROM usuario "
            ." WHERE id_usuario = '".$idUsuario."';";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../lista_usuario.php");

?>
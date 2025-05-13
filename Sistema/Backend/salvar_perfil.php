<?php
    session_start();
    include('conexao.php');

    $tipoUsuario = $_POST["nTipoUsuario"];
    $foto        = $_POST["nfoto"];
    $nome        = $_POST["nNome"];
    $login       = $_POST["nLogin"];
    $senha       = $_POST["nSenha"];
    $opcao      = $_GET["opcao"];
    $id   = $_GET["id"];

    if($senha == ''){ 
        $setSenha = ''; 
    }else{ 
        $setSenha = " Senha = md5('".$senha."'), ";
    }

    $sql = "UPDATE usuarios "
            ." SET Nome = '".$nome."' "
                            .$setSenha 
            ." WHERE id_usuario = ".$idUsuario.";";                                 
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../Frontend/painel-perfil.php");
?>
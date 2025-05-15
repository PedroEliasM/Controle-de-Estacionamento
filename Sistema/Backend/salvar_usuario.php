<?php

    $tipoUsuario = $_POST["nTipoUsuario"];
    $foto        = $_POST["nfoto"];
    $nome        = $_POST["nNome"];
    $login       = $_POST["nLogin"];
    $senha       = $_POST["nSenha"];
    $opcao      = $_GET["opcao"];
    $id   = $_GET["id"];

    include('../funcoes.php');

    include("../conexao.php");

    //Validar se é Inclusão ou Alteração
    if($opcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE usuario "
                ." SET id_tipo_usuario = $id, "
                    ." nome = '$nome', "
                    ." login = '$login', "
                    ." foto = '$foto', "
                    .$setSenha 
                ." WHERE id_usuario = $idUsuario;";

    }elseif($opcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuario "
                ." WHERE id_usuario = $id;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['Foto']['tmp_name'] != ""){

     
        $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Foto']['name']).'.'.$extensao;        
        
        
        if(is_dir('../img/')){
            //Existe
            $diretorio = '../img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = '../Frontend/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuario "
                ." SET Foto = '$dirImagem' "
                ." WHERE id_usuario = $id;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }
    

    header("location: ../Frontend/painel-perfil.php");

?>
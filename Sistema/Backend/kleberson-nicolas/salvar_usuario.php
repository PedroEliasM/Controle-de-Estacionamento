<?php

    include('../funcoes.php');

    $tipoUsuario = $_POST["nTipoUsuario"];
    $nome        = $_POST["nNome"];
    $login       = $_POST["nLogin"];
    $senha       = $_POST["nSenha"];
    $funcao      = $_GET["funcao"];
    $idUsuario   = $_GET["codigo"];

    include("../conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idUsuario = proxIdUsuario();

        //INSERT
        $sql = "INSERT INTO usuarios (id_usuario,id_tipo_usuario,nome,login,Senha) "
                ." VALUES (".$idUsuario.","
                .$tipoUsuario.","
                ."'$nome',"
                ."'$login',"
                ."md5('$senha'),"
;

    }elseif($funcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE usuario "
                ." SET id_tipo_usuario = $tipoUsuario, "
                    ." Nome = '$nome', "
                    ." Login = '$login', "
                    .$setSenha 
                    ." FlgAtivo = '$ativo' "
                ." WHERE id_usuario = $idUsuario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuario "
                ." WHERE id_usuario = $id_Usuario;";
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
        $dirImagem = '/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuario "
                ." SET Foto = '$dirImagem' "
                ." WHERE id_usuario = $idUsuario;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../usuario.php");

?>
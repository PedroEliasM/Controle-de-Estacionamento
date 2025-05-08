<?php

    include('funcoes.php');

    $tipoUsuario = $_POST["nTipoUsuario"];
    $nome        = $_POST["nNome"];
    $login       = $_POST["nLogin"];
    $senha       = $_POST["nSenha"];
    $funcao      = $_GET["funcao"];
    $idUsuario   = $_GET["codigo"];

    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idUsuario = proxIdUsuario();

        //INSERT
        $sql = "INSERT INTO usuarios (idUsuario,idTipoUsuario,Nome,Login,Senha,FlgAtivo) "
                ." VALUES (".$idUsuario.","
                .$tipoUsuario.","
                ."'$nome',"
                ."'$login',"
                ."md5('$senha'),"
                ."'$ativo');";

    }elseif($funcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE usuarios "
                ." SET idTipoUsuario = $tipoUsuario, "
                    ." Nome = '$nome', "
                    ." Login = '$login', "
                    .$setSenha 
                    ." FlgAtivo = '$ativo' "
                ." WHERE idUsuario = $idUsuario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuarios "
                ." WHERE idUsuario = $idUsuario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['Foto']['tmp_name'] != ""){

     
        $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Foto']['name']).'.'.$extensao;        
        
        
        if(is_dir('../dist/img/')){
            //Existe
            $diretorio = '../dist/img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuario "
                ." SET Foto = '$dirImagem' "
                ." WHERE id_usuario = $idUsuario;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../usuarios.php");

?>
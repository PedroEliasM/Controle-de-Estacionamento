<?php

    include('funcoes.php');

    $tipoUsuario = $_POST["nTipoUsuario"];
    $nome        = $_POST["nNome"];
    $email       = $_POST["nEmail"];
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
        $sql = "INSERT INTO usuario (id_usuario,fk_id_tipo_usuario,nome,email,senha,flg_ativo) 
                VALUES ($idUsuario,$tipoUsuario,'$nome','$email',md5('$senha'),('$ativo');";

    }elseif($funcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " senha = md5('$senha'), ";
        }

        $sql = "UPDATE usuario 
                SET fk_id_tipo_usuario = $tipoUsuario, 
                    nome = '$nome', 
                    email = '$email', 
                    $setSenha 
                    flg_ativo = '$ativo' 
                    WHERE idUsuario = $idUsuario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuario 
                WHERE id_usuario = $idUsuario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['Foto']['tmp_name'] != ""){

        //Usar o mesmo nome do arquivo original
        //$nomeArq = $_FILES['Foto']['name'];
        //...
        //OU
        //Pega a extensão do arquivo e cria um novo nome pra ele (MD5 do nome original)
        $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Foto']['name']).'.'.$extensao;        
        
        //Verificar se o diretório existe, ou criar a pasta
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
        $sql = "UPDATE usuario 
                SET foto = '$dirImagem 
                WHERE id_usuario = $idUsuario;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../usuarios.php");

?>
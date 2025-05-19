<?php

    include("conexao.php");
    include('funcoes.php');

    $tipoUsuario = $_POST["nTipoUsuario"];
    $nome        = $_POST["nNome"];
    $email       = $_POST["nEmail"];
    $senha       = $_POST["nSenha"];
    $funcao      = $_GET["funcao"];
    $idUsuario   = $_GET["codigo"];

    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    //Foto do perfil
    $diretorioImg = '';
    
    if (!empty($_FILES['nFoto']['tmp_name'])) {

        //Pega extensão e monta o novo nome do arquivo
        $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
        $novo_nome = "foto-" . $idUsuario . '.' . $ext;

        //Verifica se existe o diretório (ou cria)
        $diretorio = '../dist/img/usuarios/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        //Grava o arquivo no diretório
        $caminho_completo = $diretorio . $novo_nome;
        if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
            //Salva o diretório para colocar na tabela do BD
            $diretorioImg = 'dist/img/usuarios/' . $novo_nome;

            //Gravação no BD
            $sql = "UPDATE usuario
                    SET foto = '$diretorioImg'
                    WHERE id_usuario = $idUsuario";
            if (!mysqli_query($conn, $sql)) {
                die("Erro ao atualizar foto: " . mysqli_error($conn));
            }
            
            // Atualiza a sessão com o novo caminho da foto
            $_SESSION['FotoLogin'] = $diretorioImg;
        }
    }
    // /.foto

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
                    WHERE id_usuario = $idUsuario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuario 
                WHERE id_usuario = $idUsuario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../usuarios.php");

?>
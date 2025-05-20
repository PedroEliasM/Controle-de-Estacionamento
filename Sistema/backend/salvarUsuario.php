<?php

    include("conexao.php");
    include('funcoes.php');

    $tipoUsuario    = $_POST["nTipoUsuario"];
    $nome           = $_POST["nNome"];
    $email          = $_POST["nEmail"];
    $senha          = $_POST["nSenha"];
    $funcao         = $_GET["funcao"];
    $idUsuario      = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $ativo          = isset($_POST["nAtivo"]) ? $_POST["nAtivo"] : null;
    $idEmpresa      = $_SESSION['idEmpresa'];
    $ativo          = isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on" ? "S" : "N";

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idUsuario = proxIdUsuario();

        // Armazenar a foto do Usuário
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
                
            }
        }
        // /.foto

        // Armazena o caminho da foto
        $foto = $diretorioImg;

        //INSERT
        $sql = "INSERT INTO usuario (id_usuario,fk_id_tipo_usuario,nome,email,senha,foto,flg_ativo,fk_id_empresa) 
                VALUES ($idUsuario,$tipoUsuario,'$nome','$email',md5('$senha'),'$foto','$ativo','$idEmpresa');";

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

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuario 
                WHERE id_usuario = $idUsuario;";
    }
    // Atualiza a sessão com o novo valor
    $_SESSION['NomeLogin'] = $nome;
    $_SESSION['EmailLogin'] = $email;

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../usuarios.php");

?>
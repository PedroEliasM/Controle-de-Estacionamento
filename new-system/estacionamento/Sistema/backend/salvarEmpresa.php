<?php

    include('funcoes.php');

    $nome           = $_POST["nNome"];
    $cnpj           = $_POST["nCNPJ"];
    $telefone       = $_POST["nTelefone"];
    $cep            = $_POST["nCEP"];
    $endereco       = $_POST["nEndereco"];
    $numero         = $_POST["nNumero"];
    $complemento    = $_POST["nComplemento"];
    $bairro         = $_POST["nBairro"];
    $cidade         = $_POST["nCidade"];
    $uf             = $_POST["nUF"];
    $funcao         = $_GET["funcao"];
    $idEmpresa      = $_GET["codigo"];

    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idEmpresa = proxIdEmpresa();

        //INSERT
        $sql = "INSERT INTO empresa (id_empresa,nome,cnpj,telefone,cep,endereco,numero,complemento,bairro,cidade,uf,flg_ativo) 
                VALUES ($idEmpresa,'$nome','$cnpj','$telefone','$cep','$endereco',
                        '$numero','$complemento','$bairro','$cidade','$uf',('$ativo');";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE empresa 
                SET nome        = $nome, 
                    cnpj        = '$cnpj', 
                    telefone    = '$telefone', 
                    cep         = '$cep', 
                    endereco    = '$endereco', 
                    numero      = '$numero', 
                    complemento = '$complemento', 
                    bairro      = '$bairro', 
                    cidade      = '$cidade', 
                    uf          = '$uf', 
                    flg_ativo = '$ativo' 
                    WHERE id_empresa = $idEmpresa;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM empresa 
                WHERE id_empresa = $idEmpresa;";
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
        if(is_dir('../dist/img/empresas/')){
            //Existe
            $diretorio = '../dist/img/empresas/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/empresas/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/empresas/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuario 
                SET foto = '$dirImagem 
                WHERE id_usuario = $idEmpresa;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../usuarios.php");

?>
<?php

    include('funcoes.php');

    $razao_social        = $_POST["nRazao"];
    $nome_fantasia        = $_POST["nNomeFantasia"];
    $cnpj       = $_POST["nCNPJ"];
    $logo      = $_FILES["nLogo"];
    $cidade       = $_POST["nCidade"];
    $uf       = $_POST["nUF"];
    $cep       = $_POST["nCEP"];
    $endereco       = $_POST["nEndereco"];
    $numero       = $_POST["nNumero"];
    $complemento       = $_POST["nComplemento"];
    $bairro       = $_POST["nBairro"];
    $ativo       = $_POST["nAtivo"];
    $funcao      = $_GET["funcao"];
    $idFornecedor   = $_GET["codigo"];

    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idFornecedor = proxIdFornecedor();

        //INSERT
        $sql = "INSERT INTO fornecedor (id_fornecedor,razao_social,nome_fantasia,cnpj,logo,endereco,numero,complemento,
        bairro,cidade,uf,cep,flg_ativo) "
                ." VALUES (".$idFornecedor.","
                ."'$razao_social',"
                ."'$nome_fantasia',"
                ."'$cnpj',"
                ."'$logo',"
                ."'$endereco',"
                ."'$numero',"
                ."'$complemento',"
                ."'$bairro',"
                ."'$cidade',"
                ."'$uf',"
                ."'$cep',"
                ."'$ativo');";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE fornecedor "
                ." SET nome_fantasia = '$nome_fantasia', "
                    ." cnpj = '$cnpj', "
                    ." cidade = '$cidade', "
                    ." uf = '$uf', "
                    ." flg_ativo = '$ativo' "
                ." WHERE id_fornecedor = $idFornecedor;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM fornecedor "
                ." WHERE id_fornecedor = $idFornecedor;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['Logo']['tmp_name'] != ""){

        //Usar o mesmo nome do arquivo original
        //$nomeArq = $_FILES['Logo']['name'];
        //...
        //OU
        //Pega a extensão do arquivo e cria um novo nome pra ele (MD5 do nome original)
        $extensao = pathinfo($_FILES['Logo']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Logo']['name']).'.'.$extensao;        
        
        //Verificar se o diretório existe, ou criar a pasta
        if(is_dir('../dist/img/')){
            //Existe
            $diretorio = '../dist/img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Logo']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE fornecedor "
                ." SET Logo = '$dirImagem' "
                ." WHERE id_fornecedor = $idFornecedor;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../fornecedores.php");

?>
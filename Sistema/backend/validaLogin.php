<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include("funcoes.php");

    $_SESSION['logado'] = 0;

    $email = stripslashes($_POST["nEmail"]);
    $senha = stripslashes($_POST["nSenha"]);

    //$_POST - Valor enviado pelo FORM através da propriedade NAME do elemento HTML 
    //$_GET - Valor enviado pelo FORM através da URL
    //$_SESSION - Variável criada pelo usuário no PHP

    include("conexao.php");
    $sql = "SELECT 	usu.*, 
		            emp.nome as nome_empresa,
                    emp.foto as foto_empresa,
                    tip.descricao as descricao_tipo_usuario
            FROM usuario AS usu
            INNER JOIN empresa AS emp ON usu.fk_id_empresa = emp.id_empresa
            INNER JOIN tipo_usuario AS tip ON usu.fk_id_tipo_usuario = tip.id_tipo_usuario
            WHERE usu.email = '$email' 
            AND usu.senha = md5('$senha');";
    $resultLogin = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($resultLogin) > 0) {  
        
        //enviarEmail('destino@email.com.br','Mensagem de e-mail para SA','Teste SA','Eu mesmo');

        foreach ($resultLogin as $coluna) {
                        
            //***Verificar os dados da consulta SQL
            $_SESSION['idTipoUsuario']  = $coluna['fk_id_tipo_usuario'];
            $_SESSION['DescricaoTipoUsuario']  = $coluna['descricao_tipo_usuario'];
            $_SESSION['logado']         = 1;
            $_SESSION['idLogin']        = $coluna['id_usuario'];
            $_SESSION['NomeLogin']      = $coluna['nome'];
            $_SESSION['EmailLogin']     = $coluna['email'];
            $_SESSION['FotoLogin']      = $coluna['foto'];
            $_SESSION['AtivoLogin']     = $coluna['flg_ativo'];
            $_SESSION['idEmpresa']      = $coluna['fk_id_empresa'];
            $_SESSION['NomeEmpresa']      = $coluna['nome_empresa'];
            $_SESSION['FotoEmpresa']      = $coluna['foto_empresa'];

            //Acessar a tela inicial
            header('location: ../painel.php');
            
        }        
    }else{
        //Acessar a tela inicial
        header('location: ../../');
    } 

    

?>
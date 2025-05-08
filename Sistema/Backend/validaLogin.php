<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include("funcoes.php");

    $_SESSION['logado'] = 0;

    $email = stripslashes($_POST["email"]);
    $senha = stripslashes($_POST["senha"]);

    //$_POST - Valor enviado pelo FORM através da propriedade NAME do elemento HTML 
    //$_GET - Valor enviado pelo FORM através da URL
    //$_SESSION - Variável criada pelo usuário no PHP

    include("conexao.php");
    $sql = "SELECT * FROM usuario
            WHERE email = '$email'
            AND senha = md5('$senha');";
    $resultLogin = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($resultLogin) > 0) {  
        foreach ($resultLogin as $coluna) {
                        
            //***Verificar os dados da consulta SQL
            $_SESSION['idUsuario']       = $coluna['id_usuario'];
            //$_SESSION['logado']        = 1;

            //Acessar a tela inicial
            header('location: ../Frontend/painel-adm-vagas.php');
            
        }        
    }else{
        //Acessar a tela inicial
        header('location: ../../index.php');
    } 

    

?>
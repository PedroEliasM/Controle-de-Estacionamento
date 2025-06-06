<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include('funcoes.php');

    //Filtros de tela
    $movimentacao   = $_POST["nMovimentacao"];
    $maxima = $_POST["hMax"];
    $minima = $_POST["hMin"];

    //Campos para WHERE
    $whereDescricao   = '';
    $whereIdEmpresa = '';
    
    //Sessões para retorno
    $_SESSION['relatMovi']      = '';
    $_SESSION['relatVagasDescr'] = '';
    $_SESSION['relatVagasIdEmpr'] = '';
   
    //Validar filtros
    if($movimentacao != '') {
        $whereMovimentacao = " AND mv.tipo LIKE '%".$movimentacao."%' ";
    }

    if($minima != '') {
        $whereMinima = " AND mv.tipo LIKE .$minima. ";
    }
     
    include("conexao.php");

    $sql = "SELECT vg.id_vaga, "
            ." vg.descricao AS Descrição, "
            ." mv.tipo AS Tipo, "
            ." mv.data AS Data, "
            ." vg.id_vaga "
        ." FROM movimentacao mv"
        ." INNER JOIN vaga vg "
        ." ON vg.id_vaga = mv.fk_id_vaga " 
        ." WHERE 1 = 1 "

        .$whereMovimentacao
        .";";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {        
        
        foreach ($result as $coluna) {

            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td>'.$coluna["id_vaga"].'</td>'
                .'<td>'.$coluna["Descrição"].'</td>'
                .'<td>'.$coluna["Tipo"].'</td>'
                .'<td>'.$coluna["Data"].'</td>'
            .'</tr>';                       
        }    
    }
    
    $_SESSION['relatMovi']      = $lista;
    $_SESSION['relatVagasDescr'] = $descricao;
    $_SESSION['relatVagasIdEmpr'] = $idEmpresa;

    header("location: ../relatorio-movimentacao.php"); 
?>
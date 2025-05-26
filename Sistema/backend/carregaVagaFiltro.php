<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   

    //Funções e conexão por PDO
    include('funcoes.php');
    require_once('conexaoPDO.php');

    //Pega o id enviado por GET na URL
    $idCategoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    
    if (! empty($idCategoria)){
        //Monta a lista no banco
        echo getProdutoCategoria($idCategoria);
    }

    //Função para montar a lista filtrada
    function getProdutoCategoria($idCat){
        //Conexão PDO
        $pdo = Conectar();

        //Consulta SQL
        $sql = "SELECT idProduto, "
					." Descricao "
			." FROM produto "
			." WHERE idCategoria = ".$idCat
			." ORDER BY Descricao;";

        //Executar por PDO
        $stm = $pdo->prepare($sql);
        $stm->execute();

        //sleep(1);
        //Converte o resultado em JSON antes de retornar para a página
        echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));        
        
        //Encerra a conexão PDO
        $pdo = null;
    }

?>
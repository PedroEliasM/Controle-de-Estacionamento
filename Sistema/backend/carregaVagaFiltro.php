<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   

    //Funções e conexão por PDO
    include('funcoes.php');
    require_once('conexaoPDO.php');

    //Pega o id enviado por GET na URL
    $idSituacao = isset($_GET['situacao']) ? $_GET['situacao'] : '';
    
    if (! empty($idSituacao)){
        //Monta a lista no banco
        echo getVagaSituacao($idSituacao);
    }

    //Função para montar a lista filtrada
    function getVagaSituacao($idSit){
        //Conexão PDO
        $pdo = Conectar();

        //Consulta SQL
        $sql = "SELECT id_vaga, descricao 
			    FROM vaga 
			    WHERE id_vaga = $idSit
			    ORDER BY descricao;";

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
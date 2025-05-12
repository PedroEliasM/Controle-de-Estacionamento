<?php
    include("funcaoMenu.php");
    include("funcaoVaga.php");

    function descrFlag($flag) {
        if($flag == 'S') {
            return 'Sim';
        } else {
            return 'Não';
        }
    }
    function nomeEmpresa($idVaga){
        include("conexao.php");
        $sql = "SELECT em.nome
        from empresa em
        inner join vaga vg
        on em.id_empresa = vg.fk_id_empresa
        WHERE id_vaga = $idVaga;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){

            }
        }
        return $campo;
    }
    
?>
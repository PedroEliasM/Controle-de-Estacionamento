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
    function nomeEmpresa(){
        
        include("conexao.php");
        $sql = "SELECT em.nome, vg.fk_id_empresa
        from empresa  em
        inner join vaga  vg
        on em.id_empresa = vg.fk_id_empresa;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(mysqli_num_rows($result) > 0){
            foreach($result as $campo){
            
            }
        }
        return $campo;
    }
?>
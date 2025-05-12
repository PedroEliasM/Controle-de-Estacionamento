<?php
include("modalVaga.php");

include("../Backend/funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Vagas</title>
    <meta charset="utf-8">

    <style>
            body{
                font-family: Arial, sans-serif;
                background-color: lightgray;
                display: block;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            h4, th, td{
                color: black;
            }
            #iButton{
                color: lightgray;
                background-color: blue;
                margin-top: 5px;
                padding: 5px;
                border-radius: 5px;
            }
    </style>
  </head>
  <body>
            

    <h1>tela de vagas</h1>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Situação</ths>
            <th>Empresa</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
            
        <?php echo listaVagas(); ?>
            
    </table>

    
    <button id="iButton" onclick=openModal()>Adicionar vaga</button>
  </body>
</html>
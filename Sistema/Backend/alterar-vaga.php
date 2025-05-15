<?php


    include("funcoes.php");

    // Buscar os dados do usuário do ID recebido por GET
    $usuario = buscaVagaId($_GET['id']);

    //echo $usuario['nome'];
    //die();

    $flagAtivo = '';
    if($usuario['flg_ativo'] == 'S') {
        $flagAtivo = 'checked';
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Vagas</title>
    <meta charset="utf-8">
    <style>
      button{
        background-color: blue;
        border:1px;
        height:30px;
      }
      .modal-overlay {
      display: none; /* Inicialmente oculta */
      position: fixed; /* Fica fixo na tela */
      z-index: 1; /* Garante que esteja por cima */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7); /* Fundo escuro translúcido */
      }

      .modal-content {
      background-color: #fefefe; /* Cor do fundo da modal */
      margin: 15% auto; /* Posiciona no centro da tela */
      padding: 20px;
      border: 1px solid #888;
      width: 450px; /* Largura da modal */
      height:300px;
      }

      .close-button {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      }

    .close-button:hover {
      color: black;
    }
    </style>
  </head>

<body>
    <!-- Modal Adicionar Vaga -->
  <div class="modal-overlay" id="Modal2">
    <div class="modal-content">
      <span class="close-button" onclick=closeModal2()>&times;</span>
      <h2>as Vaga</h2>

      <form method="POST" action="../Backend/salvarVaga.php?funcao=I&id=0" enctype="multipart/form-data">
        <p>
          <label for="iDescricao">Descrição:</label>
          <input type="text" class="form-control" id="iDescricao" name="nDescricao" maxlength="50">
        </p>
        <p>
          <label for="iSituacao">Situação:</label>
          <input type="text" class="form-control" id="iSituacao" name="nSituacao" maxlength="50">
        </p>
        <p>
                <input type="checkbox" name="nAtivo" id="iAtivo">
                <label for="iAtivo">Usuário Ativo</label>
        </p>
        <p>
          <label for="iEmpresa">Empresa:</label>
          <select name="nEmpresa" id="iEmpresa" required>
            <option value="">Selecione...</option>
            <?php echo optionEmpresa(0);?>
          </select>
        </p>
        <button onclick=openModal2()>Salvar</button>
      </form>

    </div>
    
  </div>
  <!--Fim Modal Alterar Vaga -->
  <script>
    function openModal2() {
    document.getElementById("Modal2").style.display = "block";
    }

  function closeModal2() {
    document.getElementById("Modal2").style.display = "none";
    }
  </script>


</body>
</html>
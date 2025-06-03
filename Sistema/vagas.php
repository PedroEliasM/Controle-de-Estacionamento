<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParkWay - Vagas</title>

    <!-- CSS -->
    <?php include('partes/css.php'); ?>
    <!-- Fim CSS -->

  </head>
  <body class="hold-transition sidebar-mini layout-fixed pagina-vagas">
    <div class="wrapper">

      <!-- Navbar -->
      <?php include('partes/navbar.php'); ?>
      <!-- Fim Navbar -->

      <!-- Sidebar -->
      <?php 
        $_SESSION['menu-n1'] = 'administrador';
        $_SESSION['menu-n2'] = 'vagas';
        include('partes/sidebar.php'); 
      ?>
      <!-- Fim Sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <!-- Espaço -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="row">
                      
                      <div class="col-6">
                        <h3 class="card-title">Vagas</h3>
                      </div>
                      
                      <div class="col-6" align="right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testeAjaxModal">
                          Filtrar Vagas
                        </button>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novaVagaModal">
                          Nova Vaga
                        </button>
                      </div>

                    </div>
                  </div>

                  

                  <!-- /.card-header -->
                  <div class="card-body vagas-container">
                      <div class="row">

                          <?php echo listaVagas(); ?>

                      </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->

          <div class="modal fade" id="novaVagaModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h4 class="modal-title">Nova Vaga</h4>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="backend/salvarVaga.php?funcao=I" enctype="multipart/form-data">              
                    
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="iDescricao">Descrição:</label>
                          <input type="text" class="form-control" id="iDescricao" name="nDescricao" maxlength="7" required>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="iSituacao">Situação:</label>
                          <select name="nSituacao" id="iSituacao" class="form-control" required>
                            <option value="">Selecione...</option>
                            <option value="L">Livre</option>
                            <option value="O">Ocupada</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-8">
                        <div class="form-group">
                          <label for="iEmpresa">Empresa:</label>
                          <select name="nEmpresa" id="iEmpresa" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php echo optionEmpresa();?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <input type="checkbox" id="iAtivo" name="nAtivo">
                          <label for="iAtivo">Vaga Ativa</label>
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    
                  </form>

                </div>
                
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <div class="modal fade" id="testeAjaxModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h4 class="modal-title">Teste Ajax</h4>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="#" enctype="multipart/form-data">              
                    
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <label for="iCategoriaAjax">Filtrar por:</label>
                          <select name="nCategoriaAjax" id="iCategoriaAjax" class="form-control" required>
                            <option value="">Selecione...</option>
                            <option value="L">Vagas Livres</option>
                            <option value="O">Vagas Ocupadas</option>
                            <option value="N">Vagas Inativas</option>
                          </select>
                        </div>
                      </div>


                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-success">Filtrar</button>
                    </div>
                    
                  </form>

                  </div>
                  
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal fade -->

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
          
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- JS -->
    <?php include('partes/js.php'); ?>
    <!-- Fim JS -->

    <script>
      //== Inicialização
      $(document).ready(function() {

        //Lista dinâmica com Ajax
        $('#iCategoriaAjax').on('change',function(){
          //Pega o valor selecionado na lista 1
          var categoria  = $('#iCategoriaAjax').val();
          
          //Prepara a lista 2 filtrada
          var optionProd = '';
                    
          //Valida se teve seleção na lista 1
          if(categoria != "" && categoria != "0"){
            
            //Vai no PHP consultar dados para a lista 2
            $.getJSON('backend/carregaProdutoCategoria.php?categoria='+categoria,
            function (dados){  
              
              //Carrega a primeira option
              optionProd = '<option value="">Filtrar Vagas por</option>';                  
              
              //Valida o retorno do PHP para montar a lista 2
              if (dados.length > 0){                        
                
                //Se tem dados, monta a lista 2
                $.each(dados, function(i, obj){
                  optionProd += '<option value="'+obj.idProduto+'">'+obj.Descricao+'</option>';	                            
                })

                //Marca a lista 2 como required e mostra os dados filtrados
                $('#iProdutoAjax').attr("required", "req");						
                $('#iProdutoAjax').html(optionProd).show();
              }else{
                
                //Não encontrou itens para a lista 2
                optionProd += '<option value="">Selecione um Produto</option>';
                $('#iProdutoAjax').html(optionProd).show();
              }
            })                
          }else{
            //Sem seleção na lista 1 não consulta
            optionProd += '<option value="">Selecione um Produto</option>';
            $('#iProdutoAjax').html(optionProd).show();
          }			
        });
      
      });
    </script>

  </body>
</html>
<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Produtos</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
                    <h3 class="card-title">Produtos</h3>
                  </div>
                  
                  <div class="col-6" align="right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testeAjaxModal">
                      Teste Ajax
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoProdutoModal">
                      Novo Produto
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Produto</th>
                      <th>Categoria</th>
                      <th>Quantidade</th>               
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaProduto(); ?>
                  
                  </tbody>
                  
                </table>
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

      <div class="modal fade" id="novoProdutoModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Novo Produto</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="backend/salvarProduto.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="iDescricao">Descrição:</label>
                      <input type="text" class="form-control" id="iDescricao" name="nDescricao" maxlength="80">
                    </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                      <label for="iCategoria">Categoria:</label>
                      <select name="nCategoria" id="iCategoria" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionCategoria();?>
                      </select>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="iQuantidade">Quantidade:</label>
                      <input type="number" class="form-control" id="iQuantidade" name="nQuantidade" min="0">
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
                      <label for="iCategoriaAjax">Categoria:</label>
                      <select name="nCategoriaAjax" id="iCategoriaAjax" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionCategoria();?>
                      </select>
                    </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                      <label for="iProdutoAjax">Produtos:</label>
                      <select name="nProdutoAjax" id="iProdutoAjax" class="form-control" required>
                        <option value="">Selecione...</option>
                      </select>
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

    </section>
    <!-- /.content -->
  </div>

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
          optionProd = '<option value="">Selecione um Produto</option>';                  
          
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

  $(function() {
    $('#tabela').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

</script>

</body>
</html>

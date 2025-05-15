 <?php 
  session_start();
  include('php/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Fornecedores</title>

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
    $_SESSION['menu-n2'] = 'fornecedores';
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
                  
                  <div class="col-9">
                    <h3 class="card-title">Fornecedores</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoFornecedorModal">
                      Novo Fornecedor
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
                      <th>Nome Fantasia</th>
                      <th>CNPJ</th>                              
                      <th>Cidade</th>                
                      <th>UF</th>                
                      <th>Ativo</th>
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaFornecedor(); ?>
                  
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

      <div class="modal fade" id="novoFornecedorModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Novo Fornecedor</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarFornecedor.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label for="iRazao">Razão Social:</label>
                      <input type="text" class="form-control" id="iRazao" name="nRazao" maxlength="80">
                    </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                      <label for="iNomeFantasia">Nome Fantasia:</label>
                      <input type="text" class="form-control" id="iNomeFantasia" name="nNomeFantasia" maxlength="50">
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="iCNPJ">CNPJ:</label>
                      <input type="text" class="form-control" id="iCNPJ" name="nCNPJ" maxlength="20">
                    </div>
                  </div>
                
                  <div class="col-12">
                    <div class="form-group">
                      <label for="iLogo">Logo:</label>
                      <input type="file" class="form-control" id="iLogo" name="nLogo" accept="image/*">
                    </div>
                  </div>
                
                  <div class="col-12">
                    <div class="form-group">
                      <input type="checkbox" id="iAtivo" name="nAtivo">
                      <label for="iAtivo">Fornecedor Ativo</label>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label>CEP</label>
                      <input required name="CEP" type="text" class="form-control cep">
                    </div>
                  </div>
                  
                  <div class="col-9">
                    <div class="form-group">
                      <label>Endereço</label>
                      <input required name="nEndereco" type="text" class="form-control">
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label>Número</label>
                      <input required name="nNumero" type="text" maxlength="8" class="form-control">
                    </div>
                  </div>

                  <div class="col-9">
                    <div class="form-group">
                      <label>Complemento</label>
                      <input name="nComplemento" type="text" maxlength="50" class="form-control">
                    </div>
                  </div>

                  <div class="col-5">
                    <div class="form-group">
                      <label>Bairro</label>
                      <input name="nBairro" type="text" class="form-control">
                    </div>
                  </div>
                  
                  <div class="col-5">
                    <div class="form-group">
                      <label for="iCidade">Cidade</label>
                      <input required id="iCidade" name="nCidade" type="text" class="form-control">
                    </div>
                  </div>

                  <div class="col-2">
                    <div class="form-group">
                      <label for="iUF">UF</label>
                      <input required id="iUF" name="nUF" type="text" class="form-control">
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
  $(function () {
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

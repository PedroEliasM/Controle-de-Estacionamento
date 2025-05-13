<?php 
  session_start();
  include('funcoes.php');
  include('conexao.php');

  $_SESSION['menu-n1'] = 'administrador';
  $_SESSION['menu-n2'] = 'usuarios'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Usuários</title>

  <?php include('partes/css.php'); ?> <!-- Certifique-se de ter esse include -->
</head>
<body>

<div class="content-wrapper">
  <div class="content-header">
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-9">
                  <h3 class="card-title">Usuários</h3>
                </div>
                <div class="col-3 text-right">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoUsuarioModal">
                    Novo Usuário
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body">
              <table id="tabela" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tipo de Usuário</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo listaUsuario(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Novo Usuário -->
    <div class="modal fade" id="novoUsuarioModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h4 class="modal-title">Novo Usuário</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form method="POST" action="php/salvar_usuario.php?funcao=I" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                    <label for="iNome">Nome:</label>
                    <input type="text" class="form-control" id="iNome" name="nNome" required>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="iTipoUsuario">Tipo de Usuário:</label>
                    <select name="nTipoUsuario" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo optionTipoUsuario(); ?>
                    </select>
                  </div>
                </div>

                <div class="col-8">
                  <div class="form-group">
                    <label for="iLogin">Login:</label>
                    <input type="email" class="form-control" id="iLogin" name="nLogin" required>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="iSenha">Senha:</label>
                    <input type="password" class="form-control" id="iSenha" name="nSenha" required>
                  </div>
                </div>

                <div class="col-8">
                  <div class="form-group">
                    <label for="iEmpresa">Empresa:</label>
                    <input type="text" class="form-control" id="iEmpresa" name="nEmpresa" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="iFoto">Foto:</label>
                    <input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">
                  </div>
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
    </div>
    <!-- Fim Modal -->

  </section>
</div>

<!-- Sidebar opcional -->
<aside class="control-sidebar control-sidebar-dark">
</aside>

<?php include('partes/js.php'); ?> <!-- Certifique-se de que esse arquivo inclui jQuery, Bootstrap, DataTables -->

<script>
  $(function () {
    $('#tabela').DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true
    });
  });
</script>

</body>
</html>,


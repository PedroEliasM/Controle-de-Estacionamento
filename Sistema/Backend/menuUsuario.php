<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Perfil de Usuário</title>
        <link rel="stylesheet" type="text/css" href="css/style-menuUsuario.css">
    </head>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  
                  <div class="col-12">
                    <h3 class="card-title">Meu Perfil</h3>
                  </div>

                </div>
              </div>

                <div class="card-body">

                <form method="POST" action="php/salvaPerfil.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">	
                                
                                <div class="col-12">
                                    <div class="row">	
                                
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3 text-center">
                                                    <div class="foto-perfil mx-auto">
                                                        <img alt="<?php echo $_SESSION['NomeLogin'];?>" src="img/logo.png" class="foto">
                                                        <div class="trocar-imagem">
                                                            <i class="fas fa-camera upload-button"></i>
                                                            <p>Alterar Foto</p>
                                                            <input class="arquivo" name="Foto" type="file" title="" accept="image/*"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <div class="form-group">
                                                                <label for="iNome">Nome</label>
                                                                <input name="nNome" id="iNome" type="text" class="form-control" value=" Nome" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="form-group">
                                                                <label>Senha</label>
                                                                <input name="nSenha" id="iSenha" type="text" class="form-control" value=" Senha " required>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input readonly name="nEmail" id="iEmail" type="email" class="form-control" value=" Email " required>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label>Empresa</label>
                                                                <input readonly name="nEmpresa" id="iEmpresa" type="text" class="form-control" value=" Empresa " required>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label>Tipo de Usuário</label>
                                                                <input readonly name="nTipo" id="iTipo" type="text" class="form-control" value=" Tipo do Usuário " required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action" align="right">
                            <a href="menuUsuario.php" class="btn btn-danger" data-toggle="tooltip" title="Limpar Alterações">
                                <span>Limpar</span>
                            </a>
                            <input type="submit" class="btn btn-success" value="Salvar" data-toggle="tooltip" title="Salvar Alterações">
                        </div>
                        </div>
                </form>
                </div>
            
    </body>
</html>
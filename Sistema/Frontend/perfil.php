<!--<div class="container-fluid">-->
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

                    <form method="POST" action="../Backend/salvar_perfil.php?funcao=I" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3 text-center">
                                                    <div class="foto-perfil mx-auto">
                                                        <img alt="<?php echo $_SESSION['NomeLogin']; ?>" src="<?php echo $_SESSION['FotoLogin']; ?>" class="foto" name="nFoto">
                                                        <div class="trocar-imagem">
                                                            <i class="fas fa-camera upload-button"></i>
                                                            <p>Alterar Foto</p>
                                                            <input class="arquivo" name="nFoto" type="file" title=""
                                                                accept="image/*" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <div class="form-group">
                                                                <label for="iNome">Nome</label>
                                                                <input name="nNome" id="iNome" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $_SESSION['NomeLogin']; ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="form-group position-relative">
                                                                <label>Senha</label>
                                                                <input name="nSenha" id="iSenha" type="password"
                                                                    class="form-control"
                                                                    value="<?php // echo $_SESSION['SenhaLogin']; ?>"
                                                                    required>
                                                                <i class="fas fa-eye-slash toggle-password"
                                                                    style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.querySelector('.toggle-password').addEventListener('click', function () {
                                                                const passwordInput = document.getElementById('iSenha');
                                                                const icon = this;
                                                                if (passwordInput.type === 'password') {
                                                                    passwordInput.type = 'text';
                                                                    icon.classList.remove('fa-eye-slash');
                                                                    icon.classList.add('fa-eye');
                                                                } else {
                                                                    passwordInput.type = 'password';
                                                                    icon.classList.remove('fa-eye');
                                                                    icon.classList.add('fa-eye-slash');
                                                                }
                                                            });
                                                        </script>
                                                        <div class="col-7">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input readonly name="nEmail" id="iEmail" type="email"
                                                                    class="form-control"
                                                                    value="<?php echo $_SESSION['EmailLogin']; ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label>Empresa</label>
                                                                <input readonly name="nEmpresa" id="iEmpresa"
                                                                    type="text" class="form-control"
                                                                    value="<?php echo $_SESSION['Empresa']; ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label>Tipo de Usuário</label>
                                                                <input readonly name="nTipo" id="iTipo" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $_SESSION['Tipo_Usuario']; ?>"
                                                                    required>
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
                            <a href="painel-perfil.php" class="btn btn-danger" data-toggle="tooltip"
                                title="Limpar Alterações">
                                <span>Limpar</span>
                            </a>
                            <input type="submit" class="btn btn-success" value="Salvar" data-toggle="tooltip"
                                title="Salvar Alterações">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->
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

    <?php include('partes/css.php'); ?>
    <link rel="stylesheet" href="css/custom.css"> 
    </head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include('partes/navbar.php'); ?>
    <?php
    $_SESSION['menu-n1'] = 'administrador';
    $_SESSION['menu-n2'] = 'vagas';
    include('partes/sidebar.php');
    ?>
    <div class="content-wrapper">
        <div class="content-header">
            </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                                        <h3 class="card-title">Vagas</h3>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                                        <div class="input-group">
                                            <input type="text" id="searchVagaInput" class="form-control" placeholder="Pesquisar vaga...">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="clearSearch"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 text-md-right">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novaVagaModal">
                                            <i class="fas fa-plus"></i> Nova Vaga
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="vagas-container row d-flex flex-wrap">
                                    <?php echo listaVagas(); ?>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <label for="iDescricao">Nome da Vaga:</label>
                                            <input required type="text" class="form-control" id="iDescricao" name="nDescricao" maxlength="80" placeholder="Ex: A1, B2, Vaga Visitante">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="iSituacao">Situação:</label>
                                            <select name="nSituacao" id="iSituacao" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <option value="Livre">Livre</option>
                                                <option value="Ocupada">Ocupada</option>
                                                <option value="Manutenção">Manutenção</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="iEmpresa">Empresa Associada:</label>
                                            <select name="nEmpresa" id="iEmpresa" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <?php echo optionEmpresa();?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="iAtivo" name="nAtivo" checked>
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
                    </div>
                </div>
            <div class="modal fade" id="vagaDetailsModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title" id="vagaDetailsTitle">Detalhes da Vaga: <span id="vagaDetailsName"></span></h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID:</strong> <span id="vagaDetailsId"></span></p>
                            <p><strong>Descrição:</strong> <span id="vagaDetailsDescricao"></span></p>
                            <p><strong>Situação:</strong> <span id="vagaDetailsSituacao"></span></p>
                            <p><strong>Empresa:</strong> <span id="vagaDetailsEmpresa"></span></p>
                            <p><strong>Ativa:</strong> <span id="vagaDetailsAtivo"></span></p>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editVagaModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h4 class="modal-title">Editar Vaga</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editVagaForm" method="POST" action="backend/salvarVaga.php?funcao=A" enctype="multipart/form-data">
                                <input type="hidden" id="editVagaId" name="codigo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="editDescricao">Nome da Vaga:</label>
                                            <input required type="text" class="form-control" id="editDescricao" name="nDescricao" maxlength="80">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="editSituacao">Situação:</label>
                                            <select name="nSituacao" id="editSituacao" class="form-control" required>
                                                <option value="Livre">Livre</option>
                                                <option value="Ocupada">Ocupada</option>
                                                <option value="Manutenção">Manutenção</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="editEmpresa">Empresa Associada:</label>
                                            <select name="nEmpresa" id="editEmpresa" class="form-control" required>
                                                <?php echo optionEmpresa();?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="editAtivo" name="nAtivo">
                                            <label for="editAtivo">Vaga Ativa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteVagaModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h4 class="modal-title">Confirmar Exclusão</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja excluir a vaga: <strong id="deleteVagaName"></strong> (ID: <span id="deleteVagaIdConfirm"></span>)?</p>
                            <small class="text-danger">Esta ação não pode ser desfeita.</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <a href="#" id="confirmDeleteVagaBtn" class="btn btn-danger">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        </div>

    <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
<?php include('partes/js.php'); ?>

<script>
    $(document).ready(function() {
        // Evento de clique no widget da vaga para abrir o modal de detalhes
        $('.vagas-container').on('click', '.vaga-widget-clickable', function() {
            const vagaId = $(this).data('id');
            
            // Requisição AJAX para buscar os detalhes da vaga
            $.ajax({
                url: 'backend/getVagaDetails.php', // Novo arquivo para buscar detalhes
                type: 'GET',
                data: { id: vagaId },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#vagaDetailsId').text(data.id_vaga);
                        $('#vagaDetailsName').text(data.descricao);
                        $('#vagaDetailsDescricao').text(data.descricao);
                        $('#vagaDetailsSituacao').text(data.situacao);
                        $('#vagaDetailsEmpresa').text(data.nome_empresa); // Assume que o backend retorna o nome da empresa
                        $('#vagaDetailsAtivo').text(data.flg_ativo === 'S' ? 'Sim' : 'Não');
                        $('#vagaDetailsModal').modal('show');
                    } else {
                        // Implementar um modal de erro ou mensagem para o usuário
                        console.error('Detalhes da vaga não encontrados.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar detalhes da vaga:', error);
                    // Implementar um modal de erro ou mensagem para o usuário
                }
            });
        });

        // Evento de clique no botão de editar vaga
        $('.vagas-container').on('click', '.edit-vaga-btn', function(e) {
            e.stopPropagation(); // Impede que o clique no botão ative o clique do widget pai
            const vagaId = $(this).data('id');

            // Requisição AJAX para buscar os detalhes da vaga para preencher o formulário de edição
            $.ajax({
                url: 'backend/getVagaDetails.php',
                type: 'GET',
                data: { id: vagaId },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#editVagaId').val(data.id_vaga);
                        $('#editDescricao').val(data.descricao);
                        $('#editSituacao').val(data.situacao);
                        $('#editEmpresa').val(data.fk_id_empresa);
                        $('#editAtivo').prop('checked', data.flg_ativo === 'S');
                        $('#editVagaModal').modal('show');
                    } else {
                        console.error('Detalhes da vaga para edição não encontrados.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar detalhes da vaga para edição:', error);
                }
            });
        });

        // Evento de clique no botão de excluir vaga
        $('.vagas-container').on('click', '.delete-vaga-btn', function(e) {
            e.stopPropagation(); // Impede que o clique no botão ative o clique do widget pai
            const vagaId = $(this).data('id');
            const vagaName = $(this).data('name'); // Pega o nome da vaga do atributo data-name

            $('#deleteVagaIdConfirm').text(vagaId);
            $('#deleteVagaName').text(vagaName);
            $('#confirmDeleteVagaBtn').attr('href', 'backend/salvarVaga.php?funcao=D&codigo=' + vagaId);
            $('#deleteVagaModal').modal('show');
        });

        // Funcionalidade de pesquisa
        $('#searchVagaInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.vaga-widget').each(function() {
                const vagaName = $(this).find('h5').text().toLowerCase();
                if (vagaName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Botão para limpar a pesquisa
        $('#clearSearch').on('click', function() {
            $('#searchVagaInput').val('');
            $('.vaga-widget').show(); // Mostra todas as vagas novamente
        });

        // Exemplo de como você poderia implementar a ordenação (requer mais lógica no backend/frontend)
        // Por enquanto, apenas um placeholder para demonstração.
        // Você precisaria de um dropdown ou botões para isso.
        // Ex: $('#sortDropdown').on('change', function() { ... });
    });
</script>

</body>
</html>

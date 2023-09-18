<div>
    <!-- Modal para mostrar Perfil de Usuário -->
    <div class="modal fade modal-profile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5">

                            <!-- Card -->
                            <div class="card" style="min-height: 200px;">
                                <div class="bg-primary bg-soft">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-3">
                                                <h5 class="text-primary">Usuário</h5>
                                                <p class="font-size-15 jsonUser jsonUserName"></p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <x-button-crud op="99" model="1" class="btn-close float-end px-1 py-1" data-bs-dismiss="modal" aria-label="Close" />
                                            <img src="{{ asset('build/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <img src="" alt="" class="img-thumbnail rounded-circle jsonUserAvatar" id="imgImageAvatar">
                                            </div>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Grupo</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonUser jsonUserGrupo"></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Situação</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonUser jsonUserSituacao"></p>
                                                    </div>
                                                </div>
                                                <div class="row" id="modal-profile-botoes">
                                                    <div class="col-4 mt-4 px-0">
                                                        @if(\App\Facades\Permissoes::permissao(['users_perfil_edit'], $userLoggedPermissoes))
                                                            <x-button-crud op="99" model="3" bgColor="success" textColor="write" class="btn-sm float-end" image="fas fa-address-card" label="Avatar" id="buttonUploadAvatar" />
                                                            <x-button-crud op="99" model="3" bgColor="warning" textColor="write" class="btn-sm float-end" image="fas fa-address-card" label="Fechar" style="display: none;" id="buttonUploadAvatarClose" />
                                                        @endif
                                                    </div>
                                                    <div class="col-4 mt-4 px-0">
                                                        @if(\App\Facades\Permissoes::permissao(['users_perfil_edit'], $userLoggedPermissoes))
                                                            <x-button-crud op="99" model="3" bgColor="primary" textColor="write" class="btn-sm float-end" image="fas fa-envelope" label="E-mail" id="buttonEditEmail" />
                                                            <x-button-crud op="99" model="3" bgColor="warning" textColor="write" class="btn-sm float-end" image="fas fa-envelope" label="Fechar" style="display: none;" id="buttonEditEmailClose" />
                                                        @endif
                                                    </div>
                                                    <div class="col-4 mt-4 px-0">
                                                        @if(\App\Facades\Permissoes::permissao(['users_perfil_edit'], $userLoggedPermissoes))
                                                            <x-button-crud op="99" model="3" bgColor="danger" textColor="write" class="btn-sm float-end" image="fas fa-key" label="Senha" id="buttonEditPassword" />
                                                            <x-button-crud op="99" model="3" bgColor="warning" textColor="write" class="btn-sm float-end" image="fas fa-key" label="Fechar" style="display: none;" id="buttonEditPasswordClose" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 pt-4" id="divUploadAvatar" style="display: none;">
                                            <h4 class="text-success"><b>:: </b>Alterar Avatar</h4>

                                            <form method="post" enctype="multipart/form-data" id="frm_upload_avatar">
                                                @csrf
                                                @method('POST')

                                                <input type="hidden" class="jsonUserId" id="upload_avatar_user_id" name="upload_avatar_user_id" value="">

                                                <div class="row mt-4">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="avatar_file" id="avatar_file">
                                                        <button type="submit" class="input-group-text">Upload</button>
                                                    </div>
                                                </div>

                                                <span class="col-12 text-danger text-center" id="frm-upload-avatar-error"></span>
                                            </form>
                                        </div>

                                        <div class="col-sm-12 pt-4" id="divEditEmail" style="display: none;">
                                            <h4 class="text-primary"><b>:: </b>Alterar E-mail</h4>

                                            <form method="post" enctype="multipart/form-data" id="frm_edit_email">
                                                @csrf
                                                @method('POST')

                                                <input type="hidden" class="jsonUserId" id="edit_email_user_id" name="edit_email_user_id" value="">

                                                <div class="row mt-4">
                                                    <div class="form-group col-12 pb-3">
                                                        <label class="form-label">E-mail Atual</label>
                                                        <input type="email" class="form-control jsonUserCurrentEmail" id="current_email" name="current_email" readonly>
                                                        <span class="col-12 text-danger font-size-11" id="current-email-error"></span>
                                                    </div>
                                                    <div class="form-group col-12 pb-3">
                                                        <label class="form-label">E-mail Novo</label>
                                                        <input type="email" class="form-control" id="new_email" name="new_email">
                                                        <span class="col-12 text-danger font-size-11" id="new-email-error"></span>
                                                    </div>
                                                    <div class="form-group col-12 pb-3">
                                                        <x-button-crud op="99" model="3" type="submit" bgColor="success" textColor="write" image="fa fa-save" label="Confirmar" />
                                                    </div>
                                                </div>

                                                <span class="col-12 text-danger text-center" id="frm-edit-email-error"></span>
                                            </form>
                                        </div>

                                        <div class="col-sm-12 pt-4" id="divEditPassword" style="display: none;">
                                            <h4 class="text-danger"><b>:: </b>Alterar Senha</h4>

                                            <form method="post" id="frm_edit_password" name="frm_edit_password">
                                                @csrf
                                                @method('POST')

                                                <input type="hidden" class="jsonUserId" id="edit_password_user_id" name="edit_password_user_id" value="">

                                                <div class="row mt-4">
                                                    <div class="form-group col-12 pb-3">
                                                        <label class="form-label">Senha Atual</label>
                                                        <input type="password" class="form-control" id="current_password" name="current_password">
                                                        <span class="col-12 text-danger font-size-11" id="current-password-error"></span>
                                                    </div>
                                                    <div class="form-group col-12 pb-3">
                                                        <label class="form-label">Senha Nova</label>
                                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                                        <span class="col-12 text-danger font-size-11" id="new-password-error"></span>
                                                    </div>
                                                    <div class="form-group col-12 pb-3">
                                                        <label class="form-label">Confirmar Senha Nova</label>
                                                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                                        <span class="col-12 text-danger font-size-11" id="confirm-new-password-error"></span>
                                                    </div>
                                                    <div class="form-group col-12 pb-3">
                                                        <x-button-crud op="99" model="3" type="submit" bgColor="success" textColor="write" image="fa fa-save" label="Confirmar" />
                                                    </div>
                                                </div>

                                                <span class="col-12 text-danger text-center" id="frm-edit-password-error"></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Pessoais -->
                            <div class="card font-size-11" style="min-height: 270px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Informações Pessoais</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Name :</th>
                                                <td class="jsonUser jsonUserName"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-mail :</th>
                                                <td class="jsonUser jsonUserEmail"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Localização :</th>
                                                <td class="jsonUser jsonUserLocalizacao"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-7">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium mb-2">Inclusões</p>
                                                    <h4 class="mb-0 jsonTransacoesInclusions">0</h4>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                                        <span class="avatar-title bg-success"><i class="bx bx-plus font-size-24"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium mb-2">Alterações</p>
                                                    <h4 class="mb-0 jsonTransacoesAlterations">0</h4>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                        <span class="avatar-title bg-primary"><i class="bx bx-edit font-size-24"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium mb-2">Exclusões</p>
                                                    <h4 class="mb-0 jsonTransacoesExclusions">0</h4>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm mini-stat-icon rounded-circle bg-danger">
                                                        <span class="avatar-title bg-danger"><i class="bx bx-trash font-size-24"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card" style="min-height: 400px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Log de Transações</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0 class-datatable-2 font-size-11">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Operação</th>
                                                    <th scope="col">Submódulos</th>
                                                    <th scope="col">Data</th>
                                                </tr>
                                            </thead>
                                            <tbody class="jsonTransacoesTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar Foto e Transações do Cliente -->
    <div class="modal fade modal-cliente" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5">

                            <!-- Principal -->
                            <div class="card" style="min-height: 200px;">
                                <div class="bg-success">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-white p-3">
                                                <h5 class="text-white">Cliente</h5>
                                                <p class="jsonCliente jsonClienteName"></p>
                                            </div>
                                        </div>
                                        <div class="col-4 align-self-end">
                                            <x-button-crud op="99" model="1" class="btn-close float-end px-1 py-1" data-bs-dismiss="modal" aria-label="Close" />
                                            <img src="{{ asset('build/assets/images/cliente-img.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <h5 class="font-size-15">Status</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonCliente jsonClienteStatus"></p>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="font-size-15">Tipo</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonCliente jsonClienteTipo"></p>
                                                    </div>
                                                    <div class="col-5">
                                                        <h5 class="font-size-15 labelClienteCnpjCpf">CNPJ/CPF</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonCliente jsonClienteCnpj"></p>
                                                        <p class="text-muted mb-0 text-truncate jsonCliente jsonClienteCpf"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Pessoais -->
                            <div class="card font-size-11" style="min-height: 250px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Informações Gerais</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Cliente Principal :</th>
                                                    <td class="jsonCliente jsonClienteClientePrincipal"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email :</th>
                                                    <td class="jsonCliente jsonClienteEmail"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contato :</th>
                                                    <td>
                                                        <span class="jsonCliente jsonClienteContatoTelefone1"></span>
                                                        <span class="jsonCliente jsonClienteContatoTelefone2"></span>
                                                        <span class="jsonCliente jsonClienteContatoCelular1"></span>
                                                        <span class="jsonCliente jsonClienteContatoCelular2"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7">
                            <!-- Tabela -->
                            <div class="card" style="min-height: 475px;">
                                <div class="card-body">
                                    <h5 class="card-title text-success mb-4">Serviços</h5>
                                    <div class="/*table-responsive*/">
                                        <table class="table /*table-nowrap*/ table-hover mb-0 class-datatable-2 font-size-11">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Serviço</th>
                                                </tr>
                                            </thead>
                                            <tbody class="jsonCliente jsonClienteServicosTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar Foto e Transações do Fornecedor -->
    <div class="modal fade modal-fornecedor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5">

                            <!-- Principal -->
                            <div class="card" style="min-height: 200px;">
                                <div class="bg-primary">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-white p-3">
                                                <h5 class="text-white">Fornecedor</h5>
                                                <p class="jsonFornecedor jsonFornecedorName"></p>
                                            </div>
                                        </div>
                                        <div class="col-4 align-self-end">
                                            <x-button-crud op="99" model="1" class="btn-close float-end px-1 py-1" data-bs-dismiss="modal" aria-label="Close" />
                                            <img src="{{ asset('build/assets/images/fornecedor-img.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <h5 class="font-size-15">Status</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonFornecedor jsonFornecedorStatus"></p>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="font-size-15">Tipo</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonFornecedor jsonFornecedorTipo"></p>
                                                    </div>
                                                    <div class="col-5">
                                                        <h5 class="font-size-15 labelFornecedorCnpjCpf">CNPJ/CPF</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonFornecedor jsonFornecedorCnpj"></p>
                                                        <p class="text-muted mb-0 text-truncate jsonFornecedor jsonFornecedorCpf"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Pessoais -->
                            <div class="card font-size-11" style="min-height: 250px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Informações Gerais</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Site :</th>
                                                <td class="jsonFornecedor jsonFornecedorSite"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email :</th>
                                                <td class="jsonFornecedor jsonFornecedorEmail"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Contato :</th>
                                                <td>
                                                    <span class="jsonFornecedor jsonFornecedorContatoTelefone1"></span>
                                                    <span class="jsonFornecedor jsonFornecedorContatoTelefone2"></span>
                                                    <span class="jsonFornecedor jsonFornecedorContatoCelular1"></span>
                                                    <span class="jsonFornecedor jsonFornecedorContatoCelular2"></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7">
                            <!-- Tabela -->
                            <div class="card" style="min-height: 475px;">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-4">Compras</h5>
                                    <div class="/*table-responsive*/">
                                        <table class="table /*table-nowrap*/ table-hover mb-0 class-datatable-2 font-size-11">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Compra</th>
                                            </tr>
                                            </thead>
                                            <tbody class="jsonFornecedor jsonFornecedorComprasTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar Foto e Transações do Funcionario -->
    <div class="modal fade modal-funcionario" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5">
                            <!-- Card -->
                            <div class="card" style="min-height: 200px;">
                                <div class="bg-danger">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-white p-3">
                                                <h5 class="text-white">Funcionário</h5>
                                                <p class="jsonFuncionario jsonFuncionarioName"></p>
                                            </div>
                                        </div>
                                        <div class="col-4 align-self-end">
                                            <x-button-crud op="99" model="1" class="btn-close float-end px-1 py-1" data-bs-dismiss="modal" aria-label="Close" />
                                            <img src="{{ asset('build/assets/images/funcionario-img.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <img src="" alt="" class="img-thumbnail rounded-circle jsonFuncionario jsonFuncionarioFoto" id="imgImageFuncionarioExtraFoto">
                                            </div>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Função</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonFuncionario jsonFuncionarioFuncao"></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Gênero</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonFuncionario jsonFuncionarioGenero"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 mt-4 px-0">
                                                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                                                            <x-button-crud op="99" model="3" bgColor="danger" textColor="write" class="btn-sm float-end" image="fas fa-address-card" label="Foto" id="buttonUploadFuncionarioExtraFoto" />
                                                            <x-button-crud op="99" model="3" bgColor="warning" textColor="write" class="btn-sm float-end" image="fas fa-address-card" label="Fechar" style="display: none;" id="buttonUploadFuncionarioExtraFotoClose" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 pt-4" id="divUploadFuncionarioExtraFoto" style="display: none;">
                                            <h4 class="text-success"><b>:: </b>Alterar Foto</h4>

                                            <form method="post" enctype="multipart/form-data" id="frm_upload_funcionario_extra_foto">
                                                @csrf
                                                @method('POST')

                                                <input type="hidden" class="jsonFuncionario jsonFuncionarioId" id="upload_funcionario_extra_foto_funcionario_id" name="upload_funcionario_extra_foto_funcionario_id" value="">

                                                <div class="row mt-4">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="funcionario_extra_foto_file" id="funcionario_extra_foto_file">
                                                        <button type="submit" class="input-group-text">Upload</button>
                                                    </div>
                                                </div>

                                                <span class="col-12 text-danger text-center" id="frm-upload-funcionario-extra-foto-error"></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Pessoais -->
                            <div class="card" style="min-height: 250px;">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Informações Pessoais</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Name :</th>
                                                <td class="jsonFuncionario jsonFuncionarioName"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-mail :</th>
                                                <td class="jsonFuncionario jsonFuncionarioEmail"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-7">
                            <div class="card" style="min-height: 530px;">
                                <div class="card-body">
                                    <h5 class="card-title text-danger mb-4">Transações</h5>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0 class-datatable-2 font-size-11">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Operação</th>
                                            </tr>
                                            </thead>
                                            <tbody class="jsonFuncionarioTransacoesTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar Notificação que o usuário logado clicou para ler (Topbar) -->
    <div class="modal fade modal-notificacao-ler" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card overflow-hidden">
                                <div class="bg-secondary">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-white p-3">
                                                <h5 class="text-white">Notificação</h5>
                                                <p class="jsonNotificacaoLerTitulo"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="text-muted pt-4 mb-0 jsonNotificacaoLerNotificacao" style="text-align: justify"></p>
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

    <!-- Modal para mostrar Informações Visita Técnica -->
    <div class="modal fade modal-visita-tecnica" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: var(--bs-body-bg);">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5">

                            <!-- Card -->
                            <div class="card overflow-hidden">
                                <div class="bg-danger">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-white p-3">
                                                <h5 class="text-white">Extra</h5>
                                                <p>Visita Técnica do Sistema</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <x-button-crud op="99" model="1" class="btn-close float-end px-1 py-1" data-bs-dismiss="modal" aria-label="Close" />
                                            <img src="{{ asset('build/assets/images/visita_tecnica-img.png') }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h5 class="font-size-15 text-truncate jsonVisitaTecnicaName"></h5>
                                            <p class="text-muted mb-0 text-truncate jsonVisitaTecnicaFuncao"></p>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Escolaridade</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonVisitaTecnicaEscolaridade"></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Gênero</h5>
                                                        <p class="text-muted mb-0 text-truncate jsonVisitaTecnicaGenero"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 mt-4 px-0">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Pessoais -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Informações Pessoais</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Name :</th>
                                                <td class="jsonVisitaTecnicaName"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-mail :</th>
                                                <td class="jsonVisitaTecnicaEmail"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Transações</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0 class-datatable-2 font-size-11">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Operação</th>
                                            </tr>
                                            </thead>
                                            <tbody class="jsonVisitaTecnicaTransacoesTable"></tbody>
                                        </table>
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

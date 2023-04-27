<!-- Formulario -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create', $ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                                <button type="button" class="btn btn-success waves-effect btn-label waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Operação" id="crudFormConfirmOperacao"><i class="fa fa-save label-icon"></i> Confirmar</button>
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                                <button type="button" class="btn btn-primary waves-effect btn-label waves-light editRecord" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Alterar Registro"><i class="fas fa-pencil-alt label-icon"></i> Alterar</button>
                        @endif

                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_destroy'], $userLoggedPermissoes))
                            <!-- Botão Excluir Registro -->
                                <button type="button" class="btn btn-danger waves-effect btn-label waves-light deleteRecord" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Excluir Registro"><i class="fa fa-trash-alt label-icon"></i> Excluir</button>
                        @endif

                        <!-- Botão Extra -->
                        <button type="button" class="btn btn-warning waves-effect btn-label waves-light" data-bs-toggle="modal" data-bs-target=".modal-fornecedor" onclick="fornecedorExtraData();" data-id="0"><i class="bx bx-photo-album label-icon"></i> Extra</button>

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-loading" id="crudFormAjaxLoading" style="display: none;">
                        <div class="spinner-chase">
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                            <div class="chase-dot"></div>
                        </div>
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{$ajaxNameFormSubmodulo}}" name="{{$ajaxNameFormSubmodulo}}">
                        <fieldset disabled id="fieldsetForm">
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">
                            <input type="hidden" id="foto" name="foto" value="build/assets/images/fornecedores/fornecedor-0.png">

                            <div class="row mt-4">
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Informa&ccedil;&otilde;es Gerais</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label col-12">Status</label>
                                        <select class="select2 form-control col-12" name="status" id="status" required="required">
                                            <option value="1">ATIVO</option>
                                            <option value="2">INATIVO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Tipo</label>
                                        <select class="select2 form-control" name="tipo" id="tipo" required="required">
                                            <option value="1">PESSOA JURÍDICA</option>
                                            <option value="2">PESSOA FÍSICA</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_fisica">
                                        <label class="form-label">CPF</label>
                                        <input type="text" class="form-control mask_cpf" id="cpf" name="cpf">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_juridica">
                                        <label class="form-label">
                                            CNPJ
                                            <a href="#" class="texto-primary" id="link_api_buscar">&nbsp;&nbsp;&nbsp;<i class="mdi mdi-search-web"></i> Buscar na API</a>
                                        </label>
                                        <input type="text" class="form-control mask_cnpj" id="cnpj" name="cnpj">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_juridica">
                                        <label class="form-label">Nome Fantasia</label>
                                        <input type="text" class="form-control text-uppercase" id="nome_fantasia" name="nome_fantasia">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_fisica">
                                        <label class="form-label">Gênero</label>
                                        <select class="select2 form-control" name="genero_id" id="genero_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($generos as $key => $genero)
                                                <option value="{{ $genero['id'] }}">{{ $genero['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label" id="label_data_nascimento">Nascimento</label>
                                        <input type="text" class="form-control mask_date" id="data_nascimento" name="data_nascimento">
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Contato</h5>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Telefone 1</label>
                                        <input type="text" class="form-control mask_phone_with_ddd" id="telefone_1" name="telefone_1">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Telefone 2</label>
                                        <input type="text" class="form-control mask_phone_with_ddd" id="telefone_2" name="telefone_2">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Celular 1</label>
                                        <input type="text" class="form-control mask_cell_with_ddd" id="celular_1" name="celular_1">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Celular 2</label>
                                        <input type="text" class="form-control mask_cell_with_ddd" id="celular_2" name="celular_2">
                                    </div>
                                    <div class="form-group col-12 col-md-6 pb-3">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control text-lowercase mask_email" id="email" name="email">
                                    </div>
                                    <div class="form-group col-12 col-md-6 pb-3">
                                        <label class="form-label">Site</label>
                                        <input type="text" class="form-control text-lowercase" id="site" name="site">
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-landmark"></i> Dados Bancários</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Banco</label>
                                        <select class="form-control select2" name="banco_id" id="banco_id">
                                            <option value="">Selecione...</option>

                                            @foreach ($bancos as $key => $banco)
                                                <option value="{{ $banco['id'] }}">{{ $banco['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Agência</label>
                                        <input type="text" class="form-control" id="agencia" name="agencia">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Conta</label>
                                        <input type="text" class="form-control" id="conta" name="conta">
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-paste"></i> Documentos</h5>
                                    <div class="form-group col-12 col-md-3 pb-3 pessoa_fisica">
                                        <label class="form-label">Identidade (Órgão)</label>
                                        <select class="form-control select2" name="identidade_orgao_id" id="identidade_orgao_id">
                                            <option value="">Selecione...</option>

                                            @foreach ($identidade_orgaos as $key => $identidade_orgao)
                                                <option value="{{ $identidade_orgao['id'] }}">{{ $identidade_orgao['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3 pessoa_fisica">
                                        <label class="form-label">Identidade (Estado)</label>
                                        <select class="form-control select2" name="identidade_estado_id" id="identidade_estado_id">
                                            <option value="">Selecione...</option>

                                            @foreach ($identidade_estados as $key => $identidade_estado)
                                                <option value="{{ $identidade_estado['id'] }}">{{ $identidade_estado['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3 pessoa_fisica">
                                        <label class="form-label">Identidade (Número)</label>
                                        <input type="text" class="form-control" id="identidade_numero" name="identidade_numero">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3 pessoa_fisica">
                                        <label class="form-label">Identidade (Emissão)</label>
                                        <input type="text" class="form-control mask_date" id="identidade_data_emissao" name="identidade_data_emissao">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_juridica">
                                        <label class="form-label">Inscrição Estadual</label>
                                        <input type="text" class="form-control" id="inscricao_estadual" name="inscricao_estadual">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3 pessoa_juridica">
                                        <label class="form-label">Inscrição Municipal</label>
                                        <input type="text" class="form-control" id="inscricao_municipal" name="inscricao_municipal">
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-house-user"></i> Endereço</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">CEP</label>
                                        <input type="text" class="form-control mask_cep" id="cep" name="cep" onblur="pesquisacep(this.value);">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" id="numero" name="numero">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Complemento</label>
                                        <input type="text" class="form-control text-uppercase" id="complemento" name="complemento">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Logradouro</label>
                                        <input type="text" class="form-control text-uppercase" id="logradouro" name="logradouro" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" class="form-control text-uppercase" id="bairro" name="bairro" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Localidade</label>
                                        <input type="text" class="form-control text-uppercase" id="localidade" name="localidade" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">UF</label>
                                        <input type="text" class="form-control text-uppercase" id="uf" name="uf" readonly="readonly">
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-house-user"></i> Endereço Cobrança</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">CEP</label>
                                        <input type="text" class="form-control mask_cep" id="cep_cobranca" name="cep_cobranca" onblur="pesquisacep_cobranca(this.value);">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" id="numero_cobranca" name="numero_cobranca">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Complemento</label>
                                        <input type="text" class="form-control text-uppercase" id="complemento_cobranca" name="complemento_cobranca">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Logradouro</label>
                                        <input type="text" class="form-control text-uppercase" id="logradouro_cobranca" name="logradouro_cobranca" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" class="form-control text-uppercase" id="bairro_cobranca" name="bairro_cobranca" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Localidade</label>
                                        <input type="text" class="form-control text-uppercase" id="localidade_cobranca" name="localidade_cobranca" readonly="readonly">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">UF</label>
                                        <input type="text" class="form-control text-uppercase" id="uf_cobranca" name="uf_cobranca" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- API modal -->
<div class="modal fade modal-dialog-scrollable" id="modal_api" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="pb-2">
                                <button type="button" class="btn btn-success button_api_copiar">Copiar Informações</button>
                            </div>
                            <div class="table-responsive">
                                <!-- Campos hidden para copiar -->
                                <input type="hidden" name="hidden_api_situacao" id="hidden_api_situacao">
                                <input type="hidden" name="hidden_api_tipo" id="hidden_api_tipo">
                                <input type="hidden" name="hidden_api_natureza_juridica" id="hidden_api_natureza_juridica">
                                <input type="hidden" name="hidden_api_nome" id="hidden_api_nome">
                                <input type="hidden" name="hidden_api_fantasia" id="hidden_api_fantasia">
                                <input type="hidden" name="hidden_api_cnpj" id="hidden_api_cnpj">
                                <input type="hidden" name="hidden_api_abertura" id="hidden_api_abertura">
                                <input type="hidden" name="hidden_api_cep" id="hidden_api_cep">
                                <input type="hidden" name="hidden_api_telefone" id="hidden_api_telefone">
                                <input type="hidden" name="hidden_api_email" id="hidden_api_email">
                                <input type="hidden" name="hidden_api_logradouro" id="hidden_api_logradouro">
                                <input type="hidden" name="hidden_api_numero" id="hidden_api_numero">
                                <input type="hidden" name="hidden_api_complemento" id="hidden_api_complemento">
                                <input type="hidden" name="hidden_api_bairro" id="hidden_api_bairro">
                                <input type="hidden" name="hidden_api_municipio" id="hidden_api_municipio">
                                <input type="hidden" name="hidden_api_uf" id="hidden_api_uf">

                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Situação</th>
                                        <td name="td_api_situacao" id="td_api_situacao"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tipo</th>
                                        <td name="td_api_tipo" id="td_api_tipo"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Natureza Jurídica</th>
                                        <td name="td_api_natureza_juridica" id="td_api_natureza_juridica"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nome</th>
                                        <td name="td_api_nome" id="td_api_nome"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nome Fantasia</th>
                                        <td name="td_api_fantasia" id="td_api_fantasia"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CNPJ</th>
                                        <td name="td_api_cnpj" id="td_api_cnpj"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Abertura</th>
                                        <td name="td_api_abertura" id="td_api_abertura"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CEP</th>
                                        <td name="td_api_cep" id="td_api_cep"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Telefone</th>
                                        <td name="td_api_telefone" id="td_api_telefone"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">E-mail</th>
                                        <td name="td_api_email" id="td_api_email"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Logradouro</th>
                                        <td name="td_api_logradouro" id="td_api_logradouro"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Número</th>
                                        <td name="td_api_numero" id="td_api_numero"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Complemento</th>
                                        <td name="td_api_complemento" id="td_api_complemento"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Bairro</th>
                                        <td name="td_api_bairro" id="td_api_bairro"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Município</th>
                                        <td name="td_api_municipio" id="td_api_municipio"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">UF</th>
                                        <td name="td_api_uf" id="td_api_uf"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success button_api_copiar">Copiar Informações</button>
            </div>
        </div>
    </div>
</div>

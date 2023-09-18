<!-- Formulario -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons crudFormButtons1">
                        <!-- store or update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create', $ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                                <x-button-crud op="5" class="crudConfirmarOperacao" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" class="crudCancelarOperacao" />
                    </div>
                    <div class="modal-buttons crudFormButtons2">
                        <!-- edit or delete -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                                <x-button-crud op="2" class="crudAlterarRegistro" />
                        @endif

                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_destroy'], $userLoggedPermissoes))
                            <!-- Botão Excluir Registro -->
                                <x-button-crud op="3" class="crudExcluirRegistro" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" class="crudCancelarOperacao" />
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
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row mt-4">
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Usuário</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control text-lowercase" id="email" name="email" required="required">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Funcionário</label>
                                        <select class="form-control select2" name="funcionario_id" id="funcionario_id">
                                            <option value="">Selecione...</option>

                                            @foreach ($funcionarios as $key => $funcionario)
                                                <option value="{{ $funcionario['id'] }}">{{ $funcionario['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Montar configurações para Empresas do Grupo SR+ - Início -->
                                <!-- Montar configurações para Empresas do Grupo SR+ - Início -->
                                @foreach ($empresas as $key => $empresa)

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Configurações ({{$empresa['name']}})</h5>

                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Grupo</label>
                                        <select class="form-control" name="grupo_id_{{$empresa['id']}}" id="grupo_id_{{$empresa['id']}}">
                                            <option value="">Selecione...</option>

                                            @foreach ($grupos as $key => $grupo)
                                                <option value="{{ $grupo['id'] }}">{{ $grupo['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Situação</label>
                                        <select class="form-control" name="situacao_id_{{$empresa['id']}}" id="situacao_id_{{$empresa['id']}}">
                                            <option value="">Selecione...</option>

                                            @foreach ($situacoes as $key => $situacao)
                                                <option value="{{ $situacao['id'] }}">{{ $situacao['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Acesso</label>
                                        <select class="form-control" name="sistema_acesso_id_{{$empresa['id']}}" id="sistema_acesso_id_{{$empresa['id']}}">
                                            <option value="">Selecione...</option>

                                            @foreach ($sistema_acessos as $key => $sistema_acesso)
                                                <option value="{{ $sistema_acesso['id'] }}">{{ $sistema_acesso['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Modo de layout</label>
                                        <select class="form-control" name="layout_mode_{{$empresa['id']}}" id="layout_mode_{{$empresa['id']}}">
                                            <option value=''>Selecione...</option>

                                            @foreach ($layouts_modes as $key => $layout_mode)
                                                @if($layout_mode['ativo'] == 1)
                                                    <option value="{{ $layout_mode['name'] }}">{{ $layout_mode['descricao'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Estilo de Layout</label>
                                        <select class="form-control" name="layout_style_{{$empresa['id']}}" id="layout_style_{{$empresa['id']}}">
                                            <option value=''>Selecione...</option>

                                            @foreach ($layouts_styles as $key => $layout_style)
                                                @if($layout_style['ativo'] == 1)
                                                    <option value="{{ $layout_style['name'] }}">{{ $layout_style['descricao'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @endforeach
                                <!-- Montar configurações para Empresas do Grupo SR+ - Fim -->
                                <!-- Montar configurações para Empresas do Grupo SR+ - Fim -->

                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

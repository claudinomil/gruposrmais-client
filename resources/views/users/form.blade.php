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
                                        <label class="form-label">Grupo</label>
                                        <select class="form-control select2" name="grupo_id" id="grupo_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($grupos as $key => $grupo)
                                                <option value="{{ $grupo['id'] }}">{{ $grupo['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Situação</label>
                                        <select class="form-control select2" name="situacao_id" id="situacao_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($situacoes as $key => $situacao)
                                                <option value="{{ $situacao['id'] }}">{{ $situacao['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Configurações</h5>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Acesso</label>
                                        <select class="form-control select2" name="sistema_acesso_id" id="sistema_acesso_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($sistema_acessos as $key => $sistema_acesso)
                                                <option value="{{ $sistema_acesso['id'] }}">{{ $sistema_acesso['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Modo de layout</label>
                                        <select class="form-control select2" name="layout_mode" id="layout_mode" required="required">
                                            <option value=''>Selecione...</option>
                                            <option value="layout_mode_light"> Modo Claro</option>
                                            <option value="layout_mode_dark"> Modo Escuro</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Estilo de Layout</label>
                                        <select class="form-control select2" name="layout_style" id="layout_style" required="required">
                                            <option value=''>Selecione...</option>
                                            <option value="layout_style_vertical_light_sidebar">Vertical - Barra Lateral Leve</option>
                                            <option value="layout_style_vertical_compact_sidebar">Vertical - Barra Lateral Compacta</option>
                                            <option value="layout_style_vertical_icon_sidebar">Vertical - Barra lateral de ícones</option>
                                            <option value="layout_style_vertical_boxed_width">Vertical - Largura da Caixa</option>
                                            <option value="layout_style_vertical_colored_sidebar">Vertical - Barra Lateral Colorida</option>
                                            <option value="layout_style_vertical_scrollable">Vertical - Rolável</option>
                                            <option value="layout_style_horizontal_horizontal">Horizontal - Horizontal</option>
                                            <option value="layout_style_horizontal_topbar_light">Horizontal - Luz da Barra Superior</option>
                                            <option value="layout_style_horizontal_boxed_width">Horizontal - Largura da Caixa</option>
                                            <option value="layout_style_horizontal_colored_header">Horizontal - Cabeçalho Colorido</option>
                                            <option value="layout_style_horizontal_scrollable">Horizontal - Rolável</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Referência</h5>
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
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

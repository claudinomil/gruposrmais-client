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
                        <input type="hidden" id="frm_operacao" name="frm_operacao">
                        <input type="hidden" id="registro_id" name="registro_id">

                        <div class="row mt-4">
                            <div class="row pt-4">
                                <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Informa&ccedil;&otilde;es Gerais</h5>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Serviço Descrição</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Serviço Tipo</label>
                                    <select class="form-select" name="servico_tipo_id" id="servico_tipo_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($servico_tipos as $key => $servico_tipo)
                                            <option class="{{ 'servico_tipo_name_'.$servico_tipo['id'] }}" value="{{ $servico_tipo['id'] }}">{{ $servico_tipo['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Valor de Referência</label>
                                    <input type="text" class="form-control mask_money" id="valor" name="valor" value="0,00" required="required">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

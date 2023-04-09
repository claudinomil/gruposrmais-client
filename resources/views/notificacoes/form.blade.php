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
                        <fieldset disabled id="fieldsetForm">
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row mt-4">
                                <!-- View/Edit -->
                                <div class="form-group col-12 col-md-3 pb-3 fieldsViewEdit" style="display: none;">
                                    <label class="form-label">Data</label>
                                    <input type="text" class="form-control" id="fieldDate" readonly="readonly">
                                    <input type="hidden" id="date" name="date">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3 fieldsViewEdit" style="display: none;">
                                    <label class="form-label">Hora</label>
                                    <input type="text" class="form-control" id="fieldTime" readonly="readonly">
                                    <input type="hidden" id="time" name="time">
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3 fieldsViewEdit" style="display: none;">
                                    <label class="form-label">Usuário</label>
                                    <input type="text" class="form-control" id="fieldUserName" readonly="readonly">
                                    <input type="hidden" id="user_id" name="user_id">
                                </div>

                                <!-- Create -->
                                <div class="form-group col-12 col-md-3 pb-3 fieldsCreate" style="display: none;">
                                    <input type="hidden" id="date" name="date" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" id="time" name="time" value="{{ date('H:i:s') }}">
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $userLoggedData['id'] }}">
                                </div>

                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Título</label>
                                    <input type="text" class="form-control" id="title" name="title" required="required">
                                </div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Notificação</label>
                                    <textarea class="form-control" rows="3" id="notificacao" name="notificacao" required="required"></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

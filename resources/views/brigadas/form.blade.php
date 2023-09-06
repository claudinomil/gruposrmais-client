<!-- Formulario crudForm -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons crudFormButtons1">
                        <!-- update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                            <button type="button" class="btn btn-success waves-effect btn-label waves-light crudFormConfirmOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Operação"><i class="fa fa-save label-icon"></i> Confirmar</button>
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-buttons crudFormButtons2">
                        <!-- edit -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light editRecord" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Alterar Registro"><i class="fas fa-pencil-alt label-icon"></i> Alterar</button>
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
                    <form id="{{$ajaxNameFormSubmodulo}}" name="{{$ajaxNameFormSubmodulo}}" enctype="multipart/form-data">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row mt-4">
                                <div class="row pt-4" id="divInformacoesServico">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-list"></i> Informa&ccedil;&otilde;es do Serviço</h5>
                                    <div class="form-group col-12 col-md-5 pb-3">
                                        <label class="form-label col-12">Cliente</label>
                                        <input type="text" class="form-control" id="is_cliente" name="is_cliente" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label col-12">Status do Serviço</label>
                                        <input type="text" class="form-control" id="is_servico_status" name="is_servico_status" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-5 pb-3">
                                        <label class="form-label col-12">Funcionário Responsável</label>
                                        <input type="text" class="form-control" id="is_responsavel_funcionario" name="is_responsavel_funcionario" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Data Início</label>
                                        <input type="text" class="form-control mask_date" id="is_data_inicio" name="is_data_inicio" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Data Fim</label>
                                        <input type="text" class="form-control mask_date" id="is_data_fim" name="is_data_fim" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Data Vencimento</label>
                                        <input type="text" class="form-control mask_date" id="is_data_vencimento" name="is_data_vencimento" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label text-end">Valor</label>
                                        <input type="text" class="form-control text-end mask_money" id="is_valor" name="is_valor" readonly>
                                    </div>
                                </div>

                                <div class="row pt-4" id="divEscalas">
                                    <h5 class="pb-4 text-primary"><i class="far fa-calendar-alt"></i> Escalas</h5>
                                </div>

                                <div class="row pt-4" id="divRondas">
                                    <h5 class="pb-4 text-primary"><i class="far fa-calendar-check"></i> Rondas</h5>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario escalasForm -->
<div id="escalasForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Botões -->
                        <div class="col-12 col-md-8 float-start">
                            <div class="row">
                                <div class="col pb-4">
                                    <!-- Botão Cancelar Operação -->
                                    <button type="button" class="btn btn-secondary waves-effect btn-label waves-light escalasFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>

                        <!-- Filtro -->
                        <div class="col-12 col-md-4 float-end">
                            <div class="row">
                                <div class="col-5 col-md-5 float-end px-1">
                                    <input type="date" class="form-control text-center font-size-12" id="es_periodo_data_1" name="es_periodo_data_1">
                                </div>
                                <div class="col-5 col-md-5 float-end px-1">
                                    <input type="date" class="form-control text-center font-size-12" id="es_periodo_data_2" name="es_periodo_data_2">
                                </div>
                                <div class="col-2 col-md-2 float-start ps-1">
                                    <x-button op="17" id="btnGradeEscalas" />
                                </div>
                                <div class="col-12 text-info small" id="divPeriodoDatasEscalas"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Título -->
                    <div class="col-12 pb-4">
                        <h4 class="font-size-14" id="titulo"></h4>
                    </div>

                    <div class="modal-loading" id="escalasFormAjaxLoading" style="display: none;">
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
                    <form id="frm_escalas" name="frm_escalas" enctype="multipart/form-data">
                        <fieldset id="fieldsetEscalas">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive w-100 er_grade_escala">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nome</th>
                                            <th>Chegada</th>
                                            <th>Saída</th>
                                            <th style="max-width: 200px">Frequência / Ronda</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ações -->
    <div class="modal fade modal-acoes" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-acoes-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frm_escala_frequencia" name="frm_escala_frequencia" enctype="multipart/form-data">
                        <input type="hidden" id="brigada_escala_id" name="brigada_escala_id">
                        <input type="hidden" id="escala_frequencia_id" name="escala_frequencia_id">

                        <div class="row">
                            <div class="col-4 pb-3">
                                <button type="button" class="btn btn-outline-success text-center btn-sm col-12 text-center font-size-10" onclick="$('#escala_frequencia_id').val(1); bi_atualizarFrequenciaEscala();">PRESENÇA</button>
                            </div>
                            <div class="col-4 pb-3">
                                <button type="button" class="btn btn-outline-warning text-center btn-sm col-12 text-center font-size-10" onclick="$('#escala_frequencia_id').val(2); bi_atualizarFrequenciaEscala();">ATRASO</button>
                            </div>
                            <div class="col-4 pb-3">
                                <button type="button" class="btn btn-outline-danger text-center btn-sm col-12 text-center font-size-10" onclick="$('#escala_frequencia_id').val(3); bi_atualizarFrequenciaEscala();">FALTA</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario rondasForm -->
<div id="rondasForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Botões -->
                        <div class="col-12 col-md-8 float-start">
                            <div class="row">
                                <div class="col pb-4">
                                    <!-- Criar Registro com a Ronda -->
                                    @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create'], $userLoggedPermissoes))
                                        <!-- Botão Confirnar Operação -->
                                        <button type="button" class="btn btn-success waves-effect btn-label waves-light rondasFormConfirmOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Ronda"><i class="fa fa-save label-icon"></i> Confirmar</button>
                                    @endif

                                    <!-- Botão Cancelar Operação -->
                                    <button type="button" class="btn btn-secondary waves-effect btn-label waves-light rondasFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Título -->
                    <div class="col-12 pb-4">
                        <h4 class="font-size-14" id="titulo"></h4>
                    </div>

                    <!-- Título2 -->
                    <div class="col-12 pb-4">
                        <h4 class="font-size-12" id="titulo2"></h4>
                    </div>

                    <div class="modal-loading" id="rondasFormAjaxLoading" style="display: none;">
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
                    <form id="frm_rondas" name="frm_rondas" enctype="multipart/form-data">
                        <fieldset id="fieldsetRondas">
                            <input type="hidden" id="brigada_escala_id" name="brigada_escala_id">
                            <input type="hidden" id="brigada_ronda_id" name="brigada_ronda_id">

                            <div class="row" id="divMedidasSegurancaRondaItens"></div>
                        </fieldset>
                    </form>

                    <div class="row">
                        <!-- Botões -->
                        <div class="col-12 col-md-8 float-start">
                            <div class="row">
                                <div class="col pb-4">
                                    <!-- Criar Registro com a Ronda -->
                                    @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_create'], $userLoggedPermissoes))
                                        <!-- Botão Confirnar Operação -->
                                        <button type="button" class="btn btn-success waves-effect btn-label waves-light rondasFormConfirmOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Ronda"><i class="fa fa-save label-icon"></i> Confirmar</button>
                                    @endif

                                    <!-- Botão Cancelar Operação -->
                                    <button type="button" class="btn btn-secondary waves-effect btn-label waves-light rondasFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

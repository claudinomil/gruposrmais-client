@extends('Mobile.layouts.layout')

@section('content')
    <div id="crudTable">
        <div class="bg-white rounded py-2 px-2">
            <!-- Botoes -->
            <div class="row">
                <div class="col-12 col-md-8 pb-2"></div>
            </div>

            <!-- Tabela (Componente Blade) -->
            @php
                $colsNames = ['Cliente', 'Data'];
                $colsFields = ['clienteName', 'data_visita'];
                $colActions = 'yes';
            @endphp

            <div class="pt-1">
                <x-table-mobile-ajax
                    :numCols="3"
                    :class="'table table-dark table-bordered mb-0 font-size-10'"
                    :colsNames=$colsNames
                    :colsFields=$colsFields
                    :colActions=$colActions />
            </div>

        </div>
    </div>

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
                        <form id="{{$ajaxNameFormSubmodulo}}" name="{{$ajaxNameFormSubmodulo}}">
                            <fieldset>
                                <input type="hidden" id="frm_operacao" name="frm_operacao">
                                <input type="hidden" id="registro_id" name="registro_id">

                                <div class="row mt-4">
                                    <div class="row pt-4">
                                        <h5 class="pb-4 text-primary"><i class="fas fa-list"></i> Informa&ccedil;&otilde;es Gerais</h5>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Status</label>
                                            <select class="select2 form-control" name="visita_tecnica_status_id" id="visita_tecnica_status_id" required="required">
                                                <option value="">Selecione...</option>

                                                @foreach ($visita_tecnica_status as $key => $status)
                                                    <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-9 pb-3">
                                            <label class="form-label">Cliente</label>
                                            <select class="select2 form-control" name="cliente_id" id="cliente_id" required="required">
                                                <option value="">Selecione...</option>

                                                @foreach ($clientes as $key => $cliente)
                                                    <option value="{{ $cliente['id'] }}">{{ $cliente['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group col-6 col-md-3 pb-3">
                                            <label class="form-label">Data Visita</label>
                                            <input type="text" class="form-control mask_date" id="data_visita" name="data_visita">
                                        </div>
                                        <div class="form-group col-12 col-md-9 pb-3">
                                            <label class="form-label">Responsável</label>
                                            <select class="select2 form-control" name="responsavel_funcionario_id" id="responsavel_funcionario_id">
                                                <option value="">Selecione...</option>

                                                @foreach ($funcionarios as $key => $funcionario)
                                                    <option value="{{ $funcionario['id'] }}">{{ $funcionario['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="row pt-4">
                                        <h5 class="pb-4 text-primary"><i class="fas fa-clipboard"></i> Classificação (DECRETO Nº 42, DE 17 DE DEZEMBRO DE 2018)</h5>

                                        <div class="row pt-3 ps-4">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Informações Gerais</h6>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Número Pavimentos</label>
                                                <input type="text" class="form-control" id="numero_pavimentos" name="numero_pavimentos" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Altura</label>
                                                <input type="text" class="form-control" id="altura" name="altura" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">ATC (m²)</label>
                                                <input type="text" class="form-control" id="area_total_construida" name="area_total_construida" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Lotação</label>
                                                <input type="text" class="form-control" id="lotacao" name="lotacao" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Carga Incêndio</label>
                                                <input type="text" class="form-control" id="carga_incendio" name="carga_incendio" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Risco Incêndio</label>
                                                <input type="text" class="form-control" id="incendio_risco" name="incendio_risco" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Grupo</label>
                                                <input type="text" class="form-control" id="grupo" name="grupo" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-2 pb-3">
                                                <label class="form-label">Divisão</label>
                                                <input type="text" class="form-control" id="divisao" name="divisao" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Ocupação</label>
                                                <input type="text" class="form-control" id="ocupacao_uso" name="ocupacao_uso" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-5 pb-3">
                                                <label class="form-label">Descrição</label>
                                                <input type="text" class="form-control" id="descricao" name="descricao" readonly>
                                            </div>
                                        </div>

                                        <div class="row pt-3 ps-4" id="divProjetoScip" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Projeto SCIP</h6>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Número</label>
                                                <input type="text" class="form-control" id="projeto_scip_numero" name="projeto_scip_numero" readonly>
                                            </div>
                                        </div>
                                        <div class="row pt-3 ps-4" id="divLaudoExigencias" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Laudo de Exigências</h6>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Número</label>
                                                <input type="text" class="form-control" id="laudo_exigencias_numero" name="laudo_exigencias_numero" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-3 pb-3">
                                                <label class="form-label">Emissão</label>
                                                <input type="text" class="form-control" id="laudo_exigencias_data_emissao" name="laudo_exigencias_data_emissao" readonly>
                                            </div>
                                            <div class="form-group col-6 col-md-3 pb-3">
                                                <label class="form-label">Vencimento</label>
                                                <input type="text" class="form-control" id="laudo_exigencias_data_vencimento" name="laudo_exigencias_data_vencimento" readonly>
                                            </div>
                                        </div>
                                        <div class="row pt-3 ps-4" id="divCertificadoAprovacao" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação</h6>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Número</label>
                                                <input type="text" class="form-control" id="certificado_aprovacao_numero" name="certificado_aprovacao_numero" readonly>
                                            </div>
                                        </div>
                                        <div class="row pt-3 ps-4" id="divCertificadoAprovacaoSimplificado" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação Simplificado</h6>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Número</label>
                                                <input type="text" class="form-control" id="certificado_aprovacao_simplificado_numero" name="certificado_aprovacao_simplificado_numero" readonly>
                                            </div>
                                        </div>
                                        <div class="row pt-3 ps-4" id="divCertificadoAprovacaoAssistido" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação Assistido</h6>
                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label">Número</label>
                                                <input type="text" class="form-control" id="certificado_aprovacao_assistido_numero" name="certificado_aprovacao_assistido_numero" readonly>
                                            </div>
                                        </div>
                                        <div class="row pt-3 ps-4" id="divMedidasSeguranca" style="display: none;">
                                            <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Medidas de Segurança</h6>

                                            <div class="row pt-3 ps-4" id="divMedidasSegurancaItens"></div>
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
@endsection

@section('script')
    <!-- scripts_visitas_tecnicas.js -->
    <script src="{{ Vite::asset('resources/assets_template/js/scripts_mobile_visitas_tecnicas.js')}}"></script>
@endsection

@section('script-bottom')
@endsection

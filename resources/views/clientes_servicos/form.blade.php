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
                            <button type="button" class="btn btn-success waves-effect btn-label waves-light crudFormConfirmOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Operação"><i class="fa fa-save label-icon"></i> Confirmar</button>
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                    <div class="modal-buttons crudFormButtons2">
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
                                    <h5 class="pb-4 text-primary"><i class="fas fa-user"></i> Informa&ccedil;&otilde;es Gerais</h5>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label col-12">Status</label>
                                        <select class="form-select" name="servico_status_id" id="servico_status_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($servico_status as $key => $status)
                                                <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label col-12">Cliente</label>
                                        <select class="select2 form-select" name="cliente_id" id="cliente_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($clientes as $key => $cliente)
                                                <option value="{{ $cliente['id'] }}">{{ $cliente['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-5 pb-3">
                                        <label class="form-label col-12">Serviço</label>
                                        <select class="select2 form-control" name="servico_id" id="servico_id" required="required">
                                            <option value="" data-servico_tipo_id="0">Selecione...</option>

                                            @foreach ($servicos as $key => $servico)
                                                <option value="{{ $servico['id'] }}" data-servico_tipo_id="{{ $servico['servico_tipo_id'] }}">{{ $servico['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label col-12">Funcionário Responsável</label>
                                        <select class="select2 form-control" name="responsavel_funcionario_id" id="responsavel_funcionario_id">
                                            <option value="">Selecione...</option>

                                            @foreach ($funcionarios as $key => $funcionario)
                                                <option value="{{ $funcionario['id'] }}">{{ $funcionario['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-md-2 pb-3" id="divQuantidade">
                                        <label class="form-label">Qtd</label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3" id="divDataInicio">
                                        <label class="form-label">Data Início</label>
                                        <input type="text" class="form-control mask_date" id="data_inicio" name="data_inicio" required="required">
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3" id="divDataFim">
                                        <label class="form-label">Data Fim</label>
                                        <input type="text" class="form-control mask_date" id="data_fim" name="data_fim" required="required">
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3" id="divDataVencimento">
                                        <label class="form-label">Data Vencimento</label>
                                        <input type="text" class="form-control mask_date" id="data_vencimento" name="data_vencimento">
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3" id="divValor">
                                        <label class="form-label text-end">Valor</label>
                                        <input type="text" class="form-control text-end mask_money" id="valor" name="valor">
                                    </div>

                                </div>

                                <!-- Serviço Tipo 1: BRIGADA DE INCÊNDIO -->
                                <div class="row pt-4 d-none" id="divSTBrigada">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-hotel"></i> Brigada</h5>
                                    <div class="row">
                                        <!-- Informações Gerais -->
                                        <div class="col-12 col-md-6">
                                            <h6 class="pb-2"><i class="fas fa-clipboard-list"></i> Informações Gerais</h6>
                                            <div class="row col-12 bg-light py-2 px-2">
                                                <div class="form-group col-12 col-md-4 pb-3">
                                                    <label class="form-label">Escala</label>
                                                    <select class="form-control" name="bi_escala_tipo_id" id="bi_escala_tipo_id" required="required">
                                                        <option value="">Selecione...</option>
                                                        @foreach ($escala_tipos as $key => $escala_tipo)
                                                            <option value="{{ $escala_tipo['id'] }}" data-quantidade_alas="{{ $escala_tipo['quantidade_alas'] }}">{{ $escala_tipo['name'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Campos preenchidos com os valores vindos da escolha da escala -->
                                                    <input type="hidden" id="bi_quantidade_alas_escala" name="bi_quantidade_alas_escala" value="">
                                                </div>

                                                <div class="form-group col-12 col-md-4 pb-3">
                                                    <label class="form-label">Brigadistas Ala</label>
                                                    <input type="number" class="form-control" id="bi_quantidade_brigadistas_por_ala" name="bi_quantidade_brigadistas_por_ala" step="1" required="required">
                                                </div>
                                                <div class="form-group col-12 col-md-4 pb-3">
                                                    <label class="form-label">Brigadistas Total</label>
                                                    <input type="text" class="form-control" id="bi_quantidade_brigadistas_total" name="bi_quantidade_brigadistas_total" readonly>
                                                </div>
                                                <div class="form-group col-12 col-md-4 pb-3">
                                                    <label class="form-label">Hora início ala</label>
                                                    <input type="time" class="form-control" id="bi_hora_inicio_ala" name="bi_hora_inicio_ala" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grade de Brigadistas -->
                                        <div class="col-12 col-md-6">
                                            <h6 class="pb-2"><i class="fas fa-list"></i> Grade de Brigadistas</h6>
                                            <div class="row col-12 bg-light py-2 px-2">
                                                <div class="row bi_divCamposEscolherBrigadista">
                                                    <div class="form-group col-8 col-md-8 pb-3">
                                                        <label class="form-label">Brigadista</label>
                                                        <select class="select2 form-control" name="bi_grade_funcionario_id" id="bi_grade_funcionario_id">
                                                            <option value="">Selecione...</option>
                                                            @foreach ($funcionarios as $key => $funcionario)
                                                                @if($funcionario['funcao_id'] == 1)
                                                                    <option value="{{ $funcionario['id'] }}">{{ $funcionario['name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" id="bi_grade_funcionario_nome" name="bi_grade_funcionario_nome">
                                                    </div>
                                                    <div class="form-group col-2 col-md-2 pb-3">
                                                        <label class="form-label">Ala</label>
                                                        <select class="form-control" name="bi_grade_ala" id="bi_grade_ala">
                                                            <option value="1">1</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-2 col-md-2 pb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="row">
                                                            <div class="col-12" id="bi_divGradeFuncionarioAdicionar" style="display: none;">
                                                                <button type="button" class="btn btn-success" id="bi_funcionario_adicionar" name="bi_funcionario_adicionar" title="Adicionar Funcionário na Grade"><i class="fas fa-check"></i></button>
                                                            </div>
                                                            <div class="col-12" id="bi_divGradeFuncionarioRetirar" style="display: none;">
                                                                <button type="button" class="btn btn-danger" id="bi_funcionario_retirar" name="bi_funcionario_retirar" title="Retirar Funcionário da Grade"><i class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-bordered border-primary table-striped">
                                                        <thead class="table-dark">
                                                        <tr>
                                                            <th colspan="2" class="text-start">BRIGADISTAS<span class="text-end float-end" id="bi_funcionario_total">Total: 0/0</span></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="bi_tbody_grade_brigadistas"></tbody>
                                                    </table>
                                                </div>

                                                <!-- Campos hiddens para salvar na tabela servicos_funcionarios -->
                                                <div id="bi_funcionario_hiddens"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Serviço Tipo 2: MANUTENÇÃO -->
                                <div class="row pt-4 d-none" id="divSTManutencao">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-address-card"></i> Manutenção</h5>
                                    <div class="row">
                                        <!-- Informações Gerais -->
                                        <div class="col-12 col-md-6">
                                            <h6 class="pb-2"><i class="fas fa-clipboard-list"></i> Informações Gerais</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Serviço Tipo 3: VISITA TÉCNICA -->
                                <div class="row pt-4 d-none" id="divSTVisitaTecnica">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-address-card"></i> Visita Técnica</h5>
                                    <div class="row">
                                        <!-- Informações Gerais -->
                                        <div class="col-12 col-md-6">
                                            <h6 class="pb-2"><i class="fas fa-clipboard-list"></i> Informações Gerais</h6>
                                        </div>
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

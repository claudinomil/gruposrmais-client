<!-- Formulario -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons crudFormButtons1">
                        <!-- update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                            <x-button-crud op="5" class="crudConfirmarOperacao" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" class="crudCancelarOperacao" />
                    </div>
                    <div class="modal-buttons crudFormButtons2">
                        <!-- edit -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                            <x-button-crud op="2" class="crudAlterarRegistro" />
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

                                    <!-- Alert para marcar Serviço como Finalizado -->
                                    <div class="alert alert-success mx-2" role="alert">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-4">
                                                <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                    <input class="form-check-input" type="checkbox" id="servico_executado" name="servico_executado">
                                                    <label class="form-label" for="servico_executado" id="labelServicoExecutado"></label>
                                                    <hr class="mt-0 mb-0" id="hrServicoExecutado">
                                                    <span class="small" id="spanServicoExecutado"></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <label class="form-label">Data da Execução</label>
                                                <input type="text" class="form-control mask_date" id="executado_data" name="executado_data" disabled="true" readonly="true">
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <label class="form-label">Funcionário que Executou</label>
                                                <input type="text" class="form-control" id="executado_user_funcionario" name="executado_user_funcionario" disabled="true" readonly="true">
                                                <input type="text" id="executado_user_id" name="executado_user_id" disabled="true" readonly="true">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row pt-4" id="divClassificacaoDecreto">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-clipboard"></i> Classificação (DECRETO Nº 42, DE 17 DE DEZEMBRO DE 2018)</h5>

                                    <div class="row pt-3 ps-4" id="divClassificacaoDecretoInformacoesGerais">
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

                                    <input type="hidden" id="projeto_scip" name="projeto_scip" value="0">
                                    <div class="row pt-3 ps-4" id="divProjetoScip">
                                        <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Projeto SCIP</h6>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" id="projeto_scip_numero" name="projeto_scip_numero">
                                        </div>

                                        <div class="form-group col-12 col-md-6 pb-3">
                                            <label class="form-label">Arquivo PDF</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" class="form-control input_projeto_scip_pdf" name="projeto_scip_pdf" id="projeto_scip_pdf">
                                                    <button type="button" class="input-group-text btn_projeto_scip_pdf_upload" title="Fazer Upload do Documento"><i class="fa fa-upload font-size-14 text-dark"></i></button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="input-group-text btn_projeto_scip_pdf_view" title="Visualizar Documento"><i class='fa fa-file-pdf font-size-18 text-primary'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="laudo_exigencias" name="laudo_exigencias" value="0">
                                    <div class="row pt-3 ps-4" id="divLaudoExigencias">
                                        <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Laudo de Exigências</h6>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" id="laudo_exigencias_numero" name="laudo_exigencias_numero">
                                        </div>
                                        <div class="form-group col-6 col-md-2 pb-3">
                                            <label class="form-label">Emissão</label>
                                            <input type="text" class="form-control mask_date" id="laudo_exigencias_data_emissao" name="laudo_exigencias_data_emissao">
                                        </div>
                                        <div class="form-group col-6 col-md-2 pb-3">
                                            <label class="form-label">Vencimento</label>
                                            <input type="text" class="form-control mask_date" id="laudo_exigencias_data_vencimento" name="laudo_exigencias_data_vencimento">
                                        </div>
                                        <div class="form-group col-12 col-md-5 pb-3">
                                            <label class="form-label">Arquivo PDF</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" class="form-control input_laudo_exigencias_pdf" name="laudo_exigencias_pdf" id="laudo_exigencias_pdf">
                                                    <button type="button" class="input-group-text btn_laudo_exigencias_pdf_upload" title="Fazer Upload do Documento"><i class="fa fa-upload font-size-14 text-dark"></i></button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="input-group-text btn_laudo_exigencias_pdf_view" title="Visualizar Documento"><i class='fa fa-file-pdf font-size-18 text-primary'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="certificado_aprovacao" name="certificado_aprovacao" value="0">
                                    <div class="row pt-3 ps-4" id="divCertificadoAprovacao">
                                        <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação</h6>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" id="certificado_aprovacao_numero" name="certificado_aprovacao_numero">
                                        </div>
                                        <div class="form-group col-12 col-md-6 pb-3">
                                            <label class="form-label">Arquivo PDF</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" class="form-control input_certificado_aprovacao_pdf" name="certificado_aprovacao_pdf" id="certificado_aprovacao_pdf">
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_pdf_upload" title="Fazer Upload do Documento"><i class="fa fa-upload font-size-14 text-dark"></i></button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_pdf_view" title="Visualizar Documento"><i class='fa fa-file-pdf font-size-18 text-primary'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="certificado_aprovacao_simplificado" name="certificado_aprovacao_simplificado" value="0">
                                    <div class="row pt-3 ps-4" id="divCertificadoAprovacaoSimplificado">
                                        <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação Simplificado</h6>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" id="certificado_aprovacao_simplificado_numero" name="certificado_aprovacao_simplificado_numero">
                                        </div>
                                        <div class="form-group col-12 col-md-6 pb-3">
                                            <label class="form-label">Arquivo PDF</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" class="form-control input_certificado_aprovacao_simplificado_pdf" name="certificado_aprovacao_simplificado_pdf" id="certificado_aprovacao_simplificado_pdf">
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_simplificado_pdf_upload" title="Fazer Upload do Documento"><i class="fa fa-upload font-size-14 text-dark"></i></button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_simplificado_pdf_view" title="Visualizar Documento"><i class='fa fa-file-pdf font-size-18 text-primary'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="certificado_aprovacao_assistido" name="certificado_aprovacao_assistido" value="0">
                                    <div class="row pt-3 ps-4" id="divCertificadoAprovacaoAssistido">
                                        <h6 class="pb-3 text-success"><i class="fa fa-list"></i> Certificado de Aprovação Assistido</h6>
                                        <div class="form-group col-12 col-md-3 pb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" id="certificado_aprovacao_assistido_numero" name="certificado_aprovacao_assistido_numero">
                                        </div>
                                        <div class="form-group col-12 col-md-6 pb-3">
                                            <label class="form-label">Arquivo PDF</label>
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" class="form-control input_certificado_aprovacao_assistido_pdf" name="certificado_aprovacao_assistido_pdf" id="certificado_aprovacao_assistido_pdf">
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_assistido_pdf_upload" title="Fazer Upload do Documento"><i class="fa fa-upload font-size-14 text-dark"></i></button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="input-group-text btn_certificado_aprovacao_assistido_pdf_view" title="Visualizar Documento"><i class='fa fa-file-pdf font-size-18 text-primary'></i></button>
                                                </div>
                                            </div>
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

                    <div class="modal-buttons crudFormButtons1">
                        <!-- update -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Confirnar Operação -->
                            <x-button-crud op="5" class="crudConfirmarOperacao" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" class="crudCancelarOperacao" />
                    </div>
                    <div class="modal-buttons crudFormButtons2">
                        <!-- edit -->
                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_edit'], $userLoggedPermissoes))
                            <!-- Botão Alterar Registro -->
                            <x-button-crud op="2" class="crudAlterarRegistro" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" class="crudCancelarOperacao" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

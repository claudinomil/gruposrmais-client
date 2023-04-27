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

                            <!-- Botão Montar Visita -->
                            <button type="button" class="btn btn-info waves-effect btn-label waves-light" data-bs-toggle="modal" data-bs-target="#modalMontarVisita" data-bs-placement="top" title="Montar Visita Técnica"><i class="fa fa-layer-group label-icon"></i> Montar Visita</button>
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
                        <button type="button" class="btn btn-warning waves-effect btn-label waves-light" data-bs-toggle="modal" data-bs-target=".modal-visita_tecnica" onclick="visita_tecnicaExtraData();" data-id="0"><i class="bx bx-photo-album label-icon"></i> Extra</button>

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
                            <input type="hidden" id="user_id" name="user_id" value="">

                            <div class="row mt-4">
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-list"></i> Informa&ccedil;&otilde;es Gerais</h5>
                                    <div class="form-group col-12 col-md-10 pb-3">
                                        <label class="form-label">Cliente</label>
                                        <select class="select2 form-control" name="cliente_id" id="cliente_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($clientes as $key => $cliente)
                                                <option value="{{ $cliente['id'] }}">{{ $cliente['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Data Visita</label>
                                        <input type="text" class="form-control mask_date" id="data_visita" name="data_visita" value="{{date('d/m/Y')}}" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Número Pavimentos</label>
                                        <input type="number" class="form-control" id="numero_pavimentos" name="numero_pavimentos" step="1" value="1" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Altura</label>
                                        <input type="text" class="form-control mask_money" id="altura" name="altura" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">ATC (m²)</label>
                                        <input type="text" class="form-control mask_money" id="area_total_construida" name="area_total_construida" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Lotação</label>
                                        <input type="number" class="form-control" id="lotacao" name="lotacao" step="1" value="1" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Carga Incêndio</label>
                                        <input type="number" class="form-control" id="carga_incendio" name="carga_incendio" step="1" value="1" required="required">
                                    </div>
                                    <div class="form-group col-6 col-md-2 pb-3">
                                        <label class="form-label">Risco Incêndio</label>
                                        <select class="select2 form-control" name="incendio_risco_id" id="incendio_risco_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($incendio_riscos as $key => $incendio_risco)
                                                <option value="{{ $incendio_risco['id'] }}">{{ $incendio_risco['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-12 pb-3">
                                        <label class="form-label">Classificação Edificação</label>
                                        <select class="select2 form-control" name="edificacao_classificacao_id" id="edificacao_classificacao_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($edificacao_classificacoes as $key => $edificacao_classificacao)
                                                <option value="{{ $edificacao_classificacao['id'] }}"
                                                        data-grupo="{{ $edificacao_classificacao['grupo'] }}"
                                                        data-ocupacao-uso="{{ $edificacao_classificacao['ocupacao_uso'] }}"
                                                        data-divisao="{{ $edificacao_classificacao['divisao'] }}"
                                                        data-descricao="{{ $edificacao_classificacao['descricao'] }}"
                                                >{{ $edificacao_classificacao['divisao']. ' | '.$edificacao_classificacao['ocupacao_uso']. ' | '.$edificacao_classificacao['descricao'] }}</option>
                                            @endforeach

                                        </select>
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
                                <div class="row pt-4">
                                    <h5 class="pb-2 text-primary"><i class="fa fa-list"></i> Laudo de Exigências</h5>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label col-12">&nbsp;</label>
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light col-12" id="btnLaudoExigencias">
                                            <i class="bx bx-block font-size-16 align-middle me-2" id="btnLaudoExigenciasIcon"></i> Laudo de Exigências
                                        </button>
                                        <input type="hidden" id="laudo_exigencias" name="laudo_exigencias" value="0">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" id="laudo_exigencias_numero" name="laudo_exigencias_numero">
                                    </div>
                                    <div class="form-group col-6 col-md-3 pb-3">
                                        <label class="form-label">Emissão</label>
                                        <input type="text" class="form-control mask_date" id="laudo_exigencias_data_emissao" name="laudo_exigencias_data_emissao">
                                    </div>
                                    <div class="form-group col-6 col-md-3 pb-3">
                                        <label class="form-label">Vencimento</label>
                                        <input type="text" class="form-control mask_date" id="laudo_exigencias_data_vencimento" name="laudo_exigencias_data_vencimento">
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-2 text-primary"><i class="fa fa-list"></i> Certificado de Aprovação</h5>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label col-12">&nbsp;</label>
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light col-12" id="btnCertificadoAprovacao">
                                            <i class="bx bx-block font-size-16 align-middle me-2" id="btnCertificadoAprovacaoIcon"></i> Certificado de Aprovação
                                        </button>
                                        <input type="hidden" id="certificado_aprovacao" name="certificado_aprovacao" value="0">
                                    </div>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" id="certificado_aprovacao_numero" name="certificado_aprovacao_numero">
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-2 text-primary"><i class="fa fa-list"></i> Medidas de Segurança</h5>

                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light col-12" id="btnMedidasSegurancaPadrao">
                                            <i class="fa fa-list-ul font-size-16 align-middle me-2"></i> Padrão
                                        </button>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light col-12" id="btnMedidasSegurancaCustomizada">
                                            <i class="fa fa-list-ol font-size-16 align-middle me-2"></i> Padrão
                                        </button>
                                    </div>

                                    <div class="divMedidasSeguranca"></div>



                                        <h6 class="pb-2 text-success"><i class="fa fa-list"></i> Pavimento 1</h6>

                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label col-12">&nbsp;</label>
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light col-12">
                                                    <i class="bx bx-block font-size-16 align-middle me-2"></i> APARELHO EXTINTOR
                                                </button>
                                                <input type="hidden" id="APARELHO_EXTINTOR" name="APARELHO_EXTINTOR" value="0">
                                            </div>
                                            <div class="form-group col-12 col-md-2 pb-3">
                                                <label class="form-label">Quantidade</label>
                                                <input type="number" class="form-control" id="APARELHO_EXTINTOR_quantidade" name="APARELHO_EXTINTOR_quantidade">
                                            </div>
                                            <div class="form-group col-12 col-md-7 pb-3">
                                                <label class="form-label">Observações</label>
                                                <textarea class="form-control" id="APARELHO_EXTINTOR_observacoes" name="APARELHO_EXTINTOR_observacoes"></textarea>
                                            </div>

                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label col-12">&nbsp;</label>
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light col-12">
                                                    <i class="bx bx-block font-size-16 align-middle me-2"></i> SAÍDAS DE EMERGÊNCIA
                                                </button>
                                                <input type="hidden" id="SAÍDAS DE EMERGÊNCIA" name="SAÍDAS DE EMERGÊNCIA" value="0">
                                            </div>
                                            <div class="form-group col-12 col-md-2 pb-3">
                                                <label class="form-label">Quantidade</label>
                                                <input type="number" class="form-control" id="SAÍDAS DE EMERGÊNCIA_quantidade" name="SAÍDAS DE EMERGÊNCIA_quantidade">
                                            </div>
                                            <div class="form-group col-12 col-md-7 pb-3">
                                                <label class="form-label">Observações</label>
                                                <textarea class="form-control" id="SAÍDAS DE EMERGÊNCIA_observacoes" name="SAÍDAS DE EMERGÊNCIA_observacoes"></textarea>
                                            </div>


                                            <div class="form-group col-12 col-md-3 pb-3">
                                                <label class="form-label col-12">&nbsp;</label>
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light col-12">
                                                    <i class="bx bx-block font-size-16 align-middle me-2"></i> SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO
                                                </button>
                                                <input type="hidden" id="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO" name="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO" value="0">
                                            </div>
                                            <div class="form-group col-12 col-md-2 pb-3">
                                                <label class="form-label">Quantidade</label>
                                                <input type="number" class="form-control" id="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO_quantidade" name="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO_quantidade">
                                            </div>
                                            <div class="form-group col-12 col-md-7 pb-3">
                                                <label class="form-label">Observações</label>
                                                <textarea class="form-control" id="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO_observacoes" name="SINALIZAÇÃO DE SEGURANÇA CONTRA INCÊNDIO E PÂNICO_observacoes"></textarea>
                                            </div>


                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Montar Visita Técnica -->
    <div class="modal fade" id="modalMontarVisita" tabindex="-1" role="dialog" aria-labelledby="modalMontarVisitaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMontarVisitaTitle">Montar Visita Técnica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row pt-3">
                        <h6 class="pb-2 text-primary"><i class="fa fa-arrow-right"></i> Documentos</h6>
                        <div class="col-12 col-md-6 pb-3">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="mvt_laudo_exigencias" name="mvt_laudo_exigencias">
                                <label class="form-check-label" for="mvt_laudo_exigencias">Laudo de Exigências</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 pb-3">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="mvt_certificado_aprovacao" name="mvt_certificado_aprovacao">
                                <label class="form-check-label" for="mvt_certificado_aprovacao">Certificado de Aprovação</label>
                            </div>
                        </div>
                    </div>

                    @for($pavimento=1; $pavimento<=50; $pavimento++)
                        <div class="row pt-3" style="display:none;" id="mvt_divMedidasSeguranca{{$pavimento}}">
                            <h6 class="pb-2 text-primary"><i class="fa fa-arrow-right"></i> Medidas de Segurança - Pavimento {{$pavimento}}</h6>

                            @foreach ($seguranca_medidas as $key => $seguranca_medida)
                                <div class="col-12 col-md-12 pb-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="mvt_seguranca_medida_{{$pavimento.'_'.$seguranca_medida['id']}}" name="mvt_seguranca_medida_{{$pavimento.'_'.$seguranca_medida['id']}}">
                                        <label class="form-check-label" for="mvt_seguranca_medida_{{$pavimento.'_'.$seguranca_medida['id']}}">{{$seguranca_medida['name']}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endfor

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>

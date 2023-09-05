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

                        @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_list'], $userLoggedPermissoes))
                            <!-- Botão PropostaPDF -->
                            <button type="button" class="btn btn-info waves-effect btn-label waves-light gerarPdfProposta" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Proposta em PDF"><i class="fas fa-file-pdf label-icon"></i> PDF</button>
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
                                    <h5 class="pb-4 text-primary"><i class="fas fa-list"></i> Cabeçalho</h5>
                                    <div class="form-group col-12 col-md-3 pb-3">
                                        <label class="form-label">Data</label>
                                        <input type="text" class="form-control mask_date" id="data_proposta" name="data_proposta">
                                    </div>
                                    <div class="form-group col-12 col-md-5 pb-3">
                                        <label class="form-label">Data Extenso</label>
                                        <input type="text" class="form-control" id="data_proposta_extenso" name="data_proposta_extenso" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" id="numero_proposta" name="numero_proposta" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Ano</label>
                                        <input type="text" class="form-control" id="ano_proposta" name="ano_proposta" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Cliente</label>
                                        <select class="select2 form-control" name="cliente_id" id="cliente_id" required="required">
                                            <option value="">Selecione...</option>

                                            @foreach ($clientes as $key => $cliente)
                                                <option value="{{ $cliente['id'] }}">{{ $cliente['name'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Nome Cliente</label>
                                        <input type="text" class="form-control text-uppercase" id="cliente_nome" name="cliente_nome">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Logradouro Cliente</label>
                                        <input type="text" class="form-control text-uppercase" id="cliente_logradouro" name="cliente_logradouro">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Bairro Cliente</label>
                                        <input type="text" class="form-control text-uppercase" id="cliente_bairro" name="cliente_bairro">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">Cidade Cliente</label>
                                        <input type="text" class="form-control text-uppercase" id="cliente_cidade" name="cliente_cidade">
                                    </div>
                                    <div class="form-group col-12 col-md-4 pb-3">
                                        <label class="form-label">A/C</label>
                                        <input type="text" class="form-control text-uppercase" id="aos_cuidados" name="aos_cuidados">
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-table"></i> Serviços</h5>
                                    <div class="form-group col-12 col-md-12 pb-3">
                                        <input type="text" class="form-control" id="texto_acima_tabela_servico" name="texto_acima_tabela_servico" value="Apresentamos abaixo, planilha dos valores para execução dos serviços de manutenção dos equipamentos preventivos:">
                                    </div>
                                    <div class="row col-12">
                                        <div class="form-group col-12 col-md-6 pb-3">
                                            <label class="form-label">Serviço</label>
                                            <select class="select2 form-control" name="ts_servico_id" id="ts_servico_id">
                                                <option value="">Selecione...</option>

                                                @foreach ($servicos as $key => $servico)
                                                    <option value="{{ $servico['id'] }}">{{ $servico['name'] }}</option>
                                                @endforeach

                                            </select>
                                            <input type="hidden" id="ts_servico_nome" name="ts_servico_nome">
                                        </div>
                                        <div class="form-group col-12 col-md-2 pb-3">
                                            <label class="form-label text-end">Valor</label>
                                            <input type="text" class="form-control text-end mask_money" id="ts_servico_valor" name="ts_servico_valor">
                                        </div>
                                        <div class="form-group col-12 col-md-2 pb-3">
                                            <label class="form-label">Qtd</label>
                                            <input type="number" class="form-control" id="ts_servico_qtd" name="ts_servico_qtd" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        </div>
                                        <div class="form-group col-12 col-md-2 pb-3">
                                            <label class="form-label">Opções</label>
                                            <div class="row">
                                                <div class="col-4" id="ts_servico_adicionar_div" style="display: none;">
                                                    <button type="button" class="btn btn-success" id="ts_servico_adicionar" name="ts_servico_adicionar" title="Adicionar Serviço na Grade"><i class="fas fa-check"></i></button>
                                                </div>
                                                <div class="col-4" id="ts_servico_atualizar_div" style="display: none;">
                                                    <button type="button" class="btn btn-primary" id="ts_servico_atualizar" name="ts_servico_atualizar" title="Atualizar Serviço na Grade"><i class="fas fa-edit"></i></button>
                                                </div>
                                                <div class="col-4" id="ts_servico_retirar_div" style="display: none;">
                                                    <button type="button" class="btn btn-danger" id="ts_servico_retirar" name="ts_servico_retirar" title="Retirar Serviço da Grade"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">ITEM</th>
                                                    <th>DESCRIÇÃO DOS EQUIPAMENTOS PREVENTIVOS</th>
                                                    <th class="text-end">VALOR UNITÁRIO</th>
                                                    <th class="text-center">QUANTIDADE</th>
                                                    <th class="text-end">VALOR TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ts_servico_grade">
                                                <!--
                                                MODELO DE LINHA DA GRADEDE SERVIÇOS
                                                <tr>
                                                    <th class="text-center" scope="row">1</th>
                                                    <td>RECARGA DE EXTINTOR DE INCÊNDIO DO TIPO CO2 - 6KG</td>
                                                    <td class="text-end">R$ 50,00</td>
                                                    <td class="text-center">24</td>
                                                    <td class="text-end">R$ 1.200,00</td>
                                                </tr>
                                                -->

                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th class="text-end">VALOR GLOBAL</th>
                                                    <th class="text-center">R$</th>
                                                    <th class="text-end" id="ts_servico_valor_global">R$ 0,00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Campos hiddens para salvar na tabela propostas_servicos -->
                                    <div id="ts_servico_hiddens"></div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-dollar-sign"></i> Do Desconto</h5>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Porcentagem (%)</label>
                                        <input type="number" step=".01" class="form-control mask_numero_ponto" id="porcentagem_desconto" name="porcentagem_desconto" onchange="atualizarServicoGrade(0)" onblur="atualizarServicoGrade(0)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Valor</label>
                                        <input type="text" class="form-control mask_money text-end" id="valor_desconto" name="valor_desconto" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-8 pb-3">
                                        <label class="form-label">Extenso</label>
                                        <input type="text" class="form-control" id="valor_desconto_extenso" name="valor_desconto_extenso" readonly>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-dollar-sign"></i> Do Valor Total</h5>
                                    <div class="form-group col-12 col-md-2 pb-3">
                                        <label class="form-label">Valor</label>
                                        <input type="text" class="form-control mask_money text-end" id="valor_total" name="valor_total" readonly>
                                    </div>
                                    <div class="form-group col-12 col-md-10 pb-3">
                                        <label class="form-label">Extenso</label>
                                        <input type="text" class="form-control" id="valor_total_extenso" name="valor_total_extenso" readonly>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-money-check-alt"></i> Da Forma e Condições de Pagamento</h5>
                                    <div class="form-group col-12 col-md-12 pb-3">
                                        <label class="form-label">Forma de Pagamento</label>
                                        <input type="text" class="form-control" id="forma_pagamento" name="forma_pagamento" value="O pagamento será realizado ao término dos serviços.">
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <h5 class="pb-4 text-primary"><i class="fas fa-tasks"></i> Das Generalidades</h5>
                                    <div class="form-group col-12 col-md-12 pb-3">
                                        <label class="form-label">Generalidades:</label>
                                        <input type="text" class="form-control" id="paragrafo_1" name="paragrafo_1" value="Os serviços extras que não constam no edita em questão, só serão executados com autorização expressa dos responsáveis pela edificação, mediante aprovação de novo orçamento.">
                                        <input type="text" class="form-control" id="paragrafo_2" name="paragrafo_2" value="Esta proposta contempla, manutenção, recargas, troca de peças, pinturas e retestes dos cilindros.">
                                        <input type="text" class="form-control" id="paragrafo_3" name="paragrafo_3" value="Esta proposta tem validade de10(dez) dias.">
                                        <input type="text" class="form-control" id="paragrafo_4" name="paragrafo_4" value="Credenciamentos: CREA RJ 2019201827, INMETRO 000031/2020 e CBMERJ 02-408.">
                                        <input type="text" class="form-control" id="paragrafo_5" name="paragrafo_5" value="Marcos Paulo Machado: (21) 99225-2656.">
                                        <input type="text" class="form-control" id="paragrafo_6" name="paragrafo_6">
                                        <input type="text" class="form-control" id="paragrafo_7" name="paragrafo_7">
                                        <input type="text" class="form-control" id="paragrafo_8" name="paragrafo_8">
                                        <input type="text" class="form-control" id="paragrafo_9" name="paragrafo_9">
                                        <input type="text" class="form-control" id="paragrafo_10" name="paragrafo_10">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>

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

                    @if(\App\Facades\Permissoes::permissao([$ajaxPrefixPermissaoSubmodulo.'_list'], $userLoggedPermissoes))
                        <!-- Botão PropostaPDF -->
                            <button type="button" class="btn btn-info waves-effect btn-label waves-light gerarPdfProposta" data-bs-toggle="tooltip" data-bs-placement="top" data-id="0" title="Proposta em PDF"><i class="fas fa-file-pdf label-icon"></i> PDF</button>
                    @endif

                    <!-- Botão Cancelar Operação -->
                        <button type="button" class="btn btn-secondary waves-effect btn-label waves-light crudFormCancelOperacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Operação"><i class="fa fa-arrow-left label-icon"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

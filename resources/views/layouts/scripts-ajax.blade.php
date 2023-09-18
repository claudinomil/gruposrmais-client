@if(isset($ajaxPrefixPermissaoSubmodulo))
    <!-- Script para CRUD Ajax -->
    <!-- Alguns Submódulos não tem CRUD, então entra na exceção -->
    <!-- Submódulos que não vão usar: Dashboards, Logos -->
    @if($ajaxPrefixPermissaoSubmodulo != 'dashboards' and $ajaxPrefixPermissaoSubmodulo != 'logos' and $ajaxPrefixPermissaoSubmodulo != 'Mobile')
        {{-- Script para CRUD Ajax --}}
        <script type="text/javascript">
            $(function () {
                //Header
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });

                //Table
                tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');

                function tableContent(route) {
                    $('.datatable-crud-ajax').DataTable({
                        language: {
                            pageLength: {
                                '-1': 'Mostrar todos os registros',
                                '_': 'Mostrar %d registros'
                            },
                            lengthMenu: 'Exibir _MENU_ resultados por página',
                            emptyTable: 'Nenhum registro encontrado',
                            info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
                            infoEmpty: 'Mostrando 0 até 0 de 0 registros',
                            infoFiltered: '(Filtrados de _MAX_ registros)',
                            infoThousands: '.',
                            loadingRecords: 'Carregando...',
                            processing: 'Processando...',
                            zeroRecords: 'Nenhum registro encontrado',
                            search: 'Pesquisar',
                            paginate: {
                                next: 'Próximo',
                                previous: 'Anterior',
                                first: 'Primeiro',
                                last: 'Último'
                            }
                        },
                        bDestroy: true,
                        responsive: true,
                        lengthChange: true,
                        autoWidth: true,
                        order: [],

                        processing: true,
                        serverSide: false,
                        ajax: route,
                        columns: [
                            @foreach($colsFields as $colField)
                                {'data': '{{$colField}}'},
                            @endforeach

                            @if($colActions == 'yes')
                                {'data': 'action'}
                            @endif
                        ]
                    });
                }

                //Search
                $('.crudPesquisarRegistros').click(function () {
                    //Recebendo field/value
                    var field = $('#pesquisar_field').val();
                    var value = $('#pesquisar_value').val();

                    if (field == '' || value == '') {
                        alert('Digite?');
                        return;
                    }

                    tableContent('{{$ajaxPrefixPermissaoSubmodulo}}/search/'+$('#pesquisar_field').val()+'/'+$('#pesquisar_value').val());
                });

                //Create
                $('.crudIncluirRegistro').click(function () {
                    //Passar pelo evento create do controller
                    $.get("{{$ajaxPrefixPermissaoSubmodulo}}/create", function (data) {
                        //Limpar validações
                        $('.is-invalid').removeClass('is-invalid');

                        //Limpar Formulário
                        $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                        $('.select2').val('').trigger('change');

                        //Lendo dados
                        if (data.success) {
                            //Campo hidden frm_operacao
                            $('#frm_operacao').val('create');

                            //Campos do Formulário - disabled true/false
                            $('input').prop('disabled', false);
                            $('textarea').prop('disabled', false);
                            $('select').prop('disabled', false);
                            $('.select2').prop('disabled', false);

                            //Botões do Modal
                            $('.crudFormButtons1').show();
                            $('.crudFormButtons2').hide();

                            //Table Show/Hide
                            $('#crudTable').hide();

                            //Modal Show/Hide
                            $('#crudForm').show();

                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            //Settings'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @if($ajaxPrefixPermissaoSubmodulo == 'notificacoes')
                                $('.fieldsViewEdit').hide();
                                $('.fieldsCreate').show();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'grupos')
                                $('.markUnmarkAll').show();

                                //Desabilitar/Habilitar opções de Show
                                $('.tdShow').hide();

                                //Desabilitar/Habilitar opções de Create/Edit
                                $('.tdCreateEdit').show();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'users')
                                //voltar configurações de campos apos passar pelo edit
                                $('#email').prop('readonly', false);
                                $('#funcionario_id').prop('disabled', false);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'servicos')
                                //voltar configurações de campos apos passar pelo edit
                                $('#name').prop('readonly', false);
                                $('#servico_tipo_id').prop('disabled', false);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'ferramentas')
                                //Esconder botão buscar icones
                                $('#buscarIcones').show();

                                $('#iconView').removeClass();

                                $('.fieldsViewEdit').hide();
                                $('.fieldsCreate').show();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'propostas')
                                limparServicosGrade();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes')
                                //campos checkbox'''''''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.divProjetoScip').show();
                                $('.divLaudoExigencias').show();
                                $('.divCertificadoAprovacao').show();
                                $('.divCertificadoAprovacaoSimplificado').show();
                                $('.divCertificadoAprovacaoAssistido').show();

                                $('#projeto_scip').attr('checked', false);
                                $('#laudo_exigencias').attr('checked', false);
                                $('#certificado_aprovacao').attr('checked', false);
                                $('#certificado_aprovacao_simplificado').attr('checked', false);
                                $('#certificado_aprovacao_assistido').attr('checked', false);
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Deixar todos os checkbox de Medidas de Segurança'''''''''''''''''''
                                $('.divSegurancaMedida').show();
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //desmarcar checkbox'''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.cbSegurancaMedida').attr('checked', false);
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                pavimentosShowHide();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'funcionarios')
                                //Setando campo nacionalidade_id como Brasileira
                                $('#nacionalidade_id').val('3').trigger('change');

                                //Funcionario Documentos
                                $('#tbodyDocumentoUpload').html('');

                                //Display divArquivosPdf
                                $('#divArquivosPdf').hide();
                                $('#divArquivosPdfUpload').hide();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                                //Brigada de Incêndio'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                                bi_limparGradeBrigadistas();
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        } else if (data.error_permissao) {
                            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                        } else {
                            alert('Erro interno');
                        }
                    });
                });

                //View
                $('body').on('click', '.crudVisualizarRegistro', function () {
                    //Campo hidden registro_id
                    $('#registro_id').val($(this).data('id'));

                    //Buscar dados do Registro
                    $.get("{{$ajaxPrefixPermissaoSubmodulo}}/"+$('#registro_id').val(), function (data) {
                        //Limpar validações
                        $('.is-invalid').removeClass('is-invalid');

                        //Limpar Formulário
                        $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                        $('.select2').val('').trigger('change');

                        //Lendo dados
                        if (data.success) {
                            //preencher formulário
                            @foreach($ajaxNamesFieldsSubmodulo as $field)
                                @if($field == 'id')
                                    $('#registro_id').val(data.success.id);
                                @else
                                    if ($('#{{$field}}').hasClass('select2')) {
                                        $('#{{$field}}').val(data.success['{{$field}}']).trigger('change');
                                    } else {
                                        $('#{{$field}}').val(data.success['{{$field}}']);
                                    }
                                @endif
                            @endforeach

                            //Campo hidden frm_operacao
                            $('#frm_operacao').val('view');

                            //Campos do Formulário - disabled true/false
                            $('input').prop('disabled', true);
                            $('textarea').prop('disabled', true);
                            $('select').prop('disabled', true);
                            $('.select2').prop('disabled', true);

                            //Campos do Formulário - disabled true/false (Campos Padrões)
                            $('#pesquisar_field').prop('disabled', false);
                            $('#pesquisar_value').prop('disabled', false);
                            $('.fildFilterTable').prop('disabled', false);
                            $('.fildLengthTable').prop('disabled', false);

                            //Botões do Modal
                            $('.crudFormButtons1').hide();
                            $('.crudFormButtons2').show();

                            //Table Show/Hide
                            $('#crudTable').hide();

                            //Modal Show/Hide
                            $('#crudForm').show();

                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            //Settings'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @if($ajaxPrefixPermissaoSubmodulo == 'notificacoes')
                                $('.fieldsViewEdit').show();
                                $('.fieldsCreate').hide();

                                $('#fieldDate').val(data.success['date']);
                                $('#fieldTime').val(data.success['time']);
                                $('#fieldUserName').val(data.success['userName']);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'grupos')
                                $('.markUnmarkAll').hide();

                                //Desabilitar/Habilitar opções de Show
                                $.each(data.success, function(i, item) {
                                    $('.show_'+i).show();
                                });

                                //Desabilitar/Habilitar opções de Create/Edit
                                $('.tdCreateEdit').hide();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'ferramentas')
                                //Esconder botão buscar icones
                                $('#buscarIcones').hide();

                                $('#iconView').removeClass();
                                $('#iconView').addClass(data.success['icon']);

                                $('.fieldsViewEdit').show();
                                $('.fieldsCreate').hide();
                                $('#fieldUserName').val(data.success['userName']);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'propostas')
                                proposta_servicos = data.success['proposta_servicos'];

                                limparServicosGrade();

                                $.each(proposta_servicos, function(i, item) {
                                    //Dados para preenchera linha da grade
                                    $('#ts_servico_id').val(item.servico_id);
                                    $('#ts_servico_nome').val(item.servico_nome);
                                    $('#ts_servico_valor').val(float2moeda(item.servico_valor));
                                    $('#ts_servico_qtd').val(item.servico_quantidade);

                                    atualizarServicoGrade(1);
                                });
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes')
                                //campos checkbox'''''''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.divProjetoScip').hide();
                                $('.divLaudoExigencias').hide();
                                $('.divCertificadoAprovacao').hide();
                                $('.divCertificadoAprovacaoSimplificado').hide();
                                $('.divCertificadoAprovacaoAssistido').hide();

                                $('#projeto_scip').attr('checked', false);
                                $('#laudo_exigencias').attr('checked', false);
                                $('#certificado_aprovacao').attr('checked', false);
                                $('#certificado_aprovacao_simplificado').attr('checked', false);
                                $('#certificado_aprovacao_assistido').attr('checked', false);

                                if (data.success['projeto_scip'] == 1) {
                                    $('#projeto_scip').attr('checked', true);
                                    $('.divProjetoScip').show();
                                }
                                if (data.success['laudo_exigencias'] == 1) {
                                    $('#laudo_exigencias').attr('checked', true);
                                    $('.divLaudoExigencias').show();
                                }
                                if (data.success['certificado_aprovacao'] == 1) {
                                    $('#certificado_aprovacao').attr('checked', true);
                                    $('.divCertificadoAprovacao').show();
                                }
                                if (data.success['certificado_aprovacao_simplificado'] == 1) {
                                    $('#certificado_aprovacao_simplificado').attr('checked', true);
                                    $('.divCertificadoAprovacaoSimplificado').show();
                                }
                                if (data.success['certificado_aprovacao_assistido'] == 1) {
                                    $('#certificado_aprovacao_assistido').attr('checked', true);
                                    $('.divCertificadoAprovacaoAssistido').show();
                                }
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //desmarcar checkbox'''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.cbSegurancaMedida').attr('checked', false);
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Hide em todos os checkbox de Medidas de Segurança'''''''''''''''''''
                                $('.divSegurancaMedida').hide();
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //varrer os checkbox''''''''''''''''''''''''''''''''''''''''''''''''''
                                cliente_seguranca_medidas = data.success['cliente_seguranca_medidas'];

                                $.each(cliente_seguranca_medidas, function(i, item) {
                                    //marcar como checado
                                    $('#seguranca_medida_'+item.pavimento+'_'+item.seguranca_medida_id).attr('checked', true);

                                    //Outros campos
                                    $('#quantidade_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.quantidade);
                                    $('#tipo_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.tipo);
                                    $('#observacao_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.observacao);

                                    //dar show
                                    $('.divSegurancaMedida'+item.pavimento+item.seguranca_medida_id).show();
                                });
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                pavimentosShowHide();
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicas')
                                //Verificar botões''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                                //Se servico_status_id for igual a 1(EXECUTADO) : Somente Visualização
                                if (data.success.clientes_servicos_servico.servico_status_id == 1) {
                                    $('.crudFormButtons2 .crudAlterarRegistro').hide();
                                } else {
                                    $('.crudFormButtons2 .crudAlterarRegistro').show();
                                }
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                vt_configurarFormulario(data.success);
                                vt_preencherFormulario(data.success);

                                //Alert para marcar Serviço como Finalizado'''''''''''''''''''''''''''''''''''''''''''''
                                $('#hrServicoExecutado').hide();
                                $('#spanServicoExecutado').hide();

                                $('#executado_data').val(data.success.executado_data);
                                $('#executado_user_funcionario').val(data.success.executado_user_funcionario);
                                $('#executado_user_id').val(data.success.executado_user_id);

                                if (data.success.executado_data == '' || data.success.executado_data === null) {
                                    $('#servico_executado').prop('checked', false);
                                    $('#labelServicoExecutado').html('Visita não Finalizada');
                                } else {
                                    $('#servico_executado').prop('checked', true);
                                    $('#labelServicoExecutado').html('Visita Finalizada');
                                }
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'brigadas')
                            bi_preencherFormulario(data.success);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'funcionarios')
                                //Display divArquivosPdf
                                $('#divArquivosPdf').show();
                                $('#divArquivosPdfUpload').hide();

                                //FuncionarioDocumentos
                                funcionarioDocumentos = data.success['funcionarioDocumentos'];

                                montar_grade_documentos_funcionario(1);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'users')
                                users_configuracoes = data.success['users_configuracoes'];

                                $.each(users_configuracoes, function(i, item) {
                                    $('#grupo_id_'+item.empresa_id).val(item.grupo_id).trigger('change');
                                    $('#situacao_id_'+item.empresa_id).val(item.situacao_id).trigger('change');
                                    $('#sistema_acesso_id_'+item.empresa_id).val(item.sistema_acesso_id).trigger('change');
                                    $('#layout_mode_'+item.empresa_id).val(item.layout_mode).trigger('change');
                                    $('#layout_style_'+item.empresa_id).val(item.layout_style).trigger('change');
                                });
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                                //Verificar botões''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                                //Se servico_status_id for igual a 1(EXECUTADO) : Somente Visualização
                                if (data.success.servico_status_id == 1) {
                                    $('.crudFormButtons2 .crudAlterarRegistro').hide();
                                    $('.crudFormButtons2 .crudExcluirRegistro').hide();
                                } else {
                                    $('.crudFormButtons2 .crudAlterarRegistro').show();
                                    $('.crudFormButtons2 .crudExcluirRegistro').show();
                                }
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Brigada de Incêndio'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Configuração conforme escala escolhida
                                bi_configuracaoConformeEscala($('#bi_escala_tipo_id').val());

                                //Preencher Grade Brigadistas
                                cliente_servicos_brigadistas = data.success['cliente_servicos_brigadistas'];

                                bi_limparGradeBrigadistas();

                                $.each(cliente_servicos_brigadistas, function(i, item) {
                                    //Dados para preenchera linha da grade
                                    $('#bi_grade_funcionario_id').val(item.funcionario_id);
                                    $('#bi_grade_funcionario_nome').val(item.funcionario_nome);
                                    $('#bi_grade_ala').val(item.ala);

                                    bi_gradeBrigadistasAtualizar(1);
                                });
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        } else if (data.error_not_found) {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
                        } else if (data.error_permissao) {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                        } else {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alert('Erro interno');
                        }
                    });
                });

                //Edit
                $('body').on('click', '.crudAlterarRegistro', function () {
                    //Campo hidden registro_id
                    if ($(this).data('id') != 0) {
                        $('#registro_id').val($(this).data('id'));
                    }

                    //Buscar dados do Registro
                    $.get("{{$ajaxPrefixPermissaoSubmodulo}}/"+$('#registro_id').val()+"/edit", function (data) {
                        //Limpar validações
                        $('.is-invalid').removeClass('is-invalid');

                        //Limpar Formulário
                        $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                        $('.select2').val('').trigger('change');

                        //Lendo dados
                        if (data.success) {
                            //preencher formulário
                            @foreach($ajaxNamesFieldsSubmodulo as $field)
                                @if($field == 'id')
                                    $('#registro_id').val(data.success.id);
                                @else
                                    if ($('#{{$field}}').hasClass('select2')) {
                                        $('#{{$field}}').val(data.success['{{$field}}']).trigger('change');
                                    } else {
                                        $('#{{$field}}').val(data.success['{{$field}}']);
                                    }
                                @endif
                            @endforeach

                            //Campo hidden frm_operacao
                            $('#frm_operacao').val('edit');

                            //Campos do Formulário - disabled true/false
                            $('input').prop('disabled', false);
                            $('textarea').prop('disabled', false);
                            $('select').prop('disabled', false);
                            $('.select2').prop('disabled', false);

                            //Botões do Modal
                            $('.crudFormButtons1').show();
                            $('.crudFormButtons2').hide();

                            //Table Show/Hide
                            $('#crudTable').hide();

                            //Modal Show/Hide
                            $('#crudForm').show();

                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            //Settings'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @if($ajaxPrefixPermissaoSubmodulo == 'notificacoes')
                                $('.fieldsViewEdit').show();
                                $('.fieldsCreate').hide();

                                $('#fieldDate').val(data.success['date']);
                                $('#fieldTime').val(data.success['time']);
                                $('#fieldUserName').val(data.success['userName']);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'grupos')
                                $('.markUnmarkAll').show();

                                //Desabilitar/Habilitar opções de Show
                                $('.tdShow').hide();

                                //Desabilitar/Habilitar opções de Create/Edit
                                $('.tdCreateEdit').show();

                                $.each(data.success, function(i, item) {
                                    $('.create_edit_'+i).prop('checked', true);
                                });
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'users')
                                //Não deixar alterar E-mail pelo submódulo Users
                                $('#email').prop('readonly', true);

                                //Verificar se pode alterar campo funcionario_id
                                var user_operacoes_qtd = data.success['user_operacoes_qtd'];
                                if (user_operacoes_qtd > 0) {$('#funcionario_id').prop('disabled', true);}

                                //User Configurações
                                var users_configuracoes = data.success['users_configuracoes'];

                                $.each(users_configuracoes, function(i, item) {
                                    $('#grupo_id_'+item.empresa_id).val(item.grupo_id).trigger('change');
                                    $('#situacao_id_'+item.empresa_id).val(item.situacao_id).trigger('change');
                                    $('#sistema_acesso_id_'+item.empresa_id).val(item.sistema_acesso_id).trigger('change');
                                    $('#layout_mode_'+item.empresa_id).val(item.layout_mode).trigger('change');
                                    $('#layout_style_'+item.empresa_id).val(item.layout_style).trigger('change');
                                });
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'servicos')
                                //Verificar se pode alterar os campos name e servico_tipo_id - para não afetar outros submódulos
                                var servico_readonly_campos = data.success['servico_readonly_campos'];
                                if (servico_readonly_campos === true) {
                                    $('#name').prop('readonly', true);
                                    $('#servico_tipo_id').prop('disabled', true);
                                }
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'ferramentas')
                                //Esconder botão buscar icones
                                $('#buscarIcones').show();

                                $('#iconView').removeClass();
                                $('#iconView').addClass(data.success['icon']);

                                $('.fieldsViewEdit').show();
                                $('.fieldsCreate').hide();
                                $('#fieldUserName').val(data.success['userName']);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'propostas')
                                proposta_servicos = data.success['proposta_servicos'];

                                limparServicosGrade();

                                $.each(proposta_servicos, function(i, item) {
                                    //Dados para preenchera linha da grade
                                    $('#ts_servico_id').val(item.servico_id);
                                    $('#ts_servico_nome').val(item.servico_nome);
                                    $('#ts_servico_valor').val(float2moeda(item.servico_valor));
                                    $('#ts_servico_qtd').val(item.servico_quantidade);

                                    atualizarServicoGrade(1);
                                });
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes')
                                //campos checkbox'''''''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.divProjetoScip').show();
                                $('.divLaudoExigencias').show();
                                $('.divCertificadoAprovacao').show();
                                $('.divCertificadoAprovacaoSimplificado').show();
                                $('.divCertificadoAprovacaoAssistido').show();

                                $('#projeto_scip').attr('checked', false);
                                $('#laudo_exigencias').attr('checked', false);
                                $('#certificado_aprovacao').attr('checked', false);
                                $('#certificado_aprovacao_simplificado').attr('checked', false);
                                $('#certificado_aprovacao_assistido').attr('checked', false);

                                if (data.success['projeto_scip'] == 1) {$('#projeto_scip').attr('checked', true);}
                                if (data.success['laudo_exigencias'] == 1) {$('#laudo_exigencias').attr('checked', true);}
                                if (data.success['certificado_aprovacao'] == 1) {$('#certificado_aprovacao').attr('checked', true);}
                                if (data.success['certificado_aprovacao_simplificado'] == 1) {$('#certificado_aprovacao_simplificado').attr('checked', true);}
                                if (data.success['certificado_aprovacao_assistido'] == 1) {$('#certificado_aprovacao_assistido').attr('checked', true);}
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //desmarcar checkbox'''''''''''''''''''''''''''''''''''''''''''''''''
                                $('.cbSegurancaMedida').attr('checked', false);
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Deixar todos os checkbox de Medidas de Segurança'''''''''''''''''''
                                $('.divSegurancaMedida').show();
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                cliente_seguranca_medidas = data.success['cliente_seguranca_medidas'];

                                $.each(cliente_seguranca_medidas, function(i, item) {
                                    //marcar como checado
                                    $('#seguranca_medida_'+item.pavimento+'_'+item.seguranca_medida_id).attr('checked', true);

                                    //Outros campos
                                    $('#quantidade_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.quantidade);
                                    $('#tipo_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.tipo);
                                    $('#observacao_'+item.pavimento+'_'+item.seguranca_medida_id).val(item.observacao);
                                });

                                pavimentosShowHide();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicas')
                                vt_configurarFormulario(data.success);

                                if (!vt_preencherFormulario(data.success)) {
                                    //Modal Show/Hide
                                    $('#crudForm').hide();

                                    //Table Show/Hide
                                    $('#crudTable').show();
                                }

                                //Alert para marcar Serviço como Finalizado'''''''''''''''''''''''''''''''''''''''''''''
                                $('#executado_data').prop('disabled', true).prop('readonly', false);
                                $('#executado_user_funcionario').prop('disabled', true).prop('readonly', false);
                                $('#executado_user_id').prop('disabled', true).prop('readonly', false);

                                $('#hrServicoExecutado').hide();
                                $('#spanServicoExecutado').hide();

                                if (data.success.executado_data == '' || data.success.executado_data === null) {
                                    $('#executado_data').val(data.success.dados_servico_executado.executado_data);
                                    $('#executado_user_funcionario').val(data.success.dados_servico_executado.executado_user_funcionario);
                                    $('#executado_user_id').val(data.success.dados_servico_executado.executado_user_id);

                                    $('#servico_executado').prop('checked', false);
                                    $('#labelServicoExecutado').html('Visita não Finalizada');

                                    $('#hrServicoExecutado').show();
                                    $('#spanServicoExecutado').show();
                                    $('#spanServicoExecutado').html('Ao verificar as Medidas de Segurança finalize a Visita aqui e confirme.');
                                } else {
                                    $('#executado_data').val(data.success.executado_data);
                                    $('#executado_user_funcionario').val(data.success.executado_user_funcionario);
                                    $('#executado_user_id').val(data.success.executado_user_id);

                                    $('#servico_executado').prop('checked', true);
                                    $('#labelServicoExecutado').html('Visita Finalizada');
                                }
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'funcionarios')
                                //Display divArquivosPdf
                                $('#divArquivosPdf').show();
                                $('#divArquivosPdfUpload').show();

                                //FuncionarioDocumentos
                                funcionarioDocumentos = data.success['funcionarioDocumentos'];

                                montar_grade_documentos_funcionario(2);
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                                //Não deixar alterar o campo servico_id e cliente_id''''''''''''''''''''''''''''''''''''
                                $('#servico_id').prop('disabled', true);
                                //$('#cliente_id').prop('disabled', true);
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''






                                //Brigada de Incêndio'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //Configuração conforme escala escolhida
                                bi_configuracaoConformeEscala($('#bi_escala_tipo_id').val());

                                //Preencher Grade Brigadistas
                                cliente_servicos_brigadistas = data.success['cliente_servicos_brigadistas'];

                                bi_limparGradeBrigadistas();

                                $.each(cliente_servicos_brigadistas, function(i, item) {
                                    //Dados para preenchera linha da grade
                                    $('#bi_grade_funcionario_id').val(item.funcionario_id);
                                    $('#bi_grade_funcionario_nome').val(item.funcionario_nome);
                                    $('#bi_grade_ala').val(item.ala);

                                    bi_gradeBrigadistasAtualizar(1);
                                });
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        } else if (data.error_not_found) {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
                        } else if (data.error_permissao) {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                        } else {
                            //Removendo Máscaras
                            removeMask();

                            //Restaurando Máscaras
                            putMask();

                            alert('Erro interno');
                        }
                    });
                });

                //Delete
                $('body').on('click', '.crudExcluirRegistro', function () {
                    //Campo hidden registro_id
                    if ($(this).data('id') != 0) {
                        $('#registro_id').val($(this).data('id'));
                    }

                    //Confirmação de Delete
                    alertSwalConfirmacao(function (confirmed) {
                        if (confirmed) {
                            //Settings'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                                //Confirmar exclusão, pois vai deletar a Visita Técnica''''''''''''''''
                                var resultado = confirm("Essa operação irá afetar o que se refere a este Serviço. Confirma operação?");
                                if (resultado == false) {return false;}
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                            $.ajax({
                                type: "DELETE",
                                url: "{{$ajaxPrefixPermissaoSubmodulo}}/" + $('#registro_id').val(),
                                beforeSend: function () {
                                    //Retirar DIV Botões e colocar DIV Loading
                                    $('.crudFormButtons2').hide();
                                    $('#crudFormAjaxLoading').show();
                                },
                                success: function (response) {
                                    //Lendo dados
                                    if (response.success) {
                                        alertSwal('success', "{{$ajaxNameSubmodulo}}", response.success, 'true', 2000);

                                        //Modal Show/Hide
                                        $('#crudForm').hide();

                                        //Table Show/Hide
                                        $('#crudTable').show();

                                        //Table
                                        tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');
                                    } else if (response.error) {
                                        alertSwal('error', "{{$ajaxNameSubmodulo}}", response.error, 'true', 2000);

                                        //Modal Show/Hide
                                        $('#crudForm').hide();

                                        //Table Show/Hide
                                        $('#crudTable').show();

                                        //Table
                                        tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');
                                    } else if (response.error_permissao) {
                                        alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                                    } else {
                                        alert('Erro interno');
                                    }
                                },
                                error: function (data) {
                                    alert('Erro interno');
                                },
                                complete: function () {
                                    //Retirar DIV Loading e colocar DIV Botões
                                    $('#crudFormAjaxLoading').hide()
                                    $('.crudFormButtons2').show();
                                }
                            });
                        }
                    });
                });

                //Confirm Operacao
                $('.crudConfirmarOperacao').click(function (e) {
                    e.preventDefault();

                    //Verificar Validação feita com sucesso
                    if ($('#{{$ajaxNameFormSubmodulo}}').valid()) {
                        var executar = 1;

                        @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                            //Serviço Tipo 1: Brigada de Incêndio - Verificação''''''''''''''''''''''''''''''''''''''''''''''
                            if ($('#servico_id option[value="'+$('#servico_id').val()+'"]').attr('data-servico_tipo_id') == 1) {
                                if (bi_gradeBrigadistasVerificacao(2) === false) {executar = 0;}
                            }
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                            //Serviço Tipo 3: Visita Técnica - Verificação'''''''''''''''''''''''''''''''''''''''''''''''''''
                            if ($('#servico_id option[value="'+$('#servico_id').val()+'"]').attr('data-servico_tipo_id') == 3) {
                                if (vt_verificacao() === false) {executar = 0;}
                            }
                            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        @endif

                        if (executar == 1) {
                            //Removendo Máscaras
                            removeMask();

                            //Confirm Operacao - Create
                            if ($('#frm_operacao').val() == 'create') {
                                $.ajax({
                                    data: $('#{{$ajaxNameFormSubmodulo}}').serialize(),
                                    url: "{{$ajaxPrefixPermissaoSubmodulo}}",
                                    type: "POST",
                                    dataType: "json",
                                    beforeSend: function () {
                                        //Retirar DIV Botões e colocar DIV Loading
                                        $('.crudFormButtons1').hide();
                                        $('#crudFormAjaxLoading').show();
                                    },
                                    success: function (response) {
                                        //Lendo dados
                                        if (response.success) {
                                            //Enviar E-mail'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                                            @if($ajaxPrefixPermissaoSubmodulo == 'users')
                                                email = $("#email").val();
                                            senha = response.content;
                                            senha = senha.substring(4, 14);
                                            $.get("enviar_email/users/primeiro_acesso/" + email + "/" + senha);
                                            @endif
                                            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                            alertSwal('success', "{{$ajaxNameSubmodulo}}", response.success, 'true', 2000);

                                            //Limpar validações
                                            $('.is-invalid').removeClass('is-invalid');

                                            //Limpar Formulário
                                            $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                                            $('.select2').val('').trigger('change');

                                            //Modal Show/Hide
                                            $('#crudForm').hide();

                                            //Table Show/Hide
                                            $('#crudTable').show();

                                            //Table
                                            tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');
                                        } else if (response.error_validation) {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            //Montar mensage de erro de Validação
                                            message = '<div class="pt-3">';
                                            $.each(response.error_validation, function (index, value) {
                                                message += '<div class="col-12 text-start font-size-12"><b>></b> ' + value + '</div>';
                                            });
                                            message += '</div>';

                                            alertSwal('warning', "Validação", message, 'true', 20000);
                                        } else if (response.error_permissao) {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                                        } else if (response.error) {
                                            alertSwal('warning', "{{$ajaxNameSubmodulo}}", response.error, 'true', 20000);
                                        } else {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            alert('Erro interno');
                                        }
                                    },
                                    error: function (data) {
                                        //Removendo Máscaras
                                        removeMask();

                                        //Restaurando Máscaras
                                        putMask();

                                        alert('Erro interno');
                                    },
                                    complete: function () {
                                        //Retirar DIV Loading e colocar DIV Botões
                                        $('#crudFormAjaxLoading').hide()
                                        $('.crudFormButtons1').show();
                                    }
                                });
                            }

                            //Confirm Operacao - Edit
                            if ($('#frm_operacao').val() == 'edit') {
                                //Settings'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                                @if($ajaxPrefixPermissaoSubmodulo == 'clientes_servicos')
                                    //Não deixar alterar o campo servico_id e cliente_id (revertendo)'''''''''''''''''''
                                    $('#servico_id').prop('disabled', false);
                                    //$('#cliente_id').prop('disabled', false);
                                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                    //Confirmar alteração, pois pode afetar a Visita Técnica''''''''''''''''''''''''''''
                                    var resultado = confirm("Essa operação irá afetar o que se refere a este Serviço. Confirma operação?");
                                    if (resultado == false) {return false;}
                                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                @endif
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                $.ajax({
                                    data: $('#{{$ajaxNameFormSubmodulo}}').serialize(),
                                    url: "{{$ajaxPrefixPermissaoSubmodulo}}/" + $('#registro_id').val(),
                                    type: "PUT",
                                    dataType: "json",
                                    beforeSend: function () {
                                        //Retirar DIV Botões e colocar DIV Loading
                                        $('.crudFormButtons1').hide();
                                        $('#crudFormAjaxLoading').show();
                                    },
                                    success: function (response) {
                                        //Lendo dados
                                        if (response.success) {
                                            alertSwal('success', "{{$ajaxNameSubmodulo}}", response.success, 'true', 2000);

                                            //Limpar validações
                                            $('.is-invalid').removeClass('is-invalid');

                                            //Limpar Formulário
                                            $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                                            $('.select2').val('').trigger('change');

                                            //Modal Show/Hide
                                            $('#crudForm').hide();

                                            //Table Show/Hide
                                            $('#crudTable').show();

                                            //Table
                                            tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');
                                        } else if (response.error_validation) {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            //Montar mensage de erro de Validação
                                            message = '<div class="pt-3">';
                                            $.each(response.error_validation, function (index, value) {
                                                message += '<div class="col-12 text-start font-size-12"><b>></b> ' + value + '</div>';
                                            });
                                            message += '</div>';

                                            alertSwal('warning', "Validação", message, 'true', 20000);
                                        } else if (response.error_not_found) {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
                                        } else if (response.error_permissao) {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                                        } else if (response.error) {
                                            alertSwal('warning', "{{$ajaxNameSubmodulo}}", response.error, 'true', 20000);
                                        } else {
                                            //Removendo Máscaras
                                            removeMask();

                                            //Restaurando Máscaras
                                            putMask();

                                            alert('Erro interno');
                                        }
                                    },
                                    error: function (data) {
                                        //Removendo Máscaras
                                        removeMask();

                                        //Restaurando Máscaras
                                        putMask();

                                        alert('Erro interno');
                                    },
                                    complete: function () {
                                        //Retirar DIV Loading e colocar DIV Botões
                                        $('#crudFormAjaxLoading').hide()
                                        $('.crudFormButtons1').show();
                                    }
                                });
                            }
                        }
                    }
                });

                //Cancel Operacao
                $('.crudCancelarOperacao').click(function (e) {
                    e.preventDefault();

                    //Modal Show/Hide
                    $('#crudForm').hide();

                    //Table Show/Hide
                    $('#crudTable').show();
                });

                //Configurações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Select2
                if ($('select').hasClass('select2')) {
                    $(".select2").select2({dropdownParent: $('#crudForm')});
                }

                if ($('select').hasClass('select2-limiting')) {
                    $(".select2-limiting").select2({maximumSelectionLength:2, dropdownParent: $('#crudForm')});
                }

                if ($('select').hasClass('select2-search-disable')) {
                    $(".select2-search-disable").select2({minimumResultsForSearch:1/0, dropdownParent: $('#crudForm')});
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            });
        </script>
    @endif
@endif





<script>
    //DESENVOLVIMENTO (IRDIRETO PARA O FORMULARIO CREATE)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //DESENVOLVIMENTO (IRDIRETO PARA O FORMULARIO CREATE)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //DESENVOLVIMENTO (IRDIRETO PARA O FORMULARIO CREATE)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    @if(isset($ajaxPrefixPermissaoSubmodulo))
        @if($ajaxPrefixPermissaoSubmodulo == 'xxxxxx')
            $.get("{{$ajaxPrefixPermissaoSubmodulo}}/create", function (data) {
                //Limpar validações
                $('.is-invalid').removeClass('is-invalid');

                //Limpar Formulário
                $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');
                $('.select2').val('').trigger('change');

                //Lendo dados
                if (data.success) {
                    //Campo hidden frm_operacao
                    $('#frm_operacao').val('create');

                    //Campos do Formulário - disabled true/false
                    $('input').prop('disabled', false);
                    $('textarea').prop('disabled', false);
                    $('select').prop('disabled', false);
                    $('.select2').prop('disabled', false);

                    //Botões do Modal
                    $('.crudFormButtons1').show();
                    $('.crudFormButtons2').hide();

                    //Table Show/Hide
                    $('#crudTable').hide();

                    //Modal Show/Hide
                    $('#crudForm').show();

                    //Removendo Máscaras
                    removeMask();

                    //Restaurando Máscaras
                    putMask();
                } else if (data.error_permissao) {
                    alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                } else {
                    alert('Erro interno');
                }
            });
        @endif
    @endif
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
</script>

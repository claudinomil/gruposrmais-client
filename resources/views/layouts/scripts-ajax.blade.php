@if(isset($ajaxPrefixPermissaoSubmodulo))
    <!-- Script para CRUD Ajax -->
    <!-- Alguns Submódulos não tem CRUD, então entra na exceção -->
    <!-- Submódulos que não vão usar: Dashboards, Logos -->
    @if($ajaxPrefixPermissaoSubmodulo != 'dashboards' and $ajaxPrefixPermissaoSubmodulo != 'logos')
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
                $('#searchRecords').click(function () {
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
                $('#createNewRecord').click(function () {
                    //Passar pelo evento create do controller
                    $.get("{{$ajaxPrefixPermissaoSubmodulo}}/create", function (data) {
                        //Limpar validações
                        $('.is-invalid').removeClass('is-invalid');

                        //Limpar Formulário
                        $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');

                        //Lendo dados
                        if (data.success) {
                            //Campo hidden frm_operacao
                            $('#frm_operacao').val('create');

                            //Campos do Formulário - disabled true/false
                            $('#fieldsetForm').prop('disabled', false);
                            $('.select2').prop('disabled', false);

                            //Botões do Modal
                            $('#crudFormButtons1').show();
                            $('#crudFormButtons2').hide();

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

                            @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicas')
                                //limpando campos iniciais''''''''''''''''''''''''''''''''''''''
                                $('#visita_tecnica_status_id').val('').trigger('change');
                                $('#cliente_id').val('').trigger('change');
                                $('#data_visita').val('');
                                $('#responsavel_funciionario_id').val('').trigger('change');
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                //montando Classificação para o Cliente'''''''''''''''''''''''''
                                montarClassificacaoCliente();
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
                $('body').on('click', '.viewRecord', function () {
                    //Campo hidden registro_id
                    $('#registro_id').val($(this).data('id'));

                    //Buscar dados do Registro
                    $.get("{{$ajaxPrefixPermissaoSubmodulo}}/"+$('#registro_id').val(), function (data) {
                        //Limpar validações
                        $('.is-invalid').removeClass('is-invalid');

                        //Limpar Formulário
                        $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');

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
                            $('#fieldsetForm').prop('disabled', true);
                            $('.select2').prop('disabled', true);

                            //Botões do Modal
                            $('#crudFormButtons1').hide();
                            $('#crudFormButtons2').show();

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

                                    //dar show
                                    $('.divSegurancaMedida'+item.pavimento+item.seguranca_medida_id).show();
                                });
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                                pavimentosShowHide();
                                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicas')
                                //montando Classificação para o Cliente'''''''''''''''''''''''''
                                visita_tecnica_seguranca_medidas = data.success['visita_tecnica_seguranca_medidas'];

                                montarClassificacaoCliente($('#cliente_id').val(), visita_tecnica_seguranca_medidas);
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
                $('body').on('click', '.editRecord', function () {
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
                            $('#fieldsetForm').prop('disabled', false);
                            $('.select2').prop('disabled', false);

                            //Botões do Modal
                            $('#crudFormButtons1').show();
                            $('#crudFormButtons2').hide();

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
                                $('#email').prop('readonly', true);
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
                                });

                                pavimentosShowHide();
                            @endif

                            @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicas')
                                //montando Classificação para o Cliente'''''''''''''''''''''''''
                                visita_tecnica_seguranca_medidas = data.success['visita_tecnica_seguranca_medidas'];

                                montarClassificacaoCliente($('#cliente_id').val(), visita_tecnica_seguranca_medidas);
                                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
                $('body').on('click', '.deleteRecord', function () {
                    //Campo hidden registro_id
                    if ($(this).data('id') != 0) {
                        $('#registro_id').val($(this).data('id'));
                    }

                    //Confirmação de Delete
                    alertSwalConfirmacao(function (confirmed) {
                        if (confirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{$ajaxPrefixPermissaoSubmodulo}}/" + $('#registro_id').val(),
                                beforeSend: function () {
                                    //Retirar DIV Botões e colocar DIV Loading
                                    $('#crudFormButtons2').hide();
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
                                        alertSwal('success', "{{$ajaxNameSubmodulo}}", response.error, 'true', 2000);

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
                                    $('#crudFormButtons2').show();
                                }
                            });
                        }
                    });
                });

                //Confirm Operacao
                $('#crudFormConfirmOperacao').click(function (e) {
                    e.preventDefault();

                    //Verificar Validação feita com sucesso
                    if ($('#{{$ajaxNameFormSubmodulo}}').valid()) {
                        //Removendo Máscaras
                        removeMask();

                        //Confirm Operacao - Create
                        if ($('#frm_operacao').val() == 'create') {
                            $.ajax({
                                data: $('#{{$ajaxNameFormSubmodulo}}').serialize(),
                                url: "{{route($ajaxPrefixPermissaoSubmodulo.'.store')}}",
                                type: "POST",
                                dataType: "json",
                                beforeSend: function () {
                                    //Retirar DIV Botões e colocar DIV Loading
                                    $('#crudFormButtons1').hide();
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
                                    $('#crudFormButtons1').show();
                                }
                            });
                        }

                        //Confirm Operacao - Edit
                        if ($('#frm_operacao').val() == 'edit') {
                            $.ajax({
                                data: $('#{{$ajaxNameFormSubmodulo}}').serialize(),
                                url: "{{$ajaxPrefixPermissaoSubmodulo}}/"+$('#registro_id').val(),
                                type: "PUT",
                                dataType: "json",
                                beforeSend: function () {
                                    //Retirar DIV Botões e colocar DIV Loading
                                    $('#crudFormButtons1').hide();
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
                                    $('#crudFormButtons1').show();
                                }
                            });
                        }
                    }
                });

                //Cancel Operacao
                $('.crudFormCancelOperacao').click(function (e) {
                    e.preventDefault();

                    //Modal Show/Hide
                    $('#crudForm').hide();

                    //Table Show/Hide
                    $('#crudTable').show();
                });

                //Configurações'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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
        @if($ajaxPrefixPermissaoSubmodulo == 'visitas_tecnicasxxx')
            $.get("{{$ajaxPrefixPermissaoSubmodulo}}/create", function (data) {
                //Limpar validações
                $('.is-invalid').removeClass('is-invalid');

                //Limpar Formulário
                $('#{{$ajaxNameFormSubmodulo}}').trigger('reset');

                //Lendo dados
                if (data.success) {
                    //Campo hidden frm_operacao
                    $('#frm_operacao').val('create');

                    //Campos do Formulário - disabled true/false
                    $('#fieldsetForm').prop('disabled', false);
                    $('.select2').prop('disabled', false);

                    //Botões do Modal
                    $('#crudFormButtons1').show();
                    $('#crudFormButtons2').hide();

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

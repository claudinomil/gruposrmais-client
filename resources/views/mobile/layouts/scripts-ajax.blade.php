@if(isset($ajaxPrefixPermissaoSubmodulo))
    <!-- Script para MOBILE Ajax -->
    @if($ajaxPrefixPermissaoSubmodulo != 'mobile' and $ajaxPrefixPermissaoSubmodulo != 'yyyyy')
        <script type="text/javascript">
            $(function () {
                //Header
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });

                //Table
                @if (isset($colsFields))
                    tableContent('{{$ajaxPrefixPermissaoSubmodulo}}');

                    function tableContent(route) {
                        $('.datatable-mobile-ajax').DataTable({
                            language: {
                                pageLength: {},
                                //lengthMenu: 'Exibir _MENU_ resultados por página',
                                lengthMenu: '',
                                emptyTable: 'Nenhum registro encontrado',
                                //info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
                                info: '',
                                //infoEmpty: 'Mostrando 0 até 0 de 0 registros',
                                infoEmpty: '',
                                infoFiltered: '(Filtrados de _MAX_ registros)',
                                infoThousands: '.',
                                loadingRecords: 'Carregando...',
                                processing: 'Processando...',
                                zeroRecords: 'Nenhum registro encontrado',
                                search: 'Pesquisar',
                                //paginate: {}
                                // paginate: {
                                //     next: 'Próximo',
                                //     previous: 'Anterior',
                                //     first: 'Primeiro',
                                //     last: 'Último'
                                // }
                            },
                            paginate: false,
                            bDestroy: true,
                            responsive: true,
                            lengthChange: true,
                            autoWidth: true,
                            order: [],
                            border: true,

                            processing: true,
                            serverSide: false,
                            ajax: route,
                            columns: [
                                @foreach($colsFields as $colField)
                                {
                                    'data': '{{$colField}}'
                                },
                                    @endforeach

                                    @if($colActions == 'yes')
                                {
                                    'data': 'action'
                                }
                                @endif
                            ]
                        });
                    }
                @endif

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
            });
        </script>
    @endif

    <!-- Configurações Comuns -->
    <script>
        //Logo do Topo
        $('#divLogoTopoPrincipal').hide();
        $('#divLogoTopoReturn').show();

        //Título da Pagina
        $('#divTitulo').html('{{mb_strtoupper($ajaxNameSubmodulo)}}');
    </script>

    <!-- Configurações Individuais -->
    @if($ajaxPrefixPermissaoSubmodulo == 'mobile')
        <script>
            $('#divLogoTopoPrincipal').show();
            $('#divLogoTopoReturn').hide();

            //$('#divTitulo').html('ESCOLHA UMA OPÇÃO');
        </script>
    @endif

    @if($ajaxPrefixPermissaoSubmodulo == 'mobile_clientes')
        <script></script>
    @endif

    @if($ajaxPrefixPermissaoSubmodulo == 'mobile_visitas_tecnicas')
        <script></script>
    @endif
@endif
568

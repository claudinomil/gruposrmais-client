<!-- libs -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/bootstrap/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-validation/jquery-validation.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-validation/jquery-validation-pt-br.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/jquery-validation-methods.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/metismenu/metismenu.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/simplebar/simplebar.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/node-waves/node-waves.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jszip/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/pdfmake/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-mask/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/jquery-masks.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/app.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/main.js') }}"></script>

<!-- functions.js -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/functions.js') }}"></script>

<!-- scripts_profiles.js -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/scripts_profiles.js') }}"></script>

@yield('script')

@yield('script-bottom')

<!-- scripts_template_init.js -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/scripts_template_init.js') }}"></script>

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

{{-- Script para Profile --}}
<script type="text/javascript">
    $(function () {
        //Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        //Update Avatar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonUploadAvatar').click(function () {
            //Preparar
            $('#divUploadAvatar').show();
            $('#buttonUploadAvatar').hide();
            $('#buttonUploadAvatarClose').show();

            $('#buttonEditEmailClose').trigger('click');
            $('#buttonEditPasswordClose').trigger('click');
        });

        $('#buttonUploadAvatarClose').click(function () {
            //Preparar
            $('#divUploadAvatar').hide();
            $('#buttonUploadAvatar').show();
            $('#buttonUploadAvatarClose').hide();
        });

        $('#frm_upload_avatar').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-upload-avatar-error').text('');

            $.ajax({
                type:'POST',
                url: '/users/uploadavatar',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);

                    //colocando a imagem na view
                    var file = $("#avatar_file").get(0).files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(){
                            $("#imgImageAvatar").attr("src", reader.result);
                            $(".header-profile-user").attr("src", reader.result);
                        }
                        reader.readAsDataURL(file);
                    }
                },
                error: function(response){
                    alert(response);
                    $('#frm-upload-avatar-error').text('Avatar inválido!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Edit Email''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonEditEmail').click(function () {
            //Preparar
            $('#divEditEmail').show();
            $('#buttonEditEmail').hide();
            $('#buttonEditEmailClose').show();

            $('#buttonUploadAvatarClose').trigger('click');
            $('#buttonEditPasswordClose').trigger('click');
        });

        $('#buttonEditEmailClose').click(function () {
            //Preparar
            $('#divEditEmail').hide();
            $('#buttonEditEmail').show();
            $('#buttonEditEmailClose').hide();
        });

        $('#frm_edit_email').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-edit-email-error').text('');

            //Validando'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            validacao = true;

            $('#current-email-error').text('');
            $('#new-email-error').text('');

            if ($('#current_email').val() == '') {
                $('#current-email-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#new_email').val() == '') {
                $('#new-email-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#current_email').val() == $('#new_email').val()) {
                $('#current-email-error').text('E-mail Atual e E-mail Novo Iguais.');
                $('#new-email-error').text('E-mail Atual e E-mail Novo Iguais.');
                validacao = false;
            }

            if (!validacao) {return false;}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $.ajax({
                type:'POST',
                url: '/users/editemail',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                },
                error: function(response){
                    alert(response);
                    $('#frm-edit-email-error').text('Requisição com erro!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Edit Password'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonEditPassword').click(function () {
            //Preparar
            $('#divEditPassword').show();
            $('#buttonEditPassword').hide();
            $('#buttonEditPasswordClose').show();

            $('#buttonUploadAvatarClose').trigger('click');
            $('#buttonEditEmailClose').trigger('click');
        });

        $('#buttonEditPasswordClose').click(function () {
            //Preparar
            $('#divEditPassword').hide();
            $('#buttonEditPassword').show();
            $('#buttonEditPasswordClose').hide();
        });

        $('#frm_edit_password').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-edit-password-error').text('');

            //Validando'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            validacao = true;

            $('#current-password-error').text('');
            $('#new-password-error').text('');
            $('#confirm-new-password-error').text('');

            if ($('#current_password').val() == '') {
                $('#current-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#new_password').val() != $('#confirm_new_password').val()) {
                $('#new-password-error').text('Senha Nova e Confirmar Senha Nova Diferentes.');
                $('#confirm-new-password-error').text('Senha Nova e Confirmar Senha Nova Diferentes.');
                validacao = false;
            }

            if ($('#new_password').val().length < 10 || $('#new_password').val().length > 20) {
                $('#new-password-error').text('Campo precisa ter entre 10 e 20 caracteres.');
                validacao = false;
            }

            if ($('#new_password').val() == '') {
                $('#new-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#confirm_new_password').val().length < 10 || $('#confirm_new_password').val().length > 20) {
                $('#confirm-new-password-error').text('Campo precisa ter entre 10 e 20 caracteres.');
                validacao = false;
            }

            if ($('#confirm_new_password').val() == '') {
                $('#confirm-new-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if (!validacao) {return false;}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $.ajax({
                type:'POST',
                url: '/users/editpassword',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                },
                error: function(response){
                    alert(response);
                    $('#frm-edit-password-error').text('Requisição com erro!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    });
</script>

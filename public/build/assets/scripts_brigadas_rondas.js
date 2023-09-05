$(document).ready(function () {
    if ($('#frm_rondas').length) {
        $('#frm_rondas').validate({
            rules: {},
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    }

    $(function () {
        //Header
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        //Visualizar Ronda
        $('body').on('click', '.btnViewRonda', function () {
            //Campo brigada_escala_id
            var brigada_ronda_id = $(this).data('id');

            //Preencher Campo hidden brigada_ronda_id
            $('#frm_rondas #brigada_ronda_id').val(brigada_ronda_id);

            //Table Show/Hide
            $('#crudTable').hide();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').hide();

            //Rondas Form
            $('#rondasForm').show();

            //Título
            $('#currentPageTitle span').html(' (RONDAS)');
            $('#rondasForm #titulo').html($('#is_cliente').val());

            //Título2
            $('#rondasForm #titulo2').html($(this).data('funcionario_nome')+' ('+$(this).data('data_chegada')+' às '+$(this).data('hora_chegada')+' até '+$(this).data('data_saida')+' às '+$(this).data('hora_saida')+')');

            //Loading
            $('#rondasFormAjaxLoading').show();

            //Buscar dados
            $.get("brigadas/ronda_cliente_seguranca_medidas/2/"+'0'+'/'+brigada_ronda_id, function (data) {
                //Lendo dados
                if (data.success) {
                    bi_formularioRonda(2, data.success);
                } else {
                    alert('Erro interno');
                }
            });

            //Loading
            $('#rondasFormAjaxLoading').hide();
        });

        //Executar Ronda
        $('body').on('click', '.btnExecutarRonda', function () {
            //Campo brigada_escala_id
            var brigada_escala_id = $(this).data('id');

            //Preencher Campo hidden brigada_escala_id
            $('#frm_rondas #brigada_escala_id').val(brigada_escala_id);

            //Table Show/Hide
            $('#crudTable').hide();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').hide();

            //Rondas Form
            $('#rondasForm').show();

            //Título
            $('#currentPageTitle span').html(' (RONDAS)');
            $('#rondasForm #titulo').html($('#is_cliente').val());

            //Título2
            $('#rondasForm #titulo2').html($(this).data('funcionario_nome')+' ('+$(this).data('data_chegada')+' às '+$(this).data('hora_chegada')+' até '+$(this).data('data_saida')+' às '+$(this).data('hora_saida')+')');

            //Loading
            $('#rondasFormAjaxLoading').show();

            //Buscar dados
            $.get("brigadas/ronda_cliente_seguranca_medidas/1/"+brigada_escala_id+'/0', function (data) {

                //Lendo dados
                if (data.success) {
                    bi_formularioRonda(1, data.success);
                } else {
                    alert('Erro interno');
                }
            });

            //Loading
            $('#rondasFormAjaxLoading').hide();
        });

        //Confirm Operacao
        $('.rondasFormConfirmOperacao').click(function (e) {
            e.preventDefault();

            //Verificar Validação feita com sucesso
            if (bi_validarFormRonda()) {
                //Confirm Operacao
                $.ajax({
                    data: $('#frm_rondas').serialize(),
                    url: "brigadas/ronda_store",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function () {$('#rondasFormAjaxLoading').show();},
                    success: function (response) {
                        //Lendo dados
                        if (response.success) {
                            alertSwal('success', 'Rondas', response.success, 'true', 2000);

                            //Refazer a Grade de Escalas
                            bi_montarGradeEscala();

                            //Table Show/Hide
                            $('#crudTable').hide();

                            //Modal Show/Hide
                            $('#crudForm').hide();

                            //Escalas Form
                            $('#escalasForm').show();

                            //Rondas Form
                            $('#rondasForm').hide();
                        } else if (response.error_validation) {
                            //Montar mensage de erro de Validação
                            message = '<div class="pt-3">';
                            $.each(response.error_validation, function (index, value) {
                                message += '<div class="col-12 text-start font-size-12"><b>></b> ' + value + '</div>';
                            });
                            message += '</div>';

                            alertSwal('warning', "Validação", message, 'true', 20000);
                        } else {
                            alert('Erro interno');
                        }
                    },
                    error: function (data) {
                        alert('Erro interno');
                    },
                    complete: function () {$('#rondasFormAjaxLoading').hide();}
                });
            }
        });

        //Cancel Operacao e voltar para Grade de Escalas
        $('.rondasFormCancelOperacao').click(function (e) {
            e.preventDefault();

            //Table Show/Hide
            $('#crudTable').hide();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').show();

            //Rondas Form
            $('#rondasForm').hide();

            //Título
            $('#currentPageTitle span').html(' (ESCALAS)');
        });
    });
});

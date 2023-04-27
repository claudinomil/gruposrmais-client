$(document).ready(function () {
    if ($('#frm_visitas_tecnicas').length) {
        $('#frm_visitas_tecnicas').validate({
            rules: {
                data_visita: {
                    required: true,
                    dateMethod: true
                },
                cliente_id: {
                    required: true,
                    idMethod: true
                }
            },
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

    //Botão Laudo de Exigências
    if ($('#laudo_exigencias').val() == '1') {
        $('#btnLaudoExigencias').removeClass('btn-outline-danger').addClass('btn-outline-success');
        $('#btnLaudoExigenciasIcon').removeClass('bx-block').addClass('bx-check-double');

        $('#laudo_exigencias').val('1');

        $('#laudo_exigencias_numero').attr('readonly', false);
        $('#laudo_exigencias_data_emissao').attr('readonly', false);
        $('#laudo_exigencias_data_vencimento').attr('readonly', false);
    } else {
        $('#btnLaudoExigencias').removeClass('btn-outline-success').addClass('btn-outline-danger');
        $('#btnLaudoExigenciasIcon').removeClass('bx-check-double').addClass('bx-block');

        $('#laudo_exigencias').val('0');
        $('#laudo_exigencias_numero').val('');
        $('#laudo_exigencias_data_emissao').val('');
        $('#laudo_exigencias_data_vencimento').val('');

        $('#laudo_exigencias_numero').attr('readonly', true);
        $('#laudo_exigencias_data_emissao').attr('readonly', true);
        $('#laudo_exigencias_data_vencimento').attr('readonly', true);
    }

    $('#btnLaudoExigencias').click(function () {
        if ($('#laudo_exigencias').val() == '0') {
            $('#btnLaudoExigencias').removeClass('btn-outline-danger').addClass('btn-outline-success');
            $('#btnLaudoExigenciasIcon').removeClass('bx-block').addClass('bx-check-double');

            $('#laudo_exigencias').val('1');

            $('#laudo_exigencias_numero').attr('readonly', false);
            $('#laudo_exigencias_data_emissao').attr('readonly', false);
            $('#laudo_exigencias_data_vencimento').attr('readonly', false);
        } else {
            $('#btnLaudoExigencias').removeClass('btn-outline-success').addClass('btn-outline-danger');
            $('#btnLaudoExigenciasIcon').removeClass('bx-check-double').addClass('bx-block');

            $('#laudo_exigencias').val('0');

            $('#laudo_exigencias_numero').val('');
            $('#laudo_exigencias_data_emissao').val('');
            $('#laudo_exigencias_data_vencimento').val('');

            $('#laudo_exigencias_numero').attr('readonly', true);
            $('#laudo_exigencias_data_emissao').attr('readonly', true);
            $('#laudo_exigencias_data_vencimento').attr('readonly', true);
        }
    });


    //Botão Certificado Aprovacao
    if ($('#certificado_aprovacao').val() == '1') {
        $('#btnCertificadoAprovacao').removeClass('btn-outline-danger').addClass('btn-outline-success');
        $('#btnCertificadoAprovacaoIcon').removeClass('bx-block').addClass('bx-check-double');

        $('#certificado_aprovacao').val('1');

        $('#certificado_aprovacao_numero').attr('readonly', false);
    } else {
        $('#btnCertificadoAprovacao').removeClass('btn-outline-success').addClass('btn-outline-danger');
        $('#btnCertificadoAprovacaoIcon').removeClass('bx-check-double').addClass('bx-block');

        $('#certificado_aprovacao').val('0');
        $('#certificado_aprovacao_numero').val('');

        $('#certificado_aprovacao_numero').attr('readonly', true);
    }

    $('#btnCertificadoAprovacao').click(function () {
        if ($('#certificado_aprovacao').val() == '0') {
            $('#btnCertificadoAprovacao').removeClass('btn-outline-danger').addClass('btn-outline-success');
            $('#btnCertificadoAprovacaoIcon').removeClass('bx-block').addClass('bx-check-double');

            $('#certificado_aprovacao').val('1');

            $('#certificado_aprovacao_numero').attr('readonly', false);
        } else {
            $('#btnCertificadoAprovacao').removeClass('btn-outline-success').addClass('btn-outline-danger');
            $('#btnCertificadoAprovacaoIcon').removeClass('bx-check-double').addClass('bx-block');

            $('#certificado_aprovacao').val('0');
            $('#certificado_aprovacao_numero').val('');

            $('#certificado_aprovacao_numero').attr('readonly', true);
        }
    });

    //Edificação Classificação
    $('#edificacao_classificacao_id').on('change', function() {
        grupo = $(this).find("option:selected").attr('data-grupo');
        ocupacao_uso = $(this).find("option:selected").attr('data-ocupacao-uso');
        divisao = $(this).find("option:selected").attr('data-divisao');
        descricao = $(this).find("option:selected").attr('data-descricao');

        $('#grupo').val(grupo);
        $('#ocupacao_uso').val(ocupacao_uso);
        $('#divisao').val(divisao);
        $('#descricao').val(descricao);
    });

    //Medidas de Segurança
    $('#btnMedidasSegurancaPadrao').click(function () {
        var np = $('#numero_pavimentos').val();
        var atc = $('#area_total_construida').val();
        var grupo = $('#grupo').val();
        var divisao = $('#divisao').val();

        if (np == '' || atc == '' || grupo == '' || divisao == '') {return;}

        $.get('visitas_tecnicas/medidas_seguranca/'+np+'/'+atc+'/'+grupo+'/'+divisao, function (data) {
            //Lendo dados
            if (data.success) {
                medidas_seguranca = data.success.medidas_seguranca;

                $('.divMedidasSeguranca').append('<br>#######################################################<br>');

                $.each(medidas_seguranca, function(i, item) {
                    $('.divMedidasSeguranca').append(item.name+'<br>');
                });
            } else if (data.error_permissao) {
                alertSwal('warning', "Permissão Negada", '', 'true', 2000);
            } else {
                alert('Erro internocccc');
            }
        });
    });
});

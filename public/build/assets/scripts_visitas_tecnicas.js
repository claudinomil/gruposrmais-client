$(document).ready(function () {
    if ($('#frm_visitas_tecnicas').length) {
        $('#frm_visitas_tecnicas').validate({
            rules: {

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

    //Funções para o formulário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    $(function () {
        //Header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Fazer Upload do Documento
        $('.btn_projeto_scip_pdf_upload, .btn_laudo_exigencias_pdf_upload, .btn_certificado_aprovacao_pdf_upload, .btn_certificado_aprovacao_simplificado_pdf_upload, .btn_certificado_aprovacao_assistido_pdf_upload').click(function () {
            let formData = new FormData($('#frm_visitas_tecnicas')[0]);

            //Verificando qual documento foi chamado
            var documento = '';

            if ($(this).hasClass('btn_projeto_scip_pdf_upload')) {documento = 'projeto_scip_pdf';}
            if ($(this).hasClass('btn_laudo_exigencias_pdf_upload')) {documento = 'laudo_exigencias_pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_pdf_upload')) {documento = 'certificado_aprovacao_pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_simplificado_pdf_upload')) {documento = 'certificado_aprovacao_simplificado_pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_assistido_pdf_upload')) {documento = 'certificado_aprovacao_assistido_pdf';}

            //Ajax
            $.ajax({
                type: 'POST',
                url: '/visitas_tecnicas/documentos_upload/'+documento,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error_permissao) {
                        alert(response.error_permissao);
                    } else {
                        alert(response);
                    }
                },
                error: function (response) {
                    alert(response);
                }
            });
        });

        //Visualizar Documento
        $('.btn_projeto_scip_pdf_view, .btn_laudo_exigencias_pdf_view, .btn_certificado_aprovacao_pdf_view, .btn_certificado_aprovacao_simplificado_pdf_view, .btn_certificado_aprovacao_assistido_pdf_view').click(function () {
            //Verificando qual documento foi chamado
            var documento = '';

            if ($(this).hasClass('btn_projeto_scip_pdf_view')) {documento = 'projeto_scip_pdf_'+$('#registro_id').val()+'.pdf';}
            if ($(this).hasClass('btn_laudo_exigencias_pdf_view')) {documento = 'laudo_exigencias_pdf_'+$('#registro_id').val()+'.pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_pdf_view')) {documento = 'certificado_aprovacao_pdf_'+$('#registro_id').val()+'.pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_simplificado_pdf_view')) {documento = 'certificado_aprovacao_simplificado_pdf_'+$('#registro_id').val()+'.pdf';}
            if ($(this).hasClass('btn_certificado_aprovacao_assistido_pdf_view')) {documento = 'certificado_aprovacao_assistido_pdf_'+$('#registro_id').val()+'.pdf';}

            if (documento != '') {
                //URL do documento
                var urlDocumento = window.location.protocol + '//' + window.location.host + '/' + 'build/assets/pdfs/visitas_tecnicas/' + documento;

                //Verificar se existe arquivo na pasta
                fetch(urlDocumento).then(response => {
                    if (response.ok) {
                        window.open(urlDocumento, '_blank');
                    } else {
                        alert('Documento não existe.');
                    }
                });
            } else {
                alert('Documento não existe.');
            }
        });

        //Checkbox servico_executado
        $('#servico_executado').click(function () {
            $('#hrServicoExecutado').hide();
            $('#spanServicoExecutado').hide();
            $('#spanServicoExecutado').html('');

            if ($('#servico_executado').is(':checked')) {
                $('#labelServicoExecutado').html('Visita Finalizada');

                $('#executado_data').prop('disabled', false).prop('readonly', true);
                $('#executado_user_funcionario').prop('disabled', false).prop('readonly', true);
                $('#executado_user_id').prop('disabled', false).prop('readonly', true);
            } else {
                $('#hrServicoExecutado').show();
                $('#spanServicoExecutado').show();
                $('#spanServicoExecutado').html('Ao verificar as Medidas de Segurança finalize a Visita aqui e confirme.');
                $('#labelServicoExecutado').html('Visita não Finalizada');

                $('#executado_data').prop('disabled', true).prop('readonly', false);
                $('#executado_user_funcionario').prop('disabled', true).prop('readonly', false);
                $('#executado_user_id').prop('disabled', true).prop('readonly', false);
            }
        });
    });
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
});

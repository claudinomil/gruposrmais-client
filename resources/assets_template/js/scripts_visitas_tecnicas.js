$(document).ready(function () {
    if ($('#frm_visitas_tecnicas').length) {
        $('#frm_visitas_tecnicas').validate({
            rules: {
                visita_tecnica_status_id: {
                    required: true,
                    idMethod: true
                },
                cliente_id: {
                    required: true,
                    idMethod: true
                },
                data_visita: {
                    required: true,
                    dateMethod: true
                },
                responsavel_funcionario_id: {
                    required: false,
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

    //Funções para o formulário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Buscar dados do Cliente escolhido
    $('#cliente_id').on('change', function() {
        if ($('#frm_operacao').val() == 'create') {
            montarFormVisitaGetCliente($('#cliente_id').val());
        } else if ($('#frm_operacao').val() == 'edit') {
            if ($('#visita_tecnica_status_id').val() == 1) {
                montarFormVisitaGetCliente($('#cliente_id').val());
            }
        } else if ($('#frm_operacao').val() == 'view') {
            // if ($('#visita_tecnica_status_id').val() == 1) {
            //     montarFormVisitaGetCliente($('#cliente_id').val());
            // }
        }
    });

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
                //URL
                var url_atual = window.location.protocol+'//'+window.location.host+'/';

                window.open(url_atual+"build/assets/pdfs/visitas_tecnicas/"+documento, "_blank");
            } else {
                alert('Documento não existe.');
            }
        });
    });
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
});

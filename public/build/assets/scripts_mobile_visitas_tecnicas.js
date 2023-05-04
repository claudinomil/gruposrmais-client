$(document).ready(function () {
    if ($('#frm_mobile_visitas_tecnicas').length) {
        $('#frm_mobile_visitas_tecnicas').validate({
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
                    required: false,
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
});

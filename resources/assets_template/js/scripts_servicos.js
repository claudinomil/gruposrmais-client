$(document).ready(function () {
    if ($('#frm_servicos').length) {
        $('#frm_servicos').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                servico_tipo_id: {
                    required: true,
                    idMethod: true
                },
                valor: {
                    required: true
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

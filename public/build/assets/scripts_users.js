$(document).ready(function () {
    if ($('#frm_users').length) {
        $('#frm_users').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                layout_mode: {
                    required: true
                },
                layout_style: {
                    required: true
                },
                grupo_id: {
                    required: true
                },
                situacao_id: {
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

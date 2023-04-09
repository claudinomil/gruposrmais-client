$(document).ready(function () {
    if ($('#frm_notificacoes').length) {
        $('#frm_notificacoes').validate({
            rules: {
                title: {
                    required: true
                },
                notification: {
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

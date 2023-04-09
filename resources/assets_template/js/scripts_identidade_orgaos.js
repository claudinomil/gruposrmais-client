$(document).ready(function () {
    if ($('#frm_identidade_orgaos').length) {
        $('#frm_identidade_orgaos').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                sigla: {
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

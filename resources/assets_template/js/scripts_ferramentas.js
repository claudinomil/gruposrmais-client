$(document).ready(function () {
    if ($('#frm_ferramentas').length) {
        $('#frm_ferramentas').validate({
            rules: {
                name: {
                    required: true
                },
                descricao: {
                    required: true
                },
                url: {
                    required: true
                },
                icon: {
                    required: true
                },
                viewing_order: {
                    required: true,
                    number: true,
                    step: 1
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

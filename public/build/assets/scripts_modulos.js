$(document).ready(function () {
    if ($('#frm_modulos').length) {
        $('#frm_modulos').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                menu_text: {
                    required: true,
                    minlength: 3
                },
                menu_url: {
                    required: true,
                    minlength: 3
                },
                menu_route: {
                    required: true,
                    minlength: 3
                },
                menu_icon: {
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

$(document).ready(function () {
    if ($('#frm_submodulos').length) {
        $('#frm_submodulos').validate({
            rules: {
                modulo_id: {
                    required: true
                },
                name: {
                    required: true
                },
                menu_text: {
                    required: true
                },
                menu_url: {
                    required: true
                },
                menu_route: {
                    required: true
                },
                menu_icon: {
                    required: true
                },
                prefix_permissao: {
                    required: true
                },
                prefix_route: {
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





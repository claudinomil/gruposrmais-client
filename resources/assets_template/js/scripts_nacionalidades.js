$(document).ready(function () {
    if ($('#frm_nacionalidades').length) {
        $('#frm_nacionalidades').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                nation: {
                    required: true,
                    minlength: 3
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

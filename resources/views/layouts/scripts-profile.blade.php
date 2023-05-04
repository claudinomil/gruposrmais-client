<script type="text/javascript">
    $(function () {
        //Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        //Update Avatar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonUploadAvatar').click(function () {
            //Preparar
            $('#divUploadAvatar').show();
            $('#buttonUploadAvatar').hide();
            $('#buttonUploadAvatarClose').show();

            $('#buttonEditEmailClose').trigger('click');
            $('#buttonEditPasswordClose').trigger('click');
        });

        $('#buttonUploadAvatarClose').click(function () {
            //Preparar
            $('#divUploadAvatar').hide();
            $('#buttonUploadAvatar').show();
            $('#buttonUploadAvatarClose').hide();
        });

        $('#frm_upload_avatar').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-upload-avatar-error').text('');

            $.ajax({
                type:'POST',
                url: '/users/uploadavatar',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);

                    //colocando a imagem na view
                    var file = $("#avatar_file").get(0).files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(){
                            $("#imgImageAvatar").attr("src", reader.result);
                            $(".header-profile-user").attr("src", reader.result);
                        }
                        reader.readAsDataURL(file);
                    }
                },
                error: function(response){
                    alert(response);
                    $('#frm-upload-avatar-error').text('Avatar inválido!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Edit Email''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonEditEmail').click(function () {
            //Preparar
            $('#divEditEmail').show();
            $('#buttonEditEmail').hide();
            $('#buttonEditEmailClose').show();

            $('#buttonUploadAvatarClose').trigger('click');
            $('#buttonEditPasswordClose').trigger('click');
        });

        $('#buttonEditEmailClose').click(function () {
            //Preparar
            $('#divEditEmail').hide();
            $('#buttonEditEmail').show();
            $('#buttonEditEmailClose').hide();
        });

        $('#frm_edit_email').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-edit-email-error').text('');

            //Validando'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            validacao = true;

            $('#current-email-error').text('');
            $('#new-email-error').text('');

            if ($('#current_email').val() == '') {
                $('#current-email-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#new_email').val() == '') {
                $('#new-email-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#current_email').val() == $('#new_email').val()) {
                $('#current-email-error').text('E-mail Atual e E-mail Novo Iguais.');
                $('#new-email-error').text('E-mail Atual e E-mail Novo Iguais.');
                validacao = false;
            }

            if (!validacao) {return false;}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $.ajax({
                type:'POST',
                url: '/users/editemail',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                },
                error: function(response){
                    alert(response);
                    $('#frm-edit-email-error').text('Requisição com erro!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Edit Password'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonEditPassword').click(function () {
            //Preparar
            $('#divEditPassword').show();
            $('#buttonEditPassword').hide();
            $('#buttonEditPasswordClose').show();

            $('#buttonUploadAvatarClose').trigger('click');
            $('#buttonEditEmailClose').trigger('click');
        });

        $('#buttonEditPasswordClose').click(function () {
            //Preparar
            $('#divEditPassword').hide();
            $('#buttonEditPassword').show();
            $('#buttonEditPasswordClose').hide();
        });

        $('#frm_edit_password').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-edit-password-error').text('');

            //Validando'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            validacao = true;

            $('#current-password-error').text('');
            $('#new-password-error').text('');
            $('#confirm-new-password-error').text('');

            if ($('#current_password').val() == '') {
                $('#current-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#new_password').val() != $('#confirm_new_password').val()) {
                $('#new-password-error').text('Senha Nova e Confirmar Senha Nova Diferentes.');
                $('#confirm-new-password-error').text('Senha Nova e Confirmar Senha Nova Diferentes.');
                validacao = false;
            }

            if ($('#new_password').val().length < 10 || $('#new_password').val().length > 20) {
                $('#new-password-error').text('Campo precisa ter entre 10 e 20 caracteres.');
                validacao = false;
            }

            if ($('#new_password').val() == '') {
                $('#new-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if ($('#confirm_new_password').val().length < 10 || $('#confirm_new_password').val().length > 20) {
                $('#confirm-new-password-error').text('Campo precisa ter entre 10 e 20 caracteres.');
                validacao = false;
            }

            if ($('#confirm_new_password').val() == '') {
                $('#confirm-new-password-error').text('Campo é requerido.');
                validacao = false;
            }

            if (!validacao) {return false;}
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $.ajax({
                type:'POST',
                url: '/users/editpassword',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                },
                error: function(response){
                    alert(response);
                    $('#frm-edit-password-error').text('Requisição com erro!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    });
</script>

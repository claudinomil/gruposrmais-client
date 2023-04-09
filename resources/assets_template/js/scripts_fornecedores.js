$(document).ready(function () {
    if ($('#frm_fornecedores').length) {
        $('#frm_fornecedores').validate({
            rules: {
                status: {required: true},
                tipo: {required: true},
                name: {
                    required: true,
                    minlength: 3
                },
                nome_fantasia: {
                    required: false,
                    minlength: 3
                },
                inscricao_estadual: {
                    required: false,
                    numberMethod: true
                },
                inscricao_municipal: {
                    required: false,
                    numberMethod: true
                },
                cpf: {
                    required: false,
                    cpfMethod: true
                },
                cnpj: {
                    required: false,
                    cnpjMethod: true
                },
                identidade_orgao_id: {
                    required: false,
                    idMethod: true
                },
                identidade_estado_id: {
                    required: false,
                    idMethod: true
                },
                identidade_numero: {
                    required: false,
                    numberMethod: true
                },
                identidade_data_emissao: {
                    required: false,
                    dateMethod: true
                },
                genero_id: {
                    required: false,
                    idMethod: true
                },
                data_nascimento: {
                    required: false,
                    dateMethod: true
                },
                cep: {
                    required: false,
                    cepMethod: true
                },
                numero: {
                    required: false,
                    numberMethod: true
                },
                complemento: {
                    required: false,
                    minlength: 1
                },
                cep_cobranca: {
                    required: false,
                    cepMethod: true
                },
                numero_cobranca: {
                    required: false,
                    numberMethod: true
                },
                complemento_cobranca: {
                    required: false,
                    minlength: 1
                },
                banco_id: {
                    required: false,
                    idMethod: true
                },
                agencia: {
                    required: false,
                    minlength: 2,
                    numberMethod: true
                },
                conta: {
                    required: false,
                    minlength: 3,
                    numberMethod: true
                },
                email: {
                    required: false,
                    email: true
                },
                site: {
                    required: false,
                    url: true
                },
                telefone_1: {
                    required: false,
                    telephoneMethod: true
                },
                telefone_2: {
                    required: false,
                    telephoneMethod: true
                },
                celular_1: {
                    required: false,
                    cellularMethod: true
                },
                celular_2: {
                    required: false,
                    cellularMethod: true
                },
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

    //Acertar formulário para entrada de dados de pessoa Jurídica e Física
    if ($('#tipo').val() == 1) {
        $('.pessoa_juridica').show();
        $('.pessoa_fisica').hide();
    }

    if ($('#tipo').val() == 2) {
        $('.pessoa_juridica').hide();
        $('.pessoa_fisica').show();
    }

    $('#tipo').change(function (e) {
        if ($('#tipo').val() == 1) {
            $('.pessoa_juridica').show();
            $('.pessoa_fisica').hide();
        }

        if ($('#tipo').val() == 2) {
            $('.pessoa_juridica').hide();
            $('.pessoa_fisica').show();
        }
    });

    <!-- Script para Fornecedor "Botão Extra" -->
    $(function () {
        //Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        //Update Foto'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonUploadFornecedorExtraFoto').click(function () {
            //Preparar
            $('#divUploadFornecedorExtraFoto').show();
            $('#buttonUploadFornecedorExtraFoto').hide();
            $('#buttonUploadFornecedorExtraFotoClose').show();
        });

        $('#buttonUploadFornecedorExtraFotoClose').click(function () {
            //Preparar
            $('#divUploadFornecedorExtraFoto').hide();
            $('#buttonUploadFornecedorExtraFoto').show();
            $('#buttonUploadFornecedorExtraFotoClose').hide();
        });

        $('#frm_upload_fornecedor_extra_foto').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-upload-fornecedor-extra-foto-error').text('');

            $.ajax({
                type:'POST',
                url: '/fornecedores/uploadfoto',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error_permissao) {
                        alert(response.error_permissao);
                    } else {
                        alert(response);

                        //colocando a imagem na view
                        var file = $("#fornecedor_extra_foto_file").get(0).files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function () {
                                $("#imgImageFornecedorExtraFoto").attr("src", reader.result);
                                $(".header-profile-user").attr("src", reader.result);
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                },
                error: function(response){
                    alert(response);
                    $('#frm-upload-fornecedor-extra-foto-error').text('Foto inválida!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    });
});

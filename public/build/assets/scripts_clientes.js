$(document).ready(function () {
    if ($('#frm_clientes').length) {
        $('#frm_clientes').validate({
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

        $('#label_data_nascimento').html('Data Abertura');
    }

    if ($('#tipo').val() == 2) {
        $('.pessoa_juridica').hide();
        $('.pessoa_fisica').show();

        $('#label_data_nascimento').html('Data Nascimento');
    }

    $('#tipo').change(function(e) {
        if ($('#tipo').val() == 1) {
            $('.pessoa_juridica').show();
            $('.pessoa_fisica').hide();

            $('#label_data_nascimento').html('Data Abertura');
        }

        if ($('#tipo').val() == 2) {
            $('.pessoa_juridica').hide();
            $('.pessoa_fisica').show();

            $('#label_data_nascimento').html('Data Nascimento');
        }
    });

    $(function () {
        //Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        //Update Foto'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#buttonUploadClienteExtraFoto').click(function () {
            //Preparar
            $('#divUploadClienteExtraFoto').show();
            $('#buttonUploadClienteExtraFoto').hide();
            $('#buttonUploadClienteExtraFotoClose').show();
        });

        $('#buttonUploadClienteExtraFotoClose').click(function () {
            //Preparar
            $('#divUploadClienteExtraFoto').hide();
            $('#buttonUploadClienteExtraFoto').show();
            $('#buttonUploadClienteExtraFotoClose').hide();
        });

        $('#frm_upload_cliente_extra_foto').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#frm-upload-cliente-extra-foto-error').text('');

            $.ajax({
                type:'POST',
                url: '/clientes/uploadfoto',
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
                        var file = $("#cliente_extra_foto_file").get(0).files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function () {
                                $("#imgImageClienteExtraFoto").attr("src", reader.result);
                                $(".header-profile-user").attr("src", reader.result);
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                },
                error: function(response){
                    alert(response);
                    $('#frm-upload-cliente-extra-foto-error').text('Foto inválida!!!');
                }
            });
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //API CNPJ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#link_api_buscar').click(function () {
            //Buscando valor
            var cnpj = $('#cnpj').val();

            //Validando
            if ($('#cnpj').hasClass('is-invalid')) {
                alert($('#cnpj-error').html());
                return;
            } else if (cnpj == '') {
                alert('Informe um CNPJ.');
                return;
            }

            //Limpando mascara
            cnpj = cnpj.replace(/[^\d]+/g,"");

            //Indo no Controller buscar dados na API
            $.ajax({
                type:'GET',
                url: 'https://receitaws.com.br/v1/cnpj/'+cnpj,
                data: '',
                dataType: 'jsonp',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    //retorno da API
                    /*
                    abertura	"15/07/2016"
                    situacao	"INAPTA"
                    tipo	"MATRIZ"
                    nome	"CLAUDINO MIL HOMENS DE MORAES 01798241714"
                    fantasia	"CMDS INFORMATICA"
                    porte	"MICRO EMPRESA"
                    natureza_juridica	"213-5 - Empresário (Individual)"
                    logradouro	"RUA LINS DE VASCONCELOS"
                    numero	"579"
                    complemento	"APT 102"
                    municipio	"RIO DE JANEIRO"
                    bairro	"LINS DE VASCONCELOS"
                    uf	"RJ"
                    cep	"20.710-130"
                    email	"claudinomoraes@yahoo.com.br"
                    telefone	"(21) 6421-0128"
                    data_situacao	"12/01/2022"
                    motivo_situacao	"OMISSÃO DE DECLARAÇÕES"
                    cnpj	"25.221.403/0001-91"
                    ultima_atualizacao	"2023-03-11T23:59:59.000Z"
                    status	"OK"
                    efr	""
                    situacao_especial	""
                    data_situacao_especial	""
                    atividade_principal
                    0
                    code	"00.00-0-00"
                    text	"********"
                    atividades_secundarias
                    0
                    code	"00.00-0-00"
                    text	"Não informada"
                    capital_social	"1.00"
                    qsa	[]
                    extra	{}
                    billing
                    free	true
                    database	true
                    */

                    var dados = response;

                    // alert(dados.status);

                    if (dados.status != 'OK') {
                        alert(dados.message);
                    } else {
                        $('#td_api_situacao').html(dados.situacao);
                        $('#hidden_api_situacao').val(dados.situacao);
                        $('#td_api_tipo').html(dados.tipo);
                        $('#hidden_api_tipo').val(dados.tipo);
                        $('#td_api_natureza_juridica').html(dados.natureza_juridica);
                        $('#hidden_api_natureza_juridica').val(dados.natureza_juridica);
                        $('#td_api_nome').html(dados.nome);
                        $('#hidden_api_nome').val(dados.nome);
                        $('#td_api_fantasia').html(dados.fantasia);
                        $('#hidden_api_fantasia').val(dados.fantasia);
                        $('#td_api_cnpj').html(dados.cnpj);
                        $('#hidden_api_cnpj').val(dados.cnpj);
                        $('#td_api_abertura').html(dados.abertura);
                        $('#hidden_api_abertura').val(dados.abertura);
                        $('#td_api_cep').html(dados.cep.replace(/[^\d]+/g,""));
                        $('#hidden_api_cep').val(dados.cep.replace(/[^\d]+/g,""));
                        $('#td_api_telefone').html(dados.telefone);
                        $('#hidden_api_telefone').val(dados.telefone);
                        $('#td_api_email').html(dados.email);
                        $('#hidden_api_email').val(dados.email);
                        $('#td_api_logradouro').html(dados.logradouro);
                        $('#hidden_api_logradouro').val(dados.logradouro);
                        $('#td_api_numero').html(dados.numero);
                        $('#hidden_api_numero').val(dados.numero);
                        $('#td_api_complemento').html(dados.complemento);
                        $('#hidden_api_complemento').val(dados.complemento);
                        $('#td_api_bairro').html(dados.bairro);
                        $('#hidden_api_bairro').val(dados.bairro);
                        $('#td_api_municipio').html(dados.municipio);
                        $('#hidden_api_municipio').val(dados.municipio);
                        $('#td_api_uf').html(dados.uf);
                        $('#hidden_api_uf').val(dados.uf);
                    }

                    //abrir modal
                    $('#modal_api').modal('show');
                },
                error: function(){
                    alert('Erro na API.');
                }
            });
        });

        $('.button_api_copiar').click(function () {
            $('#name').val($('#hidden_api_nome').val());
            $('#nome_fantasia').val($('#hidden_api_fantasia').val());
            $('#data_nascimento').val($('#hidden_api_abertura').val());
            $('#cep').val($('#hidden_api_cep').val());
            $('#telefone_1').val($('#hidden_api_telefone').val());
            $('#email').val($('#hidden_api_email').val());
            $('#logradouro').val($('#hidden_api_logradouro').val());
            $('#numero').val($('#hidden_api_numero').val());
            $('#complemento').val($('#hidden_api_complemento').val());
            $('#bairro').val($('#hidden_api_bairro').val());
            $('#localidade').val($('#hidden_api_municipio').val());
            $('#uf').val($('#hidden_api_uf').val());

            //fechar modal
            $('#modal_api').modal('hide');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    });
});

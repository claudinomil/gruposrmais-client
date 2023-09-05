$(document).ready(function () {
    if ($('#frm_clientes_servicos').length) {
        $('#frm_clientes_servicos').validate({
            rules: {
                servico_status_id: {
                    required: true,
                    idMethod: true
                },
                cliente_id: {
                    required: true,
                    idMethod: true
                },
                servico_id: {
                    required: true,
                    idMethod: true
                },
                data_inicio: {
                    required: true,
                    dateMethod: true
                },
                data_fim: {
                    required: true,
                    dateMethod: true
                },
                data_vencimento: {
                    required: false,
                    dateMethod: true
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

    //Configurar Campos
    cs_configuracaoCampos();

    //Serviço
    $('#servico_id').on('change', function(e) {
        cs_configuracaoCampos();
    });

    //Buscar dados do Funcionário escolhido
    $('#bi_grade_funcionario_id').on('change', function(e) {
        if ($('#bi_grade_funcionario_id').val() != '') {
            bi_grade_funcionario_id = $('#bi_grade_funcionario_id').val();

            //Variavel de controle para saber se é para colocar na grade
            var colocar_grade = 1;

            //Verificar campos bi_escala_tipo_id e bi_quantidade_brigadistas_total
            if (colocar_grade == 1) {
                if ($('#bi_escala_tipo_id').val() == '' || $('#bi_quantidade_brigadistas_por_ala').val() == '' || $('#bi_quantidade_brigadistas_total').val() == '') {
                    alert("É preciso escolher a Escala/Qtd Brigadistas Ala.");
                    colocar_grade = 0;
                }
            }

            //Verificar grade
            if (colocar_grade == 1) {
                if (bi_gradeBrigadistasVerificacao(1) === false) {colocar_grade = 0;}
            }

            //Verificar se já existe na grade
            var qtd_na_grade = 0;
            if (colocar_grade == 1) {
                $("input[name='bi_funcionario_id[]']").each(function () {
                    qtd_na_grade++;

                    if (bi_grade_funcionario_id == $(this).val()) {
                        alert("Brigadista já está na grade.");
                        colocar_grade = 0;
                    }
                });
            }

            if (colocar_grade == 1) {
                //Header
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                $.ajax({
                    type: 'GET',
                    url: '/funcionarios/' + bi_grade_funcionario_id,
                    data: '',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        funcionario = response.success;

                        //copiar os dados para os campos
                        bi_gradeBrigadistasEscolher(1, funcionario.id, funcionario.name);
                    },
                    error: function (response) {
                        alert(response);
                    }
                });
            } else {
                //Atualizar dados do funcionario escolhido
                bi_gradeBrigadistasEscolher(0);
            }
        }
    });

    //Adicionar funcionario na grade
    $('#bi_funcionario_adicionar').click(function (e) {
        if ($('#bi_grade_funcionario_id').val() == '' || $('#bi_grade_ala').val() == '') {
            alert('Escolha um Funcionário e uma Ala.');
            return;
        }

        //Adicionar linha na grade
        bi_gradeBrigadistasAtualizar(1);

        //Atualizar dados do funcionario escolhido
        bi_gradeBrigadistasEscolher(0);
    });

    //Retirar funcionario na grade
    $('#bi_funcionario_retirar').click(function (e) {
        //Adicionar linha na grade
        bi_gradeBrigadistasAtualizar(3);

        //Atualizar dados do funcionario escolhido
        bi_gradeBrigadistasEscolher(0);
    });

    $('#bi_escala_tipo_id').change(function (e) {
        //Configuração conforme escala escolhida
        bi_configuracaoConformeEscala($('#bi_escala_tipo_id').val());
    });

    $('#bi_quantidade_brigadistas_por_ala').change(function (e) {
        bi_quantidadeBrigadistasTotal();
    });

    //Pegar dados da linha que clicou e jogar para o Funcionario Escolher
    $(document).on('click', '.bi_funcionario_linha', function() {
        var bi_grade_funcionario_id = $(this).data('id');
        var bi_grade_funcionario_nome = $('#funcionario_nome_td_'+bi_grade_funcionario_id).html();
        var bi_grade_funcionario_ala = $('#funcionario_ala_td_'+bi_grade_funcionario_id).html();

        bi_gradeBrigadistasEscolher(2, bi_grade_funcionario_id, bi_grade_funcionario_nome);
    });
});

$(document).ready(function () {
    if ($('#frm_propostas').length) {
        $('#frm_propostas').validate({
            rules: {
                data_proposta: {
                    required: false,
                    dateMethod: true
                },
                cliente_id: {
                    required: true,
                    idMethod: true
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

    //Botao gerarPdfProposta''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    $('.gerarPdfProposta').click(function () {
        //Passar pelo evento gerar_pdf_proposta do controller
        var registro_id = $('#registro_id').val();
        window.open("propostas/gerar_pdf/proposta/"+registro_id, '_blank');
    });
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Funções para o formulário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Criar Data da Proposta por extenso
    $('#data_proposta').change(function (e) {
        if ($('#data_proposta').val() != '') {
            data_extenso = dataExtenso(2, $('#data_proposta').val());
            $('#data_proposta_extenso').val(data_extenso);
        }
    });

    //Buscar dados do Cliente escolhido
    $('#cliente_id').change(function (e) {
        if ($('#cliente_id').val() != '') {
            cliente_id = $('#cliente_id').val();

            //Header
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

            $.ajax({
                type:'GET',
                url: '/clientes/'+cliente_id,
                data: '',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    cliente = response.success;

                    $('#cliente_nome').val(cliente.name);
                    $('#cliente_logradouro').val(cliente.logradouro);
                    $('#cliente_bairro').val(cliente.bairro);
                    $('#cliente_cidade').val(cliente.localidade);
                },
                error: function(response){
                    alert(response);
                }
            });
        }
    });

    //Buscar dados do Serviço escolhido
    $('#ts_servico_id').change(function (e) {
        if ($('#ts_servico_id').val() != '') {
            servico_id = $('#ts_servico_id').val();

            //Header
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

            $.ajax({
                type:'GET',
                url: '/servicos/'+servico_id,
                data: '',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    servico = response.success;

                    //copiar os dados para os campos
                    atualizarServicoEscolher(1, servico.id, servico.name, servico.valor, '1');
                },
                error: function(response){
                    alert(response);
                }
            });
        }
    });

    //Adicionar serviço na grade
    $('#ts_servico_adicionar').click(function (e) {
        if ($('#ts_servico_id').val() == '') {
            alert('Escolha um Serviço.');
            return;
        }

        if ($('#ts_valor').val() == '') {
            alert('Valor vazio.');
            return;
        }

        if ($('#ts_servico_qtd').val() == '' || $('#ts_servico_qtd').val() == '0' || $('#ts_servico_qtd').val() == 0) {
            alert('Digite uma quantidade.');
            return;
        }

        //Adicionar linha na grade
        atualizarServicoGrade(1);

        //Atualizar dados do Serviço escolhido
        atualizarServicoEscolher(0);
    });

    //Retirar serviço na grade
    $('#ts_servico_retirar').click(function (e) {
        //Adicionar linha na grade
        atualizarServicoGrade(3);

        //Atualizar dados do Serviço escolhido
        atualizarServicoEscolher(0);
    });

    //Pegar dados da linha que clicou e jogar para o Serviço Escolher
    $(document).on('click', '.ts_servico_linha', function() {
        servico_id = $(this).data('id');
        servico_nome = $('#ts_servico_nome_td_'+servico_id).html();
        servico_valor = $('#ts_servico_valor_td_'+servico_id).html();
        servico_valor = servico_valor.substring(3);
        servico_qtd = $('#ts_servico_qtd_td_'+servico_id).html();

        atualizarServicoEscolher(2, servico_id, servico_nome, servico_valor, servico_qtd);
    });

    // //Atualiza/Limpa os dados do Serviço escolhido para grade
    // //operacao = 0 : Limpar
    // //operacao = 1 : Adicionar
    // //operacao = 2 : Atualizar
    // //operacao = 3 : Retirar
    // function atualizarServicoEscolher(operacao, servico_id='', servico_nome='', servico_valor='', servico_qtd='') {
    //     if (operacao == 0) {
    //         //campos
    //         $('#ts_servico_id').val(servico_id);
    //         $('#select2-ts_servico_id-container').html(servico_nome);
    //         $('#ts_servico_nome').val(servico_nome);
    //         $('#ts_servico_valor').val(servico_valor);
    //         $('#ts_servico_qtd').val(servico_qtd);
    //
    //         //botoes
    //         $('#ts_servico_adicionar_div').hide();
    //         $('#ts_servico_atualizar_div').hide();
    //         $('#ts_servico_retirar_div').hide();
    //     }
    //
    //     if (operacao == 1) {
    //         //campos
    //         $('#ts_servico_nome').val(servico_nome);
    //         $('#ts_servico_valor').val(servico_valor);
    //         $('#ts_servico_qtd').val(servico_qtd);
    //
    //         //botoes
    //         $('#ts_servico_adicionar_div').show();
    //         $('#ts_servico_atualizar_div').hide();
    //         $('#ts_servico_retirar_div').hide();
    //     }
    //
    //     if (operacao == 2) {
    //         //campos
    //         $('#ts_servico_id').val(servico_id);
    //         $('#select2-ts_servico_id-container').html(servico_nome);
    //         $('#ts_servico_nome').val(servico_nome);
    //         $('#ts_servico_valor').val(servico_valor);
    //         $('#ts_servico_qtd').val(servico_qtd);
    //
    //         //botoes
    //         $('#ts_servico_adicionar_div').hide();
    //         $('#ts_servico_atualizar_div').hide();
    //         $('#ts_servico_retirar_div').show();
    //     }
    // }
    //
    // //Atualizar a Grade de Serviço
    // //operacao = 0 : Somente atualiza os valores
    // //operacao = 1 : Adicionar
    // //operacao = 2 : Atualizar
    // //operacao = 3 : Retirar
    // function atualizarServicoGrade(operacao) {
    //     if (operacao == 1) {
    //         //Dados para preenchera linha da grade
    //         servico_id = $('#ts_servico_id').val();
    //         servico_nome = $('#ts_servico_nome').val();
    //         servico_valor = $('#ts_servico_valor').val();
    //         servico_qtd = $('#ts_servico_qtd').val();
    //         servico_valor_total = servico_qtd * moeda2float(servico_valor);
    //         servico_valor_total = float2moeda(servico_valor_total);
    //
    //         //Montar Linha
    //         var linha;
    //
    //         linha = "<tr class='ts_servico_linha' id='ts_servico_linha_" + servico_id + "' data-id='" + servico_id + "' style='cursor: pointer'>";
    //         linha += "  <td class='text-center ts_servico_item' data-id='" + servico_id + "'></td>";
    //         linha += "  <td id='ts_servico_nome_td_" + servico_id + "'>" + servico_nome + "</td>";
    //         linha += "  <td id='ts_servico_valor_td_" + servico_id + "' class='text-end'>R$ " + servico_valor + "</td>";
    //         linha += "  <td id='ts_servico_qtd_td_" + servico_id + "' class='text-center'>" + servico_qtd + "</td>";
    //         linha += "  <td class='text-end ts_servico_valor_total'>R$ " + servico_valor_total + "</td>";
    //         linha += "</tr>"
    //
    //         //Adicionar linha na grade
    //         $('#ts_servico_grade').append(linha);
    //     }
    //
    //     if (operacao == 3) {
    //         //Dados
    //         servico_id = $('#ts_servico_id').val();
    //
    //         //Remover linha da grade
    //         $('#ts_servico_linha_'+servico_id).remove();
    //     }
    //
    //     //Atualizando numeração das linhas da coluna Item
    //     ln = 0;
    //     $('.ts_servico_item').each(function( index ) {
    //         ln++;
    //         $(this).html(ln);
    //     });
    //
    //     //Atualizando Valor Global
    //     var valor_global = 0;
    //     var valor_total = 0;
    //     $('.ts_servico_valor_total').each(function() {
    //         valor_total = $(this).html();
    //         valor_total = valor_total.substring(3);
    //         valor_total = moeda2float(valor_total);
    //
    //         valor_global = valor_global + valor_total;
    //     });
    //
    //     $('#ts_servico_valor_global').html('R$ '+float2moeda(valor_global));
    //
    //     //Atualizar Valor Total da Proposta
    //     atualizarValorTotalProposta(valor_global);
    // }
    //
    // //Atualizar o Valor Total da Proposta
    // function atualizarValorTotalProposta(valor_global) {
    //     var porcentagem_desconto = $('#porcentagem_desconto').val();
    //     if (porcentagem_desconto ==  '') {$('#porcentagem_desconto').val('0');}
    //
    //     var valor_desconto = $('#valor_desconto').val();
    //     if (valor_desconto ==  '') {$('#valor_desconto').val('0,00');}
    //
    //     var valor_desconto_extenso = valorExtenso(0);
    //     $('#valor_desconto_extenso').val(valor_desconto_extenso);
    //
    //     var valor_total = float2moeda(valor_global);
    //     $('#valor_total').val(valor_total);
    //
    //     var valor_total_extenso = valorExtenso(valor_global);
    //     $('#valor_total_extenso').val(valor_total_extenso);
    // }
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
});

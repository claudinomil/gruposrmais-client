$(document).ready(function () {
    if ($('#frm_escalas').length) {
        $('#frm_escalas').validate({
            rules: {},
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

    $(function () {
        //Header
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        //Abrir Grade de Escalas do Cliente
        $('body').on('click', '.escalasBrigada', function () {
            //Campo hidden registro_id
            if ($(this).data('id') != 0) {
                $('#registro_id').val($(this).data('id'));
            }

            //Loading
            $('#escalasFormAjaxLoading').show();

            //Buscar dados do Registro
            $.get("brigadas/"+$('#registro_id').val()+"/edit", function (data) {
                //Lendo dados
                if (data.success) {
                    //Campo hidden frm_operacao
                    $('#frm_operacao').val('edit');

                    //Table Show/Hide
                    $('#crudTable').hide();

                    //Modal Show/Hide
                    $('#crudForm').hide();

                    //Escalas Form
                    $('#escalasForm').show();

                    //Rondas Form
                    $('#rondasForm').hide();

                    //Preencher o Formulário com Informações do Serviço
                    bi_preencherFormulario(data.success);

                    //Títulos
                    $('#currentPageTitle span').html(' (ESCALAS)');
                    $('#escalasForm #titulo').html($('#is_cliente').val());

                    //Filtro de datas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                    let clientes_servicos_servico = data.success.clientes_servicos_servico;

                    //Data início e fim do Serviço para visialização do usuário
                    $('#divPeriodoDatasEscalas').html('Período acesso: '+clientes_servicos_servico.data_inicio+' até '+clientes_servicos_servico.data_fim);

                    //Datas Y-m-d
                    var data_inicio = clientes_servicos_servico.data_inicio;
                    var data_inicio_y_m_d = data_inicio.substring(6, 10)+'-'+data_inicio.substring(3, 5)+'-'+data_inicio.substring(0, 2);

                    var data_fim = clientes_servicos_servico.data_fim;
                    var data_fim_y_m_d = data_fim.substring(6, 10)+'-'+data_fim.substring(3, 5)+'-'+data_fim.substring(0, 2);

                    //Campos
                    $('#es_periodo_data_1').attr('min', data_inicio_y_m_d).attr('max', data_fim_y_m_d);
                    $('#es_periodo_data_2').attr('min', data_inicio_y_m_d).attr('max', data_fim_y_m_d);
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Buscar dados das Escalas solicitadas de acordo com operiodo de datas para colocar na grade''''''''

                    //Colocar data_inicio e data_fim como periodo inicial
                    $('#es_periodo_data_1').val(data_inicio_y_m_d);
                    $('#es_periodo_data_2').val(data_fim_y_m_d);

                    bi_montarGradeEscala();
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                } else if (data.error_not_found) {
                    alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
                } else if (data.error_permissao) {
                    alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                } else {
                    alert('Erro interno');
                }
            });

            //Loading
            $('#escalasFormAjaxLoading').hide();
        });

        //Cancel Operacao e voltar para Grade de Brigadas de Incêndios
        $('.escalasFormCancelOperacao').click(function (e) {
            e.preventDefault();

            //Table Show/Hide
            $('#crudTable').show();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').hide();

            //Rondas Form
            $('#rondasForm').hide();

            //Título
            $('#currentPageTitle span').html('');
        });

        //Botão Escalas
        $('#btnGradeEscalas').click(function () {
            //Buscar dados das Escalas solicitadas de acordo com operiodo de datas para colocar na grade
            bi_montarGradeEscala();
        });

        //Botão Editar Escala (Edita em um Modal)
        $('body').on('click', '.btnEditarEscala', function () {
            //Informações da Escala Selecionada para Editar
            var id = $(this).data('id');
            var funcionario_nome = $(this).data('funcionario_nome');
            var data_chegada = $(this).data('data_chegada');
            var hora_chegada = $(this).data('hora_chegada');
            var data_saida = $(this).data('data_saida');
            var hora_saida = $(this).data('hora_saida');

            //Campo
            $('#brigada_escala_id').val(id);
        });
    });
});

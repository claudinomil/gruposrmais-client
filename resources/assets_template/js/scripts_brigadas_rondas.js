$(document).ready(function () {
    if ($('#frm_rondas').length) {
        $('#frm_rondas').validate({
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

        //Visualizar Ronda
        $('body').on('click', '.btnViewRonda', function () {
            //Campo brigada_escala_id
            var brigada_ronda_id = $(this).data('id');

            //Preencher Campo hidden brigada_ronda_id
            $('#frm_rondas #brigada_ronda_id').val(brigada_ronda_id);

            //Table Show/Hide
            $('#crudTable').hide();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').hide();

            // Rondas Form
            $('#rondasForm').show();

            //Título
            $('#currentPageTitle span').html(' (RONDAS)');
            $('#rondasForm #titulo').html($('#is_cliente').val());

            //Título2
            $('#rondasForm #titulo2').html($(this).data('funcionario_nome')+' ('+$(this).data('data_chegada')+' às '+$(this).data('hora_chegada')+' até '+$(this).data('data_saida')+' às '+$(this).data('hora_saida')+')');

            //Loading
            $('#rondasFormAjaxLoading').show();

            //Buscar dados
            $.get("brigadas/ronda_cliente_seguranca_medidas/2/"+'0'+'/'+brigada_ronda_id, function (data) {
                //Lendo dados
                if (data.success) {
                    formularioRonda(2, data.success);
                } else {
                    alert('Erro interno');
                }
            });

            //Loading
            $('#rondasFormAjaxLoading').hide();
        });

        //Cancel Operacao e voltar para Grade de Escalas
        $('.crudCancelarOperacaoRondas').click(function (e) {
            e.preventDefault();

            //Table Show/Hide
            $('#crudTable').hide();

            //Modal Show/Hide
            $('#crudForm').hide();

            //Escalas Form
            $('#escalasForm').show();

            //Rondas Form
            $('#rondasForm').hide();

            //Título
            $('#currentPageTitle span').html(' (ESCALAS)');
        });
    });
});

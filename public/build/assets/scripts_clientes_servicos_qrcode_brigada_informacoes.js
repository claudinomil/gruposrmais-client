$(document).ready(function () {
    $(function () {
        //Header
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        //Visualizar Ronda
        $('body').on('click', '.btnViewRonda', function () {
            //Campo brigada_ronda_id
            var brigada_ronda_id = $(this).data('id');

            //Rondas Tab
            $('#tab_rondas').tab('show');

            //Título
            $('#rondas #titulo').html('<b>'+$(this).data('funcionario_nome')+'</b>'+'<br>'+'<b>Ronda feita:</b> '+$(this).data('data')+' às '+$(this).data('hora'));

            //Loading
            $('#rondasFormAjaxLoading').show();

            //URL
            var url_atual = window.location.protocol+'//'+window.location.host+'/';

            //Buscar dados
            $.get(url_atual+"brigadas/ronda_cliente_seguranca_medidas/2/"+'0'+'/'+brigada_ronda_id, function (data) {
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

        //Executar ao entrar (splash-screen)
        setTimeout(function() {
            $('body').css({'background-color': ''});
            $('#splash-screen').hide();
            $('#content-screen').show();
        }, 3000);
    });
});

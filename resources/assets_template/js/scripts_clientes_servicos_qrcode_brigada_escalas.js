$(document).ready(function () {
    if ($('#frm_qrcode_brigada_escalas').length) {
        $('#frm_qrcode_brigada_escalas').validate({
            rules: {
                password: {
                    required: true
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

    $(function () {
        //Header
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        //URL
        var url_atual = window.location.protocol+'//'+window.location.host+'/';

        //Executar ao entrar (splash-screen)
        setTimeout(function() {
            $('body').css({'background-color': ''});
            $('#splash-screen').hide();
            $('#content-screen').show();
        }, 2000);

        //Iniciar Serviço
        $('body').on('click', '#btnIniciarServico', function () {
            //Inserindo valor no campo brigada_escala_operacao
            $('#brigada_escala_operacao').val('1');

            //Limpar dados do Formulário
            $('#brigada_escala_id').val('');
            $('#email').val('');
            $('#foto_real').val('');
            $('#password').val('');
            $('#divMedidasSegurancaRondaItens').html('');

            //Buscar Dados vindos do Botão
            var brigada_escala_id = $(this).data('brigada_escala_id');
            var funcionario_nome = $(this).data('funcionario_nome');
            var usuario_email = $(this).data('usuario_email');
            var funcionario_foto = $(this).data('funcionario_foto');
            var cor_ala = $(this).data('cor_ala');
            var ala = $(this).data('ala');
            var escala_tipo_nome = $(this).data('escala_tipo_nome');
            var data_chegada = $(this).data('data_chegada');
            var hora_chegada = $(this).data('hora_chegada');
            var data_saida = $(this).data('data_saida');
            var hora_saida = $(this).data('hora_saida');

            //Preencher dados na Div
            $('.formFoto').attr('src', url_atual+funcionario_foto);

            $('.formAla').removeClass('bg-success');
            $('.formAla').removeClass('bg-primary');
            $('.formAla').removeClass('bg-danger');
            $('.formAla').removeClass('bg-warning');
            $('.formAla').removeClass('bg-pink');
            $('.formAla').addClass(cor_ala);
            $('.formAla').html(ala);

            $('.formFuncionarioNome').html(funcionario_nome);
            $('.formDadosEscala').html('Escala: '+escala_tipo_nome+'<br>'+'Início: '+data_chegada+' às '+hora_chegada+'hs'+'<br>'+'Fim: '+data_saida+' às '+hora_saida+'hs');

            //Preencher dados do Formulário
            $('#brigada_escala_id').val(brigada_escala_id);
            $('#email').val(usuario_email);

            //Hide/Show
            $('.divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-none');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-block');

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });

        //Iniciar Ronda
        $('body').on('click', '#btnIniciarRonda', function () {
            //Inserindo valor no campo brigada_escala_operacao
            $('#brigada_escala_operacao').val('2');

            //Limpar dados do Formulário
            $('#brigada_escala_id').val('');
            $('#email').val('');
            $('#foto_real').val('');
            $('#data_inicio_ronda').val(dataServidor(1));
            $('#hora_inicio_ronda').val(horaServidor(1));
            $('#password').val('');
            $('#divMedidasSegurancaRondaItens').html('');

            //Buscar Dados vindos do Botão
            var brigada_escala_id = $(this).data('brigada_escala_id');
            var funcionario_nome = $(this).data('funcionario_nome');
            var usuario_email = $(this).data('usuario_email');
            var funcionario_foto = $(this).data('funcionario_foto');
            var cor_ala = $(this).data('cor_ala');
            var ala = $(this).data('ala');
            var escala_tipo_nome = $(this).data('escala_tipo_nome');
            var data_chegada = $(this).data('data_chegada');
            var hora_chegada = $(this).data('hora_chegada');
            var data_saida = $(this).data('data_saida');
            var hora_saida = $(this).data('hora_saida');

            //Preencher dados na Div
            $('.formFoto').attr('src', url_atual+funcionario_foto);

            $('.formAla').removeClass('bg-success');
            $('.formAla').removeClass('bg-primary');
            $('.formAla').removeClass('bg-danger');
            $('.formAla').removeClass('bg-warning');
            $('.formAla').removeClass('bg-pink');
            $('.formAla').addClass(cor_ala);
            $('.formAla').html(ala);

            $('.formFuncionarioNome').html(funcionario_nome);
            $('.formDadosEscala').html('Escala: '+escala_tipo_nome+'<br>'+'Início: '+data_chegada+' às '+hora_chegada+'hs'+'<br>'+'Fim: '+data_saida+' às '+hora_saida+'hs');

            //Preencher dados do Formulário
            $('#brigada_escala_id').val(brigada_escala_id);
            $('#email').val(usuario_email);

            //Montar itens de Segurança Medidas da Ronda
            var brigada_escala_id = $('#brigada_escala_id').val();

            $.get(url_atual+"brigadas/ronda_cliente_seguranca_medidas/1/"+brigada_escala_id+'/'+'0', function (data) {
                if (data.success) {
                    formularioRonda(1, data.success);
                } else {
                    alert('Erro interno');
                }
            });

            //Hide/Show
            $('.divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-none');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-block');

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });

        //Encerrar Serviço
        $('body').on('click', '#btnEncerrarServico', function () {
            //Inserindo valor no campo brigada_escala_operacao
            $('#brigada_escala_operacao').val('3');

            //Limpar dados do Formulário
            $('#brigada_escala_id').val('');
            $('#email').val('');
            $('#foto_real').val('');
            $('#password').val('');
            $('#divMedidasSegurancaRondaItens').html('');

            //Buscar Dados vindos do Botão
            var brigada_escala_id = $(this).data('brigada_escala_id');
            var funcionario_nome = $(this).data('funcionario_nome');
            var usuario_email = $(this).data('usuario_email');
            var funcionario_foto = $(this).data('funcionario_foto');
            var cor_ala = $(this).data('cor_ala');
            var ala = $(this).data('ala');
            var escala_tipo_nome = $(this).data('escala_tipo_nome');
            var data_chegada = $(this).data('data_chegada');
            var hora_chegada = $(this).data('hora_chegada');
            var data_saida = $(this).data('data_saida');
            var hora_saida = $(this).data('hora_saida');

            //Preencher dados na Div
            $('.formFoto').attr('src', url_atual+funcionario_foto);

            $('.formAla').removeClass('bg-success');
            $('.formAla').removeClass('bg-primary');
            $('.formAla').removeClass('bg-danger');
            $('.formAla').removeClass('bg-warning');
            $('.formAla').removeClass('bg-pink');
            $('.formAla').addClass(cor_ala);
            $('.formAla').html(ala);

            $('.formFuncionarioNome').html(funcionario_nome);
            $('.formDadosEscala').html('Escala: '+escala_tipo_nome+'<br>'+'Início: '+data_chegada+' às '+hora_chegada+'hs'+'<br>'+'Fim: '+data_saida+' às '+hora_saida+'hs');

            //Preencher dados do Formulário
            $('#brigada_escala_id').val(brigada_escala_id);
            $('#email').val(usuario_email);

            //Hide/Show
            $('.divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-none');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-block');

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });

        //Quando clicar no botão btnTirarFotoFrontal
        $('body').on('click', '#btnTirarFotoFrontal', function () {
            //Elementos
            const canvasFrontal = document.getElementById('canvasFrontal');
            const photoFrontal = document.getElementById('photoFrontal');
            const foto_real = document.getElementById('foto_real');

            //Capturando Foto
            canvasFrontal.width = videoFrontal.videoWidth;
            canvasFrontal.height = videoFrontal.videoHeight;
            canvasFrontal.getContext('2d').drawImage(videoFrontal, 0, 0, canvasFrontal.width, canvasFrontal.height);
            photoFrontal.src = canvasFrontal.toDataURL('image/png');
            foto_real.value = canvasFrontal.toDataURL('image/png');

            //Parar a captura da câmera
            stopCameraFrontal();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(2);
        });

        //Quando clicar no botão btnExcluirFotoFrontal
        $('body').on('click', '#btnExcluirFotoFrontal', function () {
            //Limpar dados
            foto_real.value = '';
            photoFrontal.src = '';

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });

        //Quando clicar no botão btnTirarFotoTraseira
        $('body').on('click', '#btnTirarFotoTraseira', function () {
            //Campos hidden
            var pavimento = $('#fotoTraseiraPavimento').val();
            var seguranca_medida_id = $('#fotoTraseiraSegurancaMedidaId').val();

            //Elementos
            const canvasTraseira = document.getElementById('canvasTraseira');
            const photoTraseira = document.getElementById('photoTraseira');
            const fotoIdTraseira = document.getElementById('foto_'+pavimento+'_'+seguranca_medida_id);

            //Capturando Foto
            canvasTraseira.width = videoTraseira.videoWidth;
            canvasTraseira.height = videoTraseira.videoHeight;
            canvasTraseira.getContext('2d').drawImage(videoTraseira, 0, 0, canvasTraseira.width, canvasTraseira.height);
            photoTraseira.src = canvasTraseira.toDataURL('image/png');
            fotoIdTraseira.value = canvasTraseira.toDataURL('image/png');

            //Colocar link para ver foto
            formularioRondaBotaoVerFoto(pavimento, seguranca_medida_id);

            //Parar a captura da câmera
            stopCameraTraseira();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoTraseira(3);
        });

        //Quando clicar no botão btnExcluirFotoTraseira
        $('body').on('click', '#btnExcluirFotoTraseira', function () {
            //Campos hidden
            var pavimento = $('#fotoTraseiraPavimento').val();
            var seguranca_medida_id = $('#fotoTraseiraSegurancaMedidaId').val();

            //Elementos
            const photoTraseira = document.getElementById('photoTraseira');
            const fotoIdTraseira = document.getElementById('foto_'+pavimento+'_'+seguranca_medida_id);

            //Limpar dados
            fotoIdTraseira.value = '';
            photoTraseira.src = '';

            //Apagar link para ver foto
            $('#botaoVerFoto_'+pavimento+'_'+seguranca_medida_id).html('&nbsp;');

            //Iniciar Captura de Vídeo
            startCameraTraseira();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoTraseira(3);
        });

        //Confirmar
        $('#btnConfirmarOperacao').click(function (e) {
            e.preventDefault();

            //Verificar Validação feita com sucesso
            if ($('#frm_qrcode_brigada_escalas').valid()) {
                //Validar campos hidden'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                if ($('#brigada_escala_operacao').val() == '') {
                    alert('Erro ao capturar Operação. Refaça o Procedimento.');
                    return false;
                }

                if ($('#brigada_escala_id').val() == '') {
                    alert('Erro ao capturar Operação. Refaça o Procedimento.');
                    return false;
                }

                if ($('#email').val() == '') {
                    alert('E-mail do Brigadista não encontrado. É preciso ser Usuário do Sistema com referência ao Funcionário Brigadista.');
                    return false;
                }

                if ($('#foto_real').val() == '') {
                    alert('Erro ao capturar a Foto. Tire a Foto ou Refaça o Procedimento.');
                    return false;
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Validar campos quando for Confirmar Ronda'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                if ($('#brigada_escala_operacao').val() == 2) {
                    if (!formularioRondaValidar()) {return false;}
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Ajax
                $.ajax({
                    data: $('#frm_qrcode_brigada_escalas').serialize(),
                    url: url_atual+"qrcodes/clientes_servicos/qrcode_brigada_escala_operacao_salvar/"+$('#brigada_escala_id').val(),
                    type: "PUT",
                    dataType: "json",
                    beforeSend: function () {
                        //preloader
                        $('#preloader').show();
                    },
                    success: function (response) {
                        //Lendo dados
                        if (response.success) {
                            //Iniciar Serviço/Iniciar Ronda/Encerrar Serviço
                            if ($('#brigada_escala_operacao').val() == 1) {var bg_color = 'bg-success';   var texto_retorno = 'Chegada Confirmada com sucesso.';}
                            if ($('#brigada_escala_operacao').val() == 2) {var bg_color = 'bg-warning';   var texto_retorno = 'Ronda Confirmada com sucesso.';}
                            if ($('#brigada_escala_operacao').val() == 3) {var bg_color = 'bg-primary';   var texto_retorno = 'Saída Confirmada com sucesso.';}

                            //Colocar na DIV
                            $('#divOperacaoFormularioResultado').addClass(bg_color);
                            $('#divOperacaoFormularioResultado').html('<div class="col-12 text-center text-white font-size-16"><i class="bx bx-check-double font-size-24"></i> '+texto_retorno+'</div>');
                        } else if (response.error) {
                            //Montar Título Alert
                            if ($('#brigada_escala_operacao').val() == 1) {var alert_titulo = 'Brigada Escala - Iniciar Serviço';}
                            if ($('#brigada_escala_operacao').val() == 2) {var alert_titulo = 'Brigada Escala - Iniciar Ronda';}
                            if ($('#brigada_escala_operacao').val() == 3) {var alert_titulo = 'Brigada Escala - Encerrar Serviço';}

                            alertSwal('warning', alert_titulo, response.error, 'true', 20000);
                        } else {
                            alert('Erro interno');
                        }
                    },
                    error: function (data) {
                        alert('Erro interno');
                    },
                    complete: function () {
                        //preloader
                        $('#preloader').hide()
                    }
                });
            }
        });

        //Cancelar
        $('body').on('click', '#btnCancelarOperacao', function () {
            //Hide/Show
            $('.divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-block');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-none');

            //Parar a captura da câmera
            stopCameraFrontal();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(2);
        });
    });
});

$(document).ready(function () {
    if ($('#frm_qrcode_brigada_escalas').length) {
        $('#frm_qrcode_brigada_escalas').validate({
            rules: {
                email: {
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
            $('#divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-none');
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
            $('#divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-none');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-block');

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });

        //Código para capturar o vídeo e tirar foto'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        let videoStream; // Variável para armazenar a referência à stream de vídeo

        //Função para iniciar a captura da câmera
        function startCameraFrontal() {
            //Verifica se o navegador suporta a API de captura de mídia
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                //Define a largura e a altura desejadas para o vídeo (NÃO FUNCIONA CORRETAMENTE / PEGA O TAMANHO PADRÃO)
                const videoWidth = 0;
                const videoHeight = 0;

                //Solicita permissão para acessar a câmera
                navigator.mediaDevices.getUserMedia({ video: { width: videoWidth, height: videoHeight } })
                    .then(function (stream) {
                        //O usuário concedeu permissão para acessar a câmera (Obtém elementos do DOM)
                        videoStream = stream; // Armazena a referência à stream
                        const video = document.getElementById('video');
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function (error) {
                        // O usuário negou a permissão ou ocorreu um erro
                        alert('Erro ao acessar a câmera:'+error);
                    });
            } else {
                alert('Seu navegador não suporta a API de captura de mídia.');
            }
        }

        //Função para parar a captura da câmera
        function stopCameraFrontal() {
            if (videoStream) {
                const tracks = videoStream.getTracks();
                tracks.forEach(function (track) {
                    track.stop(); // Para cada faixa de vídeo
                });

                videoStream = null; // Limpa a referência à stream
            }
        }

        //Função para montar layout para Tirar/Excluir Foto
        function layoutTirarExcluirFotoFrontal(op) {
            //Layout para Tirar Foto
            if (op == 1) {
                //Hide / Show
                $('#btnTirarFotoFrontal').show();
                $('#btnExcluirFotoFrontal').hide();

                $('#video').show();
                $('#canvas').show();
                $('#photo').hide();
            }

            //Layout para Excluir Foto
            if (op == 2) {
                //Hide / Show
                $('#btnTirarFotoFrontal').hide();
                $('#btnExcluirFotoFrontal').show();

                $('#video').hide();
                $('#canvas').hide();
                $('#photo').show();
            }
        }

        //Quando clicar no botão btnTirarFotoFrontal
        $('body').on('click', '#btnTirarFotoFrontal', function () {
            //Elementos
            const canvas = document.getElementById('canvas');
            const photo = document.getElementById('photo');
            const foto_real = document.getElementById('foto_real');

            //Capturando Foto
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            photo.src = canvas.toDataURL('image/png');
            foto_real.value = canvas.toDataURL('image/png');

            //Parar a captura da câmera
            stopCameraFrontal();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(2);
        });

        //Quando clicar no botão btnExcluirFotoFrontal
        $('body').on('click', '#btnExcluirFotoFrontal', function () {
            //Limpar dados
            foto_real.value = '';
            photo.src = '';

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(1);

            //Iniciar Captura de Vídeo
            startCameraFrontal();
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Confirmar Chegada/Saída
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
                            alertSwal('warning', 'Brigada Escala - Chegada e Saída', response.error, 'true', 20000);
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

        //Cancelar Confirmação de Chegada e Saída
        $('body').on('click', '#btnCancelarOperacao', function () {
            //Hide/Show
            $('#divsEscalaBrigadistasOperacoes').removeClass('d-block').removeClass('d-none').addClass('d-block');
            $('#divEscalaBrigadistaOperacao').removeClass('d-block').removeClass('d-none').addClass('d-none');

            //Parar a captura da câmera
            stopCameraFrontal();

            //Layout Tirar/Excluir Foto
            layoutTirarExcluirFotoFrontal(2);
        });
    });
});
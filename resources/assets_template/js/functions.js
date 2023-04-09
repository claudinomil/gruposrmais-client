function clienteExtraData(id='') {
    //Verificar se mandou id ou se veio do registro_id
    if (id == '') {id = $('#registro_id').val();}

    //URL
    var url_atual = window.location.protocol+'//'+window.location.host+'/';

    //Ajax
    $.ajax({
        processing: true,
        serverSide: true,
        type: "GET",
        url: url_atual+"clientes/extradata/"+id,
        data: {},
        datatype: "json",
        success: function (response) {
            //Lendo json
            let json = JSON.parse(response);

            //Lendo dados cliente
            let cliente = json.cliente;


            alert(cliente.foto);


            //Passando dados cliente
            $('.jsonClienteFoto').attr('src', url_atual+cliente.foto);

            if (cliente.status == '1') {nameStatus = 'Ativo';}
            if (cliente.status == '2') {nameStatus = 'Inativo';}
            $('.jsonClienteStatus').html(nameStatus);

            if (cliente.tipo == '1') {nameTipo = 'Pessoa Jurídica';}
            if (cliente.tipo == '2') {nameTipo = 'Pessoa Física';}
            $('.jsonClienteTipo').html(nameTipo);

            $('.jsonClienteGenero').html(cliente.generoName);
            $('.jsonClienteName').html(cliente.name);

            $('.jsonClienteId').val(cliente.id);
            $('.jsonClienteEmail').html(cliente.email);
            $('.jsonClienteSite').html(cliente.site);

            //Lendo dados transacoes (Totais)
            let transacoesCount = json.transacoesCount;

            //Lendo dados transacoes (Tabela)
            let transacoesTable = json.transacoesTable.transacoes;

            var tbodyTransacoes = '';

            if (transacoesTable != '') {
                //Passando dados transacoes (Tabela)
                var row = 0;

                function montarTable(item) {
                    row++;
                    operacaoName = item;

                    tbodyTransacoes += "<tr><th scope='row'>" + row + "</th><td>" + operacaoName + "</td></tr>";
                }

                transacoesTable.forEach(montarTable);
            }

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonClienteTransacoesTable').html(tbodyTransacoes);
            configurarDataTable(2);
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

function fornecedorExtraData(id='') {
    //Verificar se mandou id ou se veio do registro_id
    if (id == '') {id = $('#registro_id').val();}

    //URL
    var url_atual = window.location.protocol+'//'+window.location.host+'/';

    //Ajax
    $.ajax({
        processing: true,
        serverSide: true,
        type: "GET",
        url: url_atual+"fornecedores/extradata/"+id,
        data: {},
        datatype: "json",
        success: function (response) {
            //Lendo json
            let json = JSON.parse(response);

            //Lendo dados fornecedor
            let fornecedor = json.fornecedor;

            //Passando dados fornecedor
            $('.jsonFornecedorFoto').attr('src', url_atual+fornecedor.foto);

            if (fornecedor.status == '1') {nameStatus = 'Ativo';}
            if (fornecedor.status == '2') {nameStatus = 'Inativo';}
            $('.jsonFornecedorStatus').html(nameStatus);

            if (fornecedor.tipo == '1') {nameTipo = 'Pessoa Jurídica';}
            if (fornecedor.tipo == '2') {nameTipo = 'Pessoa Física';}
            $('.jsonFornecedorTipo').html(nameTipo);

            $('.jsonFornecedorGenero').html(fornecedor.generoName);
            $('.jsonFornecedorName').html(fornecedor.name);

            $('.jsonFornecedorId').val(fornecedor.id);
            $('.jsonFornecedorEmail').html(fornecedor.email);
            $('.jsonFornecedorSite').html(fornecedor.site);

            //Lendo dados transacoes (Totais)
            let transacoesCount = json.transacoesCount;

            //Lendo dados transacoes (Tabela)
            let transacoesTable = json.transacoesTable.transacoes;

            var tbodyTransacoes = '';

            if (transacoesTable != '') {
                //Passando dados transacoes (Tabela)
                var row = 0;

                function montarTable(item) {
                    row++;
                    operacaoName = item;

                    tbodyTransacoes += "<tr><th scope='row'>" + row + "</th><td>" + operacaoName + "</td></tr>";
                }

                transacoesTable.forEach(montarTable);
            }

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonFornecedorTransacoesTable').html(tbodyTransacoes);
            configurarDataTable(2);
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

function funcionarioExtraData(id='') {
    //Verificar se mandou id ou se veio do registro_id
    if (id == '') {id = $('#registro_id').val();}

    //URL
    var url_atual = window.location.protocol+'//'+window.location.host+'/';

    //Ajax
    $.ajax({
        processing: true,
        serverSide: true,
        type: "GET",
        url: url_atual+"funcionarios/extradata/"+id,
        data: {},
        datatype: "json",
        success: function (response) {
            //Lendo json
            let json = JSON.parse(response);

            //Lendo dados funcionario
            let funcionario = json.funcionario;

            //Passando dados funcionario
            $('.jsonFuncionarioFoto').attr('src', url_atual+funcionario.foto);
            $('.jsonFuncionarioFuncao').html(funcionario.funcaoName);
            $('.jsonFuncionarioEscolaridade').html(funcionario.escolaridadeName);
            $('.jsonFuncionarioGenero').html(funcionario.generoName);
            $('.jsonFuncionarioName').html(funcionario.name);

            $('.jsonFuncionarioId').val(funcionario.id);
            $('.jsonFuncionarioEmail').html(funcionario.email);

            //Lendo dados transacoes (Totais)
            let transacoesCount = json.transacoesCount;

            //Lendo dados transacoes (Tabela)
            let transacoesTable = json.transacoesTable.transacoes;

            var tbodyTransacoes = '';

            if (transacoesTable != '') {
                //Passando dados transacoes (Tabela)
                var row = 0;

                function montarTable(item) {
                    row++;
                    operacaoName = item;

                    tbodyTransacoes += "<tr><th scope='row'>" + row + "</th><td>" + operacaoName + "</td></tr>";
                }

                transacoesTable.forEach(montarTable);
            }

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonFuncionarioTransacoesTable').html(tbodyTransacoes);
            configurarDataTable(2);
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

function notificacaoLerData(id) {
    //Buscar dados do Registro
    $.get("notificacoes/"+id, function (data) {
        //Lendo dados
        if (data.success) {
            $('.jsonNotificacaoLerTitulo').html(data.success.title);
            $('.jsonNotificacaoLerNotificacao').html(data.success.notificacao);
        } else if (data.error_not_found) {
            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
        } else if (data.error_permissao) {
            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
        } else {
            alert('Erro interno');
        }
    });
}

//Marcar permissão -list quando escolher qualquer outra
function checkedPermissaoTable(opClick, submodulo_id) {
    //opClick = 1 : Clicou em todos_listar
    if (opClick == 1) {
        if ($('#todos_listar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            $('#todos_mostrar').prop('checked', false);
            $('#todos_criar').prop('checked', false);
            $('#todos_editar').prop('checked', false);
            $('#todos_deletar').prop('checked', false);

            for (id = 1; id <= 100; id++) {
                $('#listar_' + id).prop('checked', false);
                $('#mostrar_' + id).prop('checked', false);
                $('#criar_' + id).prop('checked', false);
                $('#editar_' + id).prop('checked', false);
                $('#deletar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 2 : Clicou em todos_mostrar
    if (opClick == 2) {
        if ($('#todos_mostrar').is(':checked') == true) {
            $('#todos_listar').prop('checked', true);

            for (id = 1; id <= 100; id++) {
                $('#mostrar_' + id).prop('checked', true);

                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#mostrar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 3 : Clicou em todos_criar
    if (opClick == 3) {
        if ($('#todos_criar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#criar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#criar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 4 : Clicou em todos_editar
    if (opClick == 4) {
        if ($('#todos_editar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#editar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#editar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 5 : Clicou em todos_deletar
    if (opClick == 5) {
        if ($('#todos_deletar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#deletar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#deletar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 6 : Clicou em listar_
    if (opClick == 6) {
        if ($('#listar_' + submodulo_id).is(':checked') == false) {
            $('#todos_mostrar').prop('checked', false);
            $('#mostrar_' + submodulo_id).prop('checked', false);

            $('#todos_criar').prop('checked', false);
            $('#criar_' + submodulo_id).prop('checked', false);

            $('#todos_editar').prop('checked', false);
            $('#editar_' + submodulo_id).prop('checked', false);

            $('#todos_deletar').prop('checked', false);
            $('#deletar_' + submodulo_id).prop('checked', false);
        }
    }

    //opClick = 7 : Clicou em mostrar_
    if (opClick == 7) {
        if ($('#mostrar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#mostrar_' + submodulo_id).is(':checked') == false) {
            $('#todos_mostrar').prop('checked', false);
        }
    }

    //opClick = 8 : Clicou em criar_
    if (opClick == 8) {
        if ($('#criar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#criar_' + submodulo_id).is(':checked') == false) {
            $('#todos_criar').prop('checked', false);
        }
    }
    //opClick = 9 : Clicou em editar_
    if (opClick == 9) {
        if ($('#editar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#editar_' + submodulo_id).is(':checked') == false) {
            $('#todos_editar').prop('checked', false);
        }
    }
    //opClick = 10 : Clicou em deletar_
    if (opClick == 10) {
        if ($('#deletar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#deletar_' + submodulo_id).is(':checked') == false) {
            $('#todos_deletar').prop('checked', false);
        }
    }
}

//Modal de Confirmação
function alertSwalConfirmacao(callback) {
    Swal.fire({
        title: 'Confirma operação?',
        text: '',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
        confirmButtonColor: '#38c172',
        denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
        denyButtonColor: '#e3342f',
        customClass: {
            container: '...',
            popup: 'small',
            header: '...',
            title: 'h5',
            closeButton: '...',
            icon: 'small',
            image: '...',
            content: '...',
            htmlContainer: '...',
            input: '...',
            inputLabel: '...',
            validationMessage: '...',
            actions: '...',
            confirmButton: 'btn btn-success',
            denyButton: '...',
            cancelButton: 'btn btn-primary',
            loader: '...',
            footer: '....'
        }
    }).then((confirmed) => {
        callback(confirmed && confirmed.value == true);
    });
}

//Modal de Confirmação com submit
function alertSwalConfirmacaoSubmit(frm_name) {
    Swal.fire({
        title: 'Confirma operação?',
        text: '',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
        confirmButtonColor: '#38c172',
        denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
        denyButtonColor: '#e3342f',
        customClass: {
            container: '...',
            popup: 'small',
            header: '...',
            title: 'h5',
            closeButton: '...',
            icon: 'small',
            image: '...',
            content: '...',
            htmlContainer: '...',
            input: '...',
            inputLabel: '...',
            validationMessage: '...',
            actions: '...',
            confirmButton: 'btn btn-success',
            denyButton: '...',
            cancelButton: 'btn btn-primary',
            loader: '...',
            footer: '....'
        }
    }).then((confirmed) => {
        $('#'+frm_name).submit();
    });
}

//Modal de Confirmação para Exclusão de Registro - (CRUD)
// function alertSwalConfirmacaoExclusaoRegistro(id, descricao) {
//     Swal.fire({
//         title: 'Confirma exclusão do registro?',
//         text: descricao,
//         icon: 'warning',
//         showDenyButton: true,
//         confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
//         confirmButtonColor: '#38c172',
//         denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
//         denyButtonColor: '#e3342f'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Livewire.emit("destroy", id);
//         }
//     });
// }

//Modal para Mensagens
function alertSwal(icon='success', title='', html='', showConfirmButton=false, timer=2000) {
    Swal.fire({
        icon: icon,
        title: title,
        html: html,
        showConfirmButton: showConfirmButton,
        timer: timer
    });
}

//visualizar a imagem da font awesome em uma div ao lado
function viewFontAwesome(field) {
    if ($('#'+field).val() != '') {
        const image_view = $('#image_view');
        image_view.attr('class', $('#'+field).val());
    }
}

//Funções para Api ViaCep Para rodar em formulario sem REPEATER (Inicio)''''''''''''''''''''''''''''''''''''''''''''''''

//FORMULARIO COM CAMPOS SIMPLES'''''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('logradouro').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('localidade').value=("");
    document.getElementById('uf').value=("");
    //document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouro').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('localidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
        //document.getElementById('ibge').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('localidade').value="...";
            document.getElementById('uf').value="...";
            //document.getElementById('ibge').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//FORMULARIO COM CAMPOS _COBRANCA'''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep_cobranca() {
    //Limpa valores do formulário de cep_cobranca.
    document.getElementById('logradouro_cobranca').value=("");
    document.getElementById('bairro_cobranca').value=("");
    document.getElementById('localidade_cobranca').value=("");
    document.getElementById('uf_cobranca').value=("");
    //document.getElementById('ibge_cobranca').value=("");
}

function meu_callback_cobranca(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouro_cobranca').value=(conteudo.logradouro);
        document.getElementById('bairro_cobranca').value=(conteudo.bairro);
        document.getElementById('localidade_cobranca').value=(conteudo.localidade);
        document.getElementById('uf_cobranca').value=(conteudo.uf);
        //document.getElementById('ibge_cobranca').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep_cobranca();
        alert("CEP não encontrado.");
    }
}

function pesquisacep_cobranca(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro_cobranca').value="...";
            document.getElementById('bairro_cobranca').value="...";
            document.getElementById('localidade_cobranca').value="...";
            document.getElementById('uf_cobranca').value="...";
            //document.getElementById('ibge_cobranca').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback_cobranca';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep_cobranca();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep_cobranca();
    }
};
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para Api ViaCep Para rodar em formulario sem REPEATER (Fim)'''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para Api ViaCep Para rodar em formulario com REPEATER (Inicio)'''''''''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep_repeater() {
    //Limpa valores do formulário de cep.
    $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_endereco]']").val('');
}

function meu_callback_repeater(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_endereco]']")
            .val(conteudo.logradouro+', '+
                $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_numero]']").val()+' - '+
                $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_complemento]']").val()+' - '+
                conteudo.bairro+' - '+
                conteudo.localidade+' - '+
                conteudo.uf);
    } else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep_repeater(indice) {
    //retornar o indice do campo
    $('#ctrl_endereco_indice').val(indice);

    //Valor do campo CEP
    var valorCampoCep = $("input[type=text][name='endereco["+indice+"][a_cep]']").val();

    //Nova variável "cep" somente com dígitos.
    var cep = valorCampoCep.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("input[type=text][name='endereco["+indice+"][a_endereco]']").val('...');

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//Funções para Api ViaCep Para rodar em formulario com REPEATER (Fim)'''''''''''''''''''''''''''''''''''''''''''''''''''

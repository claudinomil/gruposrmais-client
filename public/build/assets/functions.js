function clienteExtraData(id='') {
    //Limpando dados
    $('.jsonCliente').html('');

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

            //Passando dados cliente
            $('.jsonClienteName').html(cliente.name);

            if (cliente.status == '1') {nameStatus = 'Ativo';}
            if (cliente.status == '2') {nameStatus = 'Inativo';}
            $('.jsonClienteStatus').html(nameStatus);

            if (cliente.tipo == '1') {
                $('.jsonClienteTipo').html('Pessoa Jurídica');
                $('.labelClienteCnpjCpf').html('CNPJ');
                $('.jsonClienteCnpj').html(aplicarMascaraJs(cliente.cnpj, '##.###.###/####-##'));
            }

            if (cliente.tipo == '2') {
                $('.jsonClienteTipo').html('Pessoa Física');
                $('.labelClienteCnpjCpf').html('CPF');
                $('.jsonClienteCpf').html(aplicarMascaraJs(cliente.cpf, '###.###.###-##'));
            }

            //Informações Gerais
            $('.jsonClienteClientePrincipal').html(cliente.principalClienteName);
            $('.jsonClienteEmail').html(cliente.email);

            if (cliente.telefone_1 != '' && cliente.telefone_1 !== null) {$('.jsonClienteContatoTelefone1').html(aplicarMascaraJs(cliente.telefone_1, '(##) #####-####'));}
            if (cliente.telefone_2 != '' && cliente.telefone_2 !== null) {$('.jsonClienteContatoTelefone2').html(aplicarMascaraJs(cliente.telefone_2, '(##) #####-####'));}
            if (cliente.celular_1 != '' && cliente.celular_1 !== null) {$('.jsonClienteContatoCelular1').html(aplicarMascaraJs(cliente.celular_1, '(##) #####-####'));}
            if (cliente.celular_2 != '' && cliente.celular_2 !== null) {$('.jsonClienteContatoCelular2').html(aplicarMascaraJs(cliente.celular_2, '(##) #####-####'));}

            //Lendo dados servicos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            let cliente_servicos = json.cliente_servicos;

            var tbodyServicos = '';

            //Passando dados servicos (Tabela)
            var row = 0;

            function montarTable(item) {
                row++;

                statusName = item.status;
                servicoName = item.servicoName;

                tbodyServicos += "<tr>";
                tbodyServicos += "<th scope='row'>" + row + "</th>";
                tbodyServicos += "<td>" + statusName + "</td>";
                tbodyServicos += "<td>" + servicoName + "</td>";
                tbodyServicos += "</tr>";
            }

            cliente_servicos.forEach(montarTable);

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonClienteServicosTable').html(tbodyServicos);

            configurarDataTable(2);

            //Alterar tamanho do input Pesquisar da tabela
            $('.dataTables_filter .fildFilterTable').attr('style',  'width:150px');
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

function fornecedorExtraData(id='') {
    //Limpando dados
    $('.jsonFornecedor').html('');

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

            //Lendo dados Fornecedor
            let fornecedor = json.fornecedor;

            //Passando dados Fornecedor
            $('.jsonFornecedorName').html(fornecedor.name);

            if (fornecedor.status == '1') {nameStatus = 'Ativo';}
            if (fornecedor.status == '2') {nameStatus = 'Inativo';}
            $('.jsonFornecedorStatus').html(nameStatus);

            if (fornecedor.tipo == '1') {
                $('.jsonFornecedorTipo').html('Pessoa Jurídica');
                $('.labelFornecedorCnpjCpf').html('CNPJ');
                $('.jsonFornecedorCnpj').html(aplicarMascaraJs(fornecedor.cnpj, '##.###.###/####-##'));
            }

            if (fornecedor.tipo == '2') {
                $('.jsonFornecedorTipo').html('Pessoa Física');
                $('.labelFornecedorCnpjCpf').html('CPF');
                $('.jsonFornecedorCpf').html(aplicarMascaraJs(fornecedor.cpf, '###.###.###-##'));
            }

            //Informações Gerais
            $('.jsonFornecedorSite').html(fornecedor.site);
            $('.jsonFornecedorEmail').html(fornecedor.email);

            if (fornecedor.telefone_1 != '' && fornecedor.telefone_1 !== null) {$('.jsonFornecedorContatoTelefone1').html(aplicarMascaraJs(fornecedor.telefone_1, '(##) #####-####'));}
            if (fornecedor.telefone_2 != '' && fornecedor.telefone_2 !== null) {$('.jsonFornecedorContatoTelefone2').html(aplicarMascaraJs(fornecedor.telefone_2, '(##) #####-####'));}
            if (fornecedor.celular_1 != '' && fornecedor.celular_1 !== null) {$('.jsonFornecedorContatoCelular1').html(aplicarMascaraJs(fornecedor.celular_1, '(##) #####-####'));}
            if (fornecedor.celular_2 != '' && fornecedor.celular_2 !== null) {$('.jsonFornecedorContatoCelular2').html(aplicarMascaraJs(fornecedor.celular_2, '(##) #####-####'));}

            //Lendo dados servicos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            let fornecedor_compras = json.fornecedor_compras;

            var tbodyCompras = '';

            //Passando dados compras (Tabela)
            var row = 0;

            function montarTable(item) {
                row++;

                xxx = item.xxx;
                yyy = item.yyy;

                tbodyCompras += "<tr>";
                tbodyCompras += "<th scope='row'>" + row + "</th>";
                tbodyCompras += "<td>" + xxx + "</td>";
                tbodyCompras += "<td>" + yyy + "</td>";
                tbodyCompras += "</tr>";
            }

            fornecedor_compras.forEach(montarTable);

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonFornecedorComprasTable').html(tbodyCompras);

            configurarDataTable(2);

            //Alterar tamanho do input Pesquisar da tabela
            $('.dataTables_filter .fildFilterTable').attr('style',  'width:150px');
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

function funcionarioExtraData(id='') {
    //Limpando dados
    $('.jsonFuncionario').html('');

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

            //Alterar tamanho do input Pesquisar da tabela
            $('.dataTables_filter .fildFilterTable').attr('style',  'width:150px');
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

//Retorna data por extenso
//op=1, data=14/04/2023 : Sexta-feira, 14 de Abril de 2023
//op=2, data=14/04/2023 : Rio de Janeiro, 14 de Abril de 2023
//op=3, data=14/04/2023 : Rio de Janeiro, Sexta-feira, 14 de Abril de 2023

function dataExtenso(op, data_informada) {
    meses = new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    semana = new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado");

    var dia_informado = data_informada.split('/')[0];
    var mes_informado = data_informada.split('/')[1];
    var ano_informado = data_informada.split('/')[2];
    var data = ano_informado + '-' + mes_informado + '-' + dia_informado + " 00:00:00";
    var dataInfo = new Date(data);
    var dia = dataInfo.getDate();
    var dias = dataInfo.getDay();
    var mes = dataInfo.getMonth();
    var ano = dataInfo.getFullYear();

    if (op == 1) {
        var dataext = semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
    }

    if (op == 2) {
        var dataext = "Rio de Janeiro, " + dia + " de " + meses[mes] + " de " + ano;
    }

    if (op == 3) {
        var dataext = "Rio de Janeiro, " + semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
    }

    return dataext;
}

function valorExtenso(vlr) {
    var Num=parseFloat(vlr);

    if (vlr == 0) {
        return "Zero";
    } else {
        var inteiro = parseInt(vlr);; // parte inteira do valor

        if(inteiro<1000000000000000) {
            var resto = Num.toFixed(2) - inteiro.toFixed(2);       // parte fracionária do valor
            resto=resto.toFixed(2)
            var vlrS =  inteiro.toString();

            var cont=vlrS.length;
            var extenso="";
            var auxnumero;
            var auxnumero2;
            var auxnumero3;

            var unidade =["", "um", "dois", "três", "quatro", "cinco",
                "seis", "sete", "oito", "nove", "dez", "onze",
                "doze", "treze", "quatorze", "quinze", "dezesseis",
                "dezessete", "dezoito", "dezenove"];

            var centena = ["", "cento", "duzentos", "trezentos",
                "quatrocentos", "quinhentos", "seiscentos",
                "setecentos", "oitocentos", "novecentos"];

            var dezena = ["", "", "vinte", "trinta", "quarenta", "cinquenta",
                "sessenta", "setenta", "oitenta", "noventa"];

            var qualificaS = ["reais", "mil", "milhão", "bilhão", "trilhão"];
            var qualificaP = ["reais", "mil", "milhões", "bilhões", "trilhões"];

            for (var i=cont;i > 0;i--)
            {
                var verifica1="";
                var verifica2=0;
                var verifica3=0;
                auxnumero2="";
                auxnumero3="";
                auxnumero=0;
                auxnumero2 = vlrS.substr(cont-i,1);
                auxnumero = parseInt(auxnumero2);


                if((i==14)||(i==11)||(i==8)||(i==5)||(i==2))
                {
                    auxnumero2 = vlrS.substr(cont-i,2);
                    auxnumero = parseInt(auxnumero2);
                }

                if((i==15)||(i==12)||(i==9)||(i==6)||(i==3))
                {
                    extenso=extenso+centena[auxnumero];
                    auxnumero2 = vlrS.substr(cont-i+1,1)
                    auxnumero3 = vlrS.substr(cont-i+2,1)

                    if((auxnumero2!="0")||(auxnumero3!="0"))
                        extenso+=" e ";

                }else

                if(auxnumero>19){
                    auxnumero2 = vlrS.substr(cont-i,1);
                    auxnumero = parseInt(auxnumero2);
                    extenso=extenso+dezena[auxnumero];
                    auxnumero3 = vlrS.substr(cont-i+1,1)

                    if((auxnumero3!="0")&&(auxnumero2!="1"))
                        extenso+=" e ";
                }
                else if((auxnumero<=19)&&(auxnumero>9)&&((i==14)||(i==11)||(i==8)||(i==5)||(i==2)))
                {
                    extenso=extenso+unidade[auxnumero];
                }else if((auxnumero<10)&&((i==13)||(i==10)||(i==7)||(i==4)||(i==1)))
                {
                    auxnumero3 = vlrS.substr(cont-i-1,1);
                    if((auxnumero3!="1")&&(auxnumero3!=""))
                        extenso=extenso+unidade[auxnumero];
                }

                if(i%3==1)
                {
                    verifica3 = cont-i;
                    if(verifica3==0)
                        verifica1 = vlrS.substr(cont-i,1);

                    if(verifica3==1)
                        verifica1 = vlrS.substr(cont-i-1,2);

                    if(verifica3>1)
                        verifica1 = vlrS.substr(cont-i-2,3);

                    verifica2 = parseInt(verifica1);

                    if(i==13)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[4]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[4]+" ";}}
                    if(i==10)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[3]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[3]+" ";}}
                    if(i==7)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[2]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[2]+" ";}}
                    if(i==4)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[1]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[1]+" ";}}
                    if(i==1)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[0]+" ";
                        }else {extenso=extenso+" "+qualificaP[0]+" ";}}
                }
            }
            resto = resto * 100;
            var aexCent=0;
            if(resto<=19&&resto>0)
                extenso+=" e "+unidade[resto]+" Centavos";
            if(resto>19)
            {
                aexCent=parseInt(resto/10);

                extenso+=" e "+dezena[aexCent]
                resto=resto-(aexCent*10);

                if(resto!=0)
                    extenso+=" e "+unidade[resto]+" Centavos";
                else extenso+=" Centavos";
            }

            return extenso;
        } else {
            return "Numero maior que 999 trilhões";
        }
    }
}

function float2moeda(num) {
    x = 0;

    if (num < 0) {
        num = Math.abs(num);
        x = 1;
    }

    if (isNaN(num)) num = "0";

    cents = Math.floor((num*100+0.5)%100);
    num = Math.floor((num*100+0.5)/100).toString();

    if (cents < 10) cents = "0" + cents;

    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
    ret = num + ',' + cents;

    if (x == 1) ret = ' - ' + ret;

    return ret;
}

function moeda2float(moeda){
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(",",".");
    return parseFloat(moeda);
}

function aplicarMascaraJs(value, pattern) {
    let i = 0;
    const v = value.toString();
    return pattern.replace(/#/g, () => v[i++] || '');
}

//Funções para o Submódulo Propostas - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Propostas - INÍCIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Atualiza/Limpa os dados do Serviço escolhido para grade
//operacao = 0 : Limpar
//operacao = 1 : Adicionar
//operacao = 2 : Atualizar
//operacao = 3 : Retirar
function atualizarServicoEscolher(operacao, servico_id='', servico_nome='', servico_valor='', servico_qtd='') {
    if (operacao == 0) {
        //campos
        $('#ts_servico_id').val(servico_id);
        $('#select2-ts_servico_id-container').html(servico_nome);
        $('#ts_servico_nome').val(servico_nome);
        $('#ts_servico_valor').val(servico_valor);
        $('#ts_servico_qtd').val(servico_qtd);

        //botoes
        $('#ts_servico_adicionar_div').hide();
        $('#ts_servico_atualizar_div').hide();
        $('#ts_servico_retirar_div').hide();
    }

    if (operacao == 1) {
        //campos
        $('#ts_servico_nome').val(servico_nome);
        $('#ts_servico_valor').val(servico_valor);
        $('#ts_servico_qtd').val(servico_qtd);

        //botoes
        $('#ts_servico_adicionar_div').show();
        $('#ts_servico_atualizar_div').hide();
        $('#ts_servico_retirar_div').hide();
    }

    if (operacao == 2) {
        //campos
        $('#ts_servico_id').val(servico_id);
        $('#select2-ts_servico_id-container').html(servico_nome);
        $('#ts_servico_nome').val(servico_nome);
        $('#ts_servico_valor').val(servico_valor);
        $('#ts_servico_qtd').val(servico_qtd);

        //botoes
        $('#ts_servico_adicionar_div').hide();
        $('#ts_servico_atualizar_div').hide();
        $('#ts_servico_retirar_div').show();
    }
}

//Atualizar a Grade de Serviço
//operacao = 0 : Somente atualiza os valores
//operacao = 1 : Adicionar
//operacao = 2 : Atualizar
//operacao = 3 : Retirar
function atualizarServicoGrade(operacao) {
    if (operacao == 1) {
        //Dados para preenchera linha da grade
        servico_id = $('#ts_servico_id').val();
        servico_nome = $('#ts_servico_nome').val();
        servico_valor = $('#ts_servico_valor').val();
        servico_qtd = $('#ts_servico_qtd').val();
        servico_valor_total = servico_qtd * moeda2float(servico_valor);
        servico_valor_total = float2moeda(servico_valor_total);

        //Montar Linha
        var linha;

        linha = "<tr class='ts_servico_linha' id='ts_servico_linha_" + servico_id + "' data-id='" + servico_id + "' style='cursor: pointer'>";
        linha += "  <td class='text-center ts_servico_item' data-id='" + servico_id + "'></td>";
        linha += "  <td id='ts_servico_nome_td_" + servico_id + "'>" + servico_nome + "</td>";
        linha += "  <td id='ts_servico_valor_td_" + servico_id + "' class='text-end'>R$ " + servico_valor + "</td>";
        linha += "  <td id='ts_servico_qtd_td_" + servico_id + "' class='text-center'>" + servico_qtd + "</td>";
        linha += "  <td class='text-end ts_servico_valor_total'>R$ " + servico_valor_total + "</td>";
        linha += "</tr>";

        //Adicionar linha na grade
        $('#ts_servico_grade').append(linha);

        //Montar campos hidden
        var hiddens;

        hiddens = "<div id='ts_servico_hiddens_" + servico_id + "'>";
        hiddens += "<input class='servico_item_hiddens' type='hidden' name='servico_item[]' id='servico_item' value=''>";
        hiddens += "<input type='hidden' name='servico_id[]' id='servico_id' value='"+servico_id+"'>";
        hiddens += "<input type='hidden' name='servico_nome[]' id='servico_nome' value='"+servico_nome+"'>";
        hiddens += "<input type='hidden' name='servico_valor[]' id='servico_valor' value='"+moeda2float(servico_valor)+"'>";
        hiddens += "<input type='hidden' name='servico_quantidade[]' id='servico_quantidade' value='"+servico_qtd+"'>";
        hiddens += "<input type='hidden' name='servico_valor_total[]' id='servico_valor_total' value='"+moeda2float(servico_valor_total)+"'>";
        hiddens += "</div>";

        //Adicionar hiddens na div
        $('#ts_servico_hiddens').append(hiddens);
    }

    if (operacao == 3) {
        //Dados
        servico_id = $('#ts_servico_id').val();

        //Remover linha da grade
        $('#ts_servico_linha_'+servico_id).remove();

        //Remover campos hiddens
        $('#ts_servico_hiddens_'+servico_id).remove();
    }

    //Atualizando numeração das linhas da coluna Item
    ln = 0;
    $('.ts_servico_item').each(function( index ) {
        ln++;
        $(this).html(ln);
    });

    //Atualizando numeração das divs da coluna Item dos campos hiddens
    ln = 0;
    $('.servico_item_hiddens').each(function( index ) {
        ln++;
        $(this).val(ln);
    });

    //Atualizando Valor Global
    var valor_global = 0;
    var valor_total = 0;
    $('.ts_servico_valor_total').each(function() {
        valor_total = $(this).html();
        valor_total = valor_total.substring(3);
        valor_total = moeda2float(valor_total);

        valor_global = valor_global + valor_total;
    });

    $('#ts_servico_valor_global').html('R$ '+float2moeda(valor_global));

    //Atualizar Valor Total da Proposta
    atualizarValorTotalProposta(valor_global);
}

//Limpar a Grade de Serviço
function limparServicosGrade() {
    //Limpando Serviços da grade
    $('#ts_servico_grade').html('');

    //Limpando campos hiddens
    $('#ts_servico_hiddens').html('');

    //Atualizar Valor Total da Proposta
    atualizarValorTotalProposta(0);
}

//Atualizar o Valor Total da Proposta
function atualizarValorTotalProposta(valor_global) {
    var porcentagem_desconto = $('#porcentagem_desconto').val();

    if (porcentagem_desconto ==  '') {
        porcentagem_desconto = 0;
        $('#porcentagem_desconto').val(porcentagem_desconto);
    }

    var valor_desconto = ((valor_global * porcentagem_desconto) / 100);

    $('#valor_desconto').val(float2moeda(valor_desconto));
    $('#valor_desconto_extenso').val(valorExtenso(valor_desconto));

    $('#valor_total').val(float2moeda(valor_global - valor_desconto));
    $('#valor_total_extenso').val(valorExtenso(valor_global - valor_desconto));
}
//Funções para o Submódulo Propostas - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Propostas - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Clientes - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Clientes - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
function pavimentosShowHide() {
    numero_pavimentos = $('#numero_pavimentos').val();

    for(i=1; i<=50; i++) {
        if (numero_pavimentos >= i) {
            $('#divMedidasSeguranca' + i).show();
        } else {
            $('#divMedidasSeguranca'+i).hide();

            //Limpar campos do Pavimento que deu hide
            $('#divMedidasSeguranca'+i+' .cbSegurancaMedida').prop('checked', false);
            $('#divMedidasSeguranca'+i+' .quantidadeSegurancaMedida').val('');
            $('#divMedidasSeguranca'+i+' .tipoSegurancaMedida').val('');
            $('#divMedidasSeguranca'+i+' .observacaoSegurancaMedida').val('');
        }
    }
}
//Funções para o Submódulo Clientes - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Clientes - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Cliente Serviços - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Cliente Serviços - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''


//Limpar Dados do Modal
function cs_limparDados() {
    bi_limparDados();
}

//Configuração campos que vão aparecer para o Serviço escolhido
function cs_configuracaoCampos() {
    var servico_tipo_id = $('#servico_id option[value="'+$('#servico_id').val()+'"]').attr('data-servico_tipo_id');

    //Hide campos
    $('#divQuantidade').hide();
    $('#divDataInicio').hide();
    $('#divDataFim').hide();
    $('#divDataVencimento').hide();
    $('#divValor').hide();

    //d-none
    $('#divSTBrigada').addClass('d-none');
    $('#divSTVisitaTecnica').addClass('d-none');
    $('#divSTManutencao').addClass('d-none');

    //Serviço Tipo 1: BRIGADA DE INCÊNDIO
    if (servico_tipo_id == 1) {
        //Show campos
        $('#divDataInicio').show();
        $('#divDataFim').show();
        $('#divDataVencimento').show();
        $('#divValor').show();

        $('#divSTBrigada').removeClass('d-none');

        //Limpar campos
        $('#quantidade').val('');
    }

    //Serviço Tipo 2: MANUTENÇÃO
    if (servico_tipo_id == 2) {
        //Show campos
        $('#divQuantidade').show();
        $('#divDataInicio').show();
        $('#divDataFim').show();
        $('#divDataVencimento').show();
        $('#divValor').show();

        //$('#divSTManutencao').removeClass('d-none');
    }

    //Serviço Tipo 3: VISITA TÉCNICA
    if (servico_tipo_id == 3) {
        //Show campos
        $('#divDataInicio').show();
        $('#divDataFim').show();
        $('#divDataVencimento').show();
        $('#divValor').show();

        //$('#divSTVisitaTecnica').removeClass('d-none');

        //Limpar campos
        $('#quantidade').val('');
    }
}

//BRIGADA DE INCÊNDIO - INICIO''''''''''''''''''''''''''''''''''''''''''''''''
//BRIGADA DE INCÊNDIO - INICIO''''''''''''''''''''''''''''''''''''''''''''''''

//Limpar Dados
function bi_limparDados() {
    bi_limparFormulario();
    bi_limparGradeBrigadistas();
}

//Limpar Formulário
function bi_limparFormulario() {
    //Limpar informações gerais
    $('#bi_escala_tipo_id').val('');
    $('#bi_quantidade_alas_escala').val('');
    $('#bi_quantidade_brigadistas_por_ala').val('');
    $('#bi_quantidade_brigadistas_total').val('');
    $('#bi_hora_inicio_ala').val('');
}

//Limpar Grade de Brigadistas
function bi_limparGradeBrigadistas() {
    //Limpar grade de brigadistas
    $('#bi_grade_funcionario_id').val('');
    $('#select2-bi_grade_funcionario_id-container').html('');
    $('#bi_grade_funcionario_nome').val('');
    $('#bi_grade_ala').val('');

    $('#bi_tbody_grade_brigadistas').html('');
    $('#bi_funcionario_hiddens').html('');
}

//Atualiza/Limpa grade de brigadistas
//operacao = 0 : Limpar
//operacao = 1 : Adicionar
//operacao = 2 : Atualizar
//operacao = 3 : Retirar
function bi_gradeBrigadistasEscolher(operacao, funcionario_id='', funcionario_nome='', ala='') {
    if (operacao == 0) {
        //campos
        $('#bi_grade_funcionario_id').val(funcionario_id);
        $('#select2-bi_grade_funcionario_id-container').html(funcionario_nome);
        $('#bi_grade_funcionario_nome').val(funcionario_nome);
        $('#bi_grade_ala').val(ala);

        //botoes
        $('#bi_divGradeFuncionarioAdicionar').hide();
        $('#bi_divGradeFuncionarioRetirar').hide();
    }

    if (operacao == 1) {
        //campos
        $('#bi_grade_funcionario_nome').val(funcionario_nome);

        //botoes
        $('#bi_divGradeFuncionarioAdicionar').show();
        $('#bi_divGradeFuncionarioRetirar').hide();
    }

    if (operacao == 2) {
        //campos
        $('#bi_grade_funcionario_id').val(funcionario_id);
        $('#select2-bi_grade_funcionario_id-container').html(funcionario_nome);
        $('#bi_grade_funcionario_nome').val(funcionario_nome);
        $('#bi_grade_ala').val(ala);

        //botoes
        $('#bi_divGradeFuncionarioAdicionar').hide();
        $('#bi_divGradeFuncionarioRetirar').show();
    }
}

//Atualizar a Grade de Brigadistas
//operacao = 0 : Somente atualiza os valores
//operacao = 1 : Adicionar
//operacao = 2 : Atualizar
//operacao = 3 : Retirar
function bi_gradeBrigadistasAtualizar(operacao) {
    if (operacao == 1) {
        //Dados para preenchera linha da grade
        var bi_grade_funcionario_id = $('#bi_grade_funcionario_id').val();
        var bi_grade_funcionario_nome = $('#bi_grade_funcionario_nome').val();
        var bi_grade_ala = $('#bi_grade_ala').val();

        //Montar Linha
        var linha;

        linha = "<tr class='bi_funcionario_linha' id='bi_funcionario_linha_" + bi_grade_funcionario_id + "' data-id='" + bi_grade_funcionario_id + "' style='cursor: pointer'>";
        linha += "  <td id='funcionario_ala_td_" + bi_grade_funcionario_id + "'>" + bi_grade_ala + "</td>";
        linha += "  <td id='funcionario_nome_td_" + bi_grade_funcionario_id + "'>" + bi_grade_funcionario_nome + "</td>";
        linha += "</tr>";

        //Adicionar linha na grade
        $('#bi_tbody_grade_brigadistas').append(linha);

        //Montar campos hidden
        var hiddens;

        hiddens = "<div id='bi_funcionario_hiddens_" + bi_grade_funcionario_id + "'>";
        hiddens += "<input type='hidden' name='bi_funcionario_id[]' id='bi_funcionario_id' value='"+bi_grade_funcionario_id+"'>";
        hiddens += "<input type='hidden' name='bi_funcionario_nome[]' id='bi_funcionario_nome' value='"+bi_grade_funcionario_nome+"'>";
        hiddens += "<input type='hidden' name='bi_ala[]' id='bi_ala' value='"+bi_grade_ala+"'>";
        hiddens += "</div>";

        //Adicionar hiddens na div
        $('#bi_funcionario_hiddens').append(hiddens);
    }

    if (operacao == 3) {
        //Dados
        var bi_grade_funcionario_id = $('#bi_grade_funcionario_id').val();

        //Remover linha da grade
        $('#bi_funcionario_linha_'+bi_grade_funcionario_id).remove();

        //Remover campos hiddens
        $('#bi_funcionario_hiddens_'+bi_grade_funcionario_id).remove();
    }

    //Contando Funcionarios na grade
    $('#bi_funcionario_total').html('Total: '+$('.bi_funcionario_linha').length+'/'+$('#bi_quantidade_brigadistas_total').val());
}

//Alterar campo bi_quantidade_brigadistas_total de acordo com os campos bi_escala_tipo_id e bi_quantidade_brigadistas_por_ala
function bi_quantidadeBrigadistasTotal() {
    var bi_quantidade_brigadistas_total = 0;

    if ($('#bi_escala_tipo_id').val() != '' && $('#bi_quantidade_brigadistas_por_ala').val() != '') {
        var qtd_alas_escala = $('#bi_quantidade_alas_escala').val();
        var qtd_brigadistas_por_ala = $('#bi_quantidade_brigadistas_por_ala').val();

        bi_quantidade_brigadistas_total = qtd_alas_escala * qtd_brigadistas_por_ala;
    }

    $('#bi_quantidade_brigadistas_total').val(bi_quantidade_brigadistas_total);
}

//Verificar se dados da grade estão corretos
//@PARAN op=1 : Ao escolher Brigadista para colocar na grade
//@PARAN op=2 : Ao tentar Incluir ou Alterar
function bi_gradeBrigadistasVerificacao(op) {
    //Verificar se qtd de Brigadistas em cada ala na grade está correto''''''''''''''''''''''''
    for(i=1; i<=$('#bi_quantidade_alas_escala').val(); i++) {
        var qtd_na_grade = 0;
        $("input[name='bi_ala[]']").each(function () {
            if ($(this).val() == i) {
                qtd_na_grade++;
            }
        });

        if (qtd_na_grade > $('#bi_quantidade_brigadistas_por_ala').val()) {
            alert('Ala '+i+'. '+'É preciso ter '+$('#bi_quantidade_brigadistas_por_ala').val()+' Brigadistas em cada Ala na Grade.');
            return false;
        }
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Verificar se qtd de Brigadistas na grade está correto''''''''''''''''''''''''''''''''''''''
    var qtd_na_grade = 0;
    $("input[name='bi_funcionario_id[]']").each(function () {qtd_na_grade++;});

    if (qtd_na_grade > $('#bi_quantidade_brigadistas_total').val()) {
        alert('É preciso ter '+$('#bi_quantidade_brigadistas_total').val()+' Brigadistas na Grade.');
        return false;
    }

    //Se for para Salvar verifica se a quantidade na grade é menor
    if (op == 2) {
        if (qtd_na_grade < $('#bi_quantidade_brigadistas_total').val()) {
            alert('É preciso ter ' + $('#bi_quantidade_brigadistas_total').val() + ' Brigadistas na Grade.');
            return false;
        }
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    return true;
}

//Configuração conforme escala escolhida
function bi_configuracaoConformeEscala(bi_escala_tipo_id) {
    var quantidade_alas = $('#bi_escala_tipo_id option[value="'+bi_escala_tipo_id+'"]').attr('data-quantidade_alas');

    //Campos hidden
    $('#bi_quantidade_alas_escala').val(quantidade_alas);

    //campo bi_grade_ala <options>
    var bi_grade_ala_options = '<option value="">&nbsp;</option>';
    for (i = 1; i <= quantidade_alas; i++) {
        bi_grade_ala_options += '<option value="' + i + '">' + i + '</option>';
    }

    $('#bi_grade_ala').html(bi_grade_ala_options);

    //Quantidade Total de Brigadistas
    bi_quantidadeBrigadistasTotal();
}
//BRIGADA DE INCÊNDIO - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''
//BRIGADA DE INCÊNDIO - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''

//VISITA TÉCNICA - INICIO'''''''''''''''''''''''''''''''''''''''''''''''''''''
//VISITA TÉCNICA - INICIO'''''''''''''''''''''''''''''''''''''''''''''''''''''

//Verificar se pode salvar
function vt_verificacao() {
    var retorno = true;

    //Buscar dados do Registro
    $.ajax({
        type:'GET',
        url: 'clientes/'+$('#cliente_id').val(),
        async: false,
        success: function (data) {
            //Lendo dados
            if (data.success) {
                cliente_seguranca_medidas = data.success['cliente_seguranca_medidas'];

                if (cliente_seguranca_medidas.length <= 0) {
                    alert('Erro nos dados vindos do Cliente. Verifique as Medidas de Segurança.');
                    retorno = false;
                }
            }
        }
    });

    return retorno;
}
//VISITA TÉCNICA - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//VISITA TÉCNICA - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Cliente Serviços - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Cliente Serviços - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Funcionarios - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Funcionarios - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Função para buscar dados na API (Documentos pdf do funcionario para colocar na grade)
//Paran op (1 view) (2 edit)
function montar_grade_documentos_funcionario(op) {
    $.get('funcionarios/' + $('#registro_id').val(), function (data) {
        let funcionarioDocumentos = data.success['funcionarioDocumentos'];

        //Montar a grade
        var linha = '';
        $.each(funcionarioDocumentos, function(i, item) {
            var caminho = window.location.protocol+'//'+window.location.host+'/'+item.caminho;

            linha += '<tr>';
            linha += '  <th scope="row">'+(i+1)+'</th>';
            linha += '      <td>'+item.descricao+'</td>';
            linha += '      <td style="vertical-align:top; white-space:nowrap;">';
            linha += '          <div class="row">';
            linha += '              <div class="col-1">';
            linha += '                  <button type="button" class="btn btn-outline-info text-center btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Documento" onclick="window.open(\''+caminho+'\', \'_blank\');"><i class="fa fa-file-pdf font-size-18"></i></button>';
            linha += '              </div>';

            //Botão Deletar documento
            if (op == 2) {
                linha += '              <div class="col-1">';
                linha += '                  <button type="button" class="btn btn-outline-danger text-center btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Documento" onclick="deletar_documentos_funcionario(' + item.id + ');"><i class="fa fa-trash-alt font-size-18"></i></button>';
                linha += '              </div>';
            }

            linha += '          </div>';
            linha += '      </td>';
            linha += '</tr>';
        });

        $('#tbodyDocumentoUpload').html(linha);
    });
}

//Função para deletar documento da grade
function deletar_documentos_funcionario(funcionario_documento_id) {
    //Confirmação de Delete
    alertSwalConfirmacao(function (confirmed) {
        if (confirmed) {
            $.ajax({
                type: "DELETE",
                url: "funcionarios/deletar_documento/" + funcionario_documento_id
            });

            montar_grade_documentos_funcionario(2);
        }
    });
}
//Funções para o Submódulo Funcionarios - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Funcionarios - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Visitas Técnicas - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Visitas Técnicas - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

function vt_configurarFormulario(dados) {
    if ($('#frm_operacao').val() == 'edit') {
        //Div's Principais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#divInformacoesServico').show();
        $('#divClassificacaoDecretoInformacoesGerais').hide();
        $('#divMedidasSeguranca').show();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Pdf's'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('.input_projeto_scip_pdf').show();
        $('.btn_projeto_scip_pdf_upload').show();

        $('.input_laudo_exigencias_pdf').show();
        $('.btn_laudo_exigencias_pdf_upload').show();

        $('.input_certificado_aprovacao_pdf').show();
        $('.btn_certificado_aprovacao_pdf_upload').show();

        $('.input_certificado_aprovacao_simplificado_pdf').show();
        $('.btn_certificado_aprovacao_simplificado_pdf_upload').show();

        $('.input_certificado_aprovacao_assistido_pdf').show();
        $('.btn_certificado_aprovacao_assistido_pdf_upload').show();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    } else {
        //Div's Principais''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('#divInformacoesServico').show();
        $('#divClassificacaoDecretoInformacoesGerais').show();
        $('#divMedidasSeguranca').show();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Pdf's'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $('.input_projeto_scip_pdf').hide();
        $('.btn_projeto_scip_pdf_upload').hide();

        $('.input_laudo_exigencias_pdf').hide();
        $('.btn_laudo_exigencias_pdf_upload').hide();

        $('.input_certificado_aprovacao_pdf').hide();
        $('.btn_certificado_aprovacao_pdf_upload').hide();

        $('.input_certificado_aprovacao_simplificado_pdf').hide();
        $('.btn_certificado_aprovacao_simplificado_pdf_upload').hide();

        $('.input_certificado_aprovacao_assistido_pdf').hide();
        $('.btn_certificado_aprovacao_assistido_pdf_upload').hide();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    //Classificação - Documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    $('#divProjetoScip').hide();
    $('#divLaudoExigencias').hide();
    $('#divCertificadoAprovacao').hide();
    $('#divCertificadoAprovacaoSimplificado').hide();
    $('#divCertificadoAprovacaoAssistido').hide();

    if (dados.projeto_scip == 1) {$('#divProjetoScip').show();}
    if (dados.laudo_exigencias == 1) {$('#divLaudoExigencias').show();}
    if (dados.certificado_aprovacao == 1) {$('#divCertificadoAprovacao').show();}
    if (dados.certificado_aprovacao_simplificado == 1) {$('#divCertificadoAprovacaoSimplificado').show();}
    if (dados.certificado_aprovacao_assistido == 1) {$('#divCertificadoAprovacaoAssistido').show();}
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

function vt_preencherFormulario(dados) {
    //Dados do Serviço criado no submódulo Clientes'''''''''''''''''''''''''''''''''''
    let clientes_servicos_servico = dados.clientes_servicos_servico;

    //Campos
    $('#is_cliente').val(clientes_servicos_servico.clienteName);
    $('#is_servico_status').val(clientes_servicos_servico.servicoStatusName);
    $('#is_responsavel_funcionario').val(clientes_servicos_servico.responsavelFuncionarioName);
    $('#is_data_inicio').val(clientes_servicos_servico.data_inicio);
    $('#is_data_fim').val(clientes_servicos_servico.data_fim);
    $('#is_data_vencimento').val(clientes_servicos_servico.data_vencimento);
    $('#is_valor').val(clientes_servicos_servico.valor);
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Classificação - Medidas de Segurança''''''''''''''''''''''''''''''''''''''''''''
    var numero_pavimentos = dados.numero_pavimentos;
    var cliente_seguranca_medidas = dados['cliente_seguranca_medidas'];
    var medidas_seguranca = '';

    //verificar validacoes
    if (numero_pavimentos == '' || numero_pavimentos == '0' || numero_pavimentos == 0) {
        alert('Erro nos dados vindos do Cliente. Verifique o Número de Pavimentos.');
        $('#divMedidasSeguranca').hide();
        return false;
    }
    if (cliente_seguranca_medidas.length <= 0) {
        alert('Erro nos dados vindos do Cliente. Verifique as Medidas de Segurança.');
        $('#divMedidasSeguranca').hide();
        return false;
    }

    //Montar
    for (pavimento = 1; pavimento <= numero_pavimentos; pavimento++) {
        ctrl = 0;

        medidas_seguranca += '<h6 class="pb-3 text-success"><i class="fa fa-fire-extinguisher"></i> Medidas de Segurança - Pavimento ' + '<span class="font-size-15">' + pavimento + '</span>' + '</h6>';

        //Campos
        $.each(cliente_seguranca_medidas, function (i, campo) {
            if (pavimento == campo.pavimento) {
                ctrl++;

                seguranca_medida_id = campo.seguranca_medida_id;

                if (campo.seguranca_medida_nome === null || campo.seguranca_medida_nome === undefined) {
                    seguranca_medida_nome = '';
                } else {
                    seguranca_medida_nome = campo.seguranca_medida_nome;
                }
                if (campo.seguranca_medida_quantidade === null || campo.seguranca_medida_quantidade === undefined) {
                    seguranca_medida_quantidade = '';
                } else {
                    seguranca_medida_quantidade = campo.seguranca_medida_quantidade;
                }
                if (campo.seguranca_medida_tipo === null || campo.seguranca_medida_tipo === undefined) {
                    seguranca_medida_tipo = '';
                } else {
                    seguranca_medida_tipo = campo.seguranca_medida_tipo;
                }
                if (campo.seguranca_medida_observacao === null || campo.seguranca_medida_observacao === undefined) {
                    seguranca_medida_observacao = '';
                } else {
                    seguranca_medida_observacao = campo.seguranca_medida_observacao;
                }
                if (campo.status === null || campo.status === undefined) {
                    status = '';
                } else {
                    status = campo.status;
                }
                if (campo.observacao === null || campo.observacao === undefined) {
                    observacao = '';
                } else {
                    observacao = campo.observacao;
                }

                medidas_seguranca += vt_prepararMedidasSegurancas(ctrl, pavimento, seguranca_medida_id, seguranca_medida_nome, seguranca_medida_quantidade, seguranca_medida_tipo, seguranca_medida_observacao, status, observacao);
            }
        });
    }

    $('#divMedidasSegurancaItens').html(medidas_seguranca);

    return true;
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

function vt_prepararMedidasSegurancas(ctrl, pavimento, seguranca_medida_id, seguranca_medida_nome, seguranca_medida_quantidade, seguranca_medida_tipo, seguranca_medida_observacao, status, observacao) {
    //Verificar se os campos vao ser readonly
    if ($('#frm_operacao').val() == 'edit') {readonly = ''; disabled = '';} else {readonly = 'readonly'; disabled = 'disabled';}

    //Combo status''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    var combo_status = '';
    var selected0 = '';
    var selected1 = '';
    var selected2 = '';

    if (status == 0) {selected0 = 'selected';}
    if (status == 1) {selected1 = 'selected';}
    if (status == 2) {selected2 = 'selected';}

    combo_status = '<select class="form-control col-12" id="status_' + pavimento + '_' + seguranca_medida_id + '" name="status_' + pavimento + '_' + seguranca_medida_id + '" required="required" '+readonly+'  '+disabled+'>';
    combo_status += '  <option value="0" '+selected0+'>Não Conferido</option>';
    combo_status += '  <option value="1" '+selected1+'>Aprovado</option>';
    combo_status += '  <option value="2" '+selected2+'>Restrição</option>';
    combo_status += '</select>';
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    var medidas_seguranca;

    medidas_seguranca = '<div class="col-12 col-md-6 pb-3">';
    medidas_seguranca += '  <div class="col-12 alert alert-primary">';
    medidas_seguranca += '      <div class="form-group col-12 pb-3">';
    medidas_seguranca += '          <div class="text-primary font-size-11 fw-bold align-middle me-2"><span class="font-size-14">'+pavimento+'.'+ctrl+'</span>' + '&nbsp;'+seguranca_medida_nome+ '</div>';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_id_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_id_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_id + '">';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_nome_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_nome_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_nome + '">';
    medidas_seguranca += '          <input type="hidden" name="ids_seguranca_medidas[]" value="' + seguranca_medida_id + '">';
    medidas_seguranca += '      </div>';
    medidas_seguranca += '      <div class="row">';
    medidas_seguranca += '          <div class="form-group col-12 col-md-2 pb-3">';
    medidas_seguranca += '              <label class="form-label">Qtd</label>';
    medidas_seguranca += '              <div class="col-12 text-dark">'+seguranca_medida_quantidade+'</div>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '          <div class="form-group col-12 col-md-10 pb-3">';
    medidas_seguranca += '              <label class="form-label">Tipo</label>';
    medidas_seguranca += '              <div class="col-12 text-dark">'+seguranca_medida_tipo+'</div>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '      </div>';
    medidas_seguranca += '      <div class="row">';
    medidas_seguranca += '          <div class="form-group col-12 col-md-4">';
    medidas_seguranca += '              <label class="form-label">Status</label>';
    medidas_seguranca +=                combo_status;
    medidas_seguranca += '          </div>';
    medidas_seguranca += '          <div class="form-group col-12 col-md-8">';
    medidas_seguranca += '              <label class="form-label">Observação</label>';
    medidas_seguranca += '              <textarea class="form-control" id="observacao_' + pavimento + '_' + seguranca_medida_id + '" name="observacao_' + pavimento + '_' + seguranca_medida_id + '" '+readonly+'>' + observacao + '</textarea>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '      </div>';
    medidas_seguranca += '  </div>';
    medidas_seguranca += '</div>';

    return medidas_seguranca;
}
//Funções para o Submódulo Visitas Técnicas - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Visitas Técnicas - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para o Submódulo Brigadas Incêndios - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Brigadas Incêndios - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Preencher o Formulário com Informações do Serviço
function bi_preencherFormulario(dados) {
    //Dados do Serviço criado no submódulo Clientes'''''''''''''''''''''''''''''''''''
    let clientes_servicos_servico = dados.clientes_servicos_servico;

    //Campos
    $('#is_cliente').val(clientes_servicos_servico.clienteName);
    $('#is_servico_status').val(clientes_servicos_servico.servicoStatusName);
    $('#is_responsavel_funcionario').val(clientes_servicos_servico.responsavelFuncionarioName);
    $('#is_data_inicio').val(clientes_servicos_servico.data_inicio);
    $('#is_data_fim').val(clientes_servicos_servico.data_fim);
    $('#is_data_vencimento').val(clientes_servicos_servico.data_vencimento);
    $('#is_valor').val(clientes_servicos_servico.valor);
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

//Brigadas Incêndios - Escalas - INÍCIO''''''''''''''''''
//Brigadas Incêndios - Escalas - INÍCIO''''''''''''''''''

//Grade de Registros de Escalas
function bi_montarGradeEscala() {
    //Verificar período
    if ($('#es_periodo_data_1').val() == '' || $('#es_periodo_data_2').val() == '') {
        alert('Escolha um Período.');
    } else {
        $('.er_grade_escala').DataTable({
            language: {
                pageLength: {
                    '-1': 'Mostrar todos os registros',
                    '_': 'Mostrar %d registros'
                },
                lengthMenu: 'Exibir _MENU_ resultados por página',
                emptyTable: 'Nenhum registro encontrado',
                info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
                infoEmpty: 'Mostrando 0 até 0 de 0 registros',
                infoFiltered: '(Filtrados de _MAX_ registros)',
                infoThousands: '.',
                loadingRecords: 'Carregando...',
                processing: 'Processando...',
                zeroRecords: 'Nenhum registro encontrado',
                search: 'Pesquisar',
                paginate: {
                    next: 'Próximo',
                    previous: 'Anterior',
                    first: 'Primeiro',
                    last: 'Último'
                }
            },
            bDestroy: true,
            responsive: false,
            pageLength: 5,
            lengthChange: true,
            autoWidth: true,
            order: [],
            processing: true,
            serverSide: false,
            ajax: 'brigadas/escalas_index/' + $('#registro_id').val() + '/' + $('#es_periodo_data_1').val() + '/' + $('#es_periodo_data_2').val(),
            columnDefs: [{'targets': [0, 1, 2, 3, 4], 'orderable': false}],
            columns: [
                {'data': '#'},
                {'data': 'funcionario_nome'},
                {'data': 'chegada'},
                {'data': 'saida'},
                {'data': 'action'}
            ]
        });
    }
}
//Brigadas Incêndios - Escalas - FIM'''''''''''''''''''''
//Brigadas Incêndios - Escalas - FIM'''''''''''''''''''''

//Brigadas Incêndios - Rondas - INÍCIO'''''''''''''''''''
//Brigadas Incêndios - Rondas - INÍCIO'''''''''''''''''''

//Função para montar o Formulário da Ronda
//@PARAN op=1 : Executar Ronda - Dados vão vir da tabela clientes_seguranca_medidas
//@PARAN op=2 : Visualizar Ronda - Dados vão vir da tabela brigadas_rondas_seguranca_medidas
function formularioRonda(op, dados) {
    //dados
    var seguranca_medidas = dados;

    //Classificação - Medidas de Segurança''''''''''''''''''''''''''''''''''''''''''''
    var retorno = '';
    var retorno_titulo = '';
    var retorno_linha = '';

    //verificar validacoes
    if (seguranca_medidas.length <= 0) {
        alert('Erro nos dados vindos do Cliente. Verifique as Medidas de Segurança.');
        return;
    }

    //numero_pavimentos (Fictício)
    var numero_pavimentos = 50;

    //Montar
    for (var pavimento = 1; pavimento <= numero_pavimentos; pavimento++) {
        var ctrl = 0;

        retorno_titulo = '<h6 class="pb-3 text-success"><i class="fa fa-fire-extinguisher"></i> Medidas de Segurança - Pavimento ' + '<span class="font-size-15">' + pavimento + '</span>' + '</h6>';
        retorno_linha = '';

        //Campos
        $.each(seguranca_medidas, function (i, campo) {
            if (pavimento == campo.pavimento) {
                ctrl++;

                if (op == 1) {
                    var seguranca_medida_id = campo.seguranca_medida_id;
                    var seguranca_medida_nome = campo.seguranca_medida_nome;
                    var seguranca_medida_quantidade = campo.quantidade;
                    var seguranca_medida_tipo = campo.tipo;
                    var status = '';
                    var observacao = '';
                }

                if (op == 2) {
                    var seguranca_medida_id = campo.seguranca_medida_id;
                    var seguranca_medida_nome = campo.seguranca_medida_nome;
                    var seguranca_medida_quantidade = campo.seguranca_medida_quantidade;
                    var seguranca_medida_tipo = campo.seguranca_medida_tipo;
                    var status = campo.status;
                    var observacao = campo.observacao;
                }

                retorno_linha += formularioRondaSegurancaMedidas(op, ctrl, pavimento, seguranca_medida_id, seguranca_medida_nome, seguranca_medida_quantidade, seguranca_medida_tipo, status, observacao);
            }
        });

        if (retorno_linha != '') {retorno += retorno_titulo+retorno_linha;}
    }

    $('#divMedidasSegurancaRondaItens').html(retorno);
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

//Função para montar as Medidas Técnicas no Formulário Ronda
//@PARAN op=1 : Executar Ronda
//@PARAN op=2 : Visualizar Ronda
function formularioRondaSegurancaMedidas(op, ctrl, pavimento, seguranca_medida_id, seguranca_medida_nome, seguranca_medida_quantidade, seguranca_medida_tipo, status, observacao) {
    //Verificar se os campos vao ser readonly
    var readonly = '';
    var disabled = '';

    var textoStatus = 'NÃO INFORMADO';
    var textoCor = '';

    var botoesStyle = '';

    if (op == 2) {
        readonly = 'readonly';
        disabled = 'disabled';

        if (status == 0) {
            textoStatus = textoStatus = '<i class="far fa-calendar-minus"></i>'+' NÃO ENCONTRADO';
            textoCor = 'text-warning';
        }

        if (status == 1) {
            textoStatus = textoStatus = '<i class="far fa-calendar-check"></i>'+' CONFERIDO';
            textoCor = 'text-success';
        }

        if (status == 2) {
            textoStatus = textoStatus = '<i class="far fa-calendar-times"></i>'+' DANIFICADO';
            textoCor = 'text-danger';
        }

        botoesStyle = 'style="display:none;"';
    }

    var medidas_seguranca;

    medidas_seguranca = '<div class="col-12 col-md-6 pb-3">';
    medidas_seguranca += '  <div class="col-12 alert alert-primary">';
    medidas_seguranca += '      <div class="form-group col-12 pb-3">';
    medidas_seguranca += '          <div class="text-primary font-size-11 fw-bold align-middle me-2"><span class="font-size-14">'+pavimento+'.'+ctrl+'</span>' + '&nbsp;'+seguranca_medida_nome+ '</div>';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_id_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_id_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_id + '">';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_nome_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_nome_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_nome + '">';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_quantidade_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_quantidade_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_quantidade + '">';
    medidas_seguranca += '          <input type="hidden" id="seguranca_medida_tipo_' + pavimento + '_' + seguranca_medida_id + '" name="seguranca_medida_tipo_' + pavimento + '_' + seguranca_medida_id + '" value="' + seguranca_medida_tipo + '">';
    medidas_seguranca += '          <input type="hidden" name="ids_seguranca_medidas[]" value="' + seguranca_medida_id + '">';
    medidas_seguranca += '      </div>';
    medidas_seguranca += '      <div class="row">';
    medidas_seguranca += '          <div class="form-group col-2 col-md-2 pb-3">';
    medidas_seguranca += '              <label class="form-label">Qtd</label>';
    medidas_seguranca += '              <div class="col-12 text-dark">'+seguranca_medida_quantidade+'</div>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '          <div class="form-group col-10 col-md-10 pb-3">';
    medidas_seguranca += '              <label class="form-label">Tipo</label>';
    medidas_seguranca += '              <div class="col-12 text-dark">'+seguranca_medida_tipo+'</div>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '          <div class="form-group col-12 col-md-8">';
    medidas_seguranca += '              <label class="form-label">Observação</label>';
    medidas_seguranca += '              <textarea class="form-control" id="observacao_' + pavimento + '_' + seguranca_medida_id + '" name="observacao_' + pavimento + '_' + seguranca_medida_id + '" '+readonly+'>' + observacao + '</textarea>';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '          <div class="form-group col-12 col-md-4">';
    medidas_seguranca += '              <label class="form-label">Status</label>';
    medidas_seguranca += '              <div class="pb-2 font-size-12 '+textoCor+'" id="textoStatus_' + pavimento + '_' + seguranca_medida_id + '">'+textoStatus+'</div>';
    medidas_seguranca += '              <div class="row" '+botoesStyle+'>';
    medidas_seguranca += '                  <div class="col-4">';
    medidas_seguranca += '                      <button type="button" class="btn btn-outline-warning text-center font-size-16" onclick="formularioRondaCampoStatus(0, '+pavimento+', '+seguranca_medida_id+');"><i class="far fa-calendar-minus"></i></button>';
    medidas_seguranca += '                  </div>';
    medidas_seguranca += '                  <div class="col-4">';
    medidas_seguranca += '                      <button type="button" class="btn btn-outline-success text-center font-size-16" onclick="formularioRondaCampoStatus(1, '+pavimento+', '+seguranca_medida_id+');"><i class="far fa-calendar-check"></i></button>';
    medidas_seguranca += '                  </div>';
    medidas_seguranca += '                  <div class="col-4">';
    medidas_seguranca += '                      <button type="button" class="btn btn-outline-danger text-center font-size-16" onclick="formularioRondaCampoStatus(2, '+pavimento+', '+seguranca_medida_id+');"><i class="far fa-calendar-times"></i></button>';
    medidas_seguranca += '                  </div>';
    medidas_seguranca += '              </div>';
    medidas_seguranca += '              <input type="hidden" class="inputsStatus" id="status_' + pavimento + '_' + seguranca_medida_id + '" name="status_' + pavimento + '_' + seguranca_medida_id + '" value="' + status + '">';
    medidas_seguranca += '          </div>';
    medidas_seguranca += '      </div>';
    medidas_seguranca += '  </div>';
    medidas_seguranca += '</div>';

    return medidas_seguranca;
}

//Função para alterar os campos statuse textoStatus
function formularioRondaCampoStatus(id, pavimento, seguranca_medida_id) {
    if (id == 0) {
        textoStatus = '<i class="far fa-calendar-minus"></i>'+' NÃO ENCONTRADO';
        textoCor = 'text-warning';
    }

    if (id == 1) {
        textoStatus = '<i class="far fa-calendar-check"></i>'+' CONFERIDO';
        textoCor = 'text-success';
    }

    if (id == 2) {
        textoStatus = '<i class="far fa-calendar-times"></i>'+' DANIFICADO';
        textoCor = 'text-danger';
    }

    $('#textoStatus_' + pavimento + '_' + seguranca_medida_id).html(textoStatus);
    $('#textoStatus_' + pavimento + '_' + seguranca_medida_id).removeClass('text-warning').removeClass('text-success').removeClass('text-danger').addClass(textoCor);
    $('#status_' + pavimento + '_' + seguranca_medida_id).val(id);
}

//Função para validar campos antes de salvar
function formularioRondaValidar() {
    var error = false;
    var qtd = 0;

    $('.inputsStatus').each(function () {
        if ($(this).val() == '') {
            error = true;
            qtd++;
        }
    });

    if (error) {
        alert('Existem '+qtd+' itens para completar a Ronda.');
        return false;
    }

    return true;
}

//Brigadas Incêndios - Rondas - FIM''''''''''''''''''''''
//Brigadas Incêndios - Rondas - FIM''''''''''''''''''''''

//Funções para o Submódulo Brigadas Incêndios - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Brigadas Incêndios - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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

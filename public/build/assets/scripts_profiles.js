function userProfileData(local, id) {
    var url_atual = window.location.protocol+'//'+window.location.host+'/';

    //verificar local : 1- Grade de Usuários ou 2 - Perfil Usuário Logado
    if (local == 1) {$('#modal-profile-botoes').hide();}
    if (local == 2) {$('#modal-profile-botoes').show();}

    $.ajax({
        processing: true,
        serverSide: true,
        type: "GET",
        url: url_atual+"profiledata",
        data: {id: id},
        datatype: "json",
        success: function (response) {
            //Lendo json
            let json = JSON.parse(response);

            //Lendo dados user
            let user = json.user;

            //Passando dados user
            $('.jsonUserAvatar').attr('src', url_atual+user.avatar);
            $('.jsonUserGroup').html(user.grupoName+' Truncate');
            $('.jsonUserSituacao').html(user.situacaoName+' Truncate');
            $('.jsonUserName').html(user.name);
            $('.jsonUserFunction').html('FUNÇÃO');
            $('.jsonUserId').val(user.id);
            $('.jsonUserEmail').html(user.email);
            $('.jsonUserCurrentEmail').val(user.email);
            $('.jsonUserLocalizacao').html('ENDEREÇO');

            //Lendo dados transacoes (Totais)
            let transacoesCount = json.transacoesCount;

            //Passando dados transacoes (Totais)
            $('.jsonTransacoesInclusions').html(transacoesCount.inclusions);
            $('.jsonTransacoesAlterations').html(transacoesCount.alterations);
            $('.jsonTransacoesExclusions').html(transacoesCount.exclusions);

            //Lendo dados transacoes (Tabela)
            let transacoesTable = json.transacoesTable.transacoes;

            var tbodyTransacoes = '';

            if (transacoesTable != '') {
                //Passando dados transacoes (Tabela)
                var row = 0;

                function montarTable(item) {
                    row++;
                    operacaoName = item.operacaoName;
                    submoduloName = item.submoduloName;
                    dateFormated = item.date.substring(8,10)+'/'+item.date.substring(5,7)+'/'+item.date.substring(0,4);

                    tbodyTransacoes += "<tr><th scope='row'>" + row + "</th><td>" + operacaoName + "</td><td>" + submoduloName + "</td><td>" + dateFormated + "</td></tr>";
                }

                transacoesTable.forEach(montarTable);
            }

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonTransacoesTable').html(tbodyTransacoes);
            configurarDataTable(2);
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

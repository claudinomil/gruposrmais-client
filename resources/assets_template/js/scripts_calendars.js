$(document).ready(function () {
    //Date and time picker'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    $('#dateTimeInicioCreate').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'YYYY-MM-DD HH:mm',
        pick12HourFormat: false
    });

    $('#dateTimeFimCreate').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'YYYY-MM-DD HH:mm',
        pick12HourFormat: false
    });

    $('#dateTimeInicioUpdate').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'YYYY-MM-DD HH:mm',
        pick12HourFormat: false
    });

    $('#dateTimeFimUpdate').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'YYYY-MM-DD HH:mm',
        pick12HourFormat: false
    });
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    var calendar = $('#calendar').fullCalendar({
        locale: 'pt-br',
        lang: 'pt-br',
        editable: true,
        displayEventTime: true,
        allDay: true,
        header: {left: 'prev, next today', center: 'title', right: ''},
        selectable: true,
        selectHelper: true,

        select: function (start, end, allDay) {
            $('#fc_create').click();

            $('#cr_event_start').val($.fullCalendar.formatDate(start, "YYYY-MM-DD HH:mm"));
            $('#cr_event_end').val($.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm"));
        },

        eventClick: function (event) {
            $('#fc_update').click();

            $('#up_event_id').val(event.id);
            $('#up_event_status').val(event.status);
            $('#up_event_title').val(event.title);
            $('#up_event_start').val($.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm"));
            $('#up_event_end').val($.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm"));
            $('#up_event_description').val(event.description);
        },

        eventDrop: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm");
            var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm");

            $.ajax({
                url: '/calendarsAjax',
                data: {
                    id: event.id,
                    status: event.status,
                    title: event.title,
                    start: start,
                    end: end,
                    description: event.description,
                    className: event.status+" "+event.status+"-text",
                    type: 'update'
                },
                type: "POST",
                success: function (response) {
                    displayMessage("Evento alterado com sucesso");
                }
            });
        },

        eventMouseover: function(calEvent, jsEvent) {
            //montando informacoes para o Tooltip
            ev_title = calEvent.title;

            ev_data_inicio = calEvent.start.format().toString().substring(0, 10);
            ev_data_inicio = ev_data_inicio.substring(8, 10)+"/"+ev_data_inicio.substring(5, 7)+"/"+ev_data_inicio.substring(0, 4);
            ev_data_fim = calEvent.end.format().toString().substring(0, 10);
            ev_data_fim = ev_data_fim.substring(8, 10)+"/"+ev_data_fim.substring(5, 7)+"/"+ev_data_fim.substring(0, 4);

            ev_hora_inicio =  calEvent.start.format().substring(11);
            ev_hora_fim =  calEvent.end.format().substring(11);

            ev_description = calEvent.description;
            ev_background = calEvent.status;
            ev_color = calEvent.status+'-text';

            if (calEvent.status == 'fc-event-info') {ev_status = 'Informação';}
            if (calEvent.status == 'fc-event-much-urgency') {ev_status = 'Muita Urgência';}
            if (calEvent.status == 'fc-event-urgency') {ev_status = 'Urgência';}
            if (calEvent.status == 'fc-event-low-urgency') {ev_status = 'Pouca Urgência';}

            var tooltip = '';

            tooltip += '<div class="tooltipevent" style="width: 260px; position: absolute; z-index: 1;">';
            tooltip += '<div class="card card-widget widget-user-2 shadow-sm">';
            tooltip += '<div class="widget-user-header '+ev_background+'">';
            tooltip += '<h5 class="text-white">'+ev_title+'</h5>';
            tooltip += '</div>';
            tooltip += '<div class="card-footer p-0">';
            tooltip += '<ul class="nav flex-column">';
            tooltip += '<li class="nav-item" style="padding: .5rem 1rem;">Início <span class="float-right badge">'+ev_data_inicio+' às '+ev_hora_inicio+'</span></li>';
            tooltip += '<li class="nav-item" style="padding: .5rem 1rem;">Fim <span class="float-right badge">'+ev_data_fim+' às '+ev_hora_fim+'</span></li>';
            tooltip += '<li class="nav-item" style="padding: .5rem 1rem;">Status <span class="float-right badge '+ev_background+'">'+ev_status+'</span></li>';
            tooltip += '<li class="nav-item" style="padding: .5rem 1rem;">Descrição <span class="float-right badge bg-success" style="white-space : normal;">'+ev_description+'</span></li>';
            tooltip += '</ul>';
            tooltip += '</div>';
            tooltip += '</div>';
            tooltip += '</div>';

            var $tooltip = $(tooltip).appendTo('body');

            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $tooltip.fadeIn('500');
                $tooltip.fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $tooltip.css('top', e.pageY + 10);
                $tooltip.css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.tooltipevent').remove();
        }
    });

    //filtrar Eventos
    $("#buttonSearchVal").on("click", function() {
        searchEvents(calendar, $('#search_val').val());
    });

    //filtrar Eventos
    $("#buttonSearchDate").on("click", function() {
        goToMonth(calendar, $('#search_date').val());
    });

    //clicando no Confirmar (Create Event)
    $(".cr_confirmar").on("click", function() {
        eventIncluir(calendar);
    });

    //clicando no Confirmar (Update Event)
    $(".up_confirmar").on("click", function() {
        eventAlterar(calendar);
    });

    //clicando no Apagar (Delete Event)
    $(".up_deletar").on("click", function() {
        eventDeletar(calendar);
    });

    //clicando no botão Mês Anterior (Mês PREV)
    $(".fc-prev-button").on("click", function() {
        eventMonthly(calendar);
    });

    //clicando no botão Mês Posterior (Mês NEXT)
    $(".fc-next-button").on("click", function() {
        eventMonthly(calendar);
    });

    //clicando no botão Today (TODAY)
    $(".fc-today-button").on("click", function() {
        eventMonthly(calendar);
    });

    //buscar eventos ao entrar
    var data = $('#calendar').fullCalendar('getDate').format().substring(0, 7);
    searchEvents(calendar, data);
});

function displayMessage(message) {
    toastr.success(message, 'Event');
}

function eventMonthly(calendar) {
    var data = $('#calendar').fullCalendar('getDate').format().substring(0, 7);

    searchEvents(calendar, data);
}

function goToMonth(calendar, valDate) {
    date = valDate + "-01";

    calendar.fullCalendar('gotoDate', date);

    searchEvents(calendar, valDate);
}

function searchEvents(calendar, valSearch='') {
    $.ajax({
        url: '/calendarsAjax',
        data: {
            valSearch: valSearch,
            type: 'events'
        },
        type: "POST",
        success: function (data) {
            //atualizando Eventos
            calendar.fullCalendar('removeEvents');
            calendar.fullCalendar('addEventSource', data);
            calendar.fullCalendar('rerenderEvents');
        }
    });
}

function eventIncluir(calendar) {
    //dados do formulario
    status = $('#cr_event_status').val();
    title = $('#cr_event_title').val();
    start = $('#cr_event_start').val();
    end = $('#cr_event_end').val();
    description = $('#cr_event_description').val();
    className = $('#cr_event_status').val()+" "+$('#cr_event_status').val()+"-text";

    //criticar dados
    if (title == '') {alert('Título inválido'); return false;}
    if (start == '') {alert('Data/Hora Início inválido'); return false;}
    if (end == '') {alert('Data/Hora Fim inválido'); return false;}
    if (start >= end) {alert('Data/Hora Fim deve ser maior que Data/Hora Início'); return false;}

    //gravar na tabela
    $.ajax({
        url: "/calendarsAjax",
        data: {
            status: status,
            title: title,
            start: start,
            end: end,
            description: description,
            className: className,
            type: 'add'
        },
        type: "POST",
        success: function (data) {
            //atualizando Eventos
            searchEvents(calendar);

            //mensagem de retorno
            displayMessage("Evento criado com sucesso");

            //fechar modal
            $('.cr_cancelar').click();

            //limpr dados do formulario
            //$('#cr_event_status').val('');
            $('#cr_event_title').val('');
            $('#cr_event_start').val('');
            $('#cr_event_end').val('');
            $('#cr_event_description').val('');
        }
    });
}

function eventAlterar(calendar) {
    //dados do formulario
    id = $('#up_event_id').val();
    status = $('#up_event_status').val();
    title = $('#up_event_title').val();
    start = $('#up_event_start').val();
    end = $('#up_event_end').val();
    description = $('#up_event_description').val();
    className = $('#up_event_status').val()+" "+$('#up_event_status').val()+"-text";

    //criticar dados
    if (title == '') {alert('Título inválido'); return false;}
    if (start == '') {alert('Data/Hora Início inválido'); return false;}
    if (end == '') {alert('Data/Hora Fim inválido'); return false;}
    if (start >= end) {alert('Data/Hora Fim deve ser maior que Data/Hora Início'); return false;}

    //gravar na tabela
    $.ajax({
        url: "/calendarsAjax",
        data: {
            id: id,
            status: status,
            title: title,
            start: start,
            end: end,
            description: description,
            className: className,
            type: 'update'
        },
        type: "POST",
        success: function (event) {
            //atualizando Eventos
            searchEvents(calendar);

            //mensagem de retorno
            displayMessage("Evento alterado com sucesso");

            //fechar modal
            $('.up_cancelar').click();

            //limpr dados do formulario
            //$('#up_event_status').val('');
            $('#up_event_title').val('');
            $('#up_event_start').val('');
            $('#up_event_end').val('');
            $('#up_event_description').val('');
        }
    });
}

function eventDeletar(calendar) {
    //dados do formulario
    id = $('#up_event_id').val();

    //deletando
    var deleteMsg = confirm("Você realmente quer apagar?");

    if (deleteMsg) {
        $.ajax({
            type: "POST",
            url: '/calendarsAjax',
            data: {
                id: id,
                type: 'delete'
            },
            success: function (response) {
                //atualizando Eventos
                searchEvents(calendar);

                //mensagem de retorno
                displayMessage("Evento apagado com sucesso");

                //fechar modal
                $('.up_cancelar').click();

                //limpr dados do formulario
                //$('#up_event_status').val('');
                $('#up_event_title').val('');
                $('#up_event_start').val('');
                $('#up_event_end').val('');
                $('#up_event_description').val('');
            }
        });
    }
}

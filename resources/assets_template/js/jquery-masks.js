function putMask() {
    $('.mask_date').mask('00/00/0000');
    $('.mask_time').mask('00:00:00');
    $('.mask_date_time').mask('00/00/0000 00:00:00');
    $('.mask_cep').mask('00000-000');
    $('.mask_phone').mask('0000-0000');
    $('.mask_phone_with_ddd').mask('(00) 0000-0000');
    $('.mask_cell').mask('00000-0000');
    $('.mask_cell_with_ddd').mask('(00) 00000-0000');
    $('.mask_cpf').mask('000.000.000-00', {reverse: true});
    $('.mask_pis').mask('000.00000.00-0', {reverse: true});
    $('.mask_pasep').mask('000.00000.00-0', {reverse: true});
    $('.mask_cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.mask_numero_ponto').mask('000.000.00', {reverse: true});
    $('.mask_money').mask('000.000.000.000.000,00', {reverse: true});
    $('.mask_money2').mask("#.##0,00", {reverse: true});
    $('.mask_percent').mask('##0,00%', {reverse: true});
    $('.mask_email').mask("A", {
        translation: {
            "A": {pattern: /[\w@\-.+]/, recursive: true}
        }
    });
}

function removeMask() {
    //$('.mask_date').unmask();
    //$('.mask_time').unmask();
    //$('.mask_date_time').unmask();
    $('.mask_cep').unmask();
    $('.mask_phone').unmask();
    $('.mask_phone_with_ddd').unmask();
    $('.mask_cell').unmask();
    $('.mask_cell_with_ddd').unmask();
    $('.mask_cpf').unmask();
    $('.mask_pis').unmask();
    $('.mask_pasep').unmask();
    $('.mask_cnpj').unmask();
    //$('.mask_money').unmask();
    //$('.mask_money2').unmask();
    //$('.mask_percent').unmask();
    //$('.mask_email').unmask();
}

putMask();

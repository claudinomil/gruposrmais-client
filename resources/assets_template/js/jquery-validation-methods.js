//id
jQuery.validator.addMethod("idMethod", function(value, element) {
    var retorno = false;

    if (!isNaN(value)) {retorno = true;}

    return this.optional(element) || retorno;
}, "Informe uma Opção válida");

//numero
jQuery.validator.addMethod("numberMethod", function(value, element) {
    var retorno = false;

    if (!isNaN(value)) {retorno = true;}

    return this.optional(element) || retorno;
}, "Informe um Número válido");

//telefone
jQuery.validator.addMethod("telefoneMethod", function(value, element) {
    value = value.replace(/\s+/g, "");
    return this.optional(element) || value.length > 9 && value.match(/\(\d{2}\)\d{4,5}\-\d{4}/);
}, "Informe um Telefone válido");

//celular
jQuery.validator.addMethod("cellularMethod", function(value, element) {
    value = value.replace(/\s+/g, "");
    return this.optional(element) || value.length > 9 && value.match(/\(\d{2}\)\d{4,5}\-\d{4}/);
}, "Informe um Celular válido");

//cpf
jQuery.validator.addMethod("cpfMethod", function (value, element) {
    value = jQuery.trim(value);

    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;
}, "Informe um CPF válido");

//cnpj
jQuery.validator.addMethod("cnpjMethod", function (value, element) {
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    if (value.length == 0) {
        return false;
    }

    value = value.replace(/\D+/g, '');
    digitos_iguais = 1;

    for (i = 0; i < value.length - 1; i++)
        if (value.charAt(i) != value.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (digitos_iguais)
        return false;

    tamanho = value.length - 2;
    numeros = value.substring(0, tamanho);
    digitos = value.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        return false;
    }
    tamanho = tamanho + 1;
    numeros = value.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    var retorno = true;

    retorno = (resultado == digitos.charAt(1));

    return this.optional(element) || retorno;
}, "Informe um CNPJ válido");

//data
jQuery.validator.addMethod("dateMethod", function (value, element) {
    var retorno = true;
    var date = value;
    var ardt = new Array;
    var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
    ardt = date.split("/");
    erro_dt = false;
    if (date.search(ExpReg)==-1) {
        erro_dt = true;
    } else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30)) {
        erro_dt = true;
    } else if ( ardt[1]==2) {
        if ((ardt[0]>28)&&((ardt[2]%4)!=0)) {
            erro_dt = true;
        }
        if ((ardt[0]>29)&&((ardt[2]%4)==0)) {
            erro_dt = true;
        }
    }

    if (erro_dt) {retorno = false;}

    return this.optional(element) || retorno;
}, "Informe uma Data válido");

//pis
jQuery.validator.addMethod("pisMethod", function (value, element) {
    var retorno = true;

    var multiplicadorBase = "3298765432";
    var total = 0;
    var resto = 0;
    var multiplicando = 0;
    var multiplicador = 0;
    var digito = 99;

    // Retira a mascara
    var numeroPIS = value.replace(/[^\d]+/g, '');

    if (numeroPIS.length !== 11 ||
        numeroPIS === "00000000000" ||
        numeroPIS === "11111111111" ||
        numeroPIS === "22222222222" ||
        numeroPIS === "33333333333" ||
        numeroPIS === "44444444444" ||
        numeroPIS === "55555555555" ||
        numeroPIS === "66666666666" ||
        numeroPIS === "77777777777" ||
        numeroPIS === "88888888888" ||
        numeroPIS === "99999999999") {

        retorno = false;
    } else {
        for (var i = 0; i < 10; i++) {
            multiplicando = parseInt( numeroPIS.substring( i, i + 1 ) );
            multiplicador = parseInt( multiplicadorBase.substring( i, i + 1 ) );
            total += multiplicando * multiplicador;
        }

        resto = 11 - total % 11;
        resto = resto === 10 || resto === 11 ? 0 : resto;

        digito = parseInt("" + numeroPIS.charAt(10));
        retorno = resto === digito;
    }

    return this.optional(element) || retorno;
}, "Informe um PIS válido");

//pasep
jQuery.validator.addMethod("pasepMethod", function (value, element) {
    var retorno = true;

    var multiplicadorBase = "3298765432";
    var total = 0;
    var resto = 0;
    var multiplicando = 0;
    var multiplicador = 0;
    var digito = 99;

    // Retira a mascara
    var numeroPIS = value.replace(/[^\d]+/g, '');

    if (numeroPIS.length !== 11 ||
        numeroPIS === "00000000000" ||
        numeroPIS === "11111111111" ||
        numeroPIS === "22222222222" ||
        numeroPIS === "33333333333" ||
        numeroPIS === "44444444444" ||
        numeroPIS === "55555555555" ||
        numeroPIS === "66666666666" ||
        numeroPIS === "77777777777" ||
        numeroPIS === "88888888888" ||
        numeroPIS === "99999999999") {

        retorno = false;
    } else {
        for (var i = 0; i < 10; i++) {
            multiplicando = parseInt( numeroPIS.substring( i, i + 1 ) );
            multiplicador = parseInt( multiplicadorBase.substring( i, i + 1 ) );
            total += multiplicando * multiplicador;
        }

        resto = 11 - total % 11;
        resto = resto === 10 || resto === 11 ? 0 : resto;

        digito = parseInt("" + numeroPIS.charAt(10));
        retorno = resto === digito;
    }

    return this.optional(element) || retorno;
}, "Informe um PASEP válido");

//carteira de trabalho
jQuery.validator.addMethod("carteira_trabalhoMethod", function (value, element) {
    return true;
}, "Informe uma Carteira de Trabalho válida");

//cep
jQuery.validator.addMethod("cepMethod", function (value, element) {
    return true;
}, "Informe um CEP válido");

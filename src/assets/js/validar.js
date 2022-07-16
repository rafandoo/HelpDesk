/**
 * If the value of the input field is not equal to the value of the password field, then set the custom
 * validity of the input field to "Repita a senha corretamente". Otherwise, set the custom validity of
 * the input field to an empty string
 * @param input - The input element that is being validated.
 */
function validaSenha (input) { 
    if (input.value != document.getElementById('senha').value) {
        input.setCustomValidity('Repita a senha corretamente');
    } else {
        input.setCustomValidity('');
    }
}

/**
 * If the value of the input field is 0 or empty, alert the user that the ticket hasn't been included
 * yet. Otherwise, redirect the user to the url.
 * @param url - The URL to redirect to.
 */
function validaTicket (url) {
    var ticket = document.getElementById('idTicket').value;
    if (ticket == 0 || ticket == '') {
        alert('Ticket não foi incluido ainda!');
    } else {
        location.href = url
    }
}

/**
 * If the email exists, set the custom validity to "Email já cadastrado!"; otherwise, set the custom
 * validity to an empty string.
 * @param input - The input element that is being validated.
 * @param existe - is a variable that is returned by the PHP script.
 */
function validarEmailUsuario (input, existe) { 
    if (existe == '1') {
        input.setCustomValidity('Email já cadastrado!');
    } else {
        input.setCustomValidity('');
    }
}

/**
 * If the user exists, set the custom validity to 'Usuário já cadastrado!'; otherwise, set the custom
 * validity to an empty string.
 * @param input - The input element that is being validated.
 * @param existe - is a variable that is returned by the the PHP script.
 */
function validarLoginUsuario (input, existe) {
    if (existe == '1') {
        input.setCustomValidity('Usuário já cadastrado!');
    } else {
        input.setCustomValidity('');
    }
}

function validacaoCpfCnpj(val) {
    if (val.length == 14) {
        var cpf = val.trim();
        cpf = cpf.replace(/\./g, '');
        cpf = cpf.replace('-', '');
        cpf = cpf.split('');
        
        var dv1 = 0;
        var dv2 = 0;
        var aux = false;
        
        for (var i = 1; cpf.length > i; i++) {
            if (cpf[i - 1] != cpf[i]) {
                aux = true;   
            }
        } 
        
        if (aux == false) {
            return false; 
        } 
        
        for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
            dv1 += cpf[i] * p; 
        } 
        
        dv1 = ((dv1 * 10) % 11);
        
        if (dv1 == 10) {
            dv1 = 0; 
        }
        
        if (dv1 != cpf[9]) {
            return false; 
        } 
        
        for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
            dv2 += cpf[i] * p; 
        } 
        
        dv2 = ((dv2 * 10) % 11);
        
        if (dv2 == 10) {
            dv2 = 0; 
        }
        
        if (dv2 != cpf[10]) {
            return false; 
        } else {   
            return true; 
        }
    } else if (val.length == 18) {
        var cnpj = val.trim();
        
        cnpj = cnpj.replace(/\./g, '');
        cnpj = cnpj.replace('-', '');
        cnpj = cnpj.replace('/', ''); 
        cnpj = cnpj.split(''); 
        
        var dv1 = 0;
        var dv2 = 0;
        var aux = false;
        
        for (var i = 1; cnpj.length > i; i++) { 
            if (cnpj[i - 1] != cnpj[i]) {  
                aux = true;   
            } 
        } 
        
        if (aux == false) {  
            return false; 
        }
        
        for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
            if (p1 >= 2) {  
                dv1 += cnpj[i] * p1;  
            } else {  
                dv1 += cnpj[i] * p2;  
            } 
        } 
        
        dv1 = (dv1 % 11);
        
        if (dv1 < 2) { 
            dv1 = 0; 
        } else { 
            dv1 = (11 - dv1); 
        } 
        
        if (dv1 != cnpj[12]) {  
            return false; 
        } 
        
        for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) { 
            if (p1 >= 2) {  
                dv2 += cnpj[i] * p1;  
            } else {   
                dv2 += cnpj[i] * p2; 
            } 
        }
        
        dv2 = (dv2 % 11); 
        
        if (dv2 < 2) {  
            dv2 = 0;
        } else { 
            dv2 = (11 - dv2); 
        } 
        
        if (dv2 != cnpj[13]) {   
            return false; 
        } else {  
            return true; 
        }
    } else {
        return false;
    }
}

function validarCpfCnpj(input, existe) {
    if (existe == '1') {
        input.setCustomValidity('CPF/CNPJ já cadastrado!');
    } else {
        if (validacaoCpfCnpj(formatarCpfCnpj(input.value))) {
            input.setCustomValidity('');
        } else {
            input.setCustomValidity('CPF/CNPJ inválido!');
        }
    }
    input.value = formatarCpfCnpj(input.value);
}

/**
 * It sends a request to a PHP file, and then does something with the response.
 * @param acao - action
 * @param valor - the value of the input
 * @param input - the input field
 */
function callValidarPHP(acao, valor, input, id) {
    $.ajax({
        type: "POST",
        url: "util/validar.php",
        data: "acao=" + acao + "&valor=" + valor + "&id=" + id,
        dataType: "html"
    }).done(function(resposta) {
        if (acao == 'email') {
            validarEmailUsuario(input, resposta);
        } else if (acao == 'login') {
            validarLoginUsuario(input, resposta);
        } else if (acao == 'cpfCnpj') {
            validarCpfCnpj(input, resposta);
        }
    });
}

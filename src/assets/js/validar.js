function validaSenha (input) { 
    if (input.value != document.getElementById('senha').value) {
        input.setCustomValidity('Repita a senha corretamente');
    } else {
        input.setCustomValidity('');
    }
}

function validarEmailUsuario (input, existe) { 
    if (existe == '1') {
        input.setCustomValidity('Email já cadastrado!');
    } else {
        input.setCustomValidity('');
    }
}

function validarLoginUsuario (input, existe) {
    if (existe == '1') {
        input.setCustomValidity('Usuário já cadastrado!');
    } else {
        input.setCustomValidity('');
    }
}

function callValidarPHP(acao, valor, input) {
    $.ajax({
        type: "POST",
        url: "util/validar.php",
        data: "acao=" + acao + "&valor=" + valor,
        dataType: "html"
    }).done(function(resposta) {
        if (acao == 'email') {
            validarEmailUsuario(input, resposta);
        } else if (acao == 'login') {
            validarLoginUsuario(input, resposta);
        }
    });
}

function callValidarPHPAlterar(acao, valor, id, input) {
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
        }
    });
}
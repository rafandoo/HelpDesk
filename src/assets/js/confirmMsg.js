function confirmExclusao(url) {
    if (confirm("Confirmar exclusão?"))
        location.href = url;
}

function confirmBloquear(url) {
    if (confirm("Confirmar alteração de situação?"))
        location.href = url;
}

function alertExistLogin() {
    alert("O usuário informado já existe!");
}

function alertExistEmail() {
    alert("O email informado já existe!");
}

function alertSenha() {
    alert("A senha digitada não confere!");
}
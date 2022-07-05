function confirmExclusion(url){
    if (confirm("Confirmar exclusão?"))
        location.href = url;
}

function confirmBloquear(url){
    if (confirm("Confirmar alteração de situação?"))
        location.href = url;
}
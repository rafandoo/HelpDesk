//quando seleciona um option
$("#estado").change(function () {
    //pega o valor do option selecionado
    let id = $(this).val();

    //faz a requisião ajax no arquivo php
    $.ajax({
        url: "util/buscaCidades.php",
        method: "POST",
        data: { "id": id },
        dataType: "HTML"
    }).done(function (data) {
        $("#cidade").html(data);
    });
});
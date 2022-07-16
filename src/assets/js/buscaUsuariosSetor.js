$("#setor").change(function () {

    let idSetor = $(this).val();

    $.ajax({
        url: "util/buscaUsuariosSetor.php",
        method: "POST",
        data: { "idSetor": idSetor },
        dataType: "HTML"
    }).done(function (data) {
        $("#usuario").html(data);
    });
});
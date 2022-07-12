$("#setor").change(function () {
  let id = $(this).val();

  $.ajax({
    url: "util/buscaUsuariosSetor.php",
    method: "POST",
    data: { id: id },
    dataType: "HTML",
  }).done(function (data) {
    $("#usuario").html(data);
  });
});

function filtrarCliente() {
  var fitro = document.getElementById("filtro").value;
  var procurar = document.getElementById("procurar").value;

  $.ajax({
    url: "util/buscaCliente.php",
    method: "POST",
    data: "filtro=" + fitro + "&procurar=" + procurar,
    dataType: "HTML",
  }).done(function (data) {
    $("#dados").html(data);
  });
}

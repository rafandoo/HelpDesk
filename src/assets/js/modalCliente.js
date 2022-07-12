function selecionaCliente(id, nome) {
  document.getElementById("idCliente").value = id;
  document.getElementById("cliente").value = nome;
  $(".modal").modal("hide");
}

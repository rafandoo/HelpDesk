function formatarCpfCnpj(value) {
  const CPFLENGTH = 11;
  const CNPJLENGTH = 14;
  const cpfCnpj = value.replace(/\D/g, "");

  if (cpfCnpj.length === CPFLENGTH) {
    return cpfCnpj.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "$1.$2.$3-$4");
  } else if (cpfCnpj.length === CNPJLENGTH) {
    return cpfCnpj.replace(
      /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,
      "$1.$2.$3/$4-$5"
    );
  } else {
    return cpfCnpj;
  }
}

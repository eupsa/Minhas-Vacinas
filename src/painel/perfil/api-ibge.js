document.addEventListener("DOMContentLoaded", async () => {
  const estado = document.getElementById("estado");
  const cidade = document.getElementById("cidade");

  if (!estado.value) return;

  var query =
    "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" +
    estado.value +
    "/municipios";
  const request = await fetch(query);
  const response = await request.json();

  cidade.innerHTML =
    '<option value="" disabled selected>Selecione uma cidade...</option>';

  response.forEach(function (i) {
    const option = document.createElement("option");
    option.value = i.nome;
    option.innerText = i.nome;
    cidade.appendChild(option);
  });
});


estado.addEventListener("change", async () => {
  var query =
    "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" +
    estado.value +
    "/municipios";
  const request = await fetch(query);
  const response = await request.json();

  cidade.innerHTML =
    '<option value="" disabled selected>Selecione uma cidade...</option>';

  response.forEach(function (i) {
    const option = document.createElement("option");
    option.value = i.nome;
    option.innerText = i.nome;
    cidade.appendChild(option);
  });
});

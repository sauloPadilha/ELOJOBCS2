const urlUF = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";
const uf = document.getElementById("uf");
const cidade = document.getElementById("cidade");

uf.addEventListener("change", async function () {
  if(uf.value){
    const urlCidades =
      "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" +
      uf.value +
      "/municipios";
    const request = await fetch(urlCidades);
    const response = await request.json();

    var valor_select = cidade.getAttribute("value");

    let options = "";

    response.forEach(function (cidade) {
      var selected = "";

      if (valor_select && valor_select == cidade.nome) {
        selected = "selected";
      }
      options += `<option ${selected}>${cidade.nome}</option>`;
    });
    cidade.innerHTML = options;
  };
});

window.addEventListener("load", async () => {
  const request = await fetch(urlUF);
  const response = await request.json();

  const options = document.createElement("optgroup");
  options.setAttribute("label", "Estados");

  var siglas = [];

  response.forEach(function (uf) {
    siglas.push(`${uf.sigla} - ${uf.nome}`);
  });

  siglas.sort();

  var valor_select = uf.getAttribute("value");

  siglas.forEach(function (uf) {
    var selected = "";
    var estado = uf.split(" - ");

    if (valor_select && valor_select == estado[0]) {
      selected = "selected";
    }

    options.innerHTML += `<option value = "${estado[0]}" ${selected}>${uf}</option>`;
  });
  uf.append(options);

  const evento_change = new Event("change");
  uf.dispatchEvent(evento_change);
});

function exibeDiv() {
  var div = document.getElementById("pinto");
  if (div) {
    div.style.display = "block";
  }
}

const form_exclusao_conta = document.querySelector("#form-excluir-conta");

if (form_exclusao_conta) {
  form_exclusao_conta.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_exclusao_conta);

    const email = dadosForm.get("email");
    const code_email = dadosForm.get("code_email");

    if (!email) {
      Swal.fire({
        text: "É necessário preencher o campo e-mail.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../backend/excluir-conta.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        exibeDiv();
      });
    } else {
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

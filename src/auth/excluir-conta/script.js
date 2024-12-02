// function exibeDiv() {
//   var div = document.getElementById("pinto");
//   if (div) {
//     div.style.display = "block";
//   }
// }

const form_send_email = document.querySelector("#form-send-email");

if (form_send_email) {
  form_send_email.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_send_email);

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
        // exibeDiv();
        document.getElementById("form-send-email").style.display = "none";
        document.getElementById("form-code-email").style.display = "block";
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

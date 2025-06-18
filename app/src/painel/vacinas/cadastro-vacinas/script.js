document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

const form_vacina = document.querySelector("#form_vacina");

if (form_vacina) {
  form_vacina.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_vacina);
    const nomeVac = dadosForm.get("nomeVac");
    const dataAplicacao = dadosForm.get("dataAplicacao");
    const proxima_dose = dadosForm.get("proxima_dose");
    const tipo = dadosForm.get("tipo");
    const dose = dadosForm.get("dose");
    const lote = dadosForm.get("lote");
    const obs = dadosForm.get("obs");
    const localAplicacao = dadosForm.get("localAplicacao");

    if (!nomeVac || !dataAplicacao || !tipo || !dose || !localAplicacao) {
      Swal.fire({
        text: "Preencha todos os campos obrigatórios.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      html: "Aguarde enquanto estamos cadastrando...",
      timer: 2000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../../backend/cadastro-vacina.php", {
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
      });
      window.location.href = "../";
      form_vacina.reset();
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

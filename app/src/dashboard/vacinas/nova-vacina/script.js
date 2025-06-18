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

    // Validação dos campos obrigatórios
    if (!nomeVac || !dataAplicacao || !tipo || !dose || !localAplicacao) {
      Swal.fire({
        text: "Por favor, preencha todos os campos obrigatórios para continuar.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Entendido",
      });
      return;
    }

    // Exibe o carregamento enquanto o processo é feito
    Swal.fire({
      title: "Estamos processando sua solicitação...",
      html: "Aguarde enquanto registramos as informações da vacina.",
      timer: 2000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Envia os dados para o backend
    const dados = await fetch("../../backend/cadastro-vacina.php", {
      method: "POST",
      body: dadosForm,
    });
    const resposta = await dados.json();

    // Caso a operação seja bem-sucedida
    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok, Entendido!",
      }).then(() => {
        window.location.href = "../"; // Redireciona para a página principal
      });
      form_vacina.reset(); // Limpa o formulário após o sucesso
    } else {
      // Caso ocorra um erro
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Tentar novamente",
      });
    }
  });
}

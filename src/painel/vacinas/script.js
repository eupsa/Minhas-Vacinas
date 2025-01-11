document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// Função para exportar vacina individual
function exportarVacina(button) {
  var idVacina = button.getAttribute("data-id");
  var vacinaElement = button.closest(".card");

  var nomeVacina = vacinaElement.querySelector(".card-title").innerText;
  var dose = vacinaElement.querySelector(".card-text i.fa-syringe")
    ? vacinaElement.querySelector(".card-text i.fa-syringe").parentElement
        .innerText
    : "";
  var dataAplicacao = vacinaElement.querySelector(
    ".card-text i.fa-calendar-day"
  )
    ? vacinaElement.querySelector(".card-text i.fa-calendar-day").parentElement
        .innerText
    : "";
  var localAplicacao = vacinaElement.querySelector(
    ".card-text i.fa-map-marker-alt"
  )
    ? vacinaElement.querySelector(".card-text i.fa-map-marker-alt")
        .parentElement.innerText
    : "";
  var lote = vacinaElement.querySelector(".card-text i.fa-cogs")
    ? vacinaElement.querySelector(".card-text i.fa-cogs").parentElement
        .innerText
    : "";
  var observacoes = vacinaElement.querySelector(".card-text i.fa-sticky-note")
    ? vacinaElement.querySelector(".card-text i.fa-sticky-note").parentElement
        .innerText
    : "";

  var content = `
      <div style="text-align: center; margin-bottom: 30px;">
          <div style="display: flex; align-items: center; justify-content: center;">
              <img src="../../../assets/img/logo-head.png" alt="Logo Minhas Vacinas" style="width: 100px; margin-right: 10px;">
              <h1 style="font-size: 22px; color: #000000; font-weight: bold;">Minhas Vacinas</h1>
      </div>
      <div style="text-align: center; color: #495057;">
        <p style="font-size: 16px;">Sistema para gerenciamento do histórico de vacinação. Mantenha seu histórico atualizado e tenha fácil acesso a informações importantes sobre suas vacinas.</p>
      </div>
          <h2 style="font-size: 20px; color: #333; margin-top: 20px;">${nomeVacina}</h2>
          <div style="color: #333; font-size: 18px;">
              <strong>${dose}</strong><br>
              <strong>${dataAplicacao}</strong> <br>
              <strong>${localAplicacao}</strong><br>
              <strong>${lote}</strong> <br>
              <strong>${observacoes}</strong><br>
          </div>
      </div>
      <hr>
      <div style="text-align: center; color: #495057;">
          <p><a href="" target="_blank" style="color:rgb(0, 0, 0); text-decoration: none;">Exportado por https://www.minhasvacinas.online</a></p>
          <p><a href="https://bit.ly/minhasvacinas" target="_blank" style="color: #007bff; text-decoration: none;">Visite nosso site: Minhas Vacinas</a></p>
      </div>
  `;

  var opt = {
    margin: 1,
    filename: "vacina_" + idVacina + ".pdf",
    image: {
      type: "jpeg",
      quality: 0.98,
    },
    html2canvas: {
      scale: 2,
    },
    jsPDF: {
      unit: "mm",
      format: "a4",
      orientation: "portrait",
    },
  };

  html2pdf().from(content).set(opt).save();
}

document.querySelectorAll(".form-excluir-vacina").forEach((form) => {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form);

    const id_vacina = dadosForm.get("id_vac");

    if (!id_vacina) {
      Swal.fire({
        text: "Não foi possível encontrar o campo ID_VACINA.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    let loadingSwal = Swal.fire({
      title: "Processando...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const dados = await fetch("../backend/excluir-vacina.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await dados.json();

      Swal.close();

      if (resposta["status"]) {
        Swal.fire({
          text: resposta["msg"],
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          location.reload();
        });
      }
    } catch (error) {
      Swal.close();

      Swal.fire({
        text: "Ocorreu um erro ao tentar excluir a vacina. Tente novamente mais tarde.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
});

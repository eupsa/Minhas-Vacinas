document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

// document.querySelectorAll("form").forEach((form) => {
//   form.addEventListener("submit", function (e) {
//     if (!confirm("Você tem certeza que deseja excluir esta vacina?")) {
//       e.preventDefault();
//     }
//   });
// });

document.querySelectorAll("form").forEach((form) => {
  form.addEventListener("submit", function (e) {
    alert("Em manutenção.");
    {
      e.preventDefault();
    }
  });
});

// const form_excluir_vacina = document.querySelector("#form-excluir-vacina");

// if (form_excluir_vacina) {
//   form_excluir_vacina.addEventListener("submit", async (e) => {
//     e.preventDefault();

//     const dadosForm = new FormData(form_excluir_vacina);

//     const id_vac = dadosForm.get("id_vac");

//     if (!id_vac) {
//       Swal.fire({
//         text: "ID não encontrado.",
//         icon: "error",
//         confirmButtonColor: "#3085d6",
//         confirmButtonText: "Fechar",
//         customClass: {
//           popup: "my-custom-swal",
//         },
//       });
//       return;
//     }

//     Swal.fire({
//       title: "Processando...",
//       timerProgressBar: true,
//       didOpen: () => {
//         Swal.showLoading();
//       },
//     });

//     try {
//       const dados = await fetch("../backend/excluir-vacina.php", {
//         method: "POST",
//         body: dadosForm,
//       });

//       if (!dados.ok) throw new Error("Erro ao processar a solicitação");

//       const resposta = await dados.json();

//       Swal.fire({
//         text: resposta["msg"],
//         icon: resposta["status"] ? "success" : "error",
//         confirmButtonColor: "#3085d6",
//         confirmButtonText: "Fechar",
//       }).then(() => {
//         location.reload();
//       });
//     } catch (error) {
//       Swal.fire({
//         text: "Erro ao processar a atualização. Tente novamente mais tarde.",
//         icon: "error",
//         confirmButtonColor: "#3085d6",
//         confirmButtonText: "Fechar",
//       });
//     }
//   });
// }

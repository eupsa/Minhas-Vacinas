document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

document.querySelectorAll("form").forEach((form) => {
  form.addEventListener("submit", function (e) {
    Swal.fire({
      text: "Em manutenção!",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
    {
      e.preventDefault();
    }
  });
});

// const form_exclusao = document.querySelector("#form-excluir-vacina");

// if (form_exclusao) {
//   form_exclusao.addEventListener("submit", async (e) => {
//     e.preventDefault();

//     const dadosForm = new FormData(form_exclusao);
//     const id_vacina = dadosForm.get("id_vacina");

//     // Verificar se o ID da vacina foi enviado
//     if (!id_vacina) {
//       Swal.fire({
//         text: "ID da vacina não encontrado.",
//         icon: "error",
//         confirmButtonColor: "#3085d6",
//         confirmButtonText: "Fechar",
//       });
//       return;
//     }

//     Swal.fire({
//       title: "Excluindo...",
//       text: "Aguarde enquanto a vacina está sendo excluída.",
//       timerProgressBar: true,
//       didOpen: () => {
//         Swal.showLoading();
//       },
//     });

//     try {
//       // Enviando os dados como JSON
//       const response = await fetch("../backend/excluir-vacina.php", {
//         method: "POST",
//         headers: {
//           "Content-Type": "application/json", // Definindo o tipo de conteúdo como JSON
//         },
//         body: JSON.stringify({ id_vacina }), // Convertendo os dados para JSON
//       });

//       const resposta = await response.json();

//       if (resposta.status) {
//         Swal.fire({
//           text: resposta.msg,
//           icon: "success",
//           confirmButtonColor: "#3085d6",
//           confirmButtonText: "Fechar",
//         }).then(() => {
//           location.reload(); // Recarregar a página após exclusão bem-sucedida
//         });
//       } else {
//         Swal.fire({
//           text: resposta.msg,
//           icon: "error",
//           confirmButtonColor: "#3085d6",
//           confirmButtonText: "Fechar",
//         });
//       }
//     } catch (error) {
//       Swal.fire({
//         text: "Ocorreu um erro ao tentar excluir a vacina. Tente novamente mais tarde.",
//         icon: "error",
//         confirmButtonColor: "#3085d6",
//         confirmButtonText: "Fechar",
//       });
//       console.error("Erro ao excluir vacina:", error);
//     }
//   });
// }

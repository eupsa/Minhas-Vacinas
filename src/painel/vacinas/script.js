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
    alert('Em manutenção.'); {
      e.preventDefault();
    }
  });
});


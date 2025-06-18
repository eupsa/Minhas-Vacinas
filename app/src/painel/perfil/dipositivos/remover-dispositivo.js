document.addEventListener("DOMContentLoaded", () => {
  const excluirForms = document.querySelectorAll("#form-remover-dispositivo");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: "Tem certeza?",
        text: "Deseja remover este dispositivo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, remover!",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});

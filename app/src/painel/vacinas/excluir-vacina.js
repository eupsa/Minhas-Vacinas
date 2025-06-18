document.addEventListener("DOMContentLoaded", () => {
  const excluirForms = document.querySelectorAll("#form-excluir-vacina");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: "Tem certeza?",
        text: "Esta ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});

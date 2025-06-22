document.addEventListener("DOMContentLoaded", () => {
  // Seleciona todos os formulários com o ID form-remover-dispositivo
  const excluirForms = document.querySelectorAll(".remove-device-form");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault(); // Impede envio automático

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
          form.submit(); // Envia o formulário se confirmado
        }
      });
    });
  });
});

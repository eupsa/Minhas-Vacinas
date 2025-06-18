document.addEventListener("DOMContentLoaded", () => {
  const excluirForms = document.querySelectorAll(".form-excluir-vacina");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault(); // Impede o envio do formulário imediatamente

      // Exibe o SweetAlert2 para confirmar a ação
      Swal.fire({
        title: "Tem certeza?",
        text: "Esta ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true, // Exibe o botão de cancelar
        confirmButtonColor: "#d33", // Cor do botão de confirmação (vermelho)
        cancelButtonColor: "#3085d6", // Cor do botão de cancelamento (azul)
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        // Se o usuário confirmar, submete o formulário
        if (result.isConfirmed) {
          form.submit(); // Envia o formulário
        }
      });
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const excluirForms = document.querySelectorAll("#form-remover-dispositivo");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const confirmacao = confirm(
        "Tem certeza de que deseja remover esse dispositivo?"
      );

      if (confirmacao) {
        form.submit();
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const excluirForms = document.querySelectorAll("#form-excluir-vacina");

  excluirForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault(); 
      const confirmacao = confirm(
        "Tem certeza de que deseja excluir esta vacina? Esta ação não pode ser desfeita."
      );

      if (confirmacao) {
        form.submit(); 
      }
    });
  });
});

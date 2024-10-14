document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.querySelector("#togglePassword");
  const toggleConfPassword = document.querySelector("#ConftogglePassword");
  const password = document.querySelector("#senha");
  const confPassword = document.querySelector("#confSenha");

  // Função para alternar a visibilidade do campo de senha
  const toggleVisibility = (field, toggleBtn) => {
    const type =
      field.getAttribute("type") === "password" ? "text" : "password";
    field.setAttribute("type", type);
    toggleBtn.querySelector("i").classList.toggle("bi-eye");
    toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
  };

  // Event listeners para os botões de alternar visibilidade
  if (togglePassword) {
    togglePassword.addEventListener("click", () => {
      toggleVisibility(password, togglePassword);
    });
  }

  if (toggleConfPassword) {
    toggleConfPassword.addEventListener("click", () => {
      toggleVisibility(confPassword, toggleConfPassword);
    });
  }

  const formalog = document.querySelector("#formalog");

  if (formalog) {
    formalog.addEventListener("submit", async (e) => {
      // Bloquear o recarregamento da página
      e.preventDefault();

      // Receber os dados do formulário
      const dadosForm = new FormData(formalog);

      // Capturar os valores dos campos do formulário
      const email = dadosForm.get("email");
      const senha = dadosForm.get("senha");

      // Verificar se todos os campos estão preenchidos e se as senhas coincidem
      if (!email || !senha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }

      // Enviar os dados para o PHP
      const dados = await fetch("../methods/entrar.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await dados.json();

      if (resposta["status"]) {
        Swal.fire({
          text: resposta["msg"],
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          window.location.href = "../painel/index.html";
        });
        formalog.reset();
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    });
  }
});

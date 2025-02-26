document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#senha");

  // Função para alternar visibilidade da senha
  const toggleVisibility = (field, toggleBtn) => {
    const type =
      field.getAttribute("type") === "password" ? "text" : "password";
    field.setAttribute("type", type);
    toggleBtn.querySelector("i").classList.toggle("bi-eye");
    toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
  };

  // Evento de clique para alternar a visibilidade da senha
  if (togglePassword) {
    togglePassword.addEventListener("click", () => {
      toggleVisibility(password, togglePassword);
    });
  }

  const form_login = document.querySelector("#form_login");

  // Verifica se o formulário de login existe
  if (form_login) {
    form_login.addEventListener("submit", async (e) => {
      e.preventDefault();

      const dadosForm = new FormData(form_login);
      const email = dadosForm.get("email");
      const senha = dadosForm.get("senha");

      const loadingSpinner = document.getElementById("loadingSpinner");
      const submitButton = document.getElementById("submitBtn");

      // Validação dos campos
      if (!email || !senha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }

      // Desabilita o botão e exibe o carregamento
      submitButton.disabled = true;
      loadingSpinner.style.display = "inline-block";

      try {
        const resposta = await fetch("../backend/entrar.php", {
          method: "POST",
          body: dadosForm,
        });

        const dados = await resposta.json();

        // Reabilita o botão e oculta o carregamento
        submitButton.disabled = false;
        loadingSpinner.style.display = "none";

        // Trata o status da resposta
        if (dados.status === true) {
          Swal.fire({
            text: dados.msg,
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Fechar",
          }).then(() => {
            window.location.href = "../../painel/";
          });
        } else if (dados.status === "2FA") {
          window.location.href = "../dois-fatores/";
        } else {
          Swal.fire({
            text: dados.msg,
            icon: "error",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Fechar",
          });
        }
      } catch (error) {
        submitButton.disabled = false;
        loadingSpinner.style.display = "none";
        Swal.fire({
          text: "Erro ao fazer login. Tente novamente.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    });
  }
});

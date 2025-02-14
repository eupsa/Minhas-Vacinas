document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#senha");

  const toggleVisibility = (field, toggleBtn) => {
    const type =
      field.getAttribute("type") === "password" ? "text" : "password";
    field.setAttribute("type", type);
    toggleBtn.querySelector("i").classList.toggle("bi-eye");
    toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
  };

  if (togglePassword) {
    togglePassword.addEventListener("click", () => {
      toggleVisibility(password, togglePassword);
    });
  }

  const form_login = document.querySelector("#form_login");

  if (form_login) {
    form_login.addEventListener("submit", async (e) => {
      e.preventDefault();

      const dadosForm = new FormData(form_login);

      const email = dadosForm.get("email");
      const senha = dadosForm.get("senha");
      const termosAceitos = dadosForm.get("lembrarLogin");
      const loadingSpinner = document.getElementById("loadingSpinner");
      const submitButton = document.getElementById("submitBtn");

      if (!email || !senha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }

      submitButton.disabled = true;
      loadingSpinner.style.display = "inline-block";

      try {
        const resposta = await fetch("../backend/entrar.php", {
          method: "POST",
          body: dadosForm,
        });

        const dados = await resposta.json(); 

        submitButton.disabled = false;
        loadingSpinner.style.display = "none";

        if (dados.status) {
          Swal.fire({
            text: dados.msg,
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Fechar",
          }).then(() => {
            form_login.reset();
            window.location.href = "../../painel/";
          });
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

        console.error("Erro:", error);
      }
    });
    console.error("Erro:", error);
  }
});

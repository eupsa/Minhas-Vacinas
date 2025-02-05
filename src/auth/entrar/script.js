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
        iziToast.show({
          message: "Preencha todos os campos obrigatórios.",
          position: "topRight",
          color: "red",
          icon: "fas fa-exclamation-circle",
          theme: "dark",
          iconColor: "#fff",
          progressBarColor: "#fff",
          timeout: 5000,
          close: true,
          balloon: true,
          transitionIn: "bounceInUp",
          transitionOut: "bounceOutDown",
          titleColor: "#fff",
          messageColor: "#e1e1e1",
          backgroundColor: "#ff5f5f",
          displayMode: 2,
        });
        return;
      }

      submitButton.disabled = true;
      loadingSpinner.style.display = "inline-block";

      try {
        const dados = await fetch("../backend/entrar.php", {
          method: "POST",
          body: dadosForm,
        });

        const resposta = await dados.json();

        if (resposta["status"]) {
          submitButton.disabled = false;
          loadingSpinner.style.display = "none";
          form_login.reset();
          window.location.href = "../../painel/";
        } else {
          submitButton.disabled = false;
          loadingSpinner.style.display = "none";
          iziToast.destroy();
          iziToast.show({
            title: "Erro!",
            message: resposta["msg"],
            position: "topRight",
            color: "red",
            icon: "fas fa-times-circle",
            theme: "dark",
            iconColor: "#fff",
            progressBarColor: "#fff",
            titleColor: "#fff",
            messageColor: "#e1e1e1",
            backgroundColor: "#dc3545",
            timeout: 5000,
            close: true,
            balloon: true,
            transitionIn: "fadeInDown",
            transitionOut: "fadeOutUp",
            maxWidth: 450,
          });
        }
      } catch (error) {
        submitButton.disabled = false;
        loadingSpinner.style.display = "none";
        Swal.fire({
          text: "Ocorreu um erro ao tentar fazer login. Tente novamente mais tarde.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.querySelector("#togglePassword");
  const toggleConfPassword = document.querySelector("#ConftogglePassword");
  const password = document.querySelector("#senha");
  const confPassword = document.querySelector("#confSenha");

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

  if (toggleConfPassword) {
    toggleConfPassword.addEventListener("click", () => {
      toggleVisibility(confPassword, toggleConfPassword);
    });
  }

  const formalog = document.querySelector("#formalog");

  if (formalog) {
    formalog.addEventListener("submit", async (e) => {
      e.preventDefault();

      const dadosForm = new FormData(formalog);
      const email = dadosForm.get("email");
      const senha = dadosForm.get("senha");

      if (!email || !senha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }

      const dados = await fetch("../backend/login.php", {
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
          window.location.href = "../painel/index.php";
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

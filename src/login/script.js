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

  const formcad = document.querySelector("#requestForm");

  if (requestForm) {
    requestForm.addEventListener("submit", async (e) => {
      e.preventDefault();
  
      const dadosForm = new FormData(requestForm);
  
      const nome = dadosForm.get("nome");
      const email = dadosForm.get("email");
      const estado = dadosForm.get("estado");
      const senha = dadosForm.get("senha");
      const confSenha = dadosForm.get("confSenha");
  
      if (!nome || !email || !estado || !senha || !confSenha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }
  
      if (senha !== confSenha) {
        Swal.fire({
          text: "As senhas precisam ser iguais.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }
  
      Swal.fire({
        title: "Processando...",
        html: "Aguarde enquanto estamos cadastrando...",
        timer: 5000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
        },
      });
  
      const dados = await fetch("../backend/register.php", {
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
          window.location.href = "../login/index.php";
        });
        formcad.reset();
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
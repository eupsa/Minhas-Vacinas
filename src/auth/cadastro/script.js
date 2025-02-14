const togglePassword = document.querySelector("#togglePassword");
const toggleConfPassword = document.querySelector("#ConftogglePassword");
const password = document.querySelector("#senha");
const confPassword = document.querySelector("#confSenha");

const toggleVisibility = (field, toggleBtn) => {
  const type = field.getAttribute("type") === "password" ? "text" : "password";
  field.setAttribute("type", type);
  toggleBtn.querySelector("i").classList.toggle("bi-eye");
  toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
};

togglePassword.addEventListener("click", () => {
  toggleVisibility(password, togglePassword);
});

toggleConfPassword.addEventListener("click", () => {
  toggleVisibility(confPassword, toggleConfPassword);
});

const formcad = document.querySelector("#formcad");

if (formcad) {
  formcad.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(formcad);

    const nome = dadosForm.get("nome");
    const email = dadosForm.get("email");
    const estado = dadosForm.get("estado");
    const senha = dadosForm.get("senha");
    const confSenha = dadosForm.get("confSenha");

    if (!nome || !email || !estado || !senha || !confSenha) {
      Swal.fire({
        text: "Preencha todos os campos obrigatórios.",
        icon: "warning",
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
      text: "Aguarde enquanto processamos sua solicitação.",
      icon: "info",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const dados = await fetch("../backend/cadastro.php", {
        method: "POST",
        body: dadosForm,
      });

      if (!dados.ok) throw new Error("Erro ao processar a solicitação");

      const resposta = await dados.json();

      if (resposta["status"]) {
        Swal.fire({
          text: "Cadastro realizado com sucesso!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "OK",
        }).then(() => {
          window.location.href = "../confirmar-cadastro/";
          formcad.reset();
        });
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    } catch (error) {
      Swal.fire({
        text: "Erro ao cadastrar. Tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

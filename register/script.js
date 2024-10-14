// Selecionar os elementos dos campos de senha e o botão para alternar a visibilidade
const togglePassword = document.querySelector("#togglePassword");
const toggleConfPassword = document.querySelector("#ConftogglePassword");
const password = document.querySelector("#senha");
const confPassword = document.querySelector("#confSenha");

// Função para alternar a visibilidade do campo de senha
const toggleVisibility = (field, toggleBtn) => {
  const type = field.getAttribute("type") === "password" ? "text" : "password";
  field.setAttribute("type", type);
  toggleBtn.querySelector("i").classList.toggle("bi-eye");
  toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
};

// Event listeners para os botões de alternar visibilidade
togglePassword.addEventListener("click", () => {
  toggleVisibility(password, togglePassword);
});

toggleConfPassword.addEventListener("click", () => {
  toggleVisibility(confPassword, toggleConfPassword);
});

// Validação e envio do formulário
const formcad = document.querySelector("#formcad");

if (formcad) {
  formcad.addEventListener("submit", async (e) => {
    // Bloquear o recarregamento da página
    e.preventDefault();

    // Receber os dados do formulário
    const dadosForm = new FormData(formcad);

    // Capturar os valores dos campos do formulário
    const nome = dadosForm.get("nome");
    const email = dadosForm.get("email");
    const estado = dadosForm.get("estado");
    const senha = dadosForm.get("senha");
    const confSenha = dadosForm.get("confSenha");

    // Verificar se todos os campos estão preenchidos e se as senhas coincidem
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

    // Exibir a animação de carregamento
    Swal.fire({
      title: "Processando...",
      html: "Aguarde enquanto estamos cadastrando...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Enviar os dados para o PHP
    const dados = await fetch("../methods/cadastro.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    // Verificar se o cadastro foi bem-sucedido
    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        window.location.href = "../painel/index.html";
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

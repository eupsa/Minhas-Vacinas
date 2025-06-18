const form_login = document.querySelector("#form_login");

// Verifica se o formulário de login existe
if (form_login) {
  form_login.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_login);
    const email = dadosForm.get("email");
    const senha = dadosForm.get("senha");

    const loadingSpinner = document.getElementById("loading-spinner"); // Corrigido para usar o id correto
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
          window.location.href = "../../dashboard/"; // Redirecionamento para o painel após login
        });
      } else if (dados.status === "2FA") {
        window.location.href = "../dois-fatores/"; // Redirecionamento para a página de dois fatores
      } else {
        Swal.fire({
          text: dados.msg,
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    } catch (error) {
      // Caso ocorra um erro na requisição
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

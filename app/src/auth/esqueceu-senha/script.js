const form_recovery = document.querySelector("#form_recovery");

if (form_recovery) {
  form_recovery.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_recovery);
    const email = dadosForm.get("email");

    // Validação de campo vazio
    if (!email) {
      Swal.fire({
        text: "Por favor, insira seu e-mail para recuperar sua senha.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok",
      });
      return;
    }

    // Exibe mensagem enquanto processa a solicitação
    Swal.fire({
      title: "Estamos processando sua solicitação...",
      text: "Por favor, aguarde um momento. Isso pode levar alguns segundos.",
      timer: 7000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Envia a requisição para o backend
    const dados = await fetch("../backend/esqueceu_senha.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    // Resposta de sucesso
    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Entendido",
      }).then(() => {
        window.location.href = "../entrar/"; // Redireciona para a página de login
      });
      form_recovery.reset(); // Limpa o formulário após envio
    } else {
      // Resposta de erro
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Tentar novamente",
      });
    }
  });
}

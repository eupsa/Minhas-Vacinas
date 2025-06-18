const form_reset = document.querySelector("#form_reset");

if (form_reset) {
  form_reset.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_reset);

    const senha = dadosForm.get("senha");
    const confSenha = dadosForm.get("confSenha");
    const token = dadosForm.get("token");

    // Validação de campos vazios
    if (!senha || !confSenha) {
      Swal.fire({
        text: "Por favor, preencha todos os campos para continuar.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok",
      });
      return;
    }

    // Verifica se as senhas são iguais
    if (senha !== confSenha) {
      Swal.fire({
        text: "As senhas não coincidem. Por favor, tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Entendido",
      });
      return;
    }

    // Exibe uma mensagem de processamento
    Swal.fire({
      title: "Estamos processando sua solicitação...",
      text: "Isso pode levar alguns segundos, por favor, aguarde.",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Envia os dados para o backend
    const dados = await fetch("../backend/nova-senha.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    // Se o status for positivo, exibe mensagem de sucesso
    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok",
      }).then(() => {
        window.location.href = "../entrar/"; // Redireciona para a página de login
      });
      form_reset.reset(); // Limpa o formulário
    } else {
      // Caso haja erro, exibe mensagem de erro
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Tentar novamente",
      }).then(() => {
        window.location.href = "../esqueceu-senha/"; // Redireciona para a página de recuperação de senha
      });
      form_reset.reset(); // Limpa o formulário
    }
  });
}

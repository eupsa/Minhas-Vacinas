const form_2fa = document.querySelector("#form-2fa");

if (form_2fa) {
  form_2fa.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_2fa);

    const codigo = dadosForm.get("codigo");
    const key = dadosForm.get("key");

    // Validação: Verificar se o código ou a chave estão vazios
    if (!codigo || !key) {
      Swal.fire({
        title: "Erro",
        text: "Por favor, insira o código e a chave para continuar.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    // Exibir uma mensagem de carregamento enquanto processa a solicitação
    Swal.fire({
      title: "Aguarde, estamos processando...",
      text: "Isso pode levar alguns segundos.",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Enviar os dados para o servidor
    const dados = await fetch("../../backend/ativar-2FA.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    // Se a ativação for bem-sucedida
    if (resposta["status"]) {
      Swal.fire({
        title: "Sucesso!",
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        window.location.href = "../"; // Redireciona para a página inicial
      });
      form_2fa.reset(); // Limpa os campos do formulário
    } else {
      // Caso ocorra algum erro
      Swal.fire({
        title: "Ops, algo deu errado!",
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

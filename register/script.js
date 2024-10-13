const formcad = document.querySelector("#formcad");

if (formcad) {
  formcad.addEventListener("submit", async (e) => {
    // Bloquear o recarregamento da página com JavaScript
    e.preventDefault();

    // Receber os dados do formulário com JavaScript
    const dadosForm = new FormData(formcad);

    // Verificar se os campos estão vazios
    const nome = dadosForm.get("nome");
    const email = dadosForm.get("email");
    const estado = dadosForm.get("estado");
    const senha = dadosForm.get("senha");
    const confSenha = dadosForm.get("confSenha");

    if (!nome || !email || !estado || !senha || !confSenha) {
      // Exibir alerta se algum campo estiver vazio
      Swal.fire({
        icon: "error",
        title: "Erro!",
        text: "Preencha todos os campos.",
        confirmButtonText: "Fechar",
      });
      return; // Impede o envio do formulário
    }

    // Exibir a animação de carregamento antes de enviar
    Swal.fire({
      title: "Processando...",
      html: "Aguarde enquanto estamos cadastrando...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading(); // Inicia o loading
      },
      willClose: () => {
        // Aqui não precisamos do setInterval, pois o SweetAlert já gerencia isso
      },
    });

    // Enviar os dados do JavaScript para o PHP
    const dados = await fetch("../methods/cadastro.php", {
      method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
      body: dadosForm, // Enviar os dados do JavaScript para o PHP
    });

    // Ler o retorno do PHP com JavaScript
    const resposta = await dados.json();

    // Verificar com JavaScript se cadastrou no banco de dados
    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        window.location.href = "../painel/index.html"; // Redireciona após o alerta
      });

      // Limpar o formulário com JavaScript
      formcad.reset();
    } else {
      // Usar o SweetAlert para apresentar a mensagem de erro após não cadastrar no banco de dados com PHP
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

const form_perfil = document.querySelector("#form-perfil");

form_perfil.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_perfil);

  const nome = dadosForm.get("nome");
  const cpf = dadosForm.get("cpf");
  const data_nascimento = dadosForm.get("data_nascimento");
  const telefone = dadosForm.get("telefone");
  const estado = dadosForm.get("estado");
  const genero = dadosForm.get("genero");
  const cidade = dadosForm.get("cidade");
  const foto_perfil = dadosForm.get("foto_perfil");

  // Verificar se ao menos um campo foi alterado
  if (
    !nome &&
    !cpf &&
    !data_nascimento &&
    !telefone &&
    !estado &&
    !genero &&
    !foto_perfil &&
    !cidade
  ) {
    Swal.fire({
      title: "Atenção!",
      text: "Parece que você não fez nenhuma alteração. Por favor, modifique algum dado antes de tentar salvar.",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
      customClass: {
        popup: "my-custom-swal",
      },
    });
    return;
  }

  // Exibição do "carregando" enquanto a solicitação está sendo processada
  Swal.fire({
    title: "Atualizando...",
    html: "Estamos atualizando suas informações. Por favor, aguarde um momento.",
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const dados = await fetch("../backend/atualizar-dados.php", {
      method: "POST",
      body: dadosForm,
    });

    if (!dados.ok) throw new Error("Erro ao processar a solicitação");

    const resposta = await dados.json();

    // Exibição de resposta com base no status da operação
    if (resposta["status"]) {
      Swal.fire({
        title: "Sucesso!",
        text: resposta["msg"] || "Seus dados foram atualizados com sucesso.",
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        location.reload(); // Recarrega a página após o sucesso
      });
    } else {
      Swal.fire({
        title: "Erro!",
        text:
          resposta["msg"] ||
          "Ocorreu um problema ao atualizar seus dados. Por favor, tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  } catch (error) {
    // Caso haja algum erro inesperado
    Swal.fire({
      title: "Erro de Conexão",
      text: "Ocorreu um erro inesperado ao tentar atualizar seus dados. Tente novamente mais tarde ou entre em contato com o suporte.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
  }
});

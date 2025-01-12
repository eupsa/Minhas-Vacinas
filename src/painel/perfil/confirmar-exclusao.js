const form_conf_exclusao = document.querySelector("#form-confirmar-exclusao");

form_conf_exclusao.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_conf_exclusao);
  const codigo = dadosForm.get("codigo");

  if (!codigo) {
    Swal.fire({
      text: "Insira o código enviado por e-mail",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
      customClass: {
        popup: "my-custom-swal",
      },
    });
    return;
  }

  const confirmacao = await Swal.fire({
    title: "Você tem certeza?",
    text: "Esta ação não pode ser desfeita. A exclusão da conta é permanente.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, excluir!",
    cancelButtonText: "Cancelar",
  });

  if (!confirmacao.isConfirmed) {
    Swal.fire({
      text: "Ação de exclusão cancelada.",
      icon: "info",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
    return;
  }

  // Exibe o Swal de "Processando..."
  Swal.fire({
    title: "Processando...",
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const dados = await fetch("../backend/confirmar-exclusao.php", {
      method: "POST",
      body: dadosForm,
    });

    if (!dados.ok) throw new Error("Erro ao processar a solicitação");

    const resposta = await dados.json();

    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        location.reload();
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
      text: "Ocorreu um erro ao tentar processar sua solicitação. Tente novamente mais tarde.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
  }
});

const form_excluir_conta = document.querySelector("#form-excluir-conta");

form_excluir_conta.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_excluir_conta);

  const email = dadosForm.get("email");

  if (!email) {
    Swal.fire({
      text: "Insira seu e-mail.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
      customClass: {
        popup: "my-custom-swal",
      },
    });
    return;
  }

  Swal.fire({
    title: "Processando...",
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const dados = await fetch("../backend/excluir-conta.php", {
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
        $("#confirmar-exclusao").modal("show");
        $("#excluir-conta").modal("hide");
      });
    } else {
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        location.reload();
      });
    }
  } catch (error) {
    Swal.fire({
      text: "Ocorreu um erro ao tentar enviar o e-mail.".$error,
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    }).then(() => {
      location.reload();
    });
  }
});

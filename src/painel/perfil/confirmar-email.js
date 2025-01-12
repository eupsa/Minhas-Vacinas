const form_conf_email = document.querySelector(
  "#form-confirmar-codigo-alterar-email"
);

form_conf_email.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_conf_email);

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

  Swal.fire({
    title: "Processando...",
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const dados = await fetch("../backend/confirmar-email.php", {
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

const form_alterar_email = document.querySelector("#form-alterar-email");

form_alterar_email.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_alterar_email);

  const email = dadosForm.get("email");

  if (!email) {
    Swal.fire({
      text: "Insira o novo e-mail.",
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
    const dados = await fetch("../backend/alterar-email.php", {
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
        $("#confirmar-codigo").modal("show");
        $("#alterar-email").modal("hide");
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
      text: "Ocorreu um erro ao tentar fazer login. Tente novamente mais tarde."
        .$error,
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
  }
});

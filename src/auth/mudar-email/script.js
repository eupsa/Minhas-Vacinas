const form_alterar_email = document.querySelector("#form-alterar-email");

if (form_alterar_email) {
  form_alterar_email.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_alterar_email);

    const id = dadosForm.get("id");
    const novo_email = dadosForm.get("novo-email");

    if (!id || !novo_email) {
      Swal.fire({
        text: "ID ou e-mail não foi preenchido. Solicite um novo e-mail.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    try {
      const dados = await fetch("../backend/novo-email.php", {
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
          window.location.href = "../../painel/perfil/";
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
        text: "Erro ao processar o cadastro. Tente novamente mais tarde.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

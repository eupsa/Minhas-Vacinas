const form_login = document.querySelector("#login-adm");

if (form_login) {
  form_login.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_login);

    const email = dadosForm.get("email");
    const senha = dadosForm.get("senha");

    if (!email || !senha) {
      Swal.fire({
        text: "Preencha todos os campos.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
        background: "#ccc",
      });
      return;
    }

    try {
      const resposta = await fetch("backend/entrar-admin.php", {
        method: "POST",
        body: dadosForm,
      });

      const dados = await resposta.json();

      if (dados.status) {
        Swal.fire({
          text: dados.msg,
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          form_login.reset();
          window.location.href = "inicio/";
        });
      } else {
        Swal.fire({
          text: dados.msg,
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    } catch (error) {
      Swal.fire({
        text: "Erro ao fazer login. Tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });

      console.error("Erro:", error);
    }
  });
  console.error("Erro:", error);
}

document.addEventListener("DOMContentLoaded", () => {
  const formalog = document.querySelector("#formalog");

  if (formalog) {
    formalog.addEventListener("submit", async (e) => {
      e.preventDefault();

      const dadosForm = new FormData(formalog);
      const email = dadosForm.get("email");
      const senha = dadosForm.get("senha");

      if (!email || !senha) {
        Swal.fire({
          text: "Preencha todos os campos.",
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
        return;
      }

      const dados = await fetch("../methods/entrar.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await dados.json();

      if (resposta["status"]) {
        Swal.fire({
          text: resposta["msg"],
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          window.location.href = "../painel/index.php";
        });
        formalog.reset();
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    });
  }
});

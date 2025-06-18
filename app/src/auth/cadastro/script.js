const formcad = document.querySelector("#formcad");

if (formcad) {
  formcad.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(formcad);

    const nome = dadosForm.get("nome");
    const email = dadosForm.get("email");
    const estado = dadosForm.get("estado");
    const senha = dadosForm.get("senha");
    const confSenha = dadosForm.get("confSenha");

    if (!nome || !email || !estado || !senha || !confSenha) {
      Swal.fire({
        text: "Por favor, preencha todos os campos obrigatórios.",
        icon: "warning",
        confirmButtonText: "Ok, entendi",
      });
      return;
    }

    if (senha !== confSenha) {
      Swal.fire({
        text: "As senhas não coincidem. Verifique e tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok, vou corrigir",
      });
      return;
    }

    Swal.fire({
      title: "Estamos processando seu cadastro...",
      text: "Isso pode levar alguns segundos, por favor, aguarde.",
      icon: "info",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const dados = await fetch("../backend/cadastro.php", {
        method: "POST",
        body: dadosForm,
      });

      if (!dados.ok) throw new Error("Erro ao processar a solicitação");

      const resposta = await dados.json();

      if (resposta["status"]) {
        Swal.fire({
          text: "Sua conta foi criada com sucesso! Enviamos um e-mail com um código de verificação. Siga as instruções para completar seu cadastro.",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Tudo bem, vou verificar",
        }).then(() => {
          window.location.href = "../confirmar-cadastro/";
          formcad.reset();
        });
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Entendi, tentar novamente",
        });
      }
    } catch (error) {
      Swal.fire({
        text: "Houve um erro ao tentar criar sua conta. Por favor, tente novamente mais tarde.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

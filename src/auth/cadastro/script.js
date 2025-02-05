const togglePassword = document.querySelector("#togglePassword");
const toggleConfPassword = document.querySelector("#ConftogglePassword");
const password = document.querySelector("#senha");
const confPassword = document.querySelector("#confSenha");

const toggleVisibility = (field, toggleBtn) => {
  const type = field.getAttribute("type") === "password" ? "text" : "password";
  field.setAttribute("type", type);
  toggleBtn.querySelector("i").classList.toggle("bi-eye");
  toggleBtn.querySelector("i").classList.toggle("bi-eye-slash");
};

togglePassword.addEventListener("click", () => {
  toggleVisibility(password, togglePassword);
});

toggleConfPassword.addEventListener("click", () => {
  toggleVisibility(confPassword, toggleConfPassword);
});

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
      iziToast.show({
        message: "Preencha todos os campos obrigatórios.",
        position: "topRight",
        color: "red",
        icon: "fas fa-exclamation-circle",
        theme: "dark",
        iconColor: "#fff",
        progressBarColor: "#fff",
        timeout: 5000,
        close: true,
        balloon: true,
        transitionIn: "bounceInUp",
        transitionOut: "bounceOutDown",
        titleColor: "#fff",
        messageColor: "#e1e1e1",
        backgroundColor: "#ff5f5f",
        displayMode: 2,
      });
      return;
    }

    if (senha !== confSenha) {
      iziToast.show({
        message: "As senhas precisam ser iguais.",
        position: "topRight",
        color: "red",
        icon: "fas fa-exclamation-circle",
        theme: "dark",
        iconColor: "#fff",
        progressBarColor: "#fff",
        timeout: 5000,
        close: true,
        balloon: true,
        transitionIn: "bounceInUp",
        transitionOut: "bounceOutDown",
        titleColor: "#fff",
        messageColor: "#e1e1e1",
        backgroundColor: "#ff5f5f",
        displayMode: 2,
      });
      return;
    }

    iziToast.show({
      title: "Processando...",
      message: "Aguarde enquanto processamos sua solicitação.",
      position: "topRight",
      color: "warning",
      timeout: 7000,
      progressBar: true,
      icon: "fas fa-cogs",
    });

    try {
      const dados = await fetch("../backend/cadastro.php", {
        method: "POST",
        body: dadosForm,
      });

      if (!dados.ok) throw new Error("Erro ao processar a solicitação");

      const resposta = await dados.json();

      if (resposta["status"]) {
        iziToast.destroy();

        window.location.href = "../confirmar-cadastro/";
        formcad.reset();
      } else {
        iziToast.destroy();
        iziToast.show({
          title: "Erro!",
          message: resposta["msg"],
          position: "topRight",
          color: "red",
          icon: "fas fa-times-circle",
          theme: "dark",
          iconColor: "#fff",
          progressBarColor: "#fff",
          titleColor: "#fff",
          messageColor: "#e1e1e1",
          backgroundColor: "#dc3545",
          timeout: 5000,
          close: true,
          balloon: true,
          transitionIn: "fadeInDown",
          transitionOut: "fadeOutUp",
          maxWidth: 450,
        });
      }
    } catch (error) {
      console.log("Erro ao cadastrar");
    }
  });
}

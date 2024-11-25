const form_conf = document.querySelector("#form_conf");

if (form_conf) {
  form_conf.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_conf);

    const email = dadosForm.get("email");

    if (!email) {
      Swal.fire({
        text: "Preencha todos os campos! Verifique se todos os campos obrigatórios estão preenchidos.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      timer: 7000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../backend/conf_cad.php", {
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
        window.location.href = "../entrar/";
      });
      formcad.reset();
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

const form_2fa = document.querySelector("#form-2fa");

if (form_2fa) {
  form_2fa.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_2fa);

    const codigo = dadosForm.get("codigo");
    const key = dadosForm.get("key");

    if (!codigo || !key) {
      Swal.fire({
        text: "Key ou código não encontrado.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../../backend/ativar-2FA.php", {
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
        window.location.href = "../";
      });
      form_2fa.reset();
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

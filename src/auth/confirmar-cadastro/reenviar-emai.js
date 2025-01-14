const form_reenviar_email = document.querySelector("#form-reenviar-email");

form_reenviar_email.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_reenviar_email);

  const email = dadosForm.get("email");
  const loadingSpinner = document.getElementById("loadingSpinner");
  const submitButton = document.getElementById("submitBtn");

  if (!email) {
    Swal.fire({
      text: "O e-mail não foi inserido.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
    return;
  }

  Swal.fire({
    title: "Processando...",
    timer: 10000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  const dados = await fetch("../backend/reenviar-email.php", {
    method: "POST",
    body: dadosForm,
  });

  const resposta = await dados.json();

  if (resposta["status"]) {
    submitButton.disabled = false;
    loadingSpinner.style.display = "none";
    Swal.fire({
      text: resposta["msg"],
      icon: "success",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    }).then(() => {
      window.location.href = "../entrar/";
      formcad.reset();
    });
  } else {
    submitButton.disabled = false;
    loadingSpinner.style.display = "none";
    Swal.fire({
      text: resposta["msg"],
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
  }
});

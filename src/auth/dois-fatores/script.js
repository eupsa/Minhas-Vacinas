const form_2FA = document.querySelector("#form-2FA");

form_2FA.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_2FA);

  const codigo = dadosForm.get("codigo");
  const loadingSpinner = document.getElementById("loadingSpinner");
  const submitButton = document.getElementById("submitBtn");

  if (!codigo) {
    Swal.fire({
      text: "O código não foi inserido.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
    return;
  }

  submitButton.disabled = true;
  loadingSpinner.style.display = "inline-block";

  const dados = await fetch("../backend/confirmar-2FA.php", {
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
      window.location.href = "../painel/";
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

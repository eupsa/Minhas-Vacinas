document.querySelector("#form-2FA").addEventListener("submit", function (e) {
  e.preventDefault();

  const inputs = document.querySelectorAll(".codigo-input");
  const submitBtn = document.getElementById("submitBtn");
  const spinner = document.getElementById("loadingSpinner");

  const codigoConcatenado = Array.from(inputs)
    .map((input) => input.value.trim())
    .join("");

  if (codigoConcatenado.length !== 6) {
    Swal.fire({
      text: "Por favor, insira todos os 6 dígitos.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
    return;
  }

  submitBtn.disabled = true;
  if (spinner) spinner.style.display = "inline-block";

  const dadosForm = new FormData(this);
  dadosForm.append("codigo", codigoConcatenado);

  fetch("../backend/confirmar-2FA.php", {
    method: "POST",
    body: dadosForm,
  })
    .then((response) => response.json())
    .then((resposta) => {
      submitBtn.disabled = false;
      if (spinner) spinner.style.display = "none";

      Swal.fire({
        text: resposta.msg,
        icon: resposta.status ? "success" : "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        if (resposta.status) {
          window.location.href = "../../dashboard/";
        }
      });
    })
    .catch(() => {
      submitBtn.disabled = false;
      if (spinner) spinner.style.display = "none";
      Swal.fire({
        text: "Erro ao validar código. Tente novamente.",
        icon: "error",
        confirmButtonColor: "#3085d6",
      });
    });
});

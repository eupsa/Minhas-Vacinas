document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll("input[name='codigo[]']");

  inputs.forEach((input, index) => {
    input.addEventListener("input", function () {
      if (this.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", function (event) {
      if (event.key === "Backspace" && index > 0 && this.value === "") {
        inputs[index - 1].focus();
      }
    });

    input.addEventListener("paste", function (event) {
      event.preventDefault();
      const pasteData = (event.clipboardData || window.clipboardData).getData("text").trim();
      
      if (pasteData.length === inputs.length && /^\d+$/.test(pasteData)) {
        inputs.forEach((input, i) => {
          input.value = pasteData[i] || "";
        });
        inputs[inputs.length - 1].focus();
      }
    });
  });

  document.querySelector("#form-2FA").addEventListener("submit", function (e) {
    e.preventDefault();
    const codigoConcatenado = Array.from(inputs)
      .map((input) => input.value)
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

    const dadosForm = new FormData(this);
    dadosForm.append("codigo", codigoConcatenado);

    document.getElementById("submitBtn").disabled = true;
    document.getElementById("loadingSpinner").style.display = "inline-block";

    fetch("../backend/confirmar-2FA.php", {
      method: "POST",
      body: dadosForm,
    })
      .then((response) => response.json())
      .then((resposta) => {
        document.getElementById("submitBtn").disabled = false;
        document.getElementById("loadingSpinner").style.display = "none";

        Swal.fire({
          text: resposta.msg,
          icon: resposta.status ? "success" : "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          if (resposta.status) {
            window.location.href = "../../painel/";
          }
        });
      });
  });
});

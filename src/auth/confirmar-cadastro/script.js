document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(".codigo-input");
  const codigoHidden = document.getElementById("codigo-hidden");
  const form = document.getElementById("form-conf-cad");

  inputs.forEach((input, index) => {
    input.addEventListener("input", function () {
      if (this.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
      atualizarCodigoConcatenado();
    });
    input.addEventListener("keydown", function (event) {
      if (event.key === "Backspace" && index > 0 && this.value === "") {
        inputs[index - 1].focus();
      }
      atualizarCodigoConcatenado();
    });
    input.addEventListener("paste", function (event) {
      event.preventDefault();
      let pasteData = (event.clipboardData || window.clipboardData).getData(
        "text"
      );
      pasteData = pasteData.replace(/\D/g, ""); // Remove caracteres não numéricos

      if (pasteData.length === inputs.length) {
        inputs.forEach((input, i) => (input.value = pasteData[i] || ""));
        inputs[inputs.length - 1].focus();
        atualizarCodigoConcatenado();
      }
    });
  });

  function atualizarCodigoConcatenado() {
    let codigoConcatenado = "";
    inputs.forEach((input) => (codigoConcatenado += input.value));
    codigoHidden.value = codigoConcatenado;
  }

  form.addEventListener("submit", async function (event) {
    event.preventDefault();

    const codigo = codigoHidden.value;
    const loadingSpinner = document.getElementById("loadingSpinner");
    const submitButton = document.getElementById("submitBtn");

    if (codigo.length < 6) {
      Swal.fire({
        text: "O código deve ter 6 dígitos.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    submitButton.disabled = true;
    loadingSpinner.style.display = "inline-block";

    const dadosForm = new FormData(form);

    const dados = await fetch("../backend/confirmar-cadastro.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    submitButton.disabled = false;
    loadingSpinner.style.display = "none";

    if (resposta["status"]) {
      Swal.fire({
        text: resposta["msg"],
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        window.location.href = "../entrar/";
        form.reset();
      });
    } else {
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
});

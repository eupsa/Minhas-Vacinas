const form = document.getElementById("form-conf-cad");

form.addEventListener("submit", async function (event) {
  event.preventDefault();

  // Correct reference to the hidden input
  const codigoHidden = document.getElementById("codigo-hidden");
  const codigo = codigoHidden.value;

  const loadingSpinner = document.getElementById("loading-spinner"); // Fixed ID to match your HTML (loading-spinner)
  const submitButton = document.getElementById("submitBtn");

  if (codigo.length < 6) {
    Swal.fire({
      text: "O código de verificação deve ter 6 dígitos.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Entendi",
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
      confirmButtonText: "OK",
    }).then(() => {
      window.location.href = "../entrar/";
      form.reset();
    });
  } else {
    Swal.fire({
      text: resposta["msg"],
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "OK",
    });
  }
});

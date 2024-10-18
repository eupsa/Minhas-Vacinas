function startTimer(duration, display, button) {
  let timer = duration,
    minutes,
    seconds;
  let interval = setInterval(function () {
    minutes = parseInt(timer / 60, 10);
    seconds = parseInt(timer % 60, 10);

    seconds = seconds < 10 ? "0" + seconds : seconds;

    display.textContent =
      "Em " +
      minutes +
      ":" +
      seconds +
      " você poderá solicitar um novo código.";

    if (--timer < 0) {
      clearInterval(interval);
      button.disabled = false;
      display.textContent = "Solicite um novo código";
    }
  }, 1000);
}

function disableResendButton() {
  let resendBtn = document.getElementById("resendBtn");
  let display = document.getElementById("timer");

  resendBtn.disabled = true;
  startTimer(60, display, resendBtn);
}

document.getElementById("resendBtn").addEventListener("click", function () {
  disableResendButton();
  Swal.fire({
    text: "Um novo link de redefinição de senha foi enviado para o seu e-mail. Caso não o encontre, não se esqueça de verificar também a pasta de spam ou lixo eletrônico.",
    icon: "success",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Fechar",
  });
});

// Formulário de envio de redefinição de senha
const formResetPassword = document.querySelector("#formResetPassword");

if (formResetPassword) {
  formResetPassword.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(formResetPassword);
    const email = dadosForm.get("email");

    if (!email) {
      Swal.fire({
        text: "Todos os campos devem estar preenchidos!",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      html: "Enviando E-Mail...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../backend/requestPassword.php", {
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
        disableResendButton(); // Desabilitar o botão de reenvio
      });
      formResetPassword.reset();
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

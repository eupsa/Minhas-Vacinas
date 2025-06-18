const form_reenviar_email = document.querySelector("#form-reenviar-email");

form_reenviar_email.addEventListener("submit", async (e) => {
  e.preventDefault();

  const dadosForm = new FormData(form_reenviar_email);

  const email = dadosForm.get("email");

  if (!email) {
    Swal.fire({
      text: "Por favor, insira seu e-mail para reenviar a mensagem.",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Ok, entendi",
    });
    return;
  }

  // Manually hide the modal using Tailwind
  const emailModal = document.getElementById("resend-modal");
  emailModal.classList.add("hidden");

  Swal.fire({
    title: "Estamos processando...",
    text: "Aguarde um momento, estamos reenviando o e-mail.",
    timer: 10000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const dados = await fetch("../backend/reenviar-email.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    if (resposta["status"]) {
      Swal.fire({
        text: "E-mail reenviado com sucesso! Verifique sua caixa de entrada.",
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok, vou verificar",
      }).then(() => {
        form_reenviar_email.reset();
      });
    } else {
      Swal.fire({
        text: resposta["msg"],
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Entendi, tentar novamente",
      });
    }
  } catch (error) {
    Swal.fire({
      text: "Ocorreu um erro ao reenviar o e-mail. Tente novamente mais tarde.",
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Fechar",
    });
  }
});

// Show modal on a specific action (e.g., clicking a button)
const openModalButton = document.querySelector("#open-modal-btn"); // Adjust this if needed
openModalButton.addEventListener("click", () => {
  const emailModal = document.getElementById("resend-modal");
  emailModal.classList.remove("hidden");
});

// Close modal when "cancel-resend" is clicked
const cancelButton = document.querySelector("#cancel-resend");
cancelButton.addEventListener("click", () => {
  const emailModal = document.getElementById("resend-modal");
  emailModal.classList.add("hidden");
});

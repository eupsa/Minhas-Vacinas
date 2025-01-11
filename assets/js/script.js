const scrollToTopBtn = document.getElementById("scrollToTopBtn");

window.onscroll = function () {
  if (
    document.body.scrollTop > 100 ||
    document.documentElement.scrollTop > 100
  ) {
    scrollToTopBtn.classList.add("show");
  } else {
    scrollToTopBtn.classList.remove("show");
  }
};

scrollToTopBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Verificar se a sessão VPN foi detectada

  if (vpnDetected) {
    // Exibe a mensagem de alerta
    Swal.fire({
      title: "Acesso Bloqueado",
      text: "Detectamos que você está utilizando uma VPN. Para continuar acessando o site, por favor, desative a VPN.",
      icon: "error",
      confirmButtonText: "Entendido",
      confirmButtonColor: "#3085d6",
      customClass: {
        popup: "my-custom-swal",
      },
    });

    // Bloqueia a navegação
    window.location.href = "https://www.exemplo.com/bloqueado"; // Redireciona para uma página de bloqueio, se necessário
  }
});

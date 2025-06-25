const formNovoDispositivo = document.querySelector("#formNovoDispositivo");

if (formNovoDispositivo) {
  formNovoDispositivo.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(formNovoDispositivo);

    Swal.fire({
      title: "Estamos processando sua solicitação...",
      text: "Isso pode levar alguns segundos, por favor, aguarde.",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const response = await fetch("../backend/novo-dispositivo.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await response.json();

      console.log("Resposta JSON:", resposta);

      if (resposta.status) {
        Swal.fire({
          text: resposta.msg,
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Ok",
        }).then(() => {
          window.location.href = "../entrar/";
        });
      } else {
        Swal.fire({
          text: resposta.msg,
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Tentar novamente",
        }).then(() => {
          location.reload();
        });
      }
    } catch (error) {
      console.error("Erro no fetch ou JSON:", error);
      Swal.fire({
        text: "Erro inesperado ao processar resposta do servidor.",
        icon: "error",
      });
    }

    formNovoDispositivo.reset();
  });
}

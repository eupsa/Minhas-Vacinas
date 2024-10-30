const form_suporte = document.querySelector("#form_suporte");

if (form_suporte) {
  form_suporte.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_suporte);

    const nome = dadosForm.get("suporte_nome");
    const email = dadosForm.get("suporte_email");
    const data = dadosForm.get("data");
    const mensagem = dadosForm.get("mensagem");

    if (!nome || !email || !data || !mensagem) {
      Swal.fire({
        text: "Preencha todos os campos.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    Swal.fire({
      title: "Processando...",
      timer: 5000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../backend/support.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();

    if (resposta.status) {
      Swal.fire({
        text: resposta.msg,
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      }).then(() => {
        window.location.href = "/index.html"; 
      });
      form_suporte.reset(); 
    } else {
      Swal.fire({
        text: resposta.msg,
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

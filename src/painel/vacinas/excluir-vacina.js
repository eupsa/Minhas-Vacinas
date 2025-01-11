const form_excluir_vacina = document.querySelector("#form-excluir-vacina");

if (form_excluir_vacina) {
  form_excluir_vacina.addEventListener("submit", async (e) => {
    e.preventDefault();
    console.log("Formulário enviado");

    const dadosForm = new FormData(form_excluir_vacina);
    const id_vacina = dadosForm.get("id_vac");

    if (!id_vacina) {
      console.log("ID da vacina não encontrado");
      Swal.fire({
        text: "Não foi possível encontrar o campo ID_VACINA.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      return;
    }

    let loadingSwal = Swal.fire({
      title: "Processando...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const dados = await fetch("../backend/excluir-vacina.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await dados.json();

      Swal.close();

      if (resposta["status"]) {
        Swal.fire({
          text: resposta["msg"],
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          text: resposta["msg"],
          icon: "error",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Fechar",
        });
      }
    } catch (error) {
      Swal.close();

      Swal.fire({
        text: "Ocorreu um erro ao tentar excluir a vacina. Tente novamente mais tarde.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

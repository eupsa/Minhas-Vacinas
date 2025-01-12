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

    try {
      const dados = await fetch("../backend/excluir-vacina.php", {
        method: "POST",
        body: dadosForm,
      });

      const resposta = await dados.json();

      Swal.close();

      if (resposta["status"]) {
        location.reload();
      } else {
        location.reload();
      }
    } catch (error) {
      Swal.close();
    }
  });
}

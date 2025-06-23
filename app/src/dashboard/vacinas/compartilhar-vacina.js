document
  .getElementById("compartilharForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // SweetAlert de carregando
    Swal.fire({
      title: "Gerando link...",
      text: "Aguarde enquanto o link é criado.",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
      });

      if (!response.ok) throw new Error("Erro na requisição");

      const data = await response.json();

      if (!data.link || !data.data_expiracao || !data.data_compartilhamento) {
        throw new Error("Resposta incompleta do servidor.");
      }

      closeShareModal();

      // Preenche o modal com os dados do PHP
      document.getElementById("shareLink").value = data.link;
      document.getElementById("expirationInfo").textContent =
        data.data_expiracao === "never" ? "Nunca expira" : data.data_expiracao;
      document.getElementById("createdInfo").textContent =
        data.data_compartilhamento;

      // Fecha SweetAlert e abre modal de cópia
      Swal.close();
      document.getElementById("copyModal").classList.remove("hidden");
      document.body.classList.add("overflow-hidden");
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: error.message || "Erro ao gerar link de compartilhamento.",
      });
    }
  });

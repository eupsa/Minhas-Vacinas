async function gerarPdf(button) {
  const idVacina = button.getAttribute("data-id");
  const vacinaElement = button.closest(".card");

  // Aqui você pega os dados necessários para o PDF
  const nomeVacina = vacinaElement.querySelector(".card-title").innerText;
  const dose = vacinaElement.querySelector(".card-text i.fa-syringe")
    ? vacinaElement.querySelector(".card-text i.fa-syringe").parentElement
        .innerText
    : "";
  const dataAplicacao = vacinaElement.querySelector(
    ".card-text i.fa-calendar-day"
  )
    ? vacinaElement.querySelector(".card-text i.fa-calendar-day").parentElement
        .innerText
    : "";
  const localAplicacao = vacinaElement.querySelector(
    ".card-text i.fa-map-marker-alt"
  )
    ? vacinaElement.querySelector(".card-text i.fa-map-marker-alt")
        .parentElement.innerText
    : "";
  const lote = vacinaElement.querySelector(".card-text i.fa-cogs")
    ? vacinaElement
        .querySelector(".card-text i.fa-cogs")
        .parentElement.innerText.trim() || "Não informado"
    : "Não informado";
  const observacoes = vacinaElement.querySelector(".card-text i.fa-sticky-note")
    ? vacinaElement
        .querySelector(".card-text i.fa-sticky-note")
        .parentElement.innerText.trim()
        .replace(/^Observações\s*:/, "") || "Não informado"
    : "Não informado";

  const content = `<div style="width: 100%; max-width: 800px; margin: 30px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);">
    <!-- Cabeçalho -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="../../../assets/img/logo-head.png" alt="Logo Minhas Vacinas" style="width: 100px; margin-bottom: 10px;">
        <h1 style="font-size: 28px; color: #1a3a4a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 600;">Minhas Vacinas</h1>
        <p style="font-size: 16px; color: #777777; font-family: 'Roboto', sans-serif;">Sistema para gerenciamento do histórico de vacinação</p>
    </div>

    <!-- Detalhes da Vacina -->
    <div style="background-color: #f4f7fb; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <h2 style="font-size: 22px; color: #2d3e50; margin-bottom: 15px; font-family: 'Roboto', sans-serif; font-weight: 500;">${nomeVacina}</h2>

        <div style="font-size: 18px; color: #5a5a5a; line-height: 1.6; margin-bottom: 15px;">
            <p><strong>💉 Dose:</strong> ${dose}</p>
            <p><strong>📅 Data de Aplicação:</strong> ${dataAplicacao}</p>
            <p><strong>📍 Local de Aplicação:</strong> ${localAplicacao}</p>
            <p><strong>🔬 Lote:</strong> ${lote.replace(/^Lote\s*:/, "")}</p>
            <p><strong>📝 Observações:</strong> ${observacoes.replace(
              /^Observações\s*:/,
              ""
            )}</p>
        </div>
    </div>

    <!-- Rodapé -->
    <div style="text-align: center; font-size: 14px; color: #999999; font-family: 'Roboto', sans-serif;">
        <p style="margin: 0;">Exportado por <a href="https://www.minhasvacinas.online" target="_blank" style="color: #007bff; text-decoration: none;">Minhas Vacinas</a></p>
        <p style="margin-top: 10px;">
            <a href="https://bit.ly/minhasvacinas" target="_blank" style="color: #0077b3; text-decoration: none; font-weight: 500;">Visite nosso site</a>
        </p>
    </div>
</div>

`;

  const opt = {
    margin: 1,
    filename: "minhasvacinas_" + nomeVacina + ".pdf",
    image: {
      type: "jpeg",
      quality: 0.98,
    },
    html2canvas: {
      scale: 2,
    },
    jsPDF: {
      unit: "mm",
      format: "a4",
      orientation: "portrait",
    },
  };

  const newWindow = window.open("", "_blank");

  html2pdf()
    .from(content)
    .set(opt)
    .toPdf()
    .get("pdf")
    .then(function (pdf) {
      pdf.save("minhasvacinas_" + nomeVacina + ".pdf");
      newWindow.close();
    });
}

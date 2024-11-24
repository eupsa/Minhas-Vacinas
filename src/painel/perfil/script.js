document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

document.getElementById("cpf").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, "");
  if (value.length > 11) value = value.slice(0, 11);
  e.target.value = value
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
});

function formatPhoneNumber(input) {
  let phone = input.value.replace(/\D/g, "");
  if (phone.length > 10) {
    phone = phone.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
  } else if (phone.length > 6) {
    phone = phone.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
  } else if (phone.length > 2) {
    phone = phone.replace(/^(\d{2})(\d{0,4})/, "($1) $2");
  } else {
    phone = phone.replace(/^(\d*)/, "($1");
  }

  input.value = phone;
}

document.getElementById("telefone").addEventListener("input", function () {
  formatPhoneNumber(this);
});

const form_perfil = document.querySelector("#form-perfil");

if (form_perfil) {
  form_perfil.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_perfil);

    const nome = dadosForm.get("nome");
    const cpf = dadosForm.get("cpf");
    const data_nascimento = dadosForm.get("data_nascimento");
    const telefone = dadosForm.get("telefone");
    const estado = dadosForm.get("estado");
    const genero = dadosForm.get("genero");
    const cidade = dadosForm.get("cidade");

    if (!nome || !cpf || !data_nascimento || !telefone || !estado || genero ||cidade) {
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
      html: "Aguarde enquanto estamos cadastrando...",
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const dados = await fetch("../backend/cadastro.php", {
        method: "POST",
        body: dadosForm,
      });

      if (!dados.ok) throw new Error("Erro ao processar a solicitação");

      const resposta = await dados.json();

      Swal.fire({
        text: resposta["msg"],
        icon: resposta["status"] ? "success" : "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
      if (resposta["status"]) formcad.reset();
    } catch (error) {
      Swal.fire({
        text: "Erro ao processar o cadastro. Tente novamente mais tarde.",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Fechar",
      });
    }
  });
}

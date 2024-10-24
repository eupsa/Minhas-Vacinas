document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const profileForm = document.getElementById("profileForm");
  const updateButton = profileForm.querySelector('button[type="submit"]');

  updateButton.disabled = true;

  function checkForChanges() {
    const originalValues = {
      nome: "<?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : ''; ?>",
      idade:
        "<?php echo isset($_SESSION['user_idade']) ? $_SESSION['user_idade'] : ''; ?>",
      telefone:
        "<?php echo isset($_SESSION['user_telefone']) ? $_SESSION['user_telefone'] : ''; ?>",
      cpf: "<?php echo isset($_SESSION['user_cpf']) ? $_SESSION['user_cpf'] : ''; ?>",
      estado:
        "<?php echo isset($_SESSION['user_estado']) ? $_SESSION['user_estado'] : ''; ?>",
      genero:
        "<?php echo isset($_SESSION['user_genero']) ? $_SESSION['user_genero'] : ''; ?>",
      cidade:
        "<?php echo isset($_SESSION['user_cidade']) ? $_SESSION['user_cidade'] : ''; ?>",
    };

    let formChanged = false;

    profileForm.querySelectorAll("input").forEach(function (input) {
      if (input.value !== originalValues[input.name]) {
        formChanged = true;
      }
    });

    updateButton.disabled = !formChanged;
  }

  profileForm.addEventListener("input", checkForChanges);
});

document.getElementById("cpf").addEventListener("input", function (e) {
  let cpf = e.target.value.replace(/\D/g, "");
  cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
  cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
  cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
  e.target.value = cpf;
});

if (form_perfil) {
  form_perfil.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_perfil);

    const nome = dadosForm.get("nome");
    const data_nascimento = dadosForm.get("data_nascimento");
    const telefone = dadosForm.get("telefone");
    const estado = dadosForm.get("estado");
    const genero = dadosForm.get("genero");
    const cidade = dadosForm.get("cidade");

    Swal.fire({
      title: "Processando...",
      timer: 7000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    const dados = await fetch("../../../backend/update_register.php", {
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
        location.reload();
      });
      form_perfil.reset();
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

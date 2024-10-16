document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  // Alternar a visibilidade da sidebar
  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });

  // Função para alternar o modo escuro
  function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
  }

  // Verificar o estado do modo escuro na inicialização
  const darkModeSwitch = document.getElementById("darkModeSwitch");
  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
    darkModeSwitch.checked = true;
  }

  // Alterar o modo escuro quando o interruptor é mudado
  darkModeSwitch.addEventListener("change", () => {
    if (darkModeSwitch.checked) {
      document.body.classList.add("dark-mode");
      localStorage.setItem("darkMode", "enabled");
    } else {
      document.body.classList.remove("dark-mode");
      localStorage.removeItem("darkMode");
    }
  });
});

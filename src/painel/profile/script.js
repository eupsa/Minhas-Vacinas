document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  sidebarToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    sidebar.classList.toggle("hide");
  });
});

function toggleDarkMode() {
  document.body.classList.toggle("dark-mode");
}

document.addEventListener("DOMContentLoaded", () => {
  const darkModeSwitch = document.getElementById("darkModeSwitch");

  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
    darkModeSwitch.checked = true;
  }

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
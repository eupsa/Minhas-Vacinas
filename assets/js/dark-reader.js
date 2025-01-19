document.addEventListener("DOMContentLoaded", function () {
  DarkReader.setFetchMethod(window.fetch);

  const darkModeSwitch = document.getElementById("darkModeSwitch");
  const sunIcon = document.getElementById("sunIcon");
  const moonIcon = document.getElementById("moonIcon");
  const themeToggle = document.getElementById("themeToggle");

  const checkDarkModePreference = () => {
    return localStorage.getItem("darkMode") === "enabled";
  };

  const toggleDarkMode = (isChecked = null) => {
    const enableDarkMode =
      isChecked !== null ? isChecked : darkModeSwitch.checked;

    if (enableDarkMode) {
      DarkReader.enable({
        brightness: 90,
        contrast: 110,
        sepia: 0,
      });
      document.body.classList.add("dark");
      sunIcon.style.display = "block";
      moonIcon.style.display = "none";
      localStorage.setItem("darkMode", "enabled");
    } else {
      DarkReader.disable();
      document.body.classList.remove("dark");
      sunIcon.style.display = "none";
      moonIcon.style.display = "block";
      localStorage.setItem("darkMode", "disabled");
    }
  };

  if (checkDarkModePreference()) {
    toggleDarkMode(true);
  }

  if (darkModeSwitch) {
    darkModeSwitch.checked = checkDarkModePreference();
    darkModeSwitch.addEventListener("change", function () {
      toggleDarkMode(darkModeSwitch.checked);
    });
  }

  if (themeToggle) {
    themeToggle.addEventListener("click", function () {
      const isCurrentlyDark = document.body.classList.contains("dark");

      if (isCurrentlyDark) {
        toggleDarkMode(false);
      } else {
        toggleDarkMode(true);
      }
    });
  }
});
